<?php

require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';

class SMTPClient{

    private $mailer;

    public function __construct(){
        $transport = (new Swift_SmtpTransport(Config::SMTP_HOST."c0c38ab71-1553bd45-5c6cd9ef", Config::SMTP_PORT))
          ->setUsername(Config::SMTP_USER)
          ->setPassword(Config::SMTP_PASS);

        $this->mailer = new Swift_Mailer($transport);
    }

    public function send_register_user_token($user){
      $message = (new Swift_Message('[Real-Estate] Register User Confirmation'))
        ->setFrom(['no-reply@real-estate.studio' => 'No-Reply'])
        ->setTo([$user['email']])
        ->setBody('Here is the confirmation link: http://localhost/real-estate/api/users/confirm/'.$user['token']);

      $this->mailer->send($message);
    }

}
