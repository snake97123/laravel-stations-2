<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movie', ['movies' => $movies]);
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {       
            $request->validate([
                'title' => 'required|unique:movies,title',
                'image_url' => 'required|url',
                'published_year' => 'required',
                'is_showing' => 'required',
                'description' => 'required',   
            ]);

         try {
            $movie = new Movie();
            $movie->title = $request->title;
            $movie->image_url = $request->image_url;
            $movie->published_year = $request->published_year;
            $movie->is_showing = $request->is_showing;
            $movie->description = $request->description;
            $movie->save();

            return redirect('/admin/movies');
         } catch (\Exception $e) {
            return redirect()->route('movies.create')->with('error', '映画の作成に失敗しました');
         }
    }
}