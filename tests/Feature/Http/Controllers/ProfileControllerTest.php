<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProfileController
 */
class ProfileControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $profiles = Profile::factory()->count(3)->create();

        $response = $this->get(route('profile.index'));

        $response->assertOk();
        $response->assertViewIs('profile.index');
        $response->assertViewHas('profiles');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('profile.create'));

        $response->assertOk();
        $response->assertViewIs('profile.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProfileController::class,
            'store',
            \App\Http\Requests\ProfileStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $webSite = $this->faker->word;
        $sex = $this->faker->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

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

        $response->assertRedirect(route('profile.index'));
        $response->assertSessionHas('profile.id', $profile->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $profile = Profile::factory()->create();

        $response = $this->get(route('profile.show', $profile));

        $response->assertOk();
        $response->assertViewIs('profile.show');
        $response->assertViewHas('profile');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $profile = Profile::factory()->create();

        $response = $this->get(route('profile.edit', $profile));

        $response->assertOk();
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('profile');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProfileController::class,
            'update',
            \App\Http\Requests\ProfileUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $profile = Profile::factory()->create();
        $webSite = $this->faker->word;
        $sex = $this->faker->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('profile.update', $profile), [
            'webSite' => $webSite,
            'sex' => $sex,
            'user_id' => $user->id,
        ]);

        $profile->refresh();

        $response->assertRedirect(route('profile.index'));
        $response->assertSessionHas('profile.id', $profile->id);

        $this->assertEquals($webSite, $profile->webSite);
        $this->assertEquals($sex, $profile->sex);
        $this->assertEquals($user->id, $profile->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $profile = Profile::factory()->create();

        $response = $this->delete(route('profile.destroy', $profile));

        $response->assertRedirect(route('profile.index'));

        $this->assertModelMissing($profile);
    }
}
