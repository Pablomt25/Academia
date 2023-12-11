<?php

namespace Controllers;

use Models\Nota;
use Lib\Pages;

/**
 * Controlador para la gestión de notas.
 */
class NotaController
{
    private Pages $pages;

    /**
     * Constructor de la clase NotaController.
     * Inicializa la instancia de Pages.
     */
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Lista todas las notas y renderiza la vista correspondiente.
     */
    public function listarNotas()
    {
        // Lógica para obtener y mostrar la lista de notas en la vista
        $notas = Nota::obtenerTodas();  // Asume un método estático en tu modelo Nota
        $this->pages->render('/notas/listar', ['notas' => $notas]);
    }

    /**
     * Agrega una nueva nota.
     * Valida los datos enviados por POST y guarda la nota en la base de datos.
     * Establece variables de sesión para informar sobre el resultado de la operación.
     * Renderiza la vista del formulario de agregar nota.
     */
    public function agregarNota()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
            $datosNota = $_POST['data'];

            $nota = Nota::fromArray($datosNota);

            $guardada = $nota->guardar();

            if ($guardada) {
                $_SESSION['agregarNota'] = "complete";
            } else {
                $_SESSION['agregarNota'] = "failed";
            }
        }

        // Lógica para mostrar el formulario de agregar nota en la vista
        $this->pages->render('/notas/agregar');
    }

    /**
     * Modifica una nota existente.
     * Valida los datos enviados por POST y actualiza la nota en la base de datos.
     * Establece variables de sesión para informar sobre el resultado de la operación.
     * Renderiza la vista del formulario de modificar nota.
     *
     * @param int $idNota Identificador de la nota a modificar.
     */
    public function modificarNota($idNota)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
            $datosNota = $_POST['data'];

            $nota = Nota::fromArray($datosNota);

            $modificada = $nota->modificar($idNota);

            if ($modificada) {
                $_SESSION['modificarNota'] = "complete";
            } else {
                $_SESSION['modificarNota'] = "failed";
            }
        }

        // Lógica para mostrar el formulario de modificar nota en la vista
        $this->pages->render('/notas/modificar', ['idNota' => $idNota]);
    }

    /**
     * Elimina una nota existente.
     * Utiliza el identificador de la nota para realizar la eliminación en la base de datos.
     * Establece variables de sesión para informar sobre el resultado de la operación.
     *
     * @param int $idNota Identificador de la nota a eliminar.
     */
    public function eliminarNota($idNota)
    {
        // Crear una instancia de la clase Nota
        $nota = new Nota(null, 0, 0, 0, 0, 0.0);

        // Llamada al método eliminar de la instancia
        $eliminada = $nota->eliminar($idNota);

        if ($eliminada) {
            $_SESSION['eliminarNota'] = "complete";
        } else {
            $_SESSION['eliminarNota'] = "failed";
        }
    }
}
