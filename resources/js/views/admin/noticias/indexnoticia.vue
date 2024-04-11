<template>
                                <h2>Todas las noticias</h2>

    <div class="row">
        <div class="grid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <tbody class="row">
                            <select v-model="categoriaSeleccionada" @change="filtrarNoticias">
                                <option value="">Todas las categorías</option>
                                <option v-for="categoria in categorias" :value="categoria.categoria">{{
                                categoria.categoria }}</option>
                            </select>
                            <tr v-for="(noticia, index) in noticias" :key="noticia.id"
                                class="card col-12 col-lg-4 text-center">
                                <button @click="detallenoticia(noticia.id)" class="button">
                                    <td>
                                        <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia"
                                            class="imgNoticias">
                                    </td>
                                    <h3>{{ noticia.titulo }}</h3>
                                </button>
                            </tr>
                        </tbody>
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
const router = useRouter();
const categorias = ref([]);
const categoriaSeleccionada = ref('');

onMounted(() => {
    axios.get('/api/noticias')
        .then(response => {
            noticias.value = response.data; // Asignar la noticia individual
        });
});

onMounted(() => {
    // Obtener todas las categorías
    axios.get('/api/categorias')
        .then(response => {
            categorias.value = response.data;
        });
});
const detallenoticia = (idNoticia) => {
    // Use router.push to navigate to the individual news page
    console.log(idNoticia);
    router.push({ name: 'noticias.indexnoticiaindividual', params: { id: idNoticia } });
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

</script>

<style></style>
