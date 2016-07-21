<?php

namespace Intracto\CampaignMonitorBundle\Model;

class Response
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @param \CS_REST_Wrapper_Result $result
     */
    public function __construct(\CS_REST_Wrapper_Result $result)
    {
        $this->data = json_decode(json_encode($result->response), true);
        $this->statusCode = $result->http_status_code;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return bool
     */
    public function isPaginated()
    {
        if (isset($this->data['NumberOfPages'])) {
            return true;
        }

        return false;
    }
}
