<?php
namespace Zuragan\Lazada;

use Zuragan\Lazada\Actions\ActionFactory;
use Zuragan\Lazada\Actions\GetAction;
use Zuragan\Lazada\Actions\PostAction;

class LazadaAPI
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    private function buildQuery($paramArray)
    {
        $queryString = http_build_query($paramArray,
            '', '&', PHP_QUERY_RFC3986);
        return $queryString;
    }

    private function buildURL($paramArray)
    {
        return $this->url . "?" . $this->buildQuery($paramArray);
    }

    public function get(GetAction $action)
    {
        return $this->curlGET(
            $action->getSignedParams(),
            $action->isJSON()
        );
    }

    public function post(PostAction $action)
    {
        return $this->curlPOST(
            $action->getSignedParams(),
            $action->getXMLPayload(),
            $action->isJSON()
        );
    }

    private function curlPOST($paramArray, $rawPayload, $isJSON = true)
    {
        $ch = curl_init();

        curl_setopt_array(
            $ch, [
                CURLOPT_POST => TRUE,
                CURLOPT_URL => $this->buildURL($paramArray),
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_POSTFIELDS => $rawPayload,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                ],
            ]
        );

        return $this->curlExec($ch, $isJSON);

    }

    private function curlGET($paramArray, $isJSON = true)
    {
        $ch = curl_init();

        curl_setopt_array(
            $ch, [
                CURLOPT_URL => $this->buildURL($paramArray),
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_RETURNTRANSFER => TRUE,
            ]
        );

        return $this->curlExec($ch, $isJSON);
    }

    private function curlExec($ch, $isJSON = true)
    {
        $data = curl_exec($ch);
        if ($isJSON) {
            $decodedResponse = json_decode($data);
        } else {
            $decodedResponse = simplexml_load_string($data);
        }

        curl_close($ch);
        return $decodedResponse;
    }
}
