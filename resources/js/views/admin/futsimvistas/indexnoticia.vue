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
                            <tr v-for="(noticia, index) in noticias" :key="noticia.id">
                                <td class="text-center">{{ noticia.id }}</td>
                                <td>{{ noticia.titulo }}</td>
                                <td>{{ noticia.subtitulo }}</td>
                                <td>{{ noticia.contenido }}</td>
                                <td>{{ noticia.publicado }}</td>
                                <td>{{ noticia.foto }}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger"
                                        @click="deleteNoticia(noticia.id, index)">Delete</button>
                                    <button class="btn btn-success"
                                        @click="mostrarFormularioComentario(noticia.id)">Comentar</button>
                                    <!-- <div>
                                        <router-link :to="{ name: 'futsimvistas.createcomentario', params: { id_noticia: noticia.id } }" class="btn btn-success">Hacer Comentario</router-link>
                                    </div> -->

                                    <!-- Mostrar comentarios solo para la noticia actual -->
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
                                            <tr v-for="(comentario, index) in comentariosPorNoticia[noticia.id]"
                                                :key="comentario.id">
                                                <td class="text-center">{{ comentario.id }}</td>
                                                <td>{{ comentario.comentario }}</td>
                                                <td>{{ comentario.id_usuario }}</td>
                                                <td>{{ comentario.time }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
const comentariosPorNoticia = ref({});

onMounted(() => {
    axios.get('/api/noticias')
        .then(response => {
            noticias.value = response.data;
        });
});

onMounted(() => {
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
            // console.log(response.data);
            // console.log( comentariosPorNoticia.value[nuevoComentario.id_noticia]);
            swal({
                    icon: 'success',
                    title: 'Comentado correctamente :-)'
                });
        })
        .catch(error => {
            strSuccess.value = "";
            strError.value = error.response.data.message;
        });
};

</script>

<style></style>
