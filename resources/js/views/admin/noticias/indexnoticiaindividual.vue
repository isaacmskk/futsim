<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div v-for="(noticia, index) in noticias" :key="noticia.id">
                        <div class="row">
                            <div class="col-md-4">
                                <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia" class="img-fluid" >
                            </div>
                            <div class="col-md-8">
                                <h5 class="card-title">{{ noticia.titulo }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ noticia.subtitulo }}</h6>
                                <p class="card-text">{{ noticia.contenido }}</p>
                                <p class="card-text"><small class="text-muted">{{ noticia.publicado }}</small></p>
                                <button class="botonGeneral"
                                    @click="mostrarFormularioComentario(noticia.id)">Comentar</button>
                                <table v-if="comentariosPorNoticia[noticia.id]" class="table table-hover table-sm mt-3">
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
                                </table>
                            </div>
                        </div>
                        <hr>
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
const noticias = ref([]);
onMounted(() => {

    console.log('/api/noticias/' + route.params.id);
    axios.get('/api/noticias/' + route.params.id)
        .then(response => {
            console.log(response.data);
            noticias.value = response.data; // Tratar como un array
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
        html:
            '<input id="swal-comentario" class="swal2-input" placeholder="Comentario">',
        focusConfirm: false,
        preConfirm: () => {
            return {
                comentario: document.getElementById('swal-comentario').value
            };
        },
        customClass: {
            popup: 'my-custom-popup-class', // Clase para el cuadro de diálogo
            confirmButton: 'my-custom-success-popup-class', // Clase para el botón de confirmar
            cancelButton: 'my-custom-cancel-button-class', // Clase para el botón de cancelar
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
            // Agregar el nuevo comentario a la lista local de comentarios
            if (!comentariosPorNoticia.value[nuevoComentario.id_noticia]) {
                comentariosPorNoticia.value[nuevoComentario.id_noticia] = [];
            }

            comentariosPorNoticia.value[nuevoComentario.id_noticia].push(response.data.data);
            swal({
                icon: 'success',
                title: 'Comentado correctamente :-)',
                customClass: {
                    popup: 'my-custom-success-popup-class', // Clase para el cuadro de diálogo de éxito
                    title: 'my-custom-success-title-class', // Clase para el título de éxito
                }
            });
        })
        .catch(error => {
            strSuccess.value = "";
            strError.value = error.response.data.message;
            swal({
                icon: 'error',
                title: 'No se ha podido eliminar la plantilla',
                customClass: {
                    popup: 'my-custom-error-popup-class', // Clase para el cuadro de diálogo de error
                    title: 'my-custom-error-title-class', // Clase para el título de error
                    confirmButton: 'my-custom-success-popup-class', // Clase para el botón de OK
                }
            });
        });
};



</script>

<style scoped>
.img-fluid {
    max-width: 100%;
    height: auto;
}
</style>