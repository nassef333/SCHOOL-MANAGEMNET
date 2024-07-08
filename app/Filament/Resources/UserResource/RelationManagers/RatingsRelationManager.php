<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Facades\Auth;

class RatingsRelationManager extends RelationManager
{
    protected static string $relationship = 'teacherRatings';
    protected static ?string $recordTitleAttribute = 'name';

    public  function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('molars_and_skills')->required()->label('Molars & Skills')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('homework')->required()->label('Homework')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('planning')->required()->label('Planning')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('media_usage')->required()->label('Media Usage')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('learning_strategy')->required()->label('Learning Strategy')->numeric()->minValue(1)->maxValue(5),
                TextInput::make('manage_class')->required()->label('Manage Class')->numeric()->minValue(1)->maxValue(5),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('supervisor.name'),
                TextColumn::make('molars_and_skills'),
                TextColumn::make('homework'),
                TextColumn::make('planning'),
                TextColumn::make('media_usage'),
                TextColumn::make('learning_strategy'),
                TextColumn::make('manage_class'),
                TextColumn::make('total'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['supervisor_id'] = Auth::id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
