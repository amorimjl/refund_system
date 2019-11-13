<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    
    public function __construct(User $user){
        $this->user = $user;

    }

    public function index()
    {
        $users = $this->user->paginate('10');

        return response()->json($users, 200);
    }

    public function show($id)
    {
        try {

            $user = $this->user->findOrFail($id); 

            return response()->json([
                    'data' => $user
            ], 200);

        } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')){
            $message = new ApiMessages('É necessario informar uma senha para o usuario');
            response()->json($message->getMessage(), 401);
        }


            try {
                $data['password'] = bcrypt($data['password']);

                $user = $this->user->create($data); 

                return response()->json([
                    'data' => [
                        'msg' => 'Usuario cadastrado com sucesso'
                    ]
                ], 200);
            } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
            }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

         if(!$request->has('password') || !$request->get('password')){
            $data['password'] = bcrypt($data['password']);
        } else{
            unset($data['password']);
        }

        try {
            $user = $this->user->findOrFail($id); 
            $user->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Usuario atualizado com sucesso'
                ]
            ], 200);

        } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
        }
    }

    
    public function destroy($id)
    {
        try {

            $user = $this->user->findOrFail($id); 
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuario excluido com sucesso'
                ]
            ], 200);
            
        } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
        }
    }
}
