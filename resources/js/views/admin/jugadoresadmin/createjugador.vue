<template>
    <h2>Añade un nuevo jugador</h2>
    <div class="card">
        <div class="card-body">
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
                    <input v-model="jugadores.nombre" type="text" class="form-control" placeholder="Nombre Jugador">
                </div>


                <div class="form-group mb-2">
                    <label>Apellido</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.apellido" class="form-control" placeholder="Apellido"
                        name="Apellido Jugador">
                </div>


                <div class="form-gorup mb-2">
                    <label>Posicion</label><span class="text-danger">*</span>
                    <input v-model="jugadores.posicion" class="form-control" placeholder="Posicion"
                        name="Posicion Jugador" />
                </div>


                <div class="form-gorup mb-2">
                    <label>Nacionalidad</label><span class="text-danger">*</span>
                    <input v-model="jugadores.nacionalidad" class="form-control" placeholder="Nacionalidad Jugador"
                        name="Nacionalidad" />
                </div>
                <div class="form-group mb-2">
                    <label>Valoracion</label><span class="text-danger"> *</span>
                    <input v-model="jugadores.valoracion" type="text" class="form-control"
                        placeholder="Valoracion Jugador" name="Valoracion">
                </div>
                <div class="form-group mb-2">
                    <label>Carta</label><span class="text-danger"> *</span>
                    <DropZone v-model="jugadores.thumbnail" />
                </div>


                <button type="submit" class="botonGeneral">Añadir Jugador</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref, reactive } from "vue";
import DropZone from "@/components/DropZone.vue";
import { useRouter } from 'vue-router';

const router = useRouter();

// const jugadores = ref({});
const jugadores = reactive({
    nombre: '',
    apellido: '',
    posicion: '',
    nacionalidad: '',
    valoracion: '',
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

    axios.post('/api/jugadores', serializedJugador, {
        headers: {
            "content-type": "multipart/form-data"
        }
    })
        .then(response => {

            console.log(response);
            strSuccess.value = response.data.success;
            strError.value = "";
            router.push({
                name: 'jugadoresadmin.indexjugador'
            });
        }).catch(error => {
            console.log(error);
            strSuccess.value = "";
            strError.value = error.response.data.message;

        });
}
</script>


<style>
label {
    color: rgb(171, 168, 168);
}
</style>