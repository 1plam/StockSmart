<?php

namespace App\Presentation\Jobs;

use App\Presentation\Mail\DiscountCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

final class SendDiscountCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $userId
    )
    {
    }

    public function handle(): void
    {
        $discountCode = strtoupper(Str::random(8));

        // Simplified storage of a discount code, I'd rather use a dedicated service here
        DB::table('discount_codes')->insert([
            'id' => Str::uuid()->toString(),
            'code' => $discountCode,
            'amount' => 5.00,
            'user_id' => $this->userId,
            'expires_at' => now()->addMonths(),
        ]);

        // Send email, but due to simplification just output it to CLI.
        // Mail::to($this->userEmail)->send(new DiscountCodeMail($discountCode));
        error_log("Your €5 code is: " . $discountCode);
    }
}
