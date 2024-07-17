<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\RelationManagers\BranchesRelationManager;
use App\Filament\Resources\SubjectResource\RelationManagers\RatingsRelationManager;
use App\Filament\Resources\SubjectResource\RelationManagers\SubjectsRelationManager;
use App\Filament\Resources\SubjectResource\RelationManagers\TrainingRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\yearResource\RelationManagers\YearRelationManager;
use App\Models\User;
use Filament\Actions\Action;
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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\IconColumn\IconColumnSize;

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
                TextInput::make('mobile')->numeric()->minLength(11)->maxLength(11)->unique(ignoreRecord: true)->label('Mobile'),
                TextInput::make('email')->email()->label('EMAIL'),
                Select::make('role_id')->label('ROLE')
                    ->options([
                        1 => 'Supervisor',
                        2 => 'Teacher',
                    ])
                    ->required(),
                    TextInput::make('password')
                    ->password(),
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
                Tables\Actions\Action::make('whatsapp')
                ->label('ً')
                ->icon('heroicon-o-chat-bubble-oval-left-ellipsis')
                ->color('success')
                ->url(fn (User $record): string => route('users.whatsapp', ['id' => $record->id]))
                ->openUrlInNewTab(),
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
            SubjectsRelationManager::class,
            YearRelationManager::class,
            BranchesRelationManager::class,
            RatingsRelationManager::class,
            TrainingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'report' => Pages\UserReport::route("/{record}/report")
        ];
    }
}
