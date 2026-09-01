<?php
declare(strict_types=1);
namespace Authentication\Exceptions;
use Core\Contracts\HasHttpStatusException;
abstract class PasswordException extends \Exception implements HasHttpStatusException {
    public function __construct(string $message) {
        parent::__construct($message);
    }
}