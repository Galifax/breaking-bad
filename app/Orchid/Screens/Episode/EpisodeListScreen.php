<?php
declare(strict_types=1);

namespace App\Orchid\Screens\Episode;

use App\Models\Episode;
use App\Orchid\Layouts\Episode\EpisodeListTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class EpisodeListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'episodes' => Episode::query()
                ->defaultSort('air_date', 'desc')
                ->filters()
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return 'Episodes';
    }

    public function description(): ?string
    {
        return 'All episodes';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.episodes.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            EpisodeListTable::class
        ];
    }

    public function remove(Request $request): void
    {
        Episode::findOrFail($request->get('id'))->delete();

        Toast::info(__('Episode was removed'));
    }
}
