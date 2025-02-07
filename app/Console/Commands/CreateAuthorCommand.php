<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CandidateApiService;

class CreateAuthorCommand extends Command
{
    protected $signature = 'author:create';
    protected $description = 'Create a new author via API';
    protected $candidateApiService;

    public function __construct(CandidateApiService $candidateApiService)
    {
        parent::__construct();
        $this->candidateApiService = $candidateApiService;
    }

    public function handle()
    {

        $firstName = $this->ask('Enter First Name');
        $lastName = $this->ask('Enter Last Name');
        $gender = $this->choice('Select Gender', ['male', 'female', 'other'], 0);
        $biography = $this->ask('Enter Biography');
        $placeOfBirth = $this->ask('Enter Place of Birth');
        $token = $this->ask('Enter User Access Token');
        // you need to generate token from swagger api tool and pass it here

        // Prepare data
        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'birthday' => now()->toIso8601String(),
            'biography' => $biography,
            'gender' => $gender,
            'place_of_birth' => $placeOfBirth
        ];

        if (!$token) {
            $this->error("API token is missing. Please generate from Swagger.");
            return;
        }

        // Call API to create author
        try {
            $response = $this->candidateApiService->addAuthor($token, $data);
            $this->info("Author created successfully: " . json_encode($response));
        } catch (\Exception $e) {
            $this->error("Failed to create author: " . $e->getMessage());
        }
    }
}
