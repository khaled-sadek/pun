<?php

declare(strict_types=1);

namespace ExceptionGetCode;

use function PHPStan\dumpType;

final class InvalidConfigurationException extends \Exception
{
    public static function withContext(string $context, self $previous): self
    {
        return new self(
            sprintf('%s: %s', $context, $previous->getMessage()),
            $previous->getCode(),
            $previous,
        );
    }
}

class CustomPdoException extends \PDOException {}

class StringCodeException extends \Exception
{
    /** @var string */
    protected $code = 'ERR';
}

class SubStringCodeException extends StringCodeException {}

class CustomError extends \Error {}

function needsInt(int $code): void {}
function needsString(string $code): void {}

/**
 * @param \PDOException|\RuntimeException $pdoOrRuntime
 * @param \PDOException|InvalidConfigurationException $pdoOrCustom
 * @param InvalidConfigurationException|\LogicException $customOrLogic
 */
function cases(
    \Throwable $throwable,
    \Exception $exception,
    \RuntimeException $runtimeException,
    \LogicException $logicException,
    \Error $error,
    \TypeError $typeError,
    \PDOException $pdoException,
    CustomPdoException $customPdoException,
    InvalidConfigurationException $customException,
    StringCodeException $stringCodeException,
    SubStringCodeException $subStringCodeException,
    CustomError $customError,
    $pdoOrRuntime,
    $pdoOrCustom,
    $customOrLogic,
): void {
    dumpType($throwable->getCode());
    dumpType($exception->getCode());
    dumpType($runtimeException->getCode());
    dumpType($logicException->getCode());
    dumpType($error->getCode());
    dumpType($typeError->getCode());
    dumpType($pdoException->getCode());
    dumpType($customPdoException->getCode());
    dumpType($customException->getCode());
    dumpType($stringCodeException->getCode());
    dumpType($subStringCodeException->getCode());
    dumpType($customError->getCode());
    dumpType($pdoOrRuntime->getCode());
    dumpType($pdoOrCustom->getCode());
    dumpType($customOrLogic->getCode());

    needsInt($throwable->getCode());
    needsInt($exception->getCode());
    needsInt($runtimeException->getCode());
    needsInt($logicException->getCode());
    needsInt($error->getCode());
    needsInt($customException->getCode());

    needsString($customException->getCode());
    needsString($error->getCode());
    needsString($stringCodeException->getCode());
}
