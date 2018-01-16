<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 16/01/2018
 * Time: 11:39
 */

namespace App\Observers;

use App\CallForProjects;
use Illuminate\Support\Facades\Auth;

class CallForProjectsObserver {
	public function saving(CallForProjects $callForProjects) {
		$callForProjects->editor_id = Auth::user()->id;
	}
}