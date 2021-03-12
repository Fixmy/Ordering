<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedFlagToItems extends Migration
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
        Schema::table($this->predecessor.'order_items', function (Blueprint $table) {			
            $table->tinyInteger('updated')->default(0);			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table($this->predecessor.'order_items', function (Blueprint $table) {
    	    $table->dropColumn(['updated']);
    	});
    }
}
