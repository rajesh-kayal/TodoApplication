<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function getAllTodos()
    {
        $data = DB::table('todos')->paginate(5);

        $response = [
            'data' => $data->items(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
            'total' => $data->total(),
        ];

        return response()->json($response);
    }

    public function getTodoId($id, Request $req)
    {
        if ($req->isMethod('GET')) {
            $data = DB::table('todos')->where('todo_id', $id)->get();
            if ($data->isEmpty()) {
                return response()->json(['message' => 'Todo not found'], 404);
            }
            return response()->json($data[0]);
        }
    }

    public function searchTodo(Request $req)
    {
        $search = $req->input('data');
        $data = DB::table('todos')->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->orWhere('created', 'LIKE', '%' . $search . '%')
            ->get();
        return response()->json($data);
    }

    public function shortTodo(Request $req)
    {
        $sortColumn = $req->input('s1');
        $sortType = $req->input('s2');
        $data = DB::table('todos')->orderBy($sortColumn, $sortType)->get();
        return response()->json($data);
    }

    public function insertTodo(Request $req)
    {
        $insertData = [
            'title' => $req->input('title'),
            'description' => $req->input('desc')
        ];
        $affectedRows = DB::table('todos')->insert($insertData);
        if ($affectedRows == 1) {
            return response()->json(['message' => 'One todo has been added']);
        } else {
            return response()->json(['message' => 'Unable to add todo'], 500);
        }
    }

    public function updateTodo($id, Request $req)
    {
        if ($req->isMethod('PUT') || $req->isMethod('PATCH')) {
            $title = $req->input('title');
            $desc = $req->input('description');
            $created = $req->input('created');
            $affectedRows = DB::table('todos')
                ->where('todo_id', $id)
                ->update([
                    'title' => $title,
                    'description' => $desc,
                    'created' => $created
                ]);
            if ($affectedRows == 1) {
                return response()->json(['message' => 'One todo has been updated']);
            } else {
                return response()->json(['message' => 'Unable to update now'], 500);
            }
        } else {
            return response()->json(['message' => $req->__METHOD__ . ' is not supported'], 405);
        }
    }

    public function deleteTodo($id)
    {
        $affectedRows = DB::table('todos')
            ->where('todo_id', $id)
            ->delete();
        if ($affectedRows == 1) {
            return response()->json(['message' => 'One Todo Info has been Deleted']);
        } else {
            return response()->json(['message' => 'Unable to delete info'], 500);
        }
    }

}
