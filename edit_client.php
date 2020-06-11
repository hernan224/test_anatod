<?php
    $nav_selected = 'clientes';

    require_once 'classes/class.clientes.php';
    $clients_ctr = new Clientes();

    $errors = null;
    $msg = null;

    // Default client data
    $default = $clients_ctr->getClient_byID($_GET['id']);
    if ($default['success'] && $default['client']) {
        $default = $default['client'];
    } else {
        $msg = urlencode("Error al obtener el cliente");
        header('Location: /?e='.$msg);
        exit;
    }

    // Edit client
    if (!empty($_POST['id'])) {
        $nombre = null;
        $dni = 0;
        $localidad_id = 0;

        if (!empty($_POST['nombre']) && $_POST['nombre'] != $default['nombre']) {
            $nombre = $_POST['nombre'];
        }
        if (!empty($_POST['dni']) && $_POST['dni'] != $default['dni']) {
            $dni = $_POST['dni'];
        }
        if (!empty($_POST['localidad_id']) && $_POST['localidad_id'] != $default['localidad_id']) {
            $localidad_id = $_POST['localidad_id'];
        }

        $client_edited = $clients_ctr->updateClient($_POST['id'], $nombre, $dni, $localidad_id);

        if ($client_edited['success']) {
            $msg = urlencode('Cliente #'.$_POST['id'].' actualizado correctamente');
            header('Location: /?m='.$msg);
            exit;
        } else {
            $errors = $client_edited['error'];
            unset($_POST);
        }
    }
?>

<?php require_once 'includes/header.php';?>

<div class="main-content-container narrow-content">
    <section class="pa-5">
        <h4 class="section-title fs-3 fw-bold mb-4">Editar cliente</h4>
        <?php require_once 'includes/client_form.php'; ?>

        <?php if ($errors) :?>
            <p class="text-centered fs-5 mt-3 pa-3 text-secondary"><?=$errors?></p>
        <?php endif; ?>
    </section>
</div>
<?php
    require_once 'includes/footer.php';
    $clients_ctr->conn->close();
?>