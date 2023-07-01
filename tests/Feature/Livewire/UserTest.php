<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(User::class)
//            ->set('name', '')
//            ->assertHasErrors(['name' => 'required'])
        ->set('article.title', '')
//            ->assertHasErrors(['article.title' => 'required'])
            ->assertHasNoErrors(['article.title'])
            ->set('article.title', 'a')
//            ->call('updated')
            ->assertHasNoErrors(['article.title'])

        ;

        $component->assertStatus(200);
    }

    public function test_u_a()
    {
        $testResponse = $this->get(route('u.a', ['article' => '1']));
        $testResponse->assertOk();
    }
}
