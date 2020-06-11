<?php
    require_once 'classes/class.localidades.php';
    $localidad_ctr = new Localidades();

    $provincias = $localidad_ctr->getProvinces('nombre');
    $localidades = null;
    if (!empty($default['provincia_id'])) {
        $localidades = $localidad_ctr->getProvinceCities($default['provincia_id'], 'nombre');
    }

?>

<form action="" method="POST" style="max-width: 680px;">
    <?php if (!empty($default['id'])): ?>
    <input type="hidden" name="id" value="<?=$default['id']?>">
    <?php endif; ?>
    <div class="field mb-3">
        <label for="clientName" class="label">Nombre y apellido</label>
        <div class="control">
            <input class="input" type="text"  placeholder="Nombre y apellido del cliente" name="nombre" id="clientName" value="<?=!empty($default['nombre']) ? $default['nombre'] : ''?>" required>
        </div>
    </div>
    <div class="field mb-3">
        <label for="clientDni" class="label">DNI</label>
        <div class="control">
            <input class="input" type="number" min="0" max="99999999"  placeholder="DNI del cliente" name="dni" id="clientDni" value="<?=!empty($default['dni']) ? $default['dni'] : ''?>" required>
        </div>
    </div>
    <div class="field mb-3">
        <label for="selectProvincias" class="label">Provincia</label>
        <div class="control">
            <div class="select">
                <select id="selectProvincias" name="provincia_id" required>
                    <?php if ($provincias['success']): ?>
                        <?php if (empty($default['provincia_id'])) : ?>
                        <option selected hidden>Seleccione una provincia</option>
                        <?php endif; ?>

                        <?php foreach ($provincias['provinces'] as $prov) : ?>
                        <option value="<?= $prov['id'] ?>" <?= (!empty($default['provincia_id']) && $default['provincia_id'] == $prov['id']) ? 'selected' : ''  ?>><?= $prov['nombre']; ?></option>
                        <?php endforeach; ?>

                    <?php else : ?>
                    <option selected hidden>Error al obtener las provincias</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="field mb-3">
        <label for="selectLocalidades" class="label">Localidad</label>
        <div class="control">
            <div class="select">
                <select id="selectLocalidades" name="localidad_id" required>
                    <?php if (!$localidades) : ?>
                    <option selected hidden>Primero debe seleccionar una provincia</option>
                    <?php elseif ($localidades['success']): ?>
                        <?php if (empty($default['localidad_id'])): ?>
                        <option selected hidden>Seleccione una localidad</option>
                        <?php endif; ?>

                        <?php foreach ($localidades['cities'] as $city) : ?>
                        <option value="<?= $city['id'] ?>" <?= (!empty($default['localidad_id']) && $default['localidad_id'] == $city['id']) ? 'selected' : ''  ?>><?= $city['nombre']; ?></option>
                        <?php endforeach; ?>

                    <?php else : ?>
                    <option selected hidden>Error al obtener las localidades</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="flex-container flex-content-end">
        <button type="submit" class="btn btn-big btn-solid btn-primary">Guardar cambios</button>
    </div>
</form>

<?php  $localidad_ctr->conn->close(); ?>