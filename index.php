<?php
    $nav_selected = 'clientes';

    require_once 'classes/class.clientes.php';
    $clients_ctr = new Clientes();

    $clientes = $clients_ctr->getClients();
?>

<?php require_once 'includes/header.php' ?>
<div class="main-content-container">

    <?php if (!empty($_GET['e'])) : // Show error msg?>
    <p class="text-centered fs-5 pa-5 mb-3 text-secondary"><?=urldecode($_GET['e'])?></p>
    <?php endif; ?>
    <?php if (!empty($_GET['m'])) : // Show other msg?>
    <p class="text-centered fs-5 pa-5 mb-3 text-primary"><?=urldecode($_GET['m'])?></p>
    <?php endif; ?>

    <section class="pa-5">
        <div class="flex-container flex-content-between flex-items-center mb-3">
            <h2 class="section-title fs-3 fw-bold mb-4">Nuestros clientes</h2>
            <a href="/new_client.php" class="btn btn-solid btn-dark">Nuevo cliente <i class="fas fa-user-plus ml-1"></i></a>
        </div>
        <div class="table-container">
            <?php if ($clientes['success'] && count($clientes['clients']) > 0): ?>
            <table class="dashboard-table table-stripless">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Localidad</th>
                        <th>Provincia</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes['clients'] as $client) : ?>
                    <tr>
                        <td><?=$client['id']?></td>
                        <td><?=$client['nombre']?></td>
                        <td><?=$client['dni']?></td>
                        <td><?=$client['localidad']?></td>
                        <td><?=$client['provincia']?></td>
                        <td><a href="/edit_client.php?id=<?=$client['id']?>" class="btn btn-solid btn-primary btn-small">Editar <i class="fas fa-pen fa-sm ml-1"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php elseif (count($clientes['clients']) == 0): ?>
                <p class="text-centered fs-5 pt-5 pb-5 text-grey">No hay clientes para mostrar</p>
            <?php else: ?>
                <p class="text-centered fs-5 pt-5 pb-5 text-secondary">Hubo un error al obtener los clientes</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php
    require_once 'includes/footer.php';
    $clients_ctr->conn->close();
?>