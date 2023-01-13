<?php

namespace Modules\Payment\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Page\Entities\Page;
use Modules\Payment\Entities\Payment;

class PaymentRepoEloquent implements PaymentRepoEloquentInterface
{
    /**
     * @return Builder
     */
    public function offline(): Builder
    {
        return $this->query()->where('paymentable_type', 'Modules\Payment\Entities\OfflinePayment')->latest();
    }

    /**
     * @return Builder
     */
    public function online(): Builder
    {
        return $this->query()->where('paymentable_type', 'Modules\Payment\Entities\OnlinePayment')->latest();
    }

    /**
     * @return Builder
     */
    public function cash(): Builder
    {
        return $this->query()->where('paymentable_type', 'Modules\Payment\Entities\CashPayment')->latest();
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
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Payment::query();
    }
}
