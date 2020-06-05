<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerimetersWebsites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('perimeters_websites')) {
            Schema::create('perimeters_websites', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('perimeter_id')->unsigned()->index();
                $table->integer('website_id')->unsigned()->index();
            });
        }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perimeter_website');
    }
}
