<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'service_id', 'data', 'note'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

	public function service()
    {
    	return $this->belongsTo(Service::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function safeInsert($key, $data)
    {
        $secretKey = md5($key);
        $newEncrypter = new Encrypter($secretKey,'AES-256-CBC');

        $data['data'] = $newEncrypter->encrypt($data['data']);
        return $this->create($data);
    }

    public function showData($key, $data)
    {
        $secretKey = md5($key);
        $newEncrypter = new Encrypter($secretKey,'AES-256-CBC');
        return $newEncrypter->decrypt($data['data']);
    }    
}
