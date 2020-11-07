<?php

namespace App\Nova;

use App\Nova\Actions\GenerateArticlePreviewLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use PhpParser\Node\Expr\Cast\Bool_;

class Article extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Article::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title'),

            Textarea::make('Excerpt'),

            Markdown::make('Content'),

            DateTime::make('Published At'),

            Boolean::make('Sponsors Only'),

            Boolean::make('Show Table of Contents', 'show_toc'),

            Boolean::make('Allow PDF Download', 'allow_pdf_download')
                ->default(false),

            Boolean::make('Show Series Title in Open Graph Image', 'show_series_title_in_og_image')
                ->default(false),

            Boolean::make('Featured')
                ->default(false),

            BelongsToMany::make('Tags'),

            BelongsTo::make('Series')
                ->nullable(),

            Text::make('Preview Link')
                ->onlyOnDetail()
                ->asHtml()
                ->resolveUsing(function () {
                    return sprintf(
                        '<a class="%s" href="javascript:void(0)" data-url="%s" onclick="%s">Click to Copy</a>',
                        'no-underline font-bold dim text-primary',
                        URL::signedRoute('articles.preview', $this),
                        <<<HTML
                            event.preventDefault();
                            navigator.clipboard.writeText(event.target.dataset.url);
                            window.Nova.app.\$toasted.show('Preview link copied!', { type: 'success' })
                        HTML
                    );
                })
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
}
