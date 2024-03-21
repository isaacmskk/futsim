<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Todas las plantillas</h2>
  </div>

  <div class="grid" v-for="plantilla in plantillasTodas" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <tbody class="row">
            <!-- Mostrar el nombre de la plantilla -->
            <h3>{{ plantilla.nombre }}</h3>

            <div v-for="jugador in plantilla.jugadores" :key="jugador.id"
              class="col-12 col-lg-3 cartJugadores text-center" style="background-color: #00000000!important;">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </tbody>

          <!-- Botón para seleccionar plantilla -->
          <div class="text-center">
            <button class="botonGeneral" @click="mostrarPlantillasUsuario(plantilla.id)">Seleccionar
              Plantilla</button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, inject } from 'vue';
import { useRouter } from 'vue-router';

const plantillasUsuario = ref([]);
const plantillasTodas = ref([]);
const swal = inject("$swal");
const router = useRouter();

onMounted(() => {
  // Cargar todas las plantillas al montar el componente
  axios.get('/api/plantillas').then((response) => {
    plantillasTodas.value = response.data;
    console.log(response.data);
  });

  // Cargar las plantillas del usuario autenticado
  axios.get('/api/misplantillas').then((response) => {
    plantillasUsuario.value = response.data;
  });
});

const mostrarPlantillasUsuario = (plantillaId) => {
  // Construye un array de opciones con los nombres de las plantillas del usuario
  const opciones = plantillasUsuario.value.map(plantilla => ({ id: plantilla.id, nombre: plantilla.nombre }));
  console.log("IDs de todas las plantillas del usuario:", plantillaId);

  // Muestra el SweetAlert con la lista desplegable
  swal.fire({
    title: 'Selecciona tu plantilla',
    input: 'select',
    inputOptions: opciones.reduce((acc, curr) => {
      acc[curr.id] = curr.nombre;
      return acc;
    }, {}),
    showCancelButton: true,
    confirmButtonText: 'Seleccionar',
    cancelButtonText: 'Cancelar'
  }).then((response) => {
    console.log("ID de la plantilla seleccionada:", response.value);

    // Verifica si se seleccionó una opción
    if (response.isConfirmed) {
      // Obtiene el ID de la plantilla seleccionada
      const plantillaSeleccionadaId = response.value;
router.push({ 
    name: 'partidos.indexpartido', 
    params: { 
        plantillaId: plantillaId,
        plantillaSeleccionadaId: plantillaSeleccionadaId // Añadir el ID de la plantilla seleccionada
    },
    state: {
        plantillaSeleccionadaId: plantillaSeleccionadaId
    }
});
    }
  });
};

</script>

<style>
/* Estilos opcionales */
</style>
