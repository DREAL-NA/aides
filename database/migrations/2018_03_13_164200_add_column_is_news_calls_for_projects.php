<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsNewsCallsForProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('calls_for_projects')) {
            Schema::table('calls_for_projects', function (Blueprint $table) {
                $table->tinyInteger('is_news')->default(1);
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
            $table->removeColumn('is_news');
        });
    }
}
