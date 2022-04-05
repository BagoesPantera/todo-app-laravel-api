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
        $todos = Todo::where('userId', Auth::id())->get();
        // https://stackoverflow.com/a/20585483/13079820
        if ($todos->first()) {
            return response()->json($todos, 200);
        } else {
            return response()->json(['message' => 'No data found'], 200);
        }
    }

    //
    public function show($id)
    {
        $todo = Todo::where('userId', Auth::id())->find($id);
        if ($todo) {
            return response()->json($todo, 200);
        } else {
            return response()->json(['message' => 'Data not found'], 200);
        }
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
            'userId' => Auth::id(),
        ]);

        $save = $todo->save();

        if ($save) {
            return response()->json(['message' => 'Data added successfully.'], 200);
        } else {
            return response()->json(['message' => 'Data failed to add.'], 200);
        }
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
            return response()->json(['message' => 'Data not found',], 200);
        }

        $todo->title = $request->title;
        $todo->description = $request->description;

        if ($todo->userId == Auth::id()) {
            $save = $todo->save();

            if ($save) {
                return response()->json(['message' => 'Data updated successfully.'], 200);
            } else {
                return response()->json(['message' => 'Data failed to update.'], 200);
            }
        } else {
            return response()->json(['message' => 'You are not authorized to update this data.'], 200);
        }
    }

    //
    public function delete($id)
    {
        $todo = Todo::find($id);

        if(!$todo){
            return response()->json(['message' => 'Data not found',], 200);
        }

        if($todo->userId == Auth::id()){
            $delete = $todo->delete();

            if ($delete) {
                return response()->json(['message' => 'Data deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Data failed to delete.'], 200);
            }
        } else {
            return response()->json(['message' => 'You are not authorized to delete this data.'], 200);
        }
    }

}
