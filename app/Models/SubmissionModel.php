<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubmissionModel extends Model
{

        // Nonaktifkan timestamp
        public $timestamps = false;

        protected $fillable = ['name', 'email', 'message'];

}
