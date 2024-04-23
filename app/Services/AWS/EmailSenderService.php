<?php

namespace App\Services\AWS;

use App\Contracts\EmailSenderInterface;
use Aws\Ses\SesClient;

class EmailSenderService implements EmailSenderInterface
{
    private string $sender;
    private string $charSet;
    private string $profile;
    private string $region;

    public function __construct() {
        $this->sender = 'fitmotive.pi@gmail.com';
        $this->charSet = 'UTF-8';
        $this->profile = 'default';
        $this->region = 'us-east-1';
    }

    public function sendEmail(string $to, string $subject, string $body) {
        $client = $this->createSesClient();
        $requestArgs = $this->makeRequestArgs($to, $subject, $body);
        $result = $client->sendEmail($requestArgs);

        return $result['MessageId'];
    }

    private function makeRequestArgs(string $to, string $subject, string $body): array {
        return [
            'Destination' => [
                'ToAddresses' => [$to]
            ],
            'ReplyToAddresses' => [$this->sender],
            'Source' => $this->sender,
            'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => $this->charSet,
                        'Data' => $body
                    ],
                    'Text' => [
                        'Charset' => $this->charSet,
                        'Data' => $body
                    ]
                ],
                'Subject' => [
                    'Charset' => $this->charSet,
                    'Data' => $subject
                ]
            ]
        ];
    }

    private function createSesClient(): SesClient {
        return new SesClient([
            'region' => $this->region,
            'profile' => $this->profile,
        ]);
    }
}