
<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<script setup>
import { ref } from 'vue';
import AppMenuItem from './AppMenuItem.vue';
import {useAbility} from '@casl/vue'
const {can} = useAbility();

const vela = "pepe";


const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/admin', permision: 'all'}]
    },
    {
        label: 'Jugar',
        items: [
            { label: 'Jugadores', icon: 'pi pi-fw pi-user-plus', to: '/admin/jugadores', permision: 'all' },
            { label: 'Plantillas', icon: 'pi pi-fw pi-check-square', to: '/admin/roles', permision:'all' },
            { label: 'Partidos', icon: 'pi pi-fw pi-bookmark', to: '/admin/permissions', permision:'all' }
        ]
    },
    //,
    // {
    //     label: 'Ejercicios',
    //     items: [
    //         { label: 'Ejercicios', icon: 'pi pi-fw pi-id-card', to: '/admin/exercises', permision: 'all' },
    //         { label: 'Categorias', icon: 'pi pi-fw pi-id-card', to: '/admin/categories', permision: 'all' }
    //     ]
    // },
    {
        label: 'Noticias',
        items: [
            { label: 'Noticias', icon: 'pi pi-fw pi-megaphone', to: '/admin/futsimvistas/noticias', permision: 'all' }
        ]
    },
    {
        label: 'Panel Usuario',
        items: [
            { label: 'Modificar Jugadores', icon: 'pi pi-fw pi-user-plus', to: '/admin/jugadoresadmin/jugadores', permision: 'user-list' },
            { label: 'Modificar Noticias', icon: 'pi pi-fw pi-check-square', to: '/admin/roles', permision:'role-list' },
            { label: 'Personal', icon: 'pi pi-fw pi-bookmark', to: '/admin/permissions', permision:'all' }
        ]
    },
]);
</script>


<style lang="scss" scoped></style>
