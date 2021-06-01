<?php

namespace App\infrastructure;

use App\core\GreetingMessage;
use App\core\GreetingsSender;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class EmailGreetingsSender implements GreetingsSender
{
    private $smtpHost;
    private $smtpPort;
    private $sender;

    public function __construct(string $smtpHost, int $smtpPort, string $sender)
    {
        $this->smtpHost = $smtpHost;
        $this->smtpPort = $smtpPort;
        $this->sender = $sender;
    }

    public function send(array $messages)
    {
        /** @var GreetingMessage $message */
        foreach($messages as $message) {
            $recipient = $message->getTo();
            $body = $message->getText();
            $subject = $message->getSubject();
            $this->trySendMessage($subject, $body, $recipient);
        }
    }

    private function trySendMessage(
        string $subject, string $body, string $recipient
    ): void {
        // Create a mailer
        $mailer = new Swift_Mailer(
            new Swift_SmtpTransport($this->smtpHost, $this->smtpPort)
        );
        // Connstruct the message
        $msg = new Swift_Message($subject);
        $msg->setFrom($this->sender)
            ->setTo([$recipient])
            ->setBody($body);

        // Send the message

        $this->sendMessage($msg, $mailer);
    }

    protected function sendMessage(Swift_Message $msg, Swift_Mailer $mailer)
    {
        $mailer->send($msg);
    }
}
