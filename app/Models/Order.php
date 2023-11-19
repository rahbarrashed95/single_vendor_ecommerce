<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetails;
use App\Models\OrderPayment;
use App\Models\User;
use App\Models\Courier;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded=[];

    public function details(){

        return $this->hasMany(OrderDetails::class);
    }

    public function payments(){

        return $this->hasMany(OrderPayment::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function assign(){

        return $this->belongsTo(User::class,'assign_user_id');
    }

    public function courier(){

        return $this->belongsTo(Courier::class);
    }    
  
  	public function delivery_charge(){

        return $this->belongsTo(DeliveryCharge::class, 'delivery_charge_id');
    }
}
