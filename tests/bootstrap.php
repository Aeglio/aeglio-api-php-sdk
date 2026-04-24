<?php

declare(strict_types=1);

$autoload = __DIR__.'/../vendor/autoload.php';

if (is_file($autoload)) {
    require $autoload;
    return;
}

spl_autoload_register(static function (string $class): void {
    if (!str_starts_with($class, 'Aeglio\\')) {
        return;
    }

    $baseDir = str_starts_with($class, 'Aeglio\\Tests\\')
        ? __DIR__
        : __DIR__.'/../src';

    $prefix = str_starts_with($class, 'Aeglio\\Tests\\')
        ? 'Aeglio\\Tests\\'
        : 'Aeglio\\';

    $relative = substr($class, strlen($prefix));
    $path = $baseDir.'/'.str_replace('\\', '/', $relative).'.php';

    if (is_file($path)) {
        require $path;
    }
});
