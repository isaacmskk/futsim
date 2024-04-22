<template>
  <h2>Mis Plantillas</h2>
  <div v-for="(plantilla, index) in plantillasUsuario" :key="plantilla.id" style="margin-bottom: 20px;">
    <div class="col-12">
      <div class="card cardFondo">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h3>{{ plantilla.nombre }}</h3>
            <div>
              <button class="btn-icon btn-green-border itemeditar estiloedit">
                <i class="pi pi-fw pi-pencil tamano" @click="updatePlantilla(plantilla.id, index)"></i>
              </button>
              <button class="btn-icon btn-green-border itemeliminar estiloeliminar">
                <i class="pi pi-fw pi-trash tamano" @click="deletePlantilla(plantilla.id, index)"></i>
              </button>
            </div>
          </div>
          <tbody class="row">
            <div v-if="plantillasUsuario.length === 0" class="d-flex justify-content-between pb-2 mb-2">
              <p>No tienes plantillas creadas.</p>
            </div>

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
import { useRouter } from 'vue-router';
const router = useRouter();
const swal = inject('$swal');
const plantillasUsuario = ref([]);

onMounted(() => {
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
    cancelButtonText: 'No, cancelar',
    cancelButtonColor: '#6b7280',
    timerProgressBar: true,
    reverseButtons: true,
    customClass: {
      popup: 'my-custom-popup-class',
      confirmButton: 'my-custom-confirm-button-class',
      cancelButton: 'my-custom-cancel-button-class',
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
              popup: 'my-custom-success-popup-class',
              title: 'my-custom-success-title-class',
            }
          })
        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido eliminar la plantilla',
            customClass: {
              popup: 'my-custom-error-popup-class',
              title: 'my-custom-error-title-class',
            }
          })
        });
    }
  })
}

const updatePlantilla = (id, index) => {
  const currentData = plantillasUsuario.value[index];

  swal({
    title: 'Editar nombre de la plantilla',
    html:
      '<input id="swal-input1" class="swal2-input" placeholder="Nombre de la plantilla" value="' + currentData.nombre + '">',
    showCancelButton: true,
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar',

    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value
      ];
    },
    customClass: {
      popup: 'my-custom-popup-class',
    },
  }).then(result => {
    if (result.isConfirmed) {
      const updatedData = {
        nombre: result.value[0]
      };

      axios.put('/api/plantillas/update/' + id, updatedData)
        .then(response => {
          plantillasUsuario.value.splice(index, 1, updatedData);
          swal({
            icon: 'success',
            title: 'Nombre de la plantilla actualizado correctamente',
            customClass: {
              popup: 'my-custom-success-popup-class',
              title: 'my-custom-success-title-class',
              content: 'my-custom-success-content-class',
            }
          });
          router.push({ name: 'plantillas.indexplantillas' });

        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido actualizar el nombre de la plantilla',
            customClass: {
              popup: 'my-custom-error-popup-class',
              title: 'my-custom-error-title-class',
              content: 'my-custom-error-content-class',
            }
          });
        });
    }
  });
};

</script>

<style>
.btn-icon {
  background-color: transparent;
  border: 1px solid transparent; /* Se define un borde transparente por defecto */
  cursor: pointer;
  padding: 0;
}

.tamano {
  font-size: 2rem !important; /* Ajusta el tamaño de las íconos */
}
.estiloeliminar:hover {
  border: 2px solid #37ff8a00;
  font-weight: bold;
  color: white !important;
  box-shadow: inset 0 500px 10px #e10017, 0 0 9px 3px rgba(27, 253, 156, 0.2);
}

.estiloeliminar {
  background: linear-gradient(to right, #18181b 1%, #18181b 100%);

  border: 2px solid #37ff8b;
  padding: 10px;
  border-radius: 50%;
}
.estiloedit:hover {
  border: 2px solid #37ff8a00;
  font-weight: bold;
  color: white !important;
  box-shadow: inset 0 500px 10px #bb00b4, 0 0 9px 3px rgba(27, 253, 156, 0.2);
}

.estiloedit {
  background: linear-gradient(to right, #18181b 1%, #18181b 100%);

  border: 2px solid #37ff8b;
  padding: 10px;
  border-radius: 50%;
}
.pi-trash:hover{
    font-size: 30px!important;
    color:white;
  }
  .pi-pencil:hover{
    font-size: 30px!important;
    color:white;
  }

  .itemeditar {
  border: 0px solid #37ff8b;
  background: linear-gradient(to right, rgba(27, 253, 156, 0.1) 1%, transparent 40%, transparent 60%, rgba(27, 253, 156, 0.1) 100%);
  box-shadow: inset 0 0 10px rgba(27, 253, 156, 0.4), 0 0 9px 3px rgba(27, 253, 155, 0.271);
  margin-right: 10px;
  color:white;
}

.itemeditar:hover {
  border: 0px solid #37ff8b;
  background: linear-gradient(to right, rgba(27, 253, 156, 0.1) 1%, transparent 40%, transparent 60%, rgba(27, 253, 156, 0.1) 100%);
  margin-right: 10px;
  font-weight: bold;
  color: black;
  box-shadow: inset 0 0 10px rgba(27, 253, 156, 0.4), 0 0 9px 3px rgba(27, 253, 155, 0.271);
  color: #37ff8b!important;
}
.itemeliminar {
  border: 2px solid #37ff8b;
  background: linear-gradient(to right, rgba(27, 253, 156, 0.1) 1%, transparent 40%, transparent 60%, rgba(27, 253, 156, 0.1) 100%);
  box-shadow: inset 0 0 10px rgba(27, 253, 156, 0.4), 0 0 9px 3px rgba(27, 253, 155, 0.271);
  margin-right: 10px;
  color:white;
}

.itemeliminar:hover {
  border: 2px solid #37ff8b;
  background: linear-gradient(to right, rgba(27, 253, 156, 0.1) 1%, transparent 40%, transparent 60%, rgba(27, 253, 156, 0.1) 100%);
  margin-right: 10px;
  font-weight: bold;
  color: black;
  box-shadow: inset 0 0 10px rgba(27, 253, 156, 0.4), 0 0 9px 3px rgba(27, 253, 155, 0.271);
  color: #37ff8b!important;
}
</style>
