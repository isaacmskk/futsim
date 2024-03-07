<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las noticias</h5>
                    </div>

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Titulo</th>
                                <th>Subtitulo</th>
                                <th>Contenido</th>
                                <th>Publicado</th>
                                <th>foto</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{ noticias.id }}</td>
                                <td>{{ noticias.titulo }}</td>
                                <td>{{ noticias.subtitulo }}</td>
                                <td>{{ noticias.contenido }}</td>
                                <td>{{ noticias.publicado }}</td>
                                <td>{{ noticias.foto }}</td>
                            
                                <td class="text-center">
                                    <button class="btn btn-danger"
                                        @click="deleteNoticia(noticias.id, index)">Delete</button>
                                    <button class="btn btn-success"
                                        @click="mostrarFormularioComentario(noticias.id)">Comentar</button>
                                    <!-- Mostrar comentarios solo para la noticia actual -->
                                    <!-- <table v-if="comentariosPorNoticia[noticia.id]" class="table table-hover table-sm">
                                        <thead class="bg-dark text-light">
                                            <tr>
                                                <th width="50" class="text-center">#</th>
                                                <th>Comentario</th>
                                                <th>ID Usuario</th>
                                                <th>Fecha y Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(comentario, index) in comentariosPorNoticia[noticia.id]"
                                                :key="comentario.id">
                                                <td class="text-center">{{ comentario.id }}</td>
                                                <td>{{ comentario.comentario }}</td>
                                                <td>{{ comentario.id_usuario }}</td>
                                                <td>{{ comentario.time }}</td>
                                            </tr>
                                        </tbody>
                                    </table> -->
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
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const noticias = ref([]);

onMounted(() => {
    axios.get('/api/noticias/' + route.params.id)
        .then(response => {
            noticias.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching news data:', error);
        });
});
</script>
