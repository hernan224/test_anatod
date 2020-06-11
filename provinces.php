<?php
    $nav_selected = 'provincias';

    require_once 'classes/class.localidades.php';
    $localidad_ctr = new Localidades();

    $provincias = $localidad_ctr->getProvinces();
?>

<?php require_once 'includes/header.php' ?>

<div class="main-content-container">

    <?php if (!empty($_GET['e'])) :  // Show error msg?>
    <p class="text-centered fs-5 pa-5 mb-3 text-secondary"><?=urldecode($_GET['e'])?></p>
    <?php endif; ?>

    <section class="pa-5">
        <h4 class="section-title fs-3 fw-bold mb-4">Provincias</h4>
        <div class="table-container">
            <?php if ($provincias['success'] && count($provincias['provinces']) > 0): ?>
            <table class="dashboard-table table-stripless narrow-content">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th class="text-centered">Clientes</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($provincias['provinces'] as $province) : ?>
                    <tr>
                        <td><?=$province['id']?></td>
                        <td><?=$province['nombre']?></td>
                        <td class="text-centered"><?=$province['total_clientes']?></td>
                        <td class="text-right"><a href="/province.php?id=<?=$province['id']?>" class="btn btn-solid btn-primary btn-small" style="max-width: 200px;">Ver localidades<i class="fas fa-arrow-right fa-sm ml-1"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php elseif (count($provincias['provinces']) == 0): ?>
                <p class="text-centered fs-5 pt-5 pb-5 text-grey">No hay provincias para mostrar</p>
            <?php else: ?>
                <p class="text-centered fs-5 pt-5 pb-5 text-secondary">Hubo un error al obtener las provincias</p>
            <?php endif; ?>

        </div>
    </section>
</div>

<?php
    require_once 'includes/footer.php';
    $localidad_ctr->conn->close();
?>