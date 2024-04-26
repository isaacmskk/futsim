<template>
    <h2>Añade una noticia nueva</h2>
    <div class="card">
        <div class="card cardFondo">
            <div class="d-flex justify-content-between pb-2 mb-2">
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>
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

                <div class="form-group mb-2">
                    <label>Fecha inicio</label><span class="text-danger">*</span>
                    <input v-model="noticia.publicado" class="form-control" type="datetime-local" name="publicado" />
                </div>

                <div class="form-group mb-2">
                    <label>Categoría</label><span class="text-danger">*</span>
                    <select v-model="noticia.categorias" class="form-control" multiple>
                        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                            {{ categoria.categoria }}
                        </option>
                    </select>

                </div>
                <div class="form-gorup mb-2">
                    <label>FOTO</label><span class="text-danger">*</span>
                    <DropZone v-model="noticia.thumbnail" class="" />
                </div>
                <button type="submit" class="botonGeneral">Añadir</button>
            </form>
        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref, reactive, onMounted } from "vue";
import DropZone from "@/components/DropZone.vue";
import { useRouter } from 'vue-router';

const router = useRouter();

const noticia = reactive({
    id: '',
    titulo: '',
    subtitulo: '',
    contenido: '',
    publicado: '',
    thumbnail: '',
    categoria_id: ''
});

const categorias = ref([]);

onMounted(() => {
    // Cargar categorías disponibles al cargar la página
    axios.get('/api/categorias')
        .then(response => {
            console.log(response.data); // Verifica los datos de respuesta
            categorias.value = response.data;
        }).catch(error => {
            console.error(error);
        });
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
            router.push({
                name: 'noticiasadmin.indexnoticia'
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