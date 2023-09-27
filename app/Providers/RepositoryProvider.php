<?php

namespace App\Providers;

use App\Contracts\CharacterRepositoryContract;
use App\Contracts\EpisodeRepositoryContract;
use App\Contracts\QuoteRepositoryContract;
use App\Repositories\CharacterRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\QuoteRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CharacterRepositoryContract::class, CharacterRepository::class);
        $this->app->bind(EpisodeRepositoryContract::class, EpisodeRepository::class);
        $this->app->bind(QuoteRepositoryContract::class, QuoteRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
