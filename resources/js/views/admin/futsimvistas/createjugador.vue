<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade una tarea nueva</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>
            {{ task }}
            <form @submit.prevent="crearJugador">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.nombre" type="text" class="form-control" placeholder="Nombre tarea">
                </div>


                <div class="form-group mb-2">
                    <label>Apellido</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.apellido" class="form-control" rows="3" placeholder="Descripción">
                </div>


                <div class="form-gorup mb-2">
                    <label>Fecha inicio</label><span class="text-danger">*</span>
                    <input v-model="jugadores.posicion" class="form-control" type="datetime-local" name="date_open" />
                </div>


                <div class="form-gorup mb-2">
                    <label>Fecha fin</label><span class="text-danger">*</span>
                    <input v-model="jugadores.nacionalidad" class="form-control" type="datetime-local" name="date_close" />
                </div>
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.valoracion" type="text" class="form-control" placeholder="Nombre tarea">
                </div>
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.carta" type="text" class="form-control" placeholder="Nombre tarea">
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir Jugador</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref } from "vue";
const task = ref({});
const strError = ref();
const strSuccess = ref();


function crearJugador(){
axios.post('/api/tasks', task.value)
    .then(response => {

        console.log(response);
        strSuccess.value = response.data.success;
        strError.value = "";
    }).catch(error => {
        console.log(error);
        strSuccess.value = "";
        strError.value = error.response.data.message;

    });
}
</script>


<style></style>