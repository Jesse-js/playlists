<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{

    protected $model = Content::class;

    public function definition()
    {
        $playlistIds = Playlist::pluck('id')->all();

        return [
            'playlist_id' => $this->faker->randomElement($playlistIds),
            'title' => $this->faker->text(5),
            'author' => $this->faker->text(5),
            'url' => $this->faker->url('https'),
        ];
    }
}
