<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Partido {{ nombrePlantilla1 }} VS {{ nombrePlantilla2 }}</h2>
  </div>

  <div class="grid" v-if="jugadoresPlantilla1.length > 0 && jugadoresPlantilla2.length > 0">
    <!-- Mostrar jugadores de la plantilla 1 -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h3>{{ nombrePlantilla1 }}</h3>
          <div class="row">
            <div v-for="jugador in jugadoresPlantilla1" :key="jugador.id" class="col-12 col-lg-3 cartJugadores text-center">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mostrar jugadores de la plantilla 2 -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h3>{{ nombrePlantilla2 }}</h3>
          <div class="row">
            <div v-for="jugador in jugadoresPlantilla2" :key="jugador.id" class="col-12 col-lg-3 cartJugadores text-center">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else>
    <p>No se han seleccionado plantillas.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const nombrePlantilla1 = ref(''); // Definir como referencia reactiva
const nombrePlantilla2 = ref(''); // Definir como referencia reactiva
const jugadoresPlantilla1 = ref([]);
const jugadoresPlantilla2 = ref([]);
const route = useRoute();

onMounted(() => {
  // Recuperar los IDs de las plantillas seleccionadas de la ruta o el estado
  const plantillaId = route.params.plantillaId;
  const plantillaSeleccionadaId = route.params.plantillaSeleccionadaId;

  // Obtener jugadores de ambas plantillas
  axios.get(`/api/partidos/${plantillaId}/${plantillaSeleccionadaId}`).then(response => {
    console.log('Respuesta del backend:', response.data);
    // Verificar si se recibieron datos correctamente
    if (response.data && response.data.jugadoresPlantilla1 && response.data.jugadoresPlantilla2) {
      nombrePlantilla1.value = response.data.nombrePlantilla1;
      nombrePlantilla2.value = response.data.nombrePlantilla2;
      jugadoresPlantilla1.value = response.data.jugadoresPlantilla1;
      jugadoresPlantilla2.value = response.data.jugadoresPlantilla2;
    } else {
      console.error('No se recibieron datos de jugadores correctamente');
    }
  }).catch(error => {
    console.error('Error al obtener jugadores de las plantillas:', error);
  });
});
</script>

<style>
/* Estilos opcionales */
</style>