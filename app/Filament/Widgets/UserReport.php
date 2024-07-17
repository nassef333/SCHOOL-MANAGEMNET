<?php

namespace App\Filament\Widgets;

use App\Models\Rating;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class UserReport extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string
    {
        $user_id = $this->filters['user_id'] ?? null;
        $username = $user_id ? User::find($user_id)->name : 'User';

        return "{$username} Report (Last 10 Reports)";
    }

    protected function getArray()
    {
        $user_id = $this->filters['user_id'] ?? null;
        $last10Ratings = Rating::where('teacher_id', $user_id)->orderBy('created_at', 'desc')->take(10)->get();

        $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $cnt = 0;

        foreach ($last10Ratings as $rating) {
            $total = $rating->molars_and_skills +
                     $rating->homework +
                     $rating->planning +
                     $rating->media_usage +
                     $rating->learning_strategy +
                     $rating->manage_class +
                     $rating->academic_knowledge;

            $data[$cnt] = $total;
            $cnt++;
        }

        $data = array_reverse($data);
        return $data;
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $this->getArray(),
                    'fill' => 'start',
                    'tension' => '0.4'
                ],
            ],
            'labels' => ['', '', '', '', '', '', '', '', '', ''],
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
