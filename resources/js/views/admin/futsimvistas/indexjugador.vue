<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos los jugadores</h5>
                        <div>
                            <router-link :to="{ name: 'futsimvistas.createjugador' }" class="btn btn-success">Nuevo
                                Jugador</router-link>
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
                            <tr v-for="(jugador, index) in jugadores">
                                <td class="text-center">{{ jugador.id }}</td>
                                <td>{{ jugador.nombre }}</td>
                                <td>{{ jugador.apellido }}</td>
                                <td>{{ jugador.posicion }}</td>
                                <td>{{ jugador.nacionalidad }}</td>
                                <td>{{ jugador.valoracion }}</td>
                                <td>{{ jugador.carta }}</td>
                                <td class="text-center">
                                    <!-- <router-link :to="{ name: 'jugadores.updatejugador/:id' }" class="btn btn-danger">Nuevo Jugador</router-link> -->
                                    <button class="btn btn-danger" @click="deleteJugador(jugador.id, index)">Delete</button>
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

const deleteJugador = (id, index) => {
    swal({
        title: 'Quieres eliminar el jugador?',
        text: 'Esta acción no es reversible!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#ef4444',
        timer: 20000,
        timerProgressBar: true,
        reverseButtons: true
    })
        .then(result => {
            axios.delete('/api/jugadores/' + id)
                .then(response => {
                    jugadores.value.splice(index, 1)
                    swal({
                        icon: 'success',
                        title: 'Jugador eliminado correctamente'
                    })

                }).catch(error => {
                    swal({
                        icon: 'error',
                        title: 'No se ha podido eliminar el jugador'
                    })

                });

        })
}

</script>


<style></style>
