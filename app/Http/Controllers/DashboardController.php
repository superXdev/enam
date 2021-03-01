<?php

namespace App\Http\Controllers;

use App\Models\{Service, Tag, Log, Account};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /*
    * Dashboard menu to show all account service
    */
    public function index()
    {
        // get services
    	$results = $this->getServices();
        // count total account
        $totalAccount = Account::where('user_id', auth()->id())->count();

		return view('dashboard.index', compact('results', 'totalAccount'));
    }

    /*
    * Show logs menu
    */
    public function logs(Log $log)
    {
        $logs = $log->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.logs', compact('logs'));
    }

    /*
    * Show list of account by tag and service
    */
    public function tag($service, $tag)
    {
        // get tag id from slug
        $tag_id = Tag::where('slug', $tag)->firstOrFail()->id;
        // get service name
        $service = Service::where('name', ucfirst($service))->firstOrFail();
        // get all accounts
        $accounts = Tag::find($tag_id)->accounts()->where(['user_id' => auth()->id(), 'service_id' => $service->id])->paginate(10);

        return view('dashboard.account.index', ['accounts' => $accounts, 'service' => $service]);
    }

    /*
    * Store secretkey to cache
    */
    public function store_secretkey()
    {
    	Cache::put('secretkey', request('key'));
    	return 'ok';
    }

    // Custom logout function
    public function out()
    {
        // Delete secretkey from cache
    	Cache::forget('secretkey');
    	auth()->logout();

    	return redirect()->to(route('login'));
    }
}
