<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
use PDOException;

class Nota
{
    private ?int $id;
    private int $idMateria;
    private int $idProfesor;
    private int $idAlumno;
    private int $trimestre;
    private float $nota;

    private BaseDatos $db;

    public function __construct(?int $id, int $idMateria, int $idProfesor, int $idAlumno, int $trimestre, float $nota)
    {
        $this->id = $id;
        $this->idMateria = $idMateria;
        $this->idProfesor = $idProfesor;
        $this->idAlumno = $idAlumno;
        $this->trimestre = $trimestre;
        $this->nota = $nota;

        $this->db = new BaseDatos();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getIdMateria(): int
    {
        return $this->idMateria;
    }

    public function setIdMateria(int $idMateria): void
    {
        $this->idMateria = $idMateria;
    }

    public function getIdProfesor(): int
    {
        return $this->idProfesor;
    }

    public function setIdProfesor(int $idProfesor): void
    {
        $this->idProfesor = $idProfesor;
    }

    public function getIdAlumno(): int
    {
        return $this->idAlumno;
    }

    public function setIdAlumno(int $idAlumno): void
    {
        $this->idAlumno = $idAlumno;
    }

    public function getTrimestre(): int
    {
        return $this->trimestre;
    }

    public function setTrimestre(int $trimestre): void
    {
        $this->trimestre = $trimestre;
    }

    public function getNota(): float
    {
        return $this->nota;
    }

    public function setNota(float $nota): void
    {
        $this->nota = $nota;
    }

     /**
     * Crea una instancia de Nota a partir de un array de datos.
     *
     * @param array $data Array asociativo con los datos de la nota.
     * @return Nota
     */
    public static function fromArray(array $data): Nota
    {
        return new Nota(
            $data['id'] ?? null,
            $data['id_materia'] ?? 0,
            $data['id_profesor'] ?? 0,
            $data['id_alumno'] ?? 0,
            $data['trimestre'] ?? 0,
            $data['nota'] ?? 0.0
        );
    }


 // Métodos restantes...

    /**
     * Desconecta la instancia de la base de datos.
     */
    public function desconecta()
    {
        $this->db->close();
    }


    /**
     * Obtiene todas las notas de la base de datos.
     *
     * @return array Arreglo asociativo con todas las notas.
     */
    public static function obtenerTodas(): array
    {
        $resultado = [];

        try {
            $select = (new BaseDatos())->prepara("SELECT * FROM pruebas");
            $select->execute();
            $resultado = $select->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            // Manejo de errores
        } finally {
            $select->closeCursor();
            $select = null;
        }

        return $resultado;
    }

     /**
     * Guarda la nota en la base de datos.
     *
     * @return bool True si la operación fue exitosa, False en caso contrario.
     */
    public function guardar(): bool
    {
        $sql = "INSERT INTO pruebas (id_materia, id_profesor, id_alumno, trimestre, nota) 
                VALUES (:id_materia, :id_profesor, :id_alumno, :trimestre, :nota)";

        $stmt = $this->db->prepara($sql);

        $stmt->bindValue(':id_materia', $this->idMateria, PDO::PARAM_INT);
        $stmt->bindValue(':id_profesor', $this->idProfesor, PDO::PARAM_INT);
        $stmt->bindValue(':id_alumno', $this->idAlumno, PDO::PARAM_INT);
        $stmt->bindValue(':trimestre', $this->trimestre, PDO::PARAM_INT);
        $stmt->bindValue(':nota', $this->nota, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }

     /**
     * Modifica una nota en la base de datos.
     *
     * @param int $id Identificador de la nota a modificar.
     * @return bool True si la operación fue exitosa, False en caso contrario.
     */
    public function modificar($id): bool
    {
        $sql = "UPDATE pruebas 
                SET id_materia = :id_materia, id_profesor = :id_profesor, id_alumno = :id_alumno, 
                    trimestre = :trimestre, nota = :nota 
                WHERE id = :id";
    
        $stmt = $this->db->prepara($sql);
    
        $stmt->bindValue(':id_materia', $this->idMateria, PDO::PARAM_INT);
        $stmt->bindValue(':id_profesor', $this->idProfesor, PDO::PARAM_INT);
        $stmt->bindValue(':id_alumno', $this->idAlumno, PDO::PARAM_INT);
        $stmt->bindValue(':trimestre', $this->trimestre, PDO::PARAM_INT);
        $stmt->bindValue(':nota', $this->nota, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }
    

     /**
     * Elimina una nota de la base de datos.
     *
     * @param int $id Identificador de la nota a eliminar.
     * @return bool True si la operación fue exitosa, False en caso contrario.
     */
    public function eliminar($id): bool
    {
        $sql = "DELETE FROM pruebas WHERE id = :id";
    
        $stmt = $this->db->prepara($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }
}
