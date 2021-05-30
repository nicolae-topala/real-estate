<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/api/clients/CDNClient.class.php';
/*
use Aws\S3\S3Client;

$client = new Aws\S3\S3Client([
    'version' => 'latest',
    'region' => 'fra1',
    'endpoint' => 'https://fra1.digitaloceanspaces.com',
    'credentials' => [
        'key' => "F5A3CXUKXVYXCRNBZ2ZX",
        'secret' => "+xkJKwb1KwJGkMqJBOEDPUoH2v2z8qBheQ/5D7XQ6fA",
    ],
]);
*/
$image_content = file_get_contents('C:\Users\Nick-PC\Desktop\custom.png');


$client = new CDNClient();

$url = $client->upload("firstTry.png", base64_encode($image_content));

print_r($url);

//echo '<img src="data:image/png; base64, '.base64_encode($image_content).'"/>';
