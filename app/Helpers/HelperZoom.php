<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Zoom;

class HelperZoom
{
	static function users()
	{
		// ()->find('98947153729')->get()
		$user = Zoom::user()->find('msd@fexpost.com');
		// $meetings = $user->meetings();
		dd($user);
		// $registrant = Zoom::meeting()->find('92104614170')->registrants()->create(['first_name' => 'Pak', 'last_name' => 'Khoirul', 'email' => 'khoirulh1610@yahoo.co.id']);
		// return $registrant->join_url;
	}

	static function join($zid,$sapaan, $nama, $email, $zoom_id = '96602958296')
	{
		try {
			$myzoom = Zoom::where('id',$zid)->first();
			if($myzoom){
				$zoom = new \MacsiDigital\Zoom\Support\Entry($myzoom->key, $myzoom->secret, 60 * 60 * 24 * 7, 5, 'https://api.zoom.us/v2/');                
				$meeting = new \MacsiDigital\Zoom\Meeting($zoom);     
				$registrant = $meeting->find($zoom_id)->registrants()->create(['first_name' => $sapaan, 'last_name' => $nama, 'email' => $email]);				
				return $registrant->join_url;
			}else{
				return "x";
			}			
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}
}
