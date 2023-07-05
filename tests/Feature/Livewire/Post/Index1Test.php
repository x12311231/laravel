<?php

namespace Tests\Feature\Livewire\Post;

use App\Http\Livewire\Post\Index1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class Index1Test extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Index1::class);

        $component->assertStatus(200);
    }
}
