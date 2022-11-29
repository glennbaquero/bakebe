<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

use App\Models\Carts\Cart;
use App\Models\Branches\Branch;
use App\Models\Users\User;
use App\Models\Coupons\CouponUsage;

use App\Traits\HelperTrait;
use App\Traits\NumberFormatTrait;

use Carbon\Carbon;

class Invoice extends Model
{

	use HelperTrait, NumberFormatTrait, Searchable;

    protected $guarded = [];

    protected $appends = ['formatted_created_at'];

    /*
     * Constant value for Payment Type
     */

    const PAYPAL = 0;
    const PAYNAMICS = 1;
    const PAYMAYA = 2;

    /*
     * Constant value for Payment Status
     */
    const PENDING = 0;
    const PAID = 1;
    const ALL = 2;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'reference_number' => $this->reference_number,
        ];
    }

    /*
     * Relationship
     */
    
    public function user() {
    	return $this->belongsTo(User::class)->withTrashed();
    }

    public function cart() {
    	return $this->belongsTo(Cart::class)->withTrashed();
    }

    public function couponUsage() {
        return $this->hasOne(CouponUsage::class);
    }

    public function invoiceItems() {
        return $this->hasMany(InvoiceItem::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class)->withTrashed();
    }

    /*
     * Getters
     */
    
    public static function getPaymentType() {
		return [
			['value' => static::PAYPAL, 'label' => 'PAYPAL', 'class' => 'bg-primary'],
			['value' => static::PAYNAMICS, 'label' => 'PAYNAMICS', 'class' => 'bg-secondary'],
			['value' => static::PAYMAYA, 'label' => 'PAYMAYA', 'class' => 'bg-success'],
		];
	}

    public static function getPaymentStatus() {
        return [
            ['value' => static::PENDING, 'label' => 'PENDING', 'class' => 'bg-secondary'],
            ['value' => static::PAID, 'label' => 'PAID', 'class' => 'bg-success'],
        ];
    }

    public function getFormattedCreatedAtAttribute() {
        return Carbon::parse($this->created_at)->format('m-d-Y');
    }

    /*
     * Setters
     */
    
    public static function generateReferenceNumber() {
        return 'BAKEBE'.str_random(10);
    }

	/*
	 * Renderers
	 */
	
	public function renderPaymentTypeLabel() {
		return $this->renderConstants(static::getPaymentType(), $this->payment_type, 'label');
	}

	public function renderPaymentTypeClass() {
		return $this->renderConstants(static::getPaymentType(), $this->payment_type, 'class');
	}

    public function renderPaymentStatusLabel() {
        return $this->renderConstants(static::getPaymentStatus(), $this->is_paid, 'label');
    }

    public function renderPaymentStatusClass() {
        return $this->renderConstants(static::getPaymentStatus(), $this->is_paid, 'class');
    }

    public function renderDate() {
        return Carbon::parse($this->created_at)->format('M. d, Y');
    }

    public function renderShowUrl() {
        return route('admin.bookings.show', $this->id);
    }

    public function renderInvoiceClaimed() {
        return route('admin.invoice.mark-claimed', $this->id);
    }

    public function renderShowItemUrl() {
        return route('web.history.show', $this->reference_number);
    }    

    public function renderAmountWithFormat($amount) {
        return number_format($amount, 2, '.', ',');
    }

    public function convertToHoursMins($duration) {
        if ($duration < 1) {
            return '---';
        }

        $hours = floor($duration / 60);
        $minutes = ($duration % 60);

        $minute_format = null;
        $hours_format = null;

        if($hours > 1) {
            $hours_format = $hours.' hours';
        } elseif ($hours <= 1 && $hours  != 0) {
            $hours_format = $hours.' hour';
        }

        if($minutes > 1) {
            $minute_format = $minutes.' minutes';
        } elseif ($minutes <= 1 && $minutes  != 0) {
            $minute_format = $minutes.' minute';
        }

        $result = $hours_format.' '.$minute_format;

        return $result;
    }

    public function renderPrintInvoiceUrl() {
        return route('web.history.print', $this->reference_number);
    }

}
