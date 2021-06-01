<?php

declare(strict_types=1);


namespace App;


use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class BirthdayService
{
    private FileEmployeeRepository $employeeRepository;

    public function __construct()
    {
        $this->employeeRepository = new FileEmployeeRepository();
    }

    // extract get clients from CSV
    // iterate and check for birthdays
    // send an email
    public function sendGreetings(
        string $fileName,
        OurDate $ourDate,
        string $smtpHost,
        int $smtpPort
    ): void {
        $employees = $this->employeeRepository->getEmployees($fileName);

        $birthdayEmployees = $this->birthdayEmployees($employees, $ourDate);

        $greetings = $this->getGreetings($birthdayEmployees);

        $this->sendGreetingsToEmployees($greetings, $smtpHost, $smtpPort);
    }

    // This method should not be here
    // The method should not know about the implementation
    protected function sendMessage(
        string $smtpHost,
        int $smtpPort,
        string $sender,
        string $subject,
        string $body,
        string $recipient
    ): void {
        $mailer = new Swift_Mailer(
            new Swift_SmtpTransport($smtpHost, $smtpPort)
        );
        $msg = new Swift_Message($subject);
        $msg->setFrom($sender)
            ->setTo([$recipient])
            ->setBody($body);


        $this->send($msg, $mailer);
    }

    protected function send(Swift_Message $msg, Swift_Mailer $mailer)
    {
        $mailer->send($msg);
    }

    /**
     * @param array $employees
     * @param OurDate $ourDate
     * @return array
     */
    public function birthdayEmployees(array $employees, OurDate $ourDate): array
    {
        $employeesWhoseBirthdayIsOurDate = [];
        foreach ($employees as $employee) {
            if ($employee->isBirthday($ourDate)) {
                $employeesWhoseBirthdayIsOurDate[] = $employee;
            }
        }
        return $employeesWhoseBirthdayIsOurDate;
    }

    /**
     * @param array $greetings
     * @param string $smtpHost
     * @param int $smtpPort
     */
    public function sendGreetingsToEmployees(array $greetings, string $smtpHost, int $smtpPort): void
    {
        foreach ($greetings as $greeting) {
            $this->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $greeting['subject'], $greeting['body'], $greeting['recipient']);
        }
    }

    /**
     * @param array $employeesWhoseBirthdayIsOurDate
     * @return array
     */
    public function getGreetings(array $employeesWhoseBirthdayIsOurDate): array
    {
        $greetings = [];
        foreach ($employeesWhoseBirthdayIsOurDate as $employeeWhoseBirthdayIsOurDate) {
            $greetings[] = [
                'recipient' => $employeeWhoseBirthdayIsOurDate->getEmail(),
                'body' => sprintf('Happy Birthday, dear %s!', $employeeWhoseBirthdayIsOurDate->getFirstName()),
                'subject' => 'Happy Birthday!'
            ];
        }
        return $greetings;
    }

}