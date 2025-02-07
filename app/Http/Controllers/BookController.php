<?php

namespace App\Http\Controllers;

use App\Services\CandidateApiService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $apiService;

    public function __construct(CandidateApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function destroy($id)
    {
        try{
            $token = session('api_token');
            $success = $this->apiService->deleteBook($token, $id);

            if ($success) {
                return redirect()->back()->with('success', 'Book deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to delete book.');
            }
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
            return back()->withErrors(['error' => $errorResponse['detail'] ?? 'Failed to delete book. Please try again.']);
        }
    }

    public function create()
    {
        try{
            $token = session('api_token');
            $authors = $this->apiService->getAuthors($token,[]);
            $authors = $authors['items'];
            return view('books.create', compact('authors'));
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
            return back()->withErrors(['error' => $errorResponse['detail'] ?? 'Failed to fetch authors. Please try again.']);
        }
    }

    public function store(Request $request)
    {
        $token = session('api_token');

        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required',
            'release_date' => 'required|date',
            'description' => 'required|string|max:2000',
            'isbn' => 'required|string',
            'format' => 'required|in:Hardcover,Paperback,Ebook,Audiobook',
            'number_of_pages' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['author'] = ['id' => (int)$data['author_id']];
        $data['number_of_pages'] = (int)$data['number_of_pages'];
        $data['release_date'] = date('c', strtotime($data['release_date']));
        unset($data['author_id']);


        try {
            $response = $this->apiService->addBook($token, $data);
            if (isset($response['id'])) {
                return redirect()->route('authors.index')->with('success', 'Book added successfully');
            }

            return back()->withErrors(['error' => 'Failed to add book. Please try again.']);

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
            return back()->withErrors(['error' => $errorResponse['detail'] ?? 'Failed to add book. Please try again.']);
        }
    }
}
