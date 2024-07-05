<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SearchFilter;
use Filament\Tables\Filters\SelectFilter;
use Kainiklas\FilamentScout\Traits\InteractsWithScout;

class UserResource extends Resource
{
    use InteractsWithScout;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('NAME'),
                TextInput::make('mobile')->numeric()->minLength(11)->maxLength(11)->unique('users', 'mobile')->label('Mobile'),
                TextInput::make('email')->email()->label('EMAIL'),
                Select::make('role_id')->label('ROLE')
                ->options([
                    1 => 'Supervisor',
                    2 => 'Teacher',
                ])
                ->required(),
                TextInput::make('password')
                ->password()
                ->revealable()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('mobile')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('role_name')->label('Role'),
            ])
            ->filters([
                SelectFilter::make('role_id')
                    ->label('Role')
                    ->options([
                        1 => 'Supervisor',
                        2 => 'Teacher',
                    ])
                    ->attribute('role_id'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view'),
                Tables\Actions\EditAction::make('edit'),
                Tables\Actions\DeleteAction::make('delete'),
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
            //
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
