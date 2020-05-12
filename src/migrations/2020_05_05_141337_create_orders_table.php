<?php

use Fixme\Ordering\Entities\Values\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
	protected $predecessor;

	public function __construct() {
		$this->predecessor = config('ordering.database_predecessor', '');
	}

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {	
	
        //open, completed, closed, stuck
        Schema::create($this->predecessor.'orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buyer_id')->unsigned();
            $table->string('buyer_type');
            $table->integer('seller_id')->unsigned();
            $table->string('seller_type');
            $table->string('currency');
            $table->string('currency_value')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
			$table->softDeletes();
        });

        Schema::create($this->predecessor.'order_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on($this->predecessor.'orders')->onDelete('cascade');
            $table->string('phone_number')->nullable();
            $table->string('address_line')->nullable();
            $table->timestamps();
        });


        Schema::create($this->predecessor.'order_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on($this->predecessor.'orders')->onDelete('cascade');
            $table->integer('updater_id')->unsigned();
            $table->string('updater_type');
            $table->enum('status', array_values(Status::getStatuses()));
            $table->timestamps();
			$table->softDeletes();
        });

        Schema::create($this->predecessor.'order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on($this->predecessor.'orders')->onDelete('cascade');
            $table->string('notes')->nullable();
            $table->integer('item_id')->unsigned();
            $table->string('item_type');
			$table->integer('quantity')->unsigned();
            $table->string('description');
            $table->float('unit_price');
            $table->float('price');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
 		Schema::dropIfExists($this->predecessor.'order_items');
 		Schema::dropIfExists($this->predecessor.'order_addresses');
 		Schema::dropIfExists($this->predecessor.'order_status');
 		Schema::dropIfExists($this->predecessor.'orders');
    }
}
