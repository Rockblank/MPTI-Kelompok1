<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashPayment extends Model
{
    public const AMOUNT = 50000;

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'period',
        'amount',
        'late_fee_amount',
        'proof_path',
        'submitted_at',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'period' => 'date',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'amount' => 'integer',
            'late_fee_amount' => 'integer',
        ];
    }

    public static function deadlineFor(Carbon $period): Carbon
    {
        $day = min(28, max(1, (int) config('cash.deadline_day', 1)));

        return $period->copy()
            ->startOfMonth()
            ->day(min($day, $period->daysInMonth))
            ->endOfDay();
    }

    public static function lateDaysFor(Carbon $period, Carbon $date): int
    {
        $deadline = self::deadlineFor($period);
        $date = $date->copy();

        if ($date->lessThanOrEqualTo($deadline)) {
            return 0;
        }

        return (int) $deadline->startOfDay()->diffInDays($date->startOfDay());
    }

    public static function lateMonthsFor(Carbon $period, Carbon $date): int
    {
        $deadline = self::deadlineFor($period);
        $date = $date->copy();

        if ($date->lessThanOrEqualTo($deadline)) {
            return 0;
        }

        $latePeriodStart = $deadline->startOfDay()->addDay();
        $months = 1;

        while ($date->greaterThanOrEqualTo($latePeriodStart->copy()->addMonthNoOverflow())) {
            $latePeriodStart->addMonthNoOverflow();
            $months++;
        }

        return $months;
    }

    public static function lateFeeFor(Carbon $period, Carbon $date): int
    {
        return self::lateMonthsFor($period, $date) * (int) config('cash.late_fee_per_month', 10000);
    }

    /**
     * @return array{period: ?Carbon, late_days: int, late_months: int, fee_amount: int}
     */
    public static function accountLateFeeSummaryFor(int $userId, Carbon $date): array
    {
        $payments = self::query()
            ->where('user_id', $userId)
            ->whereBetween('period', [
                $date->copy()->startOfYear()->toDateString(),
                $date->copy()->startOfMonth()->endOfMonth()->toDateString(),
            ])
            ->get()
            ->keyBy(fn (self $payment): string => $payment->period->format('Y-m'));

        $oldestUnpaidPeriod = null;

        foreach (CarbonPeriod::create($date->copy()->startOfYear(), '1 month', $date->copy()->startOfMonth()) as $period) {
            $payment = $payments->get($period->format('Y-m'));

            if (in_array($payment?->status, [self::STATUS_APPROVED, self::STATUS_PENDING], true)
                || $date->lessThanOrEqualTo(self::deadlineFor($period))) {
                continue;
            }

            $oldestUnpaidPeriod = $period->copy();
            break;
        }

        if (! $oldestUnpaidPeriod) {
            return [
                'period' => null,
                'late_days' => 0,
                'late_months' => 0,
                'fee_amount' => 0,
            ];
        }

        $lateMonths = self::lateMonthsFor($oldestUnpaidPeriod, $date);
        $lastApprovedPeriod = $payments
            ->filter(fn (self $payment): bool => $payment->period->lessThan($oldestUnpaidPeriod)
                && $payment->status === self::STATUS_APPROVED)
            ->max('period');
        $alreadyCharged = $payments
            ->filter(fn (self $payment): bool => in_array($payment->status, [self::STATUS_APPROVED, self::STATUS_PENDING], true)
                && ($payment->period->greaterThanOrEqualTo($oldestUnpaidPeriod)
                    || ($payment->status === self::STATUS_PENDING
                        && (! $lastApprovedPeriod || $payment->period->greaterThan($lastApprovedPeriod)))))
            ->sum('late_fee_amount');

        return [
            'period' => $oldestUnpaidPeriod,
            'late_days' => self::lateDaysFor($oldestUnpaidPeriod, $date),
            'late_months' => $lateMonths,
            'fee_amount' => max(
                0,
                $lateMonths * (int) config('cash.late_fee_per_month', 10000) - (int) $alreadyCharged
            ),
        ];
    }

    public function submissionDate(): Carbon
    {
        return $this->submitted_at ?? $this->created_at;
    }

    public function isLate(): bool
    {
        return $this->submissionDate()->greaterThan(self::deadlineFor($this->period));
    }

    public function isOverdue(): bool
    {
        if (in_array($this->status, [self::STATUS_APPROVED, self::STATUS_PENDING], true)) {
            return $this->isLate();
        }

        return now()->greaterThan(self::deadlineFor($this->period));
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
