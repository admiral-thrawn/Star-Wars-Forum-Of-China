<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInsertArticle()
    {
        $user = User::factory()->create();

        $article = Article::factory()->state(['author_id'=>$user->id])->create();

        $this->assertNotNull(Article::where('title', 'testing'));

        $article->forceDelete();

        $user->forceDelete();
    }

    public function testFindArticle()
    {
        $user = User::factory()->create();

        $article = Article::factory()->state(['author_id' => $user->id])->create();

        $this->assertNotNull(Article::where('title', 'testing'));

        $article->forceDelete();

        $user->forceDelete();
    }

    public function testNotFoundArticle()
    {
        $this->assertNull(Article::find('asvasc'));
    }
}
