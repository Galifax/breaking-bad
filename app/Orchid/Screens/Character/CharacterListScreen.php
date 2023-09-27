<?php
declare(strict_types=1);

namespace App\Orchid\Screens\Character;

use App\Models\Character;
use App\Orchid\Layouts\Character\CharacterListTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CharacterListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'characters' => Character::query()
                ->filters()
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Characters';
    }

    public function description(): ?string
    {
        return 'All characters';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.characters.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            CharacterListTable::class
        ];
    }

    public function remove(Request $request): void
    {
        Character::findOrFail($request->get('id'))->delete();

        Toast::info(__('Character was removed'));
    }
}
