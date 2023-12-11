<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas por Alumno</title>
    <link rel="stylesheet" href="CSS/listaCompleta.css">
</head>
<body>
    <h1>Notas por Alumno</h1>
    <?php if (!empty($notas)): ?>
        <table>
            <thead>
                <tr>
                    <th>Asignatura</th>
                    <th>Trimestre</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?= $nota['nombre_materia'] ?></td>
                        <td><?= $nota['trimestre'] ?></td>
                        <td><?= $nota['nota'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay ninguna nota</p>
    <?php endif; ?>
</body>
</html>