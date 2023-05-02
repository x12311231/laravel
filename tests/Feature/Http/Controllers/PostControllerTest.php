<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\NewPost;
use App\Jobs\SyncMedia;
use App\Mail\ReviewPost;
use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
class PostControllerTest extends TestCase
{
//    use AdditionalAssertions;
    use RefreshDatabase, WithFaker;

    public function test_avatars_can_be_uploaded(): void
    {
        Storage::fake('avatars');

        $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'avatar' => $file,
        ];
        $response = $this->post('/avatar', $data);

        Storage::disk('avatars')->assertExists($file->hashName());
    }
    public function test_store()
    {
        $this->actingAs(User::factory()->create(), 'web');
        $title = 'test post ' . time();
        $data = [
            'title' => $title,
            'content' => 'this is a post',
            'image' => \Illuminate\Http\UploadedFile::fake()->image('test.jpeg'),
        ];
        $route = route('post.store');
        $response = $this->post($route, $data);
        $response->assertStatus(302);
        $this->assertDatabaseCount(Post::class, 1);
        $this->assertDatabaseHas(Post::class, ['title' => $title]);
    }
    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $this->actingAs(User::factory()->create(), 'web');
        $response = $this->get(route('post.create'));

        $response->assertOk();
        $response->assertViewIs('post.create');
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $this->actingAs(User::factory()->create(), 'web');
        $post = Post::factory()->create();

        $response = $this->get(route('post.show', $post));

        $response->assertOk();
        $response->assertViewIs('post.show');
        $response->assertViewHas('post');
    }


    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $this->actingAs(User::factory()->create(), 'web');
        $posts = Post::factory()->count(3)->create();

        $response = $this->get(route('post.index'));

        $response->assertOk();
        $response->assertViewIs('post.index');
        $response->assertViewHas('posts');
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
        $content = $this->faker->paragraphs(3, true);
        $author = User::factory()->create();
        $this->actingAs($author);

        Mail::fake();
        Queue::fake();
        Event::fake();

        $response = $this->post(route('post.store'), [
            'title' => $title,
            'content' => $content,
//            'author_id' => $author->id,
            'image' => \Illuminate\Http\UploadedFile::fake()->image('tttt.jpeg'),
        ]);

        $posts = Post::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('author_id', $author->id)
            ->get();
        $this->assertCount(1, $posts);
        $post = $posts->first();

        $response->assertRedirect(route('post.index'));
        $response->assertSessionHas('post.title', $post->title);

//        Mail::assertSent(ReviewPost::class, function ($mail) use ($post) {
//            return $mail->hasTo($post->author->email) && $mail->post->is($post);
//        });
        Queue::assertPushed(SyncMedia::class, function ($job) use ($post) {
            return $job->post->is($post);
        });
        Event::assertDispatched(NewPost::class, function ($event) use ($post) {
            return $event->post->is($post);
        });
    }
}
