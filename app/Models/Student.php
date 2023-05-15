<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'class_id',
        'section_id',
    ];

    protected $with = [
        'class',
        'section',
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
                ->orWhereHas('class', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                })
                ->orWhereHas('section', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                });
        });
    }

    public function scopeStudentQuery(Builder $query, $searchTerm, $class_id = null, $section_id = null)
    {
        $query->search($searchTerm)
            ->when($class_id, function ($query) use ($class_id) {
                $query->where('class_id', $class_id);
            })
            ->when($section_id, function ($query) use ($section_id) {
                $query->where('section_id', $section_id);
            });
    }
}
