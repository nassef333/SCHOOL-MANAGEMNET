<?php

namespace App\Filament\Widgets;

use App\Models\Rating;
use App\Models\Subject;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class SubjectReport extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string
    {
        $subject_id = $this->filters['subject_id'] ?? null;
        $subjectName = $subject_id ? Subject::find($subject_id)->name : 'Subject';

        return "{$subjectName} Report (Last 10 Days)";
    }

    protected function getArray()
    {
        $subject_id = $this->filters['subject_id'] ?? null;

        // Get today's date and the date 10 days ago
        $today = CarbonImmutable::today();
        $tomorrow = CarbonImmutable::tomorrow();
        $tenDaysAgo = $today->copy()->subDays(10);

        $ratings = Rating::where('subject_id', $subject_id)
            ->where('created_at', '>=', $tenDaysAgo)
            ->where('created_at', '<=', $tomorrow)
            ->get();

        $days = [];

        for ($i = 1; $i <= 10; $i++) {
            $days[] = [
                'sum' => 0,
                'count' => 0
            ];
        }

        for($i = 0; $i<10; $i++) {
            $days[$i]['day'] = $today->copy()->subDays($i)->format('Y-m-d');
        }

        foreach ($ratings as $rating) {
            $day = $rating->created_at->format('Y-m-d');

            foreach ($days as &$oneDay) { // Use reference to modify the original
                if ($oneDay['day'] == $day) {
                    $total = $rating->molars_and_skills +
                        $rating->homework +
                        $rating->planning +
                        $rating->media_usage +
                        $rating->learning_strategy +
                        $rating->manage_class +
                        $rating->academic_knowledge;

                    $oneDay["sum"] += $total;
                    $oneDay["count"]++;
                    break; // Exit the inner loop once we find the match
                }
            }
        }
        // Unset reference to avoid side effects
        unset($oneDay);
        for ($i = 0; $i < 10; $i++) {
            $days[$i]['average'] = $days[$i]['count'] ? number_format($days[$i]['sum'] / $days[$i]['count'], 2) : 0;
        }

        $newArr = [];

        for($i = 0; $i<10; $i++) {
            $newArr[] = $days[$i]['average'];
        }
        return array_reverse($newArr);
    }

    protected function getData(): array
    {
        $labels = [];
        $today = Carbon::today();

        for ($i = 9; $i >= 0; $i--) {
            $labels[] = $today->copy()->subDays($i)->format('Y-m-d'); // Format as needed
        }

        return [
            'datasets' => [
                [
                    'label' => 'Subject Report',
                    'data' => $this->getArray(),
                    'fill' => 'start',
                    'tension' => '0.4'
                ],
            ],
            'labels' => $labels, // Reverse to match the averages
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
