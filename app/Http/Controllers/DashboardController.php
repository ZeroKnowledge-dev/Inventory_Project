<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller {

	public function DashboardPage() {
		return Inertia::render('Dashboard');
	}
}
