<?php
namespace Lib;

use PDO;
use PDOException;

class BaseDatos
{
    // Propiedades de la clase
    private $conexion;
    private mixed $resultado; // Propiedad para almacenar el resultado de la consulta
    private string $servidor;
    private string $usuario;
    private string $pass;
    private string $base_datos;

    // Constructor de la clase
    function __construct()
    {
        // Configuración de la conexión a la base de datos obtenida desde variables de entorno
        $this->servidor = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
        $this->base_datos = $_ENV['DB_DATABASE'];
        // Inicialización de la conexión
        $this->conexion = $this->conectar();
    }

    // Método privado para establecer la conexión PDO
    private function conectar(): PDO
    {
        try {
            // Configuración de opciones para la conexión PDO
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES Utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            );

            // Creación de la conexión PDO
            $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}", $this->usuario, $this->pass, $opciones);
            return $conexion;
        } catch (\PDOException $e) {
            // Manejo de errores en caso de falla en la conexión
            echo "Ha surgido un error y no se puede conectar a la base de datos. Detalle: " . $e->getMessage();
            exit;
        }
    }

    // Método para ejecutar consultas SQL
    public function consulta(string $consultasQL): void
    {
        $this->resultado = $this->conexion->query($consultasQL);
    }

    // Método para extraer un solo registro del resultado de la consulta
    public function extraer_registro(): mixed
    {
        return ($fila = $this->resultado->fetch(PDO::FETCH_ASSOC)) ? $fila : false;
    }

    // Método para extraer todos los registros del resultado de la consulta
    public function extraer_todos(): array
    {
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener el número de filas afectadas por la última consulta
    public function filasAfectadas(): int
    {
        return $this->resultado->rowCount();
    }

    // Método para cerrar la conexión a la base de datos
    public function cierraConexion()
    {
        if ($this->conexion !== null) {
            $this->conexion = null;
        }
    }

    // Método para preparar consultas SQL (para evitar inyección de SQL)
    public function prepara($pre)
    {
        return $this->conexion->prepare($pre);
    }

    // Método para cerrar la conexión a la base de datos (igual que cierraConexion, ¿se necesita?)
    public function close()
    {
        if ($this->conexion !== null) {
            $this->conexion = null;
        }
    }
}
?>