<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RatingResource\Pages;
use App\Filament\Resources\RatingResource\RelationManagers;
use App\Models\Rating;
use App\Models\User;
use App\Models\Subject;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
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
                })
                ->searchable()
                ->label('Teacher')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('branch_id', null); // Reset branch_id when teacher_id changes
                    $set('subject_id', null); // Reset subject_id when teacher_id changes
                }),

            Select::make('branch_id')
                ->label('Branch')
                ->searchable()
                ->getSearchResultsUsing(function (string $search, callable $get) {
                    $userId = $get('teacher_id');

                    if (!$userId) {
                        return [];
                    }

                    return Branch::whereHas('users', function ($query) use ($userId) {
                            $query->where('users.id', $userId);
                        })
                        ->where('name', 'like', "%{$search}%")
                        ->pluck('name', 'id')
                        ->toArray();
                }),

                Select::make('subject_id')
                    ->searchable()->label('Subject')
                    ->getSearchResultsUsing(function (string $search, callable $get) {
                        $userId = $get('teacher_id');

                        if (!$userId) {
                            return [];
                        }

                        return Subject::whereHas('users', function ($query) use ($userId) {
                                $query->where('users.id', $userId);
                            })
                            ->where('name', 'like', "%{$search}%")
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                Hidden::make('supervisor_id')->default(Auth::user()->id),

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('supervisor.name')->label('Supervisor')->sortable()->searchable()->weight(FontWeight::Bold),
                TextColumn::make('teacher.name')->label('Teacher')->sortable()->searchable()->weight(FontWeight::Bold),
                TextColumn::make('branch.name')->label('Branch')->sortable()->searchable()->weight(FontWeight::Bold),
                TextColumn::make('subject.name')->label('Subject')->sortable()->searchable()->weight(FontWeight::Bold),
                TextColumn::make('molars_and_skills')->label('Molars & Skills')->sortable()->searchable(),
                TextColumn::make('homework')->label('Homework')->sortable()->searchable(),
                TextColumn::make('planning')->label('Planning')->sortable()->searchable(),
                TextColumn::make('media_usage')->label('Media Usage')->sortable()->searchable(),
                TextColumn::make('learning_strategy')->label('Learning Strategy')->sortable()->searchable(),
                TextColumn::make('manage_class')->label('Manage Class')->sortable()->searchable(),
                TextColumn::make('academic_knowledge')->label('Academic Knowledge')->sortable()->searchable(),
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
