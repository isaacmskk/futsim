<template>
    <div class="layout-topbar margenNavEscondido">
        

        <button class="p-link layout-menu-button layout-topbar-button itemIconos" @click="onMenuToggle()">
            <i class="pi pi-list"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>

        <router-link to="/" class="layout-topbar-logo layout-topbar-logo-responsive">
            <img src="/images/FUTSIM.SVG" alt="logo" class="logo" />
            <button class="button" data-text="Awesome">
                <span class="actual-text">&nbsp;FUTSIM&nbsp;</span>
                <span aria-hidden="true" class="hover-text">&nbsp;FUTSIM&nbsp;</span>
            </button>
        </router-link>
        <div class="layout-topbar-menu" :class="topbarMenuClasses">
            <template v-if="!user?.name">
                <li>
                    <router-link class="nav-link" to="/login">{{ $t('login') }}</router-link>
                </li>
                <li>
                    <router-link class="nav-link" to="/register">{{ $t('register') }}</router-link>
                </li>
            </template>
        </div>

        <div class="layout-topbar-menu" :class="topbarMenuClasses">

            <button class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button"
                data-bs-toggle="dropdown">

                <i class="pi pi-angle-down"></i>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="padding: 0px!important;">
                    <li>
                        <router-link :to="{ name: 'user.editaruser' }" class="dropdown-item">Perfil</router-link>
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
