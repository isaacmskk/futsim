<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div v-for="(jugador, index) in jugadoresPlantilla1" :key="jugador.id">
            <h5 class="card-title">{{ jugador.nombre }}</h5>
            <!-- Mostrar más detalles del jugador si es necesario -->
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div v-for="(jugador, index) in jugadoresPlantilla2" :key="jugador.id">
            <h5 class="card-title">{{ jugador.nombre }}</h5>
            <!-- Mostrar más detalles del jugador si es necesario -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const jugadoresPlantilla1 = ref([]);
// const jugadoresPlantilla2 = ref([]);
const route = useRoute();

onMounted(() => {
  const plantillaId = route.params.plantillaId;
  // const plantillaSeleccionadaId = route.params.plantillaSeleccionadaId;

  axios.get(`/api/partidos/${plantillaId}`).then(response => {
    jugadoresPlantilla1.value = response.data;
  }).catch(error => {
    console.error('Error al obtener jugadores de la plantilla 1:', error);
  });

  // axios.get(`/api/partidos/${plantillaSeleccionadaId}`).then(response => {
  //   jugadoresPlantilla2.value = response.data;
  // }).catch(error => {
  //   console.error('Error al obtener jugadores de la plantilla 2:', error);
  // });
});
</script>

<style scoped>
/* Estilos opcionales */
</style>
