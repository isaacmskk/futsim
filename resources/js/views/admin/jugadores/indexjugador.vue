<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title text-light">Todos los jugadores</h5>
                        <div>
                        </div>
                    </div>

                    <!-- <table class="table table-hover table-sm"> -->
                    <!-- <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Posicion</th>
                                <th>Nacionalidad</th>
                                <th>Valoracion</th>
                                <th>Carta</th>
                            </tr>
                        </thead> -->
                    <tbody class="row">
                        <tr v-for="(jugador, index) in jugadores" class="card col-4 cartJugadores text-center">
                            <!-- <td class="text-center">{{ jugador.id }}</td>
                                <td>{{ jugador.nombre }}</td>
                                <td>{{ jugador.apellido }}</td>
                                <td>{{ jugador.posicion }}</td>
                                <td>{{ jugador.nacionalidad }}</td>
                                <td>{{ jugador.valoracion }}</td> -->

                            <!-- <div class="col-4"> -->
                                <td class="p-2">
                                    <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-success" @click="">Seleccionar</button> 
                                </td>
                            <!-- </div> -->
                        </tr>
                    </tbody>
                    <!-- </table> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, inject } from "vue"
const jugadores = ref();
const swal = inject('$swal');


onMounted(() => {
    // console.log('Mi vista esta montada'); 
    axios.get('/api/jugadores')
        .then(response => {
            jugadores.value = response.data;
            console.log(response.data);
        })
});


</script>


<style></style>
