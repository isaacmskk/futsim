<template>
  <div class="grid nogutter">
    <div class="card cardFondo">
      <div v-for="(noticia, index) in noticias" :key="noticia.id" class="row">
        <div class="col-12 col-lg-6">
          <div class="noticia-header">
            <img :src="`${noticia.media[0]?.original_url}`" alt="Imagen Noticia" class="img-fluid">
            <p class="text-secondary">{{ new Date(noticia.publicado).toLocaleString() }}</p>
            <h3>{{ noticia.titulo }}</h3>
            <h4>{{ noticia.subtitulo }}</h4>
            <p class="noticia-content">{{ noticia.contenido }}</p>

          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="text-center">
            <button @click="mostrarFormularioComentario(noticia.id)" class="botonGeneral"
              style="margin-bottom: 15px!important;">Comentar</button>
          </div>
          <div v-if="comentariosPorNoticia[noticia.id]" class="p-mt-2 comentarios-container">
            <div v-for="(comentario, index) in comentariosPorNoticia[noticia.id]" :key="comentario.id"
              class="chat-message">
              <p class="chat-message-text">{{ comentario.comentario }}</p>
              <p class="chat-message-time">{{ comentario.user.name }} - {{ new Date(comentario.time).toLocaleString() }}
              </p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<!--
Se utiliza onMounted para cargar la noticia y los comentarios relacionados desde una API cuando el componente se monta.
Se define una función groupComentariosPorNoticia para agrupar los comentarios por el ID de la noticia a la que pertenecen.
Se define una función mostrarFormularioComentario que muestra un diálogo para agregar un comentario cuando se hace clic en el botón "Comentar".
Se define una función crearComentario para enviar un nuevo comentario a la API y actualizar la lista de comentarios localmente. -->
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
    html: '<textarea id="swal-comentario" class="swal2-textarea" style = "width: 295px" maxlength="255">',
    focusConfirm: false,
    allowOutsideClick: false,
    preConfirm: () => {
      return {
        comentario: document.getElementById('swal-comentario').value
      };
    },
    customClass: {
      popup: 'my-custom-popup-class',
    },
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

      // Recargar los comentarios de la API para reflejar los cambios
      axios.get('/api/comentarios')
        .then(response => {
          comentariosPorNoticia.value = groupComentariosPorNoticia(response.data);
        });
      swal({
        icon: 'success',
        title: 'Comentado correctamente',
        allowOutsideClick: false,
        customClass: {
          popup: 'my-custom-success-popup-class',
          title: 'my-custom-success-title-class',
          content: 'my-custom-success-content-class',

        }
      });
    })
    .catch(error => {
      swal({
        icon: 'error',
        title: 'No se ha podido agregar el comentario',
        allowOutsideClick: false,
        customClass: {
          popup: 'my-custom-error-popup-class',
          title: 'my-custom-error-title-class',
          content: 'my-custom-error-content-class',
        }
      });
    });
};

</script>

<style scoped></style>
