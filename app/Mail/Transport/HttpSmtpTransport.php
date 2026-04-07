<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class HttpSmtpTransport extends AbstractTransport
{
    private string $endpoint;
    private string $secret;

    public function __construct(string $endpoint, string $secret)
    {
        parent::__construct();
        $this->endpoint = $endpoint;
        $this->secret = $secret;
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $to = collect($email->getTo())->map(fn($a) => $a->getAddress())->implode(',');
        $from = $email->getFrom()[0] ?? null;

        $response = Http::withHeaders([
            'X-Email-Secret' => $this->secret,
        ])->post($this->endpoint, [
            'to' => $to,
            'subject' => $email->getSubject(),
            'html' => $email->getHtmlBody(),
            'from_address' => $from?->getAddress(),
            'from_name' => $from?->getName(),
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('HTTP SMTP proxy failed: ' . $response->body());
        }
    }

    public function __toString(): string
    {
        return 'httpsmtp';
    }
}
