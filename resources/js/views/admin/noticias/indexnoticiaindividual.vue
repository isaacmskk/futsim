<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">{{ noticia.titulo }}</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia" class="img-fluid">
                        </div>
                        <div class="col-lg-6">
                            <p>{{ noticia.subtitulo }}</p>
                            <p>{{ noticia.contenido }}</p>
                            <p>{{ noticia.publicado }}</p>
                            
                            <button class="btn btn-success" @click="mostrarFormularioComentario(noticia.id)">Comentar</button>
                            
                            <table v-if="comentariosPorNoticia[noticia.id]" class="table table-hover table-sm">
                                <thead class="bg-dark text-light">
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Comentario</th>
                                        <th>ID Usuario</th>
                                        <th>Fecha y Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(comentario, index) in comentariosPorNoticia[noticia.id]" :key="comentario.id">
                                        <td class="text-center">{{ comentario.id }}</td>
                                        <td>{{ comentario.comentario }}</td>
                                        <td>{{ comentario.id_usuario }}</td>
                                        <td>{{ comentario.time }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, inject } from "vue";
import { useRoute } from 'vue-router';

const swal = inject('$swal');
const comentariosPorNoticia = ref({});
const route = useRoute();
const noticia = ref(null);

onMounted(() => {
    axios.get('/api/noticias/' + route.params.id)
        .then(response => {
            noticia.value = response.data;
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching news data:', error);
        });

    axios.get('/api/comentarios')
        .then(response => {
            // Organizar comentarios por noticia
            comentariosPorNoticia.value = groupComentariosPorNoticia(response.data);
        });
});
// Función para organizar comentarios por noticia
const groupComentariosPorNoticia = (comentarios) => {
    const groupedComentarios = {};
    comentarios.forEach((comentario) => {
        const idNoticia = comentario.id_noticia;
        if (!groupedComentarios[idNoticia]) {
            groupedComentarios[idNoticia] = [];
        }
        groupedComentarios[idNoticia].push(comentario);
    });
    return groupedComentarios;
};

const mostrarFormularioComentario = (idNoticia) => {
    swal({
        title: 'Agregar Comentario',
        html: '<input id="swal-comentario" class="swal2-input" placeholder="Comentario">',
        focusConfirm: false,
        preConfirm: () => {
            return { comentario: document.getElementById('swal-comentario').value };
        }
    }).then(result => {
        if (result.isConfirmed) {
            const nuevoComentario = {
                id_noticia: idNoticia,
                comentario: result.value.comentario
            };
            crearComentario(nuevoComentario);
        }
    });
};

const crearComentario = (nuevoComentario) => {
    axios.post('/api/comentarios', nuevoComentario)
        .then(response => {
            if (!comentariosPorNoticia.value[nuevoComentario.id_noticia]) {
                comentariosPorNoticia.value[nuevoComentario.id_noticia] = [];
            }

            comentariosPorNoticia.value[nuevoComentario.id_noticia].push(response.data.data);
            swal({ icon: 'success', title: 'Comentado correctamente :-)' });
        })
        .catch(error => {
            strSuccess.value = "";
            strError.value = error.response.data.message;
        });
};
</script>

<style></style>
