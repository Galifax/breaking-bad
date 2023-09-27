<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Models\Character;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Closure;
use stdClass;
use Tests\TestCase;
use Tests\Traits\ResponseStructureTrait;

class CharacterControllerTest extends TestCase
{
    use ResponseStructureTrait;

    public function testUnauthorized(): void
    {
        $response = $this->getJson('/api/characters');

        $response->assertUnauthorized();
    }

    /**
     * @dataProvider dataIndex
     */
    public function testIndex(Closure $data): void
    {
        $characters = Character::factory(20)
            ->create();

        $data = $data($characters);

        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/characters?'.$data->query);

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

        $response = $this->actingAs($user)->getJson('/api/characters?'.$query);

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'error' => [
                'fields' => $errors
            ]
        ]);
    }

    public function testRandom()
    {
        Character::factory(2)
            ->create();

        /** @var User $user */
        $user = User::factory()
            ->createOne();

        $response = $this->actingAs($user)->getJson('/api/characters/random');

        $response->assertStatus(200);

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
            'filter by name' => [
                function(Collection $characters) {
                    $randomCharacter = $characters->random()->first();

                    $res = new stdClass;
                    $res->query = http_build_query(['name' => $randomCharacter->name]);
                    $res->expectedIds = [$randomCharacter->id];

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
            'name is big' => [
                http_build_query(['name' => Str::repeat('A',  51)]),
                ['name'],
            ],
        ];
    }

    public function dataStructure(): array
    {
        return [
            'id',
            'img',
            'name',
            'nickname',
            'birthday',
            'portrayed',
            'occupations',
            'episodes',
            'quotes',
        ];
    }

    public function dataStructureList(): array
    {
        return $this->dataStructure();
    }
}
