<template>
    <div>
      <h2>Datos del Usuario Actual</h2>
      <div v-if="userData">
        <p>ID: {{ userData.id }}</p>
        <p>Nombre: {{ userData.name }}</p>
        <p>Email: {{ userData.email }}</p>
        <!-- Mostrar más detalles del usuario si es necesario -->
      </div>
      <div v-else>
        <p>Cargando...</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const userData = ref(null);
  
  onMounted(async () => {
    try {
      const response = await axios.get('/api/user/current');
      userData.value = response.data;
    } catch (error) {
      console.error(error);
      // Manejar el error si la solicitud falla
    }
  });
  </script>
  
  <style>
  /* Estilos opcionales */
  </style>
   