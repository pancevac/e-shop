<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreatePermissionRequest;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'permissions' => Permission::paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePermissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionRequest $request)
    {
        $model = $request->get('model');
        $ability = $request->get('ability');

        // Bind model and method in format "model.method"
        $title = strtolower($model). '.' .$ability;

        $permission = Permission::create($request->except(['model', 'ability']));
        $permission->title = $title;
        $permission->update();

        return response()->json([
            'message' => 'Uspešno kreirana dozvola.'
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
        $permission = Permission::find($id);

        // Separate "model.method" record on 2 parts...
        $title = explode('.', $permission->title);
        $model = ucfirst($title[0]);
        $ability = $title[1];

        return response()->json([
            'permission' => $permission,
            'model' => (object) array('className' => $model),
            'ability' => $ability,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreatePermissionRequest $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePermissionRequest $request, Permission $permission)
    {
        $model = $request->get('model')['className'];
        $ability = $request->get('ability');

        // Bind model and method in format "model.method"
        $title = strtolower($model). '.' .$ability;

        $permission->active = $request->get('active');
        $permission->alias = $request->get('alias');
        $permission->title = $title;
        $permission->update();

        return response()->json([
            'message' => 'Uspešno ažurirana dozvola.'
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
        $permission = Permission::whereId($id)->first();

        if ($permission) {
            $permission->delete();

            return response()->json([
                'message' => 'Uspešno obrisana dozvola.'
            ]);
        }
    }

    /**
     * Return lists of permissions for <select> tags
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lists()
    {
        $permissions = Permission::select('id', 'title', 'alias')->active()->orderBy('title', 'ASC')->get();

        return response()->json([
            'permissions' => $permissions,
        ]);
    }

    /**
     * Return list of all models in app.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModels()
    {
        return response()->json([
            'models' =>  $this->getModelsList(),
        ]);
    }

    /**
     * Return list of available abilities for permissions.
     * These names are same thing as ability in permission trait,
     * so if these are updated, those on trail also must be updated.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAbilities()
    {
        return response()->json([
            'abilities' => [
                'view', 'create', 'update', 'delete',
            ]
        ]);
    }

    /**
     * Get all models names in list
     *
     * @param null $dir
     * @return mixed
     */
    protected function getModelsList($dir = null)
    {
        // Define directory path
        $path = app_path($dir);

        // Scan and get all files in app directory
        $classes = File::files($path);

        // Loop every file (model classes)
        foreach ($classes as $class) {
            // Get class name and remove ".php"
            $class->className = str_replace('.php', '', class_basename($class->getRealPath()));
        }
        return $classes;
    }

}
