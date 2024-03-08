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
import { ref, onMounted, inject } from 'vue';
import { useRoute } from 'vue-router';
const swal = inject('$swal');

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
const deleteNoticia = (id, index) => {
    swal({
        title: 'Quieres eliminar el jugador?',
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
                        title: 'Jugador eliminado correctamente'
                    })

                })

        })
}
</script>
