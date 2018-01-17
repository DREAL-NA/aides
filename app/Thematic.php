<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Thematic extends Model {
	use SoftDeletes, Description;

	protected $guarded = [];
	protected $dates   = [ 'deleted_at' ];

	public function rules() {
		return [
			'name'        => 'required|min:2',
			'description' => 'present',
		];
	}

	public function rulesSubthematic() {
		return [
			'name'        => 'required|min:2',
			'description' => 'present',
			'parent_id'   => [
				'required',
				Rule::exists('thematics', 'id')->where(function($query) {
					$query->whereNull('parent_id');
				}),
			],
		];
	}

	public function children() {
		return $this->hasMany(self::class, 'parent_id');
	}

	public function parent() {
		return $this->belongsTo(self::class, 'parent_id');
	}

	public function scopePrimary($query) {
		return $query->whereNull('parent_id');
	}

	public function scopeSub($query) {
		return $query->whereNotNull('parent_id');
	}
}
