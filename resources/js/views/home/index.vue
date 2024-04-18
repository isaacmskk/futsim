<template>
    <div class=" layout-wrapper margenlateral">
        <div class="layout-wrapper-ancho grid girdHome paddingDivs">
            <div class="col-12 ">
                <div id="carouselExampleInterval" class="carousel slide carruselHome" data-bs-ride="carousel">
                    <div class="carousel-inner carruselHome">
                        <div class="carousel-item active" data-bs-interval="10000">
                            <img src="../../../../public/images/carrusel2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="10000">
                            <img src="../../../../public/images/carrusel3.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../../../../public/images/carrusel1.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                        data-bs-slide="prev">
                        <!-- <span class="carousel-control-prev-icon" aria-hidden="true"></span> -->
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                        data-bs-slide="next">
                        <!-- <span class="carousel-control-next-icon" aria-hidden="true"></span> -->
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="layout-wrapper-ancho grid paddingDivs">
            <div class="row ">
                <div class="col-12 col-lg-3 marginPequeño paddingBottom">
                    <router-link :to="{ name: 'jugadores.indexjugador' }"
                        class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button">
                        <div class="card cardFondoPequeño cardHomes">
                            <div class="card-body cardHomes">
                                <div>
                                    <h2 class="h2HomeSecciones">Jugadores</h2>
                                </div>
                                <div class="text-center"><i class="pi pi-fw pi-users iconosHome"></i></div>
                                <div class="divExplicacionHome">
                                    <p class="pHomeSecciones">Crea tu plantilla con tus jugadores!</p>
                                </div>

                            </div>
                        </div>
                    </router-link>
                </div>
                <div class=" col-12 col-lg-9 ">
                    <router-link :to="{ name: 'plantillas.detalleplantillas' }"
                        class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button">
                        <div class="card cardFondo cardHomes">
                            <div class="card-body cardHomes">
                                <div class="imgSecc2">
                                    <h2 class="h2HomeSecciones">Mis Plantillas</h2>
                                </div>
                                <div class="divExplicacionHome">
                                    <p class="pHomeSecciones">Crea tu plantilla con tus jugadores!</p>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
                <!-- </div> -->

            </div>
        </div>
        <div class="layout-wrapper-ancho grid paddingDivs">
            <div class="row">
                <div class="col-12 col-lg-9 paddingBottom">
                    <router-link :to="{ name: 'plantillas.indexplantillas' }"
                        class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button">
                        <div class="card cardFondo cardHomes">
                            <div class="card-body cardHomes">
                                <div class="imgSecc3">
                                    <h2 class="h2HomeSecciones">Jugar</h2>
                                </div>
                                <div class="divExplicacionHome">
                                    <p class="pHomeSecciones">Quieres probarte? Juega ya contra rivales o contra tus
                                        propios
                                        amigos.</p>
                                </div>
                            </div>
                        </div>
                    </router-link>

                </div>
                <div class="col-12 col-lg-3 marginPequeño">
                    <router-link :to="{ name: 'ranking.indexranking' }"
                        class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown" role="button">
                        <div class="card cardFondoPequeño cardHomes">
                            <div class="card-body cardHomes">
                                <div>
                                    <h2 class="h2HomeSecciones">Ranking</h2>
                                </div>
                                <div class="text-center"><i class="pi pi-fw pi-trophy iconosHome"></i></div>
                                <div class="divExplicacionHome">
                                    <p class="pHomeSecciones">Crea tu plantilla con tus jugadores!</p>
                                </div>

                            </div>
                        </div>
                    </router-link>

                </div>
            </div>
        </div>
        <div class="layout-wrapper-ancho grid  paddingDivs" >
            <div class="col-12" style="margin-bottom: 30px;">
                <router-link :to="{ name: 'noticias.indexnoticia' }"
                    class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button">
                    <div class="card cardFondo" style="padding:0px!important">
                        <div class="card-body row paddingsNoticia">
                            <div class="col-12 col-lg-6" style="padding:0px!important">
                                <div class="noticiaHome">
                                    <h2 class="h2HomeSecciones">Noticias Última Hora</h2>

                                </div>
                            </div>
                            <div class="col-12 col-lg-6" style="padding:0px!important">
                                <div>
                                    
                                    <h3 class="h3HomeSecciones">Cubarsí, titular por aplastamiento</h3>
                                    <h4 class="h4HomeSecciones">El central cada vez está más afianzado en el centro de la defensa del Barcelona</h4>
                                    <p class="pHomeSecciones">Han pasado prácticamente tres meses desde el debut de Pau Cubarsí con el Barcelona. Fue en un partido de Copa ante Unionistas. Pocos conocían entonces a este chaval de la cantera azulgrana, ahora ya todos saben su nombre. Porque Cubarsí ha llegado para quedarse. Se ha hecho con un hueco en el once titular y ha debutado con la selección española. Un ascenso meteórico. Nadie le ha regalado nada...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </router-link>

            </div>
        </div>
    </div>
</template>

<script setup>
</script>

<style scoped>
</style>
