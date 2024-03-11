<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todos los jugadores</h5>
                        <div>
                        </div>
                    </div>

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Posicion</th>
                                <th>Nacionalidad</th>
                                <th>Valoracion</th>
                                <th>Carta</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(jugador, index) in jugadores">
                                <td class="text-center">{{ jugador.id }}</td>
                                <td>{{ jugador.nombre }}</td>
                                <td>{{ jugador.apellido }}</td>
                                <td>{{ jugador.posicion }}</td>
                                <td>{{ jugador.nacionalidad }}</td>
                                <td>{{ jugador.valoracion }}</td>
                                <td>            
                                    <img :src="`${jugador.media[0]?.original_url}`" alt="Imagen Jugador" class="image-table">
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
const jugadores = ref();
const swal = inject('$swal');


onMounted(() => {
    // console.log('Mi vista esta montada'); 
    axios.get('/api/jugadores')
        .then(response => {
            jugadores.value = response.data;
            console.log(response.data);
        })
});

const deleteJugador = (id, index) => {
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
            axios.delete('/api/jugadores/' + id)
                .then(response => {
                    jugadores.value.splice(index, 1)
                    swal({
                        icon: 'success',
                        title: 'Jugador eliminado correctamente'
                    })

                }).catch(error => {
                    swal({
                        icon: 'error',
                        title: 'No se ha podido eliminar el jugador'
                    })

                });

        })
}

const updateJugador = (id, index) => {

const currentData = jugadores.value[index];

swal({
    title: 'Editar publicación',
    html:
        '<input id="swal-input1" class="swal2-input" placeholder="" value="' + currentData.id + '">' +
        '<input id="swal-input2" class="swal2-input" placeholder="" value="' + currentData.nombre + '">' +
        '<input id="swal-input3" class="swal2-input" placeholder="" value="' + currentData.apellido + '">' +
        '<input id="swal-input4" class="swal2-input" placeholder="" value="' + currentData.posicion + '">' +
        '<input id="swal-input5" class="swal2-input" placeholder="" value="' + currentData.nacionalidad + '">' +
        '<input id="swal-input6" class="swal2-input" placeholder="" value="' + currentData.valoracion + '">' +
        '<input id="swal-input7" class="swal2-input" placeholder="" value="' + currentData.carta + '">',

    focusConfirm: false,
    preConfirm: () => {
        return [
            document.getElementById('swal-input1').value,
            document.getElementById('swal-input2').value,
            document.getElementById('swal-input3').value,
            document.getElementById('swal-input4').value,
            document.getElementById('swal-input5').value,
            document.getElementById('swal-input6').value,
            document.getElementById('swal-input7').value


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
                    title: 'Jugador actualizado correctamente'
                });
            }).catch(error => {
                swal({
                    icon: 'error',
                    title: 'No se ha podido actualizar el jugador'
                });
            });
    }
});
};

</script>


<style></style>
