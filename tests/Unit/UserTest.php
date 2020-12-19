<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUser()
    {
        // $user = new User([
        //     "id"=> "34f4c5a1-19e8-4df4-8892-7b5a3ce95eb0",
        //     "name"=> "skywalkerss",
        //     "email"=> "sws@gmail.com",
        //     "desciption"=> null,
        //     "password"=> bcrypt("123"),
        //     "nickName"=> "Skywalker",
        //     "avatar"=> "s.png",
        //     "slogan"=> "hahdvasdfasdfahahahahaha",]);
        // $user->save();

        $user = User::find('f742d8ce-05ee-4e2a-bab3-a4adf7a4ebb3');
        Bouncer::allow('member')->to('create',Post::class);
        $user->assign('member');
        dd($abilities = $user->getAbilities());
    }
}
