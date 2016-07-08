<?php

namespace App\Handler;

use Slim\Http\Request;

class ExtendedRequestHandler extends Request
{
    /**
     * The params (POST and GET)
     *
     * @var \Slim\Collection
     */
    protected $params;

    /**
     * This method is applied to the cloned object
     * after PHP performs an initial shallow-copy. This
     * method completes a deep-copy by creating new objects
     * for the cloned object's internal reference pointers.
     */
    public function __clone()
    {
        parent::__clone();

        if (is_object($this->params)) {
            $this->params = clone $this->params;
        }
    }

    /**
     * Get request content type.
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @return string|null
     */
    public function getIp()
    {
        $serverParams = $this->getServerParams();
        $keys = ['X_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'CLIENT_IP', 'REMOTE_ADDR'];

        foreach ($keys as $key) {
            if (isset($serverParams[$key])) {
                return $serverParams[$key];
            }
        }

        return null;
    }

    /**
     * Get Referrer
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @return string|null
     */
    public function getReferrer()
    {
        return $this->headers->get('HTTP_REFERER');
    }

    /**
     * Get User Agent
     *
     * Note: This method is not part of the PSR-7 standard.
     *
     * @return string|null
     */
    public function getUserAgent()
    {
        return $this->headers->get('HTTP_USER_AGENT');
    }
}
