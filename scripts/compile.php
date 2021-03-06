<?php

declare(strict_types=1);

$globalsFilePath = __DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

$compiledFilePath = __DIR__ . '/../src/compiled.php';

@unlink($compiledFilePath);

$replace = function ($contents, $string, $by) {
    return str_replace($string, $by, $contents);
};

$remove = function ($contents, $string) {
    return str_replace($string, '', $contents);
};

$contents = file_get_contents($globalsFilePath);
$contents = $replace($contents, 'namespace PHPUnit\Framework;', <<<'PHP'
if (defined('__PEST_GLOBAL_ASSERT_WRAPPERS__')) {
    return;
}
define('__PEST_GLOBAL_ASSERT_WRAPPERS__', true);

use PHPUnit\Framework\Assert;
PHP);
$contents = $remove($contents, 'use function func_get_args;');
$contents = $remove($contents, 'use ArrayAccess;');
$contents = $remove($contents, 'use Countable;');
$contents = $remove($contents, 'use DOMDocument;');
$contents = $remove($contents, 'use DOMElement;');
$contents = $remove($contents, 'use Throwable;');

// Fix for order of autoloading files
$contents = $replace($contents, "if (!function_exists('PHPUnit\\Framework\\", "if (!function_exists('");

file_put_contents($compiledFilePath, $contents);
