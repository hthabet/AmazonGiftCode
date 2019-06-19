<?php

namespace kamerk22\AmazonGiftCode;

use kamerk22\AmazonGiftCode\AWS\AWS;
use kamerk22\AmazonGiftCode\Config\Config;

class AmazonGiftCode
{

    private $_config;

    /**
     * AmazonGiftCode constructor.
     *
     * @param $key
     * @param $secret
     * @param $partner
     * @param $endpoint
     * @param $currency
     */
    public function __construct($key, $secret, $partner, $endpoint, $currency)
    {
        $this->_config = new Config($key, $secret, $partner, $endpoint, $currency);
    }

    /**
     * AmazonGiftCode make own client.
     *
     * @param null $key
     * @param null $secret
     * @param null $partner
     * @param null $endpoint
     * @param null $currency
     *
     * @return AmazonGiftCode
     */
    public static function make(
        $key,
        $secret,
        $partner,
        $endpoint,
        $currency
    ): AmazonGiftCode {
        return new static($key, $secret, $partner, $endpoint, $currency);
    }

    /**
     * @param float       $value
     *
     * @param string|null $requestId
     *
     * @return Response\CreateResponse
     *
     */
    public function createGiftCard(float $value, string $requestId = null): Response\CreateResponse
    {
        return (new AWS($this->_config))->getCode($value, $requestId);
    }

    /**
     * @param string $creationRequestId
     * @param string $gcId
     *
     * @return Response\CancelResponse
     */
    public function cancelGiftCard(string $creationRequestId, string $gcId): Response\CancelResponse
    {
        return (new AWS($this->_config))->cancelCode($creationRequestId, $gcId);
    }
}
