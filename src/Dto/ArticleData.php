<?php

declare(strict_types=1);

namespace Aeglio\Dto;

final readonly class ArticleData
{
    public function __construct(
        public string $name,
        public string $currency,
        public ?string $code = null,
        public ?string $unit = null,
        public ?string $unitPlural = null,
        public ?string $defaultSalesPrice = null,
        public ?string $defaultPurchasePrice = null,
        public bool $sellable = true,
        public bool $purchasable = true,
        public bool $active = true,
        public ?int $defaultExpenseCategoryId = null,
        public ?int $defaultTaxRateId = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'currency' => $this->currency,
            'code' => $this->code,
            'unit' => $this->unit,
            'unit_plural' => $this->unitPlural,
            'default_sales_price' => $this->defaultSalesPrice,
            'default_purchase_price' => $this->defaultPurchasePrice,
            'sellable' => $this->sellable,
            'purchasable' => $this->purchasable,
            'active' => $this->active,
            'default_expense_category_id' => $this->defaultExpenseCategoryId,
            'default_tax_rate_id' => $this->defaultTaxRateId,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
