<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallForProjects extends Model {
	use SoftDeletes;

	protected $guarded = [];

	public function rules() {
		return [
//			'name'        => 'required|min:2',
//			'description' => 'present',
		];
	}
}
