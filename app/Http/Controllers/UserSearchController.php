<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserSearchHistory;
use Illuminate\Support\Facades\Auth;

class UserSearchController extends Controller
{
    public function index()
    {
        $userSearchHistories = UserSearchHistory::with('user');

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

        return view('search.filter', [
            'searchHistory' => $searchHistory,
            'keywords' => $keywords,
            'users' => $users
        ]);
    }

    public function search(Request $request)
    {
        // perform search logic here...
        $searchResults = $this->generateLoremIpsum(10);

        // create new UserSearchHistory entry
        $userSearchHistory = new UserSearchHistory();
        $userSearchHistory->user_id = Auth::user()->id;
        $userSearchHistory->keyword = $request->input('keyword');
        $userSearchHistory->searched_at = now();
        $userSearchHistory->search_results = $searchResults;
        $userSearchHistory->save();

        return view('search.index', ['results' => $searchResults]);
    }

    public function filter(Request $request)
    {
        // Get the current date and time
        $currentDate = Carbon::now();

        $userSearchHistories = UserSearchHistory::with('user');

        // apply filters
        if ($request->has('keyword')) {
            $userSearchHistories->whereIn('keyword', $request->input('keyword'));
        }
        if ($request->has('user_id')) {
            $userSearchHistories->whereIn('user_id', $request->input('user_id'));
        }
        if ($request->has('yesterday')) {
            $userSearchHistories->whereDate('searched_at', Carbon::yesterday());
        }
        if ($request->has('last_week')) {
            $startWeek = Carbon::now()->subWeek()->startOfWeek();
            $endWeek   = Carbon::now()->subWeek()->endOfWeek();

            $userSearchHistories->whereBetween('searched_at', [$startWeek, $endWeek]);
        }
        if ($request->has('last_month')) {
            $lastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();

            $userSearchHistories->whereBetween('searched_at', [$lastMonth, $tillDate]);
        }
        if ($request->has('start_date')) {
            $startDate = Carbon::parse($request->input('start_date'));

            $userSearchHistories->whereDate('searched_at', '>=', $startDate);
        }
        if ($request->has('end_date')) {
            $endDate = Carbon::parse($request->input('end_date'));

            $userSearchHistories->whereDate('searched_at', '<=', $endDate);
        }

        // get search history data
        $searchHistory = $userSearchHistories->get();

        return response([
            'searchHistory' => $searchHistory
        ]);
    }

    private function generateLoremIpsum($numWords): string
    {
        $words = array("Lorem", "ipsum", "dolor", "sit", "amet", "consectetur", "adipiscing", "elit", "sed", "do", "eiusmod", "tempor", "incididunt", "ut", "labore", "et", "dolore", "magna", "aliqua");
        $text = "";

        for ($i = 0; $i < $numWords; $i++) {
            $text .= $words[rand(0, count($words) - 1)] . " ";
        }

        return $text;
    }
}
