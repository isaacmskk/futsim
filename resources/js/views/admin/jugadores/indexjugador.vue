<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between pb-2 mb-2">
            <h5 class="card-title text-light">Todos los jugadores</h5>
            <div>
              <button class="btn btn-primary" @click="guardarJugadoresSeleccionados">Guardar Jugadores Seleccionados</button>
            </div>
          </div>

          <div class="row">
            <div v-for="(jugador, index) in jugadores" :key="index" class="card col-4 cartJugadores text-center">
              <div class="p-2">
                <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
              </div>
              <div class="text-center">
                <button class="btn btn-success" @click="seleccionarJugador(jugador.id)">Seleccionar</button>
              </div>
            </div>
<<<<<<< HEAD
  
            <tbody class="row">
              <tr v-for="(jugador, index) in jugadores" :key="index" class="card col-3 cartJugadores text-center">
                <td class="p-2">
                  <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
                </td>
                <td class="text-center">
                  <button class="btn btn-success" @click="seleccionarJugador(jugador.id)">Seleccionar</button>
                </td>
              </tr>
            </tbody>
=======
>>>>>>> e66e515ea611da1eb5efcd0c034604efa49cb720
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, inject } from "vue";

const jugadores = ref([]);
const jugadoresSeleccionados = ref([]);
const swal = inject("$swal");

onMounted(() => {
  axios.get("/api/jugadores").then((response) => {
    jugadores.value = response.data;
    console.log(response.data);
  });
});

const seleccionarJugador = (jugadorId) => {
  if (jugadoresSeleccionados.value.length < 4) {
    if (!jugadoresSeleccionados.value.includes(jugadorId)) {
      jugadoresSeleccionados.value.push(jugadorId);
      console.log("Jugador seleccionado:", jugadorId);
    } else {
      // Si ya fue seleccionado, deseleccionarlo
      jugadoresSeleccionados.value = jugadoresSeleccionados.value.filter((id) => id !== jugadorId);
      console.log("Jugador deseleccionado:", jugadorId);
    }
  } else {
    console.log("Ya has seleccionado 4 jugadores.");
  }
};

const guardarJugadoresSeleccionados = () => {
  axios.post("/api/plantillas", { jugadores: jugadoresSeleccionados.value })
    .then(response => {
      console.log("Jugadores guardados en la base de datos:", response.data);
      swal.fire("¡Éxito!", "Jugadores guardados en la base de datos.", "success");
    })
    .catch(error => {
      console.error("Error al guardar jugadores:", error);
      if (error.response) {
        // La solicitud fue hecha y el servidor respondió con un código de estado que no está en el rango de 2xx
        console.error("Estado de respuesta:", error.response.status);
        console.error("Datos de respuesta:", error.response.data);
      } else if (error.request) {
        // La solicitud fue hecha pero no se recibió ninguna respuesta
        console.error("No hay respuesta del servidor.");
      } else {
        // Algo sucedió en la configuración de la solicitud que provocó que se lanzara un error
        console.error("Error durante la solicitud:", error.message);
      }
      swal.fire("Error", "Hubo un problema al guardar los jugadores.", "error");
    });
};

</script>

<style>
/* Estilos opcionales */
</style>
