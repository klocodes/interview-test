<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PagesController extends Controller
{
    public function home(): InertiaResponse
    {
        return Inertia::render('Home');
    }
}
