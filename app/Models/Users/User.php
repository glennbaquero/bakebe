<?php

namespace App\Models\Users;

use App\Extenders\Models\BaseUser as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\Web\Auth\ResetPassword;
use App\Notifications\Web\Auth\VerifyEmail;
use Password;

use Carbon\Carbon;

use App\Models\Carts\Cart;
use App\Models\Invoices\Invoice;
use App\Models\Coupons\CouponUsage;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    const FILLABLE = ['first_name', 'last_name', 'email', 'birthday', 'gender', 'username', 'telephone_number', 'mobile_number'];

    protected $casts = [
        'birthday' => 'date',
    ];

    /**
     * @Mutators
     */
    public function setBirthdayAttribute($value) {
        if (strtotime($value)) {
            $date = Carbon::parse($value);
            $this->attributes['age'] = $date->age;
        }

        $this->attributes['birthday'] = $value;
    }

    /**
     * Overrides default reset password notification
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    /* Overrides default verification notification */
    public function sendEmailVerificationNotification() {
        $this->notify(new VerifyEmail);
    }

    public function device_tokens() {
        return $this->morphMany(DeviceToken::class, 'user');
    }

    public function providers() {
        return $this->morphMany(SocialiteProvider::class, 'user');
    }

    /* Overrides default forgot password */
    public function broker() {
        return Password::broker('users');
    }

    /**
     * JWT Configurations
     */
    public function getJWTCustomClaims(): array {
        return [
            'guard' => 'web',
        ];
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /*
     * Relationship
     */
    
    public function carts() {
        return $this->hasMany(Cart::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function couponUsages() {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username,
            'gender' => $this->gender,
            'mobile_number' => $this->mobile_number,
            'telephone_number' => $this->telephone_number,
        ];
    }

    /**
     * @Renders
     */
    
    public function isIncomplete() {
        return in_array(null, [
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->username,
            $this->gender,
            $this->mobile_number,
            $this->birthday,
        ]);
    }
    
    /* User Verification Status */
    public function renderStatus($showLabel = true) {
        $result = $showLabel ? 'Unverified' : 'bg-danger';

        if ($this->email_verified_at) {
            $result = $showLabel ? 'Verified' : 'bg-success';
        }

        return $result;
    }

    public function renderShowUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return route($prefix . '.profiles.show');
        }
        
        return route($prefix . '.users.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return;
        }

        return route($prefix . '.users.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return;
        }

        return route($prefix . '.users.restore', $this->id);
    }

    /**
     * Get user active cart
     * 
     * @return object
     */
    public function getCart() {

        $active_cart = $this->carts->where('is_active', true)->first();

        if(!$active_cart) {
            $active_cart = $this->createCart();
        }

        return $active_cart;
    }

    /**
     * Create cart if user has no active cart
     *
     * @return  object
     */
    public function createCart() {
        $active_cart = $this->carts()->create([ 'user_id' => $this->id ]);

        return $active_cart;
    }

    public function renderFullname() {
        return ucwords($this->first_name. ' '. $this->last_name);
      }

}