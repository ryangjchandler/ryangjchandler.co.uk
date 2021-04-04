<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;
use Illuminate\Console\Command;

class PostResource extends Resource
{
    public static $icon = 'heroicon-o-newspaper';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('title')
                    ->required(),
                Components\TextInput::make('slug')
                    ->disabled()
                    ->only(EditPost::class)
                    ->required(),
                Components\MarkdownEditor::make('excerpt')
                    ->disableAllToolbarButtons()
                    ->enableToolbarButtons(['bold', 'italic', 'code']),
                Components\MarkdownEditor::make('content'),
                Components\DateTimePicker::make('published_at'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('title'),
                Columns\Text::make('published_at')
                    ->default('—'),
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
            Pages\ListPosts::routeTo('/', 'index'),
            Pages\CreatePost::routeTo('/create', 'create'),
            Pages\EditPost::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
