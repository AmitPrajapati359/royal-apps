<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CandidateApiService;
use Illuminate\Filesystem\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $apiService;
    public function __construct(CandidateApiService $apiService)
    {
        $this->middleware('auth');
        $this->apiService = $apiService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
