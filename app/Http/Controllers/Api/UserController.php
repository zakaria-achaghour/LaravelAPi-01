<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
/*
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
*/
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'gender' => 'string|between:2,50',
            'email' => 'required|string|email|max:100',
            'roles'=> 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
       }

       
    //    $user = User::create(array_merge(
    //                $validator->validated(),
    //                ['password' => bcrypt($request->password)]
    //            ));
    $rolesIds = Role::select('id')->whereIn('name',$request->roles)->get();
                $user = new User();
                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $user->email = $request->email;
                $user->gender = $request->gender;
                $user->username = $request->input('firstname')[0] . '.' . $request->input('lastname');
                $user->password = Hash::make('password');
                $user->save();
                
                $user->roles()->sync($rolesIds);

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
    public function show($id)
    {
        // return new UserResource(User::findOrFail($id));
        $user = User::with('roles')->where('id',$id)->first();
        return new UserResource($user);
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
            'gender' => 'string|between:2,50',
            'email' => 'required|string|email|max:100',
            'roles'=> 'required'
        ]);
      
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->username = $request->input('firstname')[0] . '.' . $request->input('lastname');
        $user->save();
        $rolesIds = Role::select('id')->whereIn('name',$request->roles)->get();
        $user->roles()->sync($rolesIds);
        
        return response()->json([
            'message' => 'User successfully Updated',
            'user' => $user
        ], 201);

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
