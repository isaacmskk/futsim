<template>
    <h2>Todas las noticias(Admin)</h2>

    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card cardFondo">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <div>
                            <router-link :to="{ name: 'futsimvistas.createnoticia' }" class="botonGeneral">Nueva
                                Noticia</router-link>
                        </div>

                    </div>

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">ID</th>
                                <th>Titulo</th>
                                <th>Subtitulo</th>
                                <th>Contenido</th>
                                <th>Publicado</th>
                                <th>foto</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(noticia, index) in noticias" :key="noticia.id">
                                <td class="text-center">{{ noticia.id }}</td>
                                <td>{{ noticia.titulo }}</td>
                                <td>{{ noticia.subtitulo }}</td>
                                <td>{{ noticia.contenido }}</td>
                                <td>{{ noticia.publicado }}</td>

                                <td>
                                    <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia"
                                        class="imgJugador">
                                </td>
                                <td> <i class="pi pi-fw pi-trash" @click="deleteNoticia(noticia.id, index)"></i></td>
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
import { useRouter } from 'vue-router';

const noticias = ref();
const swal = inject('$swal');
const comentariosPorNoticia = ref({});
const router = useRouter();
onMounted(() => {
    axios.get('/api/noticias')
        .then(response => {
            noticias.value = response.data;
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

const deleteNoticia = (id, index) => {

    axios.delete('/api/noticias/' + id)
        .then(response => {
            noticias.value.splice(index, 1)
            swal({
                icon: 'success',
                title: 'Noticia eliminada correctamente',
                customClass: {
                    popup: 'my-custom-success-popup-class',
                    title: 'my-custom-success-title-class',
                }
            })

        }).catch(error => {
            swal({
                icon: 'error',
                title: 'No se ha podido eliminar la noticia',
                customClass: {
                    popup: 'my-custom-error-popup-class',
                    title: 'my-custom-error-title-class',
                }
            })
        });
}
</script>

<style></style>
