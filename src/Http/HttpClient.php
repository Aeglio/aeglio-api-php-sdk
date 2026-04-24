<?php

declare(strict_types=1);

namespace Aeglio\Http;

use Aeglio\Exception\ApiException;
use Aeglio\Exception\AuthenticationException;
use Aeglio\Exception\AuthorizationException;
use Aeglio\Exception\NotFoundException;
use Aeglio\Exception\ServerException;
use Aeglio\Exception\ValidationException;
use CURLFile;

final readonly class HttpClient
{
    public function __construct(
        public string $baseUrl,
        public string $token,
    ) {
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param array<string, mixed>|null $json
     *
     * @return array<string, mixed>
     */
    public function json(string $method, string $path, array $query = [], ?array $json = null): array
    {
        $response = $this->send(
            method: $method,
            path: $path,
            query: $query,
            headers: ['Accept: application/json'],
            json: $json,
        );

        return $this->decodeJson($response);
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param array<string, scalar|bool|int|float|null> $fields
     * @param array<string, string|\SplFileInfo> $files
     *
     * @return array<string, mixed>
     */
    public function multipart(
        string $method,
        string $path,
        array $query = [],
        array $fields = [],
        array $files = [],
    ): array {
        $payload = [];

        foreach ($fields as $key => $value) {
            $payload[$key] = is_bool($value) ? ($value ? 'true' : 'false') : $value;
        }

        foreach ($files as $key => $file) {
            $pathName = $file instanceof \SplFileInfo ? $file->getPathname() : $file;
            $payload[$key] = new CURLFile($pathName);
        }

        $response = $this->send(
            method: $method,
            path: $path,
            query: $query,
            headers: ['Accept: application/json'],
            multipart: $payload,
        );

        return $this->decodeJson($response);
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     */
    public function raw(string $method, string $path, array $query = []): string
    {
        return $this->send(
            method: $method,
            path: $path,
            query: $query,
            headers: ['Accept: */*'],
        )['body'];
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     * @param list<string> $headers
     * @param array<string, mixed>|null $json
     * @param array<string, mixed>|null $multipart
     *
     * @return array{status:int, body:string}
     */
    private function send(
        string $method,
        string $path,
        array $query = [],
        array $headers = [],
        ?array $json = null,
        ?array $multipart = null,
    ): array {
        $curl = curl_init();

        $url = $this->buildUrl($path, $query);
        $requestHeaders = array_merge(
            [
                'Authorization: Bearer '.$this->token,
                'User-Agent: aeglio-api-php-sdk/0.1.0',
            ],
            $headers,
        );

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $requestHeaders,
            CURLOPT_TIMEOUT => 30,
        ];

        if ($json !== null) {
            $options[CURLOPT_POSTFIELDS] = json_encode($json, JSON_THROW_ON_ERROR);
            $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
        }

        if ($multipart !== null) {
            $options[CURLOPT_POSTFIELDS] = $multipart;
        }

        curl_setopt_array($curl, $options);

        $body = curl_exec($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if ($body === false) {
            $message = curl_error($curl);
            curl_close($curl);

            throw new ApiException($message, 0);
        }

        curl_close($curl);

        if ($status >= 400) {
            $this->throwHttpException($status, $body);
        }

        return [
            'status' => $status,
            'body' => $body,
        ];
    }

    /**
     * @param array{status:int, body:string} $response
     *
     * @return array<string, mixed>
     */
    private function decodeJson(array $response): array
    {
        if ($response['body'] === '') {
            return [];
        }

        $decoded = json_decode($response['body'], true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<string, scalar|list<scalar>|null> $query
     */
    private function buildUrl(string $path, array $query): string
    {
        $url = rtrim($this->baseUrl, '/').'/'.ltrim($path, '/');

        if ($query === []) {
            return $url;
        }

        $parts = [];

        foreach ($query as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_array($value)) {
                $value = implode(',', $value);
            }

            $parts[] = urlencode((string) $key).'='.urlencode((string) $value);
        }

        return $parts === [] ? $url : $url.'?'.implode('&', $parts);
    }

    private function throwHttpException(int $status, string $body): never
    {
        $decoded = json_decode($body, true);
        $response = is_array($decoded) ? $decoded : [];
        $message = is_string($response['message'] ?? null)
            ? $response['message']
            : 'Aeglio API request failed.';

        throw match (true) {
            $status === 401 => new AuthenticationException($message, $status, $response),
            $status === 403 => new AuthorizationException($message, $status, $response),
            $status === 404 => new NotFoundException($message, $status, $response),
            $status === 422 => new ValidationException($message, $status, $response),
            $status >= 500 => new ServerException($message, $status, $response),
            default => new ApiException($message, $status, $response),
        };
    }
}
