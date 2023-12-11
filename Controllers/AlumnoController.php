<?php

namespace Controllers;

use Lib\Pages;
use Models\Alumno;
use Models\Usuario;

/**
 * Controlador para la gestión de alumnos.
 */
class AlumnoController {
    private Pages $pages;

    /**
     * Constructor de la clase AlumnoController.
     * Inicializa la instancia de Pages.
     */
    public function __construct() {
        $this->pages = new Pages();
    }

    /**
     * Agrega un nuevo alumno.
     *
     * Valida los datos recibidos por POST, crea una instancia de alumno y lo guarda en la base de datos.
     * Establece una variable de sesión para informar sobre el éxito o fracaso de la operación.
     * Redirige a la página de selección de padres para asociar al nuevo alumno.
     */
    public function agregarAlumno(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['id_padre'])) {
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $id_padre = $_POST['id_padre'];

                // Validar que no haya campos vacíos
                if (!empty($nombre) && !empty($apellidos) && !empty($id_padre)) {
                    // Saneamiento de las entradas
                    $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
                    $apellidos = filter_var($apellidos, FILTER_SANITIZE_STRING);
                    $id_padre = filter_var($id_padre, FILTER_SANITIZE_NUMBER_INT);

                    // Validar que nombre y apellidos empiecen por mayúscula
                    if (ucfirst($nombre) === $nombre && preg_match('/^[A-Z][a-zA-Z]+(\s[A-Z][a-zA-Z]+)+$/', $apellidos)) {
                        // Crear una instancia de alumno con los datos recibidos
                        $alumno = new Alumno(null, $nombre, $apellidos, $id_padre);

                        // Guardar el nuevo alumno en la base de datos
                        $save = $alumno->save();

                        if ($save) {
                            $_SESSION['alumno_added'] = "complete";
                        } else {
                            $_SESSION['alumno_added'] = "failed";
                        }
                    } else {
                        $_SESSION['alumno_added'] = "invalid_format";
                    }
                } else {
                    $_SESSION['alumno_added'] = "empty_fields";
                }
            } else {
                $_SESSION['alumno_added'] = "failed";
            }
        }

    }

    /**
     * Obtiene y muestra posibles padres.
     *
     * Recupera una lista de usuarios con el rol 'padre' y la muestra en la interfaz de gestión de alumnos.
     * Muestra la lista de padres en la página correspondiente si se encuentran.
     * Si no se encuentran usuarios con el rol 'padre', muestra un mensaje indicando la ausencia de padres.
     */
    public function obtenerPosiblePadre() {
        $usuarios = new Usuario();

        $padres = $usuarios->getUsuariosPorRol('padre');

        if ($padres) {
            $this->pages->render('alumnos/alumnos', ['padres' => $padres]);
        } else {
            echo "No se encontraron usuarios con el rol padre.";
        }
    }
}

?>
