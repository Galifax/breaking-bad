<?php

namespace App\Orchid\Layouts\Character;

use App\Models\Character;
use App\Orchid\Helpers\Helper;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class CharacterListRelatedTable extends Table
{
    protected $target = 'characters';

    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID')),
            TD::make('img', 'Image')
                ->render(function(Character $character) {
                    return Helper::getImage($character->img);
                }),
            TD::make('name', 'Name'),
            TD::make('nickname', 'Nickname'),
            TD::make('portrayed', 'Portrayed'),
            TD::make('birthday', 'Birthday'),
            TD::make(__('Actions'))
                ->width('100px')
                ->align(TD::ALIGN_CENTER)
                ->render(function (Character $character) {
                    return Link::make(__('Edit'))
                        ->route('platform.characters.edit', $character)
                        ->icon('pencil');
                }),
        ];
    }
}
