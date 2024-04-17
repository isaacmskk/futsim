<template>
  <div class="card cardFondo">
    <h2>Cambiar Datos Usuario</h2>
    <div v-if="userData">
      <p>Nombre: {{ userData.name }}</p>
      <p>Email: {{ userData.email }}</p>
    </div>
    <div v-else>
      <p>Cargando...</p>
    </div>
    <i class="pi pi-fw pi-pencil" @click="updateUser(userData.id, index)"></i>

  </div>

</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import axios from 'axios';
const swal = inject('$swal');

const userData = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get('/api/user/current');
    userData.value = response.data.data; // Acceder a la propiedad 'data'
  } catch (error) {
    console.error(error);
  }
});

const updateUser = (id, index) => {
  const currentData = userData.value;

  swal({
    title: 'Editar Usuario',
    html:
      '<input id="swal-input1" class="swal2-input" placeholder="Nombre" value="' + currentData.name + '">' +
      '<input id="swal-input2" class="swal2-input" placeholder="Email" value="' + currentData.email + '">' ,
    focusConfirm: false,
    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value,
        document.getElementById('swal-input2').value,
      ]
    }
  }).then(result => {
    if (result.isConfirmed) {
      const updatedData = {
        name: result.value[0],
        email: result.value[1],
      };

      axios.put('/api/user/update/' + id, updatedData)
        .then(response => {
          userData.value.name = updatedData.name;
          userData.value.email = updatedData.email;
          swal({
            icon: 'success',
            title: 'Usuario actualizado correctamente'
          });
        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido actualizar el usuario'
          });
        });
    }
  });
};


</script>

<style>
/* Estilos opcionales */
</style>