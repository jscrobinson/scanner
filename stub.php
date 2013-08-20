<?php
Phar::mapPhar('scanner.phar');
spl_autoload_register('autoloadcallback');
ini_set('display_errors',1);
function autoloadcallback($className) {
	$libPath = 'phar://scanner.phar/src/';
	$classFile = str_replace('_',DIRECTORY_SEPARATOR,$className).'.php';
	$classPath = $libPath.$classFile;
    
	if (file_exists($classPath)) {
		require($classPath);
	}
}


require_once 'phar://scanner.phar/vendor/catacgc/juice-di-container/src/Container.php';

$di = new JuiceContainer();

$optionsInterface = new Scanner_CliHandler_Option();
$CliHandler = new Scanner_CliHandler($optionsInterface);
$CliHandler->run();
__HALT_COMPILER();