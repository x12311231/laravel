<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
class PostControllerTest extends TestCase
{
    use AdditionalAssertions, WithFaker;
//    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $posts = Post::factory()->count(3)->create();

        $response = $this->get(route('post.index'));

        $response->assertOk();
        $response->assertViewIs('post.index');
        $response->assertViewHas('posts');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('post.create'));

        $response->assertOk();
        $response->assertViewIs('post.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PostController::class,
            'store',
            \App\Http\Requests\PostStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $title = $this->faker->sentence(4);
        $title = strtoupper($title);
        $content = $this->faker->paragraphs(3, true);
        $author = User::factory()->create();

        $response = $this->post(route('post.store'), [
            'title' => $title,
            'content' => $content,
            'author_id' => $author->id,
        ]);

        $posts = Post::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('author_id', $author->id)
            ->get();
        $this->assertCount(1, $posts);
        $post = $posts->first();

        $response->assertRedirect(route('post.index'));
        $response->assertSessionHas('post.id', $post->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('post.show', $post));

        $response->assertOk();
        $response->assertViewIs('post.show');
        $response->assertViewHas('post');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $post = Post::factory()->create();

        $response = $this->get(route('post.edit', $post));

        $response->assertOk();
        $response->assertViewIs('post.edit');
        $response->assertViewHas('post');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PostController::class,
            'update',
            \App\Http\Requests\PostUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $post = Post::factory()->create();
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);
//        $author = User::factory()->create();
        $author = User::find($post->author_id);
        $this->actingAs($author);

        $response = $this->put(route('post.update', $post), [
            'title' => $title,
            'content' => $content,
            'author_id' => $author->id,
        ]);

        $post->refresh();

        $response->assertRedirect(route('post.index'));
        $response->assertSessionHas('post.id', $post->id);

        $this->assertEquals($title, $post->title);
        $this->assertEquals($content, $post->content);
        $this->assertEquals($author->id, $post->author_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $post = Post::factory()->create();

        $response = $this->delete(route('post.destroy', $post));

        $response->assertRedirect(route('post.index'));

        $this->assertModelMissing($post);
    }
}
