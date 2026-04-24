<?php

declare(strict_types=1);

namespace Aeglio\Resource;

use Aeglio\Collection\PaginatedResult;
use Aeglio\Dto\InvoiceData;
use Aeglio\Dto\InvoicePaymentData;
use Aeglio\Dto\SendInvoiceData;
use Aeglio\Dto\UpdateInvoiceData;
use Aeglio\Dto\UpdateInvoicePaymentData;
use Aeglio\Entity\Invoice;
use Aeglio\Entity\InvoicePayment;
use Aeglio\Entity\SendInvoiceResult;

final class Invoices extends BaseResource
{
    /**
     * @return PaginatedResult<Invoice>
     */
    public function list(?array $state = null, int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'invoices',
            query: [
                'state' => $state,
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): Invoice => Invoice::fromArray($this->client, $item),
        );
    }

    public function find(int $id): Invoice
    {
        $response = $this->http->json('GET', 'invoices/'.$id);

        return Invoice::fromArray($this->client, $response['data']);
    }

    public function create(InvoiceData $data): Invoice
    {
        $response = $this->http->json('POST', 'invoices', json: $data->toArray());

        return Invoice::fromArray($this->client, $response['data']);
    }

    public function update(int $id, UpdateInvoiceData $data): Invoice
    {
        $response = $this->http->json('PATCH', 'invoices/'.$id, json: $data->toArray());

        return Invoice::fromArray($this->client, $response['data']);
    }

    public function delete(int $id): void
    {
        $this->http->json('DELETE', 'invoices/'.$id);
    }

    public function addPayment(int $invoiceId, InvoicePaymentData $data): InvoicePayment
    {
        $response = $this->http->json(
            'POST',
            'invoices/'.$invoiceId.'/payments',
            json: $data->toArray(),
        );

        return InvoicePayment::fromArray($this->client, $response['data']);
    }

    public function updatePayment(int $invoiceId, int $paymentId, UpdateInvoicePaymentData $data): InvoicePayment
    {
        $response = $this->http->json(
            'PATCH',
            'invoices/'.$invoiceId.'/payments/'.$paymentId,
            json: $data->toArray(),
        );

        return InvoicePayment::fromArray($this->client, $response['data']);
    }

    public function deletePayment(int $invoiceId, int $paymentId): void
    {
        $this->http->json('DELETE', 'invoices/'.$invoiceId.'/payments/'.$paymentId);
    }

    /**
     * @return PaginatedResult<InvoicePayment>
     */
    public function listPayments(int $invoiceId, int $perPage = 50, int $page = 1): PaginatedResult
    {
        return $this->paginated(
            path: 'invoices/'.$invoiceId.'/payments',
            query: [
                'per_page' => $perPage,
                'page' => $page,
            ],
            mapper: fn (array $item): InvoicePayment => InvoicePayment::fromArray($this->client, $item),
        );
    }

    public function findPayment(int $invoiceId, int $paymentId): InvoicePayment
    {
        $response = $this->http->json('GET', 'invoices/'.$invoiceId.'/payments/'.$paymentId);

        return InvoicePayment::fromArray($this->client, $response['data']);
    }

    public function send(int $invoiceId, SendInvoiceData $data): SendInvoiceResult
    {
        $response = $this->http->json(
            'POST',
            'invoices/'.$invoiceId.'/send',
            json: $data->toArray(),
        );

        return SendInvoiceResult::fromArray($response);
    }

    public function downloadPdf(int $invoiceId): string
    {
        return $this->http->raw('GET', 'invoices/'.$invoiceId.'/pdf');
    }
}
