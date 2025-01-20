<?php

namespace App\Presentation\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class DiscountCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly string $discountCode
    )
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this
            ->subject('Your Exclusive Discount Code!')
            ->markdown('emails.discount-code', [
                'discountCode' => $this->discountCode
            ]);
    }
}
