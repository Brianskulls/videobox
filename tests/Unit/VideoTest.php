<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use DatabaseTransactions; //After testing reset the database so we dont clutter the actual database

    /*
     * Test that a provided file with a wrong MIME type triggers the form validator and spews out an error.
     */
    public function testFileUploadedMimeTypeIsValidated()
    {
        Schema::disableForeignKeyConstraints();
        //A default user is made according to the UserFactory->definition() function and is saved in the database.
        $user = User::factory()->create();
        Schema::enableForeignKeyConstraints();

        $role = Role::where('id',3)->first();
        $user->roles()->attach($role->id); //Give the user Reporter role

        $response = $this->actingAs($user)
            ->post(route('videos.store'), [
                'file' => UploadedFile::fake()->create('test.mp4', 100, 'image/jpeg'),
                'thumbnail' => UploadedFile::fake()->create('thumbnail.png', 50, 'image/png'),
                'title' => 'Test title',
                'description' => 'Test description',
                'subject' => 'History'
            ]);

        //As the 'file' has a image/jpeg MIME type, we should expect an error to occur.
        $response->assertSessionHasErrors();
    }
}
