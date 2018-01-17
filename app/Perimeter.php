<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perimeter extends Model {
	use SoftDeletes, Description;

	protected $guarded = [];
	protected $dates   = [ 'deleted_at' ];

	public function rules() {
		return [
			'name'        => 'required|min:2',
			'description' => 'present',
		];
	}
}
