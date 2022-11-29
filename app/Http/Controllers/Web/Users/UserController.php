<?php

namespace App\Http\Controllers\Web\Users;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\User\UserStoreRequest;
use App\Http\Requests\Web\User\PasswordStoreRequest;

use App\Models\User\User;

use Hash;
use DB;

class UserController extends Controller
{

    /**
     * Update user password
     */
    
    public function fetchView(Request $request)
    {
        $item = $request->user();

        $item->image_path = $item->renderImagePath();
        return response()->json([
            'item' => $item,
        ]);

    }

	/**
	 * Update user password
	 *
	 * @return [boolean/string] $is_updated
	 */
    public function updatePassword(Request $request) {
    	$user = auth()->guard('web')->user();
    	$old_password = $user->password;
    	$new_password = Hash::make($request->new_password);
    	DB::beginTransaction();
    		if($request->new_password != $request->password_confirmation) {
    			throw ValidationException::withMessages([
    			    'password_confirm' => ['Password did not match.']
    			]);
    		}

    		if(Hash::check($request->old_password, $old_password)) {
    			$user->update([
    				'password' => $new_password
    			]);
    		} else {
    			throw ValidationException::withMessages([
    			    'old_password' => ['Old password did not match.']
    			]);
    		}
    	DB::commit();

    	return response()->json([
    		'is_updated' => true
    	]);
    }

    /**
     * Update user profile
     *
     * @return [boolean/string] $is_updated
     */
    
    public function updateProfile(UserStoreRequest $request) {
    	$user = auth()->guard('web')->user();

    	DB::beginTransaction();
    		$user->update([
    			'first_name' => $request->first_name,
    			'last_name' => $request->last_name,
    			'mobile_number' => $request->mobile_number,
    		]);
    		
    		if($request->hasFile('image_path')) {
    			$user->storeImage($request->file('image_path'), 'image_path', 'user-avatars');
    		}

    	DB::commit();

    	return response()->json([
    		'is_updated' => true
    	]);
    }
}
