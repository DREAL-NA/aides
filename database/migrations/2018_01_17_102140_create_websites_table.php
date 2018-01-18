<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('websites', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('organization_type_id')->unsigned();
			$table->text('themes')->nullable();
			$table->string('name');
			$table->integer('perimeter_id')->unsigned()->nullable();
			$table->text('perimeter_comments')->nullable();
			$table->text('delay')->nullable();
			$table->text('allocated_budget')->nullable();
			$table->text('beneficiaries')->nullable();
			$table->text('website_url')->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('websites');
	}
}
