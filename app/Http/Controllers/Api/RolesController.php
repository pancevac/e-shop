<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateRoleRequest;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::withoutGlobalScopes()->paginate();

        return response()->json([
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
    {
        // Create new role
        $role = Role::create($request->except('permissions_ids'));
        // Sync permissions with created role
        $role->permissions()->sync($request->permissions_ids);

        return response()->json([
            'role' => $role,
            'message' => 'Uspešno kreirana uloga.'
        ]);
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            'role' => Role::whereId($id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateRoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRoleRequest $request, Role $role)
    {
        // Update specified role
        $role->update(request()->except('permissions_ids'));

        // Sync role with permissions
        $role->permissions()->sync(request()->permissions_ids);

        return response()->json([
            'role' => $role,
            'message' => 'Uspešno ažurirana uloga.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::withoutGlobalScopes()->whereId($id)->first();

        if ($role) {
            $role->delete();
            return response()->json([
                'message' => 'Uspešno obrisana uloga.'
            ]);
        }
    }

    /**
     * List roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $roles = Role::withoutGlobalScopes()->select('id', 'title')->orderBy('title')->get();

        return response()->json([
            'roles' => $roles,
        ]);
    }
}
