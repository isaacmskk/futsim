<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Partido {{ nombrePlantilla1 }} vs {{ nombrePlantilla2 }}</h2>
  </div>
  <div class="grid" v-if="jugadoresPlantilla1.length > 0 && jugadoresPlantilla2.length > 0">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h3>{{ nombrePlantilla1 }}</h3>
          <div class="row">
            <div v-for="jugador in jugadoresPlantilla1" :key="jugador.id"
              class="col-12 col-lg-3 cartJugadores text-center">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </div>
        </div>
      </div>
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>{{ nombrePlantilla1 }}</th>
              <th>Valoración</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="jugador in jugadoresPlantilla1" :key="jugador.id">
              <td>{{ jugador.nombre }}</td>
              <td>{{ jugador.valoracion }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div>
      <button v-if="!juegoIniciado" class="botonGeneral" @click="jugarPartido">Jugar</button>
    </div>

    <div v-if="juegoIniciado" class="temporizador">
      <p>{{ tiempo }}</p>
      <div class="resultados">
        <p>{{ golesEquipo1 }} - {{ golesEquipo2 }}</p>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h3>{{ nombrePlantilla2 }}</h3>
          <div class="row">
            <div v-for="jugador in jugadoresPlantilla2" :key="jugador.id"
              class="col-12 col-lg-3 cartJugadores text-center">
              <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
            </div>
          </div>
        </div>
      </div>
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>{{ nombrePlantilla2 }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="jugador in jugadoresPlantilla2" :key="jugador.id">
              <td>{{ jugador.nombre }}</td>
              <td>{{ jugador.valoracion }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div v-else>
    <p>No se han seleccionado plantillas.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { routerKey, useRoute, useRouter } from 'vue-router';

const nombrePlantilla1 = ref('');
const nombrePlantilla2 = ref('');
const jugadoresPlantilla1 = ref([]);
const jugadoresPlantilla2 = ref([]);
const route = useRoute();
const router = useRouter();
const juegoIniciado = ref(false);
const tiempo = ref('00:00');
let minutos = ref(0);
let segundos = ref(0);
let golesEquipo1 = ref(0);
let golesEquipo2 = ref(0);
let intervalo;
const valoracionesPlantilla1 = ref([]);
const valoracionesPlantilla2 = ref([]);
const sumaValoraciones1 = ref(0);
const sumaValoraciones2 = ref(0);

onMounted(() => {
  const plantillaId = route.params.plantillaId;
  const plantillaSeleccionadaId = route.params.plantillaSeleccionadaId;

  axios.get(`/api/partidos/${plantillaId}/${plantillaSeleccionadaId}`).then(response => {
    if (response.data && response.data.jugadoresPlantilla1 && response.data.jugadoresPlantilla2) {
      nombrePlantilla1.value = response.data.nombrePlantilla1;
      nombrePlantilla2.value = response.data.nombrePlantilla2;
      jugadoresPlantilla1.value = response.data.jugadoresPlantilla1;
      jugadoresPlantilla2.value = response.data.jugadoresPlantilla2;

      // Calcular la suma de las valoraciones de la plantilla 1
      valoracionesPlantilla1.value = response.data.jugadoresPlantilla1.map(jugador => jugador.valoracion);
      sumaValoraciones1.value = valoracionesPlantilla1.value.reduce((acc, val) => acc + val, 0);

      // Calcular la suma de las valoraciones de la plantilla 2
      valoracionesPlantilla2.value = response.data.jugadoresPlantilla2.map(jugador => jugador.valoracion);
      sumaValoraciones2.value = valoracionesPlantilla2.value.reduce((acc, val) => acc + val, 0);

      console.log('Suma de valoraciones plantilla 1:', sumaValoraciones1.value);
      console.log('Suma de valoraciones plantilla 2:', sumaValoraciones2.value);
      // Llamar a la función avanzarTiempo para iniciar el partido
    } else {
      console.error('No se recibieron datos de jugadores correctamente');
    }
  }).catch(error => {
    console.error('Error al obtener jugadores de las plantillas:', error);
  });
});


const jugarPartido = () => {
  juegoIniciado.value = true;
  avanzarTiempo(router);
};

const avanzarTiempo = (router) => {
  intervalo = setInterval(() => {
    segundos.value++;
    if (segundos.value === 60) {
      minutos.value++;
      segundos.value = 0;
    }
    if (minutos.value === 45 && segundos.value === 0) {
      pausarPartido();
    }
    if (minutos.value === 90 && segundos.value === 0) {
      clearInterval(intervalo);
      terminarPartido();
    }

    tiempo.value = `${String(minutos.value).padStart(2, '0')}:${String(segundos.value).padStart(2, '0')}`;

    // Ajustar la probabilidad en función de la suma de las valoraciones de cada equipo
    const probabilidadEquipo1 = sumaValoraciones1.value * 0.000001;
    const probabilidadEquipo2 = sumaValoraciones2.value * 0.000001;

    // Comprobar si se marca gol para cada equipo según la probabilidad ajustada
    if (Math.random() < probabilidadEquipo1) {
      golesEquipo1.value++;
      mostrarGol(nombrePlantilla1.value);
    }
    if (Math.random() < probabilidadEquipo2) {
      golesEquipo2.value++;
      mostrarGol(nombrePlantilla2.value);
    }
  }, 0.2);
};

const pausarPartido = () => {
  clearInterval(intervalo);
  Swal.fire({
    title: '¡Descanso!',
    text: '¿Reanudar el partido?',
    confirmButtonText: 'Sí',
    customClass: {
      popup: 'my-custom-popup-class',
    },
  }).then((result) => {
    if (result.isConfirmed) {
      avanzarTiempo(router);
    }
  });
};

const terminarPartido = () => {
  let resultadoMensaje = '';
  if (golesEquipo1.value > golesEquipo2.value) {
    resultadoMensaje = `Has Perdido`;
  } else if (golesEquipo1.value < golesEquipo2.value) {
    resultadoMensaje = `Has Ganado`;
  } else {
    resultadoMensaje = 'Has Empatado';
  }

  Swal.fire({
    title: '¡Fin del partido!',
    text: `¡El partido ha terminado! ${resultadoMensaje}`,
    text: `${resultadoMensaje}`,
    icon: 'info',
    confirmButtonText: 'Aceptar',
    customClass: {
      popup: 'my-custom-success-popup-class',
      title: 'my-custom-success-title-class',
      content: 'my-custom-success-content-class',
    }
  }).then(() => {
    guardarResultadosPartido(golesEquipo1.value, golesEquipo2.value);
    router.push('/admin/ranking');
  });
};


const mostrarGol = (equipo) => {
  Swal.fire({
    title: `<i class="pi pi-fw pi-trophy"></i> ¡Gol de ${equipo}!`, // Aquí agregamos el icono dentro del título
    icon: 'success',
    timer: 2000,
    timerProgressBar: true,
    toast: true,
    position: 'top', // Centra la alerta en la pantalla
    showConfirmButton: false,
    customClass: {
      popup: 'my-custom-success-popup-class2',
      title: 'my-custom-title-class' // Agregamos una clase de estilo personalizada para el título
    }
  });
};


const guardarResultadosPartido = (golesEquipo1, golesEquipo2) => {
  const plantillaId1 = route.params.plantillaId;
  const plantillaId2 = route.params.plantillaSeleccionadaId;

  // Calcular la diferencia de valoración entre las dos plantillas
  const diferenciaValoracion = sumaValoraciones1.value - sumaValoraciones2.value;

  // Definir un factor de ajuste basado en la diferencia de valoración
  let factorAjuste = 1;
  if (diferenciaValoracion > 0) {
    factorAjuste = 1 + diferenciaValoracion * 0.009; // Cuanto mayor es la diferencia, mayor es el factor de ajuste
  } else if (diferenciaValoracion < 0) {
    factorAjuste = 1 / (1 - diferenciaValoracion * 0.009); // Cuanto menor es la diferencia, mayor es el factor de ajuste
  }

  let puntosequipo = 0;
  if (golesEquipo1 < golesEquipo2) {
    puntosequipo = 100 * factorAjuste; // Se suman más puntos si se pierde contra un rival más valorado
  } else if (golesEquipo1 > golesEquipo2) {
    puntosequipo = -50 / factorAjuste; // Se restan menos puntos si se gana contra un rival más valorado
  } else {
    puntosequipo = 15 * factorAjuste;
  }
console.log(factorAjuste);
  console.log(puntosequipo)
  axios.post(`/api/partidos/${plantillaId1}/${plantillaId2}/${golesEquipo1}/${golesEquipo2}/${puntosequipo}`, {
    id_plantilla1: plantillaId1,
    usuario1: '',
    goles1: golesEquipo1,
    id_plantilla2: plantillaId2,
    usuario2: '',
    goles2: golesEquipo2
  }).then(response => {
    console.log('Partido jugado y guardado exitosamente:', response.data);
  }).catch(error => {
    console.error('Error al guardar el partido:', error);
  });
};

</script>

<style></style>

