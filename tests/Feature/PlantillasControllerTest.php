<?php

namespace Tests\Feature;

use App\Models\Jugadores;
use Tests\TestCase;
use App\Models\User;
use App\Models\Plantillas;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;


class PlantillasControllerTest extends TestCase
{
    public function test_can_create_user_success()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_can_create_jugadores_success()
    {
        $jugadores = Jugadores::factory()->count(4)->create(['nombre' => 'Nombre de Jugador', 'apellido' => 'Apellido de Jugador', 'posicion' => 'Posicion de Jugador', 'valoracion' => '2', 'nacionalidad' => 'ESP']);

        foreach ($jugadores as $jugador) {
            $this->assertDatabaseHas('jugadores', ['id' => $jugador->id]);
        }
    }


    public function test_can_create_plantilla_success()
    {
        $user = User::factory()->create();
        $jugadores = Jugadores::factory()->count(4)->create(['nombre' => 'Nombre de Jugador', 'apellido' => 'Apellido de Jugador', 'posicion' => 'Posicion de Jugador', 'valoracion' => '2', 'nacionalidad' => 'ESP']);

        $plantillaData = [
            'nombre' => 'Plantilla de prueba',
            'jugadores' => $jugadores->pluck('id')->toArray(),
            'fichaje' => now(),
        ];

        $response = $this->actingAs($user)->postJson('/api/plantillas', $plantillaData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('plantillas', ['nombre' => 'Plantilla de prueba']);
    }
    public function test_can_create_user_failure()
    {
        $response = $this->postJson('/api/users', []);

        $response->assertStatus(422);
        $res = $response->json();

        $this->assertSame($res['message'], 'The name field is required. (and 2 more errors)');
    }

    public function test_can_create_jugadores_error()
    {
        $response = $this->postJson('/api/plantillas', []);

        $response->assertStatus(422);
        $res = $response->json();

        $this->assertSame($res['message'], 'The nombre field is required. (and 1 more error)');
    }

    public function test_can_create_plantilla_without_name_failure()
    {
        // Utilizamos el método expectException para indicar que esperamos una excepción
        $this->expectException(\Illuminate\Database\QueryException::class);

        // Creamos jugadores sin proporcionar el nombre, lo que debería lanzar una excepción
        $jugadores = Jugadores::factory()->count(4)->create(['apellido' => 'Apellido de Jugador', 'posicion' => 'Posicion de Jugador', 'valoracion' => '2', 'nacionalidad' => 'ESP']);

        $plantillaData = [
            'jugadores' => $jugadores->pluck('id')->toArray(),
            'fichaje' => now(),
        ];

        // Realizamos una solicitud POST a la ruta de la API para crear una nueva plantilla
        $this->postJson('/api/plantillas', $plantillaData);
    }
}
