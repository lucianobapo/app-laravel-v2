<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedStatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shared_stats', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->softDeletes();

            $table->string('mandante')->index();

            $table->string('status');
		});

        Schema::create('products_has_shared_stats',function(Blueprint $table){
            $table->timestamps();

            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')
                ->on('products')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')
                ->on('shared_stats')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('cost_allocates_has_shared_stats',function(Blueprint $table){
            $table->timestamps();

            $table->integer('cost_allocate_id')->unsigned()->index();
            $table->foreign('cost_allocate_id')->references('id')
                ->on('cost_allocates')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')
                ->on('shared_stats')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('partners_has_shared_stats',function(Blueprint $table){
            $table->timestamps();

            $table->integer('partner_id')->unsigned()->index();
            $table->foreign('partner_id')->references('id')
                ->on('partners')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')
                ->on('shared_stats')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('orders_has_shared_stats',function(Blueprint $table){
            $table->timestamps();

            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')
                ->on('orders')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')
                ->on('shared_stats')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('item_orders_has_shared_stats',function(Blueprint $table){
            $table->timestamps();

            $table->integer('item_id')->unsigned()->index();
            $table->foreign('item_id')->references('id')
                ->on('item_orders')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->integer('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')
                ->on('shared_stats')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products_has_shared_stats');
		Schema::drop('cost_allocates_has_shared_stats');
		Schema::drop('partners_has_shared_stats');
		Schema::drop('orders_has_shared_stats');
		Schema::drop('item_orders_has_shared_stats');
		Schema::drop('shared_stats');
	}

}
