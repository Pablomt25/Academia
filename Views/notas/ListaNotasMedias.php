<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PDF de Alumnos y Notas Medias</title>
    <link rel="stylesheet" href="CSS/notasMedias.css">
</head>
<body>
    <h1>Listado de Alumnos y Notas Medias por Asignatura</h1>
    <?php if (!empty($alumnosNotasMedias)): ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Nota Media</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alumnosNotasMedias as $alumno): ?>
                <tr>
                    <td><?= $alumno['nombre'] ?></td>
                    <td><?= $alumno['apellidos'] ?></td>
                    <td><?= number_format($alumno['nota_media'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No hay ninguna nota</p>
    <?php endif; ?>
</body>
</html>