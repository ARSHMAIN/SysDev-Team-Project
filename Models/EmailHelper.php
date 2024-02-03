<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'Libraries/PHPMailer/PHPMailer-master/src/Exception.php';
require 'Libraries/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'Libraries/PHPMailer/PHPMailer-master/src/SMTP.php';
class EmailHelper {
    private PHPMailer $phpMailer;

    public function __construct(bool $exceptions) {
        $this->phpMailer = new PHPMailer($exceptions);
        $this->phpMailer = self::configurePhpMailer($this->phpMailer);
    }

    public function SMTPDebug(int $debugServerLevel): EmailHelper
    {
        $this->phpMailer->SMTPDebug = $debugServerLevel;
        return $this;
    }

    public function isHTML(bool $isHTML): EmailHelper
    {
        $this->phpMailer->isHTML($isHTML);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function setFrom(string $fromAddress, string $fromName, bool $auto = true): EmailHelper
    {
        $this->phpMailer->setFrom($fromAddress, $fromName, $auto);
        return $this;
    }

    /**
     * @throws Exception
     */
    public function addAddress(string $sendToAddress): static
    {
        $this->phpMailer->addAddress($sendToAddress);
        return $this;
    }

    public function subject(string $mailSubject): EmailHelper
    {
        $this->phpMailer->Subject = $mailSubject;
        return $this;
    }

    public function body(string $bodyMessage): EmailHelper
    {
        $this->phpMailer->Body = $bodyMessage;
        return $this;
    }

    public function clearAllRecipients() : EmailHelper {
        $this->phpMailer->clearAllRecipients();
        return $this;
    }

    /**
     * @throws Exception
     */
    public function send(): EmailHelper
    {
        $this->phpMailer->send();
        return $this;
    }
    private static function configurePhpMailer(PHPMailer $phpMailer) : PHPMailer {
        $phpMailer->isSMTP();
        $phpMailer->SMTPAuth = true;
        $phpMailer->Host = "smtp.gmail.com";
        $phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpMailer->Username = "snakegenotypetesting@gmail.com";
        $phpMailer->Password = "uzttrkfwhxwdbhmd";
        $phpMailer->Port = 587;
        return $phpMailer;
    }
}