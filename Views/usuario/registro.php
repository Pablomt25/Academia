<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Enlace a la hoja de estilos CSS -->
    <link rel="stylesheet" href="CSS/registro.css">
</head>

<body>
    <!-- Encabezado principal -->
    <h2>Crear una cuenta</h2>

    <!-- PHP: Mostrar mensajes según el resultado del registro -->
    <?php use Utils\Utils; ?>
    <?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
        <h4><strong class="correcto">Registrado correctamente</strong></h4>
    <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
        <h4> <strong class="error">Registro fallido</strong> </h4>
    <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'nombre_invalido'): ?>
        <h4> <strong class="error">Registro fallido, el nombre debe empezar por mayúscula</strong> </h4>
    <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'apellidos_invalidos'): ?>
        <h4> <strong class="error">Registro fallido, los apellidos deben empezar por mayúscula, y deben ser al menos
                2</strong> </h4>
    <?php elseif (isset($_SESSION['register']) && $_SESSION['register'] == 'empty_fields'): ?>
        <h4> <strong class="error">Registro fallido, los campos no pueden estar vacíos</strong> </h4>
    <?php endif; ?>

    <!-- PHP: Limpiar la sesión después de mostrar mensajes -->
    <?php Utils::deleteSession('register'); ?>

    <!-- Formulario para el registro de usuario -->
    <form action="<?= BASE_URL ?>usuario/registro/" method="POST">

        <!-- Campos para el registro -->
        <label for="nombre">Nombre</label>
        <input type="text" name="data[nombre]"
            value="<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>" required /><br>

        <label for="apellidos">Apellidos</label>
        <input type="text" name="data[apellidos]"
            value="<?php echo isset($_SESSION['apellidos']) ? $_SESSION['apellidos'] : ''; ?>" required /><br>

        <label for="nombre_usuario">Nombre de usuario</label>
        <input type="text" name="data[nombre_usuario]" required /><br>

        <label for="pass">Contraseña</label>
        <input type="password" name="data[pass]" required /><br>

        <label for="rol">Rol</label>
        <select name="data[rol]" required>
            <option value="profesor">Profesor</option>
            <option value="padre">Padre</option>
            <option value="alumno">Alumno</option>
        </select><br><br>

        <!-- Botón de envío del formulario -->
        <input type="submit" value="Registrarse" />
    </form>
</body>

</html>