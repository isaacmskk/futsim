<template>
    <h2>Noticias</h2>
    <div class="grid">
        <div class="col-12">
            <div class="card cardFondo">
                <div class="card-body">
                    <div class="row col-12 centrarfiltros">
                        <div class="col-12 col-lg-6 text-center">
                            <input v-model="search_global" @input="filtrarPorTitulo" type="text" class="searchbar"
                                placeholder="Buscar...">
                        </div>
                        <div class="col-12 col-lg-6 text-center">
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
                            class="col-12 col-lg-4 text-center">
                            <div>
                                <button @click="detallenoticia(noticia.id)" class="button">
                                    <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia"
                                        class="imgNoticias" style="margin-top: 20px;">
                                    <h3>{{ noticia.titulo }}</h3>
                                </button>
                            </div>
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
const router = useRouter();
const categorias = ref([]);
const categoriaSeleccionada = ref('');
const search_global = ref('')

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
::placeholder {
    color: #18181b;
  }
  </style>