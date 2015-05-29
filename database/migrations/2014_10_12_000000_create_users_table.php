<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('mandante')->index();

//            $table->integer('partner_id')->unsigned()->index()->nullable();
//            $table->foreign('partner_id')
//                ->references('id')
//                ->on('partners')
//                ->onDelete('restrict')
//                ->onUpdate('cascade');

			$table->string('name');
			$table->string('avatar')->nullable();
//			$table->string('email')->unique();
			$table->string('password', 60)->nullable();

            $table->string('username')->nullable();
            $table->string('email')->unique()->default(time() . '-no-reply@ilhanet.com');
//            $table->string('email')->unique()->default(time() . '-no-reply@EasyAuthenticator.com')->change();
//            $table->string('avatar');
            $table->string('provider')->default('laravel');
            $table->string('provider_id')->unique()->nullable();
            $table->string('activation_code')->nullable();
            $table->integer('active')->nullable();

			$table->rememberToken();
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
		Schema::drop('users');
	}

}
