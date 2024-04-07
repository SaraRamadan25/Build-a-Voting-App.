<?php

namespace Tests\Feature;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdeaControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page()
    {
        $this->withoutExceptionHandling();

        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Idea',
            'description' => 'Description of my second idea',
        ]);

        $response = $this->get(route('ideas.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
    }

    /** @test */
    public function single_idea_shows_correctly_on_the_show_page()
    {
        $user = User::factory()->create();
        $idea = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first idea',
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('ideas.show', $idea->id));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }
}
