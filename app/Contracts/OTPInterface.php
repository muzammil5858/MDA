<?php

namespace App\Contracts;

interface OTPInterface
{
    /**
     * Send an OTP to the recipient.
     *
     * @param  string  $recipient  The recipient's address (email or phone).
     * @param  string  $smsText  The SMS text to be sent.
     * @return bool True if SMS was sent successfully, false otherwise.
     */
    public function send(string $recipient,string $smsText): bool;
}
