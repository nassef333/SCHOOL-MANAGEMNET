<?php

namespace App\Filament\Pages;

use App\Models\Branch;
use App\Models\Rating;
use App\Models\Subject;
use App\Models\User;
use App\Models\Year;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

// class TeacherChartPage extends Page
// {
//     use InteractsWithForms;

//     public $user_id;
//     public $year_id;
//     public $branch_id;
//     public $subject_id;
//     public $start_date;
//     public $end_date;

//     protected static ?string $navigationIcon = 'heroicon-o-document-text';
//     protected static string $view = 'filament.pages.teacher-chart-page';

//     public function mount()
//     {
//         $this->form->fill();
//     }

//     public function form(Form $form): Form
//     {
//         return $form->schema([
//             Select::make('user_id')
//                 ->label('User')
//                 ->searchable()
//                 ->getSearchResultsUsing(function (string $search) {
//                     return User::query()
//                         ->where('name', 'like', "%{$search}%")
//                         ->pluck('name', 'id')
//                         ->toArray();
//                 })
//                 ->getOptionLabelUsing(function ($value) {
//                     return User::find($value)?->name;
//                 })
//                 ->reactive()
//                 ->afterStateUpdated(function ($state, callable $set) {
//                     $set('year_id', null); // Reset year_id when user_id changes
//                     $set('branch_id', null); // Reset branch_id when user_id changes
//                     $set('subject_id', null); // Reset branch_id when user_id changes
//                 }),

//                 Select::make('year_id')
//                 ->label('Year')
//                 ->searchable()
//                 ->getSearchResultsUsing(function (string $search, callable $get) {
//                     $userId = $get('user_id');

//                     $query = Year::query();

//                     if ($userId) {
//                         $query->whereHas('users', function ($query) use ($userId) {
//                             $query->where('teacher_id', $userId);
//                         });
//                     }

//                     return $query
//                         ->where('name', 'like', "%{$search}%")
//                         ->pluck('name', 'id')
//                         ->toArray();
//                 })
//                 ->getOptionLabelUsing(function ($value) {
//                     return Year::find($value)?->name;
//                 })
//                 ->reactive()
//                 ->afterStateUpdated(function ($state, callable $set) {
//                     $set('branch_id', null); // Reset branch_id when year_id changes
//                 }),

//             Select::make('branch_id')
//                 ->label('Branch')
//                 ->searchable()
//                 ->reactive()
//                 ->getSearchResultsUsing(function (string $search, callable $get) {
//                     $yearId = $get('year_id');

//                     return Branch::query()
//                         ->where('year_id', $yearId)
//                         ->where('name', 'like', "%{$search}%")
//                         ->pluck('name', 'id')
//                         ->toArray();
//                 })
//                 ->getOptionLabelUsing(function ($value) {
//                     return Branch::find($value)?->name;
//                 }),

//                 Select::make('subject_id')
//                 ->label('Subject')
//                 ->searchable()
//                 ->reactive()
//                 ->getSearchResultsUsing(function (string $search, callable $get) {
//                     $userId = $get('user_id');

//                     $query = Subject::query();

//                     if ($userId) {
//                         $query->whereHas('users', function ($query) use ($userId) {
//                             $query->where('teacher_id', $userId);
//                         });
//                     }

//                     return $query
//                         ->where('name', 'like', "%{$search}%")
//                         ->pluck('name', 'id')
//                         ->toArray();
//                 })
//                 ->getOptionLabelUsing(function ($value) {
//                     return Subject::find($value)?->name;
//                 }),

//             DatePicker::make('start_date')
//                 ->label('Start Date'),
//             DatePicker::make('end_date')
//                 ->label('End Date'),
//         ]);
//     }

//     public function save()
// {
//     $this->validate();

//     $user_id = $this->user_id;
//     $year_id = $this->year_id;
//     $branch_id = $this->branch_id;
//     $subject_id = $this->subject_id;
//     $start_date = $this->start_date;
//     $end_date = $this->end_date;

//     // Initial query
//     $query = Rating::query();

//     // Apply filters based on the presence of each parameter
//     if ($user_id) {
//         $query->where('teacher_id', $user_id);
//     }

//     if ($subject_id) {
//         $query->where('subject_id', $subject_id);
//     }

//     if ($branch_id) {
//         $query->where('branch_id', $branch_id);
//     } elseif ($year_id) {
//         $branches = Branch::where('year_id', $year_id)->pluck('id')->toArray();
//         $query->whereIn('branch_id', $branches);
//     }

//     if ($start_date && $end_date) {
//         $query->whereBetween('created_at', [$start_date, $end_date]);
//     }

//     // Execute the query and get the results
//     $results = $query->get();

//     // Calculate average ratings
//     $ratings = ['molars_and_skills', 'homework', 'planning', 'media_usage', 'learning_strategy', 'manage_class'];
//     $averages = [];

//     foreach ($ratings as $rating) {
//         $total = 0;
//         $count = 0;

//         foreach ($results as $result) {
//             $total += $result->$rating;
//             $count++;
//         }

//         if ($count > 0) {
//             $averages[$rating] = $total / $count;
//         } else {
//             $averages[$rating] = 0; // default to 0 if no ratings found
//         }
//     }

//     dd($averages);
// }


// }
