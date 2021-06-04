<?php
require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use Aws\S3\S3Client;

class CDNClient{
    public function __construct(){
        $this->client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => Config::CDN_REGION(),
            'endpoint' => Config::CDN_BASE_URL(),
            'credentials' => [
                'key' => Config::CDN_KEY(),
                'secret' => Config::CDN_SECRET()
            ],
        ]);
    }

    /**
    * Upload file to CDN and return the public URL
    * @param  $filename name of the file on CDN
    * @param  $cotent base64 encode file content
    */
    public function upload($filename, $content){
        $response = $this->client->putObject([
            'Bucket' => Config::CDN_SPACE(),
            'Key' => $filename,
            'Body' => base64_decode($content),
            'ACL' => 'public-read'
        ]);

        return $response->get("ObjectURL");
    }

    /**
    * Delete file from CDN
    * @param  $filename name of the file on CDN
    */
    public function delete($filename){
        $response = $this->client->deleteObject([
            'Bucket' => Config::CDN_SPACE(),
            'Key' => $filename
        ]);

        return $response;
    }
}
