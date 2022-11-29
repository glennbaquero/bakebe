<?php

namespace App\Models\Coupons;

use App\Extenders\Models\BaseModel as Model;

use Illuminate\Validation\ValidationException;

use App\Traits\HelperTrait;

use App\Models\Promos\PromoCategory;

use Carbon\Carbon;

class Coupon extends Model
{
	use HelperTrait;

    protected $appends = ['formatted_date_start', 'formatted_date_end'];

	/*
	 * Constant value for Discount Type and Status
	 */

	const PERCENTAGE = 0; // fixed percentage
    const WHOLE_AMOUNT = 1; // fixed price
    const BUY1_TAKE1 = 2; 
    const MONEY_OFF = 3;
	const PERCENTAGE_OFF = 4;

	const UNUSED = 0;
	const USED = 1;
	const EXPIRED = 2;

    const METRODEAL = 0;
    const KLOOK = 1;

    const ALLWEEK = 0;
    const WEEKDAY = 1;
    const WEEKEND = 2;
    const BIRTHDAY = 3;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
        ];
    }

    /*
     * Relationship
     */
    
    public function couponUsages() {
        return $this->hasMany(CouponUsage::class);
    }

    public function promoCategories() {
        return $this->belongsToMany(PromoCategory::class, 'coupons_promo_categories', 'coupon_id', 'promo_category_id');
    }

    /*
     * Append Data
     */
    
    public function getFormattedDateStartAttribute() {
        return Carbon::parse($this->valid_start_at)->format('M. d, Y');
    }

    public function getFormattedDateEndAttribute() {
        return Carbon::parse($this->valid_end_at)->format('M. d, Y');
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'code', 'discount', 'discount_type', 'status', 'valid_start_at', 'valid_end_at', 'max_usage', 'max_user', 'description', 'week_id', 'voucher_type', 'usage_start_date_time', 'usage_end_date_time', 'required_invoice_total', 'is_percentage'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if($request->category_ids) {
            $item->promoCategories()->sync($request->category_ids);
        }

        return $item;
    }

    /*
     * Getters
     */
    
    public static function getStatus() {
		return [
			['value' => static::UNUSED, 'label' => 'UNUSED', 'class' => 'bg-secondary'],
			['value' => static::USED, 'label' => 'USED', 'class' => 'bg-success'],
			['value' => static::EXPIRED, 'label' => 'EXPIRED', 'class' => 'bg-danger'],
		];
	}

	public static function getDiscountType() {
		return [
            ['value' => static::PERCENTAGE, 'label' => 'FIXED PERCENTAGE', 'class' => 'bg-primary'],
			['value' => static::WHOLE_AMOUNT, 'label' => 'FIXED PRICE', 'class' => 'bg-success'],
            // ['value' => static::BUY1_TAKE1, 'label' => 'BUY 1 TAKE 1', 'class' => 'bg-danger'],
            ['value' => static::MONEY_OFF, 'label' => 'MONEY OFF', 'class' => 'bg-secondary'],
			['value' => static::PERCENTAGE_OFF, 'label' => 'PERCENTAGE OFF', 'class' => 'bg-warning'],
		];
	}

    public static function getVoucherType() {
        return [
            ['value' => static::METRODEAL, 'label' => 'METRODEAL', 'class' => 'bg-secondary'],
            ['value' => static::KLOOK, 'label' => 'KLOOK', 'class' => 'bg-primary'],
        ];
    }

    public static function getPromoType() {
        return [
            ['value' => static::ALLWEEK, 'label' => 'ALL WEEK', 'class' => 'bg-success'],
            ['value' => static::WEEKDAY, 'label' => 'WEEKDAY', 'class' => 'bg-primary'],
            ['value' => static::WEEKEND, 'label' => 'WEEKEND', 'class' => 'bg-secondary'],
            ['value' => static::BIRTHDAY, 'label' => 'BIRTHDAY PROMO', 'class' => 'bg-warning'],
        ];
    }

    public function getCountUsage() {
        return $this->couponUsages->count();
    }

    public function getCouponStatus($totalInvoice) {
        $status = $this->status;
        $validity_start = Carbon::parse($this->valid_start_at);
        $validity_end = Carbon::parse($this->valid_end_at);
        $usage_start = $this->usage_start_date_time;
        $usage_end = $this->usage_end_date_time;
        $max_usage = $this->max_usage;
        $max_user = $this->max_user;
        $required_invoice_total = $this->required_invoice_total;
        $promo_type = $this->week_id;
        $already_used = $this->getCountUsage();
        
        $today = Carbon::now();

        if ($validity_start >= $today && $today <= $validity_end) {
            throw ValidationException::withMessages([
                'message' => 'You can only avail this coupon from ' . Carbon::parse($this->valid_start_at)->format('F d, Y') . ' to ' . Carbon::parse($this->valid_end_at)->format('F d, Y').'.'
            ]);
        }

        if ($usage_start >= $today && $today <= $usage_end) {
            throw ValidationException::withMessages([
                'message' => 'You can only use this coupon from ' . Carbon::parse($this->usage_start_date_time)->format('F d, Y h:i A') . ' to ' . Carbon::parse($this->usage_end_date_time)->format('F d, Y h:i A').'.'
            ]);
        }

        /* Check Coupon Max Usage  */
        $userIds = $this->couponUsages->pluck('user_id')->toArray();

        if (count($userIds) >= $max_user) {
            throw ValidationException::withMessages([
                'message' => 'The maximum users who can avail this coupon has been reached.'
            ]);
        }

        if($totalInvoice < $required_invoice_total) {
            throw ValidationException::withMessages([
                'message' => 'Total amount in cart is not reached to the expected amount to use this coupon.'
            ]);
        }

        return true;
    }

    // public function getDiscountTypeFixedPercentage($totalInvoice, $user = false) {

    // } 

    /**
     * Discount per item
     * @param  App\Models\Carts\CartItem  $cartItems
     * @param  App\Models\Carts\Cart   $cart
     * @param  boolean $is_percentage true if want to use percentage instead as discount value
     * @return Integer Number of Applied Cart Items
     */
    public function getDiscountTypeItemOff($cartItems, $cart, $is_percentage = false, $cart_promo_total) {
        $discount = $this->discount;
        $action = [];
        $coupon_total = 0;
        // dd($cart->id);
        // $cart->update(['grand_total' => 0]);

        if($is_percentage) {
            $discount /= 100;
        }
            
        $cart->decrement('grand_total', $cart_promo_total);

        foreach ($cartItems as $cartItem) {
            $cartItem_total = $cartItem->grand_total;

            /* Computation for discount for Money Off */
            if(!$is_percentage) {
                /* Prevent over cost on original price */
                if ($discount > $cartItem_total) {
                    $cartItem->discount_price = $cartItem_total;
                } else {
                    $cartItem->discount_price = $discount * $cartItem->attendees;
                }
            } else {
                /* Computation for discount for Percentage Off */

                if($discount > 1) {
                  $cartItem->discount_price = $cartItem_total;
                } else {
                    $discountPrice = $cartItem_total * $discount;
                    $cartItem->discount_price = $discountPrice;
                }
            }

            $cartItem->save();

            $coupon_total += $cartItem->discount_price;
            $total = $cartItem->grand_total - $cartItem->discount_price;
            $cart->increment('grand_total', $total);
        }
        $response['cart_grand_total'] = $cart->grand_total;
        $response['coupon_grand_total'] = $coupon_total;

        return $response;
    }

    /**
     * Discount to total Invoice amount
     * @param  App\Models\Carts\CartItem  $cartItems 
     * @param  App\Models\Carts\Cart   $cart     
     * @param  Boolean $is_percentage If you want to change discount as percentage
     * @return Integer            Count of the Cart Item affected             
     */
    public function processTotalOff($cartItems, $cart = [], $is_percentage = false, $cart_promo_total)
    {
        $action = [];
        $discount = 0;
        $cartItem_total = 0;
        $total = 0;
        $coupon_total = 0;

        $discount = $this->discount;

        $cart->decrement('grand_total', $cart_promo_total);

        foreach ($cartItems as $cartItem) {
            $total += $cartItem->grand_total;
        }

        /* Change fixed discount to percentage discount */
        if ($is_percentage) {
            $discount = $this->discount / 100;
            $discount = $total * $discount;
        }

        foreach ($cartItems as $cartItem) {

            $cartItem_total = $cartItem->grand_total;

            if ($discount > $cartItem_total) {
                $cartItem->discount_price = $cartItem_total;
                $discount -= $cartItem_total;

            } else {
                $cartItem->discount_price = $discount;
                $discount -= $discount;
            }

            if ($cartItem->discount_price > $cartItem_total) {
                $cartItem->discount_price = $cartItem_total;
            }

            $cartItem->save();
            $coupon_total += $cartItem->discount_price;
            $grand_total = $cartItem->grand_total - $cartItem->discount_price;
            $cart->increment('grand_total', $grand_total);
        }
        $response['cart_grand_total'] = $cart->grand_total;
        $response['coupon_grand_total'] = $coupon_total;

        return $response;
    }

    /**
     * @Render
     */

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.coupons.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.coupons.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.coupons.restore', $this->id);
    }

    public function renderDiscountTypeLabel() {
		return $this->renderConstants(static::getDiscountType(), $this->discount_type, 'label');
	}

	public function renderDiscountTypeClass() {
		return $this->renderConstants(static::getDiscountType(), $this->discount_type, 'class');
	}

	public function renderStatusLabel() {
		return $this->renderConstants(static::getStatus(), $this->status, 'label');
	}

	public function renderStatusClass() {
		return $this->renderConstants(static::getStatus(), $this->status, 'class');
	}

    public function renderVoucherTypeLabel() {
        return $this->renderConstants(static::getVoucherType(), $this->status, 'label');
    }

    public function renderVoucherTypeClass() {
        return $this->renderConstants(static::getVoucherType(), $this->status, 'class');
    }

    public function renderPromoTypeLabel() {
        return $this->renderConstants(static::getPromoType(), $this->status, 'label');
    }

    public function renderPromoTypeClass() {
        return $this->renderConstants(static::getPromoType(), $this->status, 'class');
    }

    public function renderDiscountWithPercentageLabel() {
        $result = $this->discount;

        if($this->is_percentage) {
            $result .= '%';
        }

        return $result;
    }
}
