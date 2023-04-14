<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\NewArticle;
use App\Jobs\SyncMedia;
use App\Models\Article;
use App\Models\User;
use App\Notification\ReviewNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ArticleController
 */
class ArticleControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $articles = Article::factory()->count(3)->create();

        $response = $this->get(route('article.index'));

        $response->assertOk();
        $response->assertViewIs('article.index');
        $response->assertViewHas('articles');
    }


    /**
     * @test
     */
    public function show_behaves_as_expected(): void
    {
        $article = Article::factory()->create();

        $route = route('article.show', $article);
        $response = $this->get($route, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ArticleController::class,
            'store',
            \App\Http\Requests\ArticleStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $title = $this->faker->sentence(4);
        $content = $this->faker->paragraphs(3, true);

        Notification::fake();
        Queue::fake();
        Event::fake();
//        $user = User::factory()->create();

        $uri = route('article.store');
        $response = $this->post($uri, [
            'title' => $title,
            'content' => $content,
//            'author_id' => $user->id,
        ], [
            'Accept' => 'application/json',
        ]);

//        $response->assertStatus(200);

        $articles = Article::query()
            ->where('title', $title)
            ->where('content', $content)
            ->get();
        $this->assertCount(1, $articles);
        $article = $articles->first();

        $response->assertRedirect(route('article.index'));
        $response->assertSessionHas('article.title', $article->title);

        Notification::assertSentTo($article->author, ReviewNotification::class, function ($notification) use ($article) {
            return $notification->article->is($article);
        });
        Queue::assertPushed(SyncMedia::class, function ($job) use ($article) {
            return $job->article->is($article);
        });
        Event::assertDispatched(NewArticle::class, function ($event) use ($article) {
            return $event->article->is($article);
        });
    }

    public function test_aritcle_popular()
    {
        $articles = Article::factory()->count(10)->create();
        $aa = [];
        foreach ($articles as $k => $v) {
            $aa[] = 10 - $k;
            for ($i = 0; $i < $k; $i++) {
                $response = $this->get(route('article.show', $v));
                $response->assertOk();
            }
        }
        $route = route('article.popular');
        $response = $this->get($route);
//        $data = $response->json('data');
        $content = json_decode($response->getContent(), true);
        $content = array_column($content, 'id');
        $this->assertEquals($content, $aa);
        $response->assertOk();
    }
}
