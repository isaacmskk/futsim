<template>

    <div class=" layout-wrapper margenlateral">
        <div class="grid girdHome row">
            <div class="col-12">
                <div id="carouselExampleInterval" class="carousel slide carruselHome" data-bs-ride="carousel">
                    <div class="carousel-inner carruselHome">
                        <div class="carousel-item active" data-bs-interval="10000">
                            <img src="../../../../public/images/carrusel2.jpg" class="d-block w-100" alt="...">
                            <h1>hola</h1>
                            
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
        <div class="grid girdHome">
            <div class="row">
                <!-- <div > -->
                <div class="col-12 col-lg-3">
                    <div class="card cardFondo">
                        <div class="card-body">
                            <h1>hola</h1>
                        </div>
                    </div>

                </div>
                <div class=" col-12 col-lg-9">
                    <div class="card cardFondo">
                        <div class="card-body">
                            <h1>hola</h1>
                        </div>
                    </div>

                </div>
                <!-- </div> -->

            </div>
        </div>
        <div class="grid girdHome">
            <div class="row">
                <div class="col-12 col-lg-9 ">
                    <div class="card cardFondo">
                        <div class="card-body">
                            <h1>hola</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3 ">
                    <div class="card cardFondo">
                        <div class="card-body">
                            <h1>hola</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid girdHome row">
            <div class="col-12">
                <div class="card cardFondo">
                    <div class="card-body">
                        <p>hola</p>
                    </div>
                </div>
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


.carruselHome {
    border-radius: 12px;
    max-height: 435px;
}

/* Agregamos un estilo para crear un espacio entre .col-9 y .col-3 */
</style>
