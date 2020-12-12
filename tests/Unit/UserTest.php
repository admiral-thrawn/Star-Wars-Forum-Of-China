<?php

namespace Tests\Unit;

use App\Models\User;
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
        $user = User::find('34f4c5a1-19e8-4df4-8892-7b5a3ce95eb0');

        // dd($user);

        dd($user->roles()->first()->code);
    }
}
