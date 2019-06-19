<?php

namespace kamerk22\AmazonGiftCode;

use kamerk22\AmazonGiftCode\AWS\AWS;
use kamerk22\AmazonGiftCode\Config\Config;
use kamerk22\AmazonGiftCode\Exceptions\AmazonErrors;

class AmazonGiftCode
{

    private $_config;

    /**
     * AmazonGiftCode constructor.
     *
     * @param null $key
     * @param null $secret
     * @param null $partner
     * @param null $endpoint
     * @param null $currency
     */
    public function __construct($key = null, $secret = null, $partner = null, $endpoint = null, $currency = null)
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
        $key = null,
        $secret = null,
        $partner = null,
        $endpoint = null,
        $currency = null
    ): AmazonGiftCode {
        return new static($key, $secret, $partner, $endpoint, $currency);
    }

    /**
     * @param Float $value
     *
     * @return Response\CreateResponse
     *
     * @throws AmazonErrors
     */
    public function buyGiftCard(Float $value): Response\CreateResponse
    {
        return (new AWS($this->_config))->getCode($value);
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
