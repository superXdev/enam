<?php

namespace App\Http\Controllers;

use App\Models\{Account, Service};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccountController extends Controller
{
	public function index($service)
	{
		$service = Service::where('name', ucfirst($service))->first();
		$accounts = auth()->user()->accounts()->where('service_id', $service->id)->get();

		// dd($accounts);
		return view('dashboard.account.index', compact('accounts', 'service'));
	}

    public function create()
    {
    	$services = Service::select('name', 'id')->get();
    	return view('dashboard.account.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

    	$accountCreated = Account::create([
    		'user_id' => auth()->id(),
    		'service_id' => $request->service_id,
    		'data' => $this->encrypt(Cache::get('secretkey'), ['username' => $request->username, 'password' => $request->password]),
    		'note' => $request->note,
    		'status' => 'active'
    	]);

    	foreach ($request->tags as $key => $value) {
    		$accountCreated->tags()->attach($value);
    	}

        // logging action
        $this->logger('create', $accountCreated->service->name);

        return redirect()->back()->with(['success' => 'Akun berhasil disimpan!']);
    }

    public function edit(Account $account)
    {
        $services = Service::select('name', 'id')->get();
        return view('dashboard.account.edit', compact('account','services'));
    }

    public function update(Account $account, Request $request)
    {
        $this->authorize('update', $account);
        $account->update([
            'data' => $this->encrypt(Cache::get('secretkey'), ['username' => $request->username, 'password' => $request->password]),
            'note' => $request->note
        ]);

        $account->tags()->sync($request->tags);

        // logging action
        $this->logger('update', Service::find($request->service_id)->name);

        return redirect()->back()->with(['updated' => 'Berhasil di perbarui']);
    }

    public function delete(Account $account)
    {
        $this->authorize('delete',$account);
        $account->delete();

        // logging action
        $this->logger('delete', $account->service->name);

        return redirect()->back()->with(['deleted' => 'Berhasil di hapus']);
    }

    public function toggleStatus(Account $account)
    {
        $status = ($account->status == 'active') ? 'inactive' : 'active';

        $account->update(['status' => $status]);

        // logging action
        $this->logger(($account->status == 'active') ? 'activated' : 'deactivated', $account->service->name);

        return redirect()->back()->with(['message' => 'Status telah diperbarui']);
    }
}
