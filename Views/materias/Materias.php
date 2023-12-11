<!-- formulario_materia.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Materia</title>
    <link rel="stylesheet" href="CSS/materias.css">
</head>
<body>
    <header>
    </header>
    <main>
        <h2>Agregar Nueva Materia</h2>
        <?php use Utils\Utils; ?>
<?php if(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'complete'): ?> 
        <h4 class="correcto">Registrado correctamente</h4>
    <?php elseif(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'failed'): ?> 
        <h4 class="error">Registro fallido</h4>
        <?php elseif(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'duplicate'): ?> 
        <h4 class="error">Registro fallido, esa asignatura ya esta asignada</h4>
        <?php elseif(isset($_SESSION['materia_added']) && $_SESSION['materia_added'] == 'invalid_format'): ?> 
        <h4 class="error">Registro fallido, la primera letra debe empezar por mayúscula </h4>
        <?php endif; ?>
<?php Utils::deleteSession('materia_added'); ?>
        <form action="<?= BASE_URL ?>materia/Materias/" method="post">

            <label for="nombre_materia">Nombre de la Materia:</label><br>
            <input type="text" id="nombre_materia" name="nombre_materia" required><br>
            
            <label for="id_profesor">Profesor de la materia:</label>
            <select id="id_profesor" name="id_profesor" required>
            <option value="" disabled selected>Selecciona un profesor</option>
            <?php
            
            foreach ($profesores as $profesor) {
                echo "<option value='" . $profesor->id . "'>" . $profesor->nombre. ' '. $profesor->apellidos. "</option>";
            }
            
            ?>
            </select><br>
            
            <input type="submit" value="Guardar">
        </form>
    </main>
</body>
</html>