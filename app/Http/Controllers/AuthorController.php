<?php

namespace App\Http\Controllers;

use App\Services\CandidateApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    protected $apiService;

    public function __construct(CandidateApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index()
    {
        return view('authors.index');
    }

    public function search(Request $request)
    {
        if($request->ajax()) {

            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $search = $request->input('search')['value'];
            $orderColumn = $request->input('order')[0]['column'];
            $orderDirection = $request->input('order')[0]['dir'];
            $currentPage = ($request->start == 0) ? 1: (($request->start/$request->length) + 1);
            $startNo = ( $request->start == 0 ) ? 1 : ( ($request->length) * ($currentPage -1) )+1;

            $columns = $request->input('columns');
            $orderBy = $columns[$orderColumn]['data'];

            $token = session('api_token');

            $apiParams = [
                'query' => $search,
                'orderBy' => $orderBy,
                'direction' => $orderDirection == 'asc' ? 'ASC' : 'DESC',
                'limit' => $length,
                'page' => (string)floor($start / $length) + 1,  // Calculate page number
            ];

            $response = $this->apiService->getAuthors($token, $apiParams);
            foreach ($response['items'] as $key => $data) {

                $params = [
                    'id' =>  $data['id']
                ];

                $response['items'][$key]['gender'] = Str::upper($response['items'][$key]['gender']);
                $response['items'][$key]['sr_no'] = $startNo+$key;
                $viewRoute = route('authors.show', $params);

                $deleteRoute = route('authors.destroy', $params);

                $response['items'][$key]['action'] = '<a href="'.$viewRoute.'" class="btn btn-success" title="View">View</a>&nbsp&nbsp';
            $response['items'][$key]['action'] .=  '<a href="javascript:void(0);" data-url="' . $deleteRoute . '" class="btn btn-danger btnDelete" data-title="Author"  title="Delete">Delete</a>&nbsp&nbsp';
            }

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $response['total_results'],
                'recordsFiltered' => $response['total_results'],
                'data' => $response['items'],
            ]);
        }
    }

    public function destroy($id)
    {
        try
        {
            $token = session('api_token');

            // Fetch the author's details to check if they have any books
            $author = $this->apiService->getAuthorDetails($token, $id);

            if (empty($author['books'])) {

                // Delete the author if they have no books
                $success = $this->apiService->deleteAuthor($token, $id);

                if ($success) {
                    return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
                } else {
                    return redirect()->route('authors.index')->with('error', 'Failed to delete author.');
                }
            } else {
                return redirect()->route('authors.index')->with('error', 'Cannot delete author with related books.');
            }
        }
        catch(\GuzzleHttp\Exception\ClientException $e)
        {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
            return back()->withErrors(['error' => $errorResponse['detail'] ?? 'Failed to delete author. Please try again.']);
        }
    }

    public function show($id)
    {
        try{
            $token = session('api_token');
            $author = $this->apiService->getAuthorDetails($token, $id);
            return view('authors.show', compact('author'));
        }
        catch(\GuzzleHttp\Exception\ClientException $e)
        {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            \Log::error('API Request Failed: ' . json_encode($errorResponse, JSON_PRETTY_PRINT));
            return back()->withErrors(['error' => $errorResponse['detail'] ?? 'Failed to fetch author details. Please try again.']);
        }
    }
}
