<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuizAttemptCSV implements FromCollection,  WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }
    public function collection()
    {
        return $this->model;
    }
    public function headings(): array
    {
        return [
            __('ID'),
            __('Member'),
            __('Quiz'),
            __('Type'),
            __('Score'),
            __('Result'),
            __('Finished at'),
        ];
    }

    public function map($attempt): array
    {
        return [
            strval('#'.$attempt->id),
            $attempt->member?->name,
            $attempt->quiz?->title,
            $attempt->quiz?->type,
            $attempt->score . '/'. $attempt->quiz?->score,
            $attempt->passed ? 'Passed' : 'Failed',
            $attempt->end_time?->format('Y-m-d'),
        ];
    }
}
