<?php

namespace ALevel\QuickOrder\Api\Data\Schema;

/**
 * Interface OrderSchemaInterface
 * @package ALevel\QuickOrder\Api\Data\Schema
 */
interface OrderSchemaInterface
{
    const TABLE_NAME = 'alevel_quick_order';

    const SKU = 'sku';
    const NAME = 'name';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const STATUS_LABEL = 'status';

}
