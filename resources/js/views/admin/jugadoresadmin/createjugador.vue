<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Añade un nuevo jugador</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>
            <form @submit.prevent="crearJugador">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.nombre" type="text" class="form-control" placeholder="Nombre tarea">
                </div>


                <div class="form-group mb-2">
                    <label>Apellido</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.apellido" class="form-control" placeholder="Apellido" name="Apellido">
                </div>


                <div class="form-gorup mb-2">
                    <label>Posicion</label><span class="text-danger">*</span>
                    <input v-model="jugadores.posicion" class="form-control" placeholder="Posicion" name="Posicion" />
                </div>


                <div class="form-gorup mb-2">
                    <label>Nacionalidad</label><span class="text-danger">*</span>
                    <input v-model="jugadores.nacionalidad" class="form-control" placeholder="Nacionalidad"
                        name="Nacionalidad" />
                </div>
                <div class="form-group mb-2">
                    <label>Valoracion</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.valoracion" type="text" class="form-control" placeholder="Valoracion"
                        name="Valoracion">
                </div>
                <div class="form-group mb-2">
                    <h6>Carta</h6><span class="text-danger"> *</span>

                    <DropZone v-model="jugadores.thumbnail" />
                </div>


                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir Jugador</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref } from "vue";
import DropZone from "@/components/DropZone.vue";

// const jugadores = ref({});
const jugadores = ref({
        nombre: '',
        apellido: '',
        posicion: '',
        nacionalidad:'',
        valoracion:'',
        thumbnail: ''
    })
const strError = ref();
const strSuccess = ref();

function crearJugador() {
    let serializedJugador = new FormData()
    for (let item in jugadores) {
        if (jugadores.hasOwnProperty(item)) {
            serializedJugador.append(item, jugadores[item])
        }
    }

    axios.post('/api/jugadores', jugadores.value)
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