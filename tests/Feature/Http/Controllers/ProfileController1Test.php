<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileController1Test extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_store_saves_and_redirects(): void
    {

        $webSite = 'http://localhost';
        $user = User::factory()->create();
        $this->actingAs($user);

        $sex = 'male';
        $response = $this->post(route('profile.store'), [
            'webSite' => $webSite,
            'sex' => $sex,
//            'user_id' => $user->id,
        ]);

        $profiles = Profile::query()
            ->where('webSite', $webSite)
            ->where('sex', $sex)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $profiles);
        $profile = $profiles->first();

//        $response->assertRedirect(route('profile.index'));
//        $response->assertSessionHas('profile.id', $profile->id);
    }
}
