<?php
/*
 * anatod ® - ©
 */
?>
<?php
class class_db {
    PUBLIC  $conn=NULL;

    CONST user      =   'test',
          pass      =   'test5678',
          db        =   'test_anatod',
          serverip  =   'anatodtest.c75o4mima6rb.us-east-1.rds.amazonaws.com';

    public function __construct(){
        if(!$this->conn){
            try {
                $this->conn = new mysqli(SELF::serverip,SELF::user,SELF::pass,SELF::db);
                $this->conn->set_charset("utf8");
                if (!$this->conn) {die('No se pudo conectar.');}
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    public function clean_tables() {
        if (!$this->conn) {
            return [
                'success' => false,
                'error' => 'Sin conexión a la base de datos'
            ];
        }

        // Vaciado de tabla clientes
        if (!$this->conn->query("DELETE FROM `clientes`")) {
            return [
                'success' => false,
                'error' => "Error al limpiar la tabla clientes: ".$this->conn->error
            ];
        }

        // Vaciado de tabla localidaldes
        if (!$this->conn->query("DELETE FROM `localidades`")) {
            return [
                'success' => false,
                'error' => "Error al limpiar la tabla localidades: ".$this->conn->error
            ];
        }

        // Vaciado de tabla provincias
        if (!$this->conn->query("DELETE FROM `provincias`")) {
            return [
                'success' => false,
                'error' => "Error al limpiar la tabla provincias: ".$this->conn->error
            ];
        }

        return ['success' =>  true];
    }

    public function query ($sql = null, $is_insert = false) {
        if (empty($sql)) {
            return [
                'success' => false,
                'error' => "No hay una sentencia SQL válida"
            ];
        }

        $query = $this->conn->query($sql);

        if (!$query){
            return [
                'success' => false,
                'error' => "Error al ejecutar la sentencia: ".$this->conn->error
            ];
        }

        $response = [
            'success' =>  true,
            'query' => $query
        ];

        if ($is_insert) {
            $response['id_inserted'] = $this->conn->insert_id;
        }

        return $response;
    }
}
