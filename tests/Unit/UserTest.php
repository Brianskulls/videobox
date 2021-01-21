<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Video;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions; //After testing reset the database so we dont clutter the actual database

    /*
     * The saved username should be he expected value. We do this test to make sure the saving and retrieving of database data
     * works.
     */
    public function testEditedUserIsSaved()
    {
        //We need to disable & enable foreign key constraints, as Eloquent otherwise spews out errors
        Schema::disableForeignKeyConstraints();
        //A default user is made according to the UserFactory->definition() function and is saved in the database.
        $user = User::factory()->create();
        Schema::enableForeignKeyConstraints();


        $id = $user->id;
        $expectedName = 'Demetrius Demarcus Bartholomew James the third Jr';

        $user->name = $expectedName;
        $user->save(); //User should now be saved and have $expectedName as the username


        //Get the user fresh from the database. This SHOULD hold the new name
        $user = User::where('id',$id)->first();

        //... and assert that the name of this user matches $expectedName. If this is not the case, the edited user
        // has NOT been saved to the database
        $this->assertEquals($expectedName, $user->name);
    }

    /*
     * User should NOT have access to the /videos/create route without the appropriate role.
     */
    public function testUserDoesNotHaveAccessToRoute()
    {
        Schema::disableForeignKeyConstraints();
        //A default user is made according to the UserFactory->definition() function and is saved in the database.
        $user = User::factory()->create();
        Schema::enableForeignKeyConstraints();

        $response = $this->actingAs($user)
            ->get('/videos/create');

        //As $user does not have a high enough role, they should get a HTTP 403 (forbidden) code.
        self::assertEquals(403, $response->getStatusCode());
    }

    /*
     * Make sure that a user can't view another user's task
     */
    public function testUserCantViewOtherUserTask()
    {
        Schema::disableForeignKeyConstraints();
        //A default user is made according to the UserFactory->definition() function and is saved in the database.
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        Schema::enableForeignKeyConstraints();

        $task = new Task([
            'title'       => 'Do the groceries',
            'description' => 'Lorem ipsum dolor sit amet',
            'user_id'     => $user1->id
            ]);
        $task->save();

        $response = $this->actingAs($user2)
            ->get('/tasks/'.$task->id);

        //As $user does not own the created task, they should get a HTTP 403 (forbidden) code.
        self::assertEquals(403, $response->getStatusCode());
    }
}
