<?php

declare(strict_types=1);

namespace Aeglio\Dto;

use Aeglio\Support\Optional;

final readonly class UpdateArticleData
{
    public function __construct(
        public string|Optional $name = new Optional(),
        public string|Optional $currency = new Optional(),
        public string|null|Optional $code = new Optional(),
        public string|null|Optional $unit = new Optional(),
        public string|null|Optional $unitPlural = new Optional(),
        public string|null|Optional $defaultSalesPrice = new Optional(),
        public string|null|Optional $defaultPurchasePrice = new Optional(),
        public bool|Optional $sellable = new Optional(),
        public bool|Optional $purchasable = new Optional(),
        public bool|Optional $active = new Optional(),
        public int|null|Optional $defaultExpenseCategoryId = new Optional(),
        public int|null|Optional $defaultTaxRateId = new Optional(),
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
        ], static fn (mixed $value): bool => !$value instanceof Optional);
    }
}
