<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItemAttribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cart_item_id', 'attribute_id', 'attribute_value_id', 'value'];

    protected $table = 'cart_item_selected_attributes';
}
