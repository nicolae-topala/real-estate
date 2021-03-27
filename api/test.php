<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.eu.mailgun.org', 587))
  ->setUsername('postmaster@real-estate.studio')
  ->setPassword('db1206523b45964b615aee10438d534a-1553bd45-60117c67')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['no-reply@real-estate.studio' => 'No-Reply'])
  ->setTo(['proawp5415@gmail.com'])
  ->setBody('Here is the message itself')
  ;

// Send the message
$result = $mailer->send($message);

print_r($result);
