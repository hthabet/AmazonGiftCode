<?php
declare(strict_types=1);

namespace kamerk22\AmazonGiftCode\Response;

class Response
{
    const SUCCESS_STATUS = 'SUCCESS';
    const FAILURE_STATUS = 'FAILURE';
    const RESEND_STATUS  = 'RESEND';

    protected $_raw_json;

    /**
     * Response constructor.
     *
     * @param $jsonResponse
     */
    public function __construct($jsonResponse)
    {
        $this->_raw_json = $jsonResponse;
        $this->parseJsonResponse($jsonResponse);
    }
}
