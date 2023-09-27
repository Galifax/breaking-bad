<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Episode;

use App\Models\Character;
use App\Models\Episode;
use App\Orchid\Layouts\Character\CharacterListRelatedTable;
use App\Orchid\Layouts\Quote\QuoteListRelatedTable;
use App\Orchid\Requests\EpisodeEditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EpisodeEditScreen extends Screen
{
    public Episode $episode;
    public Collection $characters;
    public Collection $quotes;

    public function query(Episode $episode): iterable
    {
        $episode->load(['characters', 'quotes']);

        return [
            'episode' => $episode,
            'characters' => $episode->characters,
            'quotes' => $episode->quotes,
        ];
    }

    public function name(): ?string
    {
        return $this->episode->exists ? 'Edit Episode' : 'Create Episode';
    }


    public function description(): ?string
    {
        return 'Details of episode';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->episode->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                TextArea::make('episode.title')
                    ->title('Title'),
                DateTimer::make('episode.air_date')
                    ->format('Y-m-d')
                    ->title('Air date'),
                Select::make('episode.characters')
                    ->multiple()
                    ->fromModel(Character::class, 'nickname', 'id')
                    ->title('Characters'),
            ]),

            Layout::tabs([
                'Characters' => [
                    CharacterListRelatedTable::class
                ],
                'Quotes' => [
                    QuoteListRelatedTable::class
                ]
            ])->canSee($this->episode->exists),
        ];
    }

    public function save(Episode $episode, EpisodeEditRequest $request): RedirectResponse
    {
        if ($episode->exists) {
            $episode = $episode->update($request->validated()['episode']);
        } else {
            $episode = $episode->create($request->validated()['episode']);
        }

        $episode->characters()->sync($request->input('episode.characters'));

        Toast::info(__('Episode was updated'));

        return redirect()->route('platform.episodes.list');
    }


    public function remove(Episode $episode): RedirectResponse
    {
        $episode->delete();

        Toast::info(__('Episode was removed'));

        return redirect()->route('platform.episodes.list');
    }
}
