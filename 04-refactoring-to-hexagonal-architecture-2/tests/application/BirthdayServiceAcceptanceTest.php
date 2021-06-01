<?php

declare(strict_types=1);

use App\application\BirthdayService;
use App\infrastructure\EmailGreetingsSender;
use App\infrastructure\repositories\FileEmployeesRepository;
use helpers\OurDateFactory;
use PHPUnit\Framework\TestCase;

class BirthdayServiceAcceptanceTest extends TestCase
{
    private const SMTP_HOST = '127.0.0.1';
    private const SMTP_PORT = 25;
    private const FROM = 'sender@here.com';
    private BirthdayService $service;
    private const EMPLOYEES_FILE_PATH = "/../resources/employee_data.txt";
    private $emailGreetingSender;

    protected function setUp(): void
    {
        $employeesFilePath = dirname(__FILE__) . self::EMPLOYEES_FILE_PATH;
        $this->emailGreetingSender = new class([], self::SMTP_HOST, self::SMTP_PORT, self::FROM) extends EmailGreetingsSender {

            public $messagesSent;

            public function __construct($messagesSent, string $smtpHost, int $smtpPort, string $sender)
            {
                parent::__construct($smtpHost, $smtpPort, $sender);
                $this->messagesSent = $messagesSent;
            }

            public function sendMessage(Swift_Message $msg, Swift_Mailer $mailer)
            {
                $this->messagesSent[] = $msg;
            }

        };

        $this->service = new BirthdayService(new FileEmployeesRepository($employeesFilePath), $this->emailGreetingSender);
    }

    public function testBaseScenario(): void
    {
        $today = OurDateFactory::ourDateFromString("2008/10/08");

        $this->service->sendGreetings($today);

        $this->assertEquals(1, count($this->emailGreetingSender->messagesSent), "message not sent?");
        /* @var Swift_Message $message */
        $message = $this->emailGreetingSender->messagesSent[0];
        $this->assertEquals("Happy Birthday, dear John!", $message->getBody());
        $this->assertEquals("Happy Birthday!", $message->getSubject());
        $this->assertEquals(1, count($message->getTo()));
        $this->assertEquals("john.doe@foobar.com", key($message->getTo()));
    }

    public function testWillNotSendEmailsWhenNobodysBirthday(): void
    {
        $today = OurDateFactory::ourDateFromString('2008/01/01');

        $this->service->sendGreetings(
            $today
        );

        $this->assertEquals(0, count($this->emailGreetingSender->messagesSent), 'what? messages?');
    }
}
