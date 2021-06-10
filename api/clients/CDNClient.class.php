<?php
require_once dirname(__FILE__).'/../config.php';
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use Aws\S3\S3Client;

/**
 * The client class to interact with Digital Ocean Spaces CDN
 *
 */
class CDNClient {

    private $client;

    /**
     * Estabilish connection from CDN Server with specific settings
     */
    public function __construct() {
        $this->client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => Config::CDN_REGION(),
            'endpoint' => Config::CDN_BASE_URL(),
            'credentials' => [
                'key' => Config::CDN_KEY(),
                'secret' => Config::CDN_SECRET()
            ]
        ]);
    }

    /**
    *  Upload file to CDN and return the public URL back.
    *  @param string $filename - name of file on CDN
    *  @param string $content - base64 encode file content
     */
    public function upload($filename, $content) {
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
     * @param  string $filename filename to delete, ending with .png
     */
    public function delete($filename) {
        $response = $this->client->deleteObject([
            'Bucket' => Config::CDN_SPACE(),
            'Key' => $filename
        ]);

        return $response;
    }

}
