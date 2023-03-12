<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSearchHistory;
use Illuminate\Support\Facades\Auth;

class UserSearchController extends Controller
{
    public function index(Request $request)
    {
        $userSearchHistories = UserSearchHistory::with('user');

        // apply filters
        if ($request->has('keyword')) {
            $userSearchHistories->where('keyword', $request->input('keyword'));
        }
        if ($request->has('user_id')) {
            $userSearchHistories->where('user_id', $request->input('user_id'));
        }
        if ($request->has('start_date')) {
            $userSearchHistories->where('searched_at', '>=', $request->input('start_date'));
        }
        if ($request->has('end_date')) {
            $userSearchHistories->where('searched_at', '<=', $request->input('end_date'));
        }

        // get search history data
        $searchHistory = $userSearchHistories->get();

        // get unique keywords and count
        $keywords = $searchHistory->pluck('keyword')->unique()->map(function ($keyword) use ($searchHistory) {
            $count = $searchHistory->where('keyword', $keyword)->count();
            return [
                'keyword' => $keyword,
                'count' => $count,
            ];
        });

        // get unique user IDs and names
        $users = $searchHistory->pluck('user')->unique('id')->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });

        return view('search.index', [
            'searchHistory' => $searchHistory,
            'keywords' => $keywords,
            'users' => $users,
            'filters' => $request->all(),
        ]);
    }

    public function search(Request $request)
    {
        // perform search logic here...
        $searchResults = 'Test search result';

        // create new UserSearchHistory entry
        $userSearchHistory = new UserSearchHistory();
        $userSearchHistory->user_id = Auth::user()->id;
        $userSearchHistory->keyword = $request->input('keyword');
        $userSearchHistory->searched_at = now();
        $userSearchHistory->search_results = json_encode($searchResults);
        $userSearchHistory->save();

        return view('search.index', ['results' => $searchResults]);
    }
}
