<?php

namespace Controllers;

use Models\Usuario;
use Lib\Pages;
use Utils\Utils;

class UsuarioController
{
    private Pages $pages;

    public function __construct()
    {
        $this->pages = new Pages();
    }

    public function registro(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar si el usuario tiene permiso de administrador para registrar usuarios
            if ($_SESSION['identity'] && $_SESSION['identity']->rol === 'admin') {
                // Validar y procesar el registro
                if (
                    isset($_POST['data']['nombre'], $_POST['data']['apellidos'], $_POST['data']['pass']) &&
                    !empty($_POST['data']['nombre']) &&
                    !empty($_POST['data']['apellidos']) &&
                    !empty($_POST['data']['nombre_usuario']) &&
                    !empty($_POST['data']['rol']) &&
                    !empty($_POST['data']['pass'])
                ) {
                    $nombre = $_POST['data']['nombre'];
                    $apellidos = $_POST['data']['apellidos'];
                    $nombre_usuario = $_POST['data']['nombre_usuario'];
                    $rol = $_POST['data']['rol'];
                    $pass = $_POST['data']['pass'];

                    // Validar nombre empiece con mayúscula
                    if (ucfirst($nombre) !== $nombre) {
                        $_SESSION['register'] = "nombre_invalido";
                    } else {
                        // Validar apellido empiece con mayúscula y tenga al menos dos palabras
                        $apellidoWords = explode(' ', $apellidos);
                        $apellidoFirstWord = $apellidoWords[0];
                        if (ucfirst($apellidoFirstWord) !== $apellidoFirstWord || count($apellidoWords) < 2) {
                            $_SESSION['register'] = "apellidos_invalidos";
                        } else {
                            // Encriptar contraseña
                            $pass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 4]);
                            $registrado = [
                                'nombre' => $nombre,
                                'apellidos' => $apellidos,
                                'nombre_usuario' => $nombre_usuario,
                                'pass' => $pass,
                                'rol' => $rol
                            ];

                            $usuario = Usuario::fromArray($registrado);
                            $save = $usuario->save();

                            if ($save) {
                                $_SESSION['register'] = "complete";
                            } else {
                                $_SESSION['register'] = "failed";
                            }
                        }
                    }
                } else {
                    $_SESSION['register'] = "empty_fields";
                }
            } else {
                $_SESSION['register'] = "failed"; // O un mensaje indicando que no tiene permiso para registrar
            }
        }
        $this->pages->render('usuario/registro');
    }


    /**
     * Función para iniciar sesión de usuarios en el sistema.
     * Busca y valida las credenciales del usuario en la base de datos.
     * Inicia una sesión si las credenciales son correctas y guarda los datos del usuario en la variable de sesión.
     * Redirige a la página de inicio de sesión con un mensaje de error si las credenciales no son válidas.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {
                $auth = $_POST['data'];

                // Buscar el usuario en la base de datos por su nombre de usuario
                $usuario = Usuario::fromArray($auth);
                $identity = $usuario->login();

                // Crear sesión
                if ($identity && is_object($identity)) {
                    // Verificar la contraseña utilizando password_verify
                    if (password_verify($auth['pass'], $identity->pass)) {
                        // Iniciar sesión y guardar los datos del usuario en la variable de sesión
                        $_SESSION['identity'] = $identity;

                        // Redirigir a la vista correspondiente según el rol del usuario
                        if ($identity->rol === 'admin') {
                            header("Location:" . BASE_URL . 'usuario/registro/'); // Vista del panel de administrador
                        } else if ($identity->rol === 'profesor') {
                            header("Location:" . BASE_URL . 'pruebas/registroPrueba/'); // Vista del panel de profesor
                        } else if ($identity->rol === 'padre') {
                            header("Location:" . BASE_URL . "pruebas/generarPDF/"); // Vista del panel de padre
                        }
                        return;
                    } else {
                        $_SESSION['error_de_login'] = 'failed'; // Contraseña incorrecta
                    }
                } else {
                    $_SESSION['error_de_login'] = 'failed'; // Usuario no encontrado
                }
            }
        }

        // Si hay un error o si no se ha iniciado sesión, mostrar la vista de login estándar
        $this->pages->render('usuario/login');
    }



    /**
     * Función para cerrar la sesión de un usuario.
     * Elimina la información de identidad del usuario de la sesión.
     * Redirige a la página de inicio después de cerrar la sesión.
     */


    public function logout()
    {
        Utils::deleteSession('login');

        header("Location:" . BASE_URL);
    }
}
