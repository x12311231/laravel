<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\FormSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormSearchTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(FormSearch::class);

        $component->assertStatus(200);
    }
}
