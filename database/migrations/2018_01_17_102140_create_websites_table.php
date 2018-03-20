<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_type_id')->unsigned()->nullable();
            $table->text('themes')->nullable();
            $table->string('name');
            $table->text('perimeter_comments')->nullable();
            $table->text('delay')->nullable();
            $table->text('allocated_budget')->nullable();
            $table->text('beneficiaries')->nullable();
            $table->text('website_url')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('organization_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websites');
    }
}
