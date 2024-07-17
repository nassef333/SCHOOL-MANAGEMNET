<?php

// app/Http/Livewire/TeacherChartComponent.php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Rating;
use App\Models\Subject;
use App\Models\User;
use App\Models\Year;
use Livewire\Component;

class TeacherChartComponent extends Component
{
    public $user_id;
    public $year_id;
    public $branch_id;
    public $subject_id;
    public $start_date;
    public $end_date;
    public $averages;

    public function render()
    {
        return view('livewire.teacher-chart-component');
    }

    public function calculateAverages()
    {
        $query = Rating::query();

        if ($this->user_id) {
            $query->where('teacher_id', $this->user_id);
        }

        if ($this->subject_id) {
            $query->where('subject_id', $this->subject_id);
        }

        if ($this->branch_id) {
            $query->where('branch_id', $this->branch_id);
        } elseif ($this->year_id) {
            $branches = Branch::where('year_id', $this->year_id)->pluck('id')->toArray();
            $query->whereIn('branch_id', $branches);
        }

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
        }

        $results = $query->get();

        $ratings = ['molars_and_skills', 'homework', 'planning', 'media_usage', 'learning_strategy', 'manage_class'];
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

        $this->averages = $averages;
    }
}
