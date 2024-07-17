<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Rating;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class RatingStat extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = -100;


    protected function getStats(): array
    {

        $user_id = $this->filters['user_id'] ?? null;
        $branch_id = $this->filters['branch_id'] ?? null;
        $year_id = $this->filters['year_id'] ?? null;
        $subject_id = $this->filters['subject_id'] ?? null;

        $start_date = ! is_null($this->filters['start_date'] ?? null) ?
            Carbon::parse($this->filters['start_date']) :
            null;

        $end_date = ! is_null($this->filters['end_date'] ?? null) ?
            Carbon::parse($this->filters['end_date']) :
            now();



        // Initial query
        $query = Rating::query();

        // Apply filters based on the presence of each parameter
        if ($user_id) {
            $query->where('teacher_id', $user_id);
        }

        if ($subject_id) {
            $query->where('subject_id', $subject_id);
        }

        if ($branch_id) {
            $query->where('branch_id', $branch_id);
        } elseif ($year_id) {
            $branches = Branch::where('year_id', $year_id)->pluck('id')->toArray();
            $query->whereIn('branch_id', $branches);
        }

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)]);
        } elseif ($start_date) {
            $query->where('created_at', '>=', Carbon::parse($start_date));
        } elseif ($end_date) {
            $query->where('created_at', '<=', Carbon::parse($end_date));
        }

        $results = $query->get();

        // dd($results);
        // Calculate average ratings
        $ratings = ['molars_and_skills', 'homework', 'planning', 'media_usage', 'learning_strategy', 'manage_class', 'academic_knowledge'];
        $averages = [];

        foreach ($ratings as $rating) {
            $total = 0;
            $count = 0;

            foreach ($results as $result) {
                $total += $result->$rating;
                $count++;
            }

            if ($count > 0) {
                $averages[$rating] = $total / $count;
            } else {
                $averages[$rating] = 0; // default to 0 if no ratings found
            }

        }

        return [
            Stat::make('Morals And Skills', number_format($averages['molars_and_skills'], 2)),
            Stat::make('Homework', number_format($averages['homework'], 2)),
            Stat::make('Planning', number_format($averages['planning'], 2)),
            Stat::make('Media Usage', number_format($averages['media_usage'], 2)),
            Stat::make('Learning Strategy', number_format($averages['learning_strategy'], 2)),
            Stat::make('Manage Class', number_format($averages['manage_class'], 2)),
            Stat::make('Academic Knowledge', number_format($averages['academic_knowledge'], 2)),
        ];
    }
}
