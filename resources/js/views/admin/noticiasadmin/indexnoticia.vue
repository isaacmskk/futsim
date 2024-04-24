<template>
    <h2>Todas las noticias(Admin)</h2>
    <div class="grid">

        <div class="col-12">
            <div class="card cardFondo">
                <div class="card-body">

                    <div class="justify-content-between pb-2 mb-2">
                        <div class="col-12 col-lg-6">
                            <router-link :to="{ name: 'noticiasadmin.createnoticia' }" class="botonGeneral">Nueva
                                Noticia</router-link>
                        </div>

                    </div>
                    <div class="row">
                        <tr v-for="(noticia, index) in noticias" :key="noticia.id"
                            class="card col-12 col-lg-4 text-center"
                            style="background-color: #00000000!important; color: white;">
                            <td class="text-center">{{ noticia.id }}</td>
                            <td class="">
                                <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia"
                                    class="imgNoticias">
                            </td>
                            <td>
                                <p>{{ noticia.titulo }}</p>
                            </td>
                            <td>
                                <p>{{ noticia.subtitulo }}</p>
                            </td>
                            <td>
                                <p>{{ noticia.contenido }}</p>
                            </td>
                            <td>
                                <p>{{ noticia.publicado }}</p>
                            </td>

                            <td>
                                <button class="itemEliminar espacioEliminar">
                                    <i class="pi pi-fw pi-trash tamano" @click="deleteNoticia(noticia.id, index)"></i>
                                </button>
                            </td>

                        </tr>
                    </div>
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
