<?php

// Clase base para la conexión a la base de datos
class DB
{
    // Datos de conexión a MySQL
    private $host = "localhost";
    private $dbname = "productosdb";
    private $user = "Ian";
    private $pass = "Septiembr323";

    protected $conexion;

    public function __construct()
    {
        try {
            // Crea la conexión PDO con configuración UTF-8
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->pass
            );

            // Configura el modo de error para lanzar excepciones
            $this->conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {
            // Muestra un mensaje si falla la conexión
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>