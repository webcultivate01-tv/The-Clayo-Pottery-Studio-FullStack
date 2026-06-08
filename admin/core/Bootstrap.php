<?php
declare(strict_types=1);

namespace Calyo\Core;

final class Bootstrap
{
    public static function run(): void
    {
        require __DIR__ . '/Autoloader.php';
        Autoloader::register();

        $config = require ROOT_PATH . '/config/app.php';
        date_default_timezone_set($config['timezone']);

        if ($config['debug']) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        } else {
            error_reporting(0);
            ini_set('display_errors', '0');
        }
        ini_set('log_errors', '1');
        ini_set('error_log', ROOT_PATH . '/storage/logs/php-error.log');

        foreach (glob(ROOT_PATH . '/app/helpers/*.php') as $file) {
            require_once $file;
        }

        Session::start($config['session']);

        App::boot($config);

        $router = new Router();
        (require ROOT_PATH . '/routes/web.php')($router);

        try {
            $router->dispatch(new Request());
        } catch (\Throwable $e) {
            self::handleException($e, $config);
        }
    }

    private static function handleException(\Throwable $e, array $config): void
    {
        error_log($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

        if ($e instanceof Exceptions\HttpException) {
            http_response_code($e->getStatusCode());
            $code = $e->getStatusCode();
            $errorView = ROOT_PATH . "/app/views/errors/{$code}.php";
            if (file_exists($errorView)) {
                require $errorView;
                return;
            }
        }

        http_response_code(500);
        if ($config['debug']) {
            echo '<pre style="background:#fee;padding:16px;font-family:monospace;">';
            echo htmlspecialchars($e->getMessage()) . "\n\n";
            echo htmlspecialchars($e->getTraceAsString());
            echo '</pre>';
        } else {
            require ROOT_PATH . '/app/views/errors/500.php';
        }
    }
}
