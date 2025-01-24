<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('admin.edit', ['movie' => $movie]);
    }

    // Requestをつけなかったらエラーになったので原因を調べる。
    public function update(Request $request) 
    {
        $request->validate([
            'title' =>  ['required', Rule::unique('movies')->ignore($request->id)],
            'image_url' => 'required|url',
            'published_year' => 'required',
            'is_showing' => 'required',
            'description' => 'required',   
        ]);

        try {
            $movie = Movie::find($request->id);
            $movie->title = $request->title;
            $movie->image_url = $request->image_url;
            $movie->published_year = $request->published_year;
            $movie->is_showing = $request->is_showing;
            $movie->description = $request->description;
            $movie->save();

            return redirect('/admin/movies');
        } catch (\Exception $e) {
            return redirect()->route('movies.edit', ['id' => $request->id])->with('error', '映画の更新に失敗しました');
        }
    }

    public function delete($id)
    {
        $movie = Movie::findOrFail($id);

        try {    
            $movie->delete();
            return redirect('/admin/movies')->with('success', '映画の削除が完了しました');
        } catch (\Exception $e) {
            return redirect('/admin/movies')->with('error', '映画の削除に失敗しました');
        }
    }
}