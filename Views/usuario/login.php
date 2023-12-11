<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            margin-top: 80px;

        }

        h2 {
            text-align: center;
        }

        h4 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid gainsboro;
        }

        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid gainsboro;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: green;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            color: green;
            background-color: greenyellow;
            border: 1px solid green;
        }

        .correcto {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <!-- Encabezado principal -->
    <h2>Login</h2>

    <!-- PHP: Mostrar mensaje de error si el login falla -->
    <?php use Utils\Utils; ?>
    <?php if (isset($_SESSION['error_de_login']) && $_SESSION['error_de_login'] == 'failed'): ?>
        <h4 class="error">Datos Incorrectos</h4>
    <?php endif; ?>

    <!-- PHP: Limpiar la sesión después de mostrar el mensaje -->
    <?php Utils::deleteSession('error_de_login'); ?>

    <!-- Formulario para el inicio de sesión -->
    <form action="<?= BASE_URL ?>usuario/login/" method="post">
        <label for="nombre_usuario">Nombre de usuario</label>
        <input type="text" name="data[nombre_usuario]" id="nombre_usuario" /><br>

        <label for="pass">Contraseña</label>
        <input type="password" name="data[pass]" id="pass" /> <br>

        <!-- Botón de envío del formulario -->
        <input type="submit" value="Enviar" />
    </form>
</body>

</html>