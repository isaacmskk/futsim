<template>
  <div>

    <h2>Mis Plantillas</h2>
    <div v-if="plantillasUsuario.length === 0">
      <p>No tienes plantillas creadas.</p>
    </div>
    <div v-for="plantilla in plantillasTodas" :key="plantilla.id">
      <!-- Mostrar el nombre de la plantilla -->
      <h3>{{ plantilla.nombre }}</h3>

      <!-- Iterar sobre los jugadores asociados con esta plantilla -->
      <ul>
        <li v-for="jugador in plantilla.jugadores" :key="jugador.id">

          <!-- Mostrar el nombre y valoración del jugador -->
          {{ jugador.nombre }} - Valoración: {{ jugador.valoracion }}
          <!-- Mostrar la imagen del jugador -->

          <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">

        </li>
      </ul>
    </div>

    <h2>Todas las Plantillas</h2>
    <div v-for="plantilla in plantillasTodas" :key="plantilla.id">
      <h3>{{ plantilla.nombre }}</h3>
      <ul>
        <li v-for="jugador in plantilla.jugadores" :key="jugador.id">
          {{ jugador.nombre }} - Valoración: {{ jugador.valoracion }}
          <!-- Mostrar la imagen del jugador -->
          <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">

        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const plantillasUsuario = ref([]);
const plantillasTodas = ref([]);

onMounted(() => {
  // Cargar todas las plantillas al montar el componente
  axios.get('/api/plantillas').then((response) => {
    plantillasTodas.value = response.data;
  });

  // Cargar las plantillas del usuario autenticado
  axios.get('/api/plantillas-usuario').then((response) => {
    plantillasUsuario.value = response.data;
  });
});
</script>

<style>
/* Estilos opcionales */
</style>