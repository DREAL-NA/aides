<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallForProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls_for_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subthematic_id')->unsigned();
            $table->string('name');
            $table->timestamp('closing_date')->nullable();
	        $table->integer('project_holder_id')->unsigned();
	        $table->text('project_holder_contact')->nullable();
	        $table->integer('perimeter_id')->unsigned();
	        $table->text('objectives')->nullable();
	        $table->integer('beneficiary_id')->unsigned();
	        $table->text('beneficiary_comments')->nullable();
	        $table->text('allocation')->nullable();
	        $table->text('technical_relay')->nullable();
	        $table->text('website_url')->nullable();
	        $table->integer('editor_id')->unsigned();

	        $table->timestamps();
			$table->softDeletes();

	        $table->index('subthematic_id');
	        $table->index('project_holder_id');
	        $table->index('perimeter_id');
	        $table->index('beneficiary_id');
	        $table->index('editor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('calls_for_projects', function(Blueprint $table) {
		    $table->dropIndex([ 'subthematic_id', 'project_holder_id', 'perimeter_id', 'beneficiary_id', 'editor_id' ]);
	    });
        Schema::dropIfExists('calls_for_projects');
    }
}
