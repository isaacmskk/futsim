<template>
    <div class="layout-topbar" >
        <router-link to="/" class="layout-topbar-logo">
            <img src="/images/FUTSIM.svg" alt="logo" class="logo" />
            <button class="button" data-text="Awesome">
                <span class="actual-text">&nbsp;FUTSIM&nbsp;</span>
                <span aria-hidden="true" class="hover-text">&nbsp;FUTSIM&nbsp;</span>
            </button>
        </router-link>
        <router-link :to="{ name: 'futsimvistas.indexnoticia' }"
                class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button">
                <i class="pi pi-megaphone"> </i>
            </router-link>

        <button class="p-link layout-topbar-menu-button layout-topbar-button" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>

        
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



                <i class="pi pi-user"></i>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">

                    <li>
                        <router-link :to="{ name: 'profile.index' }" class="dropdown-item">Perfil</router-link>
                    </li>
                    <li>
                        <a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                            href="javascript:void(0)" @click="logout">Cerrar sessión</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" :class="{ 'opacity-25': processing }" :disabled="processing"
                            href="javascript:void(0)" @click="logout">Cerrar sessión</a>
                    </li>
                </ul>

                <span class="nav-link dropdown-toggle ms-3 me-2" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Hola {{ user.name }}
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
<!-- <script setup>
import { useStore } from "vuex";
import useAuth from "@/composables/auth";
import { computed } from "vue";
import LocaleSwitcher from "../components/LocaleSwitcher.vue";

const store = useStore();
const user = computed(() => store.getters["auth/user"])
const { processing, logout } = useAuth();


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
</style> -->
