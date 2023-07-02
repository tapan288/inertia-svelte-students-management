<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromQuery
{
    use Exportable;
    public array $checked = [];

    public function __construct(array $checked)
    {
        $this->checked = $checked;
    }

    public function query()
    {
        return Student::whereIn('id', $this->checked)->get();
    }
}
