<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Mis Plantillas</h2>
  </div>

  <div class="grid" v-for="plantilla in plantillasUsuario" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <tbody class="row">
            <div v-if="plantillasUsuario.length === 0" class="d-flex justify-content-between pb-2 mb-2">
              <p>No tienes plantillas creadas.</p>
            </div>
            <!-- Mostrar el nombre de la plantilla -->
            <h3>{{ plantilla.nombre }}</h3>
            <button class="btn btn-danger" @click="deletePlantilla(plantilla.id, index)">Delete</button>

            <!-- Iterar sobre los jugadores asociados con esta plantilla -->
            <div v-if="plantilla.jugadores.length === 0">
              <p>No tienes jugadores asociados a esta plantilla.</p>
            </div>
            <!-- <div v-else> -->
            <div v-for="jugador in plantilla.jugadores" :key="jugador.id"
              class="card col-12 col-lg-3 cartJugadores text-center" style="background-color: #00000000!important;">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
            <!-- </div> -->
          </tbody>
        </div>
      </div>
    </div>
  </div>


</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, inject } from "vue"

const swal = inject('$swal');
const plantillasUsuario = ref([]);

onMounted(() => {
  // Cargar las plantillas del usuario autenticado
  axios.get('/api/misplantillas').then((response) => {
    plantillasUsuario.value = response.data;
  });
});

const deletePlantilla = (id, index) => {
  swal({
    title: 'Quieres eliminar esta plantilla?',
    text: 'Esta acción no es reversible!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    confirmButtonColor: '#ef4444',
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true
  })
    .then(result => {
      axios.delete('/api/misplantillas/' + id)
        .then((response) => {
          plantillasUsuario.value.splice(index, 1)
          swal({
            icon: 'success',
            title: 'Plantilla eliminada correctamente'
          })

        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido eliminar la plantilla'
          })
        });

    })
}
</script>

<style>
/* Estilos opcionales */
</style>
