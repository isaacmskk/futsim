<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos los jugadores</h5>
                        <div>
                            <router-link :to="{ name: 'futsimvistas.createjugador' }" class="btn btn-success">Nuevo Jugador</router-link>
                        </div>
                    </div>

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Posicion</th>
                                <th>Nacionalidad</th>
                                <th>Valoracion</th>
                                <th>Carta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(jugadores, index) in jugadores">
                                <td class="text-center">{{ jugadores.id }}</td>
                                <td>{{ jugadores.nombre }}</td>
                                <td>{{ jugadores.apellido }}</td>
                                <td>{{ jugadores.posicion }}</td>
                                <td>{{ jugadores.nacionalidad }}</td>
                                <td>{{ jugadores.valoracion }}</td>
                                <td>{{ jugadores.carta }}</td>
                                <td class="text-center">
                                    <!-- <router-link :to="{ name: 'jugadores.update' }" class="btn btn-success">Updatear Tarea</router-link> -->
                                    <!-- <button class="btn btn-danger" @click="deleteTask(task.id, index)">Delete</button> -->
                                </td>

                            </tr>
                        </tbody>
                    </table>
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
