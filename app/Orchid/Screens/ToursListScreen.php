<?php

namespace App\Orchid\Screens;

use App\Models\Tour;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ToursListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tours' => Tour::filters()->defaultSort('id')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Врачи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create')
                ->icon('icon-plus')
                ->route('platform.tour.edit')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('tours', [
                TD::make('name', __('Специальность'))
                    ->sort()
                    ->filter(Input::make())
                    ->render(function (Tour $tour) {
                        return Link::make($tour->name)
                            ->route('platform.tour.edit', $tour);
                    }),

                TD::make('to', __('Имя_врача'))
                    ->sort()
                    ->filter(Input::make())
                    ->render(function (Tour $tour) {
                        return $tour->to;
                    }),

                TD::make('max_people', __('Сколько есть талонов'))
                    ->sort()
                    ->filter(Input::make())
                    ->render(function (Tour $tour) {
                        return $tour->max_people;
                    }),

                TD::make('date', __('Дата'))
                    ->sort()
                    ->filter(Input::make())
                    ->render(function (Tour $tour) {
                        return $tour->date;
                    }),
                TD::make('price', __('Цена'))
                    ->sort()
                    ->filter(Input::make())
                    ->render(function (Tour $tour) {
                        return $tour->price;
                    }),
                ])
        ];
    }
}
