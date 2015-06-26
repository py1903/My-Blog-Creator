<?php namespace App\Presenters;

use Carbon\Carbon;

trait DatePresenter {

	public function getCreatedAtAttribute($date)
	{
		return Carbon::parse($date)->format($this->getFormat());
	}

	public function getUpdatedAtAttribute($date)
	{
	  return Carbon::parse($date)->format($this->getFormat());
	}

	private function getFormat()
	{
	  return config('app.locale') == 'fr' ? 'd-m-Y' : 'm-d-Y';
	}

}