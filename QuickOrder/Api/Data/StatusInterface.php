<?php


namespace ALevel\QuickOrder\Api\Data;

/**
 * Interface StatusInterface
 * @package ALevel\QuickOrder\Api\Data
 */
interface StatusInterface
{
    const STATUS_ID = 'status_id';

    const STATUS_CODE = 'status_code';

    const STATUS = 'status';

    /**
     * @return mixed
     */
    public function getStatusId();

    /**
     * @param $status_id
     * @return mixed
     */
    public function setStatusId($status_id);

    /**
     * @return mixed
     */
    public function getStatusCode();

    /**
     * @param $status_code
     * @return mixed
     */
    public function setStatusCode($status_code);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

}
