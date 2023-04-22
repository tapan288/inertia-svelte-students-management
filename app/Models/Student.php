<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'class_id',
        'section_id',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function scopeSearch(Builder $query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhere('phone_number', 'like', $term)
                ->orWhere('address', 'like', $term)
                ->orWhereHas('class', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                })
                ->orWhereHas('section', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                });
        });
    }

    public function scopeStudentsQuery($query)
    {
        $search_term = request('q', '');

        $selectedClass = request('selectedClass');
        $selectedSection = request('selectedSection');

        $sort_direction = request('sort_direction', 'asc');

        if (!in_array($sort_direction, ['asc', 'desc'])) {
            $sort_direction = 'asc';
        }

        $sort_field = request('sort_field', 'name');
        if (!in_array($sort_field, ['name', 'email', 'address', 'phone_number', 'created_at'])) {
            $sort_field = 'name';
        }

        $query->with(['class', 'section'])
            ->when($selectedClass, function ($query) use ($selectedClass) {
                $query->where('class_id', $selectedClass);
            })
            ->when($selectedSection, function ($query) use ($selectedSection) {
                $query->where('section_id', $selectedSection);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term));
    }
}
