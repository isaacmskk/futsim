<template>
  <h2>Partidos</h2>

  <div class="grid" v-for="plantilla in plantillasTodas" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <tbody class="row">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <h3 style="margin-right: 10px;">{{ plantilla.nombre }}</h3>
              <div>
                <p class="nameuserplantilla" style="font-size: 24px; color: white; display: inline;">{{ plantilla.user.name }}</p>
                <i class="pi pi-fw pi-user tamano"></i>

              </div>
            </div>
            <div v-for="jugador in plantilla.jugadores" :key="jugador.id"
              class="col-6 col-lg-3 cartJugadores text-center" style="background-color: #00000000!important;">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </tbody>
          <div class="text-center">
            <button class="botonGeneral" @click="mostrarPlantillasUsuario(plantilla.id)">Jugar</button>
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
    cancelButtonText: 'Cancelar',
    customClass: {
      popup: 'my-custom-popup-class',
      confirmButton: '',
      cancelButton: '',
      container: 'my-custom-container-class'
    }
  }).then((response) => {
    // Verifica si se seleccionó una opción
    if (response.isConfirmed) {
      // Obtiene el ID de la plantilla seleccionada
      const plantillaSeleccionadaId = response.value;
      router.push({
        name: 'partidos.indexpartido',
        params: {
          plantillaId: plantillaId,
          plantillaSeleccionadaId: plantillaSeleccionadaId
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
@media (max-width: 600px) {
  .nameuserplantilla{
  font-size: 20px!important;
}
}

</style>
