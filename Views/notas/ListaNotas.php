<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Notas</title>
    <link rel="stylesheet" href="CSS/listaCompleta.css">
</head>
<body>
    <h1>Listado de notas</h1>
    <div class="table-container">
    <?php if (!empty($notas)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Horario</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?= $nota['nombre'] ?></td>
                        <td><?= $nota['apellidos'] ?></td>
                        <td><?= $nota['horario'] ?></td>
                        <td><?= $nota['nota'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No hay ninguna nota</p>
    <?php endif; ?>
    </div>

    
</body>
</html>