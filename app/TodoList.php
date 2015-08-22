<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoList extends Model

{
    public function listItems()
    {
    	return $this->hasMany('App\TodoItem');
    }
}
