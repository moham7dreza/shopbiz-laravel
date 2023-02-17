<?php

namespace Modules\Payment\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\Payment;

class PaymentRepoEloquent implements PaymentRepoEloquentInterface
{
    /**
     * @return Builder
     */
    public function offline(): Builder
    {
        return $this->query()->offlineType()->latest();
    }

    /**
     * @return Builder
     */
    public function online(): Builder
    {
        return $this->query()->onlineType()->latest();
    }

    /**
     * @return Builder
     */
    public function cash(): Builder
    {
        return $this->query()->cashType()->latest();
    }

    /**
     * Find payment by invoice id.
     *
     * @param  string|int $invoiceId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function findByInvoiceId(int $invoiceId)
    {
        return Payment::query()->where('invoice_id', $invoiceId)->firstOrFail();
    }

    /**
     * Get the latest roles with permissions.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete role by id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * @return int
     */
    public function paymentsCount(): int
    {
        return $this->query()->count();
    }

    /**
     * @return int
     */
    public function notPaidPaymentsCount(): int
    {
        return $this->query()->notPaid()->count();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Payment::query();
    }
}
