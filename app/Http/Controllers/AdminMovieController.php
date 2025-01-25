<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::join('genres', 'movies.genre_id', '=', 'genres.id')
            ->select('movies.*', 'genres.name as genre')
            ->get();
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
                'genre' => 'required',  
            ]);

         try {
            DB::beginTransaction();
            // もしジャンルテーブルに登録がなかったら、新しく登録してそのidの取得。登録があったらそのジャンルのidを取得する。
            $genre = Genre::firstOrCreate(['name' => $request->genre]);

            $movie = new Movie();
            $movie->title = $request->title;
            $movie->image_url = $request->image_url;
            $movie->published_year = $request->published_year;
            $movie->is_showing = $request->is_showing;
            $movie->description = $request->description;
            $movie->genre_id = $genre->id;
            $movie->save();

            DB::commit();

            return redirect('/admin/movies');
         } catch (\Exception $e) {
            DB::rollBack();
            // return redirect()->route('movies.create')->with('error', '映画の作成に失敗しました');
            abort(500, '映画の更新中にエラーが発生しました。');
         }
    }

    public function edit($id)
    {
        $movie = Movie::with('genre')->find($id);
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
            'genre' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $genre = Genre::firstOrCreate(['name' => $request->genre]);
            $movie = Movie::find($request->id);
            $movie->title = $request->title;
            $movie->image_url = $request->image_url;
            $movie->published_year = $request->published_year;
            $movie->is_showing = $request->is_showing;
            $movie->description = $request->description;
            $movie->genre_id = $genre->id;
            $movie->save();

            DB::commit();

            return redirect('/admin/movies');
        } catch (\Exception $e) {
            DB::rollBack();
            // return redirect()->route('movies.edit', ['id' => $request->id])->with('error', '映画の更新に失敗しました');
            abort(500, '映画の更新中にエラーが発生しました。');
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