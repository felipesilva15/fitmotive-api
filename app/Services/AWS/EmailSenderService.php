<?php

namespace App\Services\AWS;

use App\Contracts\EmailSenderInterface;
use Aws\Ses\SesClient;

class EmailSenderService implements EmailSenderInterface
{
    private string $sender;
    private string $configrationSet;
    private string $charSet;
    private string $profile;
    private string $version;
    private string $region;

    public function __construct() {
        $this->sender = 'felipe.allware@gmail.com';
        $this->configrationSet = 'ConfigSet';
        $this->charSet = 'UTF-8';
        $this->profile = 'default';
        $this->version = '2010-12-01';
        $this->region = 'us-west-1';
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
            'Source',
            'Message' => [
                'Body' => [
                    'HTML' => [
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
            ],
            'ConfigurationSetName' => $this->configrationSet
        ];
    }

    private function createSesClient(): SesClient {
        return new SesClient([
            'region' => $this->region,
            'profile' => $this->profile,
            'version' => $this->version,
            'credentials' => [
                'key' => '',
                'secret' => ''
            ]
        ]);
    }
}