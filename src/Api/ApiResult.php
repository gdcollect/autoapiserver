<?php

namespace AutoApiServer\Api;


class ApiResult
{
    public function __construct()
    {
        $this->error = false;
    }

    private $error;

    /**
     * @param mixed $error
     */
    public function setError(bool $error): void
    {
        $this->error = $error;
    }

    private $body;

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function toArray()
    {
        $result = [];
        $result['error'] = $this->error;
        $result['body'] = $this->body;
        return $result;
    }

    public function isError()
    {
        return $this->error;
    }
}
