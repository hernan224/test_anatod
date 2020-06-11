<?php

require_once 'class.database.php';

class Clientes extends class_db {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Save new client
     * @param String $name
     * @param Number $dni
     * @param Number $city
     */
    public function saveClient($name = '', $dni = 0, $city = 0) {
        // Sanitize data
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $dni = filter_var($dni, FILTER_SANITIZE_NUMBER_INT);

        // Check data
        if (empty($name)) {
            return ['success' => false, 'error' => 'Nombre del cliente no indicado'];
        }
        if (empty($dni) || $dni < 1) {
            return ['success' => false, 'error' => 'DNI del cliente no válido'];
        }
        if ($city < 1) {
            return ['success' => false, 'error' => 'Ciudad del cliente no válida'];
        }

        // Check if DNI is usaed
        $clientByDni = $this->getClient_byDNI($dni);
        if ($clientByDni['success'] && $clientByDni['client']) {
            return ['success' => false, 'error' => 'El DNI ya está registrado'];
        }

        // Create
        $sql = "INSERT INTO clientes (`cliente_nombre`, `cliente_dni`, `cliente_localidad`)
        VALUES ('$name', '$dni', '$city');";

        return $this->query($sql, true);
    }

    /**
     * Update client data
     * @param Number $id
     * @param String $name
     * @param Number $dni
     * @param Number $city
     */
    public function updateClient($id = 0, $name = '', $dni = 0, $city = 0) {
        // Check data
        if ($id < 1) {
            return ['success' => false, 'error' => 'ID del cliente no válido'];
        }

        // Sanitize data
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $dni = filter_var($dni, FILTER_SANITIZE_NUMBER_INT);

        $set_sql = '';

        // Check dat aand prepare query
        if (!empty($name)) {
            $set_sql .= "cliente_nombre = '".$name."'";
        }
        if (!empty($dni) && $dni > 0) {
            // Check if DNI is used
            $clientByDni = $this->getClient_byDNI($dni);
            if ($clientByDni['success'] && $clientByDni['client']) {
                return ['success' => false, 'error' => 'El DNI ya está registrado'];
            }

            $set_sql .= !empty($set_sql) ? ', ' : '';
            $set_sql .= "cliente_dni = '$dni'";
        }
        if ($city > 0) {
            $set_sql .= !empty($set_sql) ? ', ' : '';
            $set_sql .= "cliente_localidad = '$city'";
        }

        if (empty($set_sql)) {
            return ['success' => false, 'error' => 'No hay valores para actualizar'];
        }
        // Update
        $sql = "UPDATE clientes
        SET $set_sql
        WHERE cliente_id = $id";

        return $this->query($sql);
    }

    /**
     * Get all clients
     * @param Number $limit
     * @param Number $offset
     * @param String $order -> order direction ['ASC', 'DESC']
     * @param String $order_by -> orer column ['id', 'nombre', 'dni']
     */
    public function getClients($limit = -1, $offset = 0, $order = 'ASC', $order_by = 'nombre') {

        $valid_order_by_inputs = ['id', 'nombre', 'dni'];
        $valid_bd_order_by = ['c.cliente_id', 'c.cliente_nombre', 'c.cliente_dni'];

        // Set query order by
        $valid_order_by = $valid_bd_order_by[0];
        if (in_array($order_by, $valid_order_by_inputs)) {
            $valid_order_by = str_replace($valid_order_by_inputs, $valid_bd_order_by, $order_by);
        }
        $order_sql = "ORDER BY $valid_order_by $order";

        // Set query limit
        $limit_sql = '';
        if ($limit > 0) {
            $limit_sql = "LIMIT $offset, $limit";
        }

        // Get clients
        $sql = "SELECT c.cliente_id AS id, c.cliente_nombre AS nombre, c.cliente_dni AS dni, l.localidad_nombre AS localidad, p.provincia_nombre AS provincia
        FROM clientes c
        INNER JOIN localidades l ON c.cliente_localidad = l.localidad_id
        INNER JOIN provincias p ON l.localidad_provincia = p.provincia_id
        $order_sql $limit_sql";

        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'clients' => $query['query']->fetch_all(MYSQLI_ASSOC)
        ];
    }

    /**
     * Get client by ID
     * @param Number $id
     */
    public function getClient_byID($id = 0) {
        if ($id < 0) {
            return [
                'success' => false,
                'error' => 'ID de cliente no válido'
            ];
        }


        $sql = "SELECT c.cliente_id AS id, c.cliente_nombre AS nombre, c.cliente_dni AS dni, l.localidad_id, l.localidad_nombre, p.provincia_id, p.provincia_nombre
        FROM clientes c
        INNER JOIN localidades l ON c.cliente_localidad = l.localidad_id
        INNER JOIN provincias p ON l.localidad_provincia = p.provincia_id
        WHERE c.cliente_id = $id";

        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'client' => $query['query']->fetch_assoc()
        ];
    }

    /**
     * Get client by DNI
     * @param Number $dni
     */
    public function getClient_byDNI($dni = null) {
        if ($dni < 0) {
            return [
                'success' => false,
                'error' => 'ID de cliente no válido'
            ];
        }

        $sql = "SELECT c.cliente_id AS id, c.cliente_nombre AS nombre, c.cliente_dni AS dni, l.localidad_id, l.localidad_nombre, p.provincia_id, p.provincia_nombre
        FROM clientes c
        INNER JOIN localidades l ON c.cliente_localidad = l.localidad_id
        INNER JOIN provincias p ON l.localidad_provincia = p.provincia_id
        WHERE c.cliente_dni = $dni";

        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'client' => $query['query']->fetch_assoc()
        ];
    }
}

?>