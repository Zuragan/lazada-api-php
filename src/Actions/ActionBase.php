<?php

namespace Zuragan\Lazada\Actions;

abstract class ActionBase
{
    protected $userId;
    protected $version;
    protected $format;
    protected $action;
    protected $parameters;
    protected $signature;

    public function __construct(
        $userId,
        $version,
        $format,
        $action,
        $parameters,
        $timestamp = null
    ){
        $this->userId = $userId;
        $this->version = $version;
        $this->format = strtoupper($format);
        $this->action = $action;
        $this->parameters = $parameters;
        $this->setTimestamp($timestamp);
    }

    public function setTimestamp($timestamp)
    {
        if (is_null($timestamp)) {
            $timestamp = new \DateTime();
        }
        $this->timestamp = $timestamp;
    }

    private function getUnsignedParams()
    {
        $unsigned = $this->getParamArray();
        ksort($unsigned);
        return $unsigned;
    }

    private function getParamArray()
    {
        $mainParams = [
            'UserID' => $this->userId,
            'Version' => $this->version,
            'Format' => $this->format,
            'Action' => $this->action,
            'Timestamp' => $this->timestamp->format(\DateTime::ISO8601),
        ];

        return array_merge($mainParams, $this->parameters);
    }

    public function getParameters()
    {
        $params = $this->getUnsignedParams();
        $params['Signature'] = $this->signature;
        return $params;
    }

    public function isJSON()
    {
        return strtoupper($this->format) == 'JSON';
    }

    public function sign($apiKey)
    {
        $encoded = array();
        foreach ($this->getUnsignedParams() as $name => $value) {
            $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
        }

        // Concatenate the sorted and URL encoded parameters into a string.
        $concatenated = implode('&', $encoded);

        // The API key for the user as generated in the Seller Center GUI.
        // Must be an API key associated with the UserID parameter.

        // Compute signature
        $this->signature = rawurlencode(
            hash_hmac('sha256', $concatenated, $apiKey, false));
    }
}
