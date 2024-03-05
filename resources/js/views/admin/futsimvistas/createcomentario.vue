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
            {{ comentarios }}
            <form @submit.prevent="crearComentario">

                <div class="form-group mb-2">
                    <input v-model="comentarios.id_noticia" type="text" class="form-control" placeholder="ID_NOTICIA" hidden>
                </div>
                <div class="form-group mb-2">
                    <label>Comentario:</label><span class="text-danger"> *</span>
                    <input v-model="comentarios.comentario" type="text" class="form-control" placeholder="Comentario">
                </div>
                <div class="form-group mb-2">
                    <input v-model="comentarios.id_usuario" type="text" class="form-control" placeholder="Nombre tarea" hidden>
                </div>
                <div class="form-group mb-2">
                    <input v-model="comentarios.time" type="text" class="form-control" placeholder="Nombre tarea" hidden>
                </div>



                <button type="submit" class="btn btn-primary mt-4 mb-4">Añadir Comentario</button>


            </form>


        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, defineProps } from "vue";
import axios from "axios";

const { id_noticia } = defineProps(['id_noticia']);

const comentarios = ref({});
const strError = ref();
const strSuccess = ref();

onMounted(() => {
  comentarios.value.id_noticia = id_noticia;
});

const crearComentario = () => {
  axios.post('/api/comentarios', comentarios.value)
    .then(response => {
      console.log(response);
      strSuccess.value = response.data.success;
      strError.value = "";
    })
    .catch(error => {
      console.log(error);
      strSuccess.value = "";
      strError.value = error.response.data.message;
    });
};


</script>


<style></style>