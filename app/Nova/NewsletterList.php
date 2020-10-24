<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class NewsletterList extends Resource
{
    public static $model = \App\Models\NewsletterList::class;

    public static $title = 'id';

    public static $group = 'Newsletter';

    public static $search = [
        'id',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Name')
                ->required(),

            Text::make('Subject')
                ->required(),

            Text::make('From Name')
                ->nullable(),

            Text::make('From Email')
                ->nullable()
                ->rules('email'),

            Boolean::make('Active'),

            Boolean::make('Default')
                ->help('This list will be used as the default when no other is provided.'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function label()
    {
        return 'Lists';
    }

    public static function singularLabel()
    {
        return 'List';
    }
}
