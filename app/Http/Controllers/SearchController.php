<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Column;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function all($q)
    {
        $articles = Article::search($q)->get();
        $posts = Post::search($q)->get();
        $columns = Column::search($q)->get();
        $topics = Topic::search($q)->get();
        $users = User::search($q)->get();

        return response([
            'data' => [$articles, $posts, $columns, $topics, $users]
        ], Response::HTTP_OK);
    }

    // public function postsAndAricles()
    // {

    // }
}
