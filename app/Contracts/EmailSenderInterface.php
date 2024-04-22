<?php

namespace App\Contracts;

interface EmailSenderInterface
{
    public function sendEmail(string $to, string $subject, string $body);
}