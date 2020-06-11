<?php

require_once 'class.database.php';

class Localidades extends class_db {

    public function __construct()
    {
       parent::__construct();
    }

    /**
     * Get all cities,
     * @param Number $limit
     * @param Number $offset
     * @param String $order -> order direction ['ASC', 'DESC']
     * @param String $order_by -> orer column ['id', 'nombre', 'provincia']
     */
    public function getCities($limit = -1, $offset = 0, $order = 'ASC', $order_by = 'nombre') {

        $valid_order_by_inputs = ['id', 'nombre', 'provincia'];
        $valid_bd_order_by = ['l.localidad_id', 'l.localidad_nombre', 'p.provincia_nombre'];

        // Set order_by sql
        $valid_order_by = $valid_bd_order_by[0];
        if (in_array($order_by, $valid_order_by_inputs)) {
            $valid_order_by = str_replace($valid_order_by_inputs, $valid_bd_order_by, $order_by);
        }
        $order_sql = "ORDER BY $valid_order_by $order";

        // Set limit sql
        $limit_sql = '';
        if ($limit > 0) {
            $limit_sql = "LIMIT $offset, $limit";
        }

        // Get cities
        $sql = "SELECT l.localidad_id AS id, l.localidad_nombre AS nombre, p.provincia_nombre AS provincia
        FROM localidades l
        INNER JOIN provincias p ON l.localidad_provincia = p.provincia_id
        $order_sql $limit_sql";
        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'cities' => $query['query']->fetch_all(MYSQLI_ASSOC)
        ];
    }


    /**
     * Get all provincis,
     * @param String $order_by -> orer column ['clientes', 'nombre']
     */
    public function getProvinces($order_by = 'clientes') {
        // Order by name
        $order_sql = "ORDER BY p.provincia_nombre ASC";
        if ($order_by == 'clientes') {
            // Order by clients count
            $order_sql = "ORDER BY total_clientes DESC, p.provincia_nombre ASC";
        }

        // Get provinces
        $sql = "SELECT p.provincia_id AS id, p.provincia_nombre AS nombre, COUNT(c.cliente_localidad) AS total_clientes
        FROM provincias p
        INNER JOIN localidades l ON l.localidad_provincia = p.provincia_id
        LEFT JOIN clientes c ON c.cliente_localidad = l.localidad_id
        GROUP BY p.provincia_id
        $order_sql";
        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'provinces' => $query['query']->fetch_all(MYSQLI_ASSOC)
        ];
    }

    /**
     * Get provicne by ID
     * @param Number $province_id
     */
    public function getProvince($province_id = 0) {
        if (empty($province_id) || $province_id < 1 || $province_id > 25) {
            return [
                'success' => false,
                'error' => 'ID de provincia no válido'
            ];
        }

        // Get province
        $sql = "SELECT provincia_id AS id, provincia_nombre AS nombre
        FROM provincias
        WHERE provincia_id = $province_id";
        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'province' => $query['query']->fetch_assoc()
        ];
    }

    /**
     * Get province cities
     * @param Number $province_id
     * @param String $order_by -> orer column ['clientes', 'nombre']
     */
    public function getProvinceCities($province_id = 0, $order_by = 'clientes') {
        if (empty($province_id) || $province_id < 1 || $province_id > 25) {
            return [
                'success' => false,
                'error' => 'ID de provincia no válido'
            ];
        }

        // Order by name
        $order_sql = "ORDER BY l.localidad_nombre ASC";
        if ($order_by == 'clientes') {
            // Order by clients count
            $order_sql = "ORDER BY total_clientes DESC, l.localidad_nombre ASC";
        }

        // Get cities
        $sql = "SELECT l.localidad_id AS id, l.localidad_nombre AS nombre, COUNT(c.cliente_localidad) AS total_clientes
        FROM localidades l
        LEFT JOIN clientes c ON c.cliente_localidad = l.localidad_id
        WHERE l.localidad_provincia = $province_id
        GROUP BY l.localidad_id
        $order_sql";
        $query = $this->query($sql);

        if (!$query['success']) return $query;

        $response = [
            'success' => true,
            'cities' => $query['query']->fetch_all(MYSQLI_ASSOC)
        ];

        $query['query']->close();

        return $response;
    }

    /**
     * Get city
     * @param NUmber $city_id
     */
    public function getCity($city_id = 0) {
        if ($city_id < 0) {
            return [
                'success' => false,
                'error' => 'ID de ciudad no válido'
            ];
        }

        // Get city
        $sql = "SELECT l.localidad_id AS id, l.localidad_nombre AS nombre, p.provincia_nombre AS provincia, COUNT(c.cliente_id) AS total_clientes
        FROM localidades l
        INNER JOIN provincias p ON l.localidad_provincia = p.provincia_id
        INNER JOIN clientes c ON l.localidad_id = c.cliente_localidad
        WHERE l.localidad_id = $city_id";
        $query = $this->query($sql);

        if (!$query['success']) return $query;

        return [
            'success' => true,
            'city' => $query['query']->fetch_assoc()
        ];
    }

}

?>