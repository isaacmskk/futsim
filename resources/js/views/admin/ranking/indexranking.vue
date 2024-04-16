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
              :class="{ 'logged-user': usuario.isLoggedUser }" style="
  border-bottom-left-radius: 6px;
  border-bottom-right-radius: 6px;">
              <div class="cell">
                <div :class="{ 'gold': index === 0, 'silver': index === 1, 'bronze': index === 2, 'white': index > 2 }" class="position-number">{{ usuario.posicion }}</div>
                <div class="medallas" v-if="index < 3">
                  <i v-if="index === 0" class="fas fa-regular fa-medal gold"></i>
                  <i v-else-if="index === 1" class="fas fa-regular fa-medal silver"></i>
                  <i v-else class="fas fa-regular fa-medal bronze"></i>
                </div>
              </div>
              <div class="cell" :class="{ 'gold': index === 0, 'silver': index === 1, 'bronze': index === 2, 'white': index > 2 }">{{ usuario.name }}</div>
              <div class="cell" :class="{ 'gold': index === 0, 'silver': index === 1, 'bronze': index === 2, 'white': index > 2 }">{{ usuario.total_puntos }}</div>
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
.gold {
  color: gold;
}

.silver {
  color: silver;
}

.bronze {
  color: #cd7f32;
}

.white {
  color: white;
}

.table-container {
  border: 2px solid #37ff8aed;
  border-radius: 8px;
  /* overflow: hidden; */
}

.fila {
  background: #18181b7c;
  display: flex;
  justify-content: space-between;
  align-items: center;
  /* Centra verticalmente el contenido */
}

.fila.header {
  color: #18181b;
  background: #37ff8aed;
  font-weight: bold;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  
  margin-bottom: -0px; /* Margen inferior negativo */
}

.cell {
  flex: 1;
  /* Ajusta el tamaño de todas las celdas */
  font-size: 18px;
  line-height: 1.2;
  padding-top: 20px;
  padding-bottom: 20px;
  text-align: center;
}

.medallas{
  display: inline-flex;
}

.logged-user {
  /* background-color: #37ff8aed; */
}

.logged-user .cell {
  color: #37ff8aed !important;
  font-weight: 550 !important;
}

.position-number {
  font-size: inherit;
  display: inline-block;
}
</style>
