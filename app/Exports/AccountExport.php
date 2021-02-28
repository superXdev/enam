<?php

namespace App\Exports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\FromArray;

class AccountExport implements FromArray
{
	public function __construct($data)
	{
		$this->data = $data;
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->data;
    }
}
