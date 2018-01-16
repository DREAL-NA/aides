<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->unsigned();
	        $table->string('name');
	        $table->text('description')->nullable();
            $table->timestamps();
	        $table->softDeletes();

	        $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('beneficiaries', function(Blueprint $table) {
		    $table->dropIndex([ 'type' ]);
	    });
        Schema::dropIfExists('beneficiaries');
    }
}
