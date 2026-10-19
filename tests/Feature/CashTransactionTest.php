<?php

namespace Tests\Feature;

use App\Models\CashTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CashTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_bendahara_can_create_a_cash_transaction_and_see_updated_totals(): void
    {
        $treasurer = User::factory()->create(['role' => 'bendahara']);
        $member = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($treasurer)
            ->post(route('bendahara.kas.store'), [
                'type' => 'masuk',
                'transaction_date' => '2026-10-19',
                'description' => 'Pembayaran kas Oktober',
                'amount' => 50000,
                'user_id' => $member->id,
                'notes' => 'Tunai',
            ])
            ->assertRedirect(route('bendahara.kas'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cash_transactions', [
            'type' => 'masuk',
            'description' => 'Pembayaran kas Oktober',
            'amount' => 50000,
            'user_id' => $member->id,
            'created_by' => $treasurer->id,
        ]);

        $this->get(route('bendahara.kas'))
            ->assertOk()
            ->assertSee('Rp50.000')
            ->assertSee('Pembayaran kas Oktober')
            ->assertSee($member->name);
    }

    public function test_bendahara_can_log_in_and_open_the_cash_page(): void
    {
        $password = 'bendahara-test-password';
        $treasurer = User::factory()->create([
            'role' => 'bendahara',
            'password' => $password,
        ]);

        $this->post(route('login.post'), [
            'email' => $treasurer->email,
            'password' => $password,
        ])->assertRedirect(route('bendahara.dashboard'));

        $this->get(route('bendahara.kas'))->assertOk();
    }

    public function test_bendahara_can_update_and_delete_a_cash_transaction(): void
    {
        $treasurer = User::factory()->create(['role' => 'bendahara']);
        $transaction = CashTransaction::create([
            'created_by' => $treasurer->id,
            'type' => 'masuk',
            'transaction_date' => '2026-10-01',
            'description' => 'Kas awal',
            'amount' => 10000,
        ]);

        $this->actingAs($treasurer)
            ->put(route('bendahara.kas.update', $transaction), [
                'type' => 'keluar',
                'transaction_date' => '2026-10-02',
                'description' => 'Koreksi transaksi',
                'amount' => 7000,
                'notes' => 'Input sebelumnya keliru',
            ])
            ->assertRedirect(route('bendahara.kas'));

        $this->assertDatabaseHas('cash_transactions', [
            'id' => $transaction->id,
            'type' => 'keluar',
            'description' => 'Koreksi transaksi',
            'amount' => 7000,
        ]);

        $this->delete(route('bendahara.kas.destroy', $transaction))
            ->assertRedirect(route('bendahara.kas'));

        $this->assertDatabaseMissing('cash_transactions', ['id' => $transaction->id]);
    }

    public function test_cash_transaction_api_supports_authenticated_json_crud(): void
    {
        $treasurer = User::factory()->create(['role' => 'adkeu']);
        $this->actingAs($treasurer);

        $createResponse = $this->postJson(route('api.bendahara.transaksi-kas.store'), [
            'type' => 'masuk',
            'transaction_date' => '2026-10-19',
            'description' => 'Iuran kas anggota',
            'amount' => 50000,
        ])->assertCreated()
            ->assertJsonPath('data.created_by', $treasurer->id);

        $transactionId = $createResponse->json('data.id');

        $this->getJson(route('api.bendahara.transaksi-kas.index'))
            ->assertOk()
            ->assertJsonPath('data.0.description', 'Iuran kas anggota');

        $this->putJson(route('api.bendahara.transaksi-kas.update', $transactionId), [
            'type' => 'masuk',
            'transaction_date' => '2026-10-19',
            'description' => 'Iuran kas terkonfirmasi',
            'amount' => 50000,
        ])->assertOk()
            ->assertJsonPath('data.description', 'Iuran kas terkonfirmasi');

        $this->deleteJson(route('api.bendahara.transaksi-kas.destroy', $transactionId))
            ->assertOk();

        $this->assertDatabaseMissing('cash_transactions', ['id' => $transactionId]);
    }

    public function test_non_treasurer_cannot_manage_cash_transactions(): void
    {
        $member = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($member)
            ->post(route('bendahara.kas.store'), [
                'type' => 'masuk',
                'transaction_date' => '2026-10-19',
                'description' => 'Tidak boleh',
                'amount' => 50000,
            ])
            ->assertRedirect(route('anggota.dashboard'));

        $this->assertDatabaseCount('cash_transactions', 0);
    }

    public function test_transaction_validation_rejects_non_positive_amounts(): void
    {
        $treasurer = User::factory()->create(['role' => 'bendahara']);

        $this->actingAs($treasurer)
            ->from(route('bendahara.kas'))
            ->post(route('bendahara.kas.store'), [
                'type' => 'masuk',
                'transaction_date' => '2026-10-19',
                'description' => 'Nominal tidak valid',
                'amount' => 0,
            ])
            ->assertRedirect(route('bendahara.kas'))
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseCount('cash_transactions', 0);
    }
}
