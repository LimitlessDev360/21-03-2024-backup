<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Scopes\ZoneScope;

class DeliveryMan extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'vehicle_id' => 'integer',
        'zone_id' => 'integer',
        'status'=>'boolean',
        'active'=>'integer',
        'available'=>'integer',
        'earning'=>'float',
        'restaurant_id'=>'integer',
        'current_orders'=>'integer',
        'vehicle_id'=>'integer',
        'shift_id' => 'integer',
    ];

    protected $hidden = [
        'password',
        'auth_token',
    ];

    public function wallet()
    {
        return $this->hasOne(DeliveryManWallet::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'restaurant_id');
    }

    public function userinfo()
    {
        return $this->hasOne(UserInfo::class,'deliveryman_id', 'id');
    }
    public function dm_shift()
    {
        return $this->belongsTo(Shift::class,'shift_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function time_logs()
    {
        return $this->hasMany(TimeLog::class, 'user_id', 'id')->with('shift');
    }

    public function order_transaction()
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function todays_earning()
    {
        return $this->hasMany(OrderTransaction::class)->whereDate('created_at',now());
    }

    public function this_week_earning()
    {
        return $this->hasMany(OrderTransaction::class)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public function this_month_earning()
    {
        return $this->hasMany(OrderTransaction::class)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
    }

    public function todaysorders()
    {
        return $this->hasMany(Order::class)->whereDate('accepted',now());
    }

    public function this_week_orders()
    {
        return $this->hasMany(Order::class)->whereBetween('accepted', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    }

    public function delivery_history()
    {
        return $this->hasMany(DeliveryHistory::class, 'delivery_man_id');
    }

    public function last_location()
    {
        return $this->hasOne(DeliveryHistory::class, 'delivery_man_id')->latestofMany();
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function reviews()
    {
        return $this->hasMany(DMReview::class);
    }

    public function disbursement_method()
    {
        return $this->hasOne(DisbursementWithdrawalMethod::class)->where('is_default',1);
    }

    public function rating()
    {
        return $this->hasMany(DMReview::class)
            ->select(DB::raw('avg(rating) average, count(delivery_man_id) rating_count, delivery_man_id'))
            ->groupBy('delivery_man_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('application_status','approved');
    }

    public function scopeEarning($query)
    {
        return $query->where('earning', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('current_orders', '<' ,config('dm_maximum_orders'));
    }

    public function scopeZonewise($query)
    {
        return $query->where('type','zone_wise');
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }
    public function incentives()
    {
        return $this->hasMany(IncentiveLog::class);
    }

    public function incentive()
    {
        return $this->hasOne(IncentiveLog::class)->whereDate('date', now()->format('Y-m-d'));
    }
}
