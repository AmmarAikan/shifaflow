<?php

declare(strict_types=1);

namespace ShifaFlow;

final class View
{
    public static function render(string $view, array $data = [], string $layout = 'app'): never
    {
        $viewFile = dirname(__DIR__) . '/views/' . $view . '.php';
        $layoutFile = dirname(__DIR__) . '/views/layouts/' . $layout . '.php';
        if (!is_file($viewFile) || !is_file($layoutFile)) {
            throw new \RuntimeException('View not found.');
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        require $layoutFile;
        exit;
    }
}
