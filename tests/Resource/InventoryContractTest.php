<?php

declare(strict_types=1);

namespace Aeglio\Tests\Resource;

use Aeglio\Aeglio;
use Aeglio\Http\HttpClient;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use RuntimeException;

final class InventoryContractTest extends TestCase
{
    public function test_every_public_operation_has_a_callable_sdk_method_with_the_correct_route(): void
    {
        $inventory = json_decode(file_get_contents(__DIR__.'/../../contracts/api-v1.json'), true, flags: JSON_THROW_ON_ERROR);
        $sentinel = new RuntimeException('Request captured without sending');
        $captured = [];
        $http = new HttpClient('https://example.test', 'test', function ($method, $path) use (&$captured, $sentinel): never {
            $captured = [$method, $path];
            throw $sentinel;
        });
        $client = new Aeglio('test', httpClient: $http);
        foreach ($inventory as $operation) {
            [$resource, $name] = explode('.', $operation['sdk']);
            $class = 'Aeglio\\Resource\\'.$resource;
            $method = new ReflectionMethod($class, $name);
            $captured = [];
            try {
                $method->invokeArgs(new $class($client, $http), $this->arguments($method));
                self::fail('SDK did not make a request: '.$operation['sdk']);
            } catch (RuntimeException $exception) {
                self::assertSame($sentinel, $exception, $operation['sdk']);
            }
            self::assertSame($operation['method'], $captured[0], $operation['sdk']);
            $pattern = '~^'.preg_replace('/\{[^}]+\}/', '[^/]+', $operation['path']).'$~';
            self::assertMatchesRegularExpression($pattern, $captured[1], $operation['sdk']);
        }
    }

    private function arguments(ReflectionMethod $method): array
    {
        $values = [];
        foreach ($method->getParameters() as $parameter) {
            if ($parameter->isOptional()) {
                break;
            }
            $type = $parameter->getType();
            self::assertInstanceOf(ReflectionNamedType::class, $type);
            $values[] = match ($type->getName()) {
                'int' => 7, 'float' => 1.0, 'bool' => true, 'string' => '00000000-0000-4000-8000-000000000007', 'array' => [],
                default => $this->construct($type->getName()),
            };
        }
        return $values;
    }

    private function construct(string $class): object
    {
        $reflection = new ReflectionClass($class);
        return $reflection->newInstanceArgs($reflection->getConstructor() ? $this->arguments($reflection->getConstructor()) : []);
    }
}
