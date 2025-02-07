<?php

namespace App\Http\Controllers;

use App\Services\CandidateApiService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $apiService;

    public function __construct(CandidateApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $response = $this->apiService->login($request->email, $request->password);
            if (isset($response['token_key'])) {
                session(['api_token' => $response['token_key']]);
                session(['user' => $response['user']]);
                session(['expires_at' => $response['expires_at']]);
                session(['refresh_token' => $response['refresh_token_key']]);

                return redirect()->route('authors.index');
            }

            return back()->withErrors(['email' => 'Invalid credentials']);
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
            return back()->withErrors(['error' => $errorResponse['detail'] ?? 'Failed to login. Please try again.']);
        }
    }

    public function logout()
    {
        try{
            session()->forget('api_token');
            session()->forget('user');
            session()->forget('expires_at');
            session()->forget('refresh_token');

            return redirect()->route('login');
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
        }

    }
}
