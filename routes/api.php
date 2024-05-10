<?php
//fichero api.php
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\JugadoresController;
use App\Http\Controllers\Api\NoticiasController;
use App\Http\Controllers\Api\ComentariosController;
use App\Http\Controllers\Api\PlantillasController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Api\PartidosController;
use App\Http\Controllers\Api\CategoriasController;
use App\Http\Controllers\api\RankingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');


Route::get('jugadores', [JugadoresController::class, 'index']);
Route::post('jugadores/', [JugadoresController::class, 'store']);
Route::put('jugadores/update/{id}', [JugadoresController::class, 'update']);
Route::delete('jugadores/{id}', [JugadoresController::class, 'destroy']);
Route::get('/api/jugadores/seleccionados', [JugadoresController::class, 'obtenerJugadoresSeleccionados']);

Route::get('noticias', [NoticiasController::class, 'index']);
Route::post('noticias/', [NoticiasController::class, 'store']);
Route::delete('noticias/{id}', [NoticiasController::class, 'destroy']);
Route::get('noticias/{id}', [NoticiasController::class, 'show']);
Route::get('/categorias', [CategoriasController::class, 'index']);

Route::get('noticias/filtrar/{categoria}', 'App\Http\Controllers\Api\NoticiasController@filtrarPorCategoria');

Route::get('comentarios', [ComentariosController::class, 'index']);
Route::post('comentarios/', [ComentariosController::class, 'store']);

Route::get('plantillas', [PlantillasController::class, 'index']);
Route::post('plantillas/', [PlantillasController::class, 'store']);
Route::delete('/misplantillas/{index}', [PlantillasController::class, 'destroyByIndex']);
Route::get('/misplantillas', [PlantillasController::class, 'plantillaJugador']);
Route::put('plantillas/update/{id}', [PlantillasController::class, 'update']);

Route::get('/api/plantillas/{idPlantilla}/jugadores/seleccionados', [PlantillasController::class, 'obtenerJugadoresSeleccionados']);


Route::get('/partidos/{plantillaId}/{plantillaSeleccionadaId}', [PartidosController::class, 'obtenerJugadoresPorPlantilla']);
Route::post('/partidos/{plantillaId}/{plantillaSeleccionadaId}/{golesEquipo1}/{golesEquipo2}/{puntosequipo}', [PartidosController::class, 'store']);

Route::get('ranking', [RankingController::class, 'index']);
Route::get('ranking/puntosTotales', [RankingController::class, 'puntosTotalesUsuario']);

Route::get('user', [UserController::class, 'index']);
Route::get('user/current', [UserController::class, 'getCurrentUser']);
Route::put('user/update/{id}', [UserController::class, 'update']);
Route::get('user/rol', [UserController::class, 'getUserRoles']);
Route::put('user/password/{id}', [UserController::class, 'password']);

Route::apiResource('users', UserController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('roles', RoleController::class);
    //Route::apiResource('exercises', ExerciseController::class);


    Route::get('role-list', [RoleController::class, 'getList']);
    Route::get('role-permissions/{id}', [PermissionController::class, 'getRolePermissions']);
    Route::put('/role-permissions', [PermissionController::class, 'updateRolePermissions']);
    Route::apiResource('permissions', PermissionController::class);
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [ProfileController::class, 'update']);

    Route::get('abilities', function (Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});
