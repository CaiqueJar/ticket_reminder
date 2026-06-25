<?php

namespace App\Filament\Resources\Termos\Pages;

use App\Filament\Resources\Termos\TermoResource;
use App\Models\Termo;
use Filament\Resources\Pages\Page;

class ListAliasesTermos extends Page
{
    protected static string $resource = TermoResource::class;

    protected static ?string $title = 'Termos e aliases';

    protected static ?string $breadcrumb = 'Aliases';

    protected string $view = 'filament.resources.termos.pages.list-aliases-termos';

    protected function getViewData(): array
    {
        return [
            'termos' => Termo::with('aliases')
                ->orderBy('nome_oficial')
                ->get(),
        ];
    }
}
