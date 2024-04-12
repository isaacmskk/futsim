<template>
  <h2>Ranking</h2>
  <div class="grid">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <div class="p-datatable">
            <div class="p-datatable-wrapper">
              <table class="p-datatable-table">
                <thead>
                  <tr>
                    <th>Posición</th>
                    <th>Usuario</th>
                    <th>Puntos</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(usuario, index) in ranking" :key="usuario.id_usuario">
                    <td>{{ usuario.posicion }}</td>
                    <td>{{ usuario.name }}</td>
                    <td>{{ usuario.total_puntos }}</td>
                  </tr>
                </tbody>
              </table>
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

<style>
/* Estilos CSS */
/* Estilos específicos de PrimeVue */
.p-datatable .p-datatable-wrapper {
  overflow: auto;
  max-height: 400px;
  /* Ajusta la altura máxima según tu diseño */
  color: white;

}

.p-datatable .p-datatable-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: auto;
}

.p-datatable .p-datatable-thead>tr>th {
  padding: 12px 20px;
  text-align: left;
  font-weight: bold;
  background-color: #f2f2f2;
  border-bottom: 1px solid #ccc;
}

.p-datatable .p-datatable-tbody>tr>td {
  padding: 10px 20px;
  border-bottom: 1px solid #ddd;
}

.p-datatable .p-datatable-tbody>tr:nth-child(even) {
  background-color: #f9f9f9;
}

.p-datatable .p-datatable-tbody>tr:hover {
  background-color: #f0f0f0;
}
</style>
