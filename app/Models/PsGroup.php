<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsGroup extends Model
{
    use HasFactory;

    protected $table ='ps_groups';
    protected $fillable = ['ps_group','ps_desc','begin_date','end_date'];

}
