<?php

declare(strict_types=1);

namespace Aeglio\Entity;

use Aeglio\Aeglio;
use Aeglio\Dto\UpdateArticleData;

final readonly class Article
{
    private function __construct(
        private Aeglio $client,
        public int $id,
        public string $name,
        public string $currency,
        public ?string $code,
        public ?string $unit,
        public ?string $unitPlural,
        public ?string $defaultSalesPrice,
        public ?string $defaultPurchasePrice,
        public bool $sellable,
        public bool $purchasable,
        public bool $active,
        public ?int $defaultExpenseCategoryId,
        public ?int $defaultTaxRateId,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(Aeglio $client, array $data): self
    {
        return new self(
            client: $client,
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            currency: (string) ($data['currency'] ?? ''),
            code: isset($data['code']) ? (string) $data['code'] : null,
            unit: isset($data['unit']) ? (string) $data['unit'] : null,
            unitPlural: isset($data['unit_plural']) ? (string) $data['unit_plural'] : null,
            defaultSalesPrice: isset($data['default_sales_price']) ? (string) $data['default_sales_price'] : null,
            defaultPurchasePrice: isset($data['default_purchase_price']) ? (string) $data['default_purchase_price'] : null,
            sellable: (bool) ($data['sellable'] ?? false),
            purchasable: (bool) ($data['purchasable'] ?? false),
            active: (bool) ($data['active'] ?? false),
            defaultExpenseCategoryId: isset($data['default_expense_category_id']) ? (int) $data['default_expense_category_id'] : null,
            defaultTaxRateId: isset($data['default_tax_rate_id']) ? (int) $data['default_tax_rate_id'] : null,
            createdAt: isset($data['created_at']) ? (string) $data['created_at'] : null,
            updatedAt: isset($data['updated_at']) ? (string) $data['updated_at'] : null,
        );
    }

    public function update(UpdateArticleData $data): self
    {
        return $this->client->articles()->update($this->id, $data);
    }
}
