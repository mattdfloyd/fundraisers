<?php

namespace Tests\Feature;

use App\Fundraiser;
use App\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->fundraiser = factory(Fundraiser::class)->create();
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'matt',
            'email' => 'matt@example.com',
            'rating' => '3',
        ], $overrides);
    }

    /** @test */
    public function it_requires_a_valid_email_to_create_review()
    {
        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'email' => 'not-an-email',
        ]));

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_requires_a_name_to_create_review()
    {
        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'name' => '',
        ]));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_review_must_be_between_one_and_five_stars()
    {
        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => '',
        ]));

        $response->assertSessionHasErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => 'a',
        ]));

        $response->assertSessionHasErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => '0',
        ]));

        $response->assertSessionHasErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => -1,
        ]));

        $response->assertSessionHasErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => '-1',
        ]));

        $response->assertSessionHasErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => '6',
        ]));

        $response->assertSessionHasErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => '1',
        ]));

        $response->assertSessionDoesntHaveErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => 1,
        ]));


        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => 3,
        ]));

        $response->assertSessionDoesntHaveErrors('rating');

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'rating' => 5,
        ]));

        $response->assertSessionDoesntHaveErrors('rating');
    }

    /** @test */
    public function a_reviewer_cannot_enter_more_than_one_review_for_a_fundraiser()
    {
        factory(Review::class)->create([
            'email' => 'matt@example.com',
            'fundraiser_id' => $this->fundraiser->id,
        ]);

        $response = $this->post("/fundraisers/{$this->fundraiser->id}/reviews", $this->validParams([
            'email' => 'matt@example.com',
            'fundraiser_id' => $this->fundraiser->id,
        ]));

        $response->assertSessionHasErrors('email');
    }
}
