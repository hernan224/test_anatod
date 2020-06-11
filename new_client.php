<?php
    $nav_selected = 'nuevo_cliente';

    require_once 'classes/class.clientes.php';

    $clients_ctr = new Clientes();

    $errors = null;
    $msg = null;
    $default = null;

    if (isset($_POST['nombre']) && isset($_POST['dni']) && $_POST['localidad_id']) {
        // Create client
        $client_created = $clients_ctr->saveClient($_POST['nombre'], $_POST['dni'], $_POST['localidad_id']);

        if ($client_created['success']) {
            unset($_POST);
            $default = null;
            $errors = null;
            $msg = 'Cliente creado correctamente';
        } else {
            $default = $_POST;
            unset($_POST);
            $msg = null;
            $errors = $client_created['error'];
        }
    }

?>

<?php require_once 'includes/header.php' ?>

<div class="main-content-container narrow-content">
    <section class="pa-5">
        <h4 class="section-title fs-3 fw-bold mb-4">Nuevo cliente</h4>

        <?php require_once 'includes/client_form.php'; ?>

        <?php if ($errors || $msg) :?>
            <p class="text-centered fs-5 mt-3 pa-3 text-<?=$errors ? 'secondary' : 'primary'?>"><?=$errors ? $errors : $msg?></p>
        <?php endif; ?>
    </section>
</div>

<?php
    require_once 'includes/footer.php';
    $clients_ctr->conn->close();
?>