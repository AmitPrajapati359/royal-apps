<?php

namespace App\Services;

use GuzzleHttp\Client;

class CandidateApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('constant.CANDIDATE_API_BASE_URL');
    }

    public function login($email, $password)
    {
        $response = $this->client->post("$this->baseUrl/token", [
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function refreshToken()
    {
        $refreshToken = session('refresh_token');

        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token is missing.'], 401);
        }

        $response = $this->client->post("$this->baseUrl/refresh-token", [
            'json' => [
                'refresh_token' => $refreshToken,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['token_key'])) {
            session(['api_token' => $data['token_key']]);
            session(['expires_at' => $data['expires_at']]);
            session(['refresh_token' => $data['refresh_token_key']]);

            return true;
        }

        return false;
    }

    public function isTokenExpired()
    {
        $expiresAt = session('expires_at');
        return strtotime($expiresAt) < time();
    }


    public function getAuthors($token,$params)
    {

        

        $response = $this->client->get("$this->baseUrl/authors",[
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json',
            ],
            'query' => $params,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deleteAuthor($token, $authorId)
    {
        $response = $this->client->delete("$this->baseUrl/authors/$authorId", [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        return $response->getStatusCode() === 204; // 204 means successful deletion
    }

    public function getAuthorDetails($token, $authorId)
    {
        $response = $this->client->get("$this->baseUrl/authors/$authorId", [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deleteBook($token, $bookId)
    {
        $response = $this->client->delete("$this->baseUrl/books/$bookId", [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        return $response->getStatusCode() === 204; // 204 means successful deletion
    }

    public function addBook($token, $data)
    {
        \Log::info(json_encode($data));
        $response = $this->client->post("$this->baseUrl/books", [
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getLoginUser($token)
    {
        $response = $this->client->get("$this->baseUrl/me", [
            'headers' => [
                'Authorization' => "Bearer $token",
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
