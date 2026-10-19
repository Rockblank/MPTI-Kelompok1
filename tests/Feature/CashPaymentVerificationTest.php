<?php

namespace Tests\Feature;

use App\Models\CashPayment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CashPaymentVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Storage::fake('local');
    }

    public function test_member_can_submit_a_transfer_proof_for_monthly_dues(): void
    {
        $member = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($member)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->post(route('anggota.bayar-kas.submit'), [
                'period' => now()->format('Y-m'),
                'proof' => UploadedFile::fake()->create('transfer.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('anggota.bayar-kas'))
            ->assertSessionHas('success');

        $payment = CashPayment::firstOrFail();
        $this->assertSame($member->id, $payment->user_id);
        $this->assertSame(CashPayment::AMOUNT, $payment->amount);
        $this->assertSame(CashPayment::STATUS_PENDING, $payment->status);
        Storage::disk('local')->assertExists($payment->proof_path);
    }

    public function test_bendahara_can_approve_payment_and_it_is_recorded_as_cash_income(): void
    {
        $member = User::factory()->create(['role' => 'anggota']);
        $treasurer = User::factory()->create(['role' => 'bendahara']);
        $proofPath = UploadedFile::fake()->create('transfer.pdf', 100, 'application/pdf')
            ->store('cash-payment-proofs', 'local');
        $payment = CashPayment::create([
            'user_id' => $member->id,
            'period' => now()->startOfMonth(),
            'amount' => CashPayment::AMOUNT,
            'proof_path' => $proofPath,
            'status' => CashPayment::STATUS_PENDING,
        ]);

        $this->actingAs($treasurer)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->post(route('bendahara.validasi-pembayaran.approve', $payment))
            ->assertRedirect(route('bendahara.validasi-pembayaran'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cash_payments', [
            'id' => $payment->id,
            'status' => CashPayment::STATUS_APPROVED,
            'reviewed_by' => $treasurer->id,
        ]);
        $this->assertDatabaseHas('cash_transactions', [
            'user_id' => $member->id,
            'created_by' => $treasurer->id,
            'type' => 'masuk',
            'amount' => CashPayment::AMOUNT,
        ]);
        $this->assertDatabaseCount('cash_transactions', 1);
    }

    public function test_bendahara_can_reject_payment_and_member_can_resubmit_proof(): void
    {
        $member = User::factory()->create(['role' => 'anggota']);
        $treasurer = User::factory()->create(['role' => 'adkeu']);
        $firstProof = UploadedFile::fake()->create('first.pdf', 100, 'application/pdf')
            ->store('cash-payment-proofs', 'local');
        $payment = CashPayment::create([
            'user_id' => $member->id,
            'period' => now()->startOfMonth(),
            'amount' => CashPayment::AMOUNT,
            'proof_path' => $firstProof,
            'status' => CashPayment::STATUS_PENDING,
        ]);

        $this->actingAs($treasurer)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->post(route('bendahara.validasi-pembayaran.reject', $payment), [
                'rejection_reason' => 'Bukti transfer tidak terbaca.',
            ])
            ->assertRedirect(route('bendahara.validasi-pembayaran'));

        $this->assertDatabaseHas('cash_payments', [
            'id' => $payment->id,
            'status' => CashPayment::STATUS_REJECTED,
            'rejection_reason' => 'Bukti transfer tidak terbaca.',
        ]);
        $this->assertDatabaseCount('cash_transactions', 0);

        $this->actingAs($member)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->post(route('anggota.bayar-kas.submit'), [
                'period' => now()->format('Y-m'),
                'proof' => UploadedFile::fake()->create('replacement.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('anggota.bayar-kas'));

        $this->assertDatabaseHas('cash_payments', [
            'id' => $payment->id,
            'status' => CashPayment::STATUS_PENDING,
            'rejection_reason' => null,
        ]);
        Storage::disk('local')->assertMissing($firstProof);
    }

    public function test_payment_submission_rejects_invalid_files_and_duplicate_pending_requests(): void
    {
        $member = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($member)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->from(route('anggota.bayar-kas'))
            ->post(route('anggota.bayar-kas.submit'), [
                'period' => now()->format('Y-m'),
                'proof' => UploadedFile::fake()->create('malware.exe', 100, 'application/x-msdownload'),
            ])
            ->assertRedirect(route('anggota.bayar-kas'))
            ->assertSessionHasErrors('proof');

        $proofPath = UploadedFile::fake()->create('transfer.pdf', 100, 'application/pdf')
            ->store('cash-payment-proofs', 'local');
        CashPayment::create([
            'user_id' => $member->id,
            'period' => now()->startOfMonth(),
            'amount' => CashPayment::AMOUNT,
            'proof_path' => $proofPath,
            'status' => CashPayment::STATUS_PENDING,
        ]);

        $this->post(route('anggota.bayar-kas.submit'), [
            'period' => now()->format('Y-m'),
            'proof' => UploadedFile::fake()->create('another.pdf', 100, 'application/pdf'),
        ])->assertSessionHasErrors('period');
    }

    public function test_only_cash_team_can_view_uploaded_evidence_and_review_payments(): void
    {
        $member = User::factory()->create(['role' => 'anggota']);
        $treasurer = User::factory()->create(['role' => 'bendahara']);
        $proofPath = UploadedFile::fake()->create('transfer.pdf', 100, 'application/pdf')
            ->store('cash-payment-proofs', 'local');
        $payment = CashPayment::create([
            'user_id' => $member->id,
            'period' => now()->startOfMonth(),
            'amount' => CashPayment::AMOUNT,
            'proof_path' => $proofPath,
            'status' => CashPayment::STATUS_PENDING,
        ]);

        $this->actingAs($member)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->get(route('bendahara.validasi-pembayaran.evidence', $payment))
            ->assertRedirect(route('anggota.dashboard'));

        $this->actingAs($treasurer)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->get(route('bendahara.validasi-pembayaran.evidence', $payment))
            ->assertOk();
    }
}
