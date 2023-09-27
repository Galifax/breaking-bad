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

class CharacterListTable extends Table
{
    protected $target = 'characters';

    protected function columns(): iterable
    {
        return [
            TD::make('id', __('ID'))
                ->filter(TD::FILTER_NUMERIC)
                ->sort(),
            TD::make('img', 'Image')
                ->render(function(Character $character) {
                    return Helper::getImage($character->img);
                }),
            TD::make('name', 'Name')
                ->filter()
                ->sort(),
            TD::make('nickname', 'Nickname')
                ->filter()
                ->sort(),
            TD::make('portrayed', 'Portrayed')
                ->filter()
                ->sort(),
            TD::make('birthday', 'Birthday')
                ->filter(TD::FILTER_DATE)
                ->sort(),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Character $character) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.characters.edit', $character)
                                ->icon('pencil'),
                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove', [
                                    'id' => $character->id,
                                ]),
                        ]);
                }),
        ];
    }
}
