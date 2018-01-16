<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perimeter extends Model {
	use SoftDeletes;

	protected $guarded = [];

	public function rules() {
		return [
			'name'        => 'required|min:2',
		];
	}
}
