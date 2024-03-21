<template>
  <div class="grid">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <div class="d-flex justify-content-between pb-2 mb-2">
            <h5 class="card-title text-light">Todos los jugadores</h5>
            <div>
              <button class="botonGeneral" @click="mostrarPromptNombrePlantilla">Crear Plantilla</button>
            </div>
          </div>
          <tbody class="row">
            <tr v-for="(jugador, index) in jugadores" :key="index" class="card col-12 col-lg-3 cartJugadores text-center" style="background-color: #00000000!important;">
              <td class="p-2">
                <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador imgJugadorSeleccion" @click="toggleSeleccion(jugador)" :class="{ 'seleccionado': jugador.checked }">
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

const toggleSeleccion = (jugador) => {
  jugador.checked = !jugador.checked;
  if (jugador.checked) {
    if (jugadoresSeleccionados.value.length > 3) {
      const jugadorDesmarcar = jugadoresSeleccionados.value.shift();
      jugadorDesmarcar.checked = false;
    }
    jugadoresSeleccionados.value.push(jugador);
  } else {
    const index = jugadoresSeleccionados.value.findIndex(selected => selected.id === jugador.id);
    if (index !== -1) {
      jugadoresSeleccionados.value.splice(index, 1);
    }
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
      router.push({ name: 'plantillas.detalleplantillas', params: { idPlantilla: plantillaId } });
      swal.fire("¡Éxito!", "Jugadores guardados en la base de datos.", "success");
    })
    .catch(error => {
      console.error("Error al guardar jugadores:", error);
      swal.fire("Error", "Hubo un problema al guardar los jugadores.", "error");
    });
};
</script>

<style>
.imgJugadorSeleccion {
  cursor: pointer;
  transition: box-shadow 0.3s ease; /* Transición para el efecto de sombra */
  border-radius: 14px;
}

.imgJugadorSeleccion:hover {
  box-shadow: 0px 0px 15px 5px rgba(55, 255, 139, 0.7); /* Sombras difuminadas */
}

.seleccionado {
  box-shadow: 0px 0px 15px 5px rgba(55, 255, 139, 0.7); /* Sombras difuminadas para jugador seleccionado */
}
</style>

