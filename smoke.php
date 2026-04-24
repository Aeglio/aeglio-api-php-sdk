<?php

declare(strict_types=1);

$autoload = __DIR__.'/vendor/autoload.php';

if (!is_file($autoload)) {
    fwrite(STDERR, "Run composer install before running smoke.php.\n");
    exit(1);
}

require $autoload;

use Aeglio\Aeglio;
use Aeglio\Dto\ClientData;
use Aeglio\Dto\ExpenseCategoryData;
use Aeglio\Dto\ExpenseData;
use Aeglio\Dto\ExpensePaymentData;
use Aeglio\Dto\InvoiceData;
use Aeglio\Dto\InvoicePaymentData;
use Aeglio\Dto\InvoiceRowData;
use Aeglio\Dto\ProjectData;
use Aeglio\Dto\TaxRateData;

$token = getenv('AEGLIO_TOKEN');

if (!$token) {
    fwrite(STDERR, "AEGLIO_TOKEN is required.\n");
    exit(1);
}

$sdk = new Aeglio(token: $token);
$suffix = (string) time();

$category = $sdk->expenseCategories()->create(new ExpenseCategoryData(
    name: 'SDK Smoke '.$suffix,
));

$expense = $sdk->expenses()->create(new ExpenseData(
    number: 'SDK-SMOKE-'.$suffix,
    amount: 12.34,
    date: date('Y-m-d'),
    categoryId: $category->id,
    notes: 'SDK smoke test',
    billable: false,
));

$payment = $expense->addPayment(new ExpensePaymentData(
    sum: 12.34,
    paidAt: date('Y-m-d'),
    notes: 'SDK smoke payment',
));

$fetchedExpense = $sdk->expenses()->find($expense->id);

$client = $sdk->clients()->create(new ClientData(
    name: 'SDK Smoke Client '.$suffix,
    locale: 'en_US',
));

$taxRate = $sdk->taxRates()->create(new TaxRateData(
    title: 'SDK Smoke VAT '.$suffix,
    percentage: 22.0,
));

$project = $sdk->projects()->create(new ProjectData(
    clientId: $client->id,
    name: 'SDK Smoke Project '.$suffix,
    type: 'time',
    notes: 'SDK project smoke test',
));

$invoice = $sdk->invoices()->create(new InvoiceData(
    clientId: $client->id,
    number: 'SDK-INV-'.$suffix,
    issuedAt: date('Y-m-d'),
    dueAt: date('Y-m-d', strtotime('+7 days')),
    notes: 'SDK invoice smoke test',
    hasTax: false,
    rows: [
        new InvoiceRowData(
            type: 'regular',
            title: 'SDK Smoke Service',
            quantity: 1,
            price: 25.00,
            taxRateId: $taxRate->id,
        ),
    ],
));

$invoicePayment = $invoice->addPayment(new InvoicePaymentData(
    sum: 25.00,
    paidAt: date('Y-m-d'),
    notes: 'SDK invoice payment',
));

$pdf = $invoice->downloadPdf();

echo json_encode([
    'category_id' => $category->id,
    'expense_id' => $expense->id,
    'payment_id' => $payment->id,
    'expense_state' => $fetchedExpense->state,
    'payments_total' => $fetchedExpense->paymentsTotal,
    'client_id' => $client->id,
    'tax_rate_id' => $taxRate->id,
    'project_id' => $project->id,
    'invoice_id' => $invoice->id,
    'invoice_payment_id' => $invoicePayment->id,
    'invoice_total' => $invoice->total,
    'pdf_bytes' => strlen($pdf),
], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR).PHP_EOL;
