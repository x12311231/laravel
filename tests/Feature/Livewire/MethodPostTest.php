<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\MethodPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class MethodPostTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(MethodPost::class);

        $component->assertStatus(200);
    }
}
