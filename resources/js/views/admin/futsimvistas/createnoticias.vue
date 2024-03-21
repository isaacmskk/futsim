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
            {{ noticia }}
            <form @submit.prevent="addNoticia">
                <div class="form-group mb-2">
                    <label>Titulo</label><span class="text-danger"> *</span>
                    <input v-model="noticia.titulo" type="text" class="form-control" placeholder="Titulo Noticia">
                </div>


                <div class="form-group mb-2">
                    <label>Subtitulo</label><span class="text-danger"> *</span>
                    <textarea v-model="noticia.subtitulo" class="form-control" rows="3"
                        placeholder="Subtitulo Noticia"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label>Contenido</label><span class="text-danger"> *</span>
                    <textarea v-model="noticia.contenido" class="form-control" rows="3"
                        placeholder="Contenido Noticia"></textarea>
                </div>


                <div class="form-gorup mb-2">
                    <label>Fecha inicio</label><span class="text-danger">*</span>
                    <input v-model="noticia.publicado" class="form-control" type="datetime-local" name="publicado" />
                </div>


                <div class="form-gorup mb-2">
                    <label>Fecha fin</label><span class="text-danger">*</span>
                    <DropZone v-model="noticia.thumbnail" />
                </div>


                <button type="submit" class="botonGeneral">Añadir Noticia</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref, reactive } from "vue";
import DropZone from "@/components/DropZone.vue";

const noticia = reactive({
    id: '',
    titulo: '',
    subtitulo: '',
    contenido: '',
    publicado: '',
    thumbnail: ''
});
const strError = ref();
const strSuccess = ref();


function addNoticia() {
    let serializedNoticia = new FormData()
    for (let item in noticia) {
        if (noticia.hasOwnProperty(item)) {
            serializedNoticia.append(item, noticia[item])
        }
    }
    axios.post('/api/noticias', serializedNoticia)
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