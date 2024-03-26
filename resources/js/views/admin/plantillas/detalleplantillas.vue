<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Mis Plantillas</h2>
  </div>

  <div v-for="(plantilla, index) in plantillasUsuario" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <h3>{{ plantilla.nombre }}</h3>
          <button class="btn btn-danger" @click="deletePlantilla(plantilla.id, index)">Delete</button>
          <button class="botonGeneral" @click="mostrarPromptNombrePlantilla">Crea Plantilla</button>
          <tbody class="row">
            <div v-if="plantillasUsuario.length === 0" class="d-flex justify-content-between pb-2 mb-2">
              <p>No tienes plantillas creadas.</p>
            </div>
            <!-- Mostrar el nombre de la plantilla -->


            <!-- Iterar sobre los jugadores asociados con esta plantilla -->
            <div v-if="plantilla.jugadores.length === 0">
              <p>No tienes jugadores asociados a esta plantilla.</p>
            </div>
            <div v-for="jugador in plantilla.jugadores" :key="jugador.id"
              class="card col-12 col-lg-3 cartJugadores text-center" style="background-color: #00000000!important;">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
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
    title: '¿Quieres eliminar esta plantilla?',
    text: 'Esta acción no es reversible',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    confirmButtonColor: '#ef4444',
    cancelButtonText: 'No, cancelar', // Texto para el botón de cancelar
    cancelButtonColor: '#6b7280', // Color del botón de cancelar
    // timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
    customClass: {
      popup: 'my-custom-popup-class', // Clase para el cuadro de diálogo
      confirmButton: 'my-custom-confirm-button-class', // Clase para el botón de confirmar
      cancelButton: 'my-custom-cancel-button-class', // Clase para el botón de cancelar
    }
  }).then(result => {
    if (result.isConfirmed) {
      axios.delete('/api/misplantillas/' + index)
        .then((response) => {
          plantillasUsuario.value.splice(index, 1)
          swal({
            icon: 'success',
            title: 'Plantilla eliminada correctamente',
            customClass: {
              popup: 'my-custom-success-popup-class', // Clase para el cuadro de diálogo de éxito
              title: 'my-custom-success-title-class', // Clase para el título de éxito
            }
          })
        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido eliminar la plantilla',
            customClass: {
              popup: 'my-custom-error-popup-class', // Clase para el cuadro de diálogo de error
              title: 'my-custom-error-title-class', // Clase para el título de error
            }
          })
        });
    }
  })
}





const updateJugador = (id, index) => {

  const currentData = plantillasUsuario.value[index];
  swal.fire({
    title: 'Nombre de la plantilla',
    input: 'text',
    inputLabel: 'Introduce el nombre de la plantilla',
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value
      ]
    }

  }).
    then(result => {
      if (result.isConfirmed) {
        const updatedData = {
          nombre: result.value[0]

        };

        axios.put('/api/plantillas/update/' + id, updatedData)
          .then(response => {
            plantillasUsuario.value.splice(index, 1, updatedData);
            swal({
              icon: 'success',
              title: 'Nombre actualizado'
            });
          }).catch(error => {
            swal({
              icon: 'error',
              title: 'No se ha podido actualizar el nombre de la plantilla'
            });
          });
      }
    });
};
</script>

<style>
/* Estilos opcionales */
</style>
