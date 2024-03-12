<template>
    <div>
      <h2>Crear Plantilla</h2>
      <form @submit.prevent="crearPlantilla">
        <div>
          <label for="nombre">Nombre de la plantilla:</label>
          <input type="text" v-model="nombre" required>
        </div>
        <div>
          <label for="grl">GRL:</label>
          <input type="text" v-model="grl" required>
        </div>
        <div>
          <button type="submit">Crear Plantilla</button>
        </div>
      </form>
  
      <h2>Jugadores Seleccionados</h2>
      <ul>
        <li v-for="jugador in jugadoresSeleccionados" :key="jugador.id">
          {{ jugador.nombre }} - Valoración: {{ jugador.valoracion }}
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import axios from "axios";
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  
  const nombre = ref("");
  const grl = ref("");
  const jugadoresSeleccionados = ref([]);
  const router = useRouter();
  
  const crearPlantilla = () => {
    axios.post("/api/plantillas", { nombre: nombre.value, grl: grl.value })
      .then(response => {
        const nuevaPlantilla = response.data.data;
        console.log("Plantilla creada:", nuevaPlantilla);
  
        // Redirige a la página de la nueva plantilla
        router.push({ name: 'plantilla', params: { id: nuevaPlantilla.id } });
      })
      .catch(error => {
        console.error("Error al crear la plantilla:", error);
      });
  };
  </script>
  
  <style>
  /* Estilos opcionales */
  </style>
  