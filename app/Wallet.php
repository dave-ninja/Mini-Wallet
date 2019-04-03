<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Wallet extends Model
{
    protected $table = 'wallet';
    
    protected $fillable = [
        'title', 'type', 'user_id'
    ];
    
    public function Users() {
		return $this->hasOne(User::class);
	}
}
