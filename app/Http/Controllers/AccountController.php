<?php

namespace App\Http\Controllers;

use App\Models\{Account, Service};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Exports\AccountExport;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    /*
    * Show all accounts by service
    */
	public function index($service)
	{
		$service = Service::where('name', ucfirst($service))->firstOrFail();
		$accounts = auth()->user()->accounts()->where('service_id', $service->id)->paginate(10);

		return view('dashboard.account.index', compact('accounts', 'service'));
	}

    /*
    * Create a new account
    */
    public function create()
    {
    	$services = Service::select('name', 'id')->get();
    	return view('dashboard.account.create', compact('services'));
    }

    /*
    * Store account to database
    */
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'service_id' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        // store to Account database
    	$accountCreated = Account::create([
    		'user_id' => auth()->id(),
    		'service_id' => $request->service_id,
    		'data' => $this->encrypt(Cache::get('secretkey'), ['username' => $request->username, 'password' => $request->password]),
    		'note' => $request->note,
    		'status' => 'active'
    	]);

        // syncronize tags relation
        $accountCreated->tags()->sync($request->tags);

        // logging action
        $this->logger('create', $accountCreated->service->name);

        return redirect()->back()->with(['success' => 'Akun berhasil disimpan!']);
    }

    /*
    * Edit account
    */
    public function edit(Account $account)
    {
        $services = Service::select('name', 'id')->get();
        return view('dashboard.account.edit', compact('account','services'));
    }

    /*
    * Update account
    */
    public function update(Account $account, Request $request)
    {
        // make sure user is authorize to doing this action
        $this->authorize('update', $account);
        // update to database
        $account->update([
            // encrypt first
            'data' => $this->encrypt(Cache::get('secretkey'), ['username' => $request->username, 'password' => $request->password]),
            'note' => $request->note
        ]);

        // syncronize tags relation
        $account->tags()->sync($request->tags);

        // logging action
        $this->logger('update', Service::find($request->service_id)->name);

        return redirect()->back()->with(['updated' => 'Berhasil di perbarui']);
    }

    /*
    * Delete account
    */
    public function delete(Account $account)
    {
        // make sure user is authorize to doing this action
        $this->authorize('delete',$account);
        // delete
        $account->delete();

        // logging action
        $this->logger('delete', $account->service->name);

        return redirect()->back()->with(['deleted' => 'Berhasil di hapus']);
    }

    /*
    * Toggle status account
    */
    public function toggle_status(Account $account)
    {
        // new status to update
        $status = ($account->status == 'active') ? 'inactive' : 'active';
        // update to database
        $account->update(['status' => $status]);

        // logging action
        $this->logger(($account->status == 'active') ? 'activated' : 'deactivated', $account->service->name);

        return redirect()->back()->with(['message' => 'Status telah diperbarui']);
    }

    /*
    * Export all account by service to excel file
    */
    public function export_account($service_id)
    {
        // get accounts collection
        $accounts = auth()->user()->accounts()->where('service_id', $service_id)->get();
        // get service name
        $serviceName = $accounts[0]->service->name;
        
        // make new array from decrypted data
        $data = array(['username', 'password', 'note', 'create date']);
        foreach($accounts as $account) {
            $credentials = (object)$account->showData(Cache::get('secretkey'));
            array_push($data, [
                'username' => $credentials->username,
                'password' => $credentials->password,
                'note' => $account->note,
                'created_at' => $account->created_at,
            ]);
        }

        // export to excel
        $export = new AccountExport($data);

        // logging action
        $this->logger('export', $serviceName);

        // download excel file
        return Excel::download($export, 'Akun '.$serviceName.'.xlsx');
    }
}
