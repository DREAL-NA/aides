<?php

namespace App;

use App\Traits\Description;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Website extends Model implements HasMedia {
	use SoftDeletes, Description, HasMediaTrait;

	protected $guarded = [];
	protected $dates   = [ 'deleted_at' ];

	const MEDIA_COLLECTION = 'websites';

	public function rules() {
		return [
			'organization_type_id' => 'required|exists:organization_types,id',
			'themes'               => 'nullable',
			'name'                 => 'required|min:2',
			'perimeter_id'         => 'nullable',
			'perimeter_comments'   => 'nullable',
			'delay'                => 'nullable',
			'allocated_budget'     => 'nullable',
			'beneficiaries'        => 'nullable',
			'website_url'          => 'nullable|url',
			'description'          => 'nullable',
			'logo'                 => 'image',
		];
	}

	public function organizationType() {
		return $this->belongsTo(OrganizationType::class);
	}

	public function addLogo() {
		$this->clearMediaCollection(Website::MEDIA_COLLECTION);
		$this->addMediaFromRequest('logo')->toMediaCollection(Website::MEDIA_COLLECTION);
	}

	// Attributes casting
	public function setThemesAttribute($value) {
		$this->attributes['themes'] = nl2br($value);
	}

	public function getThemesAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function getThemesHtmlAttribute() {
		return nl2br($this->themes);
	}

	public function setPerimeterCommentsAttribute($value) {
		$this->attributes['perimeter_comments'] = nl2br($value);
	}

	public function getPerimeterCommentsAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function getPerimeterCommentsHtmlAttribute() {
		return nl2br($this->perimeter_comments);
	}

	public function setDelayAttribute($value) {
		$this->attributes['delay'] = nl2br($value);
	}

	public function getDelayAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function getDelayHtmlAttribute() {
		return nl2br($this->delay);
	}

	public function setAllocatedBudgetAttribute($value) {
		$this->attributes['allocated_budget'] = nl2br($value);
	}

	public function getAllocatedBudgetAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function getAllocatedBudgetHtmlAttribute() {
		return nl2br($this->allocated_budget);
	}

	public function setBeneficiariesAttribute($value) {
		$this->attributes['beneficiaries'] = nl2br($value);
	}

	public function getBeneficiariesAttribute($value) {
		return preg_replace('#<br\s*/?>#i', "", $value);
	}

	public function getBeneficiariesHtmlAttribute() {
		return nl2br($this->beneficiaries);
	}
}
