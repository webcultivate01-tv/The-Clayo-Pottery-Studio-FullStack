<?php
declare(strict_types=1);

define('CALYO_START', microtime(true));
define('ROOT_PATH', __DIR__);

require ROOT_PATH . '/core/Bootstrap.php';

\Calyo\Core\Bootstrap::run();
