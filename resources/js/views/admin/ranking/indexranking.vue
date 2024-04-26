<template>
  <h2>Ranking</h2>
  <div class="grid">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <div class="table-container">
            <div class="fila header">
              <div class="cell">Posición</div>
              <div class="cell">Usuario</div>
              <div class="cell">Puntos</div>
            </div>
            <div class="fila" v-for="(usuario, index) in ranking" :key="usuario.id"
              :class="{ 'logged-user': usuario.isLoggedUser }" style="border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
              <div class="cell">
                <div :class="{ 'gold': index === 0, 'silver': index === 1, 'bronze': index === 2, 'white': index > 2 }"
                  class="position-number">{{ usuario.posicion }}</div>
                <div class="medallas" v-if="index < 3">
                  <i v-if="index === 0" class="fas fa-regular fa-medal gold"></i>
                  <i v-else-if="index === 1" class="fas fa-regular fa-medal silver"></i>
                  <i v-else class="fas fa-regular fa-medal bronze"></i>
                </div>
              </div>
              <div class="cell"
                :class="{ 'gold': index === 0, 'silver': index === 1, 'bronze': index === 2, 'white': index > 2 }">{{
                usuario.name }}</div>
              <div class="cell"
                :class="{ 'gold': index === 0, 'silver': index === 1, 'bronze': index === 2, 'white': index > 2 }">{{
                  usuario.total_puntos }}</div>
            </div>
          </div>
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
<style scoped>

</style>
