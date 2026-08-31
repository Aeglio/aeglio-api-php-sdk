# Aeglio PHP SDK

## Install

```bash
composer require aeglio/aeglio-api-php-sdk
```

## Development

```bash
composer install
composer test
AEGLIO_TOKEN=your_token php smoke.php
```

## Create Client

```php
use Aeglio\Aeglio;

$aeglio = new Aeglio(token: 'team_api_token');
```

Default base URL:

```php
Aeglio::DEFAULT_BASE_URL; // https://api.aeglio.com/v1
```

## Expenses

```php
use Aeglio\Dto\ExpenseCategoryData;
use Aeglio\Dto\ExpenseData;
use Aeglio\Dto\ExpensePaymentData;

$category = $aeglio->expenseCategories()->create(new ExpenseCategoryData(
    name: 'Travel',
    isGos: false,
));

$expense = $aeglio->expenses()->create(new ExpenseData(
    number: 'EXP-001',
    amount: 120.50,
    issuedAt: '2026-04-21',
    dueAt: '2026-04-28',
    categoryId: $category->id,
    supplierId: 42,
    notes: 'Hotel stay',
    billable: true,
));

$payment = $expense->addPayment(new ExpensePaymentData(
    sum: 120.50,
    paidAt: '2026-04-22',
    notes: 'Paid by bank transfer',
));
```

## Invoices

```php
use Aeglio\Dto\ClientData;
use Aeglio\Dto\InvoiceData;
use Aeglio\Dto\InvoicePaymentData;
use Aeglio\Dto\InvoiceRecipientData;
use Aeglio\Dto\InvoiceRowData;
use Aeglio\Dto\SendInvoiceData;

$client = $aeglio->clients()->create(new ClientData(
    name: 'Acme Ltd',
    locale: 'en_US',
    email: 'billing@acme.test',
    countryCode: 'EE',
    vatNumber: 'EE123456789',
    address: 'Main Street 1',
    city: 'Tallinn',
    postalCode: '10115',
    stateRegion: 'Harju maakond',
));

$invoice = $aeglio->invoices()->create(new InvoiceData(
    clientId: $client->id,
    number: 'INV-001',
    issuedAt: '2026-04-24',
    dueAt: '2026-05-01',
    rows: [
        new InvoiceRowData(
            type: 'regular',
            title: 'Development work',
            description: '<p><strong>Backend development</strong> and testing.</p>',
            quantity: 3,
            price: 49.99,
        ),
    ],
));

$payment = $invoice->addPayment(new InvoicePaymentData(
    sum: 149.97,
    paidAt: '2026-04-25',
));

$pdf = $invoice->downloadPdf();

$invoice->send(new SendInvoiceData(
    recipients: [InvoiceRecipientData::client($client->id)],
    teamCopy: false,
    locale: 'fi_FI',
    subject: 'Lasku INV-001',
    // Safe HTML supports paragraphs, line breaks, bold, italic, underline, and lists.
    body: '<p><strong>Mukautettu viesti.</strong></p>',
    deliveryMode: 'both', // pdf, link, or both
    replyToEmail: 'billing@example.com', // defaults to the team's billing email
));
```

## Other Resources

```php
use Aeglio\Dto\ClientData;
use Aeglio\Dto\ProjectData;
use Aeglio\Dto\TaxRateData;

$client = $aeglio->clients()->create(new ClientData(
    name: 'Globex',
    locale: 'en_US',
    countryCode: 'FI',
    vatNumber: 'FI12345678',
    address: 'Updated Street 5',
    city: 'Helsinki',
    postalCode: '00100',
    stateRegion: 'Uusimaa',
));

$project = $aeglio->projects()->create(new ProjectData(
    clientId: $client->id,
    name: 'Website rebuild',
    type: 'time',
));

$taxRate = $aeglio->taxRates()->create(new TaxRateData(
    title: 'VAT',
    percentage: 22.0,
    default: true,
));
```

## Available Sections

- `clients()`
- `suppliers()`
- `projects()`
- `taxRates()`
- `expenseCategories()`
- `expenses()`
- `invoices()`

## Public API

### Clients

- `clients()->list(int $perPage = 50, int $page = 1, ?string $search = null)`
- `clients()->find(int $id)`
- `clients()->create(ClientData $data)`
- `clients()->update(int $id, UpdateClientData $data)`
- `clients()->delete(int $id)`

### Suppliers

- `suppliers()->list(int $perPage = 50, int $page = 1, ?string $search = null)`
- `suppliers()->find(int $id)`
- `suppliers()->create(ClientData $data)`
- `suppliers()->update(int $id, UpdateClientData $data)`
- `suppliers()->delete(int $id)`

### Projects

- `projects()->list(?bool $archived = null, int $perPage = 50, int $page = 1)`
- `projects()->find(int $id)`
- `projects()->create(ProjectData $data)`
- `projects()->update(int $id, UpdateProjectData $data)`
- `projects()->delete(int $id)`

### Tax Rates

- `taxRates()->list(int $perPage = 50, int $page = 1)`
- `taxRates()->find(int $id)`
- `taxRates()->create(TaxRateData $data)`
- `taxRates()->update(int $id, UpdateTaxRateData $data)`
- `taxRates()->delete(int $id)`

### Expense Categories

- `expenseCategories()->list(int $perPage = 50, int $page = 1)`
- `expenseCategories()->find(int $id)`
- `expenseCategories()->create(ExpenseCategoryData $data)`
- `expenseCategories()->update(int $id, UpdateExpenseCategoryData $data)`
- `expenseCategories()->delete(int $id)`

### Expenses

- `expenses()->list(?array $state = null, int $perPage = 50, int $page = 1)`
- `expenses()->find(int $id)`
- `expenses()->create(ExpenseData $data)`
- `expenses()->update(int $id, UpdateExpenseData $data)`
- `expenses()->delete(int $id)`
- `expenses()->addPayment(int $expenseId, ExpensePaymentData $data)`
- `expenses()->updatePayment(int $expenseId, int $paymentId, UpdateExpensePaymentData $data)`
- `expenses()->deletePayment(int $expenseId, int $paymentId)`
- `expenses()->listPayments(int $expenseId, int $perPage = 50, int $page = 1)`
- `expenses()->findPayment(int $expenseId, int $paymentId)`
- `expenses()->downloadAttachment(int $expenseId)`

Entity helpers:

- `$expense->addPayment(...)`
- `$expense->update(...)`
- `$expense->delete()`
- `$expense->payments(...)`
- `$expense->downloadAttachment()`

### Invoices

- `invoices()->list(?array $state = null, int $perPage = 50, int $page = 1)`
- `invoices()->find(int $id)`
- `invoices()->create(InvoiceData $data)`
- `invoices()->update(int $id, UpdateInvoiceData $data)`
- `invoices()->delete(int $id)`
- `invoices()->addPayment(int $invoiceId, InvoicePaymentData $data)`
- `invoices()->updatePayment(int $invoiceId, int $paymentId, UpdateInvoicePaymentData $data)`
- `invoices()->deletePayment(int $invoiceId, int $paymentId)`
- `invoices()->listPayments(int $invoiceId, int $perPage = 50, int $page = 1)`
- `invoices()->findPayment(int $invoiceId, int $paymentId)`
- `invoices()->send(int $invoiceId, SendInvoiceData $data)`
- `invoices()->downloadPdf(int $invoiceId)`

Entity helpers:

- `$invoice->addPayment(...)`
- `$invoice->update(...)`
- `$invoice->delete()`
- `$invoice->payments(...)`
- `$invoice->send(...)`
- `$invoice->downloadPdf()`
