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
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, inject } from "vue";
import { useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
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
      jugadoresSeleccionados.value = jugadoresSeleccionados.value.filter((id) => id !== jugadorId);
      console.log("Jugador deseleccionado:", jugadorId);
    }
  } else {
    console.log("Ya has seleccionado 4 jugadores.");
  }
};

const guardarJugadoresSeleccionados = () => {
  const plantillaNombre = "Plantilla";

  axios.post("/api/plantillas", { nombre: plantillaNombre, jugadores: jugadoresSeleccionados.value })
    .then(response => {
      const plantillaId = response.data.data.id;

      router.push({ name: 'plantillas.indexplantillas', params: { idPlantilla: plantillaId } });

      swal.fire("¡Éxito!", "Jugadores guardados en la base de datos.", "success");
    })
    .catch(error => {
      console.error("Error al guardar jugadores:", error);
      swal.fire("Error", "Hubo un problema al guardar los jugadores.", "error");
    });
};

</script>

<style>
</style>
