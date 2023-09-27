<?php

namespace App\Orchid\Layouts\Quote;

use App\Models\Quote;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuoteListTable extends Table
{
    protected $target = 'quotes';

    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID'))
                ->filter(TD::FILTER_NUMERIC)
                ->sort(),
            TD::make('quote','Quote')
                ->render(function(Quote $quote) {
                    return $quote->getShortQuote();
                })
                ->filter()
                ->sort(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Quote $quote) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.quotes.edit', $quote)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove', [
                                    'id' => $quote->id,
                                ]),
                        ]);
                }),
        ];
    }
}
