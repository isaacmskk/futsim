<template>
    <h2>Jugadores(Admin)</h2>
    <div class="grid">
        <div class="col-12">
            <div class="card cardFondo">
                <div class="card-body">
                    <div class="row">
                        <div class="col-0 col-lg-4">

                        </div>
                        <div class="col-6 col-lg-4 text-center" >
                            <!-- Aplicar la clase text-center al contenedor div -->
                            <router-link :to="{ name: 'jugadoresadmin.createjugador' }">
                                <button class="botonGeneral botonGeneralAdmin">

                                    Nuevo
                                    jugador
                                </button>
                            </router-link>
                        </div>

                        <div class="col-6 col-lg-4 text-end">
                            <button class="itemIconos espacioASCDESC" @click="ordenarPorValoracion('desc')">
                                <i class="pi pi-fw pi-sort-amount-down-alt asc-desc"></i>
                            </button>
                            <button class="itemIconos espacioASCDESC" @click="ordenarPorValoracion('asc')">
                                <i class="pi pi-fw pi-sort-amount-up asc-desc"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <tr v-for="(jugador, index) in jugadores" class="card col-6 col-lg-3 cartJugadores text-center"
                            style="background-color: #00000000!important; color: white;">
                            <td class="text-center pNoticias1">{{ jugador.id }}</td>

                            <td class="p-2">
                                <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="imgJugador">
                            </td>
                            <td>
                                <p class="pNoticias2">{{ jugador.nombre }} {{ jugador.apellido }}</p>
                            </td>
                            <td>
                                <p class="pNoticias4">{{ jugador.posicion }}</p>
                            </td>
                            <td>
                                <p class="pNoticias4">{{ jugador.nacionalidad }}</p>
                            </td>
                            <td>
                                <p class="pNoticias3">{{ jugador.valoracion }}</p>
                            </td>

                            <td class="col-12 col-lg-12">
                                <button class="itemEditar espacioEditar">
                                    <i class="pi pi-fw pi-pencil tamano" @click="updateJugador(jugador.id, index)"></i>
                                </button>
                                <button class="itemEliminar espacioEliminar">
                                    <i class="pi pi-fw pi-trash tamano" @click="deleteJugador(jugador.id, index)"></i>
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
import { ref, onMounted, inject } from "vue"
const jugadores = ref();
const swal = inject('$swal');

const ordenarPorValoracion = (tipo) => {
    // Lógica para ordenar los jugadores por valoración ascendente o descendente
    if (tipo === 'desc') {
        jugadores.value.sort((a, b) => a.valoracion - b.valoracion);
    } else if (tipo === 'asc') {
        jugadores.value.sort((a, b) => b.valoracion - a.valoracion);
    }
};

onMounted(() => {
    axios.get("/api/jugadores").then((response) => {
        jugadores.value = response.data;
        jugadoresFiltrados.value = response.data;
        console.log(response.data);
    });
});
onMounted(() => {
    // console.log('Mi vista esta montada'); 
    axios.get('/api/jugadores')
        .then(response => {
            jugadores.value = response.data;
            console.log(response.data);
        })
});

const deleteJugador = (id, index) => {
    axios.delete('/api/jugadores/' + id)
        .then(response => {
            jugadores.value.splice(index, 1)
            swal({
                icon: 'success',
                title: 'Jugador eliminado correctamente',
                customClass: {
                    popup: 'my-custom-success-popup-class',
                    title: 'my-custom-success-title-class',
                }
            })

        }).catch(error => {
            swal({
                icon: 'error',
                title: 'No se ha podido eliminar el jugador',
                customClass: {
                    popup: 'my-custom-error-popup-class',
                    title: 'my-custom-error-title-class',
                }
            })

        });
}

const updateJugador = (id, index) => {

    const currentData = jugadores.value[index];

    swal({
        title: 'Editar Jugador',
        html:
            '<input id="swal-input1" class="swal2-input" placeholder="" value="' + currentData.id + '" type="hidden">' +
            '<input id="swal-input2" class="swal2-input" placeholder="" value="' + currentData.nombre + '">' +
            '<input id="swal-input3" class="swal2-input" placeholder="" value="' + currentData.apellido + '">' +
            '<input id="swal-input4" class="swal2-input" placeholder="" value="' + currentData.posicion + '">' +
            '<input id="swal-input5" class="swal2-input" placeholder="" value="' + currentData.nacionalidad + '">' +
            '<input id="swal-input6" class="swal2-input" placeholder="" value="' + currentData.valoracion + '">',

        focusConfirm: false,
        customClass: {
            popup: 'my-custom-popup-class',
            confirmButton: '',
            cancelButton: '',
            container: 'my-custom-container-class'
        },
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value,
                document.getElementById('swal-input4').value,
                document.getElementById('swal-input5').value,
                document.getElementById('swal-input6').value,


            ]
        }
    }).then(result => {
        if (result.isConfirmed) {
            const updatedData = {
                id: result.value[0],
                nombre: result.value[1],
                apellido: result.value[2],
                posicion: result.value[3],
                nacionalidad: result.value[4],
                valoracion: result.value[5],
                carta: result.value[6]

            };

            axios.put('/api/jugadores/update/' + id, updatedData)
                .then(response => {
                    jugadores.value.splice(index, 1, updatedData);
                    swal({
                        icon: 'success',
                        title: 'Jugador actualizado correctamente',
                        customClass: {
                            popup: 'my-custom-success-popup-class',
                            title: 'my-custom-success-title-class',
                        }
                    });
                }).catch(error => {
                    swal({
                        icon: 'error',
                        title: 'No se ha podido actualizar el jugador',
                        customClass: {
                            popup: 'my-custom-error-popup-class',
                            title: 'my-custom-error-title-class',
                        }
                    });
                });
        }
    });
};

</script>

<style>
@media only screen and (max-width: 600px) {
    .botonGeneralAdmin {
        height: 55px !important;
        width: 230px !important;
        /* font-size: 12px; */
        font-weight: bold !important;

    }
}
</style>
