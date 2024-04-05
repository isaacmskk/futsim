<template>
  <div class="grid nogutter">
    <div class="card cardFondo">
      <div v-for="(noticia, index) in noticias" :key="noticia.id" class="row">
        <div class="col-12 col-lg-6">
          <div class="noticia-header">
            <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia" class="img-fluid">
            <p class="text-secondary">{{ new Date(noticia.publicado).toLocaleString() }}</p>
            <h2>{{ noticia.titulo }}</h2>
            <h4>{{ noticia.subtitulo }}</h4>
            <p class="noticia-content">{{ noticia.contenido }}</p>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <button @click="mostrarFormularioComentario(noticia.id)" class="botoncomentar">Comentar</button>
          <div v-if="comentariosPorNoticia[noticia.id]" class="p-mt-2 comentarios-container">
            <div v-for="(comentario, index) in comentariosPorNoticia[noticia.id]" :key="comentario.id"
              class="chat-message">
              <div class="chat-message-text">{{ comentario.comentario }}</div>
              <div class="chat-message-time">{{comentario.user.name}} - {{ new Date(comentario.time).toLocaleString() }}</div>
            </div>

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
  axios.get('/api/noticias/' + route.params.id)
    .then(response => {
      noticias.value = response.data;
    })
    .catch(error => {
      console.error('Error fetching news data:', error);
    });

  axios.get('/api/comentarios')
    .then(response => {
      comentariosPorNoticia.value = groupComentariosPorNoticia(response.data);
    });
});

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
    html: '<input id="swal-comentario" class="swal2-input" placeholder="Comentario">',
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
      if (!comentariosPorNoticia.value[nuevoComentario.id_noticia]) {
        comentariosPorNoticia.value[nuevoComentario.id_noticia] = [];
      }

      comentariosPorNoticia.value[nuevoComentario.id_noticia].push(response.data.data);
      swal({
        icon: 'success',
        title: 'Comentado correctamente'
      });
    })
    .catch(error => {
      swal({
        icon: 'error',
        title: 'No se ha podido agregar el comentario'
      });
    });
};
</script>

<style scoped>
* {
  font-family: Tahoma !important;

}

.img-fluid {
  max-width: 100%;
  height: auto;
}

.noticia-content {
  color: white;
}

.noticia-container {
  margin-bottom: 20px;
}

.noticia-header h2 {
  color: white;
  margin: 0;
  font-size: 25px;
  font-weight: bold;
  margin-top: 10px;
  margin-bottom: 20px;
}

.noticia-header h4 {
  color: white;
  margin: 0;
  font-size: 18px;
  font-weight: 600;
  margin-top: 10px;
  margin-bottom: 20px;
}

.smaller-image {
  max-width: 100px;
  height: auto;
}

.chat-message {
  margin-bottom: 10px;
}

.chat-message-text {
  background-color: #cacaca;
  padding: 10px;
  border-radius: 5px;
  overflow-wrap: break-word;
  /* Cambia a overflow-wrap */

}

.chat-message-time {
  color: #f0f0f07b;
  font-size: 12px;
}
</style>
