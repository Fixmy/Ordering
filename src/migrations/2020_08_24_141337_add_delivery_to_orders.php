<?php

use Fixme\Ordering\Entities\Values\OrderStatus;
use Fixme\Ordering\Entities\Values\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryToOrders extends Migration
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
        Schema::table($this->predecessor.'orders', function (Blueprint $table) {
			$table->float('delivery_charge')->nullable();
			$table->string('country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table($this->predecessor.'orders', function (Blueprint $table) {
    	    $table->dropColumn(['delivery_charge', 'country_code']);
    	});
    }
}
