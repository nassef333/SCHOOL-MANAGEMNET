<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\Rating;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('teacher_id')
                    ->options(function (): array {
                        return User::where('role_id', 2)->pluck('name', 'id')->all();
                    })->searchable()->label('Teacher'),
                    Hidden::make('supervisor_id')->default(Auth::user()->id),

                TextInput::make('molars_and_skills')->required()->label('Molars & Skills')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('homework')->required()->label('Homework')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('planning')->required()->label('Planning')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('media_usage')->required()->label('Media Usage')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('learning_strategy')->required()->label('Learning Strategy')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('manage_class')->required()->label('Manage Class')->numeric()->minValue(1)->maxValue(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('supervisor.name')->label('Supervisor')->sortable()->searchable(),
                TextColumn::make('teacher.name')->label('Teacher')->sortable()->searchable(),
                TextColumn::make('molars_and_skills')->label('Molars & Skills')->sortable()->searchable(),
                TextColumn::make('homework')->label('Homework')->sortable()->searchable(),
                TextColumn::make('planning')->label('Planning')->sortable()->searchable(),
                TextColumn::make('media_usage')->label('Media Usage')->sortable()->searchable(),
                TextColumn::make('learning_strategy')->label('Learning Strategy')->sortable()->searchable(),
                TextColumn::make('manage_class')->label('Manage Class')->sortable()->searchable(),
                TextColumn::make('total')->label('Total')->sortable()->searchable(),
                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListRatings::route('/'),
            'create' => Pages\CreateRating::route('/create'),
            'edit' => Pages\EditRating::route('/{record}/edit'),
        ];
    }
}
