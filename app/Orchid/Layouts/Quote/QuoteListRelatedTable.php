<?php

namespace App\Orchid\Layouts\Quote;

use App\Models\Quote;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuoteListRelatedTable extends Table
{
    protected $target = 'quotes';

    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),
            TD::make('quote', 'Quote')
                ->render(function(Quote $quote) {
                    return $quote->getShortQuote();
                }),
            TD::make(__('Actions'))
                ->width('100px')
                ->align(TD::ALIGN_CENTER)
                ->render(function (Quote $quote) {
                    return Link::make(__('Edit'))
                        ->route('platform.quotes.edit', $quote)
                        ->icon('pencil');
                }),
        ];
    }
}
