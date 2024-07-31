<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\invoice;

class AdminHomeController extends Controller
{
    public function index()
    {
        $revenues = invoice::selectRaw('DATE(date_created) as date, SUM(price_total) as total')->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        return view('admin.home', compact('revenues'));
    }
}
