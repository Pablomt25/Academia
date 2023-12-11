<?php

namespace Controllers;

use Models\Materia;
use Models\Usuario;
use Lib\Pages;

/**
 * Controlador para la gestión de materias.
 */
class MateriaController
{
    private Pages $pages;

    /**
     * Constructor de la clase MateriaController.
     * Inicializa la instancia de Pages.
     */
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Obtiene posibles profesores y renderiza la vista para registrar materias.
     */
    public function obtenerPosibleProfesor()
    {
        $usuarios = new Usuario();

        $profesores = $usuarios->getUsuariosPorRol('profesor');

        if ($profesores) {
            $this->pages->render('materias/registro_materias', ['profesores' => $profesores]);
        } else {
            echo "No se encontraron usuarios con el rol profesor.";
        }
    }

    /**
     * Agrega una nueva materia al sistema.
     *
     * Valida los datos enviados por POST, verifica si la materia ya existe y la guarda en la base de datos si es nueva.
     * Establece variables de sesión para informar sobre el resultado de la operación.
     * Redirige a la página de obtención de posibles profesores para asociar a la nueva materia.
     */
    public function agregarMateria(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre_materia'], $_POST['id_profesor'])) {
                $nombreMateria = $_POST['nombre_materia'];
                $idProfesor = $_POST['id_profesor'];

                // Saneamiento de la entrada
                $nombreMateria = filter_var($nombreMateria, FILTER_SANITIZE_STRING);
                $idProfesor = filter_var($idProfesor, FILTER_SANITIZE_NUMBER_INT);

                // Validar el nombre de la materia y el ID del profesor
                if (!empty($nombreMateria) && ctype_upper(substr($nombreMateria, 0, 1))) {
                    // Crear una instancia de Materias para verificar si existe
                    $materiasModel = new Materia();
                    $existeMateria = $materiasModel->buscarPorNombre($nombreMateria);

                    if ($existeMateria) {
                        // La materia ya existe, establecer mensaje de error
                        $_SESSION['materia_added'] = "duplicate";
                    } else {
                        // La materia no existe, proceder a guardarla
                        $materia = new Materia(null, $nombreMateria, $idProfesor);
                        $save = $materia->save();

                        if ($save) {
                            $_SESSION['materia_added'] = "complete";
                        } else {
                            $_SESSION['materia_added'] = "failed";
                        }
                    }
                } else {
                    $_SESSION['materia_added'] = "invalid_format";
                }
            } else {
                $_SESSION['materia_added'] = "failed";
            }
        }
    }
}

?>
