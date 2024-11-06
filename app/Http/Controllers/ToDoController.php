<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Models\ToDo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/todo",
     *     summary="Todo by the user (Authorization required)",
     *      tags={"todo"},
     *     @OA\Response(
     *         response=200,
     *         description="Get all todo",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Get all todo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function index(){
        $todo = ToDo::with(['category'])
                ->where('user_id', Auth::user()->id)
                ->get();
        return ApiResponse::success("Get all todo", $todo);
    }


    /**
     * @OA\Post(
     *     path="/todo",
     *     summary="Create Todo (Authorization required)",
     *      tags={"todo"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"title","description","category_id","due_date"},
    *             @OA\Property(property="title", type="string", format="text", example="Todo1"),
    *             @OA\Property(property="description", type="string", format="text", example="Description of todo1"),
    *             @OA\Property(property="category_id", type="integer", format="number", example=1),
    *             @OA\Property(property="due_date", type="string", format="datetime", example="2021-09-30 12:00:00")
    *         ),
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "title"=> "required|min:3",
            "description" => 'required|min:6',
            "category_id" => 'required|exists:categories,id',
            "due_date" => 'required|date',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors());
        }
        try {
            $data = ToDo::create([
                'title'=> $request->title,
                'description'=> $request->description,
                'category_id'=> $request->category_id,
                'user_id'=> Auth::user()->id,
                'due_date'=> $request->due_date,
            ]);
            return ApiResponse::success('Todo created successfully',$data);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(),500);
        }
    }

    /**
     * @OA\Get(
     *     path="/todo/{id}",
     *     summary="Todo by the user (Authorization required)",
     *     tags={"todo"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Todo ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get todo by ID",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Get todo by ID"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function show($id) {
        $todo = ToDo::with(['category'])
            ->where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
            
        if (!$todo) {
            return ApiResponse::error('Todo not found', 404);
        }
        
        return ApiResponse::success('Get todo by id: '.$id, $todo);
    }

    /**
     * @OA\Put(
     *     path="/todo/{id}",
     *     summary="Update todo by id (Authorization required)",
     *     tags={"todo"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Todo ID",
     *         @OA\Schema(type="integer")
     *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"title","description","category_id","due_date"},
    *             @OA\Property(property="title", type="string", format="text", example="Todo1"),
    *             @OA\Property(property="description", type="string", format="text", example="Description of todo1"),
    *             @OA\Property(property="category_id", type="integer", format="number", example=1),
    *             @OA\Property(property="due_date", type="string", format="datetime", example="2021-09-30 12:00:00")
    *         ),
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Update todo by ID",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Update todo by ID"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title'=> 'required|min:3',
            'description'=> 'required|min:6',
            'category_id'=> 'required|exists:categories,id',
            'due_date'=> 'required|date',
        ]);
        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors());
        }
        $todo = ToDo::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        if (!$todo) {
            return ApiResponse::error('Todo not found',404);
        }
        try {
            $todo->update([
                'title'=> $request->title,
                'description'=> $request->description,
                'category_id'=> $request->category_id,
                'due_date'=> $request->due_date,
            ]);
            return ApiResponse::success('Todo updated successfully', $todo);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(),500);
        }

    }

    /**
     * @OA\Delete(
     *     path="/todo/{id}",
     *     summary="Delete Todo by the user (Authorization required)",
     *     tags={"todo"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Todo ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delete todo by ID",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Delete todo by ID"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Todo not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function destroy($id) {
        $todo = ToDo::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        if (!$todo) {
            return ApiResponse::error('Todo not found',404);
        }
        $todo->delete();
        return ApiResponse::success('Todo Deleted!');

    }



}
