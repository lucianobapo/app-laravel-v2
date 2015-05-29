<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedOrderTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shared_order_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->softDeletes();

            $table->string('tipo')->index();
            $table->string('descricao')->nullable();
		});

//        Schema::create('orders_has_shared_order_types',function(Blueprint $table){
//            $table->timestamps();
//
//            $table->integer('order_id')->unsigned()->index();
//            $table->foreign('order_id')->references('id')
//                ->on('orders')
//                ->onDelete('restrict')
//                ->onUpdate('cascade');
//
//            $table->integer('order_type_id')->unsigned()->index();
//            $table->foreign('order_type_id')->references('id')
//                ->on('shared_order_types')
//                ->onDelete('restrict')
//                ->onUpdate('cascade');
//        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('orders_has_shared_order_types');
		Schema::drop('shared_order_types');
	}

}
