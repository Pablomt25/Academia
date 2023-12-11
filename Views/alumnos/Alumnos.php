<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="CSS/alumnos.css">
</head>
<body>

    <main>
        <h2>Agregar Nuevo Alumno</h2>
        <?php use Utils\Utils; ?>
    <?php if(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'complete'): ?> 
        <h4 class="correcto">Registrado correctamente</h4>
    <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'failed'): ?> 
        <h4 class="error">Registro fallido </h4>
        <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'invalid_format'): ?> 
        <h4 class="error">Registro fallido, el nombre y apellidos del alumno deben empezar por mayúscula</h4>
        <?php elseif(isset($_SESSION['alumno_added']) && $_SESSION['alumno_added'] == 'empty_fields'): ?> 
        <h4 class="error">Registro fallido, los campos deben estar rellenos </h4>
        <?php endif; ?>
    <?php Utils::deleteSession('alumno_added'); ?>


        <form action="<?= BASE_URL ?>alumnos/Alumnos/" method="post">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required><br><br>
            
            <label for="apellidos">Apellidos:</label><br>
            <input type="text" id="apellidos" name="apellidos" required><br><br>


            <label for="id_padre">Padre:</label>
            <select id="id_padre" name="id_padre" required>
            <option value="">Lista de padres</option>
            <?php
            
            foreach ($padres as $padre) {
                echo "<option value='" . $padre->id . "'>" . $padre->nombre.' '.$padre->apellidos . "</option>";
            }
            
            ?>
            </select><br>
            
            <input type="submit" value="Guardar">
        </form>
    </main>
</body>
</html>