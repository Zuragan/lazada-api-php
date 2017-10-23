<?php
namespace Zuragan\Lazada\Actions;

class ActionFactory
{
    private $userId;
    private $version;
    private $format;
    private $apiKey;

    public function __construct($userId, $apiKey, $version = '1.0', $format = 'JSON')
    {
        $this->userId = $userId;
        $this->apiKey = $apiKey;
        $this->version = $version;
        $this->format = $format;
    }

    public function getAction($action, $parameters = [], $timestamp = null)
    {
        return new GetAction(
            $this->userId,
            $this->apiKey,
            $this->version,
            $this->format,
            $action,
            $parameters,
            $timestamp
        );
    }

    public function postAction($action, $parameters = [], $payload = [], $timestamp = null)
    {
        return new PostAction(
            $this->userId,
            $this->apiKey,
            $this->version,
            $this->format,
            $action,
            $parameters,
            $timestamp,
            $payload
        );

    }

}
