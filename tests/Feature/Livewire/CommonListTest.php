<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\CommonList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class CommonListTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(CommonList::class);

        $component->assertStatus(200);
    }
}
