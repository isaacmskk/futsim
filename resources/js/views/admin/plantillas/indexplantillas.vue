<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Todas las plantillas</h2>
  </div>

  <div class="grid" v-for="plantilla in plantillasTodas" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <tbody class="row">
            <!-- Mostrar el nombre de la plantilla -->
            <h3>{{ plantilla.nombre }}</h3>

            <div v-for="jugador in plantilla.jugadores" :key="jugador.id" class="card col-12 col-lg-3 cartJugadores text-center">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </tbody>
          
          <!-- Botón para seleccionar plantilla -->
          <div class="text-center">
            <button class="btn btn-success" @click="mostrarPlantillasUsuario">Seleccionar Plantilla</button>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const plantillasUsuario = ref([]);
const plantillasTodas = ref([]);
const swal = inject("$swal");
const router = useRouter();


onMounted(() => {
  // Cargar todas las plantillas al montar el componente
  axios.get('/api/plantillas').then((response) => {
    plantillasTodas.value = response.data;
  });

  // Cargar las plantillas del usuario autenticado
  axios.get('/api/misplantillas').then((response) => {
    plantillasUsuario.value = response.data;
  });
});

const mostrarPlantillasUsuario = () => {
  // Construye un array de opciones con los nombres de las plantillas del usuario
  const opciones = plantillasUsuario.value.map(plantilla => ({ id: plantilla.id, nombre: plantilla.nombre }));

  // Muestra el SweetAlert con la lista desplegable
  swal.fire({
    title: 'Selecciona tus plantillas',
    input: 'select',
    inputOptions: opciones.reduce((acc, curr) => {
      acc[curr.id] = curr.nombre;
      return acc;
    }, {}),
    inputAttributes: {
      multiple: 'multiple' // Permite seleccionar múltiples opciones
    },
    showCancelButton: true,
    confirmButtonText: 'Seleccionar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    // Verifica si se seleccionaron opciones
    if (result.isConfirmed) {
      // Obtiene los IDs de las plantillas seleccionadas
      const plantillasSeleccionadasIds = result.value;
      
      // Aquí puedes enviar los IDs de las plantillas seleccionadas a la página de destino
      // Por ejemplo, puedes navegar a una nueva ruta con los IDs en la URL
      router.push({ name: 'ruta.destino', params: { plantillaIds: plantillasSeleccionadasIds } });
    }
  });
};



</script>

<style>
/* Estilos opcionales */
</style>
