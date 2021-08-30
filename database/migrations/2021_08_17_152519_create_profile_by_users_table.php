<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_by_users', function (Blueprint $table) {
            $table->id();
		$table->unsignedBigInteger('profiles_id');
		$table->foreign('profiles_id')
			->references('id')
			->on('profiles')
            ->onDelete('cascade');	
		$table->unsignedBigInteger('user_id');
		$table->foreign('user_id')
			->references('id')
			->on('users')
            ->onDelete('cascade');
            $table->bigInteger('order_profiles')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_by_users');
    }
}
