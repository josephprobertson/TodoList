<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model

{
    public function todoList()
    {
    	return $this->belongsTo('TodoList');
    }
}
