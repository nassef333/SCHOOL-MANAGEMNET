<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;

class RatingsRelationManager extends RelationManager
{
    protected static string $relationship = 'teacherRatings';
    protected static ?string $recordTitleAttribute = 'name';

    public  function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('branch_id')
                ->relationship('branch', 'name')
                ->searchable()->label('Branch'),

            Select::make('subject_id')
                ->relationship('subject', 'name')
                ->searchable()->label('Subject'),

                Select::make('molars_and_skills')
                ->required()
                ->label('Molars & Skills')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
            Select::make('homework')
                ->required()
                ->label('Homework')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
            Select::make('planning')
                ->required()
                ->label('Planning')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
            Select::make('media_usage')
                ->required()
                ->label('Media Usage')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
            Select::make('learning_strategy')
                ->required()
                ->label('Learning Strategy')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
            Select::make('manage_class')
                ->required()
                ->label('Manage Class')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
                Select::make('academic_knowledge')
                ->required()
                ->label('Academic Knowledge')
                ->options([
                    '1' => 'المستوى الأول (مقبول)',
                    '2' => 'المستوى الثاني (جيد)',
                    '3' => 'المستوى الثالث (جيد جدا)',
                    '4' => 'المستوى الرابع (ممتاز)',
                ]),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('branch.name')->label('Branch')->sortable()->searchable()->weight(FontWeight::Bold),
                TextColumn::make('subject.name')->label('Subject')->sortable()->searchable()->weight(FontWeight::Bold),
                TextColumn::make('supervisor.name'),
                TextColumn::make('molars_and_skills'),
                TextColumn::make('homework'),
                TextColumn::make('planning'),
                TextColumn::make('media_usage'),
                TextColumn::make('learning_strategy'),
                TextColumn::make('manage_class'),
                TextColumn::make('academic_knowledge'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
