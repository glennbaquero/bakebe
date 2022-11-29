<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Controllers\PageTrait;

class PageController extends Controller
{
	use PageTrait;

	/* Show Home */
	public function showHome() {

        return $this->view('guest.pages.home', 'home', [
        	//
        ]);

	}

	/* Show About */
	public function showAbout() {

        return $this->view('guest.pages.about', 'about', [
        	//
        ]);

	}

	/* Show Terms and Conditions */
	public function showTerms() {

        return $this->view('guest.pages.terms', 'terms_and_conditions', [
        	//
        ]);

	}

	/* Show Privacy Policy */
	public function showPrivacy() {

        return $this->view('guest.pages.privacy', 'privacy_policy', [
        	//
        ]);

	}

	/* Show Dashboard */
	public function showDashboard() {

        return $this->view('web.pages.dashboard', 'dashboard', [
        	//
        ]);

	}	
}
