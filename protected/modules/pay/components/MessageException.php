<?php
namespace pay\components;

/**
 * Class MessageException Encapsulates the error message from the pay module
 */
class MessageException extends Exception
{
    const GENERAL_CODE = 100;
    const ORDER_GROUP_CODE = 200;
    const COUPONE_GROUP_CODE = 300;
    const ORDER_ITEM_GROUP_CODE = 400;

    /**
     * Constructor
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = '', $code = self::GENERAL_CODE, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
