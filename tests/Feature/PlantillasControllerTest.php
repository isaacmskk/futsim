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

}
