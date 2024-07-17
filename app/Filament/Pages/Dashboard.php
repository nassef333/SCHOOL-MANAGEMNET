<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\Branch;
use App\Models\Subject;
use App\Models\User;
use App\Models\Year;
use Illuminate\Support\Facades\DB;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(3) // Three columns
                            ->schema([
                                Select::make('user_id')
                                    ->label('User')
                                    ->searchable()
                                    ->getSearchResultsUsing(function (string $search) {
                                        return User::query()
                                            ->where('name', 'like', "%{$search}%")
                                            ->pluck('name', 'id')
                                            ->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        return User::find($value)?->name;
                                    })
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('year_id', null); // Reset year_id when user_id changes
                                        $set('branch_id', null); // Reset branch_id when user_id changes
                                        $set('subject_id', null); // Reset subject_id when user_id changes
                                    }),

                                    Select::make('year_id')
                                    ->label('Year')
                                    ->searchable()
                                    ->reactive()
                                    ->getSearchResultsUsing(function (string $search, callable $get) {
                                        $userId = $get('user_id');

                                        if(!$userId) {
                                            return DB::table('years')
                                            ->where('years.name', 'like', "%{$search}%")
                                            ->pluck('years.name', 'years.id')
                                            ->toArray();
                                        }

                                        return DB::table('years')
                                        ->join('teacher_years', 'years.id', '=', 'teacher_years.year_id')
                                        ->where('teacher_years.teacher_id', $userId)
                                        ->where('years.name', 'like', "%{$search}%")
                                        ->pluck('years.name', 'years.id')
                                        ->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        return Year::find($value)?->name;
                                    }),


                                    Select::make('branch_id')
                                    ->label('Branch')
                                    ->searchable()
                                    ->reactive()
                                    ->getSearchResultsUsing(function (string $search, callable $get) {
                                        $yearId = $get('year_id');
                                        $teacher_id = $get('user_id');

                                        if(!$yearId && !$teacher_id) {
                                            return DB::table('branches')
                                            ->where('branches.name', 'like', "%{$search}%")
                                            ->pluck('branches.name', 'branches.id')
                                            ->toArray();
                                        }elseif(!$teacher_id){
                                            return DB::table('branches')
                                            ->where('year_id', $yearId)
                                            ->where('branches.name', 'like', "%{$search}%")
                                            ->pluck('branches.name', 'branches.id')
                                            ->toArray();
                                        }

                                        return DB::table('branch_teacher')
                                        ->join('branches', 'branch_teacher.branch_id', '=', 'branches.id')
                                        ->where('branches.name', 'like', "%{$search}%")
                                        ->pluck('branches.name', 'branches.id')
                                        ->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        return Branch::find($value)?->name;
                                    })
                            ]),

                        Grid::make(3) // Second row of three columns
                            ->schema([
                                Select::make('subject_id')
                                    ->label('Subject')
                                    ->searchable()
                                    ->reactive()
                                    ->getSearchResultsUsing(function (string $search, callable $get) {
                                        $userId = $get('user_id');

                                        $query = Subject::query();

                                        if ($userId) {
                                            $query->whereHas('users', function ($query) use ($userId) {
                                                $query->where('teacher_id', $userId);
                                            });
                                        }

                                        return $query
                                            ->where('name', 'like', "%{$search}%")
                                            ->pluck('name', 'id')
                                            ->toArray();
                                    })
                                    ->getOptionLabelUsing(function ($value) {
                                        return Subject::find($value)?->name;
                                    }),

                                DatePicker::make('start_date')
                                    ->label('Start Date'),

                                DatePicker::make('end_date')
                                    ->label('End Date'),
                            ]),
                    ]),
            ]);
    }
}
