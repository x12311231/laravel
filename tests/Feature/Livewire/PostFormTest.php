<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\PostForm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class PostFormTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(PostForm::class);

        $component->assertStatus(200);
    }
}
