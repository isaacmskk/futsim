<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las noticias</h5>
                        <div>
                            <router-link :to="{ name: 'futsimvistas.createnoticia' }" class="btn btn-success">Nueva
                                Noticia</router-link>
                        </div>

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
                            <tr v-for="(noticia, index) in noticias">
                                <td class="text-center">{{ noticia.id }}</td>
                                <td>{{ noticia.titulo }}</td>
                                <td>{{ noticia.subtitulo }}</td>
                                <td>{{ noticia.contenido }}</td>
                                <td>{{ noticia.publicado }}</td>
                                <td>{{ noticia.foto }}</td>
                                <td class="text-center">


                                    <button class="btn btn-danger"
                                        @click="deleteNoticia(noticia.id, index)">Delete</button>
                                        <div>
                            <router-link :to="{ name: 'futsimvistas.createcomentario' }" class="btn btn-success">Hacer Comentario</router-link>
                        </div>
                                        <!-- <button class="btn btn-success"
                                        @click="crearComentario(comentario.id, store)">Crear Comentario</button> -->
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
import axios from "axios";
import { ref, onMounted, inject } from "vue"
const noticias = ref();
const swal = inject('$swal');


onMounted(() => {
    // console.log('Mi vista esta montada'); 
    axios.get('/api/noticias')
        .then(response => {
            noticias.value = response.data;
            console.log(response.data);
        })
});

const deleteNoticia = (id, index) => {
    swal({
        title: 'Quieres eliminar la noticia?',
        text: 'Esta acción no es reversible!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#ef4444',
        timer: 20000,
        timerProgressBar: true,
        reverseButtons: true
    })
        .then(result => {
            axios.delete('/api/noticias/' + id)
                .then(response => {
                    noticias.value.splice(index, 1)
                    swal({
                        icon: 'success',
                        title: 'Noticia eliminada correctamente'
                    })

                }).catch(error => {
                    swal({
                        icon: 'error',
                        title: 'No se ha podido eliminar la noticia'
                    })

                });

        })
}

</script>


<style></style>
