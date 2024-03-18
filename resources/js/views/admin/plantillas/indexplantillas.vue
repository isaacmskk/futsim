<template>
    <div>
      <h2>Detalles de la Plantilla</h2>
      <p>Nombre: {{ plantilla.nombre }}</p>
      <p>GRL: {{ plantilla.grl }}</p>
  
      <h3>Jugadores Seleccionados</h3>
      <ul>
        <li v-for="jugador in jugadoresSeleccionados" :key="jugador.id">
          {{ jugador.nombre }} - Valoración: {{ jugador.valoracion }}
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import axios from "axios";
  import { ref, onMounted } from "vue";
  import { useRouter } from "vue-router";
  
  const plantilla = ref({});
  const jugadoresSeleccionados = ref([]);
  const router = useRouter();
  
  onMounted(() => {
    cargarDetallesPlantilla();
  });
  
  const cargarDetallesPlantilla = () => {
    const plantillaId = router.params.id;
    axios.get(`/api/plantillas/${plantillaId}`)
      .then(response => {
        plantilla.value = response.data;
        cargarJugadoresSeleccionados();
      })
      .catch(error => {
        console.error("Error al cargar detalles de la plantilla:", error);
      });
  };
  
  const cargarJugadoresSeleccionados = () => {
    const plantillaId = router.params.id;
    axios.get(`/api/plantillas/${plantillaId}/jugadores`)
      .then(response => {
        jugadoresSeleccionados.value = response.data;
      })
      .catch(error => {
        console.error("Error al cargar jugadores seleccionados:", error);
      });
  };
  </script>
  
  <style>
  /* Estilos opcionales */
  </style>
  