<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedOrderPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shared_order_payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->softDeletes();

            $table->string('pagamento')->index();
            $table->string('descricao')->nullable();
		});

//        Schema::create('orders_has_shared_order_payments',function(Blueprint $table){
//            $table->timestamps();
//
//            $table->integer('order_id')->unsigned()->index();
//            $table->foreign('order_id')->references('id')
//                ->on('orders')
//                ->onDelete('restrict')
//                ->onUpdate('cascade');
//
//            $table->integer('order_payment_id')->unsigned()->index();
//            $table->foreign('order_payment_id')->references('id')
//                ->on('shared_order_payments')
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
//		Schema::drop('orders_has_shared_order_payments');
		Schema::drop('shared_order_payments');
	}

}
