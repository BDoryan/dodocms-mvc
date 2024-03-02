<?php

class Mailer
{

    private string $sender_name;
    private string $host;
    private string $port;
    private string $secure;
    private string $user;
    private string $password;

    private string $from;

    private \PHPMailer\PHPMailer\PHPMailer $mailer;

    /**
     * @param string $host smtp server
     * @param string $port smtp port
     * @param string $secure tls or ssl
     * @param string $user smtp user
     * @param string $password smtp password
     * @param string $from from email
     */
    public function __construct(string $host, string $port, string $secure, string $user, string $password, string $from, string $sender_name)
    {
        $this->from = $from;
        $this->host = $host;
        $this->port = $port;
        $this->secure = $secure;
        $this->user = $user;
        $this->password = $password;
        $this->sender_name = $sender_name;
    }

    /**
     * You can send a message with this method
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMessage(string $to, string $subject, $message)
    {
        $this->send($to, $subject, $message);
    }

    /**
     * This method you can send a template and replace the data
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendTemplate(string $to, string $subject, $template, array $data)
    {
        // Load txt and html files from template
        $txt = file_get_contents($template . '.txt');
        $html = file_get_contents($template . '.html');

        // Replace data in txt and html files
        foreach ($data as $key => $value) {
            $txt = str_replace('%' . $key . '%', $value, $txt);
            $html = str_replace('%' . $key . '%', $value, $html);
        }

        $this->send($to, $subject, $txt, $html);
    }

    /**
     * This method you can send a message with html and text
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send(string $to, string $subject, $message, $html = '')
    {

        $this->mailer = new \PHPMailer\PHPMailer\PHPMailer();
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->Encoding = 'base64';
        $this->mailer->isSMTP();

        $this->mailer->Host = $this->host;
        $this->mailer->Port = $this->port;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->user;
        $this->mailer->Password = $this->password;
        $this->mailer->SMTPSecure = $this->secure;

        $this->mailer->setFrom($this->from, $this->sender_name);
        $this->mailer->addAddress($to);
        $this->mailer->addReplyTo($this->from, $this->sender_name);
        $this->mailer->Subject = $subject;

//        dd($this->mailer);

        if (!empty($html)) {
            $this->mailer->isHTML();
            $this->mailer->Body = $html;
            $this->mailer->AltBody = $message;
        } else {
            $this->mailer->Body = $message;
        }
        if (!$this->mailer->send())
            throw new \PHPMailer\PHPMailer\Exception($this->mailer->ErrorInfo);
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->sender_name;
    }

    /**
     * Return from the mail is sent
     *
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }
}