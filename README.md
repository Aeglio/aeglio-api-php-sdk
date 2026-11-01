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
- `estimates()`

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

Code is optional. New or edited Codes are trimmed and uppercased by the API and
must contain 2–12 ASCII letters/numbers, starting with a letter. Codes reserved by
another project return 422. Existing legacy Codes remain readable. Changing Code
updates every task prefix while preserving task numbers and IDs. Omit Code to keep
it unchanged; send null or an empty string to clear it and use the automatic task
prefix. SDK field types remain nullable strings; validation belongs to the API.

```php
$aeglio->projects()->update($project->id, new \Aeglio\Dto\UpdateProjectData(code: 'WEB2'));
$aeglio->projects()->update($project->id, new \Aeglio\Dto\UpdateProjectData(code: null));
```

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

Changing or deleting a tax rate used by pending recurring one-time charges returns
HTTP 422. Resolve those charges in Aeglio first; `ValidationException::errors()`
contains the `charge` key.

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

One-time charges added to recurring schedules appear as ordinary `InvoiceRow`
entries on the generated invoice. The invoice totals include them. Pending
charges are managed in Aeglio; there are no public charge endpoints or new row
fields. Changing a recurring template's client, currency or tax mode while it has
pending charges returns HTTP 422 with `errors.charge`.

Saved invoice rows retain the tax percentage and label applied when they were
saved. Later tax-setting edits do not change their tax or total amounts.
`taxRateId` identifies the settings/mapping record; its current percentage may
differ from the invoice row’s applied rate. Treat the returned `tax` and `total`
values as authoritative. Keeping the same tax selection on an existing row
preserves its applied rate; selecting a different rate captures that rate.
Recurring templates remain live configuration for future occurrences.

