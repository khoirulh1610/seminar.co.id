<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use MacsiDigital\Zoom\Facades\Zoom;

class HelperZoom{
	static function users()
	{		
		// ()->find('98947153729')->get()
		// $user = Zoom::user()->find('pt.msd@fexpost.com');
		// $meetings = $user->meetings();
		$registrant = Zoom::meeting()->find('98947153729')->registrants()->create(['first_name'=>'Pak','last_name'=>'Khoirul','email'=>'khoirulh1610@yahoo.co.id']);
		return $registrant->join_url;
	}	

	static function join($sapaan,$nama,$email,$zoom_id='98947153729'){
		try {
			$registrant = Zoom::meeting()->find($zoom_id)->registrants()->create(['first_name'=>$sapaan,'last_name'=>$nama,'email'=>$email]);
			return $registrant->join_url;
		} catch (\Throwable $th) {
			return "";
		}
	}
}