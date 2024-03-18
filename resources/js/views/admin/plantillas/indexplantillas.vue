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

            <tr v-for="jugador in plantilla.jugadores" :key="jugador.id"
              class="card col-12 col-lg-3 cartJugadores text-center">

              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">

            </tr>
          </tbody>
        </div>
      </div>
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