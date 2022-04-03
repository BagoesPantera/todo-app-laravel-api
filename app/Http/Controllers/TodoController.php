<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Todo;

class TodoController extends Controller
{
    //
    public function index()
    {
        $todos = Todo::where('userid', Auth::id())->get();
        return response()->json($todos);
    }

    //
    public function add(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $todo = new Todo([
            'title' => $request->title,
            'description' => $request->description,
            'userId' => Auth::user()->id,
        ]);

        $todo->save();

        return response()->json([
            'message' => 'Data added',
        ], 200);
    }

    //
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $todo = Todo::find($id);

        if(!$todo){
            return response()->json([
                'message' => 'Todo not found',
            ], 404);
        }

        $todo->title = $request->title;
        $todo->description = $request->description;

        $todo->save();

        return response()->json([
            'message' => 'Data updated succesfully',
        ], 200);
    }

    //
    public function delete($id)
    {
        $todo = Todo::find($id);

        if(!$todo){
            return response()->json([
                'message' => 'Todo not found',
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'message' => 'Data deleted succesfully',
        ], 200);
    }

}
