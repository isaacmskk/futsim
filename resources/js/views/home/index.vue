<template>

    <div class=" layout-wrapper margenlateral">
        <div class="grid girdHome row paddingDivs">
            <div class="col-12">
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
        <div class="grid paddingDivs">
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
        <div class="grid paddingDivs">
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
                <div class="col-12 col-lg-3 marginPequeño ">
                    <router-link :to="{ name: 'ranking.indexranking' }"
                        class="p-link layout-topbar-button layout-topbar-button-c nav-item dropdown " role="button">
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
        <div class="grid  row paddingDivs" >
            <div class="col-12"style="margin-bottom: 30px;">
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
                                    
                                    <h3 class="h3HomeSecciones">El Barça se prepara </h3>
                                    <h4 class="h4HomeSecciones">El FCB se prepara para jugar contra su proximo rival en Champions, un PSG que viene espectacular con Mbappe!</h4>
                                    <p class="pHomeSecciones">El FCB se prepara para jugar contra su proximo rival en Champions, un PSG que viene espectacular con Mbappe!El FCB se prepara para jugar contra su proximo rival en Champions, un PSG que viene espectacular con Mbappe!El FCB se prepara para jugar contra su proximo rival en Champions, un PSG que viene espectacular con Mbappe!El FCB se prepara para jugar contra su proximo rival en Champions, un PSG que viene espectacular con Mbappe!</p>
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
.margenlateral {
    padding-left: 175px;
    padding-right: 175px;
}

.girdHome {
    padding-top: 90px;
}

.paddingDivs{
    padding-bottom: 30px;
}


.carruselHome {
    border-radius: 12px;
    max-height: 435px;
}

.cardHomes {
    padding-left: 0rem !important;
    padding-right: 0rem !important;
    padding-bottom: 0rem !important;
    padding-top: 0rem !important;
}


.divExplicacionHome {
    background-color: #cacaca53;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;

}


.h2HomeSecciones {
    padding-top: 15px;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 1px;
    margin: 0px !important;
}

.h3HomeSecciones {
    padding-top: 15px;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 1px;
    margin: 0px !important;
}

.h4HomeSecciones {
    padding-top: 15px;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 40px;
    margin: 0px !important;
}

.pHomeSecciones {
    padding: 15px;
    color: white;
}

.iconosHome {
    font-size: 12rem !important;
    color: white;
    padding: 20px;
}

.imgSecc2 {
    background-image: url(../images/Plantillas.jpg);
    min-height: 262.4px;
    background-repeat: no-repeat;
    background-size: 100% auto !important;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;

}

.imgSecc3 {
    background-image: url(../images/Jugar.png);
    min-height: 262.4px;
    background-repeat: no-repeat;
    background-size: 100% auto !important;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    background-position: bottom;
}


.noticiaHome{
    background-image: url(../images/Jugar.png);
    min-height: 100%;
    background-repeat: no-repeat;
    background-size: 100% auto !important;
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
    background-position: bottom;
}

.paddingsNoticia{
    padding-top:0px!important; 
    padding-bottom: 0px!important; 
    padding-left:11px;
}


@media only screen and (max-width: 600px) {
    .margenlateral {
    padding-left: 30px;
    padding-right: 30px;
}

.carruselHome {
    border-radius: 12px;
    max-height: 150px;
}

.paddingBottom{
    padding-bottom: 30px;

}

.marginPequeño{
    padding-left: 80px;
    padding-right: 80px;
}

.marginGrande{
    padding-left: 15px;
    padding-right: 15px;
}

.iconosHome {
    font-size: 7rem !important;
}

.imgSecc2 {
    min-height: 100px;

}

.imgSecc3 {
    min-height: 100px;
}

.noticiaHome{
    min-height: 100px;
    border-bottom-left-radius: 0px;
    border-top-right-radius: 12px;
}

.paddingsNoticia{
    padding-top:0px!important; 
    padding-bottom: 0px!important; 
    padding-left:11px;
    padding-right:10px;
}
}
/* Agregamos un estilo para crear un espacio entre .col-9 y .col-3 */
</style>
