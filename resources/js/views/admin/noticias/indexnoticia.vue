<template>
    <div class="row">
        <div class="grid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2 mb-2">
                            <h5 class="card-title text-light">Todas las noticias</h5>
                        </div>
                        <tbody class="row">
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
onMounted(() => {
    axios.get('/api/noticias')
        .then(response => {
            noticias.value = response.data; // Asignar la noticia individual
        });
});

const detallenoticia = (idNoticia) => {
    // Use router.push to navigate to the individual news page
    console.log(idNoticia);
    router.push({ name: 'noticias.indexnoticiaindividual', params: { id: idNoticia } });
}

</script>

<style></style>
