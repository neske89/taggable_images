<?php


namespace App\Service;


class DownloadImageService extends ImageService
{

    /**
     * DownloadImageService constructor.
     */
    public function __construct(private string $source)
    {
        parent::__construct();
    }

    private function imageContent(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->source);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;                     // closing curl handle
    }


    public function saveToFile($path): void
    {
       $content = $this->imageContent();
        $fp = fopen($path, 'wb');
        fwrite($fp, $content);
        fclose($fp);
    }


}