<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }
    
        if ($request->filled('is_showing')) {
            $query->where('is_showing', $request->input('is_showing'));
        }
    
        $movies = $query->paginate(20);
        return view('movie.index', ['movies' => $movies]);
    }
}