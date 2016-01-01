<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMailNotifications extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mail_notifications', function ($table) {
            $table->integer('user_id')->unique();
            $table->integer('comment_notification_flag')->default(0);
            $table->integer('favorite_notification_flag')->default(0);
            $table->integer('good_notification_flag')->default(0);
            $table->integer('edit_notification_flag')->default(0);
            $table->timestapms();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_mail_notifications');
    }

}
