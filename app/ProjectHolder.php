<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectHolder extends Model {
	use SoftDeletes;

	protected $guarded = [];
	protected $dates   = [ 'deleted_at' ];

	public function rules() {
		return [
			'name'        => 'required|min:2',
			'description' => 'present',
		];
	}
}
