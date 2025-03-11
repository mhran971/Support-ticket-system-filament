<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Services\TextMessageService;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required(),
                TextInput::make('email')
                    ->required()
                    ->unique(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->hiddenOn(['edit']),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email'),
                TextColumn::make('roles.name')
                ->badge( ),
            ])
            ->filters([
                 Tables\Filters\SelectFilter::make('role')
                     ->relationship('roles','name')
                     ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                     Tables\Actions\DeleteBulkAction::make(),
                                    BulkAction::make('sendBulkSms')
                        ->modalButton('Send SMS')
                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                            ->deselectRecordsAfterCompletion()
                        ->form([
                            TextArea::make('Enter your massage here')->required(),
                            Textarea::make('remarks')
                        ])

                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
