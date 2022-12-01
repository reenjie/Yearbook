<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentid',
        'Firstname',
        'Middlename',
        'Lastname',
        'Sex',
        'Birthdate',
        'Address',
        'Honors',
        'SectionID',
        'BatchID',
        'photo',
        'download',
    ];
}
