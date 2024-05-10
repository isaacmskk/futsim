<?php

/**
 * Controlador para gestionar usuarios en la API.
 * 
 * Este controlador maneja las operaciones CRUD para los usuarios, incluyendo la creación,
 * lectura, actualización y eliminación de usuarios. También proporciona métodos para obtener
 * roles de usuario y el usuario actual.
 */


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $orderColumn = request('order_column', 'created_at');
        if (!in_array($orderColumn, ['id', 'name', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }
        $users = User::when(request('search_id'), function ($query) {
            $query->where('id', request('search_id'));
        })
            ->when(request('search_title'), function ($query) {
                $query->where('name', 'like', '%' . request('search_title') . '%');
            })
            ->when(request('search_global'), function ($query) {
                $query->where(function ($q) {
                    $q->where('id', request('search_global'))
                        ->orWhere('name', 'like', '%' . request('search_global') . '%');
                });
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(50);

        return UserResource::collection($users);
    }
    public function getUserRoles(Request $request)
    {
        // Obtener el usuario autenticado
        $user = $request->user();

        // Obtener los roles del usuario
        $roles = $user->getRoleNames();

        return response()->json(['roles' => $roles]);
    }
    public function getCurrentUser()
    {
        $user = auth()->user();
        return new UserResource($user);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return UserResource
     */
    public function store(StoreUserRequest $request)
    {
        $role = Role::find($request->role_id);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            if ($role) {
                $user->assignRole($role);
            }
            return new UserResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show(User $user)
    {
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => '', // Asegura que el correo electrónico sea único excepto para el usuario actual
            'apellido' => 'required',
            'password' => 'nullable|min:6', // La contraseña es opcional y debe tener al menos 6 caracteres si se proporciona
            'role_id' => 'array', // Puede ser un array de IDs de roles
            'role_id.*' => 'exists:roles,id', // Cada ID de rol debe existir en la tabla roles
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->apellido = $request->apellido;

        // $user->password = $request->password;

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            if ($request->has('role_id')) {
                $user->syncRoles($request->role_id); // Sincroniza los roles del usuario con los nuevos roles proporcionados
            }
            return new UserResource($user);
        } else {
            return response()->json(['error' => 'Error al actualizar el usuario'], 500);
        }
    }

    public function password(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id, // Asegura que el correo electrónico sea único excepto para el usuario actual
            'password' => 'required|min:6', // La contraseña es opcional y debe tener al menos 6 caracteres si se proporciona
            'role_id' => 'array', // Puede ser un array de IDs de roles
            'role_id.*' => 'exists:roles,id', // Cada ID de rol debe existir en la tabla roles
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = $request->password;

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($user->save()) {
            if ($request->has('role_id')) {
                $user->syncRoles($request->role_id); // Sincroniza los roles del usuario con los nuevos roles proporcionados
            }
            return new UserResource($user);
        } else {
            return response()->json(['error' => 'Error al actualizar el usuario'], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('user-delete');
        $user->delete();

        return response()->noContent();
    }
}
