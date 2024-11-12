<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;



class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    TextInput::make('title')
                        ->autofocus()
                        ->required(),
                    Textarea::make('description')
                        ->rows(3),
                    Textarea::make('comment')
                        ->rows(3),
                    Select::make('status')
                        ->options(self::$model::STATUS)
                        ->required(),
                    Select::make('priority')
                        ->options(self::$model::PRIORITY)
                        ->required(),
                    Select::make('assigned_to')
                    ->relationship('assignedTo','name')
                    ->required(),
//                    Select::make('assigned_by')
//                        ->relationship('assignedBy','name'),
                ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->description(fn(Ticket $ticket): string =>$ticket->description)
                    ->searchable()
                    ->sortable(),
//                TextColumn::make('description'),
                TextColumn::make('status')->badge()
                ->searchable()
                ->sortable(),
                TextColumn::make('priority')->badge(),
                TextColumn::make('assignedBy.name'),
                TextColumn::make('assignedTo.name'),
                TextInputColumn::make('comment'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->hidden(auth()->user()->hasPermission('ticket_delete')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CategoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
