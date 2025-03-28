<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('logo')->nullable();
            $table->text('icon')->nullable();
            $table->smallInteger('low_count_products')->default(0)->comment('count of products which have low marketable number');
            $table->float('rating_score')->default(0)->comment('calculate avg rating of all items');
            $table->text('author')->nullable();
            $table->text('address')->nullable();
            $table->text('mobile')->nullable();
            $table->text('email')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('social_media')->nullable();
            $table->text('bank_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
