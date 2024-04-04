
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
        label: 'Jugar',
        items: [
            { label: 'Jugadores', icon: 'pi pi-fw pi-users pi-Lateral', to: '/admin/jugadores', permision: 'all' },
            { label: 'Plantillas', icon: 'pi pi-fw pi-sitemap pi-Lateral', to: '/admin/plantillas/misplantillas', permision:'all' },
            { label: 'Partidos', icon: 'pi pi-fw pi-bolt pi-Lateral', to: '/admin/plantillas', permision:'all' }
        ]
    },
    {
        label: 'Ranking',
        items: [{ label: 'Ranking', icon: 'pi pi-fw pi-star pi-Lateral', to: '/admin/ranking', permision: 'all'}]
    },
    {
        label: 'Noticias',
        items: [
            { label: 'Noticias', icon: 'pi pi-fw pi-id-card pi-Lateral', to: '/admin/noticias', permision:'all'  }
        ]
    },
    {
        label: 'Panel Usuario',
        items: [
            { label: 'Crear Jugadores', icon: 'pi pi-fw pi-user-plus pi-Lateral', to: '/admin/jugadoresadmin/jugadores', permision: 'user-list' },
            { label: 'Crear Noticias', icon: 'pi pi-fw pi-megaphone pi-Lateral', to: '/admin/futsimvistas/noticias', permision: 'role-list'},
            { label: 'Personal', icon: 'pi pi-fw pi-cog pi-Lateral', to: '/admin/permissions', permision:'all' }
        ]
    },
]);
</script>


<style lang="scss" scoped></style>
