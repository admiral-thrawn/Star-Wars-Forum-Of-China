<?php

namespace App\Http\Controllers\Search;

use App\Models\Article;
use App\Models\Column;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function all(Request $request)
    {
        $q = $request->get('q');

        $articles = Article::search($q)->get();
        $posts = Post::search($q)->get();
        $users = User::search($q)->get();

        return response([
            'data' => [
                "articles" => $articles,
                "posts" => $posts,
                "users" =>$users]
        ], Response::HTTP_OK);
    }

    // public function postsAndAricles()
    // {

    // }
}
