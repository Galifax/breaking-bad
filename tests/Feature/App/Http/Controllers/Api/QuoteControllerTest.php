<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Collection;
use Closure;
use stdClass;
use Tests\TestCase;
use Tests\Traits\ResponseStructureTrait;

class QuoteControllerTest extends TestCase
{
    use ResponseStructureTrait;

    public function testUnauthorized(): void
    {
        $response = $this->getJson('/api/quotes');

        $response->assertUnauthorized();
    }

    /**
     * @dataProvider dataIndex
     */
    public function testIndex(Closure $data): void
    {
        $quotes = Quote::factory(20)
            ->createWithEpisodeAndCharacter();

        $data = $data($quotes);

        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/quotes?' . $data->query);

        $response->assertOk();

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

        $response = $this->actingAs($user)->getJson('/api/quotes?' . $query);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'error' => [
                'fields' => $errors
            ]
        ]);
    }

    /**
     * @dataProvider dataRandom
     */
    public function testRandom(Closure $data): void
    {
        $quotes = Quote::factory(2)
            ->createWithEpisodeAndCharacter(1, 1);

        $data = $data($quotes);

        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/quotes/random?' . $data->query);

        $response->assertOk();

        $response->assertJsonStructure($this->modelResponseStructure());

        if (isset($data->charactaerId)) {
            $this->assertEquals($response->json()['data']['character']['id'], $data->charactaerId);
        }
    }

    public function dataIndex(): array
    {
        return [
            'filter by perPage' => [
                function (Collection $quotes) {
                    $res = new stdClass;
                    $res->query = http_build_query(['perPage' => 2]);
                    $res->expectedIds = $quotes->take(2)
                        ->pluck('id')
                        ->toArray();

                    return $res;
                }
            ],
            'filter by page' => [
                function (Collection $quotes) {
                    $res = new stdClass;
                    $res->query = http_build_query(['page' => 2]);
                    $res->expectedIds = $quotes->slice(10, 10)
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

    public function dataRandom(): array
    {
        return [
            'without filter' => [
                function (Collection $quotes) {
                    $res = new stdClass;
                    $res->query = http_build_query([]);

                    return $res;
                }
            ],
            'filter by author' => [
                function (Collection $quotes) {
                    /** @var Quote $quote */
                    $quote = Quote::factory(1)
                        ->createWithEpisodeAndCharacter(1,1)
                        ->first();
                    $character = $quote->character;

                    $res = new stdClass;
                    $res->query = http_build_query(['author' => $character->name]);
                    $res->charactaerId = $character->id;

                    return $res;
                }
            ],
        ];
    }

    public function dataStructure(): array
    {
        return [
            'id',
            'quote',
            'episode' => ['id', 'title', 'airDate'],
            'character' => ['id', 'img', 'name', 'nickname', 'birthday', 'portrayed', 'occupations']
        ];
    }

    public function dataStructureList(): array
    {
        return $this->dataStructure();
    }
}
