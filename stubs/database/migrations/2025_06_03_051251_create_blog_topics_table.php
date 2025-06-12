<?php

use Velto\Axion\Migration;

class CreateBlogTopicsTable extends Migration
{
    public function up()
    {
        $this->createTable('blog_topics', function ($table) {
            $table->id();
            $table->string('topic_id');
            $table->string('topic');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('blog_topics');
    }
}