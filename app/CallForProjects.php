<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class CallForProjects extends Model {
	use SoftDeletes;

	protected $guarded = [];
	protected $dates   = [ 'deleted_at', 'closing_date' ];

	protected $table = 'calls_for_projects';

	public function rules() {
		return [
			'subthematic_id'         => [
				'required',
				Rule::exists('thematics', 'id')->where(function($query) {
					$query->whereNotNull('parent_id');
				}),
			],
			'name'                   => 'required|min:2',
			'closing_date'           => 'required|date_format:Y-m-d',
			'project_holder_id'      => 'required|exists:project_holders,id',
			'project_holder_contact' => 'present',
			'perimeter_id'           => 'required|exists:perimeters,id',
			'objectives'             => 'required|min:2',
			'beneficiary_id'         => 'required|exists:beneficiaries,id',
			'beneficiary_comments'   => 'present',
			'allocation_global'      => 'required_without:allocation_per_project|in:1',
			'allocation_per_project' => 'required_without:allocation_global|in:1',
			'allocation_comments'    => 'present',
			'technical_relay'        => 'present',
			'website_url'            => 'required|url',
		];
	}

	public function subthematic() {
		return $this->belongsTo(Thematic::class);
	}

	public function projectHolder() {
		return $this->belongsTo(ProjectHolder::class);
	}

	public function perimeter() {
		return $this->belongsTo(Perimeter::class);
	}

	public function beneficiary() {
		return $this->belongsTo(Beneficiary::class);
	}

	public function scopeClosed($query) {
		return $query->whereDate('closing_date', '<', date('Y-m-d 23:59:59'));
	}

	public function scopeOpened($query) {
		return $query->whereDate('closing_date', '>=', date('Y-m-d 23:59:59'));
	}
}
