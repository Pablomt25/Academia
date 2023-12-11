<?php
namespace Lib;

class Pages
{
    // Método para renderizar páginas
    public function render(string $pageName, array $params = null): void
    {
        // Verificar si se proporcionaron parámetros
        if ($params != null) {
            // Crear variables dinámicas a partir de los parámetros
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }

        // Incluir archivos de encabezado, contenido y pie de página
        require_once "Views/Layout/header.php";
        require_once "Views/$pageName.php";
        require_once "Views/Layout/footer.php";
    }
}
?>