<?php
require_once __DIR__ . '/../../php/config.php'; // Defines BASE_URL
include_once __DIR__ . '/../../componentes/header.php';
?>

<!-- HERO -->
<section class="hero text-center text-white bg-dark py-5 mt-3">
    <div class="container text-center">
        <h1 class="h2 fw-bold mb-1">Mis Paseos</h1>
        <p class="mb-0">Listado de paseos habilitados para realizar</p>
    </div>
</section>

<!-- LISTA DE PASEOS -->
<div class="container my-4">
    <div class="row g-4">

        <!-- Paseo 1 -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">Barrio: Palermo</h5>
                            <small class="text-muted">Ruta: Plaza Italia → EcoParque</small>
                        </div>
                        <span class="badge bg-secondary">No iniciado</span>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Fecha:</strong> 12/09/2025</p>
                            <p class="mb-1"><strong>Horario:</strong> 10:00–11:00</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Mascotas:</strong></p>
                            <ul class="mb-0 ps-3">
                                <li>Firulais</li>
                                <li>Luna</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-warning btn-sm">Marcar “En curso”</button>
                        <button class="btn btn-success btn-sm">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paseo 2 -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">Barrio: Caballito</h5>
                            <small class="text-muted">Ruta: Parque Rivadavia</small>
                        </div>
                        <span class="badge bg-warning text-dark">En curso</span>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Fecha:</strong> 12/09/2025</p>
                            <p class="mb-1"><strong>Horario:</strong> 16:00–17:00</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Mascotas:</strong></p>
                            <ul class="mb-0 ps-3">
                                <li>Rocky</li>
                                <li>Mora</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-warning btn-sm disabled">En curso</button>
                        <button class="btn btn-success btn-sm">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paseo 3 -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1">Barrio: Belgrano</h5>
                            <small class="text-muted">Ruta: Barrancas de Belgrano</small>
                        </div>
                        <span class="badge bg-success">Finalizado</span>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>Fecha:</strong> 10/09/2025</p>
                            <p class="mb-1"><strong>Horario:</strong> 09:00–10:00</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-1"><strong>Mascotas:</strong></p>
                            <ul class="mb-0 ps-3">
                                <li>Toby</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-warning btn-sm" disabled>En curso</button>
                        <button class="btn btn-success btn-sm" disabled>Finalizado</button>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- /row -->
</div> <!-- /container -->

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>
