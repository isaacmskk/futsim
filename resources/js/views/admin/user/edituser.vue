<template>

  <h2>Cambiar Datos Usuario</h2>
  <div class="card cardFondo">
    <!-- {{ userData }} -->
    <div class="card-body" v-if="userData">
      <div class="col-12" style="display: inline-flex;">
        <div class="col-6">
          <p class="pSecciones">Nombre: </p>
          <div class="cajaContenidos">
            <p>{{ userData.name }}</p>
          </div>

          <p class="pSecciones">Email: </p>
          <div class="cajaContenidos">
            <p>{{ userData.email }}</p>

          </div>
        </div>
        <div class="col-6">
          <p class="pSecciones">Apellido: </p>
          <div class="cajaContenidos">
            <p>{{ userData.apellido }}</p>

          </div>

          <p class="pSecciones">Password: </p>
          <div class="cajaContenidos">
            <p>***************</p>
          </div>

        </div>
      </div>

      <i class="pi pi-fw pi-pencil" @click="updateUser(userData.id, index)"></i>
      <i class="pi pi-fw pi-lock" @click="updatePassword(userData.id, index)"></i>
    </div>
    <div v-else>
      <p>Cargando...</p>
    </div>



  </div>

</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import axios from 'axios';
const swal = inject('$swal');

const userData = ref(null);
const roleData = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get('/api/user');
    userData.value = response.data.data; // Acceder a la propiedad 'data'
  } catch (error) {
    console.error(error);
  }
});
onMounted(async () => {
  try {
    const response = await axios.get('/api/user/current');
    roleData.value = response.data.data; // Acceder a la propiedad 'data'
  } catch (error) {
    console.error(error);
  }
});

const updateUser = (id, index) => {
  const currentData = userData.value;

  swal({
    title: 'Editar Usuario',
    html:
      '<input id="swal-input1" class="swal2-input" placeholder="Nombre"  value="' + currentData.name + '">' +
      '<input id="swal-input2" class="swal2-input" placeholder="Email" value="' + currentData.email + '">' +
      '<input id="swal-input3" class="swal2-input" placeholder="Apellido" value="' + currentData.apellido + '">',

    focusConfirm: false,
    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value,
        document.getElementById('swal-input2').value,
        document.getElementById('swal-input3').value,


      ]
    }
  }).then(result => {
    if (result.isConfirmed) {
      const updatedData = {
        name: result.value[0],
        email: result.value[1],
        apellido: result.value[2],


      };

      axios.put('/api/user/update/' + id, updatedData)
        .then(response => {
          userData.value.name = updatedData.name;
          userData.value.email = updatedData.email;
          userData.value.apellido = updatedData.apellido;

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


const updatePassword = (id, index) => {
  const currentData = userData.value;

  swal({
    title: 'Cambia tu contraseña',
    html:
      '<input id="swal-input1" class="swal2-input" placeholder="Nombre" type="hidden" value="' + currentData.name + '">' +
      '<input id="swal-input2" class="swal2-input" placeholder="Email" type="hidden" value="' + currentData.email + '">' +
      '<input id="swal-input3" class="swal2-input" placeholder="Apellido" type="hidden" value="' + currentData.apellido + '">' +
      '<input id="swal-input4" class="swal2-input" placeholder="*******" value="">',

    focusConfirm: false,
    preConfirm: () => {
      return [
        document.getElementById('swal-input1').value,
        document.getElementById('swal-input2').value,
        document.getElementById('swal-input3').value,
        document.getElementById('swal-input4').value,


      ]
    }
  }).then(result => {
    if (result.isConfirmed) {
      const updatedData = {
        name: result.value[0],
        email: result.value[1],
        apellido: result.value[2],
        password: result.value[3],


      };

      axios.put('/api/user/password/' + id, updatedData)
        .then(response => {
          userData.value.name = updatedData.name;
          userData.value.email = updatedData.email;
          userData.value.apellido = updatedData.apellido;
          userData.value.password = updatedData.password;

          swal({
            icon: 'success',
            title: 'Contraseña actualizada'
          });
        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido modificar la contraseña'
          });
        });
    }
  });
};

</script>

<style>
.cajaContenidos {
  text-align: center;
  width: fit-content;
  min-width: 300px;
  padding: 10px;
  --green: #37FF8B;
  padding: 0.7em 1.2em;
  letter-spacing: 0.06em;
  position: relative;
  font-family: inherit;
  border-radius: 1em;
  overflow: hidden;
  transition: all 0.5s;
  line-height: 1.4em;
  border: 2px solid var(--green);
  color: white;
  box-shadow: inset 0 0 10px rgba(27, 253, 156, 0.4), 0 0 9px 3px rgba(27, 253, 156, 0.1);
  font-weight: bold;

}

.pSecciones{
  font-family: Tahoma!important;
    font-weight: 500;
    line-height: 1.2;
    color: var(--surface-900);
    font-size: 18px;
    padding-top: 10px;
    font-weight: bold;
}
</style>
