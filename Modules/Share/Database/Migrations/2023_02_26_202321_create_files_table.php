<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('fileable_type');
            $table->unsignedBigInteger('fileable_id');
            $table->tinyInteger('status')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('file_path');
            $table->bigInteger('file_size');
            $table->string('file_type');
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
        Schema::dropIfExists('files');
    }
};
