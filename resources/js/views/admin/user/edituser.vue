<template>

  <h2>Perfil Usuario</h2>
  <div class="card cardFondo">
    <!-- {{ userData }} -->
    <div class="card-body" v-if="userData">
      <div class="col-12 divContenidoUser">
        <div class="col-6">
          <p class="pSecciones">Nombre <i class="pi pi-fw pi-address-book iconosUsuario"></i></p>
          <div class="cajaContenidos">
            <p>{{ userData.name }}</p>
          </div>

          <p class="pSecciones2">Email <i class="pi pi-fw pi-at"></i></p>
          <div class="cajaContenidos">
            <p>{{ userData.email }}</p>

          </div>
        </div>
        <div class="col-6">
          <p class="pSecciones">Apellido <i class="pi pi-fw pi-address-book"></i></p>
          <div class="cajaContenidos">
            <p>{{ userData.apellido }}</p>
          </div>
          <p class="pSecciones" style="margin-bottom: 4px;">Password <i class="pi pi-fw pi-lock"></i> <button
              class="botonPassword" @click="updatePassword(userData.id, index)">Cambia tu password</button></p>
          <div class="cajaContenidos">
            <p>***************</p>
          </div>
        </div>
      </div>
      <div class="col-12" style="text-align: center; padding-top: 50px;">
        <button class="botonGeneral" @click="updateUser(userData.id, index)">Editar Usuario</button>
      </div>
    </div>
    <div v-else>
      <p style="color: white;">Cargando...</p>
    </div>
  </div>

</template>
<!--
  Esta función muestra el cuadro de diálogo SweetAlert2 con el formulario de edición y envía una solicitud HTTP PUT para actualizar la información del usuario en el servidor.
También se define una función updatePassword que se activa cuando el usuario hace clic en el botón "Cambia tu contraseña". 
Esta función muestra el cuadro de diálogo SweetAlert2 con un campo para la nueva contraseña y envía una solicitud HTTP PUT para actualizar la contraseña del usuario en el servidor.
En el script, se importan las bibliotecas necesarias y se configuran algunas variables reactivas.
Se utiliza el ciclo de vida onMounted para cargar la información del usuario cuando el componente se monta. -->
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
      '<input id="swal-input2" class="swal2-input" placeholder="Apellido" value="' + currentData.apellido + '">' +
      '<input id="swal-input3" class="swal2-input" placeholder="Email" value="' + currentData.email + '">',


    focusConfirm: false,
    customClass: {
      popup: 'my-custom-popup-class',
      confirmButton: '',
      cancelButton: '',
      container: 'my-custom-container-class'
    },
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
        apellido: result.value[1],
        email: result.value[2],


      };

      axios.put('/api/user/update/' + id, updatedData)
        .then(response => {
          userData.value.name = updatedData.name;
          userData.value.apellido = updatedData.apellido;
          userData.value.email = updatedData.email;

          swal({
            icon: 'success',
            title: 'Usuario actualizado correctamente',
            customClass: {
              popup: 'my-custom-success-popup-class',
              title: 'my-custom-success-title-class',
            }
          });
        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido actualizar el usuario',
            customClass: {
              popup: 'my-custom-error-popup-class',
              title: 'my-custom-error-title-class',
            }
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
    customClass: {
      popup: 'my-custom-popup-class',
      confirmButton: '',
      cancelButton: '',
      container: 'my-custom-container-class'
    },
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
            title: 'Contraseña actualizada',
            customClass: {
              popup: 'my-custom-success-popup-class',
              title: 'my-custom-success-title-class',
            }
          });
        }).catch(error => {
          swal({
            icon: 'error',
            title: 'No se ha podido modificar la contraseña',
            customClass: {
              popup: 'my-custom-error-popup-class',
              title: 'my-custom-error-title-class',
            }
          });
        });
    }
  });
};

</script>
