<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar PDF de Notas</title>
    <link rel="stylesheet" href="CSS/generarPDF.css">
</head>
<body>
    <div class="form-container">
    <h1>Notas por Materia y Trimestre</h1>
    <form action="<?= BASE_URL ?>pruebas/NotasPorMateriaYTrimestre/" method="post">
        <label for="id_materia">Materia:</label>
        <select name="id_materia" id="id_materia">
            <?php
                foreach ($materias as $materia) {
                    echo '<option value="' . $materia->id . '">' . $materia->nombre_materia . '</option>';
                }
            
            ?>
        </select>
        <br>
        <label for="trimestre">Trimestre:</label>
        <select name="trimestre" id="trimestre">
            <option value="primero">Primero</option>
            <option value="segundo">Segundo</option>
            <option value="tercero">Tercero</option>
        </select>
        <br>
        <button type="submit">Ver</button>
    </form>
    </div>

    <div class="form-container">
    <h1>Listado completo de notas de un alumno</h1>
    <form action="<?= BASE_URL ?>pruebas/ListadoCompletoPorAlumno/" method="post">
    <label for="alumno">Alumno:</label>
    <select name="alumno" id="alumno">
        <?php foreach ($alumnos as $alumno): ?>
            <option value="<?= $alumno['id'] ?>"><?= $alumno['nombre'] ?> <?= $alumno['apellidos'] ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <button type="submit">Ver</button>
    </form>

        </div>

        <div class="form-container">
    <h1>Listado notas medias por asignatura.</h1>

    <form action="<?= BASE_URL ?>pruebas/NotasMediasPorAsignatura/" method="post">
        <label for="id_materia">Materia:</label>
        <select name="id_materia" id="id_materia">
            <?php
                foreach ($materias as $materia) {
                    echo '<option value="' . $materia->id . '">' . $materia->nombre_materia . '</option>';
                }
            
            ?>
        </select>
        
        <br>
        <button type="submit">Ver</button>
    </form>
            </div>

            <div class="form-container">
    <h1>Listado notas medias por alumno.</h1>

    <form action="<?= BASE_URL ?>pruebas/NotasMediasPorAlumno/" method="post">
    <label for="alumno">Alumno:</label>
    <select name="alumno" id="alumno">
        <?php foreach ($alumnos as $alumno): ?>
            <option value="<?= $alumno['id'] ?>"><?= $alumno['nombre'] ?> <?= $alumno['apellidos'] ?></option>
        <?php endforeach; ?>
    </select>
    <br>
    <button type="submit">Ver</button>
    </form>
    </div>
</body>
</html>