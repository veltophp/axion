<?php

use Velto\Axion\Migration;

class CreateBlogCategoriesTable extends Migration
{
    public function up()
    {
        $this->createTable('blog_categories', function ($table) {
            $table->id();
            $table->string('category_id');
            $table->string('category');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->dropTable('blog_categories');
    }
}