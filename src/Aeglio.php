<?php

declare(strict_types=1);

namespace Aeglio;

use Aeglio\Http\HttpClient;
use Aeglio\Resource\Clients;
use Aeglio\Resource\ExpenseCategories;
use Aeglio\Resource\Expenses;
use Aeglio\Resource\Estimates;
use Aeglio\Resource\Invoices;
use Aeglio\Resource\Projects;
use Aeglio\Resource\Suppliers;
use Aeglio\Resource\TaxRates;
use Aeglio\Resource\Articles;

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

    public function time(): \Aeglio\Resource\Time
    {
        return new \Aeglio\Resource\Time($this, $this->httpClient);
    }

    public function clients(): Clients
    {
        return new Clients($this, $this->httpClient);
    }

    public function expenses(): Expenses
    {
        return new Expenses($this, $this->httpClient);
    }

    public function suppliers(): Suppliers
    {
        return new Suppliers($this, $this->httpClient);
    }

    public function expenseCategories(): ExpenseCategories
    {
        return new ExpenseCategories($this, $this->httpClient);
    }

    public function invoices(): Invoices
    {
        return new Invoices($this, $this->httpClient);
    }

    public function estimates(): Estimates
    {
        return new Estimates($this, $this->httpClient);
    }

    public function projects(): Projects
    {
        return new Projects($this, $this->httpClient);
    }

    public function articles(): Articles
    {
        return new Articles($this, $this->httpClient);
    }

    public function taxRates(): TaxRates
    {
        return new TaxRates($this, $this->httpClient);
    }
    public function tasks(): \Aeglio\Resource\Tasks
    {
        return new \Aeglio\Resource\Tasks($this, $this->httpClient);
    }

    public function milestones(): \Aeglio\Resource\Milestones
    {
        return new \Aeglio\Resource\Milestones($this, $this->httpClient);
    }

    public function deals(): \Aeglio\Resource\Deals
    {
        return new \Aeglio\Resource\Deals($this, $this->httpClient);
    }

    public function recurringInvoices(): \Aeglio\Resource\RecurringInvoices
    {
        return new \Aeglio\Resource\RecurringInvoices($this, $this->httpClient);
    }

    public function approvals(): \Aeglio\Resource\Approvals
    {
        return new \Aeglio\Resource\Approvals($this, $this->httpClient);
    }

    public function documents(): \Aeglio\Resource\Documents
    {
        return new \Aeglio\Resource\Documents($this, $this->httpClient);
    }

    public function reimbursements(): \Aeglio\Resource\Reimbursements
    {
        return new \Aeglio\Resource\Reimbursements($this, $this->httpClient);
    }

    public function dealPipelines(): \Aeglio\Resource\DealPipelines
    {
        return new \Aeglio\Resource\DealPipelines($this, $this->httpClient);
    }

    public function webhooks(): \Aeglio\Resource\Webhooks
    {
        return new \Aeglio\Resource\Webhooks($this, $this->httpClient);
    }

}
