<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

use App\Http\Resources\RoleResource;

use App\Models\Role;


class RoleController extends Controller
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
        return RoleResource::Collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreRoleRequest $request)
    {
        $validated = $request->validated();
        $role = Role::create($request->all());
        // $role->name = $request->input('name');
        // $role->save();
      //  return response()->json(new RoleResource($role));
        return response()->json([
            'message' => 'Role Added!',
            'role' =>new RoleResource($role)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
    

        $role->name = $request->input('name');
        $role->save();
        return response()->json([
            'message' => 'Role updated!',
            'role' => $role
        ]);
      //  return response()->json(new RoleResource($role), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        //return response()->json(null, 204);
        return response()->json([
            'message' => 'Role Deleted!',
            'role' => null
        ]);
    }
}
