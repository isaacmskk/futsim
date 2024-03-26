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
  </div>
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
import { useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const nombrePlantilla1 = ref('');
const nombrePlantilla2 = ref('');
const jugadoresPlantilla1 = ref([]);
const jugadoresPlantilla2 = ref([]);
const route = useRoute();
const juegoIniciado = ref(false); // Indica si el juego está en curso
const tiempo = ref('00:00'); // Tiempo en formato de cadena (minutos:segundos)
let golesEquipo1Parcial = 0; // Goles acumulados hasta el minuto 45
let golesEquipo2Parcial = 0; // Goles acumulados hasta el minuto 45

onMounted(() => {
  // Recuperar los IDs de las plantillas seleccionadas de la ruta o el estado
  const plantillaId = route.params.plantillaId;
  const plantillaSeleccionadaId = route.params.plantillaSeleccionadaId;

  // Obtener jugadores de ambas plantillas
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


const jugarPartido = () => {
  // Iniciar el temporizador
  juegoIniciado.value = true;
  let minutos = 0;
  let segundos = 0;
  const intervalo = setInterval(() => {
    segundos += 1; // Incremento más rápido de los segundos
    if (segundos === 60) {
      minutos++;
      segundos = 0;
    }
    // Generar resultados parciales al minuto 45
    if (minutos === 45 && segundos === 0) {
      golesEquipo1Parcial = Math.floor(Math.random() * 5);
      golesEquipo2Parcial = Math.floor(Math.random() * 5);
      // Mostrar los resultados parciales al minuto 45 en un diálogo Swal
      Swal.fire({
        title: 'Resultados parciales al minuto 45',
        html: `
          <p>${nombrePlantilla1.value}: ${golesEquipo1Parcial} goles</p>
          <p>${nombrePlantilla2.value}: ${golesEquipo2Parcial} goles</p>
        `,
        icon: 'info'
      });
    }
    // Generar resultados finales al minuto 90
    if (minutos === 90) {
      clearInterval(intervalo);
      const golesEquipo1Final = golesEquipo1Parcial + Math.floor(Math.random() * 5);
      const golesEquipo2Final = golesEquipo2Parcial + Math.floor(Math.random() * 5);
      // Mostrar los resultados finales en un diálogo Swal
      Swal.fire({
        title: 'Resultados finales del partido',
        html: `
          <p>${nombrePlantilla1.value}: ${golesEquipo1Final} goles</p>
          <p>${nombrePlantilla2.value}: ${golesEquipo2Final} goles</p>
        `,
        icon: 'info'
      }).then(() => {
        // Guardar los resultados finales del partido en la base de datos
        guardarResultadosPartido(golesEquipo1Final, golesEquipo2Final);
      });
    }
    // Actualizar el tiempo en formato de cadena
    tiempo.value = `${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;
  }, 1); // Reducir el intervalo para simular 90 minutos más rápido
};

const guardarResultadosPartido = (golesEquipo1Final, golesEquipo2Final) => {
  // Obtener los IDs de las plantillas seleccionadas
  const plantillaId1 = route.params.plantillaId;
  const plantillaId2 = route.params.plantillaSeleccionadaId;

  // Guardar el partido en la base de datos
  axios.post(`/api/partidos/${plantillaId1}/${plantillaId2}`, {
    id_plantilla1: plantillaId1,
    usuario1: '',
    goles1: golesEquipo1Final,
    id_plantilla2: plantillaId2,
    usuario2: '',
    goles2: golesEquipo2Final
  }).then(response => {
    console.log('Partido jugado y guardado exitosamente:', response.data);
    // Aquí puedes realizar alguna acción adicional si lo deseas
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
}</style>
