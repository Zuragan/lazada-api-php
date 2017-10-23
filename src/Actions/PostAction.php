<?php
namespace Zuragan\Lazada\Actions;

class PostAction extends ActionBase
{
    private $payload;

    public function __construct(
        $userId,
        $apiKey,
        $version,
        $format,
        $action,
        $parameters,
        DateTime $timestamp = null,
        $payload = []
    ){
        parent::__construct(
            $userId,
            $apiKey,
            $version,
            $format,
            $action,
            $parameters,
            $timestamp
        );

        $this->payload = $payload;
    }

    public function getXMLPayload()
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Request/>');
        $this->recursiveArrayToXml($this->payload, $xml);
        return $xml->asXML();
    }

    private function recursiveArrayToXml($data, SimpleXMLElement &$xmlData)
    {
        foreach($data as $key => $value) {
            if(is_numeric($key)){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            if(is_array($value)) {
                $subnode = $xmlData->addChild($key);
                $this->recursiveArrayToXml($value, $subnode);
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}
