<?php

class Mailer
{

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
    public function __construct(string $host, string $port, string $secure, string $user, string $password, string $from)
    {
        $this->from = $from;

        $this->mailer = new \PHPMailer\PHPMailer\PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $user;
        $this->mailer->Password = $password;
        $this->mailer->SMTPSecure = $secure;
        $this->mailer->Port = $port;
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
        $txt = file_get_contents(Application::get()->toRoot($template . '.txt'));
        $html = file_get_contents(Application::get()->toRoot($template . '.html'));

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
        $this->mailer->setFrom($this->from);
        $this->mailer->addAddress($to);
        $this->mailer->Subject = $subject;
        if (!empty($html)) {
            $this->mailer->isHTML(true);
            $this->mailer->Body = $html;
            $this->mailer->AltBody = $message;
        } else {
            $this->mailer->Body = $message;
        }
        $this->mailer->send();
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