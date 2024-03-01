<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Update un nuevo jugador</h5>
            </div>


            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strSuccess }}</strong>
            </div>


            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ strError }}</strong>
            </div>


            <form @submit.prevent="saveJugador">


                <div class="form-group mb-2">
                    <label>Posicion</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="jugador.posicion" placeholder="Posicion Jugador">
                    <div class="text-danger mt-1">
                        {{ errors.posicion }}
                    </div>
                </div>


                <div class="form-group mb-2">
                    <label>Descripción</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="jugador.descripcion" placeholder="Descripción"></textarea>
                </div>


                <div class="form-gorup mb-2">
                    <label>Nacionalidad</label><span class="text-danger">*</span>
                    <input class="form-control" type="datetime-local" v-model="jugador.nacionalidad" name="nacionalidad" />
                </div>
       
                <div class="form-gorup mb-2">
                    <label>Valoracion</label><span class="text-danger">*</span>
                    <input class="form-control" type="datetime-local" v-model="jugador.valoracion" name="valoracion" />
                </div>

                <div class="form-group mb-2">
                    <label>Carta</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="jugador.carta" placeholder="Carta"></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Modificar Jugador</button>


            </form>


        </div>
    </div>
</template>


<script setup>
import { ref, onMounted, reactive } from "vue";
import { useForm, useField} from "vee-validate";
import { useRoute } from "vue-router";
import * as yup from 'yup';
import { es } from 'yup-locales';
import { setLocale } from 'yup';


const schema =  yup.object({
    name: yup.string().required().label('nombre'),
})


const { validate, errors } = useForm({ validationSchema: schema })
const route = useRoute()


setLocale(es);




const { value: posicion } = useField('posicion', null, { initialValue: '' });
const { value: nacionalidad } = useField('nacionalidad', null, { initialValue: '' });
const { value: valoracion } = useField('valoracion', null, { initialValue: '' });
const { value: carta } = useField('carta', null, { initialValue: '' });


const jugador = reactive({
    posicion,
    nacionalidad,
    valoracion,
    carta
})


const strSuccess = ref();
const strError = ref();


onMounted(() => {
    axios.get('/api/jugadores/' + route.params.id)
    .then(response => {
        jugador.posicion = response.data.posicion;
        jugador.nacionalidad = response.data.nacionalidad;
        jugador.valoracion = response.data.valoracion;
        jugador.carta = response.data.carta;
    })
    .catch(function(error) {
        console.log(error);
    });
})


function saveJugador() {
    validate().then(form => { if (form.valid) JugadorUpdate(jugadores) })
    }
        console.log('validate');
        if (form.valid){
            axios.post('/api/jugadores/update/'+route.params.id, jugador)
            .then(response => {
                strError.value = ""
                strSuccess.value = response.data.success
            })
            .catch(function (error) {
                strSuccess.value = ""
                strError.value = error.response.data.message
            });
        }



</script>


<style>
</style>
