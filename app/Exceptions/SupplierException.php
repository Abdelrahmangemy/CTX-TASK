<?php
namespace App\Exceptions;

use Exception;

class SupplierException extends Exception
{
    /**
     * SupplierException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "Supplier API error", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
