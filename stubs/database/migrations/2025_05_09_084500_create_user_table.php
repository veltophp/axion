<?php

use Velto\Axion\Migration;

class CreateUserTable extends Migration {

    public function up()
    {
        $this->createTable('users', function ($table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->string('picture')->nullable();
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->boolean('email_verified')->default(false);
            $table->timestamps();
        });
        
    }

    public function down()
    {
        $this->dropTable('users');
    }
}