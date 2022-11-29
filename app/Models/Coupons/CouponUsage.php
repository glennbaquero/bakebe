<?php

namespace App\Models\Coupons;

use Illuminate\Database\Eloquent\Model;

use App\Models\Coupons\Coupon;
use App\Models\Users\User;
use App\Models\Invoices\Invoice;

class CouponUsage extends Model
{
    protected $guarded = [];

    /*
     * Relationship
     */
    
    public function user() {
    	return $this->belongsTo(User::class)->withTrashed();
    }

    public function coupon() {
    	return $this->belongsTo(Coupon::class)->withTrashed();
    }

    public function invoice() {
    	return $this->belongsTo(Invoice::class);
    }


    /**
     * @Render
     */

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.reservations.show', $this->invoice->reference_number);
    }

}
