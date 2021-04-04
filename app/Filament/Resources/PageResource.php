<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\Pages\EditPage;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;
use Illuminate\Mail\Markdown;

class PageResource extends Resource
{
    public static $icon = 'heroicon-o-book-open';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('title'),
                Components\TextInput::make('slug')
                    ->disabled()
                    ->only(EditPage::class),
                Components\MarkdownEditor::make('content'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('title'),
                Columns\Text::make('slug'),
            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListPages::routeTo('/', 'index'),
            Pages\CreatePage::routeTo('/create', 'create'),
            Pages\EditPage::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
