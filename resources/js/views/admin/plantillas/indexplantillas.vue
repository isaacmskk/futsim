<template>
  <div>
    <div>
      <router-link :to="{ name: 'plantillas.createplantillas' }" class="btn btn-success">Nueva
        Noticia</router-link>
    </div>
    <h2>Jugadores Seleccionados</h2>
    <ul>
      <li v-for="jugador in jugadoresSeleccionados" :key="jugador.id">
        {{ jugador.nombre }} - Valoración: {{ jugador.valoracion }}
      </li>
    </ul>
  </div>
</template>

<script setup>

</script>

<style>
/* Estilos opcionales */
</style>
