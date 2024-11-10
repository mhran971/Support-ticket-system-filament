<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    const PRIORITY = [
      'Low' => 'Low',
      'Medium'=>'Medium',
      'High'=>'High'
    ];

    const STATUS = [
        'Open' => 'Open',
        'Closed'=>'Closed',
        'Archived'=>'Archived'
    ];

    protected $fillable =[
        'title',
        'description',
        'status',
        'priority',
        'comment',
        'assigned_by',
        'assigned_to',
        'is_resolved',

    ];

    public function assignedTo (){
      return  $this->belongsTo(User::class,'assigned_to');
    }

    public function assignedBy (){
        return  $this->belongsTo(User::class,'assigned_by');
    }

    public function categories(){
        return $this->belongsToMany(Category::class);

    }
}
