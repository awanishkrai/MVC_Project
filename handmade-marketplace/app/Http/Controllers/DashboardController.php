<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
  public function buyer()
  {
    return view('dashboards.buyer', [
      'user' => auth()->user(),
    ]);
  }

  public function seller()
  {
    return view('dashboards.seller', [
      'user' => auth()->user(),
    ]);
  }

  public function admin()
  {
    return view('dashboards.admin', [
      'user' => auth()->user(),
    ]);
  }
}
