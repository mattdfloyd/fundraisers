<?php

use App\Fundraiser;
use App\Review;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

class DatabaseSeeder extends Seeder
{
    use WithFaker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpFaker();

        factory(Fundraiser::class, 1)
            ->create([
                'name' => 'Booster',
                'created_at' => function () {
                    return $this->faker->dateTimeThisMonth();
                },
            ])
            ->each(function ($fundraiser) {
                $fundraiser->reviews()->saveMany(
                    factory(Review::class, rand(80, 120))->make([
                        'fundraiser_id' => null,
                        'rating' => 5,
                        'created_at' => function () use ($fundraiser) {
                            return $this->faker->unique()->dateTimeBetween($fundraiser->created_at, 'now');
                        },
                    ])
                );
            });

        factory(Fundraiser::class, 10)
            ->create([
                'created_at' => function () {
                    return $this->faker->dateTimeThisYear();
                },
            ])
            ->each(function ($fundraiser) {
                $fundraiser->reviews()->saveMany(
                    factory(Review::class, rand(8, 12))->make([
                        'fundraiser_id' => null,
                        'created_at' => function () use ($fundraiser) {
                            return $this->faker->unique()->dateTimeBetween($fundraiser->created_at, 'now');
                        },
                    ])
                );
            });
    }
}