- `invoices()->list(?array $state = null, int $perPage = 50, int $page = 1)`
- `invoices()->find(int $id)`
- `invoices()->create(InvoiceData $data)`
- Automatic payment references are an opt-in team setting. Omit `referenceNumber`
  when creating an invoice to let Aeglio assign it (Estonian numeric or ISO 11649
  `RF`, according to the issuer's settings). Read `$invoice->referenceNumber`
  from the returned invoice. An explicit nonblank value remains manual. Generated
  references cannot be directly changed or cleared; attempts return a validation error.
  Teams can assign references per invoice (default) or reuse one per client.
  Updating `clientId` on a client-based invoice automatically replaces its reference
  with the destination client's reference, using the invoice's stored format.
  Omit `referenceNumber` on this update and read the new value from the response.
  Manual and per-invoice references remain unchanged when changing the client.
  Updating an existing invoice never automatically fills a blank reference.
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

### Estimates

Estimate endpoints are read-only. Every revision has its own stable `id`; revisions share the commercial `number` and are ordered by `revisionNumber`.

- `estimates()->list(int $perPage = 50, int $page = 1)`
- `estimates()->find(int $id)`


## Tasks, assignees and milestones

Task IDs are stable numeric IDs within the token's team. Human references can change. Assignees, statuses, labels, comments, checklists, attachments and milestones use opaque UUIDs. Discover eligible people for the chosen project; this API does not administer users.

```php
use Aeglio\Dto\TaskData;
use Aeglio\Dto\TaskFilter;
use Aeglio\Dto\UpdateTaskData;

$api = \Aeglio\Aeglio::make(token: $token);
$projects = $api->tasks()->projects();
$people = $api->tasks()->assignees($projectId);
$statuses = $api->tasks()->statuses();

$task = $api->tasks()->create(new TaskData(
    projectId: $projectId,
    title: 'Review the proposal',
    operationId: $operationUuid, // Generate once; retain for retries of this creation.
    assigneeId: $personUuid,     // From assignees($projectId).
));
$task = $api->tasks()->update($task->id, new UpdateTaskData(
    version: $task->version,
    dueDate: '2027-01-15',
));
$task = $api->tasks()->update($task->id, new UpdateTaskData(
    version: $task->version,
    assigneeId: null, // Explicitly unassign; omitted properties remain unchanged.
));
$mine = $api->tasks()->list(filter: new TaskFilter(assigneeId: $personUuid));
```

Use `setLabels`, `setParent`, `order`, `addDependency`/`removeDependency` and `addRelation`/`removeRelation` for task relationships. `archive(..., archived: false)` restores a task. Set `statusId` to a status from `statuses()` to complete/reopen; handle any domain completion warnings before resubmitting acknowledgements. Task comments, activity, children, checklist groups/items and attachments have paginated reads and explicit mutation methods. `uploadAttachment()` sends a file; `downloadAttachment()` returns bytes. `deleteAttachment()` returns false while storage cleanup is pending. Checklist conversion and relative ordering preserve domain version checks.

`milestones()` supports create/update, linked tasks/progress, and `transition()` to active, achieved or cancelled. There is no milestone delete operation.

## Commercial workflows

`deals()` supports CRUD, owners/client contacts, and outcomes. `dealPipelines()` provides read-only pipelines and stages. `estimates()` now includes rows/totals and create/update/delete, duplicate, revision, cancel, send, mark-as-sent, staff acceptance and invoice/project conversion. Editable-state and team permissions still apply. Estimate row updates replace the supplied row collection; omitting rows preserves them. Use `EstimateRowData` objects for rows.

`recurringInvoices()` supports schedules, typed invoice templates, preview, generated history, recipients and one-time charges. Use `InvoiceData` for a new template and `UpdateInvoiceData` when changing it. Preview returns `state` and `items`; each item contains variable `values`, substituted `texts` and unknown placeholders. There is no generate-now endpoint. Charges inherit the template's client/currency and require version checks for updates/cancellation.

```php
use Aeglio\Dto\InvoiceData;
use Aeglio\Dto\InvoiceRowData;
use Aeglio\Dto\RecurringInvoiceData;

$schedule = $api->recurringInvoices()->create(new RecurringInvoiceData(
    firstIssueAt: '2027-01-01',
    operationId: $operationUuid,
    template: new InvoiceData(
        clientId: $clientId,
        number: 'Monthly service',
        issuedAt: '2027-01-01',
        dueAt: '2027-01-15',
        currency: 'EUR',
        rows: [new InvoiceRowData(type: 'regular', title: 'Monthly service', quantity: 1, price: 100)],
    ),
    frequency: 1,
    frequencyUnit: 'months',
    sendAutomatically: false,
));
$preview = $api->recurringInvoices()->preview($schedule->id);
```

`approvals()`, `documents()`, `reimbursements()` and `webhooks()` cover the previously missing API families. Webhook creation and secret rotation return `WebhookSecret` with the subscription and one-time signing secret; store the secret securely. Existing numeric document/approval relationship IDs are legacy references, not task-assignee UUIDs or necessarily another endpoint's public ID.

## Paging, errors and retries

The checked [operation inventory](contracts/api-v1.json) covers every supported public operation. `PaginatedResult` iterates the current page only; explicitly request the next page using `currentPage`, `lastPage` and `perPage`. Lookup and resource pagination envelopes are both supported.

New task and milestone edits use versions. A stale version or mismatched creation operation ID raises `ConflictException` (HTTP 409); reload and reconcile. Recurring-charge conflicts retain HTTP 422 validation details. `RateLimitException` (429) exposes `headers['retry-after']` when supplied. All API exceptions expose `statusCode`, `responseBody` and normalized response headers. Transport failures and malformed successful JSON also throw rather than returning an empty result.

The SDK performs no automatic retries. In particular, never blindly repeat email sends, approval decisions, secret rotation or ambiguous non-idempotent writes. Creation, duplication, revision and conversion operations that accept an operation UUID can be retried with the same UUID and identical input. Commercial receipts are scoped by team, caller and operation.

Update DTOs distinguish omitted values (`Optional`) from explicit null. Expense uploads send a JSON `payload` multipart field beside the file, preserving nulls and booleans; this requires the matching updated server. Current financial entities use `currency`; `Project::feeCurrency` is retained only for compatibility with old responses.

Task webhooks use the existing signed version-1 envelope, public record IDs, versions and changed field names. Subscribe to task, comment, checklist, attachment and milestone events as needed; fetch current authorized state after delivery. Recurring schedules and charges have no new webhook events in this release; generated invoices retain their invoice events.

Task recurrence, templates, bulk operations, follow/reactions, user administration, time tracking and MCP implementation are intentionally outside this expansion.

### Articles

```php
$articles = $aeglio->articles()->list(search: 'Labour', active: true);
$article = $aeglio->articles()->create(new \Aeglio\Dto\ArticleData(
    name: 'Labour', currency: 'EUR', unit: 'hour', unitPlural: 'hours', defaultSalesPrice: '25.1200',
));
$article = $aeglio->articles()->find($article->id);
$article->update(new \Aeglio\Dto\UpdateArticleData(active: false)); // Deactivate; no delete endpoint.
$article->update(new \Aeglio\Dto\UpdateArticleData(unitPlural: null)); // Explicitly clear the plural.
```

Article operations require `articles:read/create/update` respectively, plus the caller's catalogue role permissions. List filters include name/code search, active, sellable and purchasable; page size is 1–100. Prices are nullable four-decimal strings. Category references use the Expense Categories API ID; tax references use the Tax Rates API ID. Article IDs are public team-local IDs and must not be substituted into the legacy estimate-row `articleId` field, which still uses an internal reference. Invoice rows do not support article linking.

Invoice/estimate/recurring-charge row DTOs and entities carry optional `unitPlural` snapshots alongside `unit`. Absolute quantity 1 uses the singular; other quantities use the plural when present. Blank plurals fall back to the singular. Existing rows and signed documents are not rewritten when catalogue labels change. Creating an Article is not idempotent; the SDK does not automatically retry ambiguous writes.
