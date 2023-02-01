<?php

namespace Modules\Share\Traits;

use Illuminate\Support\Str;

trait HasFaPropertiesTrait
{
    /**
     * @return string
     */
    public function limitedName(): string
    {
        return Str::limit($this->name, 50) ?? '-';
    }

    // text property

    /**
     * @return string
     */
    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
    }

    /**
     * @param int $limit
     * @return string
     */
    public function limitedSummary(int $limit = 150): string
    {
        return strip_tags(Str::limit($this->summary, $limit));
    }

    /**
     * @return string
     */
    public function limitedBody(): string
    {
        return Str::limit($this->body, 150);
    }

    /**
     * @return mixed|string
     */
    public function tagLessSummary(): mixed
    {
        return strip_tags($this->summary) ?? $this->summary ?? '-';
    }

    /**
     * @return mixed|string
     */
    public function tagLessIntro(): mixed
    {
        return strip_tags($this->introduction) ?? $this->introduction ?? '-';
    }

    /**
     * @return string
     */
    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50);
    }

    /**
     * @return string
     */
    public function textProductName(): string
    {
        return $this->product->name ?? 'نام محصول یافت نشد.';
    }

    /**
     * @return string
     */
    public function textCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }

    /**
     * @return mixed|string
     */
    public function textPosition(): mixed
    {
        return self::$positions[$this->position] ?? 'مکان بنر مشخص نیست.';
    }

    /**
     * @return string
     */
    public function colorName(): string
    {
        return $this->color->color_name ?? '-';
    }

    /**
     * @return string
     */
    public function guaranteeName(): string
    {
        return $this->guarantee->name ?? '-';
    }

    /**
     * @return string
     */
    public function textParentName(): string
    {
        return is_null($this->parent_id) ? 'دسته اصلی' : $this->parent->name;
    }

    /**
     * @return string
     */
    public function textAuthorName(): string
    {
        return $this->user->fullName ?? 'نویسنده ندارد.';
    }

    /**
     * @return string
     */
    public function textParentBody(): string
    {
        return is_null($this->parent_id) ? '-' : Str::limit($this->parent->body);
    }

    /**
     * @return string|int
     */
    public function faAmount(): string|int
    {
        return priceFormat($this->amount). ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function deliveryTime(): string
    {
        return convertEnglishToPersian($this->delivery_time) . ' - ' . $this->delivery_time_unit . ' کاری'?? 'روز کاری تعریف نشده.';
    }

    /**
     * @return string
     */
    public function explainDeliveryTime(): string
    {
        return 'تامین کالا از ' . convertEnglishToPersian($this->delivery_time) . ' ' . $this->delivery_time_unit . ' کاری آینده';
    }

    /**
     * @return string
     */
    public function getFaPercentage(): string
    {
        return ' % ' . convertEnglishToPersian($this->percentage) ?? $this->percentage . ' %';
    }

    /**
     * @return string
     */
    public function getFaDiscountCeiling(): string
    {
        return priceFormat($this->discount_ceiling) . ' تومان ' ?? $this->discount_ceiling . ' تومان ';
    }

    /**
     * @return string
     */
    public function minimalOrderAmountFaPrice(): string
    {
        return priceFormat($this->minimal_order_amount) . ' تومان ' ?? $this->minimal_order_amount . ' تومان ';
    }

    /**
     * @return string
     */
    public function getUserAssignedCopan(): string
    {
        return $this->user->fullName ?? '-';
    }

    /**
     * @return string
     */
    public function getFaAmount(): string
    {
        return $this->amount_type == self::AMOUNT_TYPE_PERCENTAGE ? ' % ' . convertEnglishToPersian($this->amount)
            : priceFormat($this->amount) . ' تومان';
    }

    /**
     * @return string
     */
    public function textAmountType(): string
    {
        return $this->amount_type == self::AMOUNT_TYPE_PERCENTAGE ? 'درصدی' : 'عددی';
    }

    /**
     * @return string
     */
    public function textDiscountType(): string
    {
        return $this->type == self::COPAN_TYPE_PUBLIC ? 'عمومی' : 'خصوصی';
    }

    /**
     * @return string
     */
    public function limitedQuestion(): string
    {
        return Str::limit($this->question, 50);
    }

    /**
     * @return string
     */
    public function limitedAnswer(): string
    {
        return Str::limit($this->answer, 50);
    }

    /**
     * @return string
     */
    public function limitedSubject(): string
    {
        return Str::limit($this->subject, 50);
    }

    /**
     * @param string $unit
     * @return string|array
     */
    public function getFaFileSize(string $unit = "KB"): string|array
    {
        return convert($this->file_size, $unit);
    }

    /**
     * @return int|string
     */
    public function orderFinalAmountFaPrice(): int|string
    {
        return priceFormat($this->order_final_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderTotalProductsDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_total_products_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderFinalFaPrice(): int|string
    {
        return priceFormat($this->order_final_amount -  $this->order_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderDeliveryAmountFaPrice(): int|string
    {
        return priceFormat($this->delivery_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderCopanDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_copan_discount_amount) . ' تومان'
            ?? convertEnglishToPersian(0);
    }

    /**
     * @return int|string
     */
    public function orderCommonDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_common_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function deliveryMethodName(): string
    {
        return $this->delivery->name ?? '-';
    }

    /**
     * @return string
     */
    public function customerName(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function textCustomerAddress(): string
    {
        return $this->address->address ?? 'آدرس مشتری یافت نشد.';
    }

    /**
     * @return string
     */
    public function textCustomerCity(): string
    {
        return $this->address->city->name ?? 'آدرس مشتری یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerPostalCode(): array|string
    {
        return convertEnglishToPersian($this->address->postal_code) ?? 'کد پستی یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerUnit(): array|string
    {
        return convertEnglishToPersian($this->address->unit) ?? 'واحد یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerNo(): array|string
    {
        return convertEnglishToPersian($this->address->no) ?? 'شماره پلاک یافت نشد.';
    }

    /**
     * @return string
     */
    public function recipientFName(): string
    {
        return $this->address->recipient_first_name ?? 'نام گیرنده کالا یافت نشد.';
    }

    /**
     * @return string
     */
    public function recipientLName(): string
    {
        return $this->address->recipient_last_name ?? 'نام گیرنده کالا یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerFaMobile(): array|string
    {
        return convertEnglishToPersian($this->address->mobile) ?? 'شماره موبایل یافت نشد.';
    }

    /**
     * @return string
     */
    public function orderSendDate(): string
    {
        return jalaliDate($this->delivery_time) ?? 'تاریخ ارسال یافت نشد.';
    }

    /**
     * @return string
     */
    public function customerUsedCopan(): string
    {
        return $this->copan->code ?? 'کوپن تخفیف ندارد.';
    }

    public function usedCommonDiscountTitle()
    {
        return $this->commonDiscount->title ?? 'عنوان تخفیف عمومی یافت نشد.';
    }

    /**
     * @return array|int|string
     */
    public function amazingSaleFaPercentage(): array|int|string
    {
        return convertEnglishToPersian($this->amazingSale->percentage) . ' % ' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderItemAmazingSaleDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->amazing_sale_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function orderItemFaNumber(): array|int|string
    {
        return convertEnglishToPersian($this->number) . ' عدد' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderItemFinalProductFaPrice(): int|string
    {
        return priceFormat($this->final_product_price) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderItemFinalTotalFaPrice(): int|string
    {
        return priceFormat($this->final_total_price) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderItemProductColorName(): int|string
    {
        return $this->color->color_name ?? 'رنگ ندارد.';
    }

    /**
     * @return int|string
     */
    public function orderItemProductGuaranteeName(): int|string
    {
        return $this->guarantee->name ?? 'گارانتی ندارد.';
    }

    /**
     * @return string
     */
    public function textAttributeName(): string
    {
        return $this->categoryAttribute->name ?? 'فرم کالا ندارد.';
    }

    /**
     * @return string
     */
    public function attributeValue(): string
    {
        return $this->categoryAttributeValue->value ?? 'مقداری برای فرم کالا یافت نشد.';
    }

    /**
     * @return int|string
     */
    public function paymentAmountFaPrice(): int|string
    {
        return priceFormat($this->paymentable->amount) . ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function payDate(): string
    {
        return jalaliDate($this->paymentable->pay_date) ?? 'تاریخ پرداخت یافت نشد.';
    }

    /**
     * @return string
     */
    public function cashReceiverName(): string
    {
        return $this->paymentable->cash_receiver ?? '-';
    }

    /**
     * @return int|string
     */
    public function customerId(): int|string
    {
        return convertEnglishToPersian($this->user->id) ?? '-';
    }

    /**
     * @return string
     */
    public function getFaPriceIncrease(): string
    {
        return priceFormat($this->price_increase) . ' تومان ';
    }

    /**
     * @return int|string
     */
    public function getFaWeight(): int|string
    {
        return convertEnglishToPersian($this->weight) . ' کیلو' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaMarketableNumber(): int|string
    {
        return convertEnglishToPersian($this->marketable_number) . ' عدد' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaSoldNumber(): int|string
    {
        return convertEnglishToPersian($this->sold_number) . ' عدد' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaFrozenNumber(): int|string
    {
        return convertEnglishToPersian($this->frozen_number) . ' عدد' ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function getFaAmazingSalesPercentage(): array|int|string
    {
        return '% ' . convertEnglishToPersian($this->activeAmazingSales()->percentage) ?? 0;
    }

    /**
     * @return string
     */
    public function getFaPrice(): string
    {
        return priceFormat($this->price) . ' تومان ';
    }

    /**
     * @return string
     */
    public function limitedKeywords(): string
    {
        return Str::limit($this->keywords, 50);
    }

    /**
     * @return array|string
     */
    public function faId(): array|string
    {
        return convertEnglishToPersian($this->id);
    }

    /**
     * @return string
     */
    public function textUserName(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function textParentTitle(): string
    {
        return !empty($this->parent->subject) ? Str::limit($this->parent->subject, 50) : '-';
    }

    /**
     * @return string
     */
    public function textReferenceName(): string
    {
        return $this->admin->user->fullName ?? $this->admin->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function textPriorityName(): string
    {
        return $this->priority->name ?? 'اولویت ندارد';
    }

    /**
     * @return string
     */
    public function textStatusEmailVerifiedAt(): string
    {
        if ($this->email_verified_at) return 'تایید شده';

        return 'تایید نشده';
    }

    /**
     * @return string
     */
    public function textActivationStatus(): string
    {
        return $this->activation === self::ACTIVATE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return string
     */
    public function faMobileNumber(): string
    {
        return '۰' . convertEnglishToPersian($this->mobile);
    }

}
