<?php
declare(strict_types=1);

namespace Calyo\Core;

final class View
{
    public static function render(string $view, array $data = [], ?string $layout = 'app'): string
    {
        $viewPath = ROOT_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout === null) return $content;

        $layoutPath = ROOT_PATH . '/app/views/layouts/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            throw new \RuntimeException("Layout not found: {$layout}");
        }
        ob_start();
        require $layoutPath;
        return (string) ob_get_clean();
    }

    public static function display(string $view, array $data = [], ?string $layout = 'app'): void
    {
        echo self::render($view, $data, $layout);
    }
}
