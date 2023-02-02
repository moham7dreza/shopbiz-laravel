<?php

namespace Modules\Share\Traits;

trait HasActivityLogTrait
{
    /**
     * @param $model
     * @param string $table
     * @param string $event
     * @return void
     */
    public static function userActivityLog($model, string $table = "users", string $event = "created"): void
    {
        switch ($event) {
            case "created" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'name' => $model->fullName,
                        'email' => $model->email,
                        'activation' => $model->activation == 1 ? 'فعال' : 'غیر فعال',
                        'user_type' => $model->user_type == 1 ? 'ادمین' : 'کاربر',
                        'email_verified' => is_null($model->email_verified_at) ? 'تایید شده' : 'تایید نشده',
                    ])->log(" کاربری با نام " . $model->fullName . " ایجاد شد ");
                break;
            case "updated" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'name' => $model->fullName,
                        'email' => $model->email,
                        'activation' => $model->activation == 1 ? 'فعال' : 'غیر فعال',
                        'user_type' => $model->user_type == 1 ? 'ادمین' : 'کاربر',
                        'email_verified' => !is_null($model->email_verified_at) ? 'تایید شده' : 'تایید نشده',
                    ])->log(" کاربری با نام " . $model->name . " ویرایش شد ");
                break;
            case "deleted" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'name' => $model->name,
                        'email' => $model->email
                    ])->log(" کاربری با نام " . $model->name . " حذف شد ");
                break;
        }
    }

    /**
     * @param $model
     * @param string $table
     * @param string $event
     * @return void
     */
    public static function productActivityLog($model, string $table = "products", string $event = "created"): void
    {
        switch ($event) {
            case "created" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'name' => $model->name,
                        'introduction' => strip_tags(str_replace(PHP_EOL, '<br/>', $model->introduction)),
                        'price' => priceFormat($model->price),
                        'status' => $model->status == 1 ? 'محصول فعال' : 'محصول غیر فعال',
                        'marketable' => $model->marketable == 1 ? 'محصول قابل فروش' : 'محصول غیر قابل فروش',
                        'brand' => $model->brand->originl_name . '-' . $model->brand->persian_name ?? 'برند ندارد',
                        'category' => $model->category->name ?? 'دسته بندی ندارد',
                        'created_at' => $model->getFaCreatedDate(),
                    ])->log(" محصول با نام " . $model->name . " ایجاد شد ");
                break;
            case "updated" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'name' => $model->name,
                        'email' => $model->email
                    ])->log(" کاربری با نام " . $model->name . " ویرایش شد ");
                break;
            case "deleted" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'name' => $model->name,
                        'email' => $model->email
                    ])->log(" کاربری با نام " . $model->name . " حذف شد ");
                break;
        }
    }

    /**
     * @param $request
     * @param $model
     * @param string $table
     * @param string $event
     * @return void
     */
    public static function ProductWarehouseReport($request, $model, string $table = "products", string $event = "add-to-store"): void
    {
        switch ($event) {
            case "add-to-store" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'نام کالا ' => $model->name,
                        'فرد دریافت کننده کالا ' => $request->receiver,
                        'فرد تحویل دهنده کالا ' => $request->deliverer,
                        'توضیحات ' => $request->description,
                        'تعداد دریافت شده ' => convertEnglishToPersian($request->marketable_number),
                        'تعداد کالاهای قابل فروش ' => convertEnglishToPersian($model->marketable_number),
                    ])->log('موجودی انبار کالا افزایش یافت');
                break;
            case "update-store" :
                activity()->causedBy(auth()->id())->performedOn($model)->useLog($table)
                    ->withProperties([
                        'نام کالا ' => $model->name,
                        'تعداد کالاهای قابل فروش ' => convertEnglishToPersian($request->marketable_number),
                        'تعداد کالاهای رزرو ' => convertEnglishToPersian($request->frozen_number),
                        'تعداد کالاهای فروخته شده ' => convertEnglishToPersian($request->sold_number),
                    ])->log('موجودی انبار کالا بروزرسانی شد');
                break;
        }
    }
}
