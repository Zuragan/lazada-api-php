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
        $action = new GetAction(
            $this->userId,
            $this->version,
            $this->format,
            $action,
            $parameters,
            $timestamp
        );
        $action->sign($this->apiKey);
        return $action;
    }

    public function postAction($action, $parameters = [], $payload = [], $timestamp = null)
    {
        $action = new PostAction(
            $this->userId,
            $this->version,
            $this->format,
            $action,
            $parameters,
            $timestamp,
            $payload
        );
        $action->sign($this->apiKey);
        return $action;
    }

}
