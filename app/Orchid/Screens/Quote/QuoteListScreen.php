<?php
declare(strict_types=1);

namespace App\Orchid\Screens\Quote;

use App\Models\Quote;
use App\Orchid\Layouts\Quote\QuoteListTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class QuoteListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'quotes' => Quote::query()
                ->filters()
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Quotes';
    }

    public function description(): ?string
    {
        return 'All quotes';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.quotes.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            QuoteListTable::class
        ];
    }

    public function remove(Request $request): void
    {
        Quote::findOrFail($request->get('id'))->delete();

        Toast::info(__('Quote was removed'));
    }
}
