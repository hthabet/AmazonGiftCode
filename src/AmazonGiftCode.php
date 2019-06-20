<?php

namespace kamerk22\AmazonGiftCode;

use kamerk22\AmazonGiftCode\AWS\AWS;
use kamerk22\AmazonGiftCode\Config\Config;
use kamerk22\AmazonGiftCode\Exceptions\RequestResendException;

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
     * @param string|null $creationRequestId
     *
     * @param int         $retryNumber
     *
     * @return Response\CreateResponse
     */
    public function createGiftCard(
        float $value,
        string $creationRequestId = null,
        $retryNumber = 0
    ): Response\CreateResponse {

        try {
            return (new AWS($this->_config))->getCode($value, $creationRequestId);
        } catch (RequestResendException $exception) {
            $retryNumber++;
            sleep($retryNumber);
            return $this->createGiftCard($value, $creationRequestId, $retryNumber);
        }
    }

    /**
     * @param string $creationRequestId
     * @param string $gcId
     *
     * @param int    $retryNumber
     *
     * @return Response\CancelResponse
     */
    public function cancelGiftCard(string $creationRequestId, string $gcId, $retryNumber = 0): Response\CancelResponse
    {
        try {
            return (new AWS($this->_config))->cancelCode($creationRequestId, $gcId);
        } catch (RequestResendException $exception) {
            $retryNumber++;
            sleep($retryNumber);
            return $this->cancelGiftCard($value, $creationRequestId, $retryNumber);
        }

    }
}
