<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
/*
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
*/
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::Collection(User::with('roles')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|between:2,100',
            'lastname' => 'required|string|between:2,100',
            'username' => 'string|between:2,100',
            'gender' => 'string|between:2,50',
            'email' => 'required|string|email|max:100',
            'password' => 'required|min:6',
            'role'=> 'string|min:3'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
       }

       
       $user = User::create(array_merge(
                   $validator->validated(),
                   ['password' => bcrypt($request->password)]
               ));

       return response()->json([
           'message' => 'User successfully Created',
           'user' => $user
       ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|between:2,100',
            'lastname' => 'required|string|between:2,100',
            'username' => 'string|between:2,100',
            'gender' => 'string|between:2,50',
            'email' => 'required|string|email|max:100',
            'password' => 'required|min:6',
            'role'=> 'string|min:3'
        ]);
      
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->contact = $request->contact;
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'message' => 'user updated!',
            'user' => $user
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'user deleted'
        ]);
    }
}
