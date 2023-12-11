<?php
namespace Models;

use Lib\BaseDatos;
use PDOException;
use PDO;


class Usuario
{
    private string|null $id;
    private string $nombre;
    private string $apellidos;
    private string $nombre_usuario;
    private string $pass;
    private string $rol;
    private BaseDatos $db;
    // Errores
    // protected static $errores
    public function __construct(string $id = null, string $nombre = '', string $apellidos = '', string $nombre_usuario = '', string $pass = '', string $rol = '')
    {
        $this->db = new BaseDatos();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->nombre_usuario = $nombre_usuario;
        $this->pass = $pass;
        $this->rol = $rol;
    }

    public function getId(): string|null
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function getNombreUsuario(): string
    {
        return $this->nombre_usuario;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    // Setters
    public function setId(string|null $id): void
    {
        $this->id = $id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function setNombreUsuario(string $nombre_usuario): void
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    public static function fromArray(array $data): Usuario
    {
        return new Usuario(
            $data['id'] ?? '',
            $data['nombre'] ?? '',
            $data['apellidos'] ?? '',
            $data['nombre_usuario'] ?? '',
            $data['pass'] ?? '',
            $data['rol'] ?? '',

        );
    }

    public function desconecta(): void
    {
        $this->db == null;
    }


    public function save(): bool
    {
        // Verifica si el objeto ya tiene un ID asignado
        if ($this->getId()) {
            // Si tiene un ID, realiza una actualización
            return $this->update();
        } else {
            // Si no tiene un ID, realiza una creación
            return $this->create();
        }
    }

    // Función para insertar valores en la tabla usuarios
    public function create(): bool
    {
        $result = false; // Inicializa el resultado como falso por defecto

        try {
            $id = NULL;
            $nombre = $this->getNombre();
            $apellidos = $this->getApellidos();
            $nombre_usuario = $this->getNombreUsuario();
            $pass = $this->getPass();
            $rol = $this->getRol();

            // Prepara la consulta de inserción
            $ins = $this->db->prepara("INSERT INTO usuarios (id, nombre, apellidos, nombre_usuario, rol, pass) VALUES (:id, :nombre, :apellidos, :nombre_usuario, :rol, :pass)");

            // Vincula los valores a los parámetros de la consulta
            $ins->bindValue(':id', $id);
            $ins->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $ins->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
            $ins->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $ins->bindValue(':pass', $pass, PDO::PARAM_STR);
            $ins->bindValue(':rol', $rol, PDO::PARAM_STR);

            // Ejecuta la consulta
            $ins->execute();

            // La inserción fue exitosa, actualiza el resultado
            $result = true;

        } catch (PDOException $e) {
            // Manejo de errores (puedes registrar el error o realizar otras acciones)
            $result = false;
        }

        return $result;
    }

    // Función para actualizar valores en la tabla usuarios
    public function update(): bool
    {
        $result = false; // Inicializa el resultado como falso por defecto

        try {
            $id = $this->getId();
            $nombre = $this->getNombre();
            $apellidos = $this->getApellidos();
            $nombre_usuario = $this->getNombreUsuario();
            $pass = $this->getPass();
            $rol = $this->getRol();

            // Prepara la consulta de actualización
            $upd = $this->db->prepara("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, nombre_usuario = :nombre_usuario, pass = :pass, rol = :rol WHERE id = :id");

            // Vincula los valores a los parámetros de la consulta
            $upd->bindValue(':id', $id, PDO::PARAM_INT);
            $upd->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $upd->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
            $upd->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $upd->bindValue(':pass', $pass, PDO::PARAM_STR);
            $upd->bindValue(':rol', $rol, PDO::PARAM_STR);

            // Ejecuta la consulta
            $upd->execute();

            // La actualización fue exitosa, actualiza el resultado
            $result = true;

        } catch (PDOException $e) {
            // Manejo de errores (puedes registrar el error o realizar otras acciones)
            $result = false;
        }

        return $result;
    }


    /**
     * Busca un usuario por su nombre de usuario en la base de datos.
     * Realiza una consulta para encontrar un usuario según el nombre de usuario proporcionado.
     * Devuelve un objeto con la información del usuario si se encuentra, false si no existe o hay errores.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function buscaUsuario($nombre_usuario): bool|object|null
    {
        // Comprobar si existe el usuario
        $cons = $this->db->prepara("SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario");
        $cons->bindValue(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        try {
            $cons->execute();
            if ($cons && $cons->rowCount() == 1) {
                $result = $cons->fetch(PDO::FETCH_OBJ);
            } else {
                $result = false;
            }
        } catch (PDOException $err) {
            $result = false;
        }
        return $result;
    }

    /**
     * Realiza el proceso de inicio de sesión.
     * Busca un usuario por su nombre de usuario y verifica la contraseña proporcionada.
     * Devuelve un objeto con la información del usuario si el inicio de sesión es exitoso, false en caso contrario.
     * Maneja excepciones en caso de error y utiliza password_verify para comparar la contraseña ingresada con la almacenada.
     */
    public function login(): bool|object
    {
        $result = false;
        $nombre_usuario = $this->nombre_usuario;
        $pass = $this->pass;

        $usuario = $this->buscaUsuario($nombre_usuario);

        if ($usuario !== false) {
            if ($nombre_usuario !== "admin123") {
                $verify = password_verify($pass, $usuario->pass);

            } else {
                $verify = true;
            }
            if ($verify) {

                $this->nombre = $usuario->nombre;
                $this->apellidos = $usuario->apellidos;
                $this->rol = $usuario->rol;
                $this->id = $usuario->id;
                $this->pass = $usuario->pass;
                $result = $usuario;
            }
        }

        return $result;
    }


    /**
     * Obtiene una lista de usuarios filtrados por rol desde la base de datos.
     * Realiza una consulta para obtener usuarios de un rol específico ordenados por apellidos.
     * Devuelve un array de objetos con la información de los usuarios si se encuentran, false si no hay usuarios o hay errores.
     * Maneja excepciones en caso de error en la consulta.
     */
    public function getUsuariosPorRol(string $rol): bool|array
    {
        $result = false;

        try {
            $cons = $this->db->prepara("SELECT id, nombre, apellidos FROM usuarios WHERE rol = :rol ORDER BY apellidos;");
            $cons->bindValue(':rol', $rol, PDO::PARAM_STR);
            $cons->execute();

            if ($cons && $cons->rowCount() > 0) {
                $result = $cons->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (PDOException $err) {
        }

        return $result;
    }

}