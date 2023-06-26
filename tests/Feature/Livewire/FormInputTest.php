<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\FormInput;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormInputTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(FormInput::class);

        $component->assertStatus(200);
    }
}
