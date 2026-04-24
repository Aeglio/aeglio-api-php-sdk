<?php

declare(strict_types=1);

namespace Aeglio\Exception;

use RuntimeException;

class ApiException extends RuntimeException
{
    /**
     * @param array<string, mixed> $responseBody
     */
    public function __construct(
        string $message,
        public readonly int $statusCode,
        public readonly array $responseBody = [],
    ) {
        parent::__construct($message, $statusCode);
    }
}
