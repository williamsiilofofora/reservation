<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;


class EventsTable extends LivewireDatatable
{
    protected $listeners = ['eventRented' => 'rented'];

    public function builder()
    {
        return Event::where('user_id', auth()->id())->join('homes', 'events.home_id', '=', 'homes.id');
    }

    public function columns()
    {
        return [
            Column::name('homes.title')
                ->label('Gîte'),
            DateColumn::name('start')
                ->label('Début'),
            DateColumn::name('end')
                ->label('Fin'),
            BooleanColumn::name('rented')
                ->label('Réservation'),
            Column::callback(['rented', 'limit'], function ($rented, $limit) {
                if ($rented) {
                    return;
                }
                $formated = date_format(date_create($limit), "d/m/Y");
                return date('Y-m-d') > $limit
                    ? '<span class="text-red-500 font-bold">' . $formated . '</span>'
                    : '<span class="text-green-500">' . $formated . '</span>';
            })->label('Limite de paiement'),
            Column::callback(['limit', 'rented', 'id'], function ($limit, $rented, $id) {
                return view('back.actions', [
                    'limit' => date('Y-m-d') > $limit,
                    'rented' => $rented,
                    'id' => $id,
                ]);
            }),
        ];
    }

    public function destroy(Event $event)
    {
        $event->delete();
    }

    public function rented($id)
    {
        $event = Event::findOrFail($id);
        $event->rented = true;
        $event->save();
        $event->payment()->create();
    }
}