<template>
  <div class="grid">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <div class="d-flex justify-content-between pb-2 mb-2">
            <h5 class="card-title text-light">Todos los jugadores</h5>
            <div>
              <button v-if="jugadoresSeleccionados.length === 4" class="botonGeneral" @click="mostrarPromptNombrePlantilla">Crear Plantilla</button>
            </div>
          </div>
          <div>
            <!-- Agregar botones para ordenar -->
            <button class="botonGeneral" @click="ordenarPorValoracion('desc')">
              <i class="pi pi-fw pi-sort-amount-down-alt pi-Lateral asc-desc"></i>
            </button>

            <button class="botonGeneral" @click="ordenarPorValoracion('asc')">
              <i class="pi pi-fw pi-sort-amount-up pi-Lateral asc-desc"></i>

            </button>
          </div>
          <tbody class="row">
            <tr v-for="(jugador, index) in jugadores" :key="index"
              class="card col-12 col-lg-3 cartJugadores text-center" style="background-color: #00000000!important;">
              <td class="p-2">
                <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador"
                  class="imgJugador imgJugadorSeleccion" @click="toggleSeleccion(jugador)"
                  :class="{ 'seleccionado': jugador.checked }">
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
const jugadoresFiltrados = ref([]);

// Definir la función ordenarPorValoracion para ordenar los jugadores por su valoración
const ordenarPorValoracion = (tipo) => {
  // Lógica para ordenar los jugadores por valoración ascendente o descendente
  if (tipo === 'desc') {
    jugadores.value.sort((a, b) => a.valoracion - b.valoracion);
  } else if (tipo === 'asc') {
    jugadores.value.sort((a, b) => b.valoracion - a.valoracion);
  }
};

onMounted(() => {
  axios.get("/api/jugadores").then((response) => {
    jugadores.value = response.data;
    jugadoresFiltrados.value = response.data;
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
    confirmButtonText: 'Crear',
    cancelButtonText: 'Cancelar',
    inputValidator: (value) => {
      if (!value) {
        return 'Debes ingresar un nombre para la plantilla';
      }
    },
    customClass: {
      popup: 'my-custom-popup-class',
      // confirmButton: 'my-custom-confirm-button-class',
      // cancelButton: 'my-custom-cancel-button-class',
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
      swal.fire({
        title: '¡Éxito!',
        text: 'Jugadores guardados en la base de datos.',
        icon: 'success',
        customClass: {
          popup: 'my-custom-success-popup-class',
          title: 'my-custom-success-title-class',
          content: 'my-custom-success-content-class',
        }
      });
    })
    .catch(error => {
      console.error("Error al guardar jugadores:", error);
      swal.fire({
        title: 'Error',
        text: 'Hubo un problema al guardar los jugadores.',
        icon: 'error',
        customClass: {
          popup: 'my-custom-error-popup-class',
          title: 'my-custom-error-title-class',
          content: 'my-custom-error-content-class',
        }
      });
    });
};

</script>

<style>
.imgJugadorSeleccion {
  cursor: pointer;
  transition: box-shadow 0.3s ease;
  /* Transición para el efecto de sombra */
  border-radius: 14px;
}

.imgJugadorSeleccion:hover {
  box-shadow: 0px 0px 15px 5px rgba(55, 255, 139, 0.7);
  /* Sombras difuminadas */
}

.seleccionado {
  box-shadow: 0px 0px 15px 5px rgba(55, 255, 139, 0.7);
  /* Sombras difuminadas para jugador seleccionado */
}

.asc-desc {
  color: #37ff8bb3;
}
</style>
