<?php

namespace App\Nova;

use App\Nova\Cinema;
use R64\NovaFields\JSON;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laraning\NovaTimeField\TimeField;
use Laravel\Nova\Http\Requests\NovaRequest;

class Showing extends Resource
{
    const VERSIONS = [
        '2D' => '2D',
        '3D' => '3D',
        'IMAX 2D' => 'IMAX 2D',
        'IMAX 3D' => 'IMAX 3D',
    ];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Showing';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            Number::make('Price', function () {
                return $this->price / 100 . 'kr';
            })->readonly(),
            
            Number::make('Real Price', 'price'),

            JSON::make('Multiplier', [
                Number::make('Regular')->withMeta(['value' => 1])->step(0.01)->rules('required', 'numeric'),
                Number::make('Senior')->withMeta(['value' => 0.9])->step(0.01)->rules('required', 'numeric'),
            ]),
            
            Select::make('Version')
                ->options(self::VERSIONS)
                ->sortable(),

            DateTime::make('Start'),
            
            // DateTime::make('End')->readonly(),

            BelongsTo::make('Cinema'),

            BelongsTo::make('Film')->prepopulate(),
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
