<?php

namespace ALevel\QuickOrder\Api\Data\Schema;

/**
 * Interface StatusSchemaInterface
 * @package ALevel\QuickOrder\Api\Data\Schema
 */
interface StatusSchemaInterface
{
    const TABLE_NAME = 'alevel_quick_order_status';

    const STATUS_ID_COL_NAME = 'status_id';
    const STATUS_CODE_COL_NAME = 'status_code';
    const STATUS_LABEL_COL_NAME = 'status';
}
