<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las tareas</h5>
                        <div>
                            <router-link :to="{ name: 'tasks.create' }" class="btn btn-success">Nueva Tarea</router-link>
                        </div>
                    </div>

                    {{ tasks }}

                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Name</th>
                                <th>description</th>
                                <th>date_open</th>
                                <th>date_close</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(task, index) in tasks">
                                <td class="text-center">{{ task.id }}</td>
                                <td>{{ task.name }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ task.date_open }}</td>
                                <th>{{ task.date_close }}</th>
                                <td class="text-center">
                                    <router-link :to="{ name: 'tasks.update' }" class="btn btn-success">Updatear Tarea</router-link>
                                    <button class="btn btn-danger" @click="deleteTask(task.id, index)">Delete</button>
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
const tasks = ref();
const swal = inject('$swal');


onMounted(() => {
    // console.log('Mi vista esta montada'); 
    axios.get('/api/tasks')
        .then(response => {
            tasks.value = response.data;
            console.log(response.data);
        })
});


const deleteTask = (id, index) => {
    swal({
        title: 'Quieres eliminar la tarea?',
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
            axios.delete('/api/tasks/' + id)
                .then(response => {
                    tasks.value.splice(index, 1)
                    swal({
                        icon: 'success',
                        title: 'Tarea eliminada correctamente'
                    })

                }).catch(error => {
                    swal({
                        icon: 'error',
                        title: 'No se ha podido eliminar la tarea'
                    })

                });

        })




}
</script>


<style></style>
