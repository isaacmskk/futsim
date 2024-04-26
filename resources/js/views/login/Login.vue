<template>
    <div class="layout-wrapper margenlateral">
        <div class="row justify-content-center my-5 girdHome">
            <div class="col-md-6">
                <div class="card cardFondo border-0 shadow-sm">
                    <h2>Iniciar Sesión</h2>
                    <div class="card-body">
                        <form @submit.prevent="submitLogin">
                            <div class="">
                                <!-- Email -->
                                <div class="mb-3">
                                    <h4 for="email" class="form-label">{{ $t('email') }}</h4>
                                    <input v-model="loginForm.email" id="email" type="email" class="form-control"
                                        required autofocus autocomplete="username">
                                    <!-- Validation Errors -->
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.email">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="mb-4">
                                    <h4 for="password" class="form-label">
                                        {{ $t('password') }}
                                    </h4>
                                    <input v-model="loginForm.password" id="password" type="password"
                                        class="form-control" required autocomplete="current-password">
                                    <!-- Validation Errors -->
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Remember me -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        v-model="loginForm.remember" id="flexCheckIndeterminate">
                                    <h4 class="form-check-label" for="flexCheckIndeterminate">
                                        {{ $t('remember_me') }}
                                    </h4>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-center justify-end mt-4 mb-4" >
                                    <button class="botonGeneral">
                                        {{ $t('login') }}
                                    </button>
                                    <router-link to="/register" style="margin-left: 20px;">
                                        <button class="botonGeneral mButton">
                                            Registrate
                                        </button>
                                    </router-link>
                                </div>
                            </div>
                            <!-- <router-link :to="{ name: 'auth.forgot-password' }" style="color:white;">{{
                                $t('forgot_password')}}</router-link> -->

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import useAuth from '@/composables/auth'

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

</script>
<style>
@media only screen and (max-width: 600px) {
    .botonGeneral {
        height: 45px;
        width: 150px !important;
        font-size: 12px;
        font-weight: bold;
        /* margin-left: 20px; */
    }
}
</style>
