<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url'];

    public function accounts()
    {
    	return $this->hasMany(Account::class);
    }

    public function getRouteKeyName()
	{
	    return strtolower('name');
	}
}
