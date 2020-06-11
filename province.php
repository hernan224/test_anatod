<?php
    $nav_selected = 'provincias';

    $prov_id = $_GET['id'];

    if (empty($prov_id) || !is_numeric($prov_id) || $prov_id < 1) {
        $msg = urlencode("ID de provincia no válido");
        header('Location: /provinces.php?e='.$msg);
        exit;
    }

    require_once 'classes/class.localidades.php';
    $localidad_ctr = new Localidades();

    $provincia = $localidad_ctr->getProvince($prov_id);

    if ($provincia['success'] && $provincia['province']) {
        $provincia = $provincia['province'];
        $localidades = $localidad_ctr->getProvinceCities($prov_id);
    } else {
        $msg = urlencode("Error al obtener la provincia. $provincia[error]");
        header('Location: /provinces.php?e='.$msg);
        exit;
    }
?>

<?php require_once 'includes/header.php' ?>

<div class="main-content-container">
    <section class="pa-5">
        <h4 class="section-title fs-3 fw-bold mb-4"><?=$provincia['nombre']?></h4>
        <div class="table-container">
            <?php if ($localidades['success'] && count($localidades['cities']) > 0): ?>
            <table class="dashboard-table table-stripless narrow-content">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th class="text-centered">Clientes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($localidades['cities'] as $localidad) : ?>
                    <tr>
                        <td><?=$localidad['id']?></td>
                        <td><?=$localidad['nombre']?></td>
                        <td class="text-centered"><?=$localidad['total_clientes']?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php elseif (count($localidades['cities']) == 0): ?>
                <p class="text-centered fs-5 pt-5 pb-5 text-grey">No hay localidades para mostrar</p>
            <?php else: ?>
                <p class="text-centered fs-5 pt-5 pb-5 text-secondary">Hubo un error al obtener las localidades</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
    require_once 'includes/footer.php';
    $localidad_ctr->conn->close();
?>