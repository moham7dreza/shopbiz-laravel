<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('summary');
            $table->text('body');
            $table->string('keywords')->nullable();
            $table->text('image');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('popular')->default(0);
            $table->tinyInteger('selected')->default(0);
            $table->tinyInteger('commentable')->default(0)->comment('0 => uncommentable, 1 => commentable');
            $table->timestamp('published_at');
            $table->foreignId('author_id')->constrained('users');
            $table->foreignId('category_id')->constrained('post_categories');
            $table->tinyInteger('time_to_read')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->double('rating')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
