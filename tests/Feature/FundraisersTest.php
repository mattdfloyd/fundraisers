<?php

namespace Tests\Feature;

use App\Fundraiser;
use App\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FundraisersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_fundraiser_can_be_added()
    {
        $this->post('/fundraisers', [
            'name' => 'fundraiser name',
        ]);

        $this->assertDatabaseHas('fundraisers', [
            'name' => 'fundraiser name',
        ]);
        $this->assertEquals(1, Fundraiser::count());
    }

    /** @test */
    public function name_is_required_when_creating_fundraiser()
    {
        $response = $this->post('/fundraisers', [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_fundraiser_name_must_be_unique()
    {
        factory(Fundraiser::class)->create([
            'name' => 'example fundraiser',
        ]);

        $response = $this->post('/fundraisers', [
            'name' => 'example fundraiser',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function it_redirects_to_fundraiser_after_creating_fundraiser()
    {
        $response = $this->post('/fundraisers', [
            'name' => 'example fundraiser',
        ]);

        $fundraiser = Fundraiser::first();
        $response->assertRedirect("/fundraisers/{$fundraiser->id}");
    }

    /** @test */
    public function fundraisers_are_listed_best_to_worst()
    {
        factory(Fundraiser::class, 10)
            ->create()
            ->each(function ($fundraiser) {
                $fundraiser->reviews()->saveMany(
                    factory(Review::class, 10)->make(['fundraiser_id' => null])
                );
            });

        $response = $this->get('/fundraisers');

        $this->assertEquals(
            Fundraiser::all()
                ->sortByDesc('rating_avg')
                ->pluck('rating_avg'),
            $response->viewData('fundraisers')
                ->pluck('rating_avg')
        );
    }
}
