<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Mis Plantillas</h2>
  </div>

  <div class="grid" v-for="plantilla in plantillasUsuario" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <tbody class="row">

            <!-- Mostrar el nombre de la plantilla -->
            <h3>{{ plantilla.nombre }}</h3>

            <!-- Iterar sobre los jugadores asociados con esta plantilla -->
            <div v-if="plantilla.jugadores.length === 0">
              <p>No tienes jugadores asociados a esta plantilla.</p>
            </div>
            <div v-else>
              <div v-for="jugador in plantilla.jugadores" :key="jugador.id"
                class="card col-12 col-lg-3 cartJugadores text-center">
                <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
              </div>
            </div>
          </tbody>
        </div>
      </div>
    </div>
  </div>

  <div v-if="plantillasUsuario.length === 0" class="d-flex justify-content-between pb-2 mb-2">
    <p>No tienes plantillas creadas.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const plantillasUsuario = ref([]);

onMounted(() => {
  // Cargar las plantillas del usuario autenticado
  axios.get('/api/misplantillas').then((response) => {
    plantillasUsuario.value = response.data;
  });
});
</script>

<style>
/* Estilos opcionales */
</style>
