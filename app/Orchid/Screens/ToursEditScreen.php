<?php

namespace App\Orchid\Screens;

use App\Models\Tour;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class ToursEditScreen extends Screen
{
    public $tour;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Tour $tour): iterable
    {
        return [
            'tour' => $tour
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->tour->exists
            ? 'Edit Tour'
            : 'Create Tour';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create tour')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->tour->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->tour->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->tour->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('tour.name')
                    ->title('Специальность')
                    ->placeholder('Attractive name'),

                Input::make('tour.to')
                    ->title('Имя_врача')
                    ->placeholder('To'),

                Input::make('tour.max_people')
                    ->title('Сколько есть талонов')
                    ->type('number')
                    ->placeholder('Сколько есть талонов'),

                Input::make('tour.date')
                    ->title('Дата')
                    ->type('date')
                    ->placeholder('Date'),

                Input::make('tour.price')
                    ->title('Цена')
                    ->type('number')
                    ->placeholder('Price'),
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->tour->fill($request->get('tour'))->save();

        Alert::info('You have successfully created a tour.');

        return redirect()->route('platform.tour.list');
    }

    public function remove()
    {
        $this->tour->delete();

        Alert::info('You have successfully deleted the tour.');

        return redirect()->route('platform.tour.list');
    }
}
