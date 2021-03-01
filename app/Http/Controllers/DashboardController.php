<?php

namespace App\Http\Controllers;

use App\Models\{Service, Tag, Log, Account};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
    	$results = $this->getServices();
        $totalAccount = Account::where('user_id', auth()->id())->count();

		return view('dashboard.index', compact('results', 'totalAccount'));
    }

    public function logs(Log $log)
    {
        $logs = $log->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.logs', compact('logs'));
    }

    public function tag($service, $tag)
    {
        $tag_id = Tag::where('slug', $tag)->firstOrFail()->id;
        $service = Service::where('name', ucfirst($service))->firstOrFail();
        $accounts = Tag::find($tag_id)->accounts()->where(['user_id' => auth()->id(), 'service_id' => $service->id])->paginate(10);

        return view('dashboard.account.index', ['accounts' => $accounts, 'service' => $service]);
    }

    public function store_secretkey()
    {
    	Cache::put('secretkey', request('key'));
    	return 'ok';
    }

    public function out()
    {
    	Cache::forget('secretkey');
    	auth()->logout();

    	return redirect()->to(route('login'));
    }
}
