<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TodoList;
use App\TodoItem;

class TodoListController extends Controller
{

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => ['post', 'put']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $todo_lists = TodoList::all();
        return view('todos.index')->with('todo_lists', $todo_lists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // define rules
        $rules = array(
                'name' => array('required', 'unique:todo_lists')
            );

        // pass input to validator
        $validator = \Validator::make(Request::all(), $rules);
        // test validity

        if ($validator->fails()) {
            return \Redirect::route('todos.create')->withErrors($validator)->withInput();
        }

        $name = Request::get('name');
        $list = new TodoList();
        $list->name = $name;
        $list->save();
        return \Redirect::route('todos.index')->withMessage('List Was Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $list = TodoList::findOrFail($id);
        $items = $list->listItems()->get();
        return view('todos.show')
        ->withList($list)
        ->withItems($items);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $list = TodoList::findOrFail($id);
        return view('todos.edit')->withList($list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {

        // define rules
        $rules = array(
                'name' => array('required', 'unique:todo_lists')
            );

        // pass input to validator
        $validator = \Validator::make(Request::all(), $rules);
        // test validity

        if ($validator->fails()) {
            return \Redirect::route('todos.edit', $id)->withErrors($validator)->withInput();
        }

        $name = Request::get('name');
        $list = TodoList::findOrFail($id);
        $list->name = $name;
        $list->update();
        return \Redirect::route('todos.index')->withMessage('List Was Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $todo_list = TodoList::findOrFail($id)->delete();
        return \Redirect::route('todos.index')->withMessage('Item Deleted!');
    }
}
