<template>
    <h2>Noticias(Admin)</h2>
    <div class="grid">
        <div class="col-12">
            <div class="card cardFondo">
                <div class="card-body">
                    <div class="row pb-2 mb-2">
                        <div class="col-12 col-lg-4 text-start">
                            <input v-model="search_global" @input="filtrarPorTitulo" type="text" class="searchbar"
                                placeholder="Buscar...">
                        </div>

                        <div class="col-12 col-lg-4 text-center">
                            <router-link :to="{ name: 'noticiasadmin.createnoticia' }" >
                                <button class="botonGeneral botonGeneralAdmin">
                                    Nueva
                                Noticia
                                </button></router-link>
                        </div>

                        <div class="col-12 col-lg-4 text-end">
                            <select class="searchcategoria" v-model="categoriaSeleccionada" @change="filtrarNoticias">
                                <option value="">Categorías</option>
                                <option class="estilooption" v-for="categoria in categorias"
                                    :value="categoria.categoria">{{
                                        categoria.categoria }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <tr v-for="(noticia, index) in filteredNoticias" :key="noticia.id"
                            class="card col-12 col-lg-4 text-center"
                            style="background-color: #00000000!important; color: white;">
                            <td class="text-center pNoticias1">{{ noticia.id }}</td>
                            <td class="">
                                <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia"
                                    class="imgNoticias">
                            </td>
                            <td>
                                <p class="pNoticias2">{{ noticia.titulo }}</p>
                            </td>
                            <td>
                                <p class="pNoticias3">{{ noticia.subtitulo }}</p>
                            </td>
                            <td>
                                <p class="pNoticias4">{{ noticia.publicado }}</p>
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
import { ref, onMounted, inject, computed } from "vue"
import { useRouter } from 'vue-router';

const noticias = ref();
const swal = inject('$swal');
const comentariosPorNoticia = ref({});
const router = useRouter();
const categorias = ref([]);
const categoriaSeleccionada = ref('');
const search_global = ref('')
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

onMounted(() => {
    // Obtener todas las categorías
    axios.get('/api/categorias')
        .then(response => {
            categorias.value = response.data;
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

const filtrarNoticias = () => {
    if (categoriaSeleccionada.value === '') {
        // Si no se selecciona ninguna categoría, obtener todas las noticias
        axios.get('/api/noticias')
            .then(response => {
                noticias.value = response.data;
            });
    } else {
        // Si se selecciona una categoría, filtrar las noticias por esa categoría
        axios.get(`/api/noticias/filtrar/${categoriaSeleccionada.value}`)
            .then(response => {
                noticias.value = response.data;
            });
    }
};

const filteredNoticias = computed(() => {
    if (!search_global.value) {
        return noticias.value;
    } else {
        return noticias.value.filter(noticia =>
            noticia.titulo.toLowerCase().includes(search_global.value.toLowerCase())
        );
    }
});

const filtrarPorTitulo = () => {
    // Esta función se activa cada vez que cambia el contenido del campo de búsqueda
    // Filtra las noticias por título utilizando el término de búsqueda
    if (categoriaSeleccionada.value === '') {
        filteredNoticias.value = noticias.value.filter(noticia =>
            noticia.titulo.toLowerCase().includes(search_global.value.toLowerCase())
        );
    } else {
        axios.get(`/api/noticias/filtrar/${categoriaSeleccionada.value}`)
            .then(response => {
                filteredNoticias.value = response.data.filter(noticia =>
                    noticia.titulo.toLowerCase().includes(search_global.value.toLowerCase())
                );
            });
    }
};
</script>

<style>
@media (max-width: 600px) {
    .centrarfiltros {
        display: inline-flex;
        justify-content: center !important;
        align-items: center !important;
    }

    .searchcategoria {
        height: 55px;
        width: 100% !important;
        font-size: 15px !important;
        margin-top: 20px;
    }

    .searchbar {
        height: 55px;
        width: 100% !important;
        font-size: 15px !important;
        margin-bottom: 20px;
    }

    .botonGeneralAdmin {
        height: 55px !important;
        width: 230px !important;
        /* font-size: 12px; */
        font-weight: bold !important;

    }
}
</style>