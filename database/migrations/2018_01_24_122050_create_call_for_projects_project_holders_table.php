<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallForProjectsProjectHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_for_projects_project_holders', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('project_holder_id')->unsigned()->index();
	        $table->integer('call_for_project_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_for_projects_project_holders');
    }
}
