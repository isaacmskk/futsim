<template>
  <div class="grid">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <h2>RANKING</h2>

          <table class="table table-hover table-sm">
            <thead class="bg-dark text-light">
              <tr>
                <th>Posicion</th>
                <th>Username</th>
                <th>Puntos</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(usuario, index) in ranking" :key="usuario.id_usuario">
                <td class="text-center">{{ usuario.posicion }}</td>
                <td class="text-center">{{ usuario.name }}</td>
                <td class="text-center">{{ usuario.total_puntos }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const ranking = ref([]);

onMounted(() => {
  cargarRanking();
});

const cargarRanking = () => {
  axios.get('/api/ranking')
    .then(response => {
      ranking.value = response.data;
    })
    .catch(error => {
      console.error('Error al cargar el ranking:', error);
    });
};
</script>

<style>
/* Estilos CSS según sea necesario */
</style>