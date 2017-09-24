<?
# Вывод ошибок на экран
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

# Старт сессии
@session_start();

# Старт буфера
@ob_start();

# Автоподгрузка классов
function __autoload( $name ) { include( "./class/class_" . $name . ".php" ); }

# Подключаем конфиг 
$config = new config;

# Подключаем функции
$func = new func;

# Соединяемся с бд
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

# Заголовки
$_OPTIMIZATION = array();
$_OPTIMIZATION["title"] = "Гостевая книга";
$_OPTIMIZATION["description"] = "Гостевая книга для Softgroup";
$_OPTIMIZATION["keywords"] = "гостевая, книга, гостевая книга";
$_OPTIMIZATION["author"] = "Рыжий Александр";

# Ставим защиту на запросы от "кулхацкеров"
function check_text($text) {
	$arraysql   = array( 'UNION', 'SELECT', 'OUTFILE', 'LOAD_FILE', 'GROUP BY', 'ORDER BY', 'INFORMATION_SCHEMA.TABLES', 'BENCHMARK', 'FLOOR', 'SLEEP', 'CHAR' );
	$replacesql = '';
	$text2      = $text;
	$text2      = mb_strtoupper( $text2 );
	$text2      = str_replace( $arraysql, $replacesql, $text2, $count ) ;

	if ( $count > 0 ) { echo "Внешняя ошибка. Повторите попытку позже."; exit; }

	$array_find    = array( "'", '"', '/**/', '0x', '/*', '--' );
	$array_replace = '';
	$text          = str_replace( $array_find, $array_replace, $text );

	return $text;
}

# Проверяем запросы на наличие иньекций
foreach( $_GET as $i => $value ) { $_GET[$i]       = check_text($_GET[$i]); }
foreach( $_POST as $i => $value ) { $_POST[$i]     = check_text($_POST[$i]); }
foreach( $_COOKIE as $i => $value ) { $_COOKIE[$i] = check_text($_COOKIE[$i]); }

# Подключаем голову
include( "./inc/head.php" );

# Подключаем контент
include("./pages/index.php");

# Подключаем ноги
include("./inc/foot.php");

# Заводим контент из буфера
$content = ob_get_contents();

# Чистим буфер
ob_end_clean();
	
# Добавляем заголовки
$content = str_replace("{!TITLE!}", $_OPTIMIZATION["title"], $content);
$content = str_replace('{!DESCRIPTION!}', $_OPTIMIZATION["description"], $content);
$content = str_replace('{!KEYWORDS!}', $_OPTIMIZATION["keywords"], $content);
$content = str_replace('{!AUTHOR!}', $_OPTIMIZATION["author"], $content);

# Выводим заголовки юзверю
echo $content;

?>