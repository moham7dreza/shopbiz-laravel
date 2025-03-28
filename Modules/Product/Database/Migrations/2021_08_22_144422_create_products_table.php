<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code_kala')->unique()->nullable();
            $table->string('name');
            $table->text('introduction');
            $table->string('slug')->unique()->nullable();
            $table->text('image');
            $table->decimal('weight', 10, 2);
            $table->decimal('length', 10, 1)->comment('cm unit');
            $table->decimal('width', 10, 1)->comment('cm unit');
            $table->decimal('height', 10, 1)->comment('cm unit');
            $table->decimal('price', 20, 3);
            $table->tinyInteger('active_discount_percentage')->nullable();
            $table->float('rating')->default(0);
            $table->tinyInteger('popular')->default(0);
            $table->tinyInteger('selected')->default(0);
            $table->tinyInteger('marketable')->default(0)->comment('1 => marketable, 0 => is not marketable');
            $table->smallInteger('sold_number')->default(0);
            $table->smallInteger('frozen_number')->default(0);
            $table->smallInteger('marketable_number')->default(0);
            $table->integer('views_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('product_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('published_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
