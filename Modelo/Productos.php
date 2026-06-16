<?php

require_once "conexion.php";

// Clase Producto con operaciones CRUD para la tabla productos
class Producto extends DB
{
    private $id;
    private $codigo;
    private $producto;
    private $precio;
    private $cantidad;
    private $departamento;

    public function __construct()
    {
        parent::__construct();
    }

    public function setDatos(
        $codigo,
        $producto,
        $precio,
        $cantidad,
        $departamento
    )
    {
        // Asigna los valores recibidos a las propiedades del objeto
        $this->codigo = $codigo;
        $this->producto = $producto;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->departamento = $departamento;
    }

    public function guardar()
    {
        // Inserta un nuevo producto en la base de datos
        $sql = "INSERT INTO productos
                (codigo, producto, precio, cantidad, departamento)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            $this->codigo,
            $this->producto,
            $this->precio,
            $this->cantidad,
            $this->departamento
        ]);
    }

    public function editar($id)
    {
        // Actualiza un producto existente por su ID
        $sql = "UPDATE productos
                SET codigo=?,
                    producto=?,
                    precio=?,
                    cantidad=?,
                    departamento=?
                WHERE id=?";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            $this->codigo,
            $this->producto,
            $this->precio,
            $this->cantidad,
            $this->departamento,
            $id
        ]);
    }

    public function buscar($id)
    {
        // Recupera los datos de un producto por su ID
        $sql = "SELECT * FROM productos WHERE id=?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar()
    {
        // Obtiene todos los productos ordenados por ID descendente
        $sql = "SELECT * FROM productos ORDER BY id DESC";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>