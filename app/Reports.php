<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Wallet;
use Carbon\Carbon;

class Report extends Model
{
    protected $table = 'reports';
    
    protected $fillable = [
        'description', 'user_id', 'amount'
    ];
    
    /*public function getCreatedAtAttribute($date)
    {
        // SCOPE fantastic )
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }*/
}
