<template>
    <div class="layout-topbar margenlateral">
        <router-link to="/" class="layout-topbar-logo">
            <img src="/images/FUTSIM.svg" alt="logo" class="logo" />
            <button class="button" data-text="Awesome">
                <span class="actual-text">&nbsp;FUTSIM&nbsp;</span>
                <span aria-hidden="true" class="hover-text">&nbsp;FUTSIM&nbsp;</span>
            </button>
        </router-link>


        <button class="p-link layout-topbar-menu-button layout-topbar-button itemIconos" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>


        <div class="layout-topbar-menu" :class="topbarMenuClasses">
            <template v-if="!user?.name">

                <router-link to="/login">
                    <button class="Btn">

                        <div class="sign"><svg viewBox="0 0 512 512">
                                <path
                                    d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z">
                                </path>
                            </svg></div>

                        <div class="text">Login</div>
                    </button>



                </router-link>

            </template>
        </div>
        <template v-if="user?.name">
            <div class="layout-topbar-menu" :class="topbarMenuClasses">
                <button class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown" role="button">
                    <i class="pi pi-angle-down"></i>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="padding: 0px!important;">
                        <li>
                            <router-link class="dropdown-item" to="/app/user">Perfil</router-link>
                        </li>
                        <li>
                            <a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                                href="javascript:void(0)" @click="logout">Cerrar sesión</a>
                        </li>
                    </ul>
                    <span class="nombreUsuario ms-2" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ user.name }}
                    </span>
                </button>
            </div>
        </template>



    </div>
</template>
<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { useLayout } from '../composables/layout';
import { useStore } from 'vuex';
import useAuth from "@/composables/auth";

const { onMenuToggle } = useLayout();
const store = useStore();
const user = computed(() => store.state.auth.user)
const { processing, logout } = useAuth();

const topbarMenuActive = ref(false);

const onTopBarMenuButton = () => {
    topbarMenuActive.value = !topbarMenuActive.value;
};

const topbarMenuClasses = computed(() => {
    return {
        'layout-topbar-menu-mobile-active': topbarMenuActive.value
    };
});


</script>

<style lang="scss" scoped>
.layout-topbar-button-c,
.layout-topbar-button-c:hover {
    width: auto;
    background-color: rgb(255, 255, 255, 0);
    border: 0;
    border-radius: 0%;
    padding: 1em;
}
</style>
