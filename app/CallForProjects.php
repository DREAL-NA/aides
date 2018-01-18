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
			'thematic_id'            => [
				'required',
				Rule::exists('thematics', 'id')->where(function($query) {
					$query->whereNull('parent_id');
				}),
			],
			'subthematic_id'         => [
				'nullable',
				Rule::exists('thematics', 'id')->where(function($query) {
					$query->whereNotNull('parent_id');
				}),
			],
			'name'                   => 'required|min:2',
			'closing_date'           => 'nullable|date_format:Y-m-d',
			'project_holder_id'      => 'nullable|exists:project_holders,id',
			'project_holder_contact' => 'nullable',
			'perimeter_id'           => 'nullable|exists:perimeters,id',
			'objectives'             => 'nullable|min:2',
			'beneficiary_id'         => 'nullable|exists:beneficiaries,id',
			'beneficiary_comments'   => 'nullable',
			'allocation_global'      => 'required_without:allocation_per_project|in:1',
			'allocation_per_project' => 'required_without:allocation_global|in:1',
			'allocation_amount'      => 'nullable',
			'allocation_comments'    => 'nullable',
			'technical_relay'        => 'nullable',
			'website_url'            => 'nullable|url',
		];
	}

	public function thematic() {
		return $this->belongsTo(Thematic::class);
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
		return $query->whereDate('closing_date', '<', date('Y-m-d 00:00:00'));
	}

	public function scopeOpened($query) {
//		return $query->whereDate('closing_date', '>=', date('Y-m-d 00:00:00'))->orWhereRaw('closing_date is null', []);
		return $query->whereDate('closing_date', '>=', date('Y-m-d 00:00:00'))->orWhereNull('closing_date');
	}

	// retrieve relationships data with call for projects
	public static function filterDataById($items, $data_id_name) {
		return $items->reject(function ($item) use ($data_id_name) {
			return is_null($item->{$data_id_name});
		})->map(function($item) use ($data_id_name) {
			return $item->{$data_id_name};
		})->unique()->values();
	}

	public static function getRelationshipData($class, $items, $data_id_name) {
		$ids = self::filterDataById($items, $data_id_name);

		if(empty($ids)) {
			return null;
		}

		return $class::whereIn('id', $ids)->get();
	}

	// Attributes casting
	public function setObjectivesAttribute($value) {
		$this->attributes['objectives'] = nl2br($value);
	}

	public function getObjectivesAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function setProjectHolderContactAttribute($value) {
		$this->attributes['project_holder_contact'] = nl2br($value);
	}

	public function getProjectHolderContactAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function setBeneficiaryCommentsAttribute($value) {
		$this->attributes['beneficiary_comments'] = nl2br($value);
	}

	public function getBeneficiaryCommentsAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function setAllocationCommentsAttribute($value) {
		$this->attributes['allocation_comments'] = nl2br($value);
	}

	public function getAllocationCommentsAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function setTechnicalRelayAttribute($value) {
		$this->attributes['technical_relay'] = nl2br($value);
	}

	public function getTechnicalRelayAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}
}
