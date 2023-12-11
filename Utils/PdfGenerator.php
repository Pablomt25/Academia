<?php

namespace Utils;


class PDFGenerator {
    public static function renderToString(string $pageName, array $params = null): string {
        $htmlContent = '';

        if ($params != null){
            foreach ($params as $name => $value){
                $$name = $value;
            }
        }

        ob_start();
        if (!empty($params)) {
            require_once "Views/$pageName.php";
        } else {
        }
        $htmlContent = ob_get_clean();

        return $htmlContent;
    }
}