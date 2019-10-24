<?php

namespace Devant\CinemaMaker;

use App\Seat;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class CinemaMaker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'cinema-maker';

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $attribute = Str::lower(str_replace('trashed', '', $attribute));

        if ($attribute === 'seats') {
            Seat::withTrashed()->where('cinema_id', $model->getKey())->get()->each->forceDelete();

            $seats = collect(json_decode($request[$requestAttribute]))
                ->map(function ($seat) use ($model) {
                    $seatObj = (object) $seat;

                    $seat = Seat::withTrashed()->updateOrCreate(
                        [
                            'cinema_id' => $model->getKey(),
                            'id' => $seatObj->id ?? 0,
                        ],
                        [
                            'row' => $seatObj->row,
                            'column' => $seatObj->column,
                            'disability' => $seatObj->disability,
                        ]
                    );

                    return $seat;
                });

            $alphabet = collect(Seat::ROW_IDS)->values()->all();

            $model->row_count = $seats->reduce(function ($value, $seat) use ($alphabet) {
                return array_search($seat->row, $alphabet) >= $value
                    ? array_search($seat->row, $alphabet)
                    : $value;
            }, 0) + 1; // +1 because it's needed to show all seats
            
            $model->column_count = $seats->reduce(function ($value, $seat) use ($alphabet) {
                return $seat->column >= $value
                    ? $seat->column
                    : $value;
            }, 0) + 1; // +1 because it's needed to show all seats

            $model->seats()->saveMany($seats);
        } else {
            if ($request->exists($requestAttribute)) {
                $value = $request[$requestAttribute];
    
                $model->{$attribute} = $this->isNullValue($value) ? null : $value;
            }
        }
    }
}
