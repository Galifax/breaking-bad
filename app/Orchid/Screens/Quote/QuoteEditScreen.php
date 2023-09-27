<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Quote;

use App\Models\Character;
use App\Models\Episode;
use App\Models\Quote;
use App\Orchid\Requests\QuoteEditRequest;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuoteEditScreen extends Screen
{
    public Quote $quote;

    public function query(Quote $quote): iterable
    {
        return [
            'quote' => $quote,
        ];
    }

    public function name(): ?string
    {
        return $this->quote->exists ? 'Edit Quote' : 'Create Quote';
    }


    public function description(): ?string
    {
        return 'Details of quote';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->quote->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                TextArea::make('quote.quote')
                    ->title('Quote')
                    ->maxlength(100),
                Select::make('quote.episode_id')
                    ->fromModel(Episode::class, 'title', 'id')
                    ->empty('No select')
                    ->title('Episode'),
                Select::make('quote.character_id')
                    ->fromModel(Character::class, 'nickname', 'id')
                    ->empty('No select')
                    ->title('Character'),

            ]),

        ];
    }

    public function save(Quote $quote, QuoteEditRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($quote->exists) {
            $quote->update($data['quote']);
        } else {
            $quote->create($data['quote']);
        }

        Toast::info(__('Quote was updated'));

        return redirect()->route('platform.quotes.list');
    }


    public function remove(Quote $quote): RedirectResponse
    {
        $quote->delete();

        Toast::info(__('Quote was removed'));

        return redirect()->route('platform.quotes.list');
    }
}
