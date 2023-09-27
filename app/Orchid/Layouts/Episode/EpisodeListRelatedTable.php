<?php

namespace App\Orchid\Layouts\Episode;

use App\Models\Episode;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EpisodeListRelatedTable extends Table
{
    protected $target = 'episodes';

    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID')),
            TD::make('title', __('Title')),
            TD::make('air_date', __('Air date')),
            TD::make(__('Actions'))
                ->width('100px')
                ->align(TD::ALIGN_CENTER)
                ->render(function (Episode $episode) {
                    return Link::make(__('Edit'))
                        ->route('platform.episodes.edit', $episode)
                        ->icon('pencil');
                }),
        ];
    }
}
