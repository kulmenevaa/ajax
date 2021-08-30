<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionByUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direction_by_users', function (Blueprint $table) {
		$table->id();
		$table->unsignedBigInteger('directions_id');
		$table->foreign('directions_id')
			->references('id')
			->on('directions')
            ->onDelete('cascade');
		$table->unsignedBigInteger('user_id');
		$table->foreign('user_id')
			->references('id')
			->on('users')
            ->onDelete('cascade');
		$table->bigInteger('order_directions')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direction_by_users');
    }
}
