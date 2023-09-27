<?php

namespace App\Orchid\Layouts\Episode;

use App\Models\Episode;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class EpisodeListTable extends Table
{
    protected $target = 'episodes';

    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID'))
                ->filter(TD::FILTER_NUMERIC)
                ->sort(),
            TD::make('title', __('Title'))
                ->filter()
                ->sort(),
            TD::make('air_date', __('Air date'))
                ->filter(TD::FILTER_DATE)
                ->sort(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Episode $episode) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.episodes.edit', $episode)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove', [
                                    'id' => $episode->id,
                                ]),
                        ]);
                }),
        ];
    }

}
