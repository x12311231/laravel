<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(User::class);

        $component->assertStatus(200);
    }
}
