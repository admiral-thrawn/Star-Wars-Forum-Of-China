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
    public function testFindUser()
    {
        $user = User::factory()->create();
        $this->assertNotNull(User::find($user->id));
        $user->forceDelete();
    }

    public function testNotFoundUser()
    {
        $this->assertNull(User::find('asfadva'));
    }

    public function testInsertUser()
    {
        $user = User::factory()->create();

        $this->assertNotNull(User::where('email', $user->email));
        $user->forceDelete();
    }
}
