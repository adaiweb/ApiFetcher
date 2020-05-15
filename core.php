<?php 

/**
* Загрузка настроек и проверка системы
*/
$set = parse_ini_file (ROOT . 'Config/config.ini', TRUE);
version_compare (phpversion(), '7.2.11', '>=') or die ('Требуется PHP >= 7.2.11');


require_once(ROOT."Classes/Functions.class.php");

require_once(ROOT."Classes/MyRedis.class.php");
$redis = new MyRedis($set['redis']['scheme'],$set['redis']['port'],$set['redis']['host'],$set['redis']['password'],$set['redis']['expire_time']);

require_once(ROOT."Classes/YoutubeCrawler.class.php");
/**
* Системные константы
*/
define ('MT', microtime(TRUE));
define ('TIME', time());
define ('ACTION', isset($_GET['action']) ? $_GET['action'] : '');
define ('ROOT', str_replace('system/core', '', str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__))));

/**
* Основные конфигурации системы
*/
ini_set ('error_reporting', -1);  								// Включаем полное отображение ошибок
ini_set ('xhtml_errors', TRUE);   								// Включаем полное отображение ошибок xHTML разметки
ini_set ('display_errors', FALSE); 								// Включаем вывод ошибок на экран
ini_set ('ignore_repeated_errors', TRUE);       				// Выключаем повторый показ ошибок
ini_set ('session.use_trans_sid', FALSE);       				// Выключаем подстановку PHPSESSID в ссылки
ini_set ('magic_quotes_gpc', FALSE);                            // Выключаем экранирование кавычек
ini_set ('magic_quotes_runtime', FALSE);                        // Выключаем экранирование кавычек
ini_set ('magic_quotes_sybase', FALSE);                         // Выключаем экранирование кавычек
ini_set ('register_globals', FALSE);                            // Выключаем глобальные переменные
ini_set ('arg_separator.output', '&amp;');      				// Включаем переобразование & в &amp;

mb_internal_encoding ('UTF-8'); 								// Устанавливаем кодировку UTF-8
date_default_timezone_set ('Europe/Moscow'); 		// Устанавливаем временную зону
setlocale(LC_ALL, 'ru_RU.utf-8');								// Устанавливаем локализацию


/**
* Автозагрузка классов
*/
function __autoload($name) {
	
	if(file_exists(ROOT . 'Functions/' . $name . '.php')) {
		require_once ROOT . 'Functions/' . $name . '.php';
	}
}

$function = new Functions;
 
 ?>