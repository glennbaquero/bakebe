<?php

namespace App\Models\Carts;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Users\User;
use App\Models\Invoices\Invoice;
use App\Models\Types\BookingType;
use App\Models\Branches\Branch;
use App\Models\Promos\Promo;

use App\Traits\DateTrait;

class Cart extends Model
{

	use DateTrait;
	
	public function toSearchableArray() {
        return [
             'id' => $this->id,
             'grand_total' => $this->grand_total,
        ];
    }

    /*
	 * Relationship
	 */
	
	public function user() {
		return $this->belongsTo(User::class)->withTrashed();
	}

	public function cartItems() {
		return $this->hasMany(CartItem::class);
	}

	public function invoice() {
		return $this->hasOne(Invoice::class);
	}

    public function bookingType() {
        return $this->belongsTo(BookingType::class)->withTrashed();
    }

    public function branch() {
        return $this->belongsTo(Branch::class)->withTrashed();
    }
    
    public function promo() {
    	return $this->belongsTo(Promo::class)->withTrashed();
    }

    public function renderDiscount() {
        $discount = $this->promo->discount * $this->cartItems->sum('attendees');
        if($this->promo->is_percentage) {
            $discount = (($this->promo->discount * $this->cartItems->sum('attendees')) / 100) * 100;
        }

        return '₱ '.number_format($discount, 2, '.', ',');
    }

    public function renderCouponDiscount() {
        $total = 0;
        foreach ($this->cartItems as $item) {
            $total += $item->discount_price;
        }

        return $total;
    }

    public function renderTotalDiscount() {
        $discount = $this->promo->discount * $this->cartItems->sum('attendees');
        if($this->promo->is_percentage) {
            $discount = (($this->promo->discount * $this->cartItems->sum('attendees')) / 100) * 100;
        }

        return $discount;
    }
}
