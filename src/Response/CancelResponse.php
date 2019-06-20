<?php

/**
 * Part of the AmazonGiftCode package.
 * Author: Kashyap Merai <kashyapk62@gmail.com>
 *
 */


namespace kamerk22\AmazonGiftCode\Response;


use kamerk22\AmazonGiftCode\Exceptions\RequestFailedException;
use kamerk22\AmazonGiftCode\Exceptions\RequestResendException;
use RuntimeException;

class CancelResponse extends Response
{
    /**
     * Amazon Gift Card gcId.
     *
     * @var string
     */
    protected $_id;

    /**
     * Amazon Gift Card creationRequestId
     *
     * @var string
     */
    protected $_creation_request_id;

    /**
     * @param $jsonResponse
     *
     * @return CancelResponse
     * @throws RequestFailedException
     * @throws RequestResendException
     */
    public function parseJsonResponse($jsonResponse): self
    {
        if (!is_array($jsonResponse)) {
            throw new RuntimeException('Response must be a scalar value');
        }

        if ($jsonResponse['status'] === Response::FAILURE_STATUS) {
            throw new RequestFailedException('Request failed');
        }

        if ($jsonResponse['status'] === Response::RESEND_STATUS) {
            throw new RequestResendException('Request must be retried');
        }

        if (array_key_exists('gcId', $jsonResponse)) {
            $this->_id = $jsonResponse['gcId'];
        }
        if (array_key_exists('creationRequestId', $jsonResponse)) {
            $this->_creation_request_id = $jsonResponse['creationRequestId'];
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getCreationRequestId(): string
    {
        return $this->_creation_request_id;
    }
}
