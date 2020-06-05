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
        if (!Schema::hasTable('calls_for_projects')) {
            Schema::create('calls_for_projects', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('thematic_id')->unsigned();
                $table->integer('subthematic_id')->unsigned()->nullable();
                $table->string('name');
                $table->timestamp('closing_date')->nullable();
                $table->integer('project_holder_id')->unsigned()->nullable();
                $table->text('project_holder_contact')->nullable();
                $table->integer('perimeter_id')->unsigned()->nullable();
                $table->text('objectives')->nullable();
                $table->integer('beneficiary_id')->unsigned()->nullable();
                $table->text('beneficiary_comments')->nullable();
                $table->tinyInteger('allocation_global')->default(0);
                $table->tinyInteger('allocation_per_project')->default(0);
                $table->string('allocation_amount')->nullable();
                $table->text('allocation_comments')->nullable();
                $table->text('technical_relay')->nullable();
                $table->text('website_url')->nullable();
                $table->integer('editor_id')->unsigned();
                $table->boolean('is_news');
    
                $table->timestamps();
                $table->softDeletes();
    
                $table->index('subthematic_id');
                $table->index('project_holder_id');
                $table->index('perimeter_id');
                $table->index('beneficiary_id');
                $table->index('editor_id');
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
        Schema::table('calls_for_projects', function (Blueprint $table) {
            $table->dropIndex(['subthematic_id']);
            $table->dropIndex(['project_holder_id']);
            $table->dropIndex(['perimeter_id']);
            $table->dropIndex(['beneficiary_id']);
            $table->dropIndex(['editor_id']);
        });
        Schema::dropIfExists('calls_for_projects');
    }
}
