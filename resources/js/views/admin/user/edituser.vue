<template>

  <h2>Cambiar Datos Usuario</h2>
  <div class="card cardFondo">
    <!-- {{ userData }} -->
    <div class="card-body" v-if="userData">
      <div class="col-12 divContenidoUser">
        <div class="col-6">
          <p class="pSecciones">Nombre <i class="pi pi-fw pi-address-book iconosUsuario"></i></p>
          <div class="cajaContenidos">
            <p>{{ userData.name }}</p>
          </div>

          <p class="pSecciones">Email <i class="pi pi-fw pi-at"></i></p>
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

<style>
.divContenidoUser {
  display: inline-flex;
}

.cajaContenidos {
  text-align: center;
  /* width: fit-content; */
  /* min-width: 300px; */
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
  margin-right: 40px;

}

.pSecciones {
  font-family: Tahoma !important;
  font-weight: 500;
  line-height: 1.2;
  color: var(--surface-900);
  font-size: 18px;
  padding-top: 10px;
  /* font-weight: bold; */
}



.botonPassword {
  border-radius: 4px !important;
  border: 2px solid var(--green);
  background-color: #37ff8a00;
  color: #ff37f5;
  padding: 5px;
  margin-left: 225px;

}

.botonPassword:hover {
  background-color: #ff37eb2c;
  color: white;
  padding-left: 5px;
}

@media only screen and (max-width: 600px) {
  .pSecciones {
    font-size: 16px;
  }

  .botonPassword {
    font-size: 16px;
    margin-left: 0px;
    padding-left: 0px;
  }

}
</style>
