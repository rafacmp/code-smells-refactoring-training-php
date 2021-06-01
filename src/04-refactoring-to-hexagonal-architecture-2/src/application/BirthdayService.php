<?php

declare(strict_types=1);


namespace App\application;


use App\core\EmployeeRepository;
use App\core\GreetingMessage;
use App\core\OurDate;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class BirthdayService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function sendGreetings(
        OurDate $date,
        string $smtpHost,
        int $smtpPort,
        string $sender
    ): void {

        $this->send($this->greetingMessagesFor($this->employeesHavingBirthday($date)),
                    $smtpHost, $smtpPort, $sender);
    }

    private function greetingMessagesFor(array $employees): array
    {
        return GreetingMessage::generateForSome($employees);
    }

    private function employeesHavingBirthday($today): array
    {
        return $this->employeeRepository->employeesWhoseBirthdayIs($today);
    }

    private function send(array $messages, string $smtpHost, int $smtpPort, string $sender)
    {
        /** @var GreetingMessage $message */
        foreach($messages as $message) {
            $recipient = $message->getTo();
            $body = $message->getText();
            $subject = $message->getSubject();
            $this->trySendMessage($smtpHost, $smtpPort, $sender, $subject, $body, $recipient);
        }
    }

    private function trySendMessage(
        string $smtpHost,
        int $smtpPort,
        string $sender,
        string $subject,
        string $body,
        string $recipient
    ): void {
        // Create a mailer
        $mailer = new Swift_Mailer(
            new Swift_SmtpTransport($smtpHost, $smtpPort)
        );
        // Connstruct the message
        $msg = new Swift_Message($subject);
        $msg->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body);

        // Send the message
        $this->sendMessage($msg, $mailer);
    }

    //made protected for testing :-(
    protected function sendMessage(Swift_Message $msg, Swift_Mailer $mailer)
    {
        $mailer->send($msg);
    }

}