<?php

namespace App\Filament\Widgets;

use App\Models\Role;
use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTickets extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                auth()->user()->hasRole(Role::ROLES['Admin']) ? Ticket::query() : Ticket::where('assigned_to',
                auth()->id())

            )
            ->columns([
                TextColumn::make('title')
                    ->description(fn(Ticket $ticket): string =>$ticket->description || Null )
                    ->searchable()
                    ->sortable(),
//                TextColumn::make('description'),
                TextColumn::make('status')
                    ->badge()
                    ->colors(  [
                        'success' => Ticket::STATUS['Open'] ,
                        'danger'  => Ticket::STATUS['Closed'],
                        'warning' => Ticket::STATUS['Archived'],
                    ]),

                TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'success' => Ticket::PRIORITY['Low'] ,
                        'danger'  => Ticket::PRIORITY['High'],
                        'warning' => Ticket::PRIORITY['Medium'],
                    ]),

                TextColumn::make('assignedBy.name'),
                TextColumn::make('assignedTo.name'),
                TextInputColumn::make('comment'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
