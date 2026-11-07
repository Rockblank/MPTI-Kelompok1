<?php

namespace App\Models;

use Carbon\Carbon;
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
