<?php

use Velto\Axion\Migration;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        $this->createTable('blogs', function ($table) {
            $table->id();
            $table->string('post_id');
            $table->string('user_id');
            $table->string('category_id')->nullable();
            $table->string('topic_id')->nullable();
            $table->string('title');
            $table->longText('content');
            $table->string('image');
            $table->string('slug');
            $table->string('status');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('blogs');
    }
}