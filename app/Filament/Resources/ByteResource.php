<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ByteResource\Pages;
use App\Filament\Resources\ByteResource\Pages\EditByte;
use App\Filament\Resources\ByteResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class ByteResource extends Resource
{
    public static $icon = 'heroicon-o-information-circle';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('title')
                    ->required(),
                Components\TextInput::make('slug')
                    ->disabled()
                    ->only(EditByte::class),
                Components\MarkdownEditor::make('content')
                    ->disableAllToolbarButtons()
                    ->enableToolbarButtons([
                        'bold', 'italic', 'code', 'link',
                    ]),
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
            Pages\ListBytes::routeTo('/', 'index'),
            Pages\CreateByte::routeTo('/create', 'create'),
            Pages\EditByte::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
