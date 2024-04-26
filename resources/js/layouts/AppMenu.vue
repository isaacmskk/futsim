
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
            { label: 'Jugadores', icon: 'pi pi-fw pi-users pi-Lateral', to: '/app/jugadores', permision: 'all' },
            { label: 'Plantillas', icon: 'pi pi-fw pi-sitemap pi-Lateral', to: '/app/plantillas/misplantillas', permision:'all' },
            { label: 'Partidos', icon: 'pi pi-fw pi-bolt pi-Lateral', to: '/app/plantillas', permision:'all' }
        ]
    },
    {
        label: 'Ranking',
        items: [{ label: 'Ranking', icon: 'pi pi-fw pi-trophy pi-Lateral', to: '/app/ranking', permision: 'all'}]
    },
    {
        label: 'Noticias',
        items: [
            { label: 'Noticias', icon: 'pi pi-fw pi-id-card pi-Lateral', to: '/app/noticias', permision:'all'  }
        ]
    },
    {
        label: 'Panel Usuario',
        items: [
            { label: 'Crear Jugadores', icon: 'pi pi-fw pi-user-plus pi-Lateral', to: '/app/jugadoresadmin/jugadores', permision: 'user-list' },
            { label: 'Crear Noticias', icon: 'pi pi-fw pi-megaphone pi-Lateral', to: '/app/noticiasadmin/noticias', permision: 'role-list'},
            { label: 'Perfil', icon: 'pi pi-fw pi-cog pi-Lateral', to: '/app/user', permision:'all' }
        ]
    },
]);
</script>


<style lang="scss" scoped></style>
