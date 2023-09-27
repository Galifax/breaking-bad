<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Character;

use App\Models\Character;
use App\Models\Episode;
use App\Orchid\Layouts\Episode\EpisodeListRelatedTable;
use App\Orchid\Layouts\Quote\QuoteListRelatedTable;
use App\Orchid\Requests\CharacterEditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CharacterEditScreen extends Screen
{
    public Character $character;
    public Collection $episodes;
    public Collection $quotes;

    public function query(Character $character): iterable
    {
        $character->load(['episodes', 'quotes']);

        return [
            'character' => $character,
            'episodes' => $character->episodes,
            'quotes' => $character->quotes,
        ];
    }

    public function name(): ?string
    {
        return $this->character->exists ? 'Edit Character' : 'Create Character';
    }


    public function description(): ?string
    {
        return 'Details of character';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->character->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        $occupations = '';

        if ($this->character->occupations) {
            $occupations = implode(PHP_EOL, $this->character->occupations);
        }

        return [
            Layout::rows([
                Cropper::make('character.img')
                    ->title('Image'),
                Input::make('character.name')
                    ->title('Name')
                    ->maxlength(50),
                Input::make('character.portrayed')
                    ->title('Portrayed')
                    ->maxlength(50),
                Input::make('character.nickname')
                    ->title('Nickname')
                    ->maxlength(50),
                DateTimer::make('character.birthday')
                    ->format('Y-m-d')
                    ->title('Birthday'),
                TextArea::make('stringOccupations')
                    ->title('Occupations')
                    ->help('New occupation on new line')
                    ->cols(10)
                    ->value($occupations),
                Select::make('character.episodes')
                    ->multiple()
                    ->fromModel(Episode::class, 'title', 'id')
                    ->title('Episodes'),
            ]),

            Layout::tabs([
                'Episodes' => [
                    EpisodeListRelatedTable::class,
                ],
                'Quotes' => [
                    QuoteListRelatedTable::class,
                ],
            ])->canSee($this->character->exists),
        ];
    }

    public function save(Character $character, CharacterEditRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['character']['occupations'] = explode(PHP_EOL, $data['stringOccupations']);

        if ($character->exists) {
            $character->update($data['character']);
        } else {
            $character->create($data['character']);
        }

        $character->episodes()->sync($data['character']['episodes']);

        Toast::info(__('Character was updated'));

        return redirect()->route('platform.characters.list');
    }


    public function remove(Character $character): RedirectResponse
    {
        $character->delete();

        Toast::info(__('Character was removed'));

        return redirect()->route('platform.characters.list');
    }
}
