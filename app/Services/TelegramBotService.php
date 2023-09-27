<?php
namespace App\Services;

use App\DataTransferObjects\CharacterFilterData;
use Askoldex\Teletant\Addons\Menux;
use Askoldex\Teletant\Bot;
use Askoldex\Teletant\Context;

class TelegramBotService
{
    protected Bot $bot;
    protected CharacterService $characterService;
    protected QuoteService $quoteService;

    public function __construct(
        Bot $bot,
        CharacterService $characterService,
        QuoteService $quoteService
    ) {
        $this->bot = $bot;
        $this->characterService = $characterService;
        $this->quoteService = $quoteService;
    }

    public function boot(): void
    {
        $this->bootEvents();
    }

    public function bootEvents(): void
    {
        $this->bot->onText('/start', function (Context $ctx) {
            $menu = Menux::Create('Main menu');
            $menu->btn('/characters');

            $ctx->replyHTML('Hello, this is Breaking Bad bot', $menu);
        });

        $this->bot->onText('/characters', function (Context $ctx) {
            $ctx->replyMarkdown('Characters', $this->getCharacters());
        });

        $this->bot->onAction('characters {page:integer}', function (Context $ctx) {
            $page = (int)$ctx->var('page', 1);

            $ctx->editSelfMarkdown('Characters', $this->getCharacters($page));
        });

        $this->bot->onAction('quotes {characterId:integer} {page:integer}', function (Context $ctx) {
            $page = (int)$ctx->var('page');
            $characterId = (int)$ctx->var('characterId');
            $character = $this->characterService
                ->findById($characterId);
            $quotes = $this->quoteService
                ->getByCharacter($character);

            $menu = Menux::Create('Quotes')->inline();

            $menu->row()->btn("<< Back", "characters $page");

            foreach($quotes as $quote) {
                $menu->row()->btn($quote->quote, 'data');
            }

            $ctx->editSelfMarkdown("Quotes by $character->name", $menu);
        });
    }

    private function getCharacters(int $page = 1): Menux
    {
        $characterFilterData = new CharacterFilterData;
        $characterFilterData->perPage = 3;
        $characterFilterData->page = $page;

        $characters = $this->characterService
            ->list($characterFilterData);

        $menu = Menux::Create('Characters')->inline();

        $currentPage = $characters->currentPage();
        $lastPage = $characters->lastPage();

        foreach($characters as $character) {
            $menu->row()->btn($character->name, "quotes $character->id $currentPage");
        }

        $menu = $menu->row();

        if ($currentPage != 1) {
            $menu->btn("1", "characters " . 1)
                ->btn("<<", "characters " . ($currentPage - 1));
        }
        $menu->btn($currentPage);
        if ($currentPage != $lastPage) {
            $menu->btn(">>", "characters " . ($currentPage + 1))
                ->btn($lastPage, "characters " . $lastPage);
        }

        return $menu;
    }

    public function polling(): void
    {
        $this->bot->polling();
    }

    public function listen(): void
    {
        $this->bot->listen();
    }
}
