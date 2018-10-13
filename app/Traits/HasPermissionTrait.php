<?php
/**
 * Created by PhpStorm.
 * User: sile
 * Date: 12.10.18.
 * Time: 02.34
 */

namespace App\Traits;


use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

trait HasPermissionTrait
{
    /**
     * Array with CRUD controller methods like (create, show, update, destroy)
     * mapped with ability names for actions that authorize permissions.
     * Ability can be used on Policy resource or on Gate "define" method.
     *
     * Example: Gate::define('post.update', callback());
     *
     * @var
     */
    protected $resourceAbilityMap;

    /**
     * Name of model on which permissions are granted
     *
     * @var
     */
    protected $model;

    /**
     * Note: Override
     * Get the map of resource methods to ability names.
     *
     * @return mixed
     */
    protected function resourceAbilityMap()
    {
        $this->modifyResourceAbilityMap();

        return $this->resourceAbilityMap;
    }

    /**
     * Customize $resourceAbilityMap array
     * Currently supported abilities: view, create, update, delete.
     */
    public function modifyResourceAbilityMap()
    {
        $this->resourceAbilityMap = [

            'index' => $this->model . '.view',
            'show' => $this->model . '.view',
            'create' => $this->model . '.create',
            'store' => $this->model . '.create',
            'edit' => $this->model . '.update',
            'update' => $this->model . '.update',
            'destroy' => $this->model . '.delete',
            /*'lists' => $this->model . '.view',*/
            'search' => $this->model . '.view',
        ];
    }

    /**
     * Note: Override
     * Authorize a resource action based on the incoming request.
     *
     * @param  string  $model
     * @param  string|null  $parameter
     * @param  array  $options
     * @param  \Illuminate\Http\Request|null  $request
     * @return void
     */
    public function authorizeResource($model, $parameter = null, array $options = [], $request = null)
    {
        $parameter = $parameter ?: Str::snake(class_basename($model));

        // Whole method is overwritten only for this line
        $this->model = $parameter;

        $middleware = [];

        foreach ($this->resourceAbilityMap() as $method => $ability) {
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;

            $middleware["can:{$ability},{$modelName}"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * Register application's permissions.
     */
    public function registerPermissions()
    {
        Gate::before(function ($user) {
            return $user->isSuperAdmin();
        });

        foreach (Permission::all() as $permission) {
            Gate::define($permission->title, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }

    /**
     * Check if user have requested permission.
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        if ($this->role->permissions()->exists()) {

            if ($this->role->permissions()->whereId($permission->id)->exists())
                return true;
        }
    }

    /**
     * Check if user have super admin permission which can administer whole admin panel.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        if ($this->role->permissions()->exists()) {

            if ($this->role->permissions()->whereTitle('admin.sudo')->exists())
                return true;
        }
    }
}