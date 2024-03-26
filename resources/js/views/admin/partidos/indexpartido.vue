<template>
  <div class="d-flex justify-content-between pb-2 mb-2">
    <h2 class="card-title">Partido {{ nombrePlantilla1 }} vs {{ nombrePlantilla2 }}</h2>
  </div>
  <div class="grid" v-if="jugadoresPlantilla1.length > 0 && jugadoresPlantilla2.length > 0">
    <!-- Mostrar jugadores de la plantilla 1 -->
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
    </div>
    <div>
      <button class="btn btn-primary" @click="jugarPartido">Jugar</button>
    </div>
    <div v-if="juegoIniciado" class="temporizador">
    <p>Temporizador: {{ tiempo }}</p>
    <div v-if="juegoIniciado" class="resultados">
    <p>{{ golesEquipo1Parcial }} - {{ golesEquipo2Parcial }}</p>

    <div v-if="minutos >= 45">
      <p>{{ nombrePlantilla1 }}: {{ golesEquipo1Parcial }} goles</p>
      <p>{{ nombrePlantilla2 }}: {{ golesEquipo2Parcial }} goles</p>
    </div>

    <div v-if="minutos >= 90">
      <p>Resultados finales del partido: {{ golesEquipo1 }} - {{ golesEquipo2 }}</p>
      <p>{{ nombrePlantilla1 }}: {{ golesEquipo1 }} goles</p>
      <p>{{ nombrePlantilla2 }}: {{ golesEquipo2 }} goles</p>
    </div>
  </div>  </div>
    <!-- Mostrar jugadores de la plantilla 2 -->
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
    </div>
  </div>

  <div v-else>
    <p>No se han seleccionado plantillas.</p>
  </div>

  <!-- Agregar el temporizador de PrimeVue -->
  
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useRoute } from 'vue-router';

// Declaración de variables reactivas
const nombrePlantilla1 = ref('');
const nombrePlantilla2 = ref('');
const jugadoresPlantilla1 = ref([]);
const jugadoresPlantilla2 = ref([]);
const route = useRoute();
const juegoIniciado = ref(false); // Indica si el juego está en curso
const tiempo = ref('00:00'); // Tiempo en formato de cadena (minutos:segundos)
let golesEquipo1Parcial = 0; // Goles acumulados hasta el minuto 45
let golesEquipo2Parcial = 0; // Goles acumulados hasta el minuto 45
let minutos = ref(0); // Variable para almacenar los minutos del partido
let golesEquipo1 = ref(0); // Goles totales del equipo 1 al final del partido
let golesEquipo2 = ref(0); // Goles totales del equipo 2 al final del partido

// Función para obtener los datos de las plantillas
onMounted(() => {
  const plantillaId = route.params.plantillaId;
  const plantillaSeleccionadaId = route.params.plantillaSeleccionadaId;

  axios.get(`/api/partidos/${plantillaId}/${plantillaSeleccionadaId}`).then(response => {
    if (response.data && response.data.jugadoresPlantilla1 && response.data.jugadoresPlantilla2) {
      nombrePlantilla1.value = response.data.nombrePlantilla1;
      nombrePlantilla2.value = response.data.nombrePlantilla2;
      jugadoresPlantilla1.value = response.data.jugadoresPlantilla1;
      jugadoresPlantilla2.value = response.data.jugadoresPlantilla2;
    } else {
      console.error('No se recibieron datos de jugadores correctamente');
    }
  }).catch(error => {
    console.error('Error al obtener jugadores de las plantillas:', error);
  });
});

// Función para jugar el partido
const jugarPartido = () => {
  juegoIniciado.value = true;
  let segundos = 0;
  let intervalo;

  const avanzarTiempo = () => {
    segundos += 1;
    if (segundos === 60) {
      minutos.value++;
      segundos = 0;
    }

    if (minutos.value === 45 && segundos === 0) {
      clearInterval(intervalo);
      golesEquipo1Parcial = Math.floor(Math.random() * 4);
      golesEquipo2Parcial = Math.floor(Math.random() * 4);

      Swal.fire({
        title: 'Resultados parciales al minuto 45',
        html: `
          <p>${nombrePlantilla1.value}: ${golesEquipo1Parcial} goles</p>
          <p>${nombrePlantilla2.value}: ${golesEquipo2Parcial} goles</p>
        `,
        icon: 'info'
      }).then(() => {
        intervalo = setInterval(avanzarTiempo, 1);
      });
    }

    if (minutos.value === 90) {
      clearInterval(intervalo);
      const golesEquipo1 = golesEquipo1Parcial + Math.floor(Math.random() * 3);
      const golesEquipo2 = golesEquipo2Parcial + Math.floor(Math.random() * 3);

      Swal.fire({
        title: 'Resultados finales del partido',
        html: `
          <p>${nombrePlantilla1.value}: ${golesEquipo1} goles</p>
          <p>${nombrePlantilla2.value}: ${golesEquipo2} goles</p>
        `,
        icon: 'info'
      }).then(() => {
        guardarResultadosPartido(golesEquipo1, golesEquipo2);
      });
    }

    tiempo.value = `${String(minutos.value).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;
  };

  intervalo = setInterval(avanzarTiempo, 1);
};

// Función para guardar los resultados del partido
const guardarResultadosPartido = (golesEquipo1, golesEquipo2) => {
  const plantillaId1 = route.params.plantillaId;
  const plantillaId2 = route.params.plantillaSeleccionadaId;

  axios.post(`/api/partidos/${plantillaId1}/${plantillaId2}/${golesEquipo1}/${golesEquipo2}`, {
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

<style>
.temporizador {
  font-size: 24px;
  font-weight: bold;
  color: white;
  padding: 10px 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
</style>
