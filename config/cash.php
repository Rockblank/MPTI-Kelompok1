<?php

return [
    'deadline_day' => (int) env('CASH_PAYMENT_DEADLINE_DAY', 1),
    'late_fee_per_day' => (int) env('CASH_PAYMENT_LATE_FEE_PER_DAY', 1000),
    'reminder_interval_days' => 7,
    'proof_disk' => env('CASH_PAYMENT_PROOF_DISK', 'local'),
];
