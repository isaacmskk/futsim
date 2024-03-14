<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between pb-2 mb-2">
            <h5 class="card-title text-light">Todos los jugadores</h5>
            <div>
              <button class="btn btn-primary" @click="mostrarPromptNombrePlantilla">Guardar Jugadores Seleccionados</button>
            </div>
          </div>
          <tbody class="row">
            <tr v-for="(jugador, index) in jugadores" :key="index" class="card col-3 cartJugadores text-center">
              <td class="p-2">
                <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
              </td>
              <td class="text-center">
                <input type="checkbox" id="index" class="_checkbox" v-model="jugador.checked">
                <label @click="seleccionarJugador(jugador)" for="{{ jugador.id }}">
                  <div class="tick_mark"></div>
                </label>
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

const seleccionarJugador = (jugador) => {
  jugador.checked = !jugador.checked;
  if (jugadoresSeleccionados.value.length >= 4) {
    swal.fire("¡Alerta!", "Ya has seleccionado 4 jugadores.", "warning");
    return;
  }

  const jugadorIndex = jugadoresSeleccionados.value.findIndex(selected => selected.id === jugador.id);
  if (jugadorIndex === -1) {
    jugadoresSeleccionados.value.push(jugador);
    console.log("Jugador seleccionado:", jugador.id);
  } else {
    jugadoresSeleccionados.value.splice(jugadorIndex, 1);
    console.log("Jugador deseleccionado:", jugador.id);
  }
};

const mostrarPromptNombrePlantilla = () => {
  swal.fire({
    title: 'Nombre de la plantilla',
    input: 'text',
    inputLabel: 'Introduce el nombre de la plantilla',
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',
    inputValidator: (value) => {
      if (!value) {
        return 'Debes ingresar un nombre para la plantilla';
      }
    },
  }).then((result) => {
    if (result.isConfirmed) {
      guardarJugadoresSeleccionados(result.value);
    }
  });
};

const guardarJugadoresSeleccionados = (nombrePlantilla) => {
  axios.post("/api/plantillas", { nombre: nombrePlantilla, jugadores: jugadoresSeleccionados.value.map(jugador => jugador.id) })
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