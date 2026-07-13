<?php
require_once __DIR__ . '/../../php/config.php'; // Defines BASE_URL
include_once __DIR__ . '/../../componentes/header.php';
?>

<!-- Overview -->
<div class="container my-4">

    <!-- Titulo -->
    <div>
        <h2 class="text-left mt-4 mb-3">Datos Generales</h2>
    </div>
    <!-- Tarjetas -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total de Clientes</h6>
                    <div class="display-6 fw-bold">3</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total de Paseadores</h6>
                    <div class="display-6 fw-bold">3</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-1">Total de Mascotas</h6>
                    <div class="display-6 fw-bold">6</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tarjetas grandes inferiores -->
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="card shadow-lg h-100" style="min-height: 320px;">
                <div class="card-body">
                    <div class="d-flex">
                        <h5 class="card-title mb-3 fw-bold">Daily Active Users</h5>
                        <h5 class="card-title mb-3 ms-auto me-3 fw-bold">1</h5>
                    </div>
                    <img src="https://via.placeholder.com/500x200?text=Gráfico+1" alt="Gráfico 1" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg h-100" style="min-height: 320px;">
                <div class="card-body">
                    <div class="d-flex">
                        <h5 class="card-title mb-3 fw-bold">Monthly Active Users</h5>
                        <h5 class="card-title mb-3 ms-auto me-3 fw-bold">3</h5>
                    </div>
                    <img src="https://via.placeholder.com/500x200?text=Gráfico+2" alt="Gráfico 2" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-left mt-4 mb-3">Datos de Paseadores</h2>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg h-100" style="min-height: 320px;">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-bold">Ranking de Paseadores x Rating</h5>
                    <img src="https://via.placeholder.com/500x200?text=Gráfico+2" alt="Gráfico 3" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg h-100" style="min-height: 320px;">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-bold">Volumen de Mascotas x Paseador</h5>
                    <img src="https://via.placeholder.com/500x200?text=Gráfico+2" alt="Gráfico 4" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-left mt-4 mb-3">Datos de Mascotas</h2>
        </div>
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1 fw-bold">Promedio de Edad</h6>
                        <div class="display-6 fw-bold">2</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="text-muted mb-1 fw-bold">Promedio de Paseos</h6>
                        <div class="display-6 fw-bold">3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../componentes/footer.php'; ?>
