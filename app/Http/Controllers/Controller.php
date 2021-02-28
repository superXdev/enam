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

    public function encrypt($key, $data)
    {
    	$secretKey = md5($key);
        $newEncrypter = new Encrypter($secretKey,'AES-256-CBC');

        $result = $newEncrypter->encrypt(serialize($data));
        return $result;
    }

    public static function getServices()
    {
    	$results = array();
    	$services = auth()->user()->accounts()->select('service_id')->groupBy('service_id')->get();

		foreach($services as $service) {
			array_push($results, Service::find($service->service_id));
		}

		return $results;
    }

    public function logger($action, $service)
    {
        Log::create([
            'user_id' => auth()->id(),
            'service' => $service,
            'action' => $action
        ]);
    }
}