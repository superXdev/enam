<?php

namespace App\Http\Controllers;

use App\Models\{Service, Log};
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
    * Custom encrypt function
    */
    public function encrypt($key, $data)
    {
        // create secretkey from APP_KEY + password from user
    	$secretKey = md5(config('app.key').$key);
        // initialize Encrypter from laravel
        $newEncrypter = new Encrypter($secretKey,'AES-256-CBC');

        // convert to string from array data & encrypt it
        $result = $newEncrypter->encrypt(serialize($data));
        return $result;
    }

    /*
    * Get all services that user have the account from it
    */
    public static function getServices()
    {
    	$results = array();
    	$services = auth()->user()->accounts()->select('service_id')->groupBy('service_id')->get();

		foreach($services as $service) {
			array_push($results, Service::find($service->service_id));
		}

		return $results;
    }

    /*
    * Logging all user activities
    */
    public function logger($action, $service)
    {
        Log::create([
            'user_id' => auth()->id(),
            'service' => $service,
            'action' => $action
        ]);
    }
}