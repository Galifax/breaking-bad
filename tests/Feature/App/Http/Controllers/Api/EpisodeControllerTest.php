<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Models\Character;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Closure;
use stdClass;
use Tests\TestCase;
use Tests\Traits\ResponseStructureTrait;

class EpisodeControllerTest extends TestCase
{
    use ResponseStructureTrait;

    public function testUnauthorized(): void
    {
        $response = $this->getJson('/api/episodes');

        $response->assertUnauthorized();
    }

    /**
     * @dataProvider dataIndex
     */
    public function testIndex(Closure $data): void
    {
        $episodes = Episode::factory(20)
            ->create()
            ->sortByDesc('air_date');

        $data = $data($episodes);

        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/episodes?'.$data->query);

        $response->assertStatus(200);

        $response->assertJsonStructure($this->paginateResponseStructure());

        $this->assertEquals(
            array_column($response->json()['data'], 'id'),
            $data->expectedIds
        );
    }

    /**
     * @dataProvider dataIndexValidationError
     */
    public function testIndexValidationError(string $query, array $errors): void
    {
        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/episodes?'.$query);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'error' => [
                'fields' => $errors
            ]
        ]);
    }

    public function testShow()
    {
        /** @var Episode $episode */
        $episode = Episode::factory()
            ->createOne();

        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/episodes/'.$episode->id);

        $response->assertStatus(200);

        $this->assertEquals($response->json('data.id'), $episode->id);

        $response->assertJsonStructure($this->modelResponseStructure());
    }

    public function dataIndex(): array
    {
        return [
            'filter by perPage' => [
                function(Collection $characters) {
                    $res = new stdClass;
                    $res->query = http_build_query(['perPage' => 2]);
                    $res->expectedIds = $characters->take(2)
                        ->pluck('id')
                        ->toArray();

                    return $res;
                }
            ],
            'filter by page' => [
                function(Collection $characters) {
                    $res = new stdClass;
                    $res->query = http_build_query(['page' => 2]);
                    $res->expectedIds = $characters->slice(10, 10)
                        ->pluck('id')
                        ->toArray();

                    return $res;
                }
            ],
        ];
    }

    public function dataIndexValidationError(): array
    {
        return [
            'perPage is 0' => [
                http_build_query(['perPage' => 0]),
                ['perPage'],
            ],
            'perPage is 101' => [
                http_build_query(['perPage' => 101]),
                ['perPage'],
            ],
            'page is 0' => [
                http_build_query(['page' => 0]),
                ['page'],
            ],
        ];
    }

    public function dataStructure(): array
    {
        return [
            'id',
            'title',
            'airDate',
            'characters',
            'quotes'
        ];
    }

    public function dataStructureList(): array
    {
        return [
            'id',
            'title',
            'airDate',
        ];
    }
}
