<?php
namespace Firebase\JWT;

class SignatureInvalidException extends \UnexpectedValueException
{
    public $code = 100;
}
