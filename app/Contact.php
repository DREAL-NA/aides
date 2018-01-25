<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
	protected $guarded = [];

	public function rules() {
		return [
			'name'    => 'required|min:2|max:255',
			'subject' => 'required|min:2',
			'email'   => 'required|min:2|max:255',
			'message' => 'required|min:2',
		];
	}
}
