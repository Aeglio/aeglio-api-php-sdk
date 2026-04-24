<?php

declare(strict_types=1);

namespace Aeglio;

use Aeglio\Http\HttpClient;
use Aeglio\Resource\Clients;
use Aeglio\Resource\ExpenseCategories;
use Aeglio\Resource\Expenses;
use Aeglio\Resource\Invoices;
use Aeglio\Resource\Projects;
use Aeglio\Resource\TaxRates;

final class Aeglio
{
    public const DEFAULT_BASE_URL = 'https://api.aeglio.com/v1';

    private readonly HttpClient $httpClient;

    public function __construct(
        string $token,
        string $baseUrl = self::DEFAULT_BASE_URL,
        ?HttpClient $httpClient = null,
    ) {
        $this->httpClient = $httpClient ?? new HttpClient(
            baseUrl: $baseUrl,
            token: $token,
        );
    }

    public static function make(
        string $token,
        string $baseUrl = self::DEFAULT_BASE_URL,
        ?HttpClient $httpClient = null,
    ): self {
        return new self(
            token: $token,
            baseUrl: $baseUrl,
            httpClient: $httpClient,
        );
    }

    public function clients(): Clients
    {
        return new Clients($this, $this->httpClient);
    }

    public function expenses(): Expenses
    {
        return new Expenses($this, $this->httpClient);
    }

    public function expenseCategories(): ExpenseCategories
    {
        return new ExpenseCategories($this, $this->httpClient);
    }

    public function invoices(): Invoices
    {
        return new Invoices($this, $this->httpClient);
    }

    public function projects(): Projects
    {
        return new Projects($this, $this->httpClient);
    }

    public function taxRates(): TaxRates
    {
        return new TaxRates($this, $this->httpClient);
    }
}
