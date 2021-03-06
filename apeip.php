<?php // APEIP v1.0

if(defined('APEIP_VERSION')){
	trigger_error('library before loaded', E_USER_WARNING);
	return;
}

class __apeip_data {
	static $tmp;

	static $startTime;
	static $endTime;
	static $startMemory;
	static $endMemory;
	static $dirname;
	static $dirnamedir;
	static $source = false;
	static $cwdtmpfiles = array();

	static $jsonerror;
	static $errorShow = true;
	static $errorTypeShow = array(
		true, true, false, true, true, true, true, true, false, true, true, true, true, true, true, true, true
	);
	static $errorHandler;
	static $lastError;
	static $objFile;
	static $repeat = 0;
	static $addressFunc;

	static $push = array();
	static $pushed = 0;

	static $bf = array();

	static $instJson;
	static $instHex;
	static $instBase64;
	static $instMbstr;
	static $instIconv;
	static $instUTF8;
	static $instHash;
	static $instHashHmac;
	static $instHashHkdf;
	static $instHashPbkdf2;
	static $instBcmath;
	static $instMhash;
	static $instCrypt;
	static $instRandomDiv;
	static $instUrlcoding;
	static $instMtrand;
	static $instSocket;
	static $instCOMDotNet;
	static $instInetTo;
	static $instGMP;
	static $instGMPRR;
	static $instGMPLCM;
	static $instOpenSSL;
	static $instSodium;
	static $instMcrypt;
	static $instHrTime;
	static $instZlib;
	static $instMySQLi;
	static $instPosix;
	static $instPCNTL;

	static $hasDev;
	static $hasProc;
}
class apeip {
	const version = 2.5;

	static $tmp;
	static $isMobile  = false;
	static $browserType = false;
	static $userAgent = false;
	static $SoftWare = false;
	static $isIphone = false;
	static $isIE = false;
	static $isApache = false;
	static $isNginx = false;
	static $isIIS = false;
	static $isIIS7 = false;

	static $isConsole = false;
	static $isWIN = false;
	static $isWIN7 = false;
	static $isLINUX = false;
	static $isMAC = false;

	static $requestTime = 0;
	static $loadTime = 0;
	static $memoryUsage = 0;
	static $random = 0;
	static $pid = 0;

	static $query = '';
	static $method = '';
	static $PUT = '';
	static $GET = '';
	static $POST = '';
	static $link = '';
	static $server = '';
	static $remoter = '';
	static $cookieString = '';

	static $cookie = array();
	static $includeAt = array();

	private static $occupy = '';

	public static function memof($var){
		$mem = memory_get_usage();
		$tmp = unserialize(serialize($var));
		return memory_get_usage() - $mem;
	}
	public static function runtime(){
		return microtime(true) - apeip::$requestTime;
	}
	private static function _sizeof($var){
		if(count(func_get_args()) > 1){
			$parent = func_get_arg(1);
			if(in_array($var, $parent, true))return 24;
			$parent[] = $var;
		}else $parent = array($var);
		switch(gettype($var)){
			case 'object':
				$c = strlen(get_class($var));
				foreach((array)$var as $x => $y)
					$c += (is_bool($x) || $x === null ? 1 : strlen($x)) + self::_sizeof($y, $parent);
				return $c;
			case 'array':
				$c = 0;
				foreach($var as $x => $y)
					$c += (is_bool($x) || $x === null ? 1 : strlen($x)) + self::_sizeof($y, $parent);
				return $c;
			case 'string':
			case 'integer':
			case 'float':
			case 'double':
				return strlen($var);
			default:
				return 1;
		}
	}
	public static function sizeof($var){
		return self::_sizeof($var);
	}
	public static function timeout_now(){
		trigger_error('Maximum execution time of ' . get_time_limit() . ' second exceeded', E_USER_ERROR);
	}
	public static function memoryout_now($allocate = -1){
		$limit = get_memory_limit();
		if($allocate < 0)$allocate = $limit - $allocate - 1;
		trigger_error("Allowed memory size of $limit bytes exhausted (tried to allocate $allocate bytes)");
	}
	public static function memoryout_free(){
		return get_memory_limit() - memory_get_peak_usage();
	}
	public static function timeout_free(){
		return get_time_limit() - microtime(true) + self::$requestTime;
	}
	public static function occupy($length = 0){
		if($length <= 0)return;
		self::$occupy .= str_repeat("\0", $length);
	}
}

__apeip_data::$startTime =  microtime(true);
__apeip_data::$startMemory = memory_get_usage();
__apeip_data::$dirname = __DIR__;

apeip::$includeAt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
if(!isset(apeip::$includeAt[0])){
	trigger_error('Can not run directly', E_USER_WARNING);
	exit;
}
apeip::$includeAt = apeip::$includeAt[0];
__apeip_data::$instJson = function_exists('json_encode') && function_exists('json_decode') && function_exists('json_last_error') && function_exists('json_last_error_msg');
__apeip_data::$instHex = function_exists('hex2bin') && function_exists('bin2hex');
__apeip_data::$instBase64 = function_exists('base64_encode') && function_exists('base64_decode');
__apeip_data::$instMbstr = extension_loaded('mbstring');
__apeip_data::$instIconv = extension_loaded('iconv');
__apeip_data::$instUTF8 = function_exists('utf8_encode') && function_exists('utf8_decode');
__apeip_data::$instHash = function_exists('hash') && function_exists('hash_algos');
__apeip_data::$instHashHmac = function_exists('hash_hmac') && function_exists('hash_hmac_algos');
__apeip_data::$instHashHkdf = __apeip_data::$instHashHmac && function_exists('hash_hkdf');
__apeip_data::$instHashPbkdf2 = __apeip_data::$instHashHmac && function_exists('hash_pbkdf2');
__apeip_data::$instBcmath = extension_loaded('bcmath');
__apeip_data::$instMhash = extension_loaded('mhash');
__apeip_data::$instCrypt = function_exists('crypt');
__apeip_data::$instRandomDiv = function_exists('random_bytes') && function_exists('random_int');
__apeip_data::$instUrlcoding = function_exists('urlencode') && function_exists('urldecode');
__apeip_data::$instMtrand = function_exists('mt_rand');
__apeip_data::$instSocket = extension_loaded('sockets');
__apeip_data::$instCOMDotNet = extension_loaded('com_dotnet');
__apeip_data::$instInetTo = function_exists('inet_ntop') && function_exists('inet_pton');
__apeip_data::$instGMP = extension_loaded('gmp');
__apeip_data::$instGMPRR = __apeip_data::$instGMP && function_exists('gmp_​random_​range');
__apeip_data::$instGMPLCM = __apeip_data::$instGMP && function_exists('gmp_lcm');
__apeip_data::$instOpenSSL = extension_loaded('openssl');
__apeip_data::$instSodium = extension_loaded('sodium');
__apeip_data::$instMcrypt = extension_loaded('mcrypt');
__apeip_data::$instHrTime = function_exists('hrtime');
__apeip_data::$instZlib = extension_loaded('zlib');
__apeip_data::$instMySQLi = extension_loaded('mysqli');
__apeip_data::$instPosix = extension_loaded('posix');
__apeip_data::$instPCNTL = extension_loaded('pcntl');

__apeip_data::$hasDev = file_exists('/dev/');
__apeip_data::$hasProc = file_exists('/proc/');

apeip::$isConsole = defined('STDOUT') && is_resource(STDOUT);
apeip::$isWIN = stripos(PHP_OS, 'WIN') === 0;
apeip::$isWIN7 = apeip::$isWIN && stripos(php_uname(), 'windows 7') !== false;
apeip::$isLINUX = !apeip::$isWIN && stripos(PHP_OS, 'LINUX') === 0;
apeip::$isMAC = !apeip::$isWIN && !apeip::$isLINUX && stripos(PHP_OS, 'DARWIN') === 0;

if(!defined('PHP_INT_MIN'))define('PHP_INT_MIN', ~PHP_INT_MAX);
define("APEIP_VERSION", '1.0');

apeip::$random = rand(PHP_INT_MIN, PHP_INT_MAX);
apeip::$method = getenv('REQUEST_METHOD');
apeip::$PUT = file_get_contents('php://input');
apeip::$query = getenv('QUERY_STRING');
if(apeip::$query === false){
	if(isset($_GET) && $_GET !== array())apeip::$query = http_build_query($_GET);
	elseif(isset($_POST) && $_POST !== array())apeip::$query = http_build_query($_POST);
	elseif(isset($_REQUEST))apeip::$query = http_build_query($_REQUEST);
	else apeip::$query = '';
}
if(apeip::$query === '')
	apeip::$query = apeip::$PUT;
if(apeip::$method === 'GET')
	apeip::$GET = apeip::$query;
elseif(apeip::$method === 'POST')
	apeip::$POST = apeip::$query;
apeip::$cookieString = getenv('HTTP_COOKIE');
apeip::$cookie = isset($_COOKIE) ? $_COOKIE : net::parseCookies(apeip::$cookieString);
apeip::$pid = getmypid();

apeip::$userAgent = getenv('HTTP_USER_AGENT');
apeip::$SoftWare  = getenv('SERVER_SOFTWARE');
apeip::$requestTime = isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] :
	(isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : __apeip_data::$startTime);
if(apeip::$userAgent){
	apeip::$isMobile =  strpos(apeip::$userAgent, 'Mobile')	 !== false ||
						strpos(apeip::$userAgent, 'Android')	!== false ||
						strpos(apeip::$userAgent, 'Silk/')	  !== false ||
						strpos(apeip::$userAgent, 'Kindle')	 !== false ||
						strpos(apeip::$userAgent, 'BlackBerry') !== false ||
						strpos(apeip::$userAgent, 'Opera Mini') !== false ||
						strpos(apeip::$userAgent, 'Opera Mobi') !== false;
	if(strpos(apeip::$userAgent, 'Lynx') !== false)apeip::$browserType = 'Lynx';
	elseif(strpos(apeip::$userAgent, 'Edge') !== false)apeip::$browserType = 'Edge';
	elseif(stripos(apeip::$userAgent, 'chrome') !== false)apeip::$browserType = 'Chrome';
	elseif(stripos(apeip::$userAgent, 'safari') !== false)apeip::$browserType = 'Safari';
	elseif(strpos(apeip::$userAgent, 'Win') !== false && (strpos(apeip::$userAgent, 'MSIE') !== false || strpos(apeip::$userAgent, 'Trident') !== false))apeip::$browserType = 'WINIE';
	elseif(strpos(apeip::$userAgent, 'MSIE') !== false && strpos(apeip::$userAgent, 'Mac') !== false)apeip::$browserType = 'MACIE';
	elseif(strpos(apeip::$userAgent, 'Gecko') !== false)apeip::$browserType = 'Gecko';
	elseif(strpos(apeip::$userAgent, 'Opera') !== false)apeip::$browserType = 'Opera';
	elseif(strpos(apeip::$userAgent, 'Nav') !== false && strpos(apeip::$userAgent, 'Mozilla/4.') !== false)apeip::$browserType = 'NS4';
}
if(apeip::$browserType == 'Safari' && stripos(apeip::$userAgent, 'mobile' ) !== false)apeip::$isIphone = true;
if(apeip::$browserType == 'MACIE' || apeip::$browserType == 'WINIE')apeip::$isIE = true;
if(strpos(apeip::$SoftWare, 'Apache') !== false || strpos(apeip::$SoftWare, 'LiteSpeed') !== false)apeip::$isApache = true;
if(strpos(apeip::$SoftWare, 'nginx') !== false)apeip::$isNginx = true;
if(!apeip::$isApache && (strpos(apeip::$SoftWare, 'Microsoft-IIS') !== false || strpos(apeip::$SoftWare, 'ExpressionDevServer') !== false))apeip::$isIIS = true;
if(apeip::$isIIS && (int)substr(apeip::$SoftWare, strpos(apeip::$SoftWare, 'Microsoft-IIS/') + 14) >= 7)apeip::$isIIS7 = true;

class ThumbCode {
	private static $codes = array();
	public static function register($code){
		self::$codes[] = new ThumbCode($code);
		return count(self::$codes);
	}
	public static function unregister($code){
		if(is_numeric($code) && isset(self::$codes[$code = floor($code - 1)]))
			if(self::$codes[$code] !== null){
				self::$codes[$code]->close();
				self::$codes[$code] = null;
			}
		else{
			foreach(self::$codes as &$x)
				if($x !== null && $x->code === $code){
					$x->close();
					$x = null;
					return true;
				}
			return false;
		}
		return true;
	}
	public static function exists($code){
		if(is_numeric($code) && isset(self::$codes[$code = floor($code - 1)]))
			return true;
		foreach(self::$codes as &$x)
			if($x !== null && $x->code === $code)
				return true;
		return false;
	}

	public static function shutdown($code){
		return register_shutdown_function($code);
	}

	private $code = false;
	public function __construct($func){
		$this->code = $func;
	}
	public function __destruct(){
		if($this->code){
			$code = $this->code;
			if(is_string($code) && !is_callable($code))
				eval($code);
			else
				$code();
		}
	}
	public function close(){
		$this->code = false;
	}
	public function __clone(){
		return new ThumbCode($this->code);
	}
}
function apeip_update($data = null){
//	$code = @gzinflate(file_get_contents('http://xntm.ir/lib/download.php?#php'));
//	if(!$code){
		$code = file_get_contents('https://raw.githubusercontent.com/apeip/php-openAPEIP/master/openAPEIP.php');
		if($data === true)
			$datas = file_get_contents('https://raw.githubusercontent.com/apeip/php-openAPEIP/master/contents.aped');
//	}elseif($data === true)
//		$datas = gzinflate(file_get_contents('http://xntm.ir/lib/download.php?#phpdata'));
	file_put_contents('openAPEIP.php', $code);
	if($data === true)
		file_put_contents('contents.aped', $datas);
	if(file_exists('openAPEIP.min.php'))
		file_put_contents('openAPEIP.min.php', compress_php_src($code));
	return $data === true ? strlen($code) + code($datas) : strlen($code);
}

/* ---------- Equalization PHP Version ---------- */

/*
\Throwable
├── \Exception (implements \Throwable)
│   ├── \LogicException (extends \Exception)
│   │   ├── \BadFunctionCallException (extends \LogicException)
│   │   │   └── \BadMethodCallException (extends \BadFunctionCallException)
│   │   ├── \DomainException (extends \LogicException)
│   │   ├── \InvalidArgumentException (extends \LogicException)
│   │   ├── \LengthException (extends \LogicException)
│   │   └── \OutOfRangeException (extends \LogicException)
│   └── \RuntimeException (extends \Exception)
│	   ├── \OutOfBoundsException (extends \RuntimeException)
│	   ├── \OverflowException (extends \RuntimeException)
│	   ├── \RangeException (extends \RuntimeException)
│	   ├── \UnderflowException (extends \RuntimeException)
│	   └── \UnexpectedValueException (extends \RuntimeException)
└── \Error (implements \Throwable)
	├── \APError (extends \Error)
	├── \AssertionError (extends \Error)
	├── \ParseError (extends \Error)
	├── \TypeError (extends \Error)
	│   └── \ArgumentCountError (extends \TypeError)
	└── \ArithmeticError (extends \Error)
		└── \DivisionByZeroError extends \ArithmeticError)
		*/
if(!class_exists('Error'				   )) {class Error extends Exception {}}
if(!class_exists('LogicException'		   )) {class LogicException extends Exception {}}
if(!class_exists('BadFunctionCallException')) {class BadFunctionCallException extends LogicException {}}
if(!class_exists('BadMethodCallException'  )) {class BadMethodCallException extends BadFunctionCallException {}}
if(!class_exists('DomainException'		   )) {class DomainException extends LogicException {}}
if(!class_exists('InvalidArgumentException')) {class InvalidArgumentException extends LogicException {}}
if(!class_exists('LengthException'		   )) {class LengthException extends LogicException {}}
if(!class_exists('OutOfRangeException'	   )) {class OutOfRangeExcpetion extends LogicException {}}
if(!class_exists('RuntimeException'		   )) {class RuntimeException extends Exception {}}
if(!class_exists('OutOfBoundException'	   )) {class OutOfBoundException extends RuntimeException {}}
if(!class_exists('OverflowException'	   )) {class OverflowException extends RuntimeException {}}
if(!class_exists('RangeException'		   )) {class RangeException extends RuntimeException {}}
if(!class_exists('UnderflowException'	   )) {class UnderflowException extends RuntimeException {}}
if(!class_exists('UnexpectedValueException')) {class UnexceptedValueException extends RuntimeException {}}
if(!class_exists('AssertionError'		   )) {class AssertionError extends Error {}}
if(!class_exists('ParseError'			   )) {class ParseError extends Error {}}
if(!class_exists('TypeError'			   )) {class TypeError extends Error {}}
if(!class_exists('ArgumentCountError'	   )) {class ArgumentCountError extends TypeError {}}
if(!class_exists('ArithmeticError'		   )) {class ArithmeticError extends Error {}}
if(!class_exists('DivisionByZeroError'	   )) {class DivisionByZeroError extends ArithmeticError {}}

if(!defined('JSON_HEX_TAG'				  ))define('JSON_HEX_TAG'				 ,1);
if(!defined('JSON_HEX_AMP'				  ))define('JSON_HEX_AMP'				 ,2);
if(!defined('JSON_HEX_APOS'				  ))define('JSON_HEX_APOS'				 ,4);
if(!defined('JSON_HEX_QUOT'				  ))define('JSON_HEX_QUOT'				 ,8);
if(!defined('JSON_FORCE_OBJECT'			  ))define('JSON_FORCE_OBJECT'			 ,16);
if(!defined('JSON_NUMERIC_CHECK'		  ))define('JSON_NUMERIC_CHECK'			 ,32);
if(!defined('JSON_UNESCAPED_SLASHES'	  ))define('JSON_UNESCAPED_SLASHES'		 ,64);
if(!defined('JSON_PRETTY_PRINT'			  ))define('JSON_PRETTY_PRINT'			 ,128);
if(!defined('JSON_UNESCAPED_UNICODE'	  ))define('JSON_UNESCAPED_UNICODE'		 ,256);
if(!defined('JSON_PARTIAL_OUTPUT_ON_ERROR'))define('JSON_PARTIAL_OUTPUT_ON_ERROR',512);
if(!defined('JSON_PRESERVE_ZERO_FRACTION' ))define('JSON_PRESERVE_ZERO_FRACTION' ,1024);

if(!defined('JSON_ERROR_NONE'				  ))define('JSON_ERROR_NONE'				 ,0);
if(!defined('JSON_ERROR_DEPTH'				  ))define('JSON_ERROR_DEPTH'				 ,1);
if(!defined('JSON_ERROR_STATE_MISMATCH'		  ))define('JSON_ERROR_STATE_MISMATCH'		 ,2);
if(!defined('JSON_ERROR_CTRL_CHAR'			  ))define('JSON_ERROR_CTRL_CHAR'			 ,3);
if(!defined('JSON_ERROR_SYNTAX'				  ))define('JSON_ERROR_SYNTAX'				 ,4);
if(!defined('JSON_ERROR_UTF8'				  ))define('JSON_ERROR_UTF8'				 ,5);
if(!defined('JSON_ERROR_RECURSION'			  ))define('JSON_ERROR_RECURSION'			 ,6);
if(!defined('JSON_ERROR_INF_OR_NAN'			  ))define('JSON_ERROR_INF_OR_NAN'			 ,7);
if(!defined('JSON_ERROR_UNSUPPORTED_TYPE'	  ))define('JSON_ERROR_UNSUPPORTED_TYPE'	 ,8);
if(!defined('JSON_ERROR_INVALID_PROPERTY_NAME'))define('JSON_ERROR_INVALID_PROPERTY_NAME',9);
if(!defined('JSON_ERROR_UTF16'				  ))define('JSON_ERROR_UTF16'				 ,10);

if(!defined('JSON_OBJECT_AS_ARRAY' ))define('JSON_OBJECT_AS_ARRAY' ,1);
if(!defined('JSON_BIGINT_AS_STRING'))define('JSON_BIGINT_AS_STRING',2);
if(!defined('JSON_PARSE_JAVASCRIPT'))define('JSON_PARSE_JAVASCRIPT',4);

define('DIRECTORY_NSEPARATOR', DIRECTORY_SEPARATOR == '/' ? '\\' : '/');

__apeip_data::$jsonerror = JSON_ERROR_NONE;

if(!function_exists('call_user_method_array')){
	eval('function call_user_method_array($method,$class,$params){return $class::$method(...$params);};');
}
if(!function_exists('call_user_method')){
	eval('function call_user_method($method,$class,...$params){return $class::$method(...$params);};');
}
if(!function_exists('call_user_func')){
	eval('function call_user_func($func,...$params){if(is_array($func)){$funct=$func[0];unset($func[0]);foreach($func as $f)$funct=$funct->$f;$func=$funct;}return $func(...$params);}');
}
if(!function_exists('call_user_func_array')){
	eval('function call_user_func_array($func,$params){if(is_array($func)){$funct=$func[0];unset($func[0]);foreach($func as $f)$funct=$funct->$f;$func=$funct;}return $func(...$params);}');
}
if(!function_exists('intdiv')){
	function intdiv($dividend, $divisor){
		if($divisor === 0)
			throw new DivisionByZeroError('Division by zero');
		return (int)($dividend / $divisor);
	}
}
if(!function_exists('ftok')){
	function ftok($pathname, $proj_id) {
		$st = @stat($pathname);
		if(!$st)return -1;
		return sprintf("%u", (($st['ino'] & 0xffff) | (($st['dev'] & 0xff) << 16) | (($proj_id & 0xff) << 24)));
	}
}
if(!function_exists('array_sum')){
	function array_sum($array){
		$res = 0;
		foreach($array as $x)
			$res += $x;
		return $res;
	}
}
if(!function_exists('array_product')){
	function array_product($array){
		$res = 1;
		foreach($array as $x)
			$res *= $x;
		return $res;
	}
}
if(!function_exists('class_alias')){
	function class_alias($from, $to){
		eval("class $to extends $from {}");
	}
}

class APError extends Exception {
	protected $message;
	public $HTMLMessage, $consoleMessage, $type, $from;

	const TNONE = 0;
	const TEXIT = 1;
	const TTHROW = 2;

	public static $TYPES = array(
		0  => "Notic			",
		1  => "Warning			",
		2  => "Log				",
		3  => "Status			",
		4  => "Recoverable Error",
		5  => "Syntax Error		",
		6  => "Unexpected		",
		7  => "Undefined		",
		8  => "Anonimouse		",
		9  => "System Error		",
		10 => "Secury Error		",
		11 => "Fatal Error		",
		12 => "Arithmetic Error ",
		13 => "Parse Error		",
		14 => "Type Error		",
		15 => "Network Error	",
		16 => "					"
	);

	const NOTIC = 0;
	const WARNING = 1;
	const LOG = 2;
	const STATUS = 3;
	const RECOVERABLE = 4;
	const SYNTAX = 5;
	const UNEXPECTED = 6;
	const UNDEFINED = 7;
	const ANONIMOUSE = 8;
	const SYSTEM = 9;
	const SECURY = 10;
	const FATAL = 11;
	const ARITHMETIC = 12;
	const PARSE = 13;
	const TYPE = 14;
	const NETWORK = 15;
	const TRIM = 16;

	public static function show($sh = null,$type = false){
		if($sh === null){
			if($type === false)
				__apeip_data::$errorShow = !__apeip_data::$errorShow;
			else __apeip_data::$errorTypeShow[$type] = !__apeip_data::$errorTypeShow[$type];
		}else{
			if($type === false)
				__apeip_data::$errorShow = $sh;
			else __apeip_data::$errorTypeShow[$type] = $sh;
		}
	}
	public static function handler($func){
		__apeip_data::$errorHandler = $func;
	}
	public function __construct($from, $text, $level = null, $type = null){
		if((!@__apeip_data::$errorTypeShow[$level] && $level != self::TRIM) && $type === null)return;
		$level = @self::$TYPES[$level];
		if(__apeip_data::$errorTypeShow[self::TRIM])
			$level = rtrim($level, " \t");
		$this->from = $from;
		$debug = debug_backtrace();
		$debug = end($debug);
		$this->file = $debug['file'];
		$this->line = $debug['line'];
		$console = "APEIP $level > $from: $text in {$debug['file']} on line {$debug['line']}";
		$message = "<b>APEIP $level</b> &gt; <i>$from</i>: " . nl2br($text). " in <b>{$debug['file']}</b> on line <b>{$debug['line']}</b><br />";
		$this->HTMLMessage = $message;
		$this->consoleMessage = $console;
		$this->message = "APEIP $level > $from: $text";
		__apeip_data::$lastError = $this->message;
		if(__apeip_data::$errorHandler !== null)
			if(is_callable(__apeip_data::$errorHandler))__apeip_data::$errorHandler($this);
		$errorsh = __apeip_data::$errorShow;
		if($errorsh && !$type && show_errors()){
			$headers = net::response_headers(net::HEADERS_LIST);
			if(isset($headers['Content-Type']) && $headers['Content-Type'] == 'text/plain')
				print "$console\n";
			else
				print "$message<br/>";
		}
		if($errorsh && is_string($errorsh) && (file_exists($errorsh) || touch($errorsh)))
			fadd($errorsh, $console . "\n");
		if($type !== null)
			switch($type){
				case self::TNONE:
					break;
				case self::TEXIT:
					exit;
				case self::TTHROW:
					throw $this;
			}
	}
	public function __toString(){
		return $this->message;
	}
	public static function lasterror(){
		return __apeip_data::$lastError !== null ? __apeip_data::$lastError : false;
	}
}


// -----------------------------------------------------

function var_read(){
	ob_start();
	call_user_func_array('var_dump', func_get_args());
	return ob_get_clean();
}
function swap(&$var1, &$var2, &$var3 = null, &$var4 = null, &$var5 = null, &$var6 = null, &$var7 = null, &$var8 = null, $var9 = null, $var0 = null){
	list($var2, $var1, $var4, $var3, $var6, $var5, $var8, $var7, $var0, $var9) = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0);
}
function swapright(&$var1, &$var2, &$var3 = null, &$var4 = null, &$var5 = null, &$var6 = null, &$var7 = null, &$var8 = null, $var9 = null, $var0 = null){
	if($var0 !== null)list($var0, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9) = array($var1, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0);
	elseif($var9 !== null)list($var9, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8) = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9);
	elseif($var8 !== null)list($var8, $var1, $var2, $var3, $var4, $var5, $var6, $var7) = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8);
	elseif($var7 !== null)list($var7, $var1, $var2, $var3, $var4, $var5, $var6) = array($var1, $var2, $var3, $var4, $var5, $var6, $var7);
	elseif($var6 !== null)list($var6, $var1, $var2, $var3, $var4, $var5) = array($var1, $var2, $var3, $var4, $var5, $var6);
	elseif($var5 !== null)list($var5, $var1, $var2, $var3, $var4) = array($var1, $var2, $var3, $var4, $var5);
	elseif($var4 !== null)list($var4, $var1, $var2, $var3) = array($var1, $var2, $var3, $var4);
	elseif($var3 !== null)list($var3, $var1, $var2) = array($var1, $var2, $var3);
	else list($var2, $var1) = array($var1, $var2);
}
function swapleft(&$var1, &$var2, &$var3 = null, &$var4 = null, &$var5 = null, &$var6 = null, &$var7 = null, &$var8 = null, $var9 = null, $var0 = null){
	if($var0 !== null)list($var1, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0) = array($var0, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9);
	elseif($var9 !== null)list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9) = array($var9, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8);
	elseif($var8 !== null)list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8) = array($var8, $var1, $var2, $var3, $var4, $var5, $var6, $var7);
	elseif($var7 !== null)list($var1, $var2, $var3, $var4, $var5, $var6, $var7) = array($var7, $var1, $var2, $var3, $var4, $var5, $var6);
	elseif($var6 !== null)list($var1, $var2, $var3, $var4, $var5, $var6) = array($var6, $var1, $var2, $var3, $var4, $var5);
	elseif($var5 !== null)list($var1, $var2, $var3, $var4, $var5) = array($var5, $var1, $var2, $var3, $var4);
	elseif($var4 !== null)list($var1, $var2, $var3, $var4) = array($var4, $var1, $var2, $var3);
	elseif($var3 !== null)list($var1, $var2, $var3) = array($var3, $var1, $var2);
	else list($var2, $var1) = array($var1, $var2);
}
function swapshuffle(&$var1, &$var2, &$var3 = null, &$var4 = null, &$var5 = null, &$var6 = null, &$var7 = null, &$var8 = null, &$var9 = null, &$var0 = null){
	$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0);
	shuffle($array);
	list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0) = $array;
}
function swapmin(&$var1, &$var2, &$var3 = null, &$var4 = null, &$var5 = null, &$var6 = null, &$var7 = null, &$var8 = null, &$var9 = null, &$var0 = null){
	if($var0 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0) = $array;
	}elseif($var9 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9) = $array;
	}elseif($var8 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8) = $array;
	}elseif($var7 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7) = $array;
	}elseif($var6 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6) = $array;
	}elseif($var5 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5) = $array;
	}elseif($var4 !== null){
		$array = array($var1, $var2, $var3, $var4);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4) = $array;
	}elseif($var3 !== null){
		$array = array($var1, $var2, $var3);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3) = $array;
	}elseif($var1 > $var2)
		list($var1, $var2) = array($var2, $var1);
}
function swapmax(&$var1, &$var2, &$var3 = null, &$var4 = null, &$var5 = null, &$var6 = null, &$var7 = null, &$var8 = null, &$var9 = null, &$var0 = null){
	if($var0 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var0) = array_reverse($array);
	}elseif($var9 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9) = array_reverse($array);
	}elseif($var8 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8) = array_reverse($array);
	}elseif($var7 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6, $var7);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6, $var7) = array_reverse($array);
	}elseif($var6 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5, $var6);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5, $var6) = array_reverse($array);
	}elseif($var5 !== null){
		$array = array($var1, $var2, $var3, $var4, $var5);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4, $var5) = array_reverse($array);
	}elseif($var4 !== null){
		$array = array($var1, $var2, $var3, $var4);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3, $var4) = array_reverse($array);
	}elseif($var3 !== null){
		$array = array($var1, $var2, $var3);
		sort($array, SORT_NUMERIC);
		list($var1, $var2, $var3) = array_reverse($array);
	}elseif($var1 < $var2)
		list($var1, $var2) = array($var2, $var1);
}
function theline(){
	$t = debug_backtrace();
	return array_value(end($t), 'line');
}
function thelinecall(){
	$t = debug_backtrace();
	if(!isset($t[1]))
		return false;
	return $t[1]['line'];
}
function thelinecode(){
	return array_value(explode("\n", getsource()), theline() - 1);
}
function getlinecode($line){
	return @array_value(explode("\n", getsource()), $line - 1);
}
function thefile(){
	$t = debug_backtrace();
	$t = end($t);
	return $t['file'];
}
function in_eval(){
	$t = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
	return substr($t[0]['file'], -16) == ' : eval()\'d code';
}
function thedir(){
	$t = debug_backtrace();
	$t = end($t);
	return dirname($t);
}
function thefunction(){
	$t = debug_backtrace();
	for($c = count($t) - 1; $c >= 0; --$c)
		if(isset($t[$c]['function']))
			return $t[$c]['function'];
	return false;
}
function theclass(){
	$t = debug_backtrace();
	for($c = count($t) - 1; $c >= 0; --$c)
		if(isset($t[$c]['class']))
			return $t[$c]['class'];
	return false;
}
function theargs(){
	$t = debug_backtrace();
	for($c = count($t) - 1; $c >= 0; --$c)
		if(isset($t[$c]['args']))
			return $t[$c]['args'];
	return false;
}
function themethod($last = false){
	$t = debug_backtrace();
	if($last)
		for($c = 0; isset($t[$c]); ++$c)
			if(isset($t[$c]['type']))
				return $t[$c]['type'] == '->' ? 'dynamic' : 'static';
	else
		$t = debug_backtrace();
		for($c = count($t) - 1; $c >= 0; --$c)
			if(isset($t[$c]['type']))
				return $t[$c]['type'] == '->' ? 'dynamic' : 'static';
		return false;
	return false;
}
function thethis(){
	$t = debug_backtrace();
	for($c = count($t) - 1; $c >= 0; --$c)
		if(isset($t[$c]['object']))
			return $t[$c]['object'];
	return false;
}
function thecallcode(){
	$t = debug_backtrace();
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['args']))
			$args = $t[$c]['args'];
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['function']))
			$func = $t[$c]['function'];
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['class']))
			$clas = $t[$c]['class'];
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['type']))
			$type = $t[$c]['type'];
	if(!isset($func) || !isset($args))
		return false;
	$list = array();
	foreach($args as $arg)
		$list[] = unce($arg);
	$list = $func . '(' . implode(', ', $list) . ')';
	if(isset($type) && isset($clas))
		$list = $clas . $type . $list;
	return $list;
}
function recall($object = null){
	$t = debug_backtrace();
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['args']))
			$args = $t[$c]['args'];
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['function']))
			$func = $t[$c]['function'];
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['class']))
			$clas = $t[$c]['class'];
	for($c = 0; isset($t[$c]); ++$c)
		if(isset($t[$c]['type']))
			$type = $t[$c]['type'];
	if(!isset($func) || !isset($args))
		return false;
	$list = array();
	foreach($args as $arg)
		$list[] = unce($arg);
	$list = $func . '(' . implode(', ', $list) . ')';
	if(isset($type) && isset($clas)){
		if($type == '->'){
			if(!is_object($object))
				return false;
			return eval('return $object->' . $list . ';');
		}else
			return eval("return $clas::$list;");
	}
	return eval("return $list;");
}
function thecolumn($last = false){
	$t = debug_backtrace(1, 2);
	$args = $t[0]['args'];
	$list = array();
	foreach($args as $arg)
		$list[] = preg_unce($arg);
	$list = '/thecolumn[ \n\r\t]*([ \n\r\t]*' . implode('[ \n\r\t]*,[ \n\r\t]*', $list) . '[ \n\r\t]*)/i';
	$line = thelinecode();
	preg_match($list, $line, $match);
	if($last)
		return $match === array() ? false : strpos($line, $match[0]) + strlen($match[0]);
	return $match === array() ? false : strpos($line, $match[0]);
}
function evallet(){
	if(func_num_args() === 0)
		throw new Error('Fatal error: Uncaught ArgumentCountError: Too few arguments to function evallet(), 0 passed');
	extract($GLOBALS);
	eval(func_get_arg(0));
}
function evalret($code){
	return eval('return ' . $code . ';');
}
function evalout($code){
	return eval($code);
}
function is_closure($f){
	return $f instanceof Closure;
}
function is_stdclass($f){
	return $f instanceof stdClass;
}
function is_json($json){
	return is_string($json) && ($json == 'null' || @aped::jsondecode($json, true) !== null);
}
function is_aped($obj){
	return $obj instanceof APEDString || $obj instanceof APEDFile || $obj instanceof APEDURL || $obj instanceof APED;
}
function evalstr($str){
	$res = @eval("return \"$str\";");
	if(!is_string($res))return $str;
	return $res;
}

__apeip_data::$objFile = __apeip_data::$dirname .DIRECTORY_SEPARATOR. 'contents.aped';
if(!file_exists(__apeip_data::$objFile))
	__apeip_data::$objFile = null;
function apedfile($file){
	if(file_exists($file))
		__apeip_data::$objFile = $file;
	else
		return false;
	return true;
}
function apedflush($make = false){
	aped::_aped_file_flush($make);
}
function aped($name, $length = null){
	$obj = aped::apeip_data();
	return $obj->value($name, $length);
}

function var_get($var){
	$c = array_value(file(thefile()), theline() - 1);
	if(preg_match('/var_get[\n ]*\([@\n array_value(]*\$([a-zA-Z_0-9]+), \n )*((\-\>[a-zA-Z0-9_]+)|(\:\:[a-zA-Z0-9_]+)|(\[array(^\)]+\])|(\([^\)]*\)))*\)/', $c, $s)) {
		$s[0] = substr($s[0], 9, -1);
		preg_match_all('/(\-\>[a-zA-Z0-9_]+)|(\:\:[a-zA-Z0-9_]+)|(\[array(^\)]+\])|(\([^\)]*\))/', $s[0], $j);
		$u = array();
		foreach($j[1] as $e)
			if($e)$u[] = array("caller" => '->', "type" => "object_method", "value" => substr($e, 2));
		foreach($j[2] as $e)
			if($e)$u[] = array("caller" => "::", "type" => "static_method", "value" => substr($e, 2));
		foreach($j[3] as $e)
			if($e)$u[] = array("caller" => "[]", "type" => "array_index", "value" => substr($e, 1, -1));
		foreach($j[4] as $e)
			if($e)$u[] = array("caller" => "()", "type" => "closure_call", "value" => substr($e, 1, -1));
		if(isset($s[1]))return array("type" => "variable", "short_type" => "var", "name" => $s[1], "full" => $s[0], "calls" => $u);
	}
	elseif(preg_match('/var_get[\n ]*\([@\n array_value(]*([a-zA-Z_0-9]+), \n )*\)/', $c, $s)) {
		return array("type" => "define", "short_type" => "def", "name" => $s[1]);
	}
	elseif(preg_match('/var_get[\n ]*\([@\n array_value(]*([a-zA-Z_0-9]+), \n )*\(/', $c, $s)) {
		if(preg_match('/^[fF][uU][nN][cC][tT][iI][oO][nN]$/', $s[1]))$s[1] = "function";
		return array("type" => "function", "short_type" => "closure", "name" => $s[1]);
	}
	new APError("var_get", "unsupported Type", APError::TYPE, APError::TTHROW);
}
function spl_object_count(){
	return spl_object_id(new StdClass) - 1;
}
function fvalid($file){
	$f = @fopen($file, 'r');
	if(!$f)return false;
	fclose($f);
	return true;
}
function get_resource_id($resource){
	return array_search($resource, get_resources());
}
function is_url($file){
	return filter_var($file, FILTER_VALIDATE_URL) && !file_exists($file) && fvalid($file);
}
function fcopy_implicit($from, $to, $limit = 1, $sleep = 0){
	$from = fopen($from, 'r');
	$to = fopen($to, 'w');
	if(!$from || !$to)return false;
	if($sleep > 0)
	while(($r = fread($from, $limit)) !== '') {
		fwrite($to, $r);
		usleep($sleep);
	}
	else
	while(($r = fread($from, $limit)) !== '')fwrite($to, $r);
	fclose($from);
	fclose($to);
	return true;
}
function urlinclude($url){
	$random = rand(0, 99999999) . rand(0, 99999999);
	$z = new thumbCode(function()use($random){
		@unlink("apeip$random.log");
	});
	@copy($url, "apeip$random.log");
	require "apeip$random.log";
}
function get_uploaded_file($file){
	$random = rand(0, 999999999) . rand(0, 999999999);
	if(!move_uploaded_file($file, "apeip$random.log"))return false;
	$get = fget("apeip$random.log");
	unlink("apeip$random.log");
	return $get;
}
function dateopt($date = 1){
	if($date == 2)return -19603819800; // jalaly
	if($date == 3)return -18262450800; // ghamary
	if($date == 4)return -62167219200; // time 0000-01-01T00:00:00+00:00am
	return 0; // $date == 1			// miladi
}
function timeopt($time){
	$tmp = new DateTimeZone($time);
	$tmp = new DateTime(null, $tmp);
	return $tmp->getOffset();
}
function datetimeopt($time, $date = 1){
	return timeopt($time) + dateopt($date);
}
function number_name($number, $formatter = array('B', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'), $unit = 1000, $decimal = 1, $join = ''){
	foreach($formatter as $n => $k)
		if($number < pow($unit, $n + 1) || !isset($formatter[$n + 1]))
			if($decimal < 0){
				$number /= pow($unit, $n);
				$decimal += strlen(floor($number));
				$decimal = $decimal < 0 ? -$decimal : 0;
				return round($number, $decimal) . $join . $k;
			}else return round($number / pow($unit, $n), $decimal) . $join . $k;
}
function is_serialized($data){
	return (@unserialize($data) !== false || $data == 'b:0;');
}
function is_floor($x){
	return floor($x) == (float)$x;
}
function cent_be_int($x){
	return ceil($x) != (int)$x;
}
function screenshot($url, $width = 1280, $fullpage = false, $mobile = false, $format = "PNG"){
	return file_get_contents("https://thumbnail.ws/get/thumbnail/?apikey=ab45a17344aa033247137cf2d457fc39ee4e7e16a464&url=" . urlencode($url). "&width=" . $width . "&fullpaghttps://thumbnail.ws/get/thumbnail/?apikey=ab45a17344aa033247137cf2d457fc39ee4e7e16a464&url=" . urlencode($url). "&width=" . $width . "&fullpage=" . ($fullpage ? "true" : "false"). "&moblie=" . ($mobile ? "true" : "false"). "&format=" . $format);
}
function mustbe($input, $type, $return = null){
	$types = explode('|', str_replace(array(' ', "\n", "\r", "\t"), '', strtolower($type)));
	$isarray = is_array($input);
	foreach($types as $type){
		if(($isarray && substr($type, -1) == ']' && substr($type, 0, 6) == 'array[') ||
			(is_object($input) && substr($type, 0, 7) == 'object.')){
			if($isarray)$type = substr($type, 6, -1);
			else $type = substr($type, 7);
			$type = preg_split('/\]\[|\]\.|\./', $type, 2);
			if(!isset($type[0]))continue;
			if($isarray){
				if($type[0] == '')$type[0] = 'array';
				foreach($input as $index)
					if(!mustbe($index, $type[0], true))
						continue 2;
				if(isset($type[1]))
					foreach($input as $index)
						if(!mustbe($index, $type[1], true))
							continue 2;
				return true;
			}else{
				if($type[0] == '')$type[0] = 'object';
				$input = (array)$input;
				foreach($input as $index)
					if(!isset($index) || !mustbe($index, $type[0], true))
						continue 2;
				if(isset($type[1]))
					foreach($input as $index)
						if(!mustbe($index, $type[1], true))
							continue 2;
				return true;
			}
		}
		$type = explode('&', $type);
		if(isset($type[1])){
			foreach($type as $and)
				if(!mustbe($input, $and, true))	
					continue 2;
			return true;
		}$type = $type[0];
		if($type === '')return true;
		if($type[0] == '!'){
			if(mustbe($input, substr($type, 1), true))
				continue;
			return true;
		}
		if($type[0] == '('){
			$sub = '';
			$k = 1;
			for($i = 1; isset($type[$i]); ++$i){
				if($type[$i] == '(')++$k;
				elseif($type[$i] == ')')--$k;
				if($k == 0)break;
				$sub .= $type[$i];
			}
			if(mustbe($input, $sub, true))
				return true;
			$type = substr($type, $i);
			if(mustbe($input, $type, true))
				return true;
			break;
		}
		$type = array(preg_split('/<|>|<=|>=|=|!=|\./', $type, 2), $type);
		if(isset($type[0][1])){
			$l = strlen($type[0][0]);
			$type[0][3] = substr($type[1], $l, strpos($type[1], $type[0][1]) - $l);
			$type = $type[0];
			if($type[0] != false && (float)$type[0] == $type[0])
				swap($type[0], $type[1]);
			$must = mustbe($input, $type[0]);
			if(!$must)continue;
			switch($type[3]){
				case '<':
					$must = $input < $type[1];
				break;
				case '>':
					$must = $input > $type[1];
				break;
				case '<=':
					$must = $input <= $type[1];
				break;
				case '>=':
					$must = $input >= $type[1];
				break;
				case '=':
					$must = $input == $type[1];
				break;
				case '!=':
					$must = $input != $type[1];
				break;
				case '.':
					$must = in_array($type[0], array('string', 'int', 'float', 'double', 'str', 'integer')) ? strpos($input, $type[1]) !== false : true;
				break;
			}
			if(!$must)continue;
			return true;
		}$type = $type[1];
		switch($type){
			case '':
			case 'every':
				return true;
			case 'bool':
			case 'boolean':
				if($type === true || $type === false)
					return true;
			break;
			case 'callable':
				if(is_callable($input))
					return true;
			break;
			case 'file':
				if(is_string($input) && $input !== '' && is_file($input))
					return true;
			break;
			case 'dir':
				if(is_string($input) && $input !== '' && is_dir($input))
					return true;
			break;
			case 'function':
				if(is_string($input) && $input !== '' && function_exists($input))
					return true;
			break;
			case 'class':
				if(is_string($input) && $input !== '' && class_exists($input))
					return true;
			break;
			case 'interface':
				if(is_string($input) && $input !== '' && interface_exists($input))
					return true;
			break;
			case 'trait':
				if(is_string($input) && $input !== '' && trait_exists($input))
					return true;
			break;
			case 'json':
				if(is_json($input))
					return true;
			break;
			case 'serialized':
				if(is_serialized($input))
					return true;
			break;
			case 'regex':
				if(is_regex($input))
					return true;
			break;
			case 'empty':
				if(empty($input))
					return true;
			break;
			case 'str':
			case 'string':
				if(is_string($input))
					return true;
			break;
			case 'int':
			case 'integer':
				if(is_int($input))
					return true;
			break;
			case 'float':
			case 'double':
				if(is_float($input))
					return true;
			break;
			case 'numeric':
				if(is_numeric($input))
					return true;
			break;
			case 'null':
			case 'nill':
			case 'nul':
			case 'nil':
				if($input === null)
					return true;
			break;
			case 'closure':
				if(is_callable($input) && $input instanceof Closure)
					return true;
			break;
			case 'array':
				if($isarray)
					return true;
			break;
			case 'resource':
				if(is_resource($input))
					return true;
			break;
			case 'object':
				if(is_object($input))
					return true;
			break;
			case 'iterator':
			case 'iterable':
			case 'traversable':
				if(is_iterable($input))
					return true;
			default:
				if($type != false && (float)$type == $type && length($input) == $type)
					return true;
				$type = explode(':', $type, 2);
				if(isset($type[1])){
					switch($type[0]){
						case 'object':
							if(is_object($input) && $input instanceof $type[1])
								return true;
						break;
						case 'resource':
							if(is_resource($input) && get_resource_type($input) == $type[1])
								return true;
						default:
							if(isset(__apeip_data::$musttypes[$type]))
								if(__apeip_data::$musttypes[$type]($type[0], $type[1]))
									return true;
					}
				}elseif(isset(__apeip_data::$musttypes[$type]))
					if(__apeip_data::$musttypes[$type]($type[0]))
						return true;
		}
	}
	if($return !== true){
		$trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
		if(isset($trace[1]))
			$trace = $trace[1];
		else{
			$trace = $trace[0];
			unset($trace['args'], $trace['function']);
		}
		$now = gettype($input);
		switch($now){
			case 'object':
				$now .= ':' . get_class($input);
			break;
			case 'resource':
				$now .= ':' . get_resource_type($input);
		}
		$error = new TypeError((!isset($trace['args']) ? 'The argument' : 'Argument ' . (array_search($input, $trace['args'], true) + 1)) .
			(isset($trace['function']) ? ' passed to ' . $trace['function'] . '()' : '') . ' must be an ' .
			implode(' or ', $types) . ', ' . $now . ' given');
		$error = (array)$error;
		array_shift($error["\0Error\0trace"]);
		$error["\0*\0line"] = $trace['line'];
		$error["\0*\0file"] = $trace['file'];
		$error = serialize((object)$error);
		$error = substr_replace($error, '9:"TypeError"', 2, 12);
		$error = unserialize($error);
		throw $error;
	}
	return false;
}
function get_callable_outer($callable){
	if(is_string($callable) && strpos($callable, '::') !== false)
		$callable = explode('::', $callable);
	if(is_array($callable)){
		if(!isset($callable[1]) || !isset($callable[0]) || !class_exists($callable[0]) || !method_exists($callable[0], $callable[1]))return false;
		$reflection = new ReflectionMethod($class = $callable[0], $callable = $callable[1]);
	}elseif(!is_string($callable))
		return unce($callable);
	else{
		if(!function_exists($callable))return false;
		$reflection = new ReflectionFunction($callable);
	}
	$file = $reflection->getFileName();
	if($file === false || substr($file, -16) == " : eval()'d code"){
		if(isset($class))
			return "function(){\n\treturn call_user_method_array(\$this, \"$callable\", func_get_args());\n}";
		return "function(){\n\treturn call_user_func_array(\"$callable\", func_get_args());\n}";
	}
	$code = implode('', array_slice(file($file), $start = $reflection->getStartLine() - 1, $reflection->getEndLine() - $start));
	preg_match('/function[ \n\r\t]+' . $callable . '[ \n\r\t]*\(/i', $code, $match);
	$code = substr($code, strpos($code, $match[0]));
	$i = 1;
	$q = false;
	for($c = strpos($code, '{', 10) + 1;$i !== 0 && isset($code[$c]);++$c){
		if($q == 1){
			if($code[$c] == '\\')++$c;
			elseif($code[$c] == '"')$q = false;
			continue;
		}if($q == 2){
			if($code[$c] == '\\')++$c;
			elseif($code[$c] == "'")$q = false;
			continue;
		}if($q == 3){
			if($code[$c] == '\\')++$c;
			elseif($code[$c] == '`')$q = false;
			continue;
		}
		if($code[$c] == '"')$q = 1;
		elseif($code[$c] == "'")$q = 2;
		elseif($code[$c] == '`')$q = 3;
		elseif($code[$c] == '{')++$i;
		elseif($code[$c] == '}')--$i;
	}
	if($i == 1)
		return false;
	return substr($code, 0, $c);
}
function get_callable_inner($callable){
	$outer = get_callable_outer($callable);
	return trim(substr($outer, strpos($outer, '{') + 1, -1));
}
function get_callable_header($callable){
	if(is_string($callable) && strpos($callable, '::') !== false)
		$callable = explode('::', $callable);
	if(is_array($callable)){
		if(!isset($callable[1]) || !isset($callable[0]) || !class_exists($callable[0]) || !method_exists($callable[0], $callable[1]))return false;
		$callable = new ReflectionMethod($class = $callable[0], $callable = $callable[1]);
	}elseif(!($callable instanceof ReflectionFunction || $callable instanceof ReflectionMethod))
		$callable = new ReflectionFunction($callable);
	$header = $callable instanceof ReflectionMethod ? Reflection::getModifierNames($callable->getModifiers()) . ' function ' : 'function ';
	$header .= $callable->getName() . '(';
	$pars = $callable->getParameters();
	$n = '';
	foreach($pars as $c => $par) {
		$var = '$' . $par->name;
		if($t = method_exists($par, 'isDefaultValueAvailable') && $par->isDefaultValueAvailable())$var .= ' = ' . unce($par->getDefaultValue());
		if($par->isPassedByReference())$var = '&' . $var;
		if(method_exists($par, 'isVariadic') && $par->isVariadic())$var = '...' . $var;
		if(method_exists($par, 'hasType') && $par->hasType())$var = $par->getType()->__toString() . ' ' . $var;
		if($c != 0)$var = ', ' . $var;
		if(!$t && $par->isOptional()){
			$var = ' [' . $var;
			$n .= ']';
		}
		$header .= $var;
	}
	$header .= $n . ')';
	if($callable->hasReturnType())
		$header .= ':' . $callable->getReturnType;
	return $header;
}
function closure_of_callable($callable){
	if(is_string($callable) && strpos($callable, '::') !== false)
		$callable = explode('::', $callable);
	if(is_array($callable)){
		if(!isset($callable[1]) || !isset($callable[0]) || !class_exists($callable[0]) || !method_exists($callable[0], $callable[1]))return false;
		$callable = new ReflectionMethod($class = $callable[0], $callable = $callable[1]);
	}else $callable = new ReflectionFunction($callable);
	return $callable->getClosure();
}
function get_callable_args($callable, $onlyname = false){
	if(is_string($callable) && strpos($callable, '::') !== false)
		$callable = explode('::', $callable);
	if(is_array($callable)){
		if(!isset($callable[1]) || !isset($callable[0]) || !class_exists($callable[0]) || !method_exists($callable[0], $callable[1]))return false;
		$callable = new ReflectionMethod($class = $callable[0], $callable = $callable[1]);
	}elseif(!($callable instanceof ReflectionFunction || $callable instanceof ReflectionMethod))
		$callable = new ReflectionFunction($callable);
	$pars = $callable->getParameters();
	$p = array();
	foreach($pars as $c => $par) {
		$parr = (array)$par;
		if($onlyname){
			$p[$c] = $parr['name'];
			continue;
		}
		$p[$c] = array("name" => $parr['name']);
		if(method_exists($par, 'isDefaultValueAvailable') && $par->isDefaultValueAvailable())$p[$c]["default"] = $par->getDefaultValue();
		if(method_exists($par, 'hasType') && $par->hasType())$p[$c]["type"] = $par->getType()->__toString();
		$p[$c]["optional"] = $par->isOptional();
		$p[$c]["variadic"] = method_exists($par, 'isVariadic') && $par->isVariadic();
		$p[$c]["passed"] = $par->isPassedByReference();
	}
	return $p;
}
function get_callable_arg($callable, $arg){
	if(is_string($callable) && strpos($callable, '::') !== false)
		$callable = explode('::', $callable);
	if(is_array($callable)){
		if(!isset($callable[1]) || !isset($callable[0]) || !class_exists($callable[0]) || !method_exists($callable[0], $callable[1]))return false;
		$callable = new ReflectionMethod($class = $callable[0], $callable = $callable[1]);
	}elseif(!($callable instanceof ReflectionFunction || $callable instanceof ReflectionMethod))
		$callable = new ReflectionFunction($callable);
	$par = $callable->getParameters();
	if(!isset($par[$arg]))return false;
	$par = $par[$arg];
	$p = array();
	$parr = (array)$par;
	$p = array("name" => $parr['name']);
	if(method_exists($par, 'isDefaultValueAvailable') && $par->isDefaultValueAvailable())$p["default"] = $par->getDefaultValue();
	if(method_exists($par, 'hasType') && $par->hasType())$p["type"] = $par->getType()->__toString();
	$p["optional"] = $par->isOptional();
	$p["variadic"] = method_exists($par, 'isVariadic') && $par->isVariadic();
	$p["passed"] = $par->isPassedByReference();
	return $p;
}
function call_class_constructor($classname){
	if(is_object($classname))
		$classname = get_class($classname);
	$params = func_get_args();
	unset($params[0]);
	$args = $params === array() ? '' : '$params[' . implode('],$params[', array_keys($params)) . ']';
	eval('$object = new ' . $classname . '(' . $args . ');');
	return $object;
}
function call_class_constructor_array($classname, $params = array()){
	if(is_object($classname))
		$classname = get_class($classname);
	$args = '$params[' . implode('],$params[', array_keys($params)) . ']';
	eval('$object = new ' . $classname . '(' . $args . ');');
	return $object;
}
function unce($data){
	switch(gettype($data)) {
	case 'NULL':
		return 'NULL';
		break;
	case 'boolean':
		if($data)return 'true';
		return 'false';
		break;
	case 'string':
		return '"' . str_replace(array('\\', '"'), array('\\\\', '\\"'), $data). '"';
		break;
	case 'integer':
	case 'double':
		return "$data";
		break;
	case 'array':
		$arr = '[';
		$c = 0;
		foreach($data as $k => $v) {
			if($k === $c) {
				$arr.= unce($v). ',';
				++$c;
			}
			else $arr.= unce($k). '=>' . unce($v). ',';
		}
		if($arr == '[')return '[]';
		return substr($arr, 0, -1). ']';
		break;
	case 'object':
		if(is_stdclass($data)) {
			$arr = '{';
			foreach($data as $k => $v) {
				$arr.= unce($k). ':' . unce($v). ',';
			}
			if($arr == '{')return '{}';
			return substr($arr, 0, -1). '}';
		}
		elseif(is_closure($data)) {
			$r = new ReflectionFunction($data);
			$pare = $r->getParameters();
			$pars = array();
			foreach($pare as $k => $p) {
				$pars[$k] = ' *';
				if(method_exists($p, 'hasType') && $p->hasType())$pars[$k].= $p->getType()->__toString(). ' *';
				if(method_exists($p, 'isVariadic') && $p->isVariadic())$pars[$k].= '\.\.\. *';
				$pars[$k].= '\&{0,1} *\$' . $p->getName(). ' *';
				if(method_exists($p, 'isDefaultValueAvailable') && $p->isDefaultValueAvailable())$pars[$k].= '= *' . preg_unce($p->getDefaultValue()). ' *';
			}
			$pars = implode(',', $pars);
			$sts = $r->getStaticVariables();
			$stc = array();
			foreach($sts as $k => $v)$stc[] = " *\&{0,1} *\\$$k *";
			if($stc === array())$stc = '';
			else $stc = ' *use\(' . implode(',', $stc). '\)';
			$typa = '';
			if(method_exists($r, 'hasReturnType') && $r->hasReturnType())$typa = " *: *$type";
			$name = $r->getName();
			$name = $name[0] == '{' ? '' : $name;
			$file = file($r->getFileName());
			if($file === false)
				return false;
			$file = implode('', array_slice($file, $start = $r->getStartLine() - 1, $r->getEndLine() - $start));
			$m = preg_match("/function *$name\($pars\)$stc$typa *\{/", $file, $pa);
			if(!$m)
				return false;
			$po = strpos($file, $pa[0]);
			$file = substr($file, $po + strlen($pa[0]));
			$x = 0;
			$a = false;
			$b = '';
			for($o = 0; isset($file[$o]); ++$o) {
				if($x < 0)break;
				if(!$a) {
					if($file[$o] == '{')++$x;
					elseif($file[$o] == '}')--$x;
					elseif($file[$o] == '"' || $file[$o] == "'") {
						$a = true;
						$b = $file[$o];
					}
				}
				else {
					if($file[$o] == $b)$a = false;
				}
			}
			--$o;
			$file = substr($file, 0, $o);
			return $pa[0] . $file . '}';
		}
	}
}
function preg_unce($data){
	switch(gettype($data)) {
	case 'NULL':
		return '[nN][uU][lL][lL]';
		break;
	case 'boolean':
		if($data)return '[tT][rR][uU][eE]';
		return '[fF][aA][lL][sS][eE]';
		break;
	case 'string':
		return '[\"\\\']\Q' . str_replace('\E', '\E\\\E\Q', $data). '\E[\"\\\']';
		break;
	case 'integer':
	case 'double':
		return "$data";
		break;
	case 'array':
		$arr = '\[ *';
		$c = 0;
		foreach($data as $k => $v) {
			if($k === $c) {
				$arr.= preg_unce($v). ' *\,';
				++$c;
			}
			else $arr.= preg_unce($k). ' *\=\> *' . preg_unce($v). ' *\, *';
		}
		if($arr == '\[ *')return '\[ *\]';
		return substr($arr, 0, -4). '\]';
		break;
	case 'object':
		if(is_stdclass($data)) {
			$arr = '\{ *';
			foreach($data as $k => $v) {
				$arr.= preg_unce($k). ' *: *' . preg_unce($v). ' *\, *';
			}
			if($arr == '\{ *')return '\{ *\}';
			return substr($arr, 0, -4). '\}';
		}
		elseif(is_closure($data)) {
			$r = new ReflectionFunction($data);
			$pare = $r->getParameters();
			$pars = array();
			foreach($pare as $k => $p) {
				$pars[$k] = ' *';
				if(method_exists($p, 'hasType') && $p->hasType())$pars[$k].= $p->getType()->__toString(). ' *';
				if(method_exists($p, 'isVariadic') && $p->isVariadic())$pars[$k].= '\.\.\. *';
				$pars[$k].= '\&{0,1} *\$' . $p->getName(). ' *';
				if(method_exists($p, 'isDefaultValueAvailable') && $p->isDefaultValueAvailable())$pars[$k].= '= *' . preg_unce($p->getDefaultValue()). ' *';
			}
			$pars = implode(',', $pars);
			$sts = $r->getStaticVariables();
			$stc = array();
			foreach($sts as $k => $v)$stc[] = " *\&{0,1} *\\$$k *";
			if($stc === array())$stc = '';
			else $stc = ' *use\(' . implode(',', $stc). '\)';
			$typa = '';
			if($r->hasReturnType())$typa = " *: *$type";
			$name = $r->getName();
			$name = $name[0] == '{' ? '' : $name;
			$file = file($r->getFileName());
			$file = implode('', array_slice($file, $start = $r->getStartLine() - 1, $r->getEndLine() - $start));
			$m = preg_match("/function *$name\($pars\)$stc$typa *\{/", $file, $pa);
			if(!$m)
				return false;
			$po = strpos($file, $pa[0]);
			$file = substr($file, $po + strlen($pa[0]));
			$x = 0;
			$a = false;
			$b = '';
			for($o = 0; isset($file[$o]); ++$o) {
				if($x < 0)break;
				if(!$a) {
					if($file[$o] == '{')++$x;
					elseif($file[$o] == '}')--$x;
					elseif($file[$o] == '"' || $file[$o] == "'") {
						$a = true;
						$b = $file[$o];
					}
				}
				else {
					if($file[$o] == $b)$a = false;
				}
			}
			--$o;
			$file = substr($file, 0, $o);
			$file = str_replace(array('\\', '/', '[', ']', '{', '}', '(', ')', '.', '$', '^', ',', '?', '<', '>', '+', '*', '&', '|', '!', '-', '#'),
				array('\\\\', '\/', '\[', '\]', '\{', '\}', '\(', '\)', '\.', '\$', '\^', '\,', '\?', '\<', '\>', '\+', '\*', '\&', '\|', '\!', '\-', '\#'), $file);
			return "function *$name\($pars\)$stc$typa *\{ *$file *\}";
		}
	}
}
function userip(){
	$env = array(getenv('HTTP_CLIENT_IP'), getenv('HTTP_X_FORWARDED'), getenv('HTTP_X_FORWARDED_FOR'), getenv('REMOTE_ADDR'));
	if($env[0])return $env[0];
	if($env[1])return $env[1];
	if($env[2])return $env[2];
	if($env[3])return $env[3];
	return '127.0.0.1';
}
function is_regex($x){
	return @preg_match($x, null) !== false;
}
function is_ereg($x){
	return @ereg($x, null) !== false;
}
function filestate($filename){
	$f = fopen($filename, 'r');
	if(!$f){
		new APError("filestate", "No such file or directory.", APError::NOTIC);
		return false;
	}
	$s = fstat($f);
	fclose($f);
	return $s;
}
define('UNICODE_CHARS',0);
define('UNICODE_ALL',1);
define('UNICODE_UTF',2);
function unicode_encode($str,$charset = 'UTF-8',$type = 2){
	$str = str_replace('\u','\\\u',$str);
	$str = iconv($charset,'gbk',$str);
	preg_match_all('/[\x80-\xff]?./',$str,$chars);
	foreach($chars[0] as &$c){
		$c = iconv('gbk','UTF-8',$c);
		switch(strlen($c)) {
			case 1:
				$n = ord($c[0]);
			break;
			case 2:
				$n = (ord($c[0]) & 0x3f) << 6;
				$n += ord($c[1]) & 0x3f;
			break;
			case 3:
				$n = (ord($c[0]) & 0x1f) << 12;
				$n += (ord($c[1]) & 0x3f) << 6;
				$n += ord($c[2]) & 0x3f;
			break;
			case 4:
				$n = (ord($c[0]) & 0x0f) << 18;
				$n += (ord($c[1]) & 0x3f) << 12;
				$n += (ord($c[2]) & 0x3f) << 6;
				$n += ord($c[3]) & 0x3f;
			break;
		}
		switch($type){
			case UNICODE_CHARS:
				$c = math::decstr($n);
			break;
			case UNICODE_ALL:
				$c = '\u'.str_pad(strtoupper(base_convert($n,10,16)),4,'0',STR_PAD_LEFT);
			break;
			case UNICODE_UTF:
				if(strlen($c) != 1)
					$c = '\u'.str_pad(strtoupper(base_convert($n,10,16)),4,'0',STR_PAD_LEFT);
			break;
		}
	}
	return implode('',$chars[0]);
}
function unicode_decode($str){
	return str_replace('\\\u','\u',preg_replace_callback('/(?<!\\\\)\\\\u([0-9a-fA-F]{4})/',function($x){
		$c = base_convert($x[1], 16, 10);
		$str = "";
		if($c < 0x80)
			$str .= chr($c);
		else if($c < 0x800) {
			$str .= chr(0xC0 | $c>>6);
			$str .= chr(0x80 | $c & 0x3F);
		} else if($c < 0x10000) {
			$str .= chr(0xE0 | $c>>12);
			$str .= chr(0x80 | $c>>6 & 0x3F);
			$str .= chr(0x80 | $c & 0x3F);
		} else if($c < 0x200000) {
			$str .= chr(0xF0 | $c>>18);
			$str .= chr(0x80 | $c>>12 & 0x3F);
			$str .= chr(0x80 | $c>>6 & 0x3F);
			$str .= chr(0x80 | $c & 0x3F);
		}
		return $str;
	},$str));
}
function push($x){
	__apeip_data::$push[$p = __apeip_data::$pushed++] = $x;
	return $p;
}
function ppush($x){
	__apeip_data::$push[$p = __apeip_data::$pushed === 0 ? 0 : __apeip_data::$pushed - 1] = $x;
	return $p;
}
function pop(){
	return __apeip_data::$push[__apeip_data::$pushed === 0 ? 0 : --__apeip_data::$pushed];
}
function peek(){
	return __apeip_data::$push[__apeip_data::$pushed];
}
function stack_usage(){
	return __apeip_data::$pushed;
}
function stack_locate(){
	return count(__apeip_data::$push);
}
function stack_reset(){
	__apeip_data::$push = array();
	__apeip_data::$pushed = 0;
}
function stack_delete(){
	$l = count(__apeip_data::$push);
	if($l === 0)return false;
	unset(__apeip_data::$push[$l - 1]);
	return true;
}
function stack_gcc(){
	$c = __apeip_data::$pushed;
	while(isset(__apeip_data::$push[++$c]))
		unset(__apeip_data::$push[$c]);
	return $c - __apeip_data::$pushed - 1;
}
/*
function xnfread($stream,$length = 1){
	if(!is_resource($stream))return false;
	$read = '';
	for($c = 0;($l = strlen($read)) < $length;++$c){
		$get = stream_get_contents($stream,$length - $l);
		if($get === false || ($get === '' && $c < 0))
			return $read;
		elseif($get === '')--$c;
		else $read .= $get;
	}
	return $read;
}
function xnfgetc($stream){
	if(!is_resource($stream))return false;
	$r = fgetc($stream);
	while($r === '')
		$r = fgetc($stream);
	return $r;
}
function xnfgets($stream){
	if(!is_resource($stream))return false;
	$r = fgets($stream);
	while($r === '' && $r[strlen($r) - 1] !== "\n"){
		if($r === false)
			return false;
		$r .= fgets($stream);
	}
	return $r;
}
function xnfgetss($stream){
	if(!is_resource($stream))return false;
	$r = fgetss($stream);
	while($r === '' && $r[strlen($r) - 1] !== "\n"){
		if($r === false)
			return false;
		$r .= fgetss($stream);
	}
	return $r;
}
function xnfwrite($stream,$content = '',$length = -1){
	if($length == -1)
		$length = strlen($content);
	else $content = substr($content,$length);
	if($length === 0)return 0;
	$w = fwrite($stream,$content,$length);
	if($w === false)return false;
	for($c = 0;$w < $length;++$c){
		$n = fwrite($stream,substr($content,$w),$length - $w);
		if($n === false || ($n === 0 && $c < 0))
			return $n === false && $w == 0?false:$n;
		elseif($n === 0)
			--$c;
		else $w += $n;
	}
	return $w;
}
function socket_connect_socks5($socket, $address, $port, $username = null,$password = null){
	if(!is_resource($socket))return false;
	if($username && $password)
		fwrite($socket,"\x05\x02\x00\x02");
	else fwrite($socket,"\x05\x01\x00");
	$version = ord(fgetc($socket));
	$method = ord(fgetc($socket));
	if($version != 5){
		new APError("socket_connect_socks5", "Wrong SOCKS5 version: $version", APError::NOTIC);
		return false;
	}
	if($method == 5){
		fwrite($socket,"\x01".chr(strlen($username)).$username.chr(strlen($password)).$password);
		$version = ord(fgetc($socket));
		if($version !== 1){
			new APError("socket_connect_socks5", "Wrong authorized SOCKS version: $version", APError::NOTIC);
			return false;
		}
		$result = ord(fgetc($socket));
		if($result !== 0){
			new APError("socket_connect_socks5", "Wrong authorization status: $version", APError::NOTIC);
			return false;
		}
	}elseif($method !== 0){
		new APError("socket_connect_socks5", "Wrong method: $method", APError::NOTIC);
		return false;
	}
	$data = "\x05\x01\x00";
	if(filter_var($server,FILTER_VALIDATE_IP)){
		$ip = crypt::inet_pton($server);
		$data .= (strlen($ip) == 4?"\x01":"\x04").$ip;
	}else
		$data .= "\x03".chr(strlen($server)).$server;
	$data .= chr($port/256).chr($port);
	fwrite($socket,$data);
	$version = ord(fgetc($socket));
	if($version != 5){
		new APError("socket_connect_socks5", "Wrong SOCKS5 version: $version", APError::NOTIC);
		return false;
	}
	$rep = ord(fgetc($socket));
	if($rep !== 0){
		new APError("socket_connect_socks5", "Wrong SOCKS5 rep: $rep", APError::NOTIC);
		return false;
	}
	$rsv = ord(fgetc($socket));
	if($rsv !== 0){
		new APError("socket_connect_socks5", "Wrong socks5 final RSV: $rsv", APError::NOTIC);
		return false;
	}
	switch(ord(fgetc($socket))){
		case 1:
			$ip = crypt::inet_ntop(fread($socket,4));
		break;
		case 4:
			$ip = crypt::inet_ntop(fread($socket,16));
		break;
		case 3:
			$ip = fread($socket,ord(fgetc($socket)));
		break;
	}
	$port = ord(fgetc($socket)) * 256 + ord(fgetc($socket));
	return "$ip:$port";
}
function xnloop($loop = -1,$file = null,$wait = null,$close = null){
	if(!$file)$file = thefile();
	$file = net::webpath($file);
	$headers = request_headers();
	if(!isset($headers["apeiploop-Now"]) && $loop != -1)
		$headers["apeiploop-Now"] = $loop;
	elseif(isset($headers["apeiploop-Now"])){
		--$headers["apeiploop-Now"];
		if($headers["apeiploop-Now"] == 0)
			return 2;
	}
	$loop = @fsockopen((getenv('HTTPS') ? 'tls' : 'tcp').'://'.getenv('SERVER_NAME'),getenv('SERVER_PORT'));
	if(!$loop){
		new APError("apeiploop", "Can not looping file $file", APError::WARNING);
		return false;
	}
	$header = '';
	foreach($headers as $key=>$value)
		$header .= "$key: $value\r\n";
	fwrite($loop,get_request_title()."\r\n".$header."\r\n".get_request_query());
	if($wait){
		fgetc($loop);
		fclose($loop);
	}
	if($close)
		exit;
	return 1;
}
function xnloope($loop = null, $file = null, $wait = null, $close = null){
	register_shutdown_function(function()use($loop, $file, $wait, $close){
		xnloop($loop, $file, $wait, $close);
	});
}
*/
if(!defined("PUBLICDIR"))define('PUBLICDIR', substr(thefile(), 0, -strlen(getenv('SCRIPT_NAME')) + 1));
function thelink($replacement = null){
	if(is_string($replacement))
		$replacement = array('path' => $replacement);
	if(!isset($replacement['scheme']))
		$replacement['scheme'] = getenv('HTTPS') ? 'https' : 'http';
	else
		$replacement['scheme'] = strtolower($replacement['scheme']);
	if(!isset($replacement['host']))
		$replacement['host'] = getenv('SERVER_NAME');
	if(!isset($replacement['port']))
		$replacement['port'] = getenv('SERVER_PORT');
	if(($replacement['scheme'] == 'http' && $replacement['port'] == 80) || ($replacement['scheme'] == 'https' && $replacement['port'] == 443))
		$replacement['port'] = false;
	if(!isset($replacement['path']))
		$replacement['path'] = getenv('SCRIPT_NAME');
	else
		$replacement['path'] = net::realpath($replacement['path']);
	if(!isset($replacement['query']) || $replacement['query'] === true)
		$replacement['query'] = apeip::$query;
	elseif(is_array($replacement['query']))
		$replacement['query'] = http_build_query($replacement['query']);
	return $replacement['scheme'] . '://' . $replacement['host'] . ($replacement['port'] ? ':' . $replacement['port'] : '')
		. $replacement['path'] . ($replacement['query'] ? '?' . $replacement['query'] : '');
}
apeip::$link = thelink();
function open_class($name,&$return = 53348987487374){
	$input = func_get_args();
	unset($input[0], $input[1]);
	$class = unserialize("O:".strlen($name).":\"$name\":0:{}");
	if($input === array() && $return === 53348987487374)
		return $class;
	$input[1] = $class;
	$return = call_user_func_array('call_constructor', $input);
	return $class;
}
function call_constructor($class){
	$args = func_get_args($class);
	unset($args[0]);
	if(method_exists($class,"__construct"))
		return call_user_method_array('__construct', $class, $args);
}
function is_incomplete_class($x){
	return $x instanceof __PHP_Incomplete_Class;
}
define("PHP_INT_BITS", PHP_INT_SIZE * 8);
function create_stream_content($content, $mime_type = 'text/plain', $mode = 'rw+b'){
	return fopen("data://$mime_type," . urlencode($content),$mode);
}
function goline($x, $seek = null){
	$source = explode("\n", getsource());
	if($seek === 1)$x += theline();
	elseif($seek === 2)$x = count($source) - $x;
	else --$x;
	$code = implode("\n",array_slice($source,$x));
	eval($code);exit;
}
function getsource(){
	if(__apeip_data::$source === false)
		__apeip_data::$source = fget(thefile());
	return __apeip_data::$source;
}
if(file_exists('autoinclude.php')){
	try{
		require 'autoinclude.php';
	}catch(Error $e){
		$msg = $e->getMessage() . ' in line ' . $e->getLine() . ' on file ' . $e->getFile();
		$msg = "\n\t" . str_replace("\n", "\n\t", $msg) . "\n";
		new APError("apeipAutoLoadFile", "error {$msg}");
	}
}
if(file_exists(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'autoincludeall.php')){
	try{
		require __apeip_data::$dirname . DIRECTORY_SEPARATOR . 'autoincludeall.php';
	}catch(Error $e){
		$msg = $e->getMessage() . ' in line ' . $e->getLine() . ' on file ' . $e->getFile();
		$msg = "\n\t" . str_replace("\n", "\n\t", $msg) . "\n";
		new APError("apeipAutoLoadFileAll", "error {$msg}");
	}
}
function substring($str, $from, $to = null){
	if($to === null)
		return substr($str, $from);
	return substr($str, $from, $to - $from);
}
function server_ipv6(){
	if(defined('SERVER_IPV6'))
		return SERVER_IPV6;
	$r = (bool)@file_get_contents('http://v6.ipv6-test.com/api/myip.php');
	define('SERVER_IPV6', $r);
	return $r;
}
apeip::$remoter = getenv('REMOTE_ADDR');
apeip::$remoter = (net::isipv6(apeip::$remoter) ? '[' . apeip::$remoter . ']' : apeip::$remoter) . ':' . getenv('REMOTE_PORT');
apeip::$server = getenv('SERVER_ADDR');
apeip::$server = (net::isipv6(apeip::$server) ? '[' . apeip::$server . ']' : apeip::$server) . ':' . getenv('SERVER_PORT');

function length($input){
	switch(gettype($input)){
		case 'array':
			return count($input);
		case 'object':
			return count((array)$input);
		case 'string':
		case 'integer':
		case 'float':
		case 'double':
			return strlen($input);
		default:
			return 0;
	}
}
function destruct_call($object){
	return method_exists($object, '__destruct') ? $object->__destruct() : null;
}
function lsort(array &$array){
	array_multisort(array_map('strlen', $array), SORT_ASC, SORT_NUMERIC, $array);
	$array = array_reverse($array);
}
function lrsort(array &$array){
	array_multisort(array_map('strlen', $array), SORT_ASC, SORT_NUMERIC, $array);
}
function lksort(array &$array){
	array_multisort(array_map('strlen', array_keys($array)), SORT_ASC, SORT_NUMERIC, $array);
	$array = array_reverse($array);
}
function lrksort(array &$array){
	array_multisort(array_map('strlen', array_keys($array)), SORT_ASC, SORT_NUMERIC, $array);
}
function cwdtmpfile(){
	do{
		$file = 'php.'.rand(0, 999999999).rand(0, 999999999).rand(0, 999999999).'.tmp';
	}while(file_exists($file));
	ThumbCode::register(function()use($file){
		@unlink($file);
	});
	return fopen($file,'r+b');
}
function filemime($file){
	$finfo = finfo_open(FILEINFO_MIME);
	$mime = finfo_file($finfo, $file);
	finfo_close($finfo);
	return $mime;
}
function buffermime($buffer){
	$finfo = finfo_open(FILEINFO_MIME);
	$mime = finfo_buffer($finfo, $buffer);
	finfo_close($finfo);
	return $mime;
}

if(!defined('DATE_ATOM'   ))define('DATE_ATOM'   ,'Y-m-d\TH:i:sP'   );
if(!defined('DATE_COOKIE' ))define('DATE_COOKIE' ,'l, d-M-Y H:i:s T');
if(!defined('DATE_ISO8601'))define('DATE_ISO8601','Y-m-d\TH:i:sO'   );
if(!defined('DATE_RFC822' ))define('DATE_RFC822' ,'D, d M y H:i:s O');
if(!defined('DATE_RFC850' ))define('DATE_RFC850' ,'l, d-M-y H:i:s T');
if(!defined('DATE_RFC1036'))define('DATE_RFC1036','D, d M y H:i:s O');
if(!defined('DATE_RFC1123'))define('DATE_RFC1123','D, d M Y H:i:s O');
if(!defined('DATE_RFC2822'))define('DATE_RFC2822','D, d M Y H:i:s O');
if(!defined('DATE_RFC3339'))define('DATE_RFC3339','Y-m-d\TH:i:sP'   );
if(!defined('DATE_RSS'	  ))define('DATE_RSS'	 ,'D, d M Y H:i:s O');
if(!defined('DATE_W3C'	  ))define('DATE_W3C'	 ,'Y-m-d\TH:i:sP'   );

define('MAX_NUMBER', 1.7976931348623e+308);

function is_stream($stream){
	return is_resource($stream) && strtolower(get_resource_type($stream)) == 'stream';
}
/*
class XNTelegram {
	public $session = array(), $settings = array(), $history = array(), $elements = array(), $flush = array(), $socket;

	// constants
	const VERSION = '1';
	const VERSION_CODE = 1;

	const SERIALIZATION_COMPRESS = 1;
	const SERIALIZATION_BASE64 = 2;
	
	const SESSION_FLUSH = 1;
	const SESSION_CONNECT = 2;
	const SESSION_SELF = 4;
	const SESSION_TIMER = 8;
	const SESSION_APPDATA = 16;
	const SESSION_LOGIN = 32;
	const SESSION_SETTINGS = 64;
	
	public function __construct($settings = null){
		if($settings !== null)
			$this->parse_settings($settings);
	}

	// crypt
	public function aescalc($msg, $auth, $to_server = true){
		$x = $to_server ? 0 : 8;
		$a = crypt::hash('sha256', $msg.substr($auth, $x, 36), true);
		$b = crypt::hash('sha256', substr($key, 40 + $x, 36).$msg, true);
		$key = substr($a, 0, 8).substr($b, 8, 16).substr($a, 24, 8);
		$iv = substr($b, 0, 8).substr($a, 8, 16).substr($b, 24, 8);
		return array($key, $iv);
	}
	public function old_aescalc($msg, $auth, $to_server = true){
		$x = $to_server ? 0 : 8;
		$a = sha1($msg.substr($auth, $x, 32), true);
		$b = sha1(substr($auth, 32 + $x, 16).$msg.substr($auth, 48 + $x, 16), true);
		$c = sha1(substr($auth, 64 + $x, 32).$msg, true);
		$d = sha1($msg.substr($auth, 96 + $x, 32), true);
		$key = substr($a, 0, 8).substr($b, 8, 12).substr($c, 4, 12);
		$iv = substr($a, 8, 12).substr($b, 0, 8).substr($c, 16, 4).substr($d, 0, 8);
		return array($key, $iv);
	}
	
	// elements parser
	public function load_elements(){
		if(isset($this->settings['elements']['file']) && is_string($this->settings['elements']['file']) && ($file = $this->settings['elements']['file']) &&
			file_exists($file) && ($data = file_get_contents($file)) && ($data = aped::jsondecode($data, true)));
		elseif(isset($this->settings['elements']['file']) && is_array($this->settings['elements']['file']) && $data = $this->settings['elements']['file']);
		elseif(($data = file_get_contents('https://core.telegram.org/scheme/json')) && ($data = aped::jsondecode($data, true))){
			foreach($data['methods'] as &$method){
				$pars = array();
				foreach($method['params'] as $param)
					$pars[$param['name']] = $param['type'];
				$method['params'] = $pars;
			}
			foreach($data['constructors'] as &$constructor){
				$pars = array();
				foreach($constructor['params'] as $param)
					$pars[$param['name']] = $param['type'];
				$constructor['params'] = $pars;
			}
		}else new APError("apeipTelegram loadElements", "can not Connect to https://core.telegram.org", APError::NETWORK, APError::TTHROW);
		if(isset($data['flush']))
			unset($data['flush']);
		$this->elements = $data;
		if(isset($this->settings['elements']['flush']) && $this->settings['elements']['flush'])
			return $this->flush_elements(isset($this->settings['elements']['level']) ? $this->settings['elements']['level'] : 1);
		if(isset($file) && is_string($file) && !file_exists($file) && touch($file)){
			if($this->flush !== array())
				$data['flush'] = $this->flush;
			file_put_contents($file, aped::jsonencode($data));
		}
	}
	public function flush_elements($level){
		$elements = $this->elements;
		if(($level < 1 && $level > 2) || $elements === array()){
			new APError("apeipTelegram flushElements", "invalid flush level", APError::NOTIC);
			return false;
		}
		$flush = &$this->flush;
		if(isset($this->settings['elements']['file']) && $file = $this->settings['elements']['file']){
			if($file && ((is_array($file)  && isset($file['flush']) && $data = $file['flush']) ||
				(file_exists($file) && ($data = file_get_contents($file)) && $data = aped::jsondecode($data,true))) &&
				isset($data['methods']) && isset($data['predicates'])){
				$flush['methods'] = (array)$data['methods'];
				$flush['predicates'] = (array)$data['predicates'];
				if(isset($data['ids']))
					$flush['ids'] = (array)$data['ids'];
				return;
			}
		}
		$flush['methods'] = array();
		$flush['predicates'] = array();
		if($level == 2){
			$flush['ids'] = array();
			foreach($elements['methods'] as &$method){
				$flush['methods'][$method['method']] = &$method;
				$flush['ids'][$method['id']] = &$method;
			}
			foreach($elements['constructors'] as &$constructor){
				$flush['predicates'][$constructor['predicate']] = &$constructor;
				$flush['ids'][$constructor['id']] = &$constructor;
			}
		}else{
			foreach($elements['methods'] as &$method)
				$flush['methods'][$method['method']] = &$method;
			foreach($elements['constructors'] as &$constructor)
				$flush['predicates'][$constructor['predicate']] = &$constructor;
		}
		if(isset($file) && is_string($file) && ((!file_exists($file) && touch($file)) ||
			(isset($this->settings['elements']['update']) && $this->settings['elements']['update']))){
			$data = $elements;
			$data['flush'] = $flush;
			file_put_contents($file, aped::jsonencode($data));
		}
	}

	// finders
	const METHOD = 1;
	const CONSTRUCTOR = 2;
	const PREDICATE = 3;
	const AUTO = 4;
	public function find_id($id, $type = null){
		if($id === null)$id = 4;
		if(isset($this->flush['ids'])){
			if(isset($this->flush['ids'][$id]))
				return $this->flush['ids'][$id];
			return false;
		}
		if($type == 1){
			foreach($this->elements['methods'] as $method)
				if($method['id'] == $id)
					return $method;
			return false;
		}
		if($type == 2 || $type == 3){
			foreach($this->elements['constructors'] as $constructor)
				if($constructor['id'] == $id)
					return $constructor;
			return false;
		}
		if($type == 4){
			foreach($this->elements['methods'] as $method)
				if($method['id'] == $id)
					return $method;
			foreach($this->elements['constructors'] as $constructor)
					if($constructor['id'] == $id)
						return $constructor;
			return false;
		}
		return false;
	}
	public function find_method($method){
		if(isset($this->flush['methods'])){
			if(isset($this->flush['methods'][$method]))
				return $this->flush['methods'][$method];
			return false;
		}
		foreach($this->elements['methods'] as $m)
			if($m['method'] == $method)
				return $m;
		return false;
	}
	public function find_predicate($predicate){
		if(isset($this->flush['predicates'])){
			if(isset($this->flush['predicates'][$predicate]))
				return $this->flush['predicates'][$predicate];
			return false;
		}
		foreach($this->elements['constructors'] as $constructor)
			if($constructor['predicate'] == $predicate)
				return $constructor;
		return false;
	}

	// conding
	public function type_encode($type,$content){
		$p = strpos($type, '<');
		if($p !== false){
			$sub = substr($type, $p + 1, -1);
			$type = substr($type, 0, $p);
		}
		if(is_array($content) && isset($content[0])){
			$content['_'] = $content[0];
			unset($content[0]);
		}
		switch($type){
			case 'int':
				if(!is_numeric($content)){
					new APError('XNTelegram toInt', 'number invalid', APError::TYPE);
					return "\0\0\0\0";
				}
				return pack('l', $content);
			case 'int128':
				if(strlen($content) !== 16){
					new APError('XNTelegram toInt128', 'content length invalid', APError::NOTIC);
					$content = str_pad(substr($content, 0, 16), 16, "\0");
				}
				return (string)$content;
			case 'int256':
				if(strlen($content) !== 32){
					new APError('XNTelegram toInt256', 'content length invalid', APError::NOTIC);
					$content = str_pad(substr($content, 0, 32), 32, "\0");
				}
				return (string)$content;
			case 'int512':
				if(strlen($content) !== 64){
					new APError('XNTelegram toInt512', 'content length invalid', APError::NOTIC);
					return str_pad(substr($content, 0, 64), 64, "\0", STR_PAD_LEFT);
				}
				return (string)$content;
			case '#':
				if(!is_numeric($content)){
					new APError('XNTelegram toInt', 'number invalid', APError::TYPE);
					return "\0\0\0\0";
				}
				return pack('V', $content);
			case 'double':
				if(!is_numeric($content)){
					new APError('XNTelegram toDouble', 'double invalid', APError::TYPE);
					return "\0\0\0\0\0\0\0\0";
				}
				return pack('d', $content);
			case 'long':
				if(is_string($content) && strlen($content) == 8)
					return $content;
				elseif(is_string($content)){
					new APError('XNTelegram toLong', 'long length invalid', APError::TYPE);
					return str_pad(substr($content, 0, 8), 8, "\0", STR_PAD_LEFT);
				}
				if(!is_numeric($content)){
					new APError('XNTelegram toLong', 'long invalid', APError::TYPE);
					return "\0\0\0\0\0\0\0\0";
				}
				if(PHP_INT_SIZE === 8)
					return pack('q',$content);
				switch($this->settings['number']){
					case 1:
						return pack('l',$content) . "\0\0\0\0";
					case 2:
						return strrev(str_pad(math::decstr($content), 8, "\0", STR_PAD_RIGTH));
					case 3:
						return strrev(str_pad(bnc::base_convert($content, 10, 'ascii'), 8, "\0", STR_PAD_RIGTH));
				}
			case 'bytes':
				if(is_array($content) && isset($content['_']) && $content['_'] == 'bytes')
					$content = crypt::base64decode($content['bytes']);
			case 'string':
				$l = strlen($content);
				if($l < 254)
					return chr($l) . $content . str_repeat("\0", Math::umod(-$l - 1, 4));
				else
					return "\xed" . substr(pack('l', $l), 0, 3) . $content . str_repeat("\0", Math::umod(-$l, 4));
			case 'Bool':
				return pack('l', array_value($this->find_predicate((bool)$content ? 'boolTrue' : 'boolFalse'), 'id'));
			case '!X':
				return $content;
			case 'Vector':
				$data = pack('l', array_value($this->find_predicate('vector'), 'id'));
			case 'vector':
				if(!isset($data))
					$data = '';
				if(!is_array($content)){
					new APError("apeipTelegram toVector","Array invalid", APError::TYPE);
					return $data . "\0";
				}
				$data .= pack('l', count($content));
				foreach($content as $now)
					$data .= $this->type_encode($sub, $now);
				return $data;
			case 'Object':
				if(is_string($content))
					return $content;
			break;
			case 'gzip_packed':
				return $this->encode_type('string', gzencode((string)$content, 9, 31));
		}
		$method = $this->find_method($type);
		$data = pack('N', $method['id']);
		foreach($method['params'] as $name => $param)
			$data .= $this->type_encode($param, @$content[$name]);
		return $data;
	}
	public function type_write($stream,$type,$content){
		if(!is_resource($stream))
			return false;
		return fwrite($stream,$this->type_encode($type,$content));
	}
	public function type_read($stream,$type = false){
		if(feof($stream) || !is_resource($stream))return null;
		if(!$type)
			$type = $this->find_id($id = array_value(unpack('N', fread($stream, 4)), 1));
		else{
			$type = $this->find_method($name = $type);
			if($type === false)
				$type = array(
					'id' => '0',
					'method' => $name,
					'params' => array(),
					'type' => $name
				);
		}
		if($type === false)
			new APError("apeipTelegram id@" . bin2hex($id), 'invalid type id', APError::TYPE, APError::TTHROW);
		$p = strpos($type['method'], '<');
		if($p !== false){
			$sub = substr($type, $p + 1, -1);
			$type['method'] = substr($type['method'], 0, $p);
		}
		switch($type['method']){
			case 'int':
				return array_value(unpack('l', fread($stream, 4)), 1);
			case 'int128':
				return fread($stream, 16);
			case 'int256':
				return fread($stream, 32);
			case 'int512':
				return fread($stream, 64);
			case '#':
				return array_value(unpack('V', fread($stream, 4)), 1);
			case 'double':
				return array_value(unpack('d', fread($stream, 8)), 1);
			case 'bytes':
			case 'string':
				$l = ord(fgetc($stream));
				if($l >= 254){
					$l = array_value(unpack('V', fgetc($stream) . "\0"), 1);
					$str = fread($stream, $l);
					$res = Math::umod(-$l, 4);
					if($res > 0)
						fseek($stream, $res, SEEK_CUR);
				}else{
					$str = $l > 0 ? fread($stream, $l) : '';
					$res = Math::umod(-$l - 1, 4);
					if($res > 0)
						fseek($stream, $res, SEEK_CUR);
				}
				return $type == 'bytes' ? array('bytes', 'bytes' => xcrypt::Base64encode($str)) : $str;
			case 'gzip_packed':
				return gzdecode($this->type_read($stream, 'string'));
			case 'Vector':
				fseek($stream, 4, SEEK_CUR);
			case 'vector':
				$count = array_value(unpack('V', fread($stream, 4)), 1);
				$res = array();
				while(--$count >= 0)
					$res[] = $this->type_read($stream, $sub);
				return $res;
			case 'Bool':
				return array_value($this->find_id(array_value(unpack('l', fread($stream, 4)), 1)), 'predicate') == 'boolTrue';
			case 'long':
				$content = fread($stream, 8);
				if(PHP_INT_SIZE === 8)
					return array_value(unpack('q', $content), 1);
				switch($this->settings['number']){
					case 0:
						return $content;
					case 1:
						return array_value(unpack('l', substr($content, 0, 4)), 1) * 4294967296;
					case 2:
						return math::strdec(strrev($content));
					break;
					case 3:
						return bnc::base_convert(strrev($content), 'ascii', 10);
				}
		}
		$content = array();
		foreach($type['params'] as $name => $param)
			$content[$name] = $this->type_read($stream, $param);
		return $content;
	}
	public function type_decode($string,$type = false, $offset = 0){
		if(!isset($string[$c]))return null;
		if(!$type){
			$type = $this->find_id($id = array_value(unpack('N', substr($string, $c, 4)), 1));
			$c += 4;
		}else{
			$type = $this->find_method($name = $type);
			if($type === false)
				$type = array(
					'id' => '0',
					'method' => $name,
					'params' => array(),
					'type' => $name
				);
		}
		if($type === false)
			new APError("apeipTelegram id@" . bin2hex($id), 'invalid type id', APError::TYPE, APError::TTHROW);
		$p = strpos($type['method'], '<');
		if($p !== false){
			$sub = substr($type, $p + 1, -1);
			$type['method'] = substr($type['method'], 0, $p);
		}
		switch($type['method']){
			case 'int':
				return array(array_value(unpack('l', substr($string, $c, 4)), 1), $c + 4);
			case 'int128':
				return array(substr($string, $c, 16), $c + 16);
			case 'int256':
				return array(substr($string, $c, 32), $c + 32);
			case 'int512':
				return array(substr($string, $c, 64), $c + 64);
			case '#':
				return array(array_value(unpack('V', substr($string, $c, 4)), 1), $c + 4);
			case 'double':
				return array(array_value(unpack('d', substr($string, $c, 8)), 1), $c + 8);
			case 'bytes':
			case 'string':
				$l = ord($string[$c++]);
				if($l >= 254){
					$l = array_value(unpack('V', $string[$c++] . "\0"), 1);
					$str = substr($string, $c, $l);
					$res = Math::umod(-$l, 4);
				}else{
					$str = $l > 0 ? substr($string, $c, $l) : '';
					$res = Math::umod(-$l - 1, 4);
				}
				return array($type == 'bytes' ? array('bytes', 'bytes' => crypt::base64encode($str)) : $str, $c + $l);
			case 'gzip_packed':
				return array(gzdecode($this->type_decode(substr($string, $c), 'string')), strlen($string));
			case 'Vector':
				$c += 4;
			case 'vector':
				$count = array_value(unpack('V', substr($string, $c, 4)), 1);
				$c += 4;
				$res = array();
				while(--$count >= 0){
					$r = $this->type_decode(substr($string, $c), $sub);
					$c+= $r[1];
					$res[] = $r[0];
				}
				return array($res, $c);
			case 'Bool':
				return array(array_value($this->find_id(array_value(unpack('l', substr($string, $c, 4)), 1)), 'predicate') == 'boolTrue', $c + 4);
			case 'long':
				$content = substr($string, $c, 8);
				if(PHP_INT_SIZE === 8)
					return array_value(unpack('q', $content), 1);
				switch($this->settings['number']){
					case 0:
						return array($content, $c + 8);
					case 1:
						return array(array_value(unpack('l', substr($content, 0, 4)), 1) * 0xffffffff, $c + 8);
					case 2:
						return array(math::strdec(strrev($content)), $c + 8);
					break;
					case 3:
						return array(bnc::base_convert(strrev($content), 'ascii', 10), $c + 8);
				}
		}
		$content = array();
		foreach($type['params'] as $name => $param){
			$content[$name] = $this->type_decode($string, $param, $c);
			$c = $content[$name][1];
			$content[$name] = $content[$name][0];
		}
		return $content;
	}
	public function type_read_all($stream, $input){
		if(!is_resource($stream))
			return false;
		if(!is_array($input))
			return $this->type_read_all($stream, str::explode(array('/', ':'), $input));
		$res = array();
		foreach($input as $key => $content)
			$res[$key] = $this->type_read($stream, $content);
		return $res;
	}
	public function type_decode_all($content, $input){
		if(!is_array($input))
			return $this->type_decode_all($content, str::explode(array('/', ':'), $input));
		$res = array();
		$c = 0;
		foreach($input as $key => $data){
			$res[$key] = $this->type_decode(substr($content, $c), $data);
			$c += $res[$key][1];
			$res[$key] = $res[$key][0];
		}
		return $res;
	}
	public function type_encode_all($input){
		if(!is_array($input))
			return $this->type_encode_all(str::explode(array('/', ':'), $input));
		$res = '';
		foreach($input as $content)
			if(isset($content[1]))
				$res .= $this->type_encode($content[0], $content[1]);
		return $res;
	}
	public function type_write_all($stream, $input){
		if(!is_array($input))
			return $this->type_write_all($stream, str::explode(array('/', ':'), $input));
		if(!is_resource($stream))
			return false;
		return fwrite($stream, $this->type_encode_all($input));
	}

	// peer id
	public function to_supergroup($id){
		return -($id + pow(10, floor(log($id, 10) + 3)));
	}
	public function from_supergroup($id){
		return pow(10, floor(log(-$id, 10) - 3)) - $id;
	}
	public function is_supergroup($id){
		$id = log(-$id, 10);
		return ($id - (int)$id) * 1000 < 10;
	}
	public function get_info($content){
		if(is_array($id)){
			if(isset($id[0])){
				$id['_'] = $id[0];
				unset($id[0]);
			}
			switch($id['_']){
				case 'inputUserSelf':
				case 'inputPeerSelf':
				case 'self':
					$id = $this->session['self']['id'];
				break;
				case 'inputPeerUser':
				case 'inputUser':
				case 'peerUser':
					$id = $id['user_id'];
				case 'userFull':
					$id = $id['user']['id'];
				break;
				case 'user':
					$id = $id['id'];
				break;
				case 'inputPeerChat':
				case 'inputChat':
				case 'peerChat':
					$id = -$id['chat_id'];
				break;
				case 'chatFull':
				case 'chat':
					$id = -$id['id'];
				break;
				case 'inputPeerChannel':
				case 'inputChannel':
				case 'peerChannel':
					$id = $this->to_supergroup($id['channel_id']);
				break;
				case 'channelFull':
				case 'channel':
					$id = $this->to_supergroup($id['id']);
				break;
				default:
			}
		}
		if(is_string($id) && $id !== ''){
			if($id[0] == 'c')
				$id = $this->to_supergroup(substr($id, 1));
			elseif($id[0] == 'h')
				$id = -substr($id, 1);
			elseif($id[0] == 'u')
				$id = substr($id, 1) + 0;
			else $id += 0;
		}
	}

	// robot api
	public function fileid_decode($id){
		$id = crypt::rledecode(crypt::hexdecode(substr($id, 1)));
		if($id[strlen($id) - 1] != "\x02")
			return false;
		$file = substr($id, 4);
		$id = array_value(unpack('l', substr($id, 0, 4)), 1);
		$files = array(
			0  => array("thumb"		, 'dc_id:int/id:long/access_hash:long/volume_id:long/secret:long/local_id:int'),
			2  => array("photo"		, 'dc_id:int/id:long/access_hash:long/volume_id:long/secret:long/local_id:int'),
			3  => array("voice"		, 'dc_id:int/id:long/access_hash:long'),
			4  => array("video"		, 'dc_id:int/id:long/access_hash:long'),
			5  => array("document"	, 'dc_id:int/id:long/access_hash:long'),
			8  => array("sticker"	, 'dc_id:int/id:long/access_hash:long'),
			9  => array("audio"		, 'dc_id:int/id:long/access_hash:long'),
			10 => array("gif"		, 'dc_id:int/id:long/access_hash:long'),
			12 => array("video_note", 'dc_id:int/id:long/access_hash:long')
		);
		if(!isset($files[$id]))
			return false;
		$id = $files[$id];
		$name = $id[0];
		$file = $this->type_decode_all($file, $id[1]);
		return array($name, $file);
	}

	// settings
	const RESULT_DEFUALT_MODEL = 0;
	const RESULT_XN_MODEL	  = 1;
	const RESULT_BOTAPI_MODEL  = 2;

	public function parse_settings($options = array()){
		try{
			$model = php_uname('s');
		}catch(Exception $e) {
			$model = 'Web server';
		}
		try{
			$version = php_uname('r');
		}catch(Exception $e) {
			$version = phpversion();
		}
		if($lang = getenv('LANG'))
			$lang = array_value(explode('_', $lang, 2), 0);
		elseif($lang = getenv('HTTP_ACCEPT_LANGUAGE'))
			$lang = substr($lang, 0, 2);
		else
			$lang = 'en';
		$settings = array(
			'serialization' => self::SERIALIZATION_COMPRESS,
			'session' => array(
				'serialization' => self::SESSION_FLUSH + self::SESSION_CONNECT + self::SESSION_SELF + self::SESSION_TIMER + self::SESSION_APPDATA + self::SESSION_LOGIN + self::SESSION_SETTINGS,
				'password' => false,
				'file' => 'xntelegram' . getenv('REMOTE_ADDTR') . '.session',
				'mode' => 600
			),
			'time' => array(
				'last_modified' => microtime(true),
				'created' => microtime(true),
				'serialized' => 0,
				'unserialized' => 0,
				'logined' => 0
			),
			'number' => 3,
			'subdomains' => array(
			),
			'rsa_keys' => array(
			"-----BEGIN RSA PUBLIC KEY-----\nMIIBCgKCAQEAwVACPi9w23mF3tBkdZz+zwrzKOaaQdr01vAbU4E1pvkfj4sqDsm6\nlyDONS789sVoD/xCS9Y0hkkC3gtL1tSfTlgCMOOul9lcixlEKzwKENj1Yz/s7daS\nan9tqw3bfUV/nqgbhGX81v/+7RFAEd+RwFnK7a+XYl9sluzHRyVVaTTveB2GazTw\nEfzk2DWgkBluml8OsubvfraX3bkHZJTKX4EQSjBbbdJ2ZXIsRrYOXfaA+xayEGB+\n8hdlLmAjbCVfaigxX0CDqWeR1yFL9kwd9P0NsZRPsmoqVwMbMu7mStFai6aIhc3n\nSlv8kg9qv1m6XHVQY3PnEw+QQtqSIXklHwIDAQAB\n-----END RSA PUBLIC KEY-----",
			"-----BEGIN RSA PUBLIC KEY-----\nMIIBCgKCAQEAxq7aeLAqJR20tkQQMfRn+ocfrtMlJsQ2Uksfs7Xcoo77jAid0bRt\nksiVmT2HEIJUlRxfABoPBV8wY9zRTUMaMA654pUX41mhyVN+XoerGxFvrs9dF1Ru\nvCHbI02dM2ppPvyytvvMoefRoL5BTcpAihFgm5xCaakgsJ/tH5oVl74CdhQw8J5L\nxI/K++KJBUyZ26Uba1632cOiq05JBUW0Z2vWIOk4BLysk7+U9z+SxynKiZR3/xdi\nXvFKk01R3BHV+GUKM2RYazpS/P8v7eyKhAbKxOdRcFpHLlVwfjyM1VlDQrEZxsMp\nNTLYXb6Sce1Uov0YtNx5wEowlREH1WOTlwIDAQAB\n-----END RSA PUBLIC KEY-----",
			"-----BEGIN RSA PUBLIC KEY-----\nMIIBCgKCAQEAsQZnSWVZNfClk29RcDTJQ76n8zZaiTGuUsi8sUhW8AS4PSbPKDm+\nDyJgdHDWdIF3HBzl7DHeFrILuqTs0vfS7Pa2NW8nUBwiaYQmPtwEa4n7bTmBVGsB\n1700/tz8wQWOLUlL2nMv+BPlDhxq4kmJCyJfgrIrHlX8sGPcPA4Y6Rwo0MSqYn3s\ng1Pu5gOKlaT9HKmE6wn5Sut6IiBjWozrRQ6n5h2RXNtO7O2qCDqjgB2vBxhV7B+z\nhRbLbCmW0tYMDsvPpX5M8fsO05svN+lKtCAuz1leFns8piZpptpSCFn7bWxiA9/f\nx5x17D7pfah3Sy2pA+NDXyzSlGcKdaUmwQIDAQAB\n-----END RSA PUBLIC KEY-----",
			"-----BEGIN RSA PUBLIC KEY-----\nMIIBCgKCAQEAwqjFW0pi4reKGbkc9pK83Eunwj/k0G8ZTioMMPbZmW99GivMibwa\nxDM9RDWabEMyUtGoQC2ZcDeLWRK3W8jMP6dnEKAlvLkDLfC4fXYHzFO5KHEqF06i\nqAqBdmI1iBGdQv/OQCBcbXIWCGDY2AsiqLhlGQfPOI7/vvKc188rTriocgUtoTUc\n/n/sIUzkgwTqRyvWYynWARWzQg0I9olLBBC2q5RQJJlnYXZwyTL3y9tdb7zOHkks\nWV9IMQmZmyZh/N7sMbGWQpt4NMchGpPGeJ2e5gHBjDnlIf2p1yZOYeUYrdbwcS0t\nUiggS4UeE8TzIuXFQxw7fzEIlmhIaq3FnwIDAQAB\n-----END RSA PUBLIC KEY-----"
			),
			'connection' => array(
				'ipv6' => false,
				'timeout' => 2,
				'proxy' => false,
				'dc' => 1
			),
			'datacenters' => array(
				array(
					'subdomain' => 'pluto'
				),
				array(
					'subdomain' => 'venus'
				),
				array(
					'subdomain' => 'aurora'
				),
				array(
					'subdomain' => 'vesta'
				),
				array(
					'subdomain' => 'flota'
				),
				array(
					'main' => true,
					'ipv4' => '149.154.175.50',
					'ipv6' => '2001:0b28:f23d:f001:0000:0000:0000:000a',
					'port' => 443
				),
				array(
					'main' => true,
					'ipv4' => '149.154.167.51',
					'ipv6' => '2001:067c:04e8:f002:0000:0000:0000:000a',
					'port' => 443
				),
				array(
					'main' => true,
					'ipv4' => '149.154.175.100',
					'ipv6' => '2001:0b28:f23d:f003:0000:0000:0000:000a',
					'port' => 443
				),
				array(
					'main' => true,
					'ipv4' => '149.154.167.91',
					'ipv6' => '2001:067c:04e8:f004:0000:0000:0000:000a',
					'port' => 443
				),
				array(
					'main' => true,
					'ipv4' => '149.154.171.5',
					'ipv6' => '2001:0b28:f23f:f005:0000:0000:0000:000a',
					'port' => 443
				),
				array(
					'main' => false,
					'ipv4' => '149.154.175.10',
					'ipv6' => '2001:0b28:f23d:f001:0000:0000:0000:000e',
					'port' => 443
				),
				array(
					'main' => false,
					'ipv4' => '149.154.167.40',
					'ipv6' => '2001:067c:04e8:f002:0000:0000:0000:000e',
					'port' => 443
				),
				array(
					'main' => false,
					'ipv4' => '149.154.175.117',
					'ipv6' => '2001:0b28:f23d:f003:0000:0000:0000:000e',
					'port' => 443
				)
			),
			'maxtries' => array(
				'connect' => 1
			),
			'app' => array(
				'id' => 6,
				'hash' => '',
				'device_model' => $model,
				'system_version' => $version,
				'app_version' => 'Unicorn',
				'lang' => $lang
			),
			'result_model' => 1,
			'elements' => array(
			)
		);
		$auto = isset($options['auto']) ? $options['auto'] : array();
		if(isset($options['auto']))unset($options['auto']);
		$settings = array_replace_recursive($settings, $options);
		$settings['dc'] = array();
		if(isset($settings['session']['file']) && file_exists($settings['session']['file']) && is_numeric($settings['session']['mode']))
			chmod($settings['session']['file'], $settings['session']['mode']);
		$this->settings = $settings;
		if($this->elements === array() && (!isset($auto['loadelements']) || $auto['loadelements']))$this->load_elements();
		if($this->dcs === array() && (!isset($auto['connect']) || $auto['connect']))$this->dc_connect('all');
	}

	// Data Center
	private $dcs = array();
	public function dc_connect($num = -1){
		if($num === 'all'){
			foreach($this->settings['datacenters'] as $num => $dc)
				$this->dc_connect($num);
			return true;
		}
		$dc = isset($this->settings['datacenters'][$num]) ? $this->settings['datacenters'][$num] : $this->settings['datacenters'][$this->settings['connection']['dc']];
		if(isset($dc['subdomain']))
			$address = array('tcp://' . $dc['subdomain'] . '.web.telegram.org', '/api');
		else
			$address = array(($dc['port'] === 443 ? 'ssl' : 'tcp') . '://' . (isset($dc['ipv6']) && $this->settings['connection']['ipv6'] ?
				'[' . $dc['ipv6'] . ']' : $dc['ipv4']), $dc['main'] ? '/apiw1' : '/apiw_test1');
		$c = 0;
		do{
			$ping = microtime(true);
			$socket = @fsockopen($address[0], isset($dc['port']) ? $dc['port'] : 80, $errno, $errstr, $this->settings['connection']['timeout']);
		}while(++$c < $this->settings['maxtries']['connect'] && $socket === false);
		if($socket === false)return false;
		$ping = microtime(true) - $ping;
		$dc['address'] = $address[0];
		$dc['path'] = $address[1];
		$dc['socket'] = $socket;
		$dc['tries'] = $c;
		$dc['ping'] = $ping;
		$this->dcs[$num] = $dc;
		return $num;
	}
}
*/
/*
function obfuscated2_create_random(&$crypted = 48384387897423){
	do{
		$random = rand::bytes(64);
	}while(in_array(substr($random, 0, 4), array('PVrG', 'GET ', 'POST', 'HEAD', "\xee\xee\xee\xee")) || $random[0] == "\xef" || substr($random, 4, 4) == "\0\0\0\0");
	$random[56] = $random[57] = $random[58] = $random[59] = "\xef";
	if($crypted !== 48384387897423)
		$crypted = substr_replace($random, substr(openssl_encrypt($random, 'aes-256-ctr', substr($random, 8, 32), 1, substr($random, 40, 16)), 56, 8), 56, 8);
	return $random;
}
function obfuscated2_get_info($random){
	$reversed = strrev(substr($random, 8, 48));
	return array(
		'algo' => 'aes-256-ctr',
		'encryption' => array(
			'key' => substr($random, 8, 32),
			'iv'  => substr($random, 40, 16)
		),
		'decryption' => array(
			'key' => substr($reversed, 0, 32),
			'iv'  => substr($reversed, 32, 16)
		)
	);
}
function obfuscated2_get_crypted($random){
	return substr_replace($random, substr(openssl_encrypt($random, 'aes-256-ctr', substr($random, 8, 32), 1, substr($random, 40, 16)), 56, 8), 56, 8);
}
function obfuscated2_socket_connect($socket, $crypted){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, $crypted);
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, $crypted);
	return false;
}
function tcpabridged_socket_connect($socket){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, "\xef");
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, "\xef");
	return false;
}
function tcpintermediate_socket_connect($socket){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, "\xee\xee\xee\xee");
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, "\xee\xee\xee\xee");
	return false;
}
function tcpabridged_write_message($socket, $message){
	$l = strlen($message) / 4;
	if($len < 127)
		$message = chr($l) . $message;
	else
		$message = chr(127) . substr(pack('V', $l), 0, 3) . $message;
	if(!is_resource($socket))
		return $message;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, $message);
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, $message);
	return false;
}
function obfuscated2_write_message($socket, $random, $message){
	$l = strlen($message) / 4;
	if($len < 127)
		$message = chr($l) . $message;
	else
		$message = chr(127) . substr(pack('V', $l), 0, 3) . $message;
	$message = openssl_encrypt($message, 'aes-256-ctr', substr($random, 8, 32), 1, substr($random, 40, 16));
	if(!is_resource($socket))
		return $message;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, $message);
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, $message);
	return false;
}
function tcpfull_write_message($socket, $message, $out_seq_no = 0){
	if($out_seq_no <= 0)$out_seq_no = 0;
	$message = pack('VV', strlen($message) + 12, $out_seq_no) . $message;
	$message.= strrev(hash('crc32b', $message, true));
	if(!is_resource($socket))
		return $message;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, $message);
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, $message);
	return false;
}
function tcpintermediate_write_message($socket, $message){
	$message = pack('V', strlen($message)) . $message;
	if(!is_resource($socket))
		return $message;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, $message);
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, $message);
	return false;
}
function tcpfull_read_message($socket, int &$in_seq_no = null){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		$pl = fread($socket, 4);
	elseif(get_resource_type($socket) == 'socket')
		$pl = socket_read($socket, 4);
	else return false;
	$l = array_value(unpack('V', $pl), 1);
	if(get_resource_type($socket) == 'stream')
		$p = fread($socket, $l - 4);
	elseif(get_resource_type($socket) == 'socket')
		$p = socket_read($socket, $l - 4);
	if(strrev(hash('crc32b', $pl . ($m = substr($p, 0, -4)), true)) !== substr($p, -4))
		new APError('tcpfull_read_message', 'CRC32 was not correct!', APError::WARNING, APError::TTHROW);
	if(get_resource_type($socket) == 'stream')
		$in_seq_no = fread($socket, 4);
	elseif(get_resource_type($socket) == 'socket')
		$in_seq_no = socket_read($socket, 4);
	$in_seq_no = array_value(unpack('V', $in_seq_no), 1);
	return $m;
}
function tcpintermediate_read_message($socket){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		return fread($socket, array_value(unpack('V', fread($socket, 4)), 1));
	if(get_resource_type($socket) == 'socket')
		return socket_read($socket, array_value(unpack('V', socket_read($socket, 4)), 1));
	return false;
}
function tcpabridged_read_message($socket){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream'){
		$l = ord(fgetc($socket));
		return fread($l < 127 ? $l << 2 : array_value(unpack('V', fread($socket, 3) . "\0"), 1) << 2);
	}if(get_resource_type($socket) == 'socket'){
		$l = ord(socket_read($socket, 1));
		return socket_read($l < 127 ? $l << 2 : array_value(unpack('V', socket_read($socket, 3) . "\0"), 1) << 2);
	}return false;
}
*/

function dump(){
	return call_user_func_array('var_dump', func_get_args());
}
function func_alias($from, $to){
	eval("function $to(){return call_user_func_array('$from', func_get_args());}");
}
function array_key_alias(&$array, $key){
	foreach(array_slice(func_get_args(), 2) as $arg){
		if(isset($array[$arg]) && $array[$arg] !== null)
			$res = $array[$arg];
		unset($array[$arg]);
	}
	if(isset($res))
		$array[$key] = $res;
	else return false;
	return true;
}
function array_value($array, $key, $preserve = null){
	if(is_array($key)){
		$values = array();
		if($preserve === true)
			foreach($key as $i)
				$values[] = isset($array[$i]) ? $array[$i] : null;
		else
			foreach($key as $i)
				$values[$i] = isset($array[$i]) ? $array[$i] : null;
		return $values;
	}
	return isset($array[$key]) ? $array[$key] : null;
}
function array_key($array, $value, $offset = 0, $strict = null){
	return array_search($value, array_slice($array, $offset), $strict === true);
}

/*
function pkcs1_generate_symmetric_key($password, $iv, $length, $raw = null){
	$key = '';
	$iv = substr($iv, 0, 8);
	while(!isset($key[$length - 1]))
		$key .= md5($key . $password . $iv, $raw !== false);
	return substr($key, 0, $length);
}
function putty_generate_symmetric_key($password, $length, $raw = null){
	$key = '';
	$seq = 0;
	while(!isset($key[$length - 1]))
		$key .= sha1(pack('Na*', $seq++, $password), $raw !== false);
	return substr($key, 0, $length);
}
*/

/*
function socket_write_title_header($socket, $method, $path, $http_version){
	if(!is_resource($socket))
		return false;
	$path = !isset($path[0]) || $path[0] != '/' ? '/' . $path : $path;
	$path = str_replace('%2F', '/', urlencode($path));
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, strtoupper($method) . ' ' . $path . ' ' . strtoupper($http_version) . "\r\n");
	elseif(get_resource_type($socket) == 'socket')
		return socket_write($socket, strtoupper($method) . ' ' . $path . ' ' . strtoupper($http_version) . "\r\n");
	return false;
}
function header_keyval_parse($key, $value){
	$key = ucwords(strtr(strtolower($key), ' _', '-'), '-');
	if(is_object($value))
		$value = (array)$value;
	if(is_array($value) && isset($value[0]) && is_array($value[0]))
		$value = implode('; ', array_map(function($x){
			return str_replace('; =', '; ', http_build_query($x, '=', '; '));
		}, $value)) . ';';
	elseif(is_array($value) && isset($value[0]))
		$value = implode('; ', $value) . ';';
	elseif(is_array($value))
		$value = '';
	elseif(is_bool($value))
		$value = $value ? 'true' : 'false';
	elseif(is_null($value))
		$value = '';
	return "$key: $value";
}
function socket_write_header($socket, $key, $value){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, header_keyval_parse($key, $value) . "\r\n");
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, header_keyval_parse($key, $value) . "\r\n");
	return false;
}
function socket_write_headers($socket, $headers){
	if(!is_resource($socket))
		return false;
	$res = 0;
	foreach($headers as $key=>$value)
		if(($r = socket_write_header($socket, $key, $value)) === false)
			return false;
		else $res += $r;
	return $res;
}
function socket_write_end_header($socket){
	if(!is_resource($socket))
		return false;
	if(get_resource_type($socket) == 'stream')
		return fwrite($socket, "\r\n");
	if(get_resource_type($socket) == 'socket')
		return socket_write($socket, "\r\n");
	return false;
}
function socket_write_connection($socket, $connection){
	return socket_write_header($socket, 'Connection', $connection);
}
function socket_write_host($socket, $host){
	return socket_write_header($socket, 'Host', $host);
}
function socket_write_origin($socket, $origin){
	return socket_write_header($socket, 'Origin', $origin);
}
function socket_write_content_type($socket, $length, $type){
	return socket_write_headers($socket, array(
		'Content-Type' => $type,
		'Content-Length' => $length
	));
}
*/

function pregpos($pattern, $subject, $offset = null){
	if(!preg_match($pattern, $subject, $match, 0, $offset !== null ? $offset : 0))
		return false;
	return strpos($subject, $match[0], $offset);
}
function preg_test($pattern, $subject, array &$matches = array(), $flags = null){
	if(!preg_match($pattern, $subject, $match, $flags !== null ? $flags : 0))
		return false;
	if($subject == $match[0]){
		$matches = $match;
		return true;
	}
	$matches = array();
	return false;
}
function array_tree($array){
	$tree = array();
	$last = null;
	$now = &$tree;
	foreach($array as $x){
		if(!is_array($x)){
			return false;
		}
		foreach($x as $k=>$y){
			if(!isset($x[$k + 1])){
				if(!isset($now[$y]) && array_search($y, $now) === false)
					$now[] = $y;
			}else{
				if(!isset($now[$y])){
					if(($s = array_search($y, $now)) !== false)
						unset($now[$s]);
					$now[$y] = array();
				}
				$now = &$now[$y];
			}
		}
		$now = &$tree;
	}
	return $tree;
}
function set_memory_limit($limit = null){
	return ini_set('memory_limit', $limit !== null ? $limit : '256M');
}
function get_memory_limit(){
	$mem = ini_get('memory_limit');
	if(substr($mem, -1) === 'M')$mem = substr($mem, 0, -1) * 1048576;
	return $mem + 0;
}
function get_time_limit(){
	return ini_get('max_execution_time');
}
define("EXTENSION_DIRECTORY", ini_get('extension_dir'));
/*
class VideoCaption {
	public $info = array(), $frames = array(), $format = true;
	public function setFrame($from, $length, $caption){
		$this->frames[] = array($from, $from + $length, $caption);
	}
	public function append($from, $to, $caption){
		$this->frames[] = array($from, $to, $caption);
	}
	public function getFrame($time){
		foreach($this->frames as $frame)
			if($frame[0] <= $time && $frame[1] > $time)
				return array(
					'start' => $frame[0],
					'stop' => $frame[1],
					'caption' => $frame[2]
				);
		return null;
	}
	public function setZoom($zoom = null){
		if($zoom < 0)
			$zoom *= -1;
		foreach($this->frames as &$frame){
			$frame[0] *= $zoom;
			$frame[1] *= $zoom;
		}
	}
	public function setInfo($info, $content){
		$this->info[$info] = $content;
	}
	public function getInfo($info){
		return isset($this->info[$info]) ? $this->info[$info] : false;
	}
	public function TimeFormat($time, $srt = null){
		return str_pad(floor($time / 3600), 2, '0', STR_PAD_LEFT) . ':' .
			str_pad(floor($time / 60) % 60, 2, '0', STR_PAD_LEFT) . ':' .
			str_pad($time % 60, 2, '0', STR_PAD_LEFT) .
			($srt === true ? ',' : ($srt === null ? '.' : ':')) . floor(($time - floor($time)) * 1001);
	}
	public function TimeUnformat($time){
		if(strpos($time, ',') > 0)
			$time = explode(',', $time, 2);
		elseif(strpos($time, '.') > 0)
			$time = explode('.', $time, 2);
		else
			$time = explode(':', $time, 2);
		$i = $time[1];
		$time = explode(':', $time[0], 3);
		$time = $time[0] * 3600 + $time[1] * 60 + $time[2];
		return (float)"$time.$i";
	}
	private function FrameFormat($from, $to, $srt = null, $ctl = null){
		return self::TimeFormat($from, $srt) . ($ctl === null ? ' --> ' : ($ctl === true ? ',' : ':')) . self::TimeFormat($to, $srt);
	}
	private function FrameUnformat($time){
		if(strpos($time, ' --> ') > 0)
			$time = explode(' --> ', $time, 2);
		elseif(strpos($time, ',') > 0)
			$time = explode(',', $time, 2);
		else
			$time = explode(':', $time, 2);
		return array($this->TimeUnformat($time[0]), $this->TimeUnformat($time[1]));
	}
	private function StringFormat($string, $type = null){
		if(!$this->format)
			return $string;
		if($type === null || $type === 1)
			return str_replace("\n", "\r\n", $string);
		if($type == 2)
			return str_replace("\n", '[BR]', $string);
		if($type == 3)
			return str_replace_loop("\n\n", "\n", $string);
		if($type == 4)
			return str_replace("\n", '|', $string);
	}
	private function StringUnformat($string, $type = null){
		if(!$this->format)
			return $string;
		if($type === null || $type === 1)
			return str_replace("\r\n", "\n", $string);
		if($type == 2)
			return str_replace('[BR]', "\n", $string);
		if($type == 3)
			return $string;
		if($type == 4)
			return str_replace('|', "\n", $string);
	}

	public function toSRT($file = null){
		$caption = "\xef\xbb\xbf";
		$n = 0;
		foreach($this->frames as $frame)
			$caption .= (++$n) . "\r\n" . $this->FrameFormat($frame[0], $frame[1], true) . "\r\n" . $this->StringFormat($frame[2]) . "\r\n\r\n";
		if($file === null)
			return $caption;
		return file_put_contents($file, $caption);
	}
	public function isSRT($caption){
		return substr($caption, 0, 3) == "\xef\xbb\xbf" && substr($caption, 3, 6) != 'WEBVTT';
	}
	public function fromSRT($caption){
		if(!$this->isSRT($caption))
			return false;
		$caption = explode("\r\n\r\n", substr($caption, 3));
		$n = 0;
		for($k = 0;isset($caption[$k]);++$k){
			$line = $caption[$k];
			if($line === '')
				continue;
			$line = explode("\r\n", $line, 3);
			if(!isset($line[2])){
				$caption[$k + 1] = substr($caption[$k + 1], 1);
				$line[2] = '';
			}
			$time = $this->FrameUnformat($line[1]);
			$content = $this->StringUnformat($line[2]);
			$this->append($time[0], $time[1], $content);
		}
		return true;
	}
	public function fromSRTFile($file){
		$file = file_get_contents($file);
		if($file === false)
			return false;
		return $this->fromSRT($file);
	}

	public function toVTT($file = null){
		$caption = "\xef\xbb\xbfWEBVTT";
		foreach($this->frames as $frame)
			$caption .= "\n\n" . $this->FrameFormat($frame[0], $frame[1]) . "\n" . $this->StringFormat($frame[2], 3);
		if($file === null)
			return $caption;
		return file_put_contents($file, $caption);
	}
	public function isVTT($caption){
		return substr($caption, 0, 9) == "\xef\xbb\xbfWEBVTT";
	}
	public function fromVTT($caption){
		if(!$this->isVTT($caption))
			return false;
		$caption = explode("\n\n", substr($caption, 9));
		for($k = 0;isset($caption[$k]);++$k){
			$line = $caption[$k];
			if($line === '')
				continue;
			$line = explode("\n", $line, 2);
			$time = $this->FrameUnformat($line[0]);
			if(!isset($line[1])){
				$caption[$k + 1] = substr($caption[$k + 1], 1);
				$content = '';
			}else $content = $line[1];
			$this->setFrame($time[0], $time[1], $content);
		}
		return true;
	}
	public function fromVTTFile($file){
		$file = file_get_contents($file);
		if($file === false)
			return false;
		return $this->fromVTT($file);
	}

	public function toSUB2($file = null){
		$caption = "\xef\xbb\xbf";
		foreach($this->frames as $k => $frame){
			$caption .= '{' . floor($frame[0]) . '}{' . floor($frame[1]) . '}' . $this->StringFormat($frame[2], 4);
			if(isset($this->frames[$k + 1]))
				$caption .= "\n";
		}
		return $caption;
	}
	public function isSUB2($caption){
		return $caption == "\xef\xbb\xbf" || substr($caption, 0, 4) == "\xef\xbb\xbf{";
	}
	public function fromSUB2($caption){
		if(!$this->isSUB2($caption))
			return false;
		$caption = explode("\n", substr($caption, 3));
		foreach($caption as $line){
			if($line === '' || $line[0] != '{')
				continue;
			$line = explode('}{', substr($line, 1), 2);
			$time = array($line[0], substr($line[1], 0, $p = strpos($line[1], '}')));
			$content = substr($line[1], $p + 1);
			$this->setFrame($time[0], $time[1], $content);
		}
		return true;
	}
	public function fromSUB2File($file){
		$file = file_get_contents($file);
		if($file === false)
			return false;
		return $this->fromSUB2($file);
	}

	public function existsformat($format){
		return method_exists($this, 'is' . strtoupper($format));
	}
	public function isformat($format, $caption){
		if(!$this->existsformat($format))
			return null;
		return call_user_method('is' . strtoupper($format), $this, $caption);
	}
	public function toformat($format){
		if(!$this->existsformat($format))
			return null;
		return call_user_method('to' . strtoupper($format), $this);
	}
	public function fromformat($format, $caption){
		if(!$this->existsformat($format))
			return null;
		return call_user_method('from' . strtoupper($format), $this, $caption);
	}
	public function isfileformat($format, $file){
		if(!$this->existsformat($format))
			return null;
		$file = file_get_contents($file);
		if($file === false)
			return false;
		return call_user_method('is' . strtoupper($format), $this, $file);
	}
	public function tofileformat($format, $file){
		if(!$this->existsformat($format))
			return null;
		return call_user_method('to' . strtoupper($format), $this, $file);
	}
	public function fromfileformat($format, $caption){
		if(!$this->existsformat($format))
			return null;
		return call_user_method('from' . strtoupper($format) . 'File', $this, $caption);
	}

	public function getCaption($caption){
		if(file_exists($caption))
			$caption = file_get_contents($caption);
		if($this->isSRT($caption))
			return 'SRT';
		if($this->isVTT($caption))
			return 'VTT';
		if($this->isSUB2($caption))
			return 'SUB2';
		return false;
	}
	public function fromCaption($caption){
		if(file_exists($caption))
			$caption = file_get_contents($caption);
		return $this->fromformat($this->getCaption($caption), $caption);
	}
	public function toCaption($format, $file = null){
		if($file === null)
			return $this->tofileformat($format, $file);
		return $this->toformat($format);
	}
}
function vcaption_convert($from, $format, $to = null){
	$vc = new VideoCaption;
	if(!$vc->fromCaption($from))
		return false;
	return $vc->toCaption($format, $to);
}
function vcaption_get($caption){
	$tmp = new VideoCaption;
	return $tmp->getCaption($caption);
}
*/
function compress_php_src($src){
	$IW = array(
		T_CONCAT_EQUAL,			 // .=
		T_DOUBLE_ARROW,			 // =>
		T_BOOLEAN_AND,			  // &&
		T_BOOLEAN_OR,			   // ||
		T_IS_EQUAL,				 // ==
		T_IS_NOT_EQUAL,			 // != or <>
		T_IS_SMALLER_OR_EQUAL,	  // <=
		T_IS_GREATER_OR_EQUAL,	  // >=
		T_INC,					  // ++
		T_DEC,					  // --
		T_PLUS_EQUAL,			   // +=
		T_MINUS_EQUAL,			  // -=
		T_MUL_EQUAL,				// *=
		T_DIV_EQUAL,				// /=
		T_IS_IDENTICAL,			 // ===
		T_IS_NOT_IDENTICAL,		 // !==
		T_DOUBLE_COLON,			 // ::
		T_PAAMAYIM_NEKUDOTAYIM,	 // ::
		T_OBJECT_OPERATOR,		  // ->
		T_DOLLAR_OPEN_CURLY_BRACES, // ${
		T_AND_EQUAL,				// &=
		T_MOD_EQUAL,				// %=
		T_XOR_EQUAL,				// ^=
		T_OR_EQUAL,				 // |=
		T_SL,					   // <<
		T_SR,					   // >>
		T_SL_EQUAL,				 // <<=
		T_SR_EQUAL,				 // >>=
	);
	if(is_file($src))
		if(!$src = file_get_contents($src))
			return false;
	$tokens = token_get_all($src);	
	$new = "";
	$c = sizeof($tokens);
	$iw = false; // ignore whitespace
	$ih = false; // in HEREDOC
	$ls = "";	// last sign
	$ot = null;  // open tag
	for($i = 0; $i < $c; $i++){
		$token = $tokens[$i];
		if(is_array($token)){
			list($tn, $ts) = $token; // tokens: number, string, line
			$tname = token_name($tn);
			if($tn == T_INLINE_HTML){
				$new .= $ts;
				$iw = false;
			}else{
				if($tn == T_OPEN_TAG){
					if(strpos($ts, " ") || strpos($ts, "\n") || strpos($ts, "\t") || strpos($ts, "\r"))
						$ts = rtrim($ts);
					$ts .= " ";
					$new .= $ts;
					$ot = T_OPEN_TAG;
					$iw = true;
				}elseif($tn == T_OPEN_TAG_WITH_ECHO){
					$new .= $ts;
					$ot = T_OPEN_TAG_WITH_ECHO;
					$iw = true;
				}elseif($tn == T_CLOSE_TAG){
					if($ot == T_OPEN_TAG_WITH_ECHO)
						$new = rtrim($new, "; ");
					else
						$ts = " ".$ts;
					$new .= $ts;
					$ot = null;
					$iw = false;
				}elseif(in_array($tn, $IW)){
					$new .= $ts;
					$iw = true;
				}elseif($tn == T_CONSTANT_ENCAPSED_STRING || $tn == T_ENCAPSED_AND_WHITESPACE){
					if($ts[0] == '"')
						$ts = addcslashes($ts, "\n\t\r");
					$new .= $ts;
					$iw = true;
				}elseif($tn == T_WHITESPACE){
					$nt = @$tokens[$i+1];
					if(!$iw && (!is_string($nt) || $nt == '$') && !in_array($nt[0], $IW))
						$new .= " ";
					$iw = false;
				}elseif($tn == T_START_HEREDOC){
					$new .= "<<<S\n";
					$iw = false;
					$ih = true; // in HEREDOC
				}elseif($tn == T_END_HEREDOC){
					$new .= "S;";
					$iw = true;
					$ih = false; // in HEREDOC
					for($j = $i+1; $j < $c; $j++) {
						if(is_string($tokens[$j]) && $tokens[$j] == ";"){
							$i = $j;
							break;
						}elseif($tokens[$j][0] == T_CLOSE_TAG)
							break;
					}
				}elseif($tn == T_COMMENT || $tn == T_DOC_COMMENT){
					$iw = true;
				}else{
					$new .= $ts;
					$iw = false;
				}
			}
			$ls = "";
		}else{
			if(($token != ";" && $token != ":") || $ls != $token) {
				$new .= $token;
				$ls = $token;
			}
			$iw = true;
		}
	}
	return $new;
}
function func_get_params($offset = null, $length = null, $defaults = false){
	if($offset == -1)$offset = null;
	if($length == -1)$length = null;
	$trace = debug_backtrace(1, 2);
	if(!isset($trace[1]['args'])){
		trigger_error('func_get_params():  Called from the global scope - no function context', E_USER_WARNING);
		return;
	}
	$args = $length === null ? array_slice($trace[1]['args'], $offset === null ? 0 : $offset) :
		array_slice($trace[1]['args'], $offset === null ? 0 : $offset, $length);
	if($trace[1]['function'] === '{closure}')
		return $args;
	$name = get_callable_args($trace[1]['function']);
	$name = $length === null ? array_slice($name, $offset === null ? 0 : $offset) :
		array_slice($name, $offset === null ? 0 : $offset, $length);
	$array = array();
	for($i = 0; isset($name[$i]) && isset($args[$i]); ++$i)
		$array[$name[$i]['name']] = $args[$i];
	for(; isset($args[$i]); ++$i)
		$array[] = $args[$i];
	if($defaults)
		for(; isset($name[$i]['default']); ++$i)
			$array[$name[$i]['name']] = $name[$i]['default'];
	return $array;
}
function func_get_param($index = 0, $defaults = false, $getname = false){
	$trace = debug_backtrace(1, 2);
	if(!isset($trace[1]['args'])){
		trigger_error('func_get_param():  Called from the global scope - no function context', E_USER_WARNING);
		return;
	}
	if(isset($trace[1]['args'][$index]))
		$arg = $trace[1]['args'][$index];
	elseif(!$defaults){
		trigger_error("func_get_param():  Argument $index not passed to function", E_USER_WARNING);
		return;
	}
	if($trace[1]['function'] == '{closure}'){
		if(isset($arg))
			return $getname ? array($index, $arg) : $arg;
		trigger_error("func_get_param():  Argument $index not passed to function", E_USER_WARNING);
		return;
	}
	if(!isset($arg)){
		$name = get_callable_arg($trace[1]['function'], $index);
		if(isset($name['default']))
			return $getname ? array($name['name'], $name['default']) : $name['default'];
		else{
			trigger_error("func_get_param():  Argument $index not passed to function", E_USER_WARNING);
			return;
		}
	}
	if($getname){
		$name = get_callable_arg($trace[1]['function'], $index);
		return isset($name['name']) ? array($name['name'], $arg) : array($index, $arg);
	}
	return $arg;
}
function func_has_arg($index){
	$trace = debug_backtrace(1, 2);
	if(!isset($trace[1]['args'])){
		trigger_error('func_get_param():  Called from the global scope - no function context', E_USER_WARNING);
		return;
	}
	return isset($trace[1]['args'][$index]);
}
/*
class XNAPK {
	private $file, $icons, $content = array('ns' => array()), $xml, $length, $data, $manifest, $line, $dictionary;
	public function dictionary(){
		if($this->dictionary !== null)
			return $this->dictionary;
		return aped::jsondecode(aped('apk-dictionary'), true);
	}
	public function flush_dictionary(){
		if($this->dictionary !== null)
			return;
		$this->dictionary = aped::jsondecode(aped('apk-dictionary'), true);
	}
	public function __construct($file){
		if(!file_exists($file))
			new APError('XNApk', "No such Apk file '$file'", APError::WARNING, APError::TTHROW);
		$this->file = new ZipArchive;
		if($this->file->open($file) !== true)
			new APError('XNApk', "can not open Apk file '$file'", APError::WARNING, APError::TTHROW);
	}
	public function getApkArchive(){
		return $this->file;
	}
	public function parseAll(){
		$this->getIcons();
		$this->parseManifest();
	}
	public function getIcons(){
		if($this->icons !== null)
			return $this->icons;
		$files = array(
			'ic_launcher.png',
			'icon.png',
			'app_icon.png',
			'ic_launcher_auto_media.png',
			'ic_launcher_auto_messaging.png'
		);
		$paths = array(
			array('res/mipmap-xxxhdpi', 192),
			array('res/drawable-xxxhdpi', 192),
			array('res/drawable-xxhdpi', 144),
			array('res/mipmap-xxhdpi', 144),
			array('res/drawable-xxhdpi-v0', 144),
			array('res/drawable-xxhdpi-v1', 144),
			array('res/drawable-xxhdpi-v2', 144),
			array('res/drawable-xxhdpi-v3', 144),
			array('res/drawable-xxhdpi-v4', 144),
			array('res/drawable-xxhdpi-v5', 144),
			array('res/mipmap-xhdpi', 96),
			array('res/drawable-xhdpi', 96),
			array('res/drawable-xhdpi-v0', 96),
			array('res/drawable-xhdpi-v1', 96),
			array('res/drawable-xhdpi-v2', 96),
			array('res/drawable-xhdpi-v3', 96),
			array('res/drawable-xhdpi-v4', 96),
			array('res/drawable-xhdpi-v5', 96),
			array('res/mipmap-hdpi', 72),
			array('res/drawable-hdpi', 72),
			array('res/drawable-hdpi-v0', 72),
			array('res/drawable-hdpi-v1', 72),
			array('res/drawable-hdpi-v2', 72),
			array('res/drawable-hdpi-v3', 72),
			array('res/drawable-hdpi-v4', 72),
			array('res/drawable-hdpi-v5', 72),
			array('res/mipmap-mdpi', 48),
			array('res/drawable-mdpi', 48),
			array('res/drawable-mdpi-v0', 48),
			array('res/drawable-mdpi-v1', 48),
			array('res/drawable-mdpi-v2', 48),
			array('res/drawable-mdpi-v3', 48),
			array('res/drawable-mdpi-v4', 48),
			array('res/drawable-mdpi-v5', 48),
			array('res/drawable-ldpi', 36),
			array('res/drawable', 72),
		);
		$this->icons = array();
		foreach($paths as $path)
			foreach($files as $file){
				$file = $path[0] . '/' . $file;
				if(($get = $this->file->getFromName($file)) !== false)
					$this->icons[] = array(
						'path' => $file,
						'size' => $path[1],
						'icon' => $get
					);
			}
		return $this->icons;
	}
	public function existsIcons(){
		return $this->getIcons() !== array();
	}
	public function parseManifest(){
		if(is_array($this->manifest))
			return $this->manifest;
		$xml = $this->file->getFromName('AndroidManifest.xml');
		return $this->manifest = $parse = $this->parseXML($xml);
	}
	public function parseXML($xml){
		$this->data = new StdClass;
		$this->xml = $xml;
		$this->length = strlen($xml);
		$parse = $this->_parseXML();
		$this->xml =
		$this->length;
		return $parse;
	}
	private function _parseXML(){
		$type = array_value(unpack('V', substr($this->xml, 0, 4)), 1);
		$size = array_value(unpack('V', substr($this->xml, 4, 4)), 1);
		if($size < 8 || $size > $this->length)
			new APError('parseXML', 'Block Size Error', APError::WARNING, APError::TTHROW);
		$left = $this->length - $size;
		$props = false;
		$o = 8;
		switch($type) {
			case 0x00080003:
				$props = array(
					'line' => 0,
					'tag'  => '<?xml version="1.0" encoding="utf-8"?>'
				);
			break;
			case 0x001C0001:
				$this->data->stringCount = array_value(unpack('V', substr($this->xml, $o, 4)), 1);
				$this->data->styleCount = array_value(unpack('V', substr($this->xml, $o + 4, 4)), 1);
				$strOffset = array_value(unpack('V', substr($this->xml, $o + 12, 4)), 1);
				$styOffset = array_value(unpack('V', substr($this->xml, $o + 16, 4)), 1);
				$o += 20;
				$strListOffset = $this->data->stringCount <= 0 ? null : unpack('V*', substr($this->xml, $o, $this->data->stringCount * 4));
				$o += $this->data->stringCount * 4;
				$styListOffset = $this->data->styleCount <= 0 ? null : unpack('V*', substr($this->xml, $o, $this->data->styleCount * 4));
				$o += $this->data->styleCount * 4;
				$this->data->stringTab = $this->data->stringCount > 0 ? $this->getStringTab($strOffset, $strListOffset) : array();
				$this->data->styleTab = $this->data->styleCount > 0 ? $this->getStringTab($styOffset, $styListOffset) : array();
				$o = $size;
			break;
			case 0x00080180:
				$count = $size / 4 - 2;
				$this->resourceIDs = $count <= 0 ? null : unpack('V*', substr($this->xml, $o, $count * 4));
				$o += $count * 4;
			break;
			case 0x00100100:
				$prefix = array_value(unpack('V', substr($this->xml, $o + 8, 4)), 1);
				$uri = array_value(unpack('V', substr($this->xml, $o + 12, 4)), 1);
				$o += 16;
				if(empty($this->data->cur_ns)) {
					$this->data->cur_ns = array();
					$this->data->ns[] = &$this->data->cur_ns;
				}
				$this->data->cur_ns[$uri] = $prefix;
			break;
			case 0x00100101:
				$prefix = array_value(unpack('V', substr($this->xml, $o + 8, 4)), 1);
				$uri = array_value(unpack('V', substr($this->xml, $o + 12, 4)), 1);
				$o += 16;
				if(empty($this->data->cur_ns)) break;
				unset($this->data->cur_ns[$uri]);
			break;
			case 0x00100102:
				$line = array_value(unpack('V', substr($this->xml, $o, 4)), 1);
				$o += 8;
				$attrs = array();
				$props = array(
					'line'  => $line,
					'ns'	=> $this->getNameSpace(array_value(unpack('V', substr($this->xml, $o, 4)), 1)),
					'name'  => $this->getString(array_value(unpack('V', substr($this->xml, $o + 4, 4)), 1)),
					'flag'  => array_value(unpack('V', substr($this->xml, $o + 8, 4)), 1),
					'count' => array_value(unpack('v', substr($this->xml, $o + 12, 2)), 1),
					'id'	=> array_value(unpack('v', substr($this->xml, $o + 14, 2)), 1) - 1,
					'class' => array_value(unpack('v', substr($this->xml, $o + 16, 2)), 1) - 1,
					'style' => array_value(unpack('v', substr($this->xml, $o + 18, 2)), 1) - 1,
					'attrs' => &$attrs
				);
				$o += 20;
				$props['ns_name'] = $props['ns'] . $props['name'];
				for($i = 0; $i < $props['count']; $i++) {
					$a = array(
						'ns'	   => $this->getNameSpace(array_value(unpack('V', substr($this->xml, $o, 4)), 1)),
						'name'	   => $this->getString(array_value(unpack('V', substr($this->xml, $o + 4, 4)), 1)),
						'val_str'  => array_value(unpack('V', substr($this->xml, $o + 8, 4)), 1),
						'val_type' => array_value(unpack('V', substr($this->xml, $o + 12, 4)), 1),
						'val_data' => array_value(unpack('V', substr($this->xml, $o + 16, 4)), 1)
					);
					$o += 20;
					$a['ns_name'] = $a['ns'] . $a['name'];
					$a['val_type'] >>= 24;
					$attrs[] = $a;
				}
				$tag = "<{$props['ns_name']}";
				foreach($this->data->cur_ns as $uri => $prefix) {
					$uri = $uri > -1 && $uri < $this->data->stringCount ? $this->data->stringTab[$uri] : '';
					$prefix = $prefix > -1 && $prefix < $this->data->stringCount ? $this->data->stringTab[$prefix] : '';
					$tag .= " xmlns:{$prefix}=\"{$uri}\"";
				}
				foreach($props['attrs'] as $a) {
					$tag .= " {$a['ns_name']}=\"" .
					$this->getAttributeValue($a) .
					'"';
				}
				$tag .= '>';
				$props['tag'] = $tag;
				unset($this->data->cur_ns);
				$this->data->cur_ns = array();
				$this->data->ns[] = &$this->data->cur_ns;
				$left = -1;
			break;
			case 0x00100103:
				$line = array_value(unpack('V', substr($this->xml, $o, 4)), 1);
				$props = array(
					'line' => $line,
					'ns'   => $this->getNameSpace(array_value(unpack('V', substr($this->xml, $o + 8, 4)), 1)),
					'name' => $this->getString(array_value(unpack('V', substr($this->xml, $o + 12, 4)), 1))
				);
				$o += 16;
				$props['ns_name'] = $props['ns'] . $props['name'];
				$props['tag'] = "</{$props['ns_name']}>";
				if(count($this->data->ns) > 1) {
					array_pop($this->data->ns);
					unset($this->data->cur_ns);
					$this->data->cur_ns = array_pop($this->data->ns);
					$this->data->ns[] = &$this->data->cur_ns;
				}
			break;
			case 0x00100104:
				$props = array(
					'tag' => $this->getString(array_value(unpack('V', substr($this->xml, $o + 8, 4)), 1))
				);
				$o += 20;
			break;
			default:
				new APError('parseXML', 'Block Type Error', APError::WARNING, APError::TTHROW);
		}
		$this->xml = substr($this->xml, $o);
		$this->length -= $o;
		$child = array();
		while($this->length > $left) {
			$c = $this->_parseXML();
			if($props && $c)
				$child[] = $c;
			if($left == -1 && $c['type'] == 0x00100103) {
				$left = $this->length;
				break;
			}
		}
		if($this->length != $left)
			new APError('parseXML', 'Block Overflow Error', APError::WARNING, APError::TTHROW);
		if(!$props)
			return false;
		$props['type'] = $type;
		$props['size'] = $size;
		$props['child'] = $child;
		return $props;
	}
	private function getStringTab($base, $list) {
		$tab = array();
		foreach($list as $off) {
			$off+= $base;
			$len = array_value(unpack('v', substr($this->xml, $off, 2)), 1);
			$off+= 2;
			$mask= ($len >> 0x8) & 0xFF;
			$len = $len & 0xFF;
			if($len == $mask) {
				if($off + $len > $this->length)
					new APError('getStringTab', 'String Table Overflow', APError::WARNING, APError::TTHROW);
				$tab[] = substr($this->xml, $off, $len);
			}else{
				if($off + $len * 2 > $this->length)
					new APError('getStringTab', 'String Table Overflow', APError::WARNING, APError::TTHROW);
				$str = substr($this->xml, $off, $len * 2);
				$tab[] = mb_convert_encoding($str, 'UTF-8', 'UCS-2LE');
			}
		}
		return $tab;
	}
	private	function getNameSpace($uri) {
		for($i = count($this->data->ns); $i > 0;) {
			$ns = $this->data->ns[--$i];
			if(isset($ns[$uri])) {
				$ns = $ns[$uri] > -1 && $ns[$uri] < $this->data->stringCount ? $this->data->stringTab[$ns[$uri]] : '';
				if(!empty($ns))
					$ns .= ':';
				return $ns;
			}
		}
		return '';
	}
	private	function getString($id) {
		return $id > -1 && $id < $this->data->stringCount ? $this->data->stringTab[$id] : '';
	}
	public function getAttribute($path, $name) {
		$r = $this->getElement($path);
		if(is_null($r))return null;
		if(isset($r['attrs']))
			foreach($r['attrs'] as $a)
				if($a['ns_name'] == $name)
					return $this->getAttributeValue($a);
	}
	private function getAttributeValue($a) {
		$type = &$a['val_type'];
		$data = &$a['val_data'];
		switch($type) {
			case 3:
				return $a['val_str'] > -1 && $a['val_str'] < $this->data->stringCount ? $this->data->stringTab[$a['val_str']] : '';
			case 2:
				return sprintf('?%s%08X', ($data >> 24 == 1) ? 'android:' : '', $data);
			case 1:
				return sprintf('@%s%08X', ($data >> 24 == 1) ? 'android:' : '', $data);
			case 17:
				return sprintf('0x%08X', $data);
			case 18:
				return ($data != 0 ? 'true' : 'false');
			case 28:
			case 29:
			case 30:
			case 31:
				return sprintf('#%08X', $data);
			case 5:
				return math::complex2float($data) . array_value(array("%", "%p", "", "", "", "", "", ""), $data & 15);
			case 6:
				return math::complex2float($data) . array_value(array("%", "%p", "", "", "", "", "", ""), $data & 15);
			case 4:
				return math::int2float($data);
		}
		if($type >= 16 && $type < 28)
			return (string)$data;
		return sprintf('<0x%X, type 0x%02X>', $data, $type);
	}
	private function getElement($path) {
		$ps = explode('/', $path);
		$r = $this->parseManifest();
		foreach($ps as $v) {
			if(preg_match('/([^\[]+)\[([0-9]+)\]$/', $v, $ms)) {
				$v = $ms[1];
				$off = $ms[2];
			} else
				$off = 0;
			foreach($r['child'] as $c) {
				if($c['type'] == 0x00100102 && $c['ns_name'] == $v) {
					if($off == 0) {
						$r = $c;
						continue 2;
					}
					else
						$off--;
				}
			}
			return null;
		}
		return $r;
	}
	public function decompaileXML($xml){
		if(strtolower(substr($xml, 0, 5)) == '<?xml')
			return $xml;
		return $this->getXML($this->parseXML($xml));
	}
	public function decompaileXMLFile($xml){
		$xml = $this->file->getFromName($xml);
		if($xml === false)
			return false;
		if(strtolower(substr($xml, 0, 5)) == '<?xml')
			return $xml;
		return $this->getXML($this->parseXML($xml));
	}
	public function getXML($node = null, $lv = -1) {
		$xml = '';
		if($lv == -1)
			$node = $this->parseManifest();
		if(!$node)
			return $xml;
		if($node['type'] == 0x00100103)$lv--;
		$xml = ($node['line'] == 0 || $node['line'] == $this->line) ? '' : "\n" . str_repeat('  ', $lv);
		$xml.= $node['tag'];
		$this->line = $node['line'];
		foreach($node['child'] as $c)
			$xml .= $this->getXML($c, $lv + 1);
		return trim($xml);
	}
	public function getAppName() {
		return $this->getAttribute('manifest/application', 'android:name');
	}
	public function getVersionName() {
		return $this->getAttribute('manifest', 'android:versionName');
	}
	public function getVersionCode() {
		return $this->getAttribute('manifest', 'android:versionCode');
	}
	public function getDebuggable() {
		return $this->getAttribute('manifest/application', 'android:debuggable') == 'true';
	}
	public function getAllowBackup() {
		return $this->getAttribute('manifest/application', 'android:allowBackup') == 'true';
	}
	public function getLargeHeap() {
		return $this->getAttribute('manifest/application', 'android:largeHeap') == 'true';
	}
	public function getPackageName() {
		return $this->getAttribute('manifest', 'package');
	}
	public function getUsesPermissionsDictionary() {
		$collection = array();
		$dictionary = $this->dictionary();
		$permissions = array();
		for($i = 0; true; ++$i) {
			$item = $this->getAttribute("manifest/uses-permission[{$i}]", 'android:name');
			if(!$item)break;
			$permission = isset($dictionary[$item]) ? isset($dictionary[$item]['description']) ? $dictionary[$item]['description'] : "" : "";
			$collection[$permission] = $permission !== '' ? isset($dictionary[$permission]) ? $dictionary[$permission] : '' : $dictionary;
		}
		return $collection;
	}
	public function getUsesPermissions() {
		$collection = array();
		$dictionary = $this->dictionary();
		for($i = 0; true; ++$i) {
			$item = $this->getAttribute("manifest/uses-permission[{$i}]", 'android:name');
			if(!$item)break;
			$collection[$item] = isset($dictionary[$item]) ? isset($dictionary[$item]['description']) ? $dictionary[$item]['description'] : "" : "";
		}
		return $collection;
	}
	public function hasUsePermission($permission){
		$permission = strtolower($permission);
		for($i = 0; true; ++$i) {
			$item = $this->getAttribute("manifest/uses-permission[{$i}]", 'android:name');
			if(!$item)break;
			if(strtolower($item) == $permission)
				return true;
		}
		return false;
	}
	public function getUsesFeature() {
		$collection = array();
		for($i = 0; true; $i += 1) {
			$item_name = $this->getAttribute("manifest/uses-feature[{$i}]", 'android:name');
			if(!$item_name) break;
			$item_requirement = $this->getAttribute("manifest/uses-feature[{$i}]", 'android:required');
			array_push($collection, array(
				"name"		=> $item_name,
				"is_required" => $item_requirement
			));
		}
		return $collection;
	}
	public function getUsesSDKMin() {
	  return $this->getAttribute('manifest/uses-sdk', 'android:minSdkVersion');
	}
	public function getUsesSDKTarget() {
	  return $this->getAttribute('manifest/uses-sdk', 'android:targetSdkVersion');
	}
	public function getApplicationMetaData(){
		$collection = array();
		for($i = 0; true; $i += 1) {
			$item_name = $this->getAttribute("manifest/application/meta-data[{$i}]", 'android:name');
			$item_value = $this->getAttribute("manifest/application/meta-data[{$i}]", 'android:value');
			if(!$item_name)break;
			if(!$item_value)
				$item_value = '';
			$collection[$item_name] = $item_value;
		}
		return $collection;
	}
}
function wss_secaccept($key){
	return sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true);
}
function wss_makekey(){
	return rand::bytes(20);
}
define("WSS_CONTINUATION", 0);
define("WSS_TEXT", 1);
define("WSS_BINARY", 2);
define("WSS_CLOSE", 8);
define("WSS_PING", 9);
define("WSS_PONG", 10);
define("WSS_BINARY_BLOB", "\x81");
define("WSS_BINARY_TEXT", "\x82");
function wss_encode($data, $opcode = 1, $masked = null, $final = null){
	$l = strlen($data);
	$head = (bool)$final ? '1' : '0';
	$head .= '000' . sprintf('%04b', $opcode);
	$head .= (bool)$masked ? '1' : '0';
	if($l > 65535) {
		$head .= decbin(127);
		$head .= sprintf('%064b', $l);
	}elseif($l > 125) {
		$head .= decbin(126);
		$head .= sprintf('%016b', $l);
	}else
		$head .= sprintf('%07b', $l);
	$frame = '';
	foreach(str_split($head, 8) as $binstr)
		$frame .= chr(bindec($binstr));
	$mask = '';
	if($masked) {
		for($i = 0;$i < 4;++$i)
			$mask .= chr(rand(0, 255));
		$frame .= $mask;
	}
	for($i = 0;$i < $l;++$i)
		$frame .= ($masked === true) ? $data[$i] ^ $mask[$i % 4] : $data[$i];
	return $frame;
}
function wss_write($socket, $data, $opcode = 1, $masked = null, $final = null){
	if(!is_resource($socket))
		new APError('wss_write', 'Invalid socket', APError::WARNING, APError::TTHROW);
	return fwrite($socket, wss_encode($data, $opcode, $masked, $final));
}
function wss_receive($socket){
	if(!is_resource($socket))
		new APError('wss_receive', 'Invalid socket', APError::WARNING);
	$data = fread($socket, 2);
	if($data === false)
		new APError('wss_receive', 'Could not receive data', APError::WARNING, APError::TTHROW);
	if(strlen($data) === 1)
		$data .= fgetc($socket);
	if($data === false || strlen($data) < 2)
		new APError('wss_receive', 'Could not receive data', APError::WARNING, XMError::TTHROW);
	$final = ord($data[0]) & 1 << 7;
	$rsv1 = ord($data[0]) & 1 << 6;
	$rsv2 = ord($data[0]) & 1 << 5;
	$rsv3 = ord($data[0]) & 1 << 4;
	$opcode = ord($data[0]) & 31;
	$masked = ord($data[1]) >> 7;
	$payload = '';
	$length = ord($data[1]) & 127;
	if($length > 125) {
		$temp = $length === 126 ? fread($socket, 2) : fread($socket, 8);
		if($temp === false)
			new APError('wss_receive', 'Could not receive data', APError::WARNING, APError::TTHROW);
		$length = '';
		for($i = 0;$i < strlen($temp);++$i)
			$length .= sprintf('%08b', ord($temp[$i]));
		$length = bindec($length);
	}
	$mask = '';
	if($masked) {
		$mask = fread($socket, 4);
		if($mask === false)
			new APError('wss_receive', 'Could not receive mask data', APError::WARNING, APError::TTHROW);
	}
	if($length > 0) {
		$temp = stream_get_contents($socket);
		if($masked)
			for($i = 0;$i < $length;++$i)
				$payload .= $temp[$i] ^ $mask[$i % 4];
		else
			$payload = $temp;
	}
	if($opcode === WSS_CLOSE)
		new APError('wss_receive', 'Client disconnect', APError::NETWORK, APError::TTHROW);
	return $final ? $payload : $payload . wss_receive($socket);
}
*/
if(__apeip_data::$instMySQLi){
	function mysqli_quote($string){
		return str_replace(array('\\', '`'), array('\\\\', '\\`'), $string);
	}
}
function preg_string($pattern, $subject, $flags = null, $offset = 0){
	preg_match_all($pattern, $subject, $matches, $flags, $offset);
	return implode('', $matches[0]);
}
function preg_range_list($list, $notnot = false){
	if(!$notnot && $list[0] == '^'){
		$not = true;
		$list = substr($list, 1);
	}else
		$not = false;
	$list = preg_replace_callback("/\\\\\\\\|\\\\-|(?:.|\n)-(?:.|\n)/", function($range){
		if($range[0] == '\\\\')
			return '\\';
		if($range[0] == '\\-')
			return '-';
		return implode('', range($range[0][0], $range[0][2]));
	}, $list);
	if($not)
		$list = str::xor_chars(str::ASCII_RANGE, $list);
	return str_split($list);
}
function preg_range_repeat($list, $from = 0, $to = null){
	if($to === null)$to = count($list);
	if($from < 0 || $to < 0)return false;
	if($to < $from)$to = 0;
	$ranges = array();
	while($from++ <= $to){
		if($from == 1)
			continue;
		$range = $list;
		for($i = 1;$i < $from - 1;++$i){
			$arr = array();
			foreach($range as $r)
				foreach($list as $c)
					$arr[] = $r . $c;
			$range = $arr;
		}
		$ranges[] = $range;
	}
	if($ranges === array())
		return array();
	return call_user_func_array('array_merge', $ranges);
}
function preg_range($pattern){
	if($pattern === '')
		return array();
	if(in_array($pattern[0], array('/', '#', '|')) && ($p = strrpos($pattern, $pattern[0])) !== 0){
		$flags = substr($pattern, $p);
		$pattern = substr($pattern, 1, $p - 1);
	}else $flags = '';
	$i = strpos($flags, 'i') !== false;
	$range = array('');
	preg_replace_callback("/(?:\[(?:\\\]|[^\]])+\]|(?<x>\((?:\g<x>|\\\\\)|\[(?:\\\]|[^\]])+\]|[^\)])*\))|".
		"(?<!\\\\)(?:\|(?:.|\n)*|\+(?:.|\n)*|\*(?:.|\n)*|\^(?:.|\n)*)|".
		"(?:\\\\\\\\|\\\\[0-7]{1,3}|\\\\x[0-9a-fA-F]{1,2}|\\\\b[01]{1,8}|\\\\u[0-9a-fA-F]{1,4}|\\\\[^x0-9bnrtveu]|".
		"\\\\.|.|\s))(?:\{(?:[0-9]+|[0-9]+,[0-9]+|,[0-9]+|[0-9]+,)\}|)/", function($block)use(&$range, $i){
		$block = $block[0];
		switch($block){
			case '\\\\':
				$list = array('\\');
			break;
			case '\"':
				$list = array('"');
			break;
			case "\\'":
				$list = array("'");
			break;
			case '\n':
				$list = array("\n");
			break;
			case '\r':
				$list = array("\r");
			break;
			case '\t':
				$list = array("\t");
			break;
			case '\e':
				$list = array("\e");
			break;
			case '\v':
				$list = array("\v");
			break;
			case '\f':
				$list = array("\f");
			break;
			case '\s':
				$list = array(' ', "\n", "\r", "\t");
			break;
			case '\S':
				$list = str_split(str_replace(array(' ', "\n", "\r", "\t"), '', str::ASCII_RANGE));
			break;
			case '\d':
				$list = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
			break;
			case '\D':
				$list = str_split(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), '', str::ASCII_RANGE));
			break;
			case '\w':
				$list = str_split(str::WORD_RANGE);
			break;
			case '\W':
				$list = str_split(str_replace(str_split(str::WORD_RANGE), '', str::ASCII_RANGE));
			break;
			case '.':
				$list = str::$ASCII_LIST;
			break;
			case '\R':
				$list = array("\r\n");
			break;
			case '\h':
				$list = array(' ', "\t");
			break;
			case '\H':
				$list = str_split(str_replace(array(' ', "\t"), '', str::ASCII_RANGE));
			break;
			case '\K':
				$range = array('');
			break;
			case '\L':
				$list = str_split(str::LOWER_RANGE);
			break;
			case '\U':
				$list = str_split(str::UPPER_RANGE);
			break;
			case '[[:alnum:]]':
				$list = str_split(str::WORD_RANGE);
			break;
			case '[[:alpha:]]':
				$list = str_split(str::ALPHBA_RANGE);
			break;
			case '[[:ascii:]]':
				$list = str::$ASCII_LIST;
			break;
			case '[[:blank:]]':
				$list = array(' ', "\t");
			break;
			case '[[:cntrl:]]':
				$list = str_split(str::CONTROL_RANGE);
			break;
			default:
				switch($block[0]){
					case '\\':
						$p = strpos($block, '{');
						if(is_numeric($block[1]))
							$list = array(chr(octdec(substr($block, 1, $p === false ? strlen($block) - 1 : $p))));
						elseif($block[1] == 'x')
							$list = array(chr(hexdec(substr($block, 2, $p === false ? strlen($block) - 2 : $p))));
						elseif($block[1] == 'b')
							$list = array(chr(bindec(substr($block, 2, $p === false ? strlen($block) - 2 : $p))));
						elseif($block[1] == 'u')
							$list = array(aped::jsondecode('"' . substr($block, 0, $p === false ? strlen($block) : $p) . '"'));
						else $list = array($block[1]);
					break;
					case '|':
						$range = array_merge($range, preg_range(substr($block, 1)));
					break;
					case '+':
						$list = preg_range(substr($block, 1));
						$arr = array();
						foreach($range as $r)
							foreach($list as $c)
								$arr[] = $r . $c;
						$range = array_merge($range, $arr);
					break;
					case '*':
						$list = preg_range(substr($block, 1));
						$arr = array();
						foreach($range as $r)
							foreach($list as $c)
								$arr[] = $r . $c;
						$range = array_merge($range, $list, $arr);
					break;
					case '^':
						$list = preg_range(substr($block, 1));
						$arr = array();
						foreach($range as $r)
							if(array_search($list, $r) === false)
								$arr[] = $r;
						$range = $arr;
					break;
					case '[':
						if($block[strlen($block) - 1] == '}'){
							$p = strrpos($block, ']');
							$repeat = explode(',', substr($block, $p + 2, -1), 2);
							$block = substr($block, 1, $p - 1);
							if($repeat[0] === '')
								$repeat[0] = 0;
							else $repeat[0] = (int)$repeat[0];
							if(!isset($repeat[1]))
								$repeat[1] = $repeat[0];
							elseif($repeat[1] === '')
								$repeat[1] = null;
							else
								$repeat[1] = (int)$repeat[1];
						}else{
							$block = substr($block, 1, -1);
							$repeat = array(1, 1);
						}
						$list = preg_range_repeat(preg_range_list($block), $repeat[0], $repeat[1]);
						$arr = array();
						foreach($range as $r)
							foreach($list as $c)
								$arr[] = $r . $c;
						$range = $arr;
					return '';
					case '(':
						if($block[strlen($block) - 1] == '}'){
							$p = strrpos($block, ')');
							$repeat = explode(',', substr($block, $p + 2, -1), 2);
							$block = substr($block, 1, $p - 1);
							if($repeat[0] === '')
								$repeat[0] = 0;
							else $repeat[0] = (int)$repeat[0];
							if(!isset($repeat[1]))
								$repeat[1] = $repeat[0];
							elseif($repeat[1] === '')
								$repeat[1] = null;
							else
								$repeat[1] = (int)$repeat[1];
						}else{
							$block = substr($block, 1, -1);
							$repeat = array(1, 1);
						}
						$list = preg_range_repeat(preg_range($block), $repeat[0], $repeat[1]);
						$arr = array();
						foreach($range as $r)
							foreach($list as $c)
								$arr[] = $r . $c;
						$range = $arr;
					return '';
					default:
						if(isset($block[3]) && $block[1] == '{'){
							$repeat = explode(',', substr($block, 2, -1));
							if($repeat[0] === '')
								$repeat[0] = 0;
							else $repeat[0] = (int)$repeat[0];
							if(!isset($repeat[1]))
								$repeat[1] = $repeat[0];
							elseif($repeat[1] === '')
								$repeat[1] = null;
							else
								$repeat[1] = (int)$repeat[1];
						}else
							$repeat = array(1, 1);
						$block = $i ? array_unique(array(strtolower($block), strtoupper($block))) : array($block);
						$list = preg_range_repeat($block, $repeat[0], $repeat[1]);
						$arr = array();
						foreach($range as $r)
							foreach($list as $c)
								$arr[] = $r . $c;
						$range = $arr;
					return '';
				}
		}
		if(isset($list)){
			if($block[strlen($block) - 1] == '}'){
				$p = strrpos($block, '{');
				$repeat = explode(',', substr($block, $p + 1, -1));
				if($repeat[0] === '')
					$repeat[0] = 0;
				else $repeat[0] = (int)$repeat[0];
				if(!isset($repeat[1]))
					$repeat[1] = $repeat[0];
				elseif($repeat[1] === '')
					$repeat[1] = null;
				else
					$repeat[1] = (int)$repeat[1];
			}else
				$repeat = array(1, 1);
			$list = preg_range_repeat($list, $repeat[0], $repeat[1]);
			$arr = array();
			foreach($range as $r)
				foreach($list as $c)
					$arr[] = $r . $c;
			$range = $arr;
		}
		return '';
	}, $pattern);
	if($range === array(''))
		return array();
	return $range;
}
function preg_rand($pattern){
	if($pattern === '')
		return array();
	if(in_array($pattern[0], array('/', '#', '|')) && ($p = strrpos($pattern, $pattern[0])) !== 0){
		$flags = substr($pattern, $p);
		$pattern = substr($pattern, 1, $p - 1);
	}else $flags = '';
	$i = strpos($flags, 'i') !== false;
	$rand = '';
	preg_replace_callback("/(?:\[(?:\\\]|[^\]])+\]|(?<x>\((?:\g<x>|\\\\\)|\[(?:\\\]|[^\]])+\]|[^\)])*\))|".
	"(?<!\\\\)(?:\|(?:.|\n)*|\+(?:.|\n)*|\*(?:.|\n)*|\^(?:.|\n)*)|".
	"(?:\\\\\\\\|\\\\[0-7]{1,3}|\\\\x[0-9a-fA-F]{1,2}|\\\\b[01]{1,8}|\\\\u[0-9a-fA-F]{1,4}|\\\\[^x0-9bnrtveu]|".
	"\\\\.|.|\s))(?:\{(?:[0-9]+|[0-9]+,[0-9]+|,[0-9]+|[0-9]+,)\}|)/", function($block)use(&$rand, $i){
		$block = $block[0];
		switch($block){
			case '\\\\':
				$list = array('\\');
			break;
			case '\"':
				$list = array('"');
			break;
			case "\\'":
				$list = array("'");
			break;
			case '\n':
				$list = array("\n");
			break;
			case '\r':
				$list = array("\r");
			break;
			case '\t':
				$list = array("\t");
			break;
			case '\e':
				$list = array("\e");
			break;
			case '\v':
				$list = array("\v");
			break;
			case '\f':
				$list = array("\f");
			break;
			case '\s':
				$list = array(' ', "\n", "\r", "\t");
			break;
			case '\S':
				$list = str_split(str_replace(array(' ', "\n", "\r", "\t"), '', str::ASCII_RANGE));
			break;
			case '\d':
				$list = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
			break;
			case '\D':
				$list = str_split(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'), '', str::ASCII_RANGE));
			break;
			case '\w':
				$list = str_split(str::WORD_RANGE);
			break;
			case '\W':
				$list = str_split(str_replace(str_split(str::WORD_RANGE), '', str::ASCII_RANGE));
			break;
			case '.':
				$list = str::$ASCII_LIST;
			break;
			case '\R':
				$list = array("\r\n");
			break;
			case '\h':
				$list = array(' ', "\t");
			break;
			case '\H':
				$list = str_split(str_replace(array(' ', "\t"), '', str::ASCII_RANGE));
			break;
			case '\K':
				$range = array('');
			break;
			case '\L':
				$list = str_split(str::LOWER_RANGE);
			break;
			case '\U':
				$list = str_split(str::UPPER_RANGE);
			break;
			case '[[:alnum:]]':
				$list = str_split(str::WORD_RANGE);
			break;
			case '[[:alpha:]]':
				$list = str_split(str::ALPHBA_RANGE);
			break;
			case '[[:ascii:]]':
				$list = str::$ASCII_LIST;
			break;
			case '[[:blank:]]':
				$list = array(' ', "\t");
			break;
			case '[[:cntrl:]]':
				$list = str_split(str::CONTROL_RANGE);
			break;
			default:
				switch($block[0]){
					case '\\':
						$p = strpos($block, '{');
						if(is_numeric($block[1]))
							$list = array(chr(octdec(substr($block, 1, $p === false ? strlen($block) - 1 : $p))));
						elseif($block[1] == 'x')
							$list = array(chr(hexdec(substr($block, 2, $p === false ? strlen($block) - 2 : $p))));
						elseif($block[1] == 'b')
							$list = array(chr(bindec(substr($block, 2, $p === false ? strlen($block) - 2 : $p))));
						elseif($block[1] == 'u')
							$list = array(aped::jsondecode('"' . substr($block, 0, $p === false ? strlen($block) : $p) . '"'));
						else $list = array($block[1]);
					break;
					case '|':
						$rand .= preg_rand(substr($block, 1));
					break;
					case '+':
						if(rand(0, 1) === 1)
							$rand .= preg_rand(substr($block, 1));
					break;
					case '*':
						switch(rand(0, 2)){
							case 0:
								$rand = preg_rand(substr($block, 1));
							break;
							case 1:
								$rand.= preg_rand(substr($block, 1));
						}
					break;
					case '[':
						if($block[strlen($block) - 1] == '}'){
							$p = strrpos($block, ']');
							$repeat = explode(',', substr($block, $p + 2, -1), 2);
							$block = substr($block, 1, $p - 1);
							if($repeat[0] === '')
								$repeat[0] = 0;
							else $repeat[0] = (int)$repeat[0];
							if(!isset($repeat[1]))
								$repeat[1] = $repeat[0];
							elseif($repeat[1] === '')
								$repeat[1] = null;
							else
								$repeat[1] = (int)$repeat[1];
						}else{
							$block = substr($block, 1, -1);
							$repeat = array(1, 1);
						}
						$list = preg_range_list($block);
						$l = count($list);
						if($repeat[1] === null)$repeat[1] = $l;
						$l = floor(rand($repeat[0] * $l, $repeat[1] * $l) / $l);
						for($c = 0;$c++ < $l;)
							$rand .= $list[array_rand($list)];
					return '';
					case '(':
						if($block[strlen($block) - 1] == '}'){
							$p = strrpos($block, ')');
							$repeat = explode(',', substr($block, $p + 2, -1), 2);
							$block = substr($block, 1, $p - 1);
							if($repeat[0] === '')
								$repeat[0] = 0;
							else $repeat[0] = (int)$repeat[0];
							if(!isset($repeat[1]))
								$repeat[1] = $repeat[0];
							elseif($repeat[1] === '')
								$repeat[1] = 1;
							else
								$repeat[1] = (int)$repeat[1];
						}else{
							$block = substr($block, 1, -1);
							$repeat = array(1, 1);
						}
						$l = rand($repeat[0], $repeat[1]);
						for($c = 0;$c++ < $l;)
							$rand .= preg_rand($block);
					return '';
					default:
						if(isset($block[3]) && $block[1] == '{'){
							$repeat = explode(',', substr($block, 2, -1));
							if($repeat[0] === '')
								$repeat[0] = 0;
							else $repeat[0] = (int)$repeat[0];
							if(!isset($repeat[1]))
								$repeat[1] = $repeat[0];
							elseif($repeat[1] === '')
								$repeat[1] = 1;
							else
								$repeat[1] = (int)$repeat[1];
						}else
							$repeat = array(1, 1);
						$block = $i ? array_unique(array(strtolower($block), strtoupper($block))) : array($block);
						$l = rand($repeat[0], $repeat[1]);
						for($c = 0;$c++ < $l;)
							$rand .= $block[array_rand($block)];
					return '';
				}
		}
		if(isset($list)){
			if($block[strlen($block) - 1] == '}'){
				$p = strrpos($block, '{');
				$repeat = explode(',', substr($block, $p + 1, -1));
				if($repeat[0] === '')
					$repeat[0] = 0;
				else $repeat[0] = (int)$repeat[0];
				if(!isset($repeat[1]))
					$repeat[1] = $repeat[0];
				elseif($repeat[1] === '')
					$repeat[1] = null;
				else
					$repeat[1] = (int)$repeat[1];
			}else
				$repeat = array(1, 1);
			$list = preg_range_repeat($list, $repeat[0], $repeat[1]);
			$arr = array();
			foreach($range as $r)
				foreach($list as $c)
					$arr[] = $r . $c;
			$range = $arr;
		}
		return '';
	}, $pattern);
	return $rand;
}
function get_timeout_time(){
	return (isset(apeip::$requestTime) ? apeip::$requestTime : __apeip_data::$startTime) + ini_get('max_execution_time');
}
define('M_DEG', M_PI / 180);
define('M_RAD', 180 / M_PI);
function show_errors($type = null){
	if($type === null)$type = E_USER_NOTICE;
	ob_start();
	$log = ini_get('log_errors');
	if($log != '0'){
		ini_set('log_errors', '0');
		trigger_error('', $type);
		ini_set('log_errors', $log);
	}else
		trigger_error('', $type);
	return (bool)ob_get_clean();
}
/*
define('MINECRAFTPE_SERVER_PORT', 19132);
define('MINECRAFTPC_SERVER_PORT', 25565);
function minecraft_get_challenge($socket){
	if(!is_stream($socket))return false;
	$command = "\xfe\xfd\x9\1\2\3\4";
	fwrite($socket, $command, 7);
	$data = fread($socket, 4096);
	if(strlen($data) < 5 || $data[0] != $command[2])
		return false;
	return (int)substr($data, 5, -1);
}
function minecraft_get_status($socket, $challenge = null){
	if(!is_stream($socket))return false;
	if($challenge === null)$challenge = pack('N', minecraft_get_challenge($socket));
	if($challenge === false)return false;
	$command = "\xfe\xfd\0\1\2\3\4$challenge\0\0\0\0";
	fwrite($socket, $command);
	$data = fread($socket, 4096);
	if(strlen($data) < 5 || $data[0] != $command[2])
		return false;
	$last = '';
	$info = array();
	$data = substr($data, 11);
	$data = explode("\x00\x00\x01player_\x00\x00", $data);
	$players = substr($data[1], 0, -2);
	$data	= explode("\0", $data[0]);
	$keys = array(
		'hostname'   => 'hostname',
		'hostip'	 => 'hostip',
		'hostport'   => 'hostport',
		'version'	=> 'version',
		'plugins'	=> 'plugins',
		'gametype'   => 'gametype',
		'game_id'	=> 'gamename',
		'numplayers' => 'numplayers',
		'maxplayers' => 'maxplayers',
		'map'		=> 'map',
		'whitelist' => 'whitelist'
	);
	foreach($data as $key => $val){
		if(~$key & 1){
			if(!array_key_exists($val, $keys)){
				$last = false;
				continue;
			}
			$info[$last = $keys[$val]] = '';
		}elseif($last !== false)
			$info[$last] = mb_convert_encoding($val, 'UTF-8');
	}
	$info['numplayers']	 = (int)$info['numplayers'];
	$info['maxplayers' ] = (int)$info['maxplayers'];
	$info['hostport' ]   = (int)$info['hostport'];
	if($info['version'][0] == 'v')
		$info['version'] = substr($info['version'], 1);
	if(isset($info['whitelist']))
		$info['whitelist'] = $info['whitelist'] == 'on';
	if($info['plugins']){
		$data = explode(': ', $info['plugins'], 2);
		$info['rawplugins'] = $info['plugins'];
		$info['software']   = $data[0];
		if(count($data) == 2)
			$info['plugins'] = explode('; ', $data[1]);
	}else $info['software'] = 'Vanilla';
	if(!empty($players))
		$info['players'] = explode("\0", $players);
	return $info;
}
*/
define('VEC_ZIROBIT_LEFT', 1);
define('VEC_ZIROBIT_RIGHT', 2);
define('VEC_FLOORBIT_LEFT', 3);
define('VEC_FLOORBIT_RIGHT', 4);
define('VEC_BITS', 5);
function vec($input, $from = null, $length = null, $replacement = null, $zirobit = null){
	if($from === null)$from = strlen($input) * 8;
	elseif($from < 0)$from += strlen($input) * 8;
	if($length === null)$length = strlen($input) * 8;
	elseif($length < 0)$length += strlen($input) * 8;
	if($replacement === null){
		$input = substr(crypt::binencode(substr($input, $x = floor($from / 8), -floor(-($length + $from) / 8))), $from - $x, $length);
		return bindec($input);
	}
	$input = crypt::binencode($input);
	if(is_int($replacement))
		$input = substr_replace($input, str_pad(decbin($replacement), $length, '0', STR_PAD_LEFT), $from, $length);
	elseif(is_bool($replacement))
		$input = substr_replace($input, '', $from, $length);
	else $input = substr_replace($input, crypt::binencode($replacement), $from, $length);
	if($zirobit == 5)return $input;
	$l = strlen($input) % 8;
	if($l === 0)return crypt::bindecode($input);
	if($zirobit == 2)
		return crypt::bindecode($input . str_repeat('0', 8 - $l));
	if($zirobit == 3)
		return crypt::bindecode(substr($input, $l));
	if($zirobit == 4)
		return crypt::bindecode(substr($input, 0, -$l));
	return crypt::bindecode(str_repeat('0', 8 - $l) . $input);
}
function vec_replace($from, $to, $input, &$count = null){
	$from = crypt::binecode($from);
	$to = crypt::binencode($to);
	$input = crypt::binencode($input);
	$input = substr($input, 0, $offset) . str_replace($from, $to, substr($input, $offset), $count);
	return crypt::bindecode($input);
}
function is_passed_key($key, $array){
	if(!isset($array[$key]))return false;
	return (bool)preg_match(is_numeric($key) ? '/\[(?:' . floor($key) . "|\\\"$key\\\")\]=>\n  &/" :
		'/\[' . preg_quote(unce($key), '/') . "\]=>\n  &/", var_read($array));
}

// ---------- APEIP Mathology ---------- //
if(!defined('M_SQRTPI'))define('M_SQRTPI', sqrt(M_PI));
class Math {
	const PI = 3.1415926535897932384626433832795;
	const π = 3.1415926535897932384626433832795;
	const PHI = 1.618033988749894848204586834365638;
	const φ = 1.618033988749894848204586834365638;
	const E = 2.718281828459045235360287471352662497757247;
	const EP = 1.2912859970627;
	const OMEGA = 0.567143290409783872999968662210;
	const OMEGA_1 = 1.763222834351896710225201776951;
	const Ω = 0.567143290409783872999968662210;
	const ∞ = INF;
	const SCEP = 0.785398163397448309615660845819875721;
	const DEG = 0.017453292519943;
	const RAD = 57.29577951308232;
	const EULER = 0.57721566490153286060651209;
	const ESR = 1.444667861009766133658339108596; // e self root // e ** (1/e)

	const WW2H = 1.7786458333333333;
	const WH2W = 0.5622254758418741;
	const G = 9.80665;
	const AVOGADRO = 6.0221415E23;
	const SOL = 299792458;
	const SOLS = 3.33564095198E-9;

	public static $pn1000 = array(
		2,   3,   5,   7,   11,  13,  17,  19,  23,  29,  31,  37,  41,  43,
		47,  53,  59,  61,  67,  71,  73,  79,  83,  89,  97,  101, 103, 107,
		109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181,
		191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 251, 257, 263,
		269, 271, 277, 281, 283, 293, 307, 311, 313, 317, 331, 337, 347, 349,
		353, 359, 367, 373, 379, 383, 389, 397, 401, 409, 419, 421, 431, 433,
		439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499, 503, 509, 521,
		523, 541, 547, 557, 563, 569, 571, 577, 587, 593, 599, 601, 607, 613,
		617, 619, 631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691, 701,
		709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787, 797, 809,
		811, 821, 823, 827, 829, 839, 853, 857, 859, 863, 877, 881, 883, 887,
		907, 911, 919, 929, 937, 941, 947, 953, 967, 971, 977, 983, 991, 997
	);
	public static $pp1000 = array(
		1,   2,   3,   4,   5,   7,   8,   9,   11,  13,  16,  17,  19,  23,
		25,  27,  29,  31,  32,  37,  41,  43,  47,  49,  53,  59,  61,  64,
		67,  71,  73,  79,  81,  83,  89,  97,  101, 103, 107, 109, 113, 121,
		125, 127, 128, 131, 137, 139, 149, 151, 157, 163, 167, 169, 173, 179,
		181, 191, 193, 197, 199, 211, 223, 227, 229, 233, 239, 241, 243, 251,
		256, 257, 263, 269, 271, 277, 281, 283, 289, 293, 307, 311, 313, 317,
		331, 337, 343, 347, 349, 353, 359, 361, 367, 373, 379, 383, 389, 397,
		401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479,
		487, 491, 499, 503, 509, 512, 521, 523, 529, 541, 547, 557, 563, 569,
		571, 577, 587, 593, 599, 601, 607, 613, 617, 619, 625, 631, 641, 643,
		647, 653, 659, 661, 673, 677, 683, 691, 701, 709, 719, 727, 729, 733,
		739, 743, 751, 757, 761, 769, 773, 787, 797, 809, 811, 821, 823, 827,
		829, 839, 841, 853, 857, 859, 863, 877, 881, 883, 887, 907, 911, 919,
		929, 937, 941, 947, 953, 961, 967, 971, 977, 983, 991, 997
	);
	public static $factorials = array(
		2, 6, 24, 120, 720, 5040, 40320, 362880, 3628800, 39916800, 479001600,
		6227020800, 87178291200, 1307674368000, 20922789888000, 3.55687428096E+14,
		6.402373705728E+15, 1.2164510040883E+17, 2.4329020081766E+18,
		5.1090942171709E+19, 1.1240007277776E+21, 2.5852016738885E+22,
		6.2044840173324E+23, 1.5511210043331E+25, 4.0329146112661E+26,
		1.0888869450418E+28, 3.0488834461171E+29, 8.8417619937397E+30,
		2.6525285981219E+32, 8.2228386541779E+33, 2.6313083693369E+35,
		8.6833176188119E+36, 2.952327990396E+38, 1.0333147966386E+40,
		3.719933267899E+41, 1.3763753091226E+43, 5.230226174666E+44,
		2.0397882081197E+46, 8.159152832479E+47, 3.3452526613164E+49,
		1.4050061177529E+51, 6.0415263063374E+52, 2.6582715747884E+54,
		1.1962222086548E+56, 5.5026221598121E+57, 2.5862324151117E+59,
		1.2413915592536E+61, 6.0828186403427E+62, 3.0414093201713E+64,
		1.5511187532874E+66, 8.0658175170945E+67, 4.2748832840601E+69,
		2.3084369733925E+71, 1.2696403353659E+73, 7.1099858780487E+74,
		4.0526919504877E+76, 2.3505613312829E+78, 1.3868311854569E+80,
		8.3209871127417E+81, 5.0758021387724E+83, 3.1469973260387E+85,
		1.9826083154044E+87, 1.2688693218588E+89, 8.2476505920823E+90,
		5.4434493907745E+92, 3.6471110918189E+94, 2.4800355424369E+96,
		1.7112245242815E+98, 1.197857166997E+100, 8.5047858856786E+101,
		6.1234458376888E+103, 4.4701154615128E+105, 3.3078854415193E+107,
		2.4809140811395E+109, 1.8854947016661E+111, 1.4518309202829E+113,
		1.1324281178206E+115, 8.9461821307824E+116, 7.1569457046267E+118,
		5.7971260207476E+120, 4.7536433370131E+122, 3.9455239697207E+124,
		3.3142401345653E+126, 2.8171041143805E+128, 2.4227095383672E+130,
		2.1077572983795E+132, 1.8548264225739E+134, 1.6507955160907E+136,
		1.4857159644817E+138, 1.3520015276784E+140, 1.2438414054642E+142,
		1.1567725070816E+144, 1.0873661566567E+146, 1.0329978488239E+148,
		9.9167793487096E+149, 9.6192759682484E+151, 9.4268904488831E+153,
		9.3326215443944E+155, 9.3326215443942E+157, 9.4259477598378E+159,
		9.6144667150351E+161, 9.9029007164857E+163, 1.0299016745145E+166,
		1.0813967582402E+168, 1.1462805637346E+170, 1.2265202031961E+172,
		1.3246418194518E+174, 1.4438595832025E+176, 1.5882455415227E+178,
		1.7629525510901E+180, 1.9745068572212E+182, 2.2311927486599E+184,
		2.5435597334722E+186, 2.9250936934928E+188, 3.3931086844518E+190,
		3.9699371608087E+192, 4.6845258497543E+194, 5.5745857612076E+196,
		6.6895029134494E+198, 8.0942985252732E+200, 9.8750442008327E+202,
		1.2146304367026E+205, 1.5061417415112E+207, 1.8826771768889E+209,
		2.3721732428799E+211, 3.0126600184573E+213, 3.8562048236256E+215,
		4.974504222477E+217, 6.4668554892202E+219, 8.4715806908782E+221,
		1.1182486511961E+224, 1.4872707060908E+226, 1.9929427461617E+228,
		2.6904727073183E+230, 3.6590428819525E+232, 5.0128887482753E+234,
		6.9177864726192E+236, 9.6157231969406E+238, 1.3462012475719E+241,
		1.8981437590763E+243, 2.695364137888E+245, 3.85437071718E+247,
		5.5502938327392E+249, 8.0479260574722E+251, 1.1749972043909E+254,
		1.7272458904546E+256, 2.556323917873E+258, 3.8089226376306E+260,
		5.7133839564464E+262, 8.6272097742343E+264, 1.3113358856835E+267,
		2.0063439050959E+269, 3.0897696138477E+271, 4.7891429014634E+273,
		7.4710629262823E+275, 1.1729568794265E+278, 1.8532718694938E+280,
		2.946702272495E+282, 4.714723635992E+284, 7.5907050539471E+286,
		1.2296942187395E+289, 2.0044015765454E+291, 3.2872185855343E+293,
		5.423910666132E+295, 9.0036917057796E+297, 1.5036165148651E+300,
		2.5260757449733E+302, 4.269068009005E+304, 7.2574156153089E+306
	);
	public static $dblfactorials = array(
		2, 720,
		6.2044840173324E23,
		6.6895029134491E198,
	);
	public static $tetfact = array(
		2 => 2,
		3 => 9,
		4 => 262144
	);
	public static $groups = array(
		'mathieu' => array(
			11 => 7920,
			12 => 95040,
			22 => 443520,
			23 => 10200960,
			24 => 244823040
		),
		'janko' => array(
			1 => 175560,
			2 => 604800,
			3 => 50232960,
			4 => 86775571046077562880
		),
		'conway' => array(
			3 => 495766656000,
			2 => 42305421312000,
			1 => 4157776806543360000
		),
		'fischer' => array(
			22 => 64561751654400,
			23 => 4089470473293004800,
			24 => 1255205709190661721292800
		),
		'higman-sims' => 44352000,
		'mclaughlin' => 898128000,
		'held' => 4030387200,
		'rudvalis' => 145926144000,
		'suzuki-sporadic' => 448345497600,
		'onan' => 460815505920,
		'harada-norton' => 273030912000000,
		'lyons' => 51765179004000000,
		'thompson' => 90745943887872000,
		'baby-monster' => 4154781481226426191177580544000000,
		'moster' => 808017424794512875886459904961710757005754368000000000
	);

	public static function invFunc($f, $y, $d = 2, $c = null){
		$x = 1;
		if($c === null)$c = PHP_INT_MAX / $d;
		$l = 1;
		$y = (string)$y;
		while($y != (string)$r = $f($x)){
			if($r < $y){
				if($l == -1){
					$c /= $d;
					$l = 1;
				}
			}else
				if($l == 1){
					$c /= $d;
					$l = -1;
				}
			$x += $l * $c;
		}
		return $x;
	}
	public static function goFunc($f, $d = 3, $c = null){
		$x = 1;
		if($c === null)$c = PHP_INT_MAX / $d;
		$l = 1;
		while(0 != $r = $f($x)){
			if($r == 1){
				if($l == -1){
					$c /= $d;
					$l = 1;
				}
			}else
				if($l == 1){
					$c /= $d;
					$l = -1;
				}
			$x = ($p = $x) + $l * $c;
			if($p == $x)break;
		}
		return $x;
	}
	public static function equFunc($f1, $f2, $d = 3, $c = null){
		$x = 1;
		if($c === null)$c = PHP_INT_MAX / $d;
		$l = 1;
		while(((string)$r1 = $f1($x)) != (string)$r2 = $f2($x)){
			if($r1 < $r2){
				if($l == -1){
					$c /= $d;
					$l = 1;
				}
			}else
				if($l == 1){
					$c /= $d;
					$l = -1;
				}
			$x += $l * $c;
		}
		return $x;
	}

	public static function findIntDiv($n, $m = 1){
		if($n == floor($n))return $n;
		if($n < 0){
			$n = self::findIntDiv(-$n, $m);
			return array(-$n[0], $n[1]);
		}
		if($n < 1){
			for($a = 1; true; ++$a)
				for($b = 1; $b * $m < $a; ++$b)
					if($b * $m / $a == $n)
						return array($a, $b);
		}else
			for($a = 1; true; ++$a)
				for($b = 1; $b / $m < $a; ++$b)
					if($a * $m / $b == $n)
						return array($a, $b);
	}

	public static function average(){
		$nums = func_get_args();
		if(is_array($nums[0]))
			$nums = $nums[0];
		$c = count($nums);
		return array_sum($nums) / $c;
	}
	public static function averagesqrt(){
		$nums = func_get_args();
		if(is_array($nums[0]))
			$nums = $nums[0];
		$c = count($nums);
		return pow(array_product($nums), 1 / $c);
	}
	public static function pre($x, $y){
		return $x === 0 ? 0 : 100 / ($y / $x);
	}
	public static function map($a, $b, $c, $d, $e){
		if($b == $c)
			return $b;
		return ($a / ($c - $b)) * ($e - $d) + $d;
	}
	public static function fact($n){
		if($n >= 171)return INF;
		if($n <= 1)return 1;
		return self::$factorials[$n - 2];
	}
	public static function dblfact($n){
		$n = (int)$n;
		if($n > 5)return INF;
		if($n < 2)return 1;
		return self::$dblfactorials[$n - 2];
	}
	public static function gcd($a, $b){
		return $b > 0 ? self::gcd($b, $a % $b) : $a;
	}
	public static function lcm($a, $b){
		return $a * $b / self::gcd($a, $b);
	}
	public static function infdiv($a, $b){
		if($a == 0 && $b == 0)return 0;
		if($b == 0)return INF;
		return $a / $b;
	}
	public static function floord($a, $x){
		if($a == floor($a))
			return $a;
		return floor($a) + substr($a - floor($a), 0, $x + 2);
	}
	public static function factors($x){
		if($x == 0)return array(INF);
		$r = array();
		$y = sqrt($x = $x < 0 ? -$x : $x);
		for($c = 1; $c <= $y; ++$c)
			if($x % $c == 0) {
				$r[] = $c;
				if($c != $y)$r[] = $x / $c;
			}
		sort($r);
		return $r;
	}
	public static function discriminant($a, $b, $c){
		return $b * $b - (4 * $a * $c);
	}
	public static function native($x){
		if($x < 0)$x = -$x;
		if($x == 0)return 0;
		$y = (int)sqrt($x);
		for($c = 2; $c <= $y; ++$c)
		if($x % $c == 0)return $c;
		return $x;
	}
	public static function natives($x){
		if($x < 0)$x = -$x;
		if($x == 0)return array(0);
		$r = array();
		for($c = 1; $c <= $x; ++$c)
		if($x % $c == 0)$r[] = $c;
		return $r;
	}
	public static function tree($x){
		if($x == 0)return array(0);
		$r = array($l = self::native($x));
		while(($x /= $l) > 1)$r[] = $l = self::native($x);
		return $r;
	}
	public static function pnan($x){
		if($x == 0)return array();
		$a = array(1);
		for($c = 2;$c < $x;++$c)
			if(self::gcd($x,$c) == 1)
				$a[] = $c;
		return $a;
	}
	public static function isprime($x){
		if($x < 0)$x = -$x;
		if($x == 0 || $x == 1)return false;
		$y = (int)sqrt($x);
		for($c = 2; $c <= $y; ++$c)
		if($x % $c == 0)return false;
		return true;
	}
	public static function pnprime($x){
		if($x == 1000)return self::$pn1000;
		if($x < 0){
			$a = array();
			for($c = 2; $c < $x; ++$c)
				if(self::isprime($c))
					$a[] = -$c;
			return $a;
		}
		$a = array();
		for($c = 2; $c < $x; ++$c)
			if(self::isprime($c))
				$a[] = $c;
		return $a;
	}
	public static function prand($x = -0xffff, $y = 0xffff){
		if($y < $x)swap($x, $y);
		$r = rand($x, $y);
		for($i = 0; true; ++$i)
			if($r - $i >= $x){
				if(self::isprime($r - $i))
					return $r - $i;
			}elseif($r + $i <= $y){
				if(self::isprime($r + $i))
					return $r + $i;
			}else return false;
	}
	public static function nearprime($r){
		for($i = 0; true; ++$i)
			if(self::isprime($r - $i))
				return $r - $i;
			elseif(self::isprime($r + $i))
				return $r + $i;
	}
	public static function prevprime($x){
		while(--$x)
			if(self::isprime($x))
				return $x;
	}
	public static function nextprime($x){
		while(++$x)
			if(self::isprime($x))
				return $x;
	}
	public static function cprime($x){
		$a = 0;
		for($c = 2;$c < $x;++$c)
			if(self::isprime($c))
				++$a;
		return $a;
	}
	public static function phi($x){
		if($x == 0)return 0;
		$n = 1;
		for($c = 2; $c < $x; ++$c)
			if(self::gcd($x, $c) == 1)
				++$n;
		return $n;
	}
	public static function nphi($x){
		if($x == 0)return 0;
		for($c = 2; $c < $x; ++$c)
			if(self::gcd($x, $c) == 1)
				return $c;
		return false;
	}
	public static function pnphi($x){
		if($x == 0)return 0;
		$n = array();
		for($c = 2; $c < $x; ++$c)
			if(self::gcd($x, $c) == 1)
				$n[] = $c;
		return $n;
	}
	public static function isPrimePower($x){
		if($x == 0)return false;
		if($x == 1 || $x == -1)return true;
		$s = floor(sqrt($x));
		for($i = 2; $i <= $s; ++$i)
			if($x % $i == 0)
				if(self::gcd($i, $x / $i) == 1)
					return false;
		return true;
	}
	public static function getPrimePower($x){
		if($x == 0)return false;
		if($x == 1 || $x == -1)return true;
		$s = floor(sqrt($x));
		for($i = 2; $i <= $s; ++$i)
			if($x % $i == 0)
				if(self::gcd($i, $k = $x / $i) == 1)
					return array($i, $k);
		return true;
	}
	public static function pnPrimePower($x){
//		if($x == 1000)return self::$pp1000;
		if($x < 0){
			$a = array();
			for($c = 1; $c < $x; ++$c)
				if(self::isPrimePower($c))
					$a[] = -$c;
			return $a;
		}
		$a = array();
		for($c = 1; $c < $x; ++$c)
			if(self::isPrimePower($c))
				$a[] = $c;
		return $a;
	}
	public static function pprand($x = -0xffff, $y = 0xffff){
		if($y < $x)swap($x, $y);
		$r = rand($x, $y);
		for($i = 0; true; ++$i)
			if($r - $i >= $x){
				if(self::isPrimePower($r - $i))
					return $r - $i;
			}elseif($r + $i <= $y){
				if(self::isPrimePower($r + $i))
					return $r + $i;
			}else return false;
	}
	public static function nearPrimePower($r){
		for($i = 1; true; ++$i)
			if(self::isPrimePower($r - $i))
				return $r - $i;
			elseif(self::isPrimePower($r + $i))
				return $r + $i;
	}
	public static function prevPrimePower($x){
		while(--$x)
			if(self::isPrimePower($x))
				return $x;
	}
	public static function nextPrimePower($x){
		while(++$x)
			if(self::isPrimePower($x))
				return $x;
	}
	public static function cPrimePower($x){
		$a = 0;
		for($c = 1;$c < $x;++$c)
			if(self::isPrimePower($c))
				++$a;
		return $a;
	}
	public static function umod($a, $b){
		$a %= $b;
		return $a < 0 ? $a + ($b < 0 ? -$b : $b) : $a;
	}
	public static function fumod($a, $b){
		$a -= floor($a / $b);
		return $a < 0 ? $a + ($b < 0 ? -$b : $b) : $a;
	}
	public static function clamp($x, $y, $z){
		return max($y, min($x, $z));
	}
	public static function nmod($x, $y){
		if($x % $y === 0)
			return 0;
		return $y - $x % $y;
	}
	public static function components($x){
		$f = floor($x);
		return ($f == $x ? 0 : 1 / ($x - $f)) + ($f == 0 ? 0 : 1 / $f);
	}
	public function littleEndianWord($arr, $off){
		return (($arr[$off + 3] << 24 & 0xff000000 | $arr[$off + 2] << 16 & 0xff0000 | $arr[$off + 1] << 8 & 0xff00 | $arr[$off] & 0xFF)
			<< ((PHP_INT_SIZE - 4) << 3)) >> ((PHP_INT_SIZE - 4) << 3);
	}
	public function littleEndianShort($arr, $off){
		return (($arr[$off + 1] << 8 & 0xff00 | $arr[$off] & 0xFF) << ((PHP_INT_SIZE - 2) << 3)) >> ((PHP_INT_SIZE - 2) << 3);
	}
	public function int2float($v) {
		$x = ($v & ((1 << 23) - 1)) + (1 << 23) * ($v >> 31 | 1);
		$exp = ($v >> 23 & 0xFF) - 127;
		return $x * pow(2, $exp - 23);
	}
	public function complex2float($data){
		return (float)($data & 0xFFFFFF00) * array_value(array(0.00390625, 3.051758E-005, 1.192093E-007, 4.656613E-010), ($data >> 4) & 3);
	}
	public static function safeint($x){
		if(is_int($x) || (php_uname('m') & "\xDF\xDF\xDF") != 'ARM')
			return $x;
		return (fmod($x, 0x80000000) & 0x7FFFFFFF) | ((fmod(floor($x / 0x80000000), 2) & 1) << 31);
	}
	public static function mdsrem($a, $b){
		for($i = 0; $i < 8; ++$i) {
			$t = 0xff & ($b >> 24);
			$b = ($b << 8) | (0xff & ($a >> 24));
			$a <<= 8;
			$u = $t << 1;
			if($t & 0x80)$u ^= 0x14d;
			$b ^= $t ^ ($u << 16);
			$u ^= 0x7fffffff & ($t >> 1);
			if($t & 0x01)$u ^= 0xa6;
			$b ^= ($u << 24) | ($u << 8);
		}
		return array(
			0xff & $b >> 24,
			0xff & $b >> 16,
			0xff & $b >>  8,
			0xff & $b
		);
	}

	public static function _powmod($b, $p, $m){
		if($p == 1)return $b % $m;
		if($p == 2)return $b * $b % $m;
		if($p == 3)return $b * ($b * $b % $m) % $m;
		if($p % 2 == 1)
			return $b * self::_powmod($b * $b % $m, ($p - 1) / 2, $m) % $m;
		else
			return self::_powmod($b * $b % $m, $p / 2, $m);
	}
	public static function powmod($b, $p, $m){
		if($m == 1 || $b == 0)return 0;
		if($b == 1 || $p == 0)return 1 % $m;
		if($m == 0){
			trigger_error('Division by zero', E_USER_WARNING);
			return INF;
		}
		if($p < 0)return floor(pow($b, $p)) % $m;
		if($b < 0)return -self::_powmod(-$b, $p, $m);
		return self::_powmod($b, $p, $m);
	}
	public static function _powfmod($b, $p, $m){
		if($p == 1)return fmod($b, $m);
		if($p == 2)return fmod($b * $b, $m);
		if($p == 3)return fmod($b * fmod($b * $b, $m), $m);
		if($p % 2 == 1)
			return fmod($b * self::_powmod($b * $b % $m, ($p - 1) / 2, $m), $m);
		else
			return self::_powmod(fmod($b * $b, $m), $p / 2, $m);
	}
	public static function powfmod($b, $p, $m){
		if($b == 0)return 0;
		if($b == 1 || $p == 0)return fmod(1, $m);
		if($m == 0){
			trigger_error('Division by zero', E_USER_WARNING);
			return INF;
		}
		if($p < 0)return fmod(pow($b, $p), $m);
		if($b < 0)return -self::_powfmod(-$b, $p, $m);
		return self::_powfmod($b, $p, $m);
	}
	public static function modInv26($x){ // a * x % 2 ** 26 = 1
		$x = (int)$x;
		$result = $x & 0x3;
		$result = ($result * (2 - $x * $result)) & 0xF;
		$result = ($result * (2 - ($x & 0xFF) * $result))  & 0xFF;
		$result = ($result * ((2 - ($x & 0xFFFF) * $result) & 0xFFFF)) & 0xFFFF;
		if(PHP_INT_SIZE == 8)
			return fmod($result * (2 - fmod($x * $result, 0x80000000)), 0x80000000) & 0x7FFFFFF;
		return fmod($result * (2 - fmod($x * $result, 0x40000000)), 0x40000000) & 0x3FFFFFF;
	}
	public static function modInv($x, $y, $n = 1){ // a * x % y = n
		for($a = 1; $a < $y; ++$a)
			if($a * $x % $y == $n)
				return $a;
		return false;
	}
	public static function logModInv($x, $y, $n = 1){ // a ** x % y = n
		for($a = 2; $a < $y; ++$a)
			if(self::powmod($a, $x, $y) == $n)
				return $a;
		return false;
	}
	public static function powModInv($x, $y, $n = 1){ // x ** a % y = n
		for($a = 1; $a < $y; ++$a)
			if(self::powmod($x, $a, $y) == $n)
				return $a;
		return false;
	}
	public static function factModInv($m, $n = 1){ // x! % m = n
		for($x = 2; $x < 171; ++$x)
			if(self::$factorials[$x - 2] % $m == $n)
				return $x;
		return false;
	}
	public static function combineModInv($x, $y, $z = null){ // a(ax % y) % z = ax % y , ax % y != 0
		if($z === null)$z = $y;
		$p = $y * $z;
		for($a = 1; $a < $p; ++$a)
			if(($r = $a * $x % $y) == $a * $r % $z && $r != 0)
				return $a;
		return false;
	}
	public static function modsInv($x, $y, $n = 1){ // z * xi % yi = ... = n
		if(!is_array($y)){
			if(!is_array($x)){
				for($z = 1; $z < $y; ++$z)
					if($z * $x % $y == $n)
						return $z;
				return false;
			}
			for($z = 1; $z < $y; ++$z){
				for($i = 0; isset($x[$i]); ++$i)
					if($z * $x[$i] % $y != $n)
						continue 2;
				return $z;
			}
			return false;
		}
		$p = array_product($y);
		if(!is_array($x)){
			for($z = 1; $z < $p; ++$z){
				for($i = 0; isset($y[$i]); ++$i)
					if($z * $x % $y[$i] != $n)
						continue 2;
				return $z;
			}
			return false;
		}
		for($z = 1; $z < $p; ++$z){
			for($i = 1; isset($x[$i]) && isset($y[$i]); ++$i)
				if($z * $x[$i] % $y[$i] != $n)
					continue 2;
			return $z;
		}
		return false;
	}
	public static function modsInvFamily($z, $x, $y, $p = null, $a = null, $b = null){
		if($p === 0)$p = null;
		if($a === 0)$a = null;
		if($b === 0)$b = null;
		$list = array();
		$n = $z * $x % $y;
		if($p === null)$p = $x * $y;
		if($a === null && $b === null)
			for($a = 2; $a < $p; ++$a)
				for($b = 1; $b < $p; ++$b){
					if($z * $a % $b == $n)
						$list[] = array($a, $b);
				}
		elseif($a === null)
			for($a = 2; $a < $p; ++$a){
				if($z * $a % $b == $n)
					$list[] = array($a, $b);
			}
		elseif($b === null)
			for($b = 1; $b < $p; ++$b){
				if($z * $a % $b == $n)
					$list[] = array($a, $b);
			}
		elseif($z * $a % $b == $n)
			$list[] = array($a, $b);
		return $list;
	}
	public static function allPowModInv($x, $n = 1){
		$list = array();
		for($i = 1; $i < $x; ++$i)
			for($a = 2; $a < $x; ++$a)
				if(pow($a, $i) % $x == $n)
					$list[] = array($i, $a);
		return $list;
	}
	public static function allCombineModInv($x, $p = null, $y = null, $z = null, $a = null){
		if($p === 0)$p = null;
		if($y === 0)$y = null;
		if($z === 0)$z = null;
		if($a === 0)$a = null;
		$list = array();
		if($p === null)$p = $x * $x;
		if($y === null && $z === null && $a === null){
			for($y = 1; $y < $p; ++$y)
				for($z = 1; $z < $p; ++$z)
					if($y != $z)
						for($a = 1; $a < $y * $z; ++$a)
							if(($r = $a * $x % $y) == $a * $r % $z && $r != 0)
								$list[] = array($a, $y, $z);
		}elseif($y === null && $z === null){
			for($y = 1; $y < $p; ++$y)
				for($z = 1; $z < $p; ++$z)
					if($y != $z && ($r = $a * $x % $y) == $a * $r % $z && $r != 0)
						$list[] = array($a, $y, $z);
		}elseif($z === null && $a === null){
			for($z = 1; $z < $p; ++$z)
				if($y != $z)
					for($a = 1; $a < $y * $z; ++$a)
						if(($r = $a * $x % $y) == $a * $r % $z && $r != 0)
							$list[] = array($a, $y, $z);
		}elseif($y === null && $a === null){
			for($y = 1; $y < $p; ++$y)
				if($y != $z)
					for($a = 1; $a < $y * $z; ++$a)
						if(($r = $a * $x % $y) == $a * $r % $z && $r != 0)
							$list[] = array($a, $y, $z);
		}elseif($z === null){
			for($z = 1; $z < $p; ++$z)
				if($y != $z && ($r = $a * $x % $y) == $a * $r % $z && $r != 0)
					$list[] = array($a, $y, $z);
		}elseif($y === null){
			for($y = 1; $y < $p; ++$y)
				if($y != $z && ($r = $a * $x % $y) == $a * $r % $z && $r != 0)
					$list[] = array($a, $y, $z);
		}elseif($a === null){
			if($y != $z)
				for($a = 1; $a < $y * $z; ++$a)
					if(($r = $a * $x % $y) == $a * $r % $z && $r != 0)
						$list[] = array($a, $y, $z);
		}elseif($y != $z && ($r = $a * $x % $y) == $a * $r % $z && $r != 0)
				$list[] = array($a, $y, $z);
		return $list;
	}
	public static function subgroup($x, $y){
		$a = array();
		for($i = 1; $i < $y; ++$i)
			$a[] = pow($x, $i) % $y;
		return array_unique($a);
	}

	public static function extendedGcd($a, $b){
		if($a == 0)return array($b, 0, 1);
		if($b == 0)return array($a, 1, 0);
		$x2 = $y1 = 1;
		$x1 = $y2 = 0;
		while($b > 0) {
			$q  = (int)($a / $b);
			$r  = $a % $b;
			$x  = $x2 - ($q * $x1);
			$y  = $y2 - ($q * $y1);
			$x2 = $x1;
			$x1 = $x;
			$y2 = $y1;
			$y1 = $y;
			$a  = $b;
			$b  = $r;
		}
		return array($a, $x2, $y2);
	}
	public static function digitsum($x, $b = 10){
		$l = log($x, $b);
		$d = 0;
		for($n = 0; $n <= $l; ++$n){
			$p = pow($b, $n);
			$d += ($x % ($p * $b) - $x % $p) / $p;
		}
		return $d;
	}
	public static function digitroot($x, $b = 10){
		$root = $x;
		while($root >= $b)$root = self::digitsum($root, $b);
		return $root;
	}
	public static function gamma($x){
		if($x <= 0)return false;
		if($x >= 172)
			return INF;
		$gamma = 0.577215664901532860606512090;
		if($x < 0.001)
			return 1 / ($x * ($gamma * $x + 1));
		if($x < 12){
			$y = $x;
			$n = 0;
			$awlto = $y < 1;
			if($awlto)
				$y += 1;
			else
				$y -= $n = floor($y) - 1;
			$p = array(
				-1.71618513886549492533811,
				 24.7656508055759199108314,
				-379.804256470945635097577,
				 629.331155312818442661052,
				 866.966202790413211295064,
				-31451.2729688483675254357,
				-36144.4134186911729807069,
				 66456.1438202405440627855
			);
			$q = array(
				-30.8402300119738975254353,
				 315.350626979604161529144,
				-1015.15636749021914166146,
				-3107.77167157231109440444,
				 22538.1184209801510330112,
				 4755.84627752788110767815,
				-134659.959864969306392456,
				-115132.259675553483497211
			);
			$num = 0;
			$den = 1;
			$z = $y - 1;
			for($i = 0; $i < 8; ++$i){
				$num = ($num + $p[$i]) * $z;
				$den = $den * $z + $q[$i];
			}
			$res = $num / $den + 1;
			if($awlto)
				$res /= $y - 1;
			else
				for($i = 0; $i < $n; ++$i)
					$res *= $y++;
			return $res;
		}
		return exp(self::logGamma($x));
	}
	public static function logGamma($x, $y = M_E){
		if($x < 0)return false;
		if($x < 12)
			return log(abs(self::gamma($x)), $y);
		if($y != M_E)
			return self::logGamma($x) / log($y);
		$c = array(
			0.083333333333333333333333333333, //  1 / 12
			-0.00277777777777777777777777777, // -1 / 360
			0.000793650793650793650793650793, //  1 / 1260
			-0.00059523809523809523809523809, // -1 / 1680
			0.000841750841750841750841750841, //  1 / 1188
			-0.00191752691752691752691752691, // -691 / 360360
			0.006410256410256410256410256410, //  1 / 156
			-0.02955065359477124183006535947  // -3617 / 122400
		);
		$z = 1 / ($x * $x);
		$sum = $c[7];
		for($i = 6; $i >= 0; --$i)
			$sum = ($sum * $z) + $c[$i];
		$half = 0.91893853320467274178032973640562;
		return ($x - 0.5) * log($x) - $x + $half + $sum / $x;
	}
	public static function Γ($n, $y = M_E){
		return self::gamma($n, $y);
	}
	public static function invGamma($n){
		return self::invFunc('math::gamma', $n);
	}
	public static function invFact($n){
		if($n <= 1)return 1;
		$search = array_search($n, self::$factorials);
		if($search == false)return false;
		return $search + 2;
	}
	public static function invDBLFact($n){
		if($n <= 1)return 1;
		$search = array_search($n, self::$dblfactorials);
		if($search == false)return false;
		return $search + 2;
	}
	public static function invGammaPDF($x, $a, $b){
		if($a <= 0 || $b <= 0)return NAN;
		return pow($b, $a) / self::gamma($a) * pow($x, -$a - 1) * exp(-$b / $a);
	}
	public static function invGammaCDF($x, $a, $b){
		if($a <= 0 || $b <= 0)return NAN;
		return self::gamma($a, $b / $x) / self::gamma($a);
	}
	public static function invGammaMean($a, $b){
		if($a <= 0 || $b <= 0)return NAN;
		if($a == 1)return INF;
		return $b / ($a - 1);
	}
	public static function invGammaMode($a, $b){
		if($a <= 0 || $b <= 0)return NAN;
		return $b / ($a + 1);
	}
	public static function invGammaVariance($a, $b){
		if($a <= 0 || $b <= 0)return NAN;
		return $b * $b / ($a - 1) / ($a - 1) / ($a - 2);
	}
	public static function invGammaSkewness($a){
		if($a <= 0 || $b <= 0)return NAN;
		return 4 * sqrt($a - 2) / ($a - 3);
	}
	public static function invGammaKurtosis($a){
		if($a <= 0 || $b <= 0)return NAN;
		return 6 * (5 * $a - 11) / ($a - 3) / ($a - 4);
	}
	public static function beta($x, $y){
		$args = func_get_args();
		if(is_array($args[0]))
			$args = $args[0];
		if(in_array(0, $args))
			return INF;
		$m = 1;
		foreach($args as $arg)
			$m *= self::gamma($arg);
		return $m / self::gamma(array_sum($args));
	}
	public static function β($x, $y){
		return call_user_func_array('math::beta', func_get_args());
	}
	public static function logistic($x0, $L, $k, $x){
		return $L / (exp(-$k * ($x - $x0)) + 1);
	}
	public static function sigmoid($t){
		return 1 / (exp(-$t) + 1);
	}
	public static function err($x){
		if($x == 0)return 0;
		$a = $x < 0 ? -$x : $x;
		$t = 1 / (0.3275911 * $a + 1);
		$t2 = $t * $t;
		$err = 1 - (
			0.254829592 * $t +
			-0.284496736 * $t2 +
			1.421413741 * $t2 * $t +
			-1.453152027 * $t2 * $t2 +
			1.061405429 * $t2 * $t2 * $t
		) * exp(-$a * $a);
		return $x < 0 ? -$err : $err;
	}
	public static function lowerIncompleteGamma($s, $x){
		if($s == 1)
			return 1 - exp(-$x);
		if($s == 0.5)
			return M_SQRTPI * self::err(sqrt($x));
		if((int)($s * 2) == $s * 2)
			return ($s - 1) * self::lowerIncompleteGamma($s - 1, $x) - pow($x, $s - 1) * exp(-$x);
		$e   = pow($x, $s) / exp($x) / $s;
		$sum	   = 1;
		$fractions = array();
		$element   = 1;
		while($element > 0) {
			$fractions[] = $x / ++$s;
			$sum += $element = array_product($fractions);
		}
		return $e * $sum;
	}
	public static function upperIncompleteGamma($s, $x){
		if($s <= 0)return false;
		return self::gamma($s) - self::lowerIncompleteGamma($s, $x);
	}
	public static function γ($s, $x){
		return self::lowerIncompleteGamma($s, $x);
	}
	private static function iBetaCF($m, $x, $a, $b){
		if($x < 0 || $x > 1 || $a <= 1 || $b <= 1)return false;
		$beta = self::beta($a, $b);
		$constant = pow($x, $a) * pow(1 - $x, $b) / $beta;
		$alphas = array();
		$betas = array();
		for($i = 0; $i < $m; ++$i) {
			if($i == 0)$alpha = 1;
			else $alpha = ($a + $i - 1) * ($a + $b + $i - 1) * $i * ($b - $i) * $x * $x / pow($a + 2 * $i - 1, 2);
			$b1 = $i + $i * ($b - $i) * $x / ($a + 2 * $i - 1);
			$b2 = ($a + $i) * ($a - ($a + $b) * $x + 1 + $i * (2 - $x)) / ($a + 2 * $i + 1);
			$beta = $b1 + $b2;
			$alphas[] = $alpha;
			$betas[] = $beta;
		}
		$fraction = array();
		for($i = $m - 1; $i >= 0; --$i)
			if($i == $m - 1)
				$fraction[$i] = $alphas[$i] / $betas[$i];
			else
				$fraction[$i] = $alphas[$i] / ($betas[$i] + $fraction[$i + 1]);
		return $constant * $fraction[0];
	}
	public static function regularizedIncompleteBeta($x, $a, $b){
		if($x < 0 || $x > 1 || $a <= 1 || $b <= 1)return false;
		if($x == 1 || $x == 0)return $x;
		if($a == 1)return 1 - pow(1 - $x, $b);
		if($b == 1)return pow($x, $a);
		if($x > 0.9 || $b > $a && $x > 0.5)
			return 1 - self::regularizedIncompleteBeta(1 - $x, $b, $a);
		if($a > 1 && $b > 1) {
			$dif	  = 1;
			$m		= 10;
			$I = 0;
			do {
				$n = self::iBetaCF($m, $x, $a, $b);
				if($m > 10)$dif = abs(($I - $n) / $n);
				$I = $n;
				++$m;
			}while($dif > 0);
			return $I;
		}
		$offset = pow($x, $a) * pow(1 - $x, $b) / $b / self::beta($a, $b);
		if($a <= 1)
			return self::regularizedIncompleteBeta($x, $a + 1, $b) + $offset;
		return self::regularizedIncompleteBeta($x, $a, $b + 1) - $offset;
	}
	public static function generalizedHypergeometric($p, $q){
		$args = array_slice(func_get_args(), 1);
		if(is_array($args[0]))
			$args = $args[0];
		$n = count($args);
		if($n != $p + $q + 1)return false;
		$a = array_slice($args, 0, $p);
		$b = array_slice($args, $p, $q);
		$z = $args[$n - 1];
		$n = 1;
		$sum = 0;
		$product = 1;
		do {
			$sum += $product;
			$as = array_product(array_map(function($x)use($n){
				return $x + $n - 1;
			}, $a));
			$bs = array_product(array_map(function($x)use($n){
				return $x + $n - 1;
			}, $b));
			$product *= $as * $z / $bs / $n;
			++$n;
		}while($product / $sum > 0);
		return $sum;
	}
	public static function confluentHypergeometric($a, $b, $z){
		return self::generalizedHypergeometric(1, 1, $a, $b, $z);
	}
	public static function hypergeometric($a, $b, $c, $z){
		if($z <= -1 || $z >= 1)return false;
		return self::generalizedHypergeometric(2, 1, $a, $b, $c, $z);
	}
	public static function derivative($f, $x, $d = null, $u = 2){
		if($d === null)$d = 1 / PHP_INT_MAX;
		do {
		$a = $f($x);
		$b = $f($x + $d);
		$d*= $u;
		if($d === INF)return false;
		}while($a == $b);
		return ($b - $a) / $d;
	}
	public static function cmp($x, $y){
		return $x == $y ? 0 : $x > $y ? 1 : -1;
	}
	public static function lambertW($x){ // x = y * e ** y
		if($x == 0)return 0;
		if($x == 1)return self::OMEGA;
		$n = 1;
		$t = $p = 0;
		if($x < M_E && $x > -M_E){
			if($x > 0.90609394281968 || $x < -0.90609394281968)
				return self::invFunc(function($x){
					return $x * exp($x);
				}, $x, 3);
			while($p != $n && $t != $n){
				$t = $p;
				$n = exp($p = $n);
				if($n == 0)return NAN;
				$n = $x / $n;
			}
			return $n;
		}
		while((string)$p != (string)$n)
			$n = ($p = $n) < 0 ? -log(-$x / $n) : log($x / $n);
		return $n;
	}
	public static function productLogBase($x, $a = M_E){ // x = y * a ** y
		if($x == 0)return 0;
		if($a == 1)return $x;
		if($a == 2 && $x == 4)return 1.4569995591346;
		$n = 1;
		$t = $p = 0;
		if($x < $a && $x > -$a){
			if($x > $a / 3 || $x < -$a / 3)
				return self::invFunc(function($x)use($a){
					return $x * pow($a, $x);
				}, $x, 3);
			while($p != $n && $t != $n){
				$t = $p;
				$n = pow($a, $p = $n);
				if($n == 0)return NAN;
				$n = $x / $n;
			}
			return $n;
		}
		while((string)$p != (string)$n)
			$n = ($n = $x / ($p = $n)) < 0 ? -log(-$n, $a) : log($n, $a);
		return $n;
	}
	public static function productLogPower($x, $p = 1){ // x = y ** p * e ** y
		if($p == 0)return log($x);
		return $p * self::lambertW(pow($x, 1 / $p) / $p);
	}
	public static function productLog($x, $b = M_E, $p = 1){ // x = y ** p * b ** y
		if($p == 0)return log($x, $b);
		return $p * self::productLogBase(pow($x, 1 / $p) / $p, $b);
	}
	public static function invPowEqual($x){ // y ** x = x ** y
		$l = log($x);
		return -$x * self::lambertW(-$l / $x) / $l;
	}
	public static function powBaseEqual($x, $a){ // a ** y = y ** x
		if($a <= 0)return NAN;
		$f = function($y)use($a, $x){
			$r1 = pow($a, $y);
			$r2 = pow($y, $x);
			return $r2 == $r1 ? 0 : $r2 > $r1 ? 1 : -1;
		};
		return self::goFunc($f, 3, ($x + $a) / 2);
	}
	public static function sign($x){
		return $x < 0 ? -1 : 1;
	}
	public static function titration($x, $a, $b, $c, $p = M_E){
		return $a / (1 + pow(-$x + $b, $p)) + $c;
	}
	public static function logSin($x){
		if($x > 26)return 0;
		if($x < -78)return INF;
		$n = 1;
		$f = 1;
		$p = 0;
		$c = 1;
		$o = 1;
		for($i = 1; $p != $n; ++$i)
			$n = ($p = $n) + ($f *= -1) * ($o *= $x) / ($c *= $i);
		return $n;
	}
	public static function logDown($x, $b = M_E){ // log(x - log(x - ...))
		$r = 0;
		do {
			$r = log($x - ($p = $r), $b);
		}while((string)$r != (string)$p);
		return $r;
	}
	public static function logUp($x, $b = M_E){ // log(x + log(x + ...))
		$r = 0;
		do {
			$r = log($x + ($p = $r), $b);
		}while((string)$r != (string)$p);
		return $r;
	}
	public static function productExp($x, $b = M_E){ // x = y * log(y, b)
		return $x / self::productLogBase($x, $b);
	}
	public static function productLogAdd($x, $b = M_E){ // x = y + b ** y
		return $x - self::productLogBase(pow($b, $x), $b);
	}
	public static function productLogSub($x, $b = M_E){ // x = y - b ** y
		return $x - self::productLogBase(-pow($b, $x), $b);
	}
	public static function lambertWBtet($x, $l = 1){
		if($l == 0)return $x;
		if($x == 0)return 0;
		$n = 1;
		$t = $p = 0;
		if($x < M_E && $x > -M_E){
			if($x > $a / 3 || $x < -$a / 3)
				return self::invFunc(function($x)use($l){
					$n = $x;
					for($i = 0; $i < $l; ++$i)
						$n = exp($n);
					return $x * $n;
				}, $x, 3);
			while($p != $n && $t != $n){
				$t = $p;
				$p = $n;
				for($i = 0; $i < $l; ++$i)
					$n = exp($n);
				if($n == 0)return NAN;
				$n = $x / $n;
			}
			return $n;
		}
		while((string)$p != (string)$n)
			if(($p = $n) < 0)
				for($i = 0; $i < $l; ++$i)
					$n = log($n);
			else
				for($i = 0; $i < $l; ++$i)
					$n = -log(-$n);
		return $n;
	}
	public static function productLogBtet($x, $l = 1, $a = M_E){
		if($l == 0)return $x;
		if($x == 0)return 0;
		$n = 1;
		$t = $p = 0;
		if($x < $a && $x > -$a){
			if($x > $a / 3 || $x < -$a / 3)
				return self::invFunc(function($x)use($a, $l){
					$n = $x;
					for($i = 0; $i < $l; ++$i)
						$n = pow($a, $n);
					return $x * $n;
				}, $x, 3);
			while($p != $n && $t != $n){
				$t = $p;
				$p = $n;
				for($i = 0; $i < $l; ++$i)
					$n = pow($a, $n);
				if($n == 0)return NAN;
				$n = $x / $n;
			}
			return $n;
		}
		while((string)$p != (string)$n)
			if(($p = $n) < 0)
				for($i = 0; $i < $l; ++$i)
					$n = log($n, $a);
			else
				for($i = 0; $i < $l; ++$i)
					$n = -log(-$n, $a);
		return $n;
	}
	public static function productLogX($x){ // x = y * y ** y // x = y ** (y + 1)
		return self::invFunc(function($x){
			return $x * pow($x, $x);
		}, $x);
		if($x === 1)return 1;
		$n = self::tetSqrt($x);
		$p = 0;
		while((string)$n != (string)$p)
			$n = self::productLogBase($x, $p = $n);
		return $n;
	}

	// tetration
	public static function tetFloor($x, $n){
		if($n == 0)return 1;
		if($n < 0)return 1 / self::tetFloor($x, -$n);
		$r = 1;
		for($i = 0; $i < $n; ++$i)
			$r = pow($x, $r);
		return $r;
	}
	public static function tetSqrt($x){ // x = y ** y
		$x = log($x);
		return $x / self::lambertW($x);
	}
	public static function tetSqrtLn($x, $a = M_E){ // x = y ** log(y, a)
		return pow($a, sqrt(log($x, $a)));
	}
	public static function tetFact($x){
		if($x <= 1)return 1;
		if($x >= 5)return INF;
		return self::$tetfact[$x];
	}

	// Multi Power
	public static function mpow($x, $y){ // Multi Power // x ** x ** y
		return pow($x, $x * $y);
	}
	public static function mipow($x, $p = M_E){ // Multiplicate In Power //x = (y ** y) ** p = y ** (py)
		$x = log($x);
		return $x / ($p * self::lambertW($x / $p));
	}
	public static function mlog($x, $b = M_E){ // Multi Logarithm // x = b ** b ** y
		return log(log($x, $b), $b);
	}
	public static function mroot($x, $p = 2){ // Multi Root // x = y ** y ** p
		if($p == 0)return $x;
		$x = log($x);
		return pow($p * $x / self::lambertW($p * $x), 1 / $p);
	}
	public static function msqrt($x){ // Multi Sqrt // x = b ** b
		$x = log($x);
		return $x / self::lambertW($x);
	}
	public static function mexp($x){ // E multi power // e ** e ** x
		return exp(exp($x));
	}
	public static function mLambertW($x){ // Multi LambertW // x = y * e ** e ** y
		return self::lambertWBtet($x, 2);
	}
	public static function mProductLog($x, $b){ // Multi ProductLog // x = y * b ** b ** y
		return self::productLogBtet($x, 2, $b);
	}

	// Sequences
	public static function fibonacci($n){
		if($n <= 0)return false;
		return pow(self::PHI, $n) / sqrt(5);
	}
	public static function bernoulineg($m){
		if($m < 0)$m = -$m;
		$r = 0;
		for($k = 0; $k < $m; ++$k)
			$r += self::binomial($m, $k) * self::bernoulineg($k) / ($m - $k + 1);
		return $m == 0 ? -$r : 1 - $r;
	}
	private static function bernouliun($m){
		if($m < 0)$m = -$m;
		$r = 0;
		for($k = 0; $k < $m; ++$k)
			$r += self::binomial($m, $k) * self::bernouli($k) / ($m - $k + 1);
		return 1 - $r;
	}
	public static function bernouli($m){
		return self::isneg($m) ? self::bernoulineg($m) : self::bernouliun($m);
	}
	public static function bell($n){
		$r = 0;
		$p = -1;
		for($k = 1; $p != $r; ++$k)
			$r = ($p = $r) + pow($k, $n) / self::fact($k);
		return $r / M_E;
	}
	public static function AlternatingGroup($n){
		if($n <= 4)return NAN;
		return self::gamma($n + 1) / 2;
	}
	public static function bessel($a, $x){
		if($a != floor($a) || $a < 0)return NAN;
		if($a > 72 + 0.1 / $a)return INF;
		$g = 1;
		$z = self::gamma($a + 1);
		$x /= 2;
		$w = pow($x, $a);
		$n = 1 / $z * $w;
		$p = 0;
		$f = 1;
		for($m = 1; $p != $n; ++$m)
			$n = ($p = $n) + ($g *= -1) / (($f *= $m) * ($z *= $m + $a)) * ($w *= $x * $x);
		return $n;
	}
	public static function dirichlet($s){
		$r = 0;
		$p = -1;
		$g = -1;
		for($n = 1; $p != $r; ++$n)
			$r = ($p = $r) + ($g *= -1) / pow($n, $s);
		return $r;
	}
	public static function zeta($s){
		$r = 0;
		$p = -1;
		for($n = 1; $p != $r; ++$n)
			$r = ($p = $r) + 1 / pow($n, $s);
		return $r;
	}
	public static function ζ($s){
		return self::zeta($s);
	}
	public static function laguerre($n, $x, $a = 0){
		return self::fact($n) / (self::fact($k) * self::fact($n - $k));
		$t = self::fact($n);
		if($a == 0){
			$r = 1;
			$p = 0;
			$f = 1;
			$w = 1;
			$g = 1;
			for($k = 1; $p != $r; ++$k)
				$r = ($k = $r) + $t / (self::fact($k) * self::fact($n - $k)) * ($g *= -1) / ($f *= $k) * ($w *= $x);
			return $r;
		}
		$u = self::fact($n + $a);
		$r = $u / ($t * self::fact($a));
		$p = 0;
		$f = 1;
		$w = 1;
		$g = 1;
		for($i = 0; $p != $r; ++$i)
			$r = ($k = $r) + $u / (self::fact($n - $i) * self::fact($a + $i)) * ($g *= -1) / ($f *= $i) * ($w *= $x);
		return $r;
	}
	public static function harmonic($n){
		$r = 0;
		for($k = 1; $k <= $n; ++$n)
			$r += 1 / $k;
		return $r;
	}

	// Graphic
	public static function distpositions($x1, $y1, $x2, $y2){
		return rad2deg(acos((sin(deg2rad($x1)) * sin(deg2rad($x2))) + (cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($y1 - $y2))))) * 111189.57696;
	}
	public static function distpoints($x1, $y1, $x2, $y2){
		return hypot($x2 - $x1, $y2 - $y1);
	}
	public static function unitCircle($points = 11){
		$n = $points - 1;
		$unit = array();
		for($i = 0; $i <= $n; ++$i)
			$unit[] = array(cos(2 * M_PI * $i / $n), sin(2 * M_PI * $i / $n));
		return $unit;
	}
	public static function bezier($x, $y, $z){
		return (((1 - 3 * $z + 3 * $y) * $x + (3 * $z - 6 * $y)) * $x + 3 * $y) * $x;
	}
	public static function slope($x, $y, $z){
		return 3 * (1 - 3 * $z + 3 * $y) * $x * $x + 5 * ($z - 2 * $y) * $x + 3 * $y;
	}
	public static function hypot($x, $y, $d = 90){
		return sqrt(pow($x, 2) + pow($y, 2) - 2 * $x * $y * cos(deg2rad($d)));
	}
	public static function triangle($number, $pow = 2){
		if($pow === 0)return 1;
		elseif($pow < 0)return 1 / self::triangle($number, -$pow);
		$n = $number;
		for($i = 1; $i < $pow; ++$i)
			$n *= $number + $i;
		return $n / self::fact($pow);
	}
	public static function binomial($n, $k){
		return self::fact($n) / (self::fact($k) * self::fact($n - $k));
	}
	public static function secondkind($n, $k){
		if($n == $k)return 1;
		$r = 0;
		for($i = 0; $i < $k; ++$i)
			$r += pow(-1, $i) * self::binomial($k, $i) * pow($k - $i, $n);
		return $r / self::fact($k);
	}
	public static function multinomial($ns, $ks){
		$n = $k = 1;
		foreach($ns as $x)$n *= self::fact($x);
		foreach($ks as $x)$k *= self::fact($x);
		return $n / $k;
	}
	public static function bernstein($x, $v, $n){
		return self::binomial($n, $v) * pow($x, $v) * pow(1 - $x, $n - $v);
	}
	public static function bezierCurve($t, $p){
		$n = count($p);
		$r = 0;
		for($i = 0; $i <= $n; ++$i)
			$r += self::bernstein($t, $i, $n) * $p[$i];
		return $r;
	}
	public static function nominal($x, $y){
		return (pow(($x + 1), (1 / $y)) - 1) * $y;
	}

	// Binary
	public static function onebits($x){
		if($x == 0)return 0;
		if($x < 0)$x = -$x;
		$y = 0;
		$l = floor(log($x, 2));
		while($l > 0)
			$y += ($x >> $l--) & 1;
		return $y + 1;
	}
	public static function zerobits($x){
		if($x == 0)return 1;
		if($x < 0)$x = -$x;
		$y = 0;
		$c = $l = floor(log($x, 2));
		while($l > 0)
			$y += ($x >> $l--) & 1;
		return $c - $y + 1;
	}
	public static function bitscount($x){
		return strlen(decbin($x < 0 ? -$x : $x));
	}
	public static function brev($bin, $len = null){
		if($bin === 0)return 0;
		$clone = $bin;
		$bin = 0;
		$count = 0;
		if($len === null)
			while($clone > 0) {
				++$count;
				$bin <<= 1;
				$bin |= $clone & 0x1;
				$clone >>= 1;
			}
		else
			while($count < $len) {
				++$count;
				$bin <<= 1;
				$bin |= $clone & 0x1;
				$clone >>= 1;
			}
		return (int)$bin;
	}
	public static function bin($x){
		$l = strlen(decbin(PHP_INT_MAX));
		return $x < 0 ? '1' . binc::neg(str_pad(decbin(~$x), $l, '0', STR_PAD_LEFT)) : str_pad(decbin($x), $l, '0', STR_PAD_LEFT);
	}
	public static function unbin($x){
		if($x === '' || !is_binary($x))return false;
		return $x[0] === '1' ? ~bindec(binc::neg(substr($x, 1))) : bindec(substr($x, 1));
	}
	public static function neg($x){
		return bindec(binc::neg(decbin($x)));
	}
	public static function isneg($x){
		$x = (string)$x;
		return $x[0] === '-';
	}
	public static function bmax($x){
		return (1 << strlen(decbin($x < 0 ? -$x : $x))) - 1;
	}
	public static function res($x, $y){
		return $y | ($x ^ $y);
	}
	public static function bset($number, $pos, $b = null){
		return (((($number >> ($pos + 1)) << 1) | ($b !== false ? 1 : 0)) << $pos) | ($number & ((1 << $pos) - 1));
	}
	public static function bget($number, $pos){
		return (($number >> $pos) & 1) === 1;
	}
	public static function bdel($number, $pos){
		return (($number >> ($pos + 1)) << $pos) | ($number & ((1 << $pos) - 1));
	}
	public static function bappend($number, $pos, $b = null){
		return (((($number >> $pos) << 1) | ($b !== false ? 1 : 0)) << $pos) | ($number & ((1 << $pos) - 1));
	}
	public static function bswap($number, $p1, $p2){
		list($p1, $p2) = array(min($p1, $p2), max($p1, $p2));
		return self::bset(self::bset($number, $p1, (($number >> $p2) & 1) === 1), $p2, (($number >> $p1) & 1) === 1);
	}
	public static function bneg($number, $pos){
		return self::bset($number, $pos, (($number >> $pos) & 1) === 0);
	}
	public static function blad($number, $pos){
		$l = strlen(decbin($number < 0 ? -$number : $number));
		return ($number >> $pos) | (($number & ((1 << $pos) - 1)) << ($l - $pos));
	}
	public static function bsub($number, $start, $length = null){
		return $length === null ? $number >> $start : ($number >> $start) & ((1 << $length) - 1);
	}
	public static function bsubdel($number, $start, $length = null){
		return $length === null ? $number & ((1 << $start) - 1) : $number & ((1 << $start) - 1) | (($number >> ($start + $length)) << $start);
	}
	public static function brep($number, $to, $start, $length = null){
		if($length === 0)$length = strlen(decbin($to < 0 ? -$to : $to));
		$l = strlen(decbin($number < 0 ? -$number : $number));
		return $length === null ? ($number & ((1 << $start) - 1)) | ($to << $start) : ($number & ((1 << $start) - 1)) |
			(($to & ((1 << $length) - 1)) << $start) | (($number & ((1 << ($l - $start - $length)) - 1)) << ($start + $length));
	}
	public static function bput($number, $to, $start, $length = null){
		$tl = strlen(decbin($to < 0 ? -$to : $to));
		if($length === 0)$length = $tl;
		$l = strlen(decbin($number < 0 ? -$number : $number));
		return $length === null ? ($number & ((1 << $start) - 1)) | ($to << $start) | (($number & ((1 << ($l - $start)) - 1)) << ($start + $tl)) :
			($number & ((1 << $start) - 1)) | (($to & ((1 << $length) - 1)) << $start) | (($number & ((1 << ($l - $start - $length)) - 1)) << $start);
	}
	public static function shrrr($a, $b){
		return ($a & 0xffffffff) >> ($b & 0x1f);
	}
	public static function shrr($a, $b){
		return ($a & 0x80000000 ? $a | 0xffffffff00000000 : $v & 0xffffffff) >> ($b & 0x1f);
	}
	public static function shll($a, $b){
		return ($t = ($a & 0xffffffff) << ($b & 0x1f)) & 0x80000000 ? $t | 0xffffffff00000000 : $t & 0xffffffff;
	}
	public static function rtr($x, $y){
		return ($x >> $y) | (($x & (1 << ($y - 1))) << $y);
	}
	public static function rtl($x, $y){
		return (($x << $y) & PHP_INT_MAX) | ($x >> (PHP_INT_SIZE * 8 - $y));
	}
	public static function rtr32($x, $y){
		$x &= 0xffffffff;
		return ($x >> $y) | (($x & (1 << ($y - 1))) << $y) & 0xffffffff;
	}
	public static function rtl32($x, $y){
		$x &= 0xffffffff;
		return (($x << $y) & 0xffffffff) | ($x >> (PHP_INT_SIZE * 8 - $y));
	}
	public function rl64($x, $shift){
		return ($x << $shift) | (($x >> (64 - $shift)) & ((1 << $shift) - 1));
	}
	public static function rl32($x, $shift){
		if($shift < 32)
			list($hi, $lo) = $x;
		else {
			$shift-= 32;
			list($lo, $hi) = $x;
		}
		return array(
			($hi << $shift) | (($lo >> (32 - $shift)) & (1 << $shift) - 1),
			($lo << $shift) | (($hi >> (32 - $shift)) & (1 << $shift) - 1)
		);
	}
	public static function shru($a, $b){
		return $b == 0 ? $a : ($a >> $b) & ~(1 << (8 * PHP_INT_SIZE - 1) >> ($b - 1));
	}
	public static function shl64($x, $shift){
		return ($x << $shift) | (($x >> (64 - $shift)) & ((1 << $shift) - 1));
	}
	public static function shl32($x, $shift){
		return ($x << $shift) | ($x >> (32 - $shift));
	}

	// Roots
	public static function roots($arg){
		if(!is_array($arg))
			$arg = func_get_args($arg);
		if(!isset($arg[0]))return false;
		if(!isset($arg[1]))$arg[1] = 0;
		switch(count($arg)){
			case 2:
				return array(-$arg[1] / $arg[0]);
			case 3:
				list($a, $b, $c) = $arg;
				if($a == 0)
					return -$b / $c;
				$d = $b * $b - 4 * $a * $c;
				if($d < 0)return array();
				if($d == 0)return array(-$b / (2 * $a));
				$d = sqrt($d);
				return array(
					($d - $b) / (2 * $a),
					(-$b - $d) / (2 * $a)
				);
			break;
			case 4:
				list($a, $b, $c, $d) = $arg;
				if($a == 0)
					return self::roots(array($b, $c, $d));
				$b /= $a;
				$c /= $a;
				$d /= $a;
				$Q = (3 * $c - $b * $b) / 9;
				$R = (9 * $b * $c - 27 * $d - 2 * $b * $b * $b) / 54;
				$D = $Q * $Q * $Q + $R * $R;
				if($D < 0) {
					$g = acos($R / sqrt(-$Q * $Q * $Q));
					$x = 2 * sqrt(-$Q);
					return array(
						$x * cos($g / 3) - ($b / 3),
						$x * cos(($g + 2 * M_PI) / 3) - ($b / 3),
						$x * cos(($g + 4 * M_PI) / 3) - ($b / 3)
					);
				}
				$S = pow($R + sqrt($D), 1 / 3);
				$T = pow($R - sqrt($D), 1 / 3);
				if($D == 0)
					return array(
						-$b / 3 - ($S + $T) / 2,
						$S + $T - $b / 3
					);
				return array($S + $T - $b / 3);
			break;
			case 5:
				list($a, $b, $c, $d, $e) = $arg;
				if($a == 0)
					return self::roots(array($b, $c, $d, $e));
				$b /= $a;
				$c /= $a;
				$d /= $a;
				$e /= $a;
				$a = 1;
				if($e == 0)
					return array_merge(array(0), self::roots(array($a, $b, $c, $d)));
				if($b == 0 && $d == 0) {
					$roots = self::roots(array($a, $c, $e));
					rsort($roots);
					$a = sqrt($roots[0]);
					$b = sqrt($roots[1]);
					return array($a, -$a, $b, -$b);
				}
				if($b == 0) {
					$p = $c;
					$q = $d;
					$r = $e;
					$roots = self::roots(array(8, 8 * $p, 2 * $p * $p - 8 * $r, -1 * $q * $q));
					$m = $roots[0];
					$roots1 = self::roots(array(1, sqrt(2 * $m), $p / 2 + $m - $q / 2 / sqrt(2 * $m)));
					$roots2 = self::roots(array(1,-sqrt(2 * $m), $p / 2 + $m + $q / 2 / sqrt(2 * $m)));
					$d1 = 2 * $m - 2 * ($p + $m - $q / sqrt(2 * $m));
					$d2 =-2 * $m - 2 * ($p + $m * 2 + $q / sqrt(2 * $m));
					return $d1 > $d2 ? array_merge($roots1, $roots2) : array_merge($roots2, $roots1);
				}
				$p = $c - (3 * $b * $b / 8);
				$q = $d + $b * $b * $b / 8 - $b * $c / 2;
				$r = $e - 3 * pow($b, 4) / 256 + $b * $b * $c / 16 - $b * $d / 4;
				$roots = self::roots(array(1, 0, $p, $q, $r));
				$b /= 4;
				return array_map(function($x)use($b){
					return -($x + $b);
				}, $roots);
			break;
		}
	}
	public static function equation($root, $mathometic = false){
		if(!is_array($root))
			$root = func_get_args($root);
		elseif($mathometic){
			$args = self::equation($root);
			$count = count($args);
			$string = 'x^' . ($count - 1);
			for($i = $count - 2; $i > 0; --$i)
				$string .= $args[$i] == 0 ? '' : ($args[$i] < 0 ? $args[$i] : '+' . $args[$i]) . 'x^' . $i;
			return $string;
		}
		if(!isset($root[0]))return false;
		$count = count($root);
		$arg = array(array_sum($root));
		for($i = 2; $i < $count; ++$i)
			$arg[] = array_sum(arr::map_repeat_unique($root, $i));
		$arg[] = array_product($root);
		return $arg;
	}

	// base functions
	public static function baseconvert($text, $from = false, $to = false){
		if(is_string($from) && strtolower($from) == "ascii")return self::baseconvert(bin2hex($text), str::HEX_RANGE, $to);
		if(is_string($to) && strtolower($to) == "ascii"){
			$r = self::baseconvert($text, $from, str::HEX_RANGE);
			if(strlen($r) % 2 == 1)$r = '0'.$r;
			return hex2bin($r);
		}
		$text = (string)$text;
		if(!is_array($from))$fromel = str_split($from);
		else $fromel = $from;
		if($from == $to)return $text;
		$frome = array();
		foreach($fromel as $key => $value) {
			$frome[$value] = $key;
		}
		unset($fromel);
		$fromc = count($frome);
		if(!is_array($to))$toe = str_split($to);
		else $toe = $to;
		$toc = count($toe);
		$texte = array_reverse(str_split($text));
		$textc = count($texte);
		$bs = 0;
		$th = 1;
		if($from === false) {
			$bs = $text;
		}
		else {
			for($i = 0; $i < $textc; ++$i) {
				$bs = $bs + @$frome[$texte[$i]] * $th;
				$th = $th * $fromc;
			}
		}
		$r = '';
		if($to === false)return $bs;
		while($bs > 0) {
			$r = $toe[$bs % $toc] . $r;
			$bs = floor($bs / $toc);
		}
		return $r;
	}
	public static function base_convert($str, $from, $to = 10){
		if($from == 1) {
			$str = (string)strlen($str);
			$from = 10;
		}
		if($from == $to)return $str;
		if($from <= 36 && is_numeric($from))$str = strtolower($str);
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/+=';
		$from = strtolower($from) == "ascii" ? "ascii" : substr($chars, 0, $from);
		$to = strtolower($to) == "ascii" ? "ascii" : substr($chars, 0, $to);
		$to = $to == '0123456789' ? false : $to;
		$from = $from == '0123456789' ? false : $from;
		return self::baseconvert($str, $from, $to);
	}
	public static function strdec($str){
		return base_convert(crypt::hexencode($str), 16, 10);
	}
	public static function decstr($dec){
		return crypt::hexdecode(base_convert($dec, 10, 16));
	}
	public static function float_precision($set = null){
		if(!$set)
			return ini_get('precision');
		return ini_set('precision', $set == -1 ? 400 : $set);
	}

	// calc function
	private static function calcarg($calc, $offset = null){
		preg_match('/(?:(?:(?<x>\((?:\g<x>|\\\\\(|\\\\\)|[^\)])*\))|\\\\\"|[^\"])*\"|[^,])+/', $calc, $match, 0, $offset === null ? 0 : $offset);
		return isset($match[0]) ? self::calc($match[0]) : 0;
	}
	public static function calc($calc){
		$calc = preg_replace('/(PI|π|PHI|φ|E|EP|OMEGA|Ω|∞|SCEP|DEG|RAD|EULER)([0-9])/', '$1*$2', $calc);
		$calc = preg_replace('/([0-9])(PI|π|PHI|φ|E|EP|OMEGA|Ω|∞|SCEP|DEG|RAD|EULER)/', '$1*$2', $calc);
		$calc = str_replace(array('PI', 'π', 'PHI', 'φ', 'E', 'EP', 'OMEGA', 'Ω', '∞', 'SCEP', 'DEG', 'RAD', 'EULER'),
			array(math::PI, math::PI, math::PHI, math::PHI, math::E, math::EP, math::OMEGA, math::OMEGA, INF, math::SCEP, math::DEG, math::RAD, math::EULER),
			$calc);
		$calc = preg_replace_callback('/\"(?:\\\\\\\\|\\\\\"|[^\"])*\"|(?:0|0o|o)[0-7]+|(?:0x|x)[0-9a-f]+|(?:0b|b)[01]+|\.[0-9]+|[0-9]+\./i', function($x){
			if(substr($x[0], -1) == '.')return substr($x[0], 0, -1);
			switch($x[0][0]){
				case '.':
					return '0' . $x[0];
				case '"':
					return self::strdec(substr($x[0], 1, -1));
				case 'o':
					return octdec(substr($x[0], 1));
				case 'x':
					return hexdec(substr($x[0], 1));
				case 'b':
					return bindec(substr($x[0], 1));
				case '0':
					switch($x[0][1]){
						case 'o':
							return octdec(substr($x[0], 2));
						case 'x':
							return hexdec(substr($x[0], 2));
						case 'b':
							return bindec(substr($x[0], 2));
						default:
							return octdec(substr($x[0], 1));
					}
			}
		}, $calc);
		$calc = str_replace(array('<=>', ' ', "\n", "\r", "\t"), array('^', '', '', '', ''), $calc);
		do{
			$calc = str_replace(array('--', '-+', '+-', '++'), array('+', '-', '-', '+'), $prev = $calc);
		}while($prev != $calc);
		$calc = preg_replace('/(?!<[a-zA-Z])([0-9])(\(|\[|[a-zA-Z])/', '$1*$2', $calc);
		do{
			$end = substr($calc, -1);
			if($end === '+' || $end === '-')
				$calc .= '1';
			$calc = preg_replace_callback('/(?<![a-zA-Z])\((?:\\\\\(|\\\\\)|\"(?:\\\\|\\\"|[^\"])*\"|[^\(\)])*\)/', function($x){
				return self::calc(substr($x[0], 1, -1));
			}, $prev = $calc);
			$calc = preg_replace_callback('/(?<![a-zA-Z])\[(?:\\\\\[|\\\\\]|\"(?:\\\\|\\\"|[^\"])*\"|[^\[\]])*\]/', function($x){
				return floor(self::calc(substr($x[0], 1, -1), 0));
			}, $calc);
			$calc = preg_replace_callback('/(abs|acos|acosh|asin|asinh|atan|atan2|atanh|base|ceil|cos|cot|csc|deg|exp|expm1|floor|fmod|fumod|hypot|lcg|log|log10|log1p|max|min|pi|phi|rad|rand|round|sec|sin|sinh|sqrt|tan|tanh)(?:(?<x>\((?:\g<x>|\\\\\(|\\\\\)|[^\)])*\))|(?:\g<x>|\\\\\(|\\\\\)|[^\)])*)/', function($x){
				$args = substr($x[2], 1, -1);
				switch($x[1]){
					case 'abs':
						return abs(self::calcarg($args));
					case 'acos':
						return acos(self::calcarg($args));
					case 'acosh':
						return acosh(self::calcarg($args));
					case 'asin':
						return asin(self::calcarg($args));
					case 'asinh':
						return asinh(self::calcarg($args));
					case 'atan':
						return atan(self::calcarg($args));
					case 'atan2':
						$arg = self::calcarg($args);
						return atan2($arg, self::calcarg($args, strlen($arg) + 1));
					case 'atanh':
						return atanh(self::calcarg($args));
					case 'base':
						$arg1 = self::calcarg($args);
						$len  = strlen($arg1) + 1;
						$arg2 = self::calcarg($args, $len);
						$arg3 = self::calcarg($args, strlen($arg2) + $len + 1);
						if($arg2 === '')$arg2 = '10';
						if($arg3 === '')$arg3 = '10';
						return base_convert($arg1, $arg2, $arg3);
					case 'ceil':
						return ceil(self::calcarg($args));
					case 'cos':
						return cos(self::calcarg($args));
					case 'cot':
						return 1 / tan(self::calcarg($args));
					case 'csc':
						return 1 / cos(self::calcarg($args));
					case 'deg':
						return rad2deg(self::calcarg($args));
					case 'exp':
						return exp(self::calcarg($args));
					case 'expm1':
						return expm1(self::calcarg($args));
					case 'floor':
						return floor(self::calcarg($args));
					case 'fmod':
						return self::fmod(self::calcarg($args));
					case 'fumod':
						return self::fumod(self::calcarg($args));
					case 'hypot':
						$arg = self::calcarg($args);
						return hypot($arg, self::calcarg($args, strlen($arg) + 1));
					case 'lcg':
						return lcg_value();
					case 'log':
						$arg = self::calcarg($args);
						return log($arg, self::calcarg($args, strlen($arg) + 1));
					case 'ln':
						return log(self::calcarg($args));
					case 'max':
					case 'min':
						$arg = array();
						$now = self::calcarg($args);
						$len = strlen($now) + 1;
						while($len !== 1){
							$arg[] = $now;
							$now = self::calcarg($args, $len);
							$len += strlen($now) + 1;
						}
						return call_user_func_array($x[1], $arg);
					case 'nmod':
						return self::nmod(self::calcarg($args));
					case 'pi':
						return M_PI;
					case 'phi':
						return self::PHI;
					case 'rad':
						return deg2rad(self::calcarg($args));
					case 'rand':
						$arg = self::calcarg($args);
						return rand($arg, self::calcarg($args, strlen($arg) + 1));
					case 'round':
						return round(self::calcarg($args));
					case 'sec':
						return 1 / sin(self::calcarg($args));
					case 'sin':
						return sin(self::calcarg($args));
					case 'sinh':
						return sinh(self::calcarg($args));
					case 'sqrt':
						return sqrt(self::calcarg($args));
					case 'tan':
						return tan(self::calcarg($args));
					case 'tanh':
						return tanh(self::calcarg($args));
					case 'umod':
						return self::umod(self::calcarg($args));
				}
			}, $calc);
			foreach(array(
				array(1, '~'),
				array(1, '\*\*', '\*\/', '\*%'),
				array(1, '\*', '\/', '%'),
				array(1, '\+', '-'),
				array(1, '_'),
				array(1, '>>', '<<', '<>>', '<<>', '<>'),
				array(1, '&', '\|', '^', '=>', '=<'),
				array(2, '!', '~'),
				array(3, '!', '~'),
				array(1, '&&', '\|\|', '==', '!=', '<=', '>=', '<', '>'),
			) as $signs){
				$regex = implode('|', array_slice($signs, 1));
				switch($signs[0]){
					case 1:
						$calc = preg_replace_callback("/(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)($regex)(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)/", function($x){
							switch($x[2]){
								case '~':
									return rand((int)$x[1], (int)$x[3]);
								case '**':
									return pow((float)$x[1], (float)$x[3]);
								case '*/':
									return pow((float)$x[1], 1 / (float)$x[3]);
								case '*%':
									return pow((float)$x[1], (int)$x[3]);
								case '*':
									return ((float)$x[1]) * ((float)$x[3]);
								case '/':
									return ((float)$x[1]) / ((float)$x[3]);
								case '%':
									return ((float)$x[1]) % ((float)$x[3]);
								case '+':
									return ((float)$x[1]) + ((float)$x[3]);
								case '-':
									return ((float)$x[1]) - ((float)$x[3]);
								case '_':
									return strpos($x[3], '.') === false ? $x[1] . $x[3] : floor($x[1]) . $x[3];
								case '>>':
									return ((int)$x[1]) >> ((int)$x[3]);
								case '<<':
									return ((int)$x[1]) << ((int)$x[3]);
								case '<>>':
									return self::rtr((int)$x[1], (int)$x[3]);
								case '<<>':
									return self::rtl((int)$x[1], (int)$x[3]);
								case '&':
									return ((int)$x[1]) & ((int)$x[3]);
								case '|':
									return ((int)$x[1]) | ((int)$x[3]);
								case '^':
									return ((int)$x[1]) ^ ((int)$x[3]);
								case '=>':
									return self::res((int)$x[1], (int)$x[3]);
								case '=<':
									return self::res((int)$x[3], (int)$x[1]);
								case '&&':
									return $x[1] == 0 || $x[3] == 0 ? 0 : 1;
								case '||':
									return $x[1] == 0 && $x[3] == 0 ? 0 : 1;
								case '==':
									return $x[1] == $x[3] ? 1 : 0;
								case '!=':
									return $x[1] != $x[3] ? 1 : 0;
								case '<=':
									return $x[1] <= $x[3] ? 1 : 0;
								case '>=':
									return $x[1] >= $x[3] ? 1 : 0;
								case '>':
									return $x[1] > $x[3] ? 1 : 0;
								case '<':
									return $x[1] < $x[3] ? 1 : 0;
							}
						}, $calc);
					break;
					case 2:
						$calc = preg_replace_callback("/(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)($regex)/", function($x){
							switch($x[2]){
								case '!':
									return self::fact($x[1]);
								case '~':
									return self::revb($x[1]);
							}
						}, $calc);
					break;
					case 3:
						$calc = preg_replace_callback("/($regex)(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)/", function($x){
							switch($x[2]){
								case '!':
									return $x[2] == 0 ? 1 : 0;
								case '~':
									return ~$x[1];
							}
						}, $calc);
				}
			}
		}while($prev != $calc);
		if($calc === '')return 0;
		return (float)$calc;
	}
}
class BNC { // Big Number Calculator
	const PRIME1305 = '1361129467683753853853498429727072845819'; // 3fffffffffffffffffffffffffffffffb // 2^130-5
	
	public static $precision = 0;

	// consts variables
	public static function PI($l = null){
		if(self::$precision > 0)$l = $l === null ? self::$precision : min($l, self::$precision);
		return aped("pi", $l === null || $l < 0 ? null : ($l === 0 ? 1 : $l + 2));
	}
	public static function PHI($l = null){
		if(self::$precision > 0)$l = $l === null ? self::$precision : min($l, self::$precision);
		return aped("phi", $l === null || $l < 0 ? null : ($l === 0 ? 1 : $l + 2));
	}
	public static function E($l = null){
		if(self::$precision > 0)$l = $l === null ? self::$precision : min($l, self::$precision);
		return aped("e", $l === null || $l < 0 ? null : ($l === 0 ? 1 : $l + 2));
	}
	// validator
	public static function is_number($a){
		return is_numeric($a);
	}
	// system functions
	private static function ickeck($a){
		$b = false;
		for($c = 0; isset($a[$c]); ++$c){
			$h = $a[$c];
			if($h == '.' && $c > 0 && isset($a[$c + 1])){
				if($b){
					if(strlen($a)> 20)$a = substr($a, 0, 12). '...' . substr($a, -5);
					new APError("BNC", "invalid number \"$a\".", APError::ARITHMETIC);
					return false;
				}
				$b = true;
			}
			elseif($a !== 0 && $a !== 1 && $a !== 2 && $a !== 3 && $a !== 4 && $a !== 5 && $a !== 6 && $a !== 7 && $a !== 8 && $a !== 9){
				if(strlen($a)> 20)$a = substr($a, 0, 12). '...' . substr($a, -5);
				new APError("BNC", "invalid number \"$a\".", APError::ARITHMETIC);
				return false;
			}
		}
		return true;
	}
	private static function _check($a){
		if(!is_numeric($a)){
			if(strlen($a) > 20)$a = substr($a, 0, 12). '...' . substr($a, -5);
			new APError("BNC", "invalid number \"$a\".", APError::ARITHMETIC);
			return false;
		}
		return true;
	}
	private static function _view($a){
		if($a[0] == '-')return true;
		return false;
	}
	public static function abs($a){
		if($a[0] == '-' || $a[0] == '+')return substr($a, 1);
		return $a;
	}
	private static function _change($a){
		if($a == 0)return '0';
		if($a[0] == '-')return substr($a, 1);
		if($a[0] == '+')return '-' . substr($a, 1);
		return '-' . $a;
	}
	private static function _get0($a){
		$a = ltrim($a, '0');
		return $a ? $a : '0';
	}
	private static function _get1($a){
		$a = rtrim($a, '0');
		return $a ? $a : '0';
	}
	private static function _get2($a){
		$a = explode('.', $a, 2);
		$a[1] = isset($a[1]) ? $a[1] : '0';
		$a[0] = self::_get0($a[0]);
		$a[1] = self::_get1($a[1]);
		if($a[0] && $a[1])return "{$a[0]}.{$a[1]}";
		if($a[1])return "0.{$a[1]}";
		if($a[0])return "{$a[0]}";
		return '0';
	}
	private static function _get3($a){
		if(self::_view($a))
			return '-' . self::_get2(self::abs($a));
		return self::_get2(self::abs($a));
	}
	private static function _get($a){
		if(!self::_check($a))return false;
		return self::_get3($a);
	}
	private static function _set0($a, $b){
		$l = strlen($b) - strlen($a);
		if($l <= 0)return $a;
		return str_repeat('0', $l). $a;
	}
	private static function _set1($a, $b){
		$l = strlen($b) - strlen($a);
		if($l <= 0)return $a;
		return $a . str_repeat('0', $l);
	}
	private static function _set2($a, $b){
		$a = explode('.', $a, 2);
		$b = explode('.', $b, 2);
		if(!isset($a[1]) && isset($b[1]))
			$a[1] = '0';
		if(isset($a[1]))$a[1] = self::_set1($a[1], @$b[1]);
		$a[0] = self::_set0($a[0], $b[0]);
		if(!isset($a[1]))return "{$a[0]}";
		return "{$a[0]}.{$a[1]}";
	}
	private static function _set3($a, $b){
		if(self::_view($a) && self::_view($b)) return '-' . self::_set2(self::abs($a), self::abs($b));
		if(!self::_view($a) && self::_view($b))return self::_set2(self::abs($a), self::abs($b));
		if(self::_view($a) && !self::_view($b))return '-' . self::_set2(self::abs($a), self::abs($b));
		return self::_set2(self::abs($a), self::abs($b));
	}
	private static function _set($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::_set3($a, $b);
	}
	private static function _full($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::_set(self::_get($a), self::_get($b));
	}
	private static function _setfull(&$a, &$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$a = self::_get($a);
		$b = self::_get($b);
		$a = self::_set($a, $b);
		$b = self::_set($b, $a);
	}
	private static function _st($a, $b){
		if(!isset($a[$b]) || $b == 0)return $a;
		return substr_replace($a, '.', $b, 0);
	}
	public static function mod2($a){
		$a = $a[strlen($a) - 1];
		return $a == '0' || $a == '2' || $a == '4' || $a == '6' || $a == '8';
	}
	private static function _if($a){
		$a = $a[strlen($a) - 1];
		return $a == '1' || $a == '3' || $a == '5' || $a == '7' || $a == '9';
	}
	private static function _so($a, $b){
		$l = strlen($a)% $b;
		if($l == 0)return $a;
		else return str_repeat('0', $b - $l). $a;
	}
	private static function _pl($a){
		$l = '0';
		while($a != $l) {
			$l = $a;
			$a = str_replace(array('--', '-+', '+-', '++'), array('+', '-', '-', '+'), $a);
		}
		return $a;
	}
	private static function _th($a){
		return strpos($a, '.') !== false ? array_value(explode('.', $a, 2), 1) : '0';
	}
	// retry calc functions
	private static function _powTen0($a, $b){
		$p = strpos($a, '.');
		$a = str_replace('.', '', $a);
		$l = strlen($a);
		if($p === false)$s = strlen($a) + $b;
		else $s = $p + $b;
		if($s == $l)return $a;
		if($s > $l)return $a . str_repeat('0', $s - $l);
		if($s == 0)return "0.$a";
		if($s < 0)return "0." . str_repeat('0', abs($s)). $a;
		return substr_replace($a, ".", $s, 0);
	}
	private static function _powTen1($a, $b){
		if(self::_view($a))return '-' . self::_powTen0(self::abs($a), $b);
		return self::_powTen0(self::abs($a), $b);
	}
	public static function powTen($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0){
			$l = strpos($a, '.');
			if($l === false)$l = strlen($a);
			if($b == 0)return self::round($a, self::$precision);
			return self::round(self::_get(self::_powTen1($a, $b)), self::$precision);
		}
		if($b == 0)return $a;
		return self::_get(self::_powTen1($a, $b));
	}
	private static function _mulTwo0($a){
		if(__apeip_data::$instGMP){
			$a = self::_get0($a);
			return self::_so(gmp_strval(gmp_add($a, $a)), 13);
		}
		$a = str_split($a, 13);
		$c = count($a) - 1;
		$o = 0;
		while($c >= 0) {
			$a[$c]*= 2;
			$a[$c]+= $o;
			$o = $k = 0;
			while(@$a[$c - $k] > 9999999999999) {
				$o = 1;
				$a[$c - $k]-= 10000000000000;
				++$k;
			}
			$a[$c] = self::_so($a[$c], 13);
			--$c;
		}
		return implode('', $a);
	}
	private static function _mulTwo1($a){
		$a = explode('.', $a, 2);
		$a[0] = self::_so($a[0], 13);
		$a[0] = self::_mulTwo0("0000000000000{$a[0]}");
		if(isset($a[1])) {
			$l = strlen($a[1]);
			$a[1] = self::_so($a[1], 13);
			$a[1] = self::_mulTwo0("0000000000000{$a[1]}");
			$a[2] = substr($a[1], 0, -$l);
			$a[1] = substr($a[1], -$l);
			if($a[2] > 0)$a[0] = self::_add0("0000000000000{$a[0]}", "0000000000000" . str_repeat('0', strlen($a[0]) - 1). '1');
			return "{$a[0]}.{$a[1]}";
		}
		return $a[0];
	}
	private static function _mulTwo2($a){
		if(self::_view($a))return '-' . self::_mulTwo1(self::abs($a));
		return self::_mulTwo1(self::abs($a));
	}
	private static function mulTwo($a){
		if(!self::_check($a))return false;
		if(__apeip_data::$instBcmath){
			if(self::$precision > 0)
				return self::_get3(bcmul($a, '2', self::$precision));
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c = strlen($a) - $p;
			return self::_get3(bcmul($a, '2', $c));
		}
		if(self::$precision > 0)
			return self::_get3(self::_mulTwo2(self::_get3(self::round($a, self::$pricision))));
		return self::_get3(self::_mulTwo2(self::_get3($a)));
	}
	private static function _divTwo0($a){
		if(__apeip_data::$instGMP){
			$r = self::_so(gmp_strval(gmp_div(self::_get0($a), '2')), 14);
			if(self::_if($a))
				$r .= '5';
			return $r;
		}
		$s = '';
		$c = 0;
		$k = false;
		while(isset($a[$c])) {
			$h = substr($a, $c, 14);
			$b = floor($h / 2);
			$b = $k ? $b + 50000000000000 : $b;
			$s.= self::_so($b, 14);
			if($h % 2 == 1)$k = true;
			$c+= 14;
		}
		if($k)$s.= '5';
		return $s;
	}
	private static function _divTwo1($a){
		$p = strpos($a, '.');
		$a = str_replace('.', '', $a);
		if($p === false)$p = strlen($a);
		$l = strlen($a);
		$a = self::_so($a, 14);
		$p+= strlen($a) - $l;
		$a = self::_divTwo0($a);
		return self::_st($a, $p);
	}
	private static function _divTwo2($a){
		if(self::_view($a))return '-' . self::_divTwo1(self::abs($a));
		return self::_divTwo1(self::abs($a));
	}
	public static function divTwo($a,$limit = null){
		if(self::$precision > 0)
			$limit = $limit === null ? self::$precision : min($limit, self::$precision);
		if($limit)
			$a = self::round(self::_get(self::_divTwo2(self::_get($a))), $limit);
		else $a = self::_get(self::_divTwo2(self::_get($a)));
	}
	private static function _powTwo0($a){
		if(__apeip_data::$instGMP){
			$a = self::_get0($a);
			return gmp_strval(gmp_mul($a, $a));
		}
		$a = str_split($a, 1);
		$x = false;
		$c = $d = count($a) - 1;
		$k = 0;
		while($c >= 0) {
			$y = '';
			$e = $d;
			$s = 0;
			while($e >= 0) {
				$t = $a[$c] * $a[$e] + $s;
				$s = floor($t / 10);
				$t-= $s * 10;
				$y = $t . $y;
				--$e;
			}
			--$c;
			$t = $s . $y . ($k ? str_repeat('0', $k): '');
			$x = $x ? self::add($x, $t): $t;
			++$k;
		}
		return $x;
	}
	private static function _powTwo1($a){
		$p = strpos($a, '.');
		if($p === false)return self::_powTwo0($a);
		$p = strlen($a) - $p - 1;
		$p*= 2;
		$a = str_replace('.', '', $a);
		$a = '0' . self::_powTwo0($a);
		return self::_st($a, strlen($a) - $p);
	}
	private static function _powTwo2($a){
		return self::_powTwo1(self::abs($a));
	}
	public static function powTwo($a){
		if(!self::_check($a))return false;
		if(__apeip_data::$instBcmath){
			if(self::$precision > 0)
				return self::_get3(bcpow($a, '2', self::$precision));
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c+= $al - $p;
			$c*= 2;
			return self::_get3(bcpow($a, '2', $c));
		}
		$a = self::_get3($a);
		if(self::$precision > 0){
			if(__apeip_data::$instGMP && $a == self::floor($a))
				return self::round(gmp_strval(gmp_pow($a, '2')), self::$precision);
			return self::_powTwo2(self::round($a,self::$precision));
		}
		if(__apeip_data::$instGMP && $a == self::floor($a))
			return gmp_strval(gmp_pow($a, '2'));
		if(self::$precision > 0)
			return self::_get3(self::_powTwo2(self::round($a, self::$precision)));
		return self::_get3(self::_powTwo2($a));
	}
	// set functions
	public static function floor($a){
		if(!self::_check($a))return false;
		if(self::_view($a) && strpos($a, '.') > 0)
			return '-' . self::add(self::floor(self::abs($a)), '1');
		return array_value(explode('.', $a), 0);
	}
	public static function ceil($a){
		if(!self::_check($a))return false;
		if(self::_view($a) && strpos($a, '.') > 0)
			return '-' . self::add(self::ceil(self::abs($a)), '1');
		$a = explode('.', $a);
		return isset($a[1]) ? self::add($a[0], '1'): $a[0];
	}
	public static function round($a, $n = 0){
		if(!self::_check($a))return false;
		if($n < -1){
			++$n;
			return self::powTen(self::round(self::powTen($a, $n)), -$n);
		}
		$p = strpos($a, '.');
		if($p === false)return $a;
		$p+= $n;
		if(!isset($a[$p + 1]))return $a;
		$b = $a[$p + 1] >= 5;
		$a = substr($a, 0, $n == 0 ? $p : $p + 1);
		$t = $n == 0 ? '1' : self::powTen('1', -$n);
		return self::_view($a) ? ($b ? self::sub($a, $t) : $a) : ($b ? self::add($a, $t) : $a);
	}
	public static function is_floor($a){
		return strpos($a, '.') === false;
	}
	public static function floord($a, $x){
		if(($p = strpos($a, '.')) === false)
			return $a;
		return self::_get(substr($a, 0, $p + $x + 1));
	}
	// calc functions
	private static function _add0($a, $b){
		if(__apeip_data::$instGMP)
			return self::_so(gmp_strval(gmp_add(self::_get0($a), self::_get0($b))), 13);
		$a = str_split($a, 13);
		$b = str_split($b, 13);
		$c = count($a) - 1;
		while($c >= 0) {
			$a[$c]+= $b[$c];
			$k = 0;
			while(isset($a[$c - $k]) && $a[$c - $k] > 9999999999999) {
				$a[$c - $k - 1]+= 1;
				$a[$c - $k]-= 10000000000000;
				++$k;
			}
			$a[$c] = self::_so($a[$c], 13);
			--$c;
		}
		return implode('', $a);
	}
	private static function _add1($a, $b){
		$a = "0000000000000$a";
		$b = "0000000000000$b";
		$o = strpos($a, '.');
		$p = $o + (13 - (strlen($a) - 1)% 13);
		$a = self::_so(str_replace('.', '', $a), 13);
		$b = self::_so(str_replace('.', '', $b), 13);
		if($o !== false && $o !== -1)return self::_st(self::_add0($a, $b), $p);
		return self::_add0($a, $b);
	}
	private static function _add2($a, $b){
		if(self::_view($a) && self::_view($b))return '-' . self::_add1(self::abs($a), self::abs($b));
		if(self::_view($a) && !self::_view($b))return self::sub(self::abs($b), self::abs($a));
		if(!self::_view($a) && self::_view($b))return self::sub(self::abs($a), self::abs($b));
		return self::_add1(self::abs($a), self::abs($b));
	}
	public static function add($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0){
			$a = self::round($a, self::$precision);
			$b = self::round($b, self::$precision);
		}
		if(strlen($a) <= 13 && strlen($b) <= 13)
			return (string)($a + $b);
		if(__apeip_data::$instBcmath){
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c = strlen($a) - $p;
			if(($p = strpos($b, '.')) !== false)
				$c = max($c, strlen($b) - $p);
			return self::_get3(bcadd($a, $b, $c));
		}
		self::_setfull($a, $b);
		if($a == 0)return $b;
		if($b == 0)return $a;
		if($a == $b)return self::mulTwo($a);
		return self::_get3(self::_add2($a, $b));
	}
	public static function inc($x){
		if(!self::_check($x))return false;
		if(self::$precision > 0)
			$x = self::round($x, self::$precision);
		if(strlen($x) <= 13)return (string)($x + 1);
		$p = strpos($x, '.');
		if($p !== false){
			$x = substr_replace($x, '', $p, 1);
			$x = self::inc($x);
			return substr_replace($x, '.', $p, 0);
		}
		if($x == -1)return '0';
		if(__apeip_data::$instBcmath)
			return bcadd($x, '1', 0);
		if(self::_view($x))return '-' . self::inc(self::abs($x));
		$x = '0' . $x;
		for($i = strlen($x) - 1; $i >= 0; --$i)
			if($x[$i] == '9')
				$x[$i] = '0';
			else{
				$x[$i] = $x[$i] + 1;
				break;
			}
		return self::_get0($x);
	}
	private static function _sub0($a, $b){
		if(__apeip_data::$instGMP)
		return self::_so(gmp_strval(gmp_sub(self::_get0($a), self::_get0($b))), 13);
		$a = str_split($a, 13);
		$b = str_split($b, 13);
		$c = count($a) - 1;
		while($c >= 0) {
			$a[$c]-= $b[$c];
			$k = 0;
			while(isset($a[$c - $k - 1]) && $a[$c - $k] < 0) {
				$a[$c - $k - 1]-= 1;
				$a[$c - $k]+= 10000000000000;
				++$k;
			}
			$a[$c] = self::_so($a[$c], 13);
			--$c;
		}
		return implode('', $a);
	}
	private static function _sub1($a, $b){
		$o = strpos($a, '.');
		$p = $o + (13 - (strlen($a) - 1)% 13);
		$a = self::_so(str_replace('.', '', $a), 13);
		$b = self::_so(str_replace('.', '', $b), 13);
		if($o !== false && $o !== -1)return self::_st(self::_sub0($a, $b), $p);
		return self::_sub0($a, $b);
	}
	private static function _sub2($a, $b){
		if(self::_view($a) && self::_view($b))return '-' . self::_sub1(self::abs($a), self::abs($b));
		if(self::_view($a) && !self::_view($b))return '-' . self::_add1(self::abs($a), self::abs($b));
		if(!self::_view($a) && self::_view($b))return self::_add1(self::abs($a), self::abs($b));
		return self::_sub1(self::abs($a), self::abs($b));
	}
	private static function _sub3($a, $b){
		if($a < $b) {
			return '-' . self::_sub2($b, $a);
		}
		return self::_sub2($a, $b);
	}
	public static function sub($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision){
			$a = self::round($a, self::$precision);
			$b = self::round($b, self::$precision);
		}
		if(strlen($a) <= 13 && strlen($b) <= 13)
			return (string)($a - $b);
		if(__apeip_data::$instBcmath){
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c = strlen($a) - $p;
			if(($p = strpos($b, '.')) !== false)
				$c = max($c, strlen($b) - $p);
			return self::_get3(bcsub($a, $b, $c));
		}
		self::_setfull($a, $b);
		$r = $a == 0 ? self::_change($b): $b == 0 ? $a : self::_sub3($a, $b);
		return self::_pl(self::_get3($r));
	}
	public static function dec($x){
		if(!self::_check($x))return false;
		if(self::$precision > 0)
			$x = self::round($x, self::$precision);
		if(strlen($x) <= 13)return (string)($x - 1);
		$p = strpos($x, '.');
		if($p !== false){
			$x = substr_replace($x, '', $p, 1);
			$x = self::dec($x);
			return substr_replace($x, '.', $p, 0);
		}
		if($x == 0)return '-1';
		if(__apeip_data::$instBcmath)
			return bcsub($x, '1', 0);
		if(self::_view($x))return '-' . self::dec(self::abs($x));
		for($i = strlen($x) - 1; $i >= 0; --$i)
			if($x[$i] == '0')
				$x[$i] = '9';
			else{
				$x[$i] = $x[$i] - 1;
				break;
			}
		return self::_get0($x);
	}
	private static function _mul0($a, $b){
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_mul(self::_get0($a), self::_get0($b)));
		$a = str_split($a, 1);
		$b = str_split($b, 1);
		$x = false;
		$c = $d = count($a) - 1;
		$k = 0;
		while($c >= 0) {
			if($a[$c] != 0){
				$y = '';
				$e = $d;
				$s = 0;
				while($e >= 0) {
					$t = $a[$c] * $b[$e] + $s;
					$s = floor($t / 10);
					$t%= 10;
					$y = $t . $y;
					--$e;
				}
				$t = $s . $y . ($k ? str_repeat('0', $k) : '');
				$x = $x ? self::add($x, $t) : $t;
			}--$c;
			++$k;
		}
		return $x;
	}
	private static function _mul1($a, $b){
		$ap = strpos($a, '.');
		$bp = strpos($b, '.');
		if(!$ap)return self::_mul0($a, $b);
		$ap = strlen($a) - $ap - 1;
		$bp = strlen($b) - $bp - 1;
		$p = $ap + $bp;
		$a = str_replace('.', '', $a);
		$b = str_replace('.', '', $b);
		$a = '0' . self::_mul0($a, $b);
		return self::_st($a, strlen($a) - $p);
	}
	private static function _mul2($a, $b){
		if(self::_view($a) && self::_view($b))return self::_mul1(self::abs($a), self::abs($b));
		if(!self::_view($a) && self::_view($b))return '-' . self::_mul1(self::abs($a), self::abs($b));
		if(self::_view($a) && !self::_view($b))return '-' . self::_mul1(self::abs($a), self::abs($b));
		return self::_mul1(self::abs($a), self::abs($b));
	}
	public static function mul($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0){
			$a = self::round($a, floor(self::$precision / 2) + 1);
			$b = self::round($b, floor(self::$precision / 2) + 1);
		}
		$al = strlen($a);
		$bl = strlen($b);
		if($al + $bl <= 12)
			return (string)($a * $b);
		if(__apeip_data::$instBcmath){
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c+= $al - $p;
			if(($p = strpos($b, '.')) !== false)
				$c+= $bl - $p;
			return self::_get3(bcmul($a, $b, $c));
		}
		self::_setfull($a, $b);
		if($a == 0 || $b == 0)return '0';
		if($a == 1)return "$b";
		if($b == 1)return "$a";
		if($a == 2)return self::mulTwo($b);
		if($b == 2)return self::mulTwo($a);
		if($a == $b)return self::powTwo($a);
		$a = self::_get3(self::_mul2($a, $b));
		if(self::$precision > 0)
			return self::round($a, self::$precision);
		return $a;
	}
	private static function _rand0($a){
		$rand = "0.";
		$b = floor($a / 9);
		for($c = 0; $c < $b; ++$c) {
			$rand.= self::_so(rand(0, 999999999), 9);
		}
		if($a % 9 == 0)return $rand;
		return $rand . self::_so(rand(0, str_repeat('9', $a % 9)), $a % 9);
	}
	private static function _rand1($a, $b){
		$c = self::sub($a, $b);
		$d = self::_rand0(strlen($a));
		return self::add(self::floor(self::mul(self::inc($c), $d)), $b);
	}
	private static function _rand2($a, $b){
		if($a < $b)swap($a, $b);
		$p = strpos($a, '.');
		if(!$p)return self::_rand1($a, $b);
		$p = strlen($a) - $p - 1;
		$a = str_replace('.', '', $a);
		$b = str_replace('.', '', $b);
		$a = '0' . self::_rand1($a, $b);
		return self::_st($a, strlen($a) - $p);
	}
	private static function _rand3($a, $b){
		if(self::_view($a) && self::_view($b))return '-' . self::_rand2(self::abs($a), self::abs($b));
		if(!self::_view($a) && self::_view($b))
			return self::_change(self::sub(self::_rand2('0', self::add(self::abs($a), self::abs($b))), $a));
		if(self::_view($a) && !self::_view($b))
			return self::_change(self::sub(self::_rand2('0', self::add(self::abs($a), self::abs($b))), $b));
		return self::_rand2(self::abs($a), self::abs($b));
	}
	public static function rand($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(__apeip_data::$instGMPRR)
			return gmp_strval(gmp_​random_​range(self::floor(self::_get0($a)), self::floor(self::_get0($b))));
		self::_setfull($a, $b);
		$r = $a == $b ? $a : self::_rand3($a, $b);
		return self::_get($r);
	}
	public static function _div00($a){
		if(self::$precision > 0)
			if(__apeip_data::$instGMP){
				$a = self::_get0($a);
				return array(
					self::round($a, self::$precision),
					self::round(gmp_strval(gmp_add($a, $a)), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '3')), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '4')), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '5')), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '6')), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '7')), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '8')), self::$precision),
					self::round(gmp_strval(gmp_mul($a, '9')), self::$precision)
				);
			}elseif(__apeip_data::$instBcmath)
				return array(
					self::round($a, self::$precision),
					bcmul($a, '2', self::$precision),
					bcmul($a, '3', self::$precision),
					bcmul($a, '4', self::$precision),
					bcmul($a, '5', self::$precision),
					bcmul($a, '6', self::$precision),
					bcmul($a, '7', self::$precision),
					bcmul($a, '8', self::$precision),
					bcmul($a, '9', self::$precision)
				);
			else
				return array(
					self::round($a, self::$precision),
					$b = self::mulTwo($a),
					$c = self::mul($a, '3'),
					$d = self::mulTwo($b),
					self::mul($a, '5'),
					self::mulTwo($c),
					self::mul($a, '7'),
					self::mulTwo($d),
					self::mul($c, '3')
				);
		if(__apeip_data::$instGMP){
			$a = self::_get0($a);
			return array(
				$a,
				gmp_strval(gmp_add($a, $a)),
				gmp_strval(gmp_mul($a, '3')),
				gmp_strval(gmp_mul($a, '4')),
				gmp_strval(gmp_mul($a, '5')),
				gmp_strval(gmp_mul($a, '6')),
				gmp_strval(gmp_mul($a, '7')),
				gmp_strval(gmp_mul($a, '8')),
				gmp_strval(gmp_mul($a, '9'))
			);
		}if(__apeip_data::$instBcmath){
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c = strlen($a) - $p;
			return array(
				$a,
				bcmul($a, '2'),
				bcmul($a, '3'),
				bcmul($a, '4'),
				bcmul($a, '5'),
				bcmul($a, '6'),
				bcmul($a, '7'),
				bcmul($a, '8'),
				bcmul($a, '9')
			);
		}
		return array(
			$a,
			$b = self::mulTwo($a),
			$c = self::mul($a, '3'),
			$d = self::mulTwo($b),
			self::mul($a, '5'),
			self::mulTwo($c),
			self::mul($a, '7'),
			self::mulTwo($d),
			self::mul($c, '3')
		);
	}
	private static function _div01($a, $muls){
		if($a < $muls[0])return 0;
		if($a < $muls[1])return 1;
		if($a < $muls[2])return 2;
		if($a < $muls[3])return 3;
		if($a < $muls[4])return 4;
		if($a < $muls[5])return 5;
		if($a < $muls[6])return 6;
		if($a < $muls[7])return 7;
		if($a < $muls[8])return 8;
		return 9;
	}
	private static function _div1($a, $b, $o = -1){
		if(__apeip_data::$instGMP){
			$a = self::_get0($a);
			$b = self::_get0($b);
			$r = gmp_div($a, $b);
			$d = gmp_strval(gmp_sub($a, gmp_mul($r, $b)));
			$r = gmp_strval($r);
		}else{
			$muls = self::_div00($b);
			$a = str_split($a, 1);
			$p = $r = $i = $d = '0';
			for($i = 0; isset($a[$i]); ++$i) {
				$d.= $a[$i];
				if($d >= $b) {
					$p = self::_div01($d, $muls);
					$d = self::sub($d, self::mul($p, $b));
					$r.= $p;
				}else $r.= '0';
			}
		}
		if($d == 0 || $o == 0)return $r;
		if(!isset($muls))
			$muls = self::_div00($b);
		$r .= '.';
		while($d > 0 && $o != 0) {
			$d.= '0';
			if($d >= $b) {
				$p = self::_div01($d, $muls);
				$d = self::sub($d, self::mul($p, $b));
				$r.= $p;
			}else $r.= '0';
			--$o;
		}
		return $r;
	}
	private static function _div2($a, $b, $c = -1){
		$a = str_replace('.', '', $a);
		$b = str_replace('.', '', $b);
		if(self::_view($a) && self::_view($b))return self::_div1(self::abs($a), self::abs($b), $c);
		if(self::_view($a) && !self::_view($b))return '-' . self::_div1(self::abs($a), self::abs($b), $c);
		if(!self::_view($a) && self::_view($b))return '-' . self::_div1(self::abs($a), self::abs($b), $c);
		return self::_div1(self::abs($a), self::abs($b), $c);
	}
	public static function div($a, $b, $c = -1){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		self::_setfull($a, $b);
		if($b == 0) {
			new APError("BNC", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		if(self::$precision > 0)
			$c = $c < 0 ? $c : min(self::$precision, $c);
		if(__apeip_data::$instBcmath){
			if($c == -1){
				$c = 1;
				if(($p = strpos($a, '.')) !== false)
					$c+= strlen($a) - $p;
				if(($p = strpos($b, '.')) !== false)
					$c+= strlen($b) - $p;
			}
			return self::_get3(bcdiv($a, $b, $c));
		}
		if($a == 0)return '0';
		if($b == 1)return "$a";
		if($a == $b)return '1';
		return self::_get2(self::_div2($a, $b, $c));
	}
	private static function _mod0($a, $b){
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_mod(self::_get0($a), self::_get0($b)));
		$muls = self::_div00($b);
		$a = str_split($a, 1);
		$p = $r = $i = $d = '0';
		$c = count($a);
		while($i < $c) {
			$d.= $a[$i];
			if($d >= $b) {
				$p = self::_div01($d, $muls);
				$d = self::sub($d, self::mul($p, $b));
				$r.= $p;
			}else $r.= '0';
			++$i;
		}
		return $d;
	}
	private static function _mod1($a, $b){
		$a = self::floor($a);
		$b = self::floor($b);
		if(self::_view($a))return '-' . self::_mod0(self::abs($a), self::abs($b));
		return self::_mod0(self::abs($a), self::abs($b));
	}
	public static function mod($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		self::_setfull($a, $b);
		if($b == 0) {
			new APError("BNC", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		if(__apeip_data::$instBcmath)
			return self::_get3(bcmod($a, $b, 0));
		if($a == 0 || $b == 1 || $a == $b)return '0';
		return self::_get(self::_mod1($a, $b));
	}
	private static function _divmod0($a, $b){
		if(__apeip_data::$instGMP){
			$a = self::_get0($a);
			$b = self::_get0($b);
			return array(gmp_strval(gmp_div($a, $b)), gmp_strval(gmp_mod($a, $b)));
		}
		$muls = self::_div00($b);
		$a = str_split($a, 1);
		$p = $r = $i = $d = '0';
		$c = count($a);
		while($i < $c) {
			$d.= $a[$i];
			if($d >= $b) {
				$p = self::_div01($d, $muls);
				$d = self::sub($d, self::mul($p, $b));
				$r.= $p;
			}else $r.= '0';
			++$i;
		}
		return array($r, $d);
	}
	private static function _divmod1($a, $b){
		$a = self::floor($a);
		$b = self::floor($b);
		if(self::_view($a))return '-' . self::_divmod0(self::abs($a), self::abs($b));
		return self::_divmod0(self::abs($a), self::abs($b));
	}
	public static function divmod($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		self::_setfull($a, $b);
		if($b == 0) {
			new APError("BNC", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		if(__apeip_data::$instBcmath)
			return array(self::_get3(bcdiv($a, $b, 0)), self::_get3(bcmod($a, $b, 0)));
		if($a == 0 || $b == 1 || $a == $b)return '0';
		$r = self::_divmod1($a, $b);
		return array(self::_get($r[0]), self::_get($r[1]));
	}
	private static function _powf($a,$b){
		if($a == 1 || $a == 0)
			return $a;
		if($a == -1)
			return self::mod2($b) ? '1' : '-1';
		if($b == 0)
			return '1';
		if($b == 1)
			return $a;
		if(self::mod2($b))
			return self::_powf(self::powTwo($a),self::divTwo($b));
		else
			return self::mul(self::_powf(self::powTwo($a),self::divTwo($b)),$a);
	}
	public static function powf($a,$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$al = strlen($a);
		if(self::$precision > 0)
			$a = self::round($a, floor(self::$precision / $b) + 1);
		if($al * $b <= 10)
			return (string)pow($a, $b);
		$b = self::floor($b);
		if(__apeip_data::$instBcmath){
			if(self::$precision > 0)
				return self::_get3(bcpow($a, $b, self::$precision));
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c+= $al - $p;
			$c*= $b;
			return self::_get3(bcpow($a, $b, $c));
		}
		if(self::$precision > 0){
			if(__apeip_data::$instGMP && $a == self::floor($a))
				return self::round(gmp_strval(gmp_pow(self::_get0($a), self::_get0($b))), self::$precision);
			if($b < 0)
				return self::div('1',self::_powf($a,substr_replace($b,'',0,1)),self::$precision);
			return self::round(self::_powf($a,$b),self::$precision);
		}
		if(__apeip_data::$instGMP && $a == self::floor($a))
			return gmp_strval(gmp_pow(self::_get0($a), self::_get0($b)));
		if($b < 0)
			return self::div('1',self::_powf($a,substr_replace($b,'',0,1)));
		return self::_powf($a,$b);
	}
	public static function _rpowf($a,$b,$c){
		if($a == 1 || $a == 0)
			return $a;
		if($a == -1)
			return self::mod2($b) ? '1' : '-1';
		if($b == 0)
			return '1';
		if($b == 1)
			return $a;
		if(self::mod2($b))
			return self::round(self::_rpowf(self::powTwo($a),self::divTwo($b),$c),$c);
		else
			return self::round(self::mul(self::_rpowf(self::powTwo($a),self::divTwo($b),$c),$a),$c);
	}
	public static function rpowf($a,$b,$c = 14){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		if(strlen($a) * $b <= 10)
			return (string)(pow($a, $b));
		$b = self::floor($b);
		if(__apeip_data::$instBcmath)
			return self::_get3(bcpow($a, $b, $c));
		if(__apeip_data::$instGMP && $a == self::floor($a))
			return gmp_strval(gmp_pow(self::_get0($a), self::_get0($b)));
		if($b < 0)
			return self::div('1',self::_rpowf($a,substr_replace($b,'',0,1),$c));
		return self::_rpowf($a,$b,$c);
	}
	// algo functions
	public static function fact($a){
		if(!self::_check($a))return false;
		$a = self::floor($a);
		if($a <= 1)return 1;
		if($a <= 16)return (string)Math::fact($a);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_fact(self::_get0($a)));
		$r = '1';
		while($a > 0) {
			$r = self::mul($r, $a);
			$a = self::sub($a, '1');
		}
		return $r;
	}
	public static function fmod($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if($b == 0) {
			new APError("BNC", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		if(__apeip_data::$instBcmath){
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c+= strlen($a) - $p;
			if(($p = strpos($b, '.')) !== false)
				$c+= strlen($b) - $p;
			return self::_get3(bcmod($a, $b, $c));
		}
		return self::sub($a, self::mul(self::div($a, $b, 0), $b));
	}
	public static function umod($x, $y){
		$x = self::mod($x, $y);
		if($x === false)return false;
		if($x < 0)return self::add($x, $y);
		return $x;
	}
	public static function fumod($x, $y){
		if(!self::_check($x))return false;
		if(!self::_check($y))return false;
		if(__apeip_data::$instBcmath){
			$c = 0;
			if(($p = strpos($a, '.')) !== false)
				$c+= strlen($a) - $p;
			if(($p = strpos($b, '.')) !== false)
				$c+= strlen($b) - $p;
			$x = self::_get3(bcmod($a, $b, 0));
		}else $x = self::sub($x, self::mul(self::div($x, $y, 0), $y));
		if($x < 0)return self::add($x, $y);
		return $x;
	}
	public static function nmod($x, $y){
		$z = self::mod($x, $y);
		if($z === false)return false;
		if($z == 0)return '0';
		return self::sub($x, $z);
	}
	public static function gcd($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_gcd(self::floor($a), self::floor($b)));
		return $b ? self::gcd($b, self::mod($a, $b)) : $a;
	}
	public static function lcm($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(__apeip_data::$instGMPLCM)
			return gmp_strval(gmp_lcm(self::floor($a), self::floor($b)));
		$gcd = self::gcd($a, $b);
		if($gcd === false)return false;
		return self::div(self::mul($a, $b), $gcd);
	}
	public static function time($proc = false){
		$p = self::$precision > 0 ? min(self::$precision, 18) : 16;
		if($proc && __apeip_data::$hasProc)
			return number_format((float)substr_replace(proc::nanotime(), '.', -9, 0), $p, '.', '');
		return number_format(microtime(true), $p, '.', '');
	}
	private static function _powmod($b, $p, $m){
		if($p == '1')return self::mod($b, $m);
		if($p == '2')return self::mod(self::powTwo($b), $m);
		if($p == '3')return self::mod(self::mul(self::powTwo($b), $b), $m);
		if(self::_if($p))
			return self::mod(self::mul($b, self::_powmod(self::mod(self::powTwo($b), $m), self::div($p, '2', 0), $m)), $m);
		else
			return self::_powmod(self::mod(self::powTwo($b, $b), $m), self::div($p, '2', 0), $m);
	}
	public static function powmod($b, $p, $m){
		if(!self::_check($b))return false;
		if(!self::_check($p))return false;
		if(!self::_check($m))return false;
		if(__apeip_data::$instBcmath)
			return bcpowmod($b, $p, $m, 0);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_powm(self::_get0($a), $b, $c));
		if($m == '1' || $b == '0')return 0;
		if($b == '1' || $p == '0')return $m == 1 || $m == -1 ? '0' : '1';
		if($m == '0'){
			new APError("BNC", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		if($p < 0)return self::mod(self::floor(self::powf($b, $p)), $m);
		if($b < 0)return -self::_powmod(-$b, $p, $m);
		return self::_powmod($b, $p, $m);
	}
	private static function _powfmod($b, $p, $m){
		if($p == '1')return self::fmod($b, $m);
		if($p == '2')return self::fmod(self::powTwo($b), $m);
		if($p == '3')return self::fmod(self::mul(self::powTwo($b), $b), $m);
		if(self::_if($p))
			return self::fmod(self::mul($b, self::_powfmod(self::fmod(self::powTwo($b), $m), self::div($p, '2', 0), $m)), $m);
		else
			return self::_powfmod(self::fmod(self::powTwo($b, $b), $m), self::div($p, '2', 0), $m);
	}
	public static function powfmod($b, $p, $m){
		if(!self::_check($b))return false;
		if(!self::_check($p))return false;
		if(!self::_check($m))return false;
		if($b == '0')return 0;
		if($b == '1' || $p == '0')return self::fmod('1', $m);
		if($m == '0'){
			new APError("BNC", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		if($p < 0)return self::fmod(self::powf($b, $p), $m);
		if($b < 0)return -self::_powfmod(-$b, $p, $m);
		return self::_powfmod($b, $p, $m);
	}
	public static function sqrt($n, $limit = 15){
		if(self::$precision > 0)
			$limit = min(self::$precision, $limit);
		if(__apeip_data::$instBcmath)
			return self::_get3(bcsqrt($n, $limit));
		if($limit == 0 && __apeip_data::$instGMP)
			return gmp_strval(gmp_sqrt(self::_get0(self::floor($n))));
		$x = $n;
		$y = '1';
		while($x != $y) {
			$x = self::div(self::add($x, $y), '2', $limit);
			$y = self::div($n, $x, $limit);
		}
		return $x;
	}
	public static function max($first){
		return max(is_array($first) ? $first : func_get_args());
	}
	public static function min($first){
		return min(is_array($first) ? $first : func_get_args());
	}
	public static function average(){
		$nums = func_get_args();
		if(is_array($nums[0]))
			$nums = $nums[0];
		$num = $nums[0];
		for($c = 1;isset($nums[$c]);)
			$num = self::add($num, $nums[$c++]);
		return self::div($num, $c);
	}
	public static function discriminant($a, $b, $c){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(!self::_check($c))return false;
		return self::powTwo($b) - self::mul(self::mul($a, $c), 4);
	}
	public static function decimals($x){
		if(!self::_check($x))return false;
		return array_value(explode('.', $x . '.0', 3), 1);
	}
	public static function hypot($x, $y){
		if(!self::_check($x))return false;
		if(!self::_check($y))return false;
		return self::sqrt(self::add(self::powTwo($x), self::powTwo($y)));
	}
	public static function isprime($x, $c = 1000){
		if(!self::_check($x))return false;
		if(!is_array($c))
			$c = math::pnprime($c);
		$x = str_replace('.', '', $x);
		if($x == 0 || $x == 1)
			return false;
		foreach($c as $prime){
			if($x != $prime && self::mod($x, $prime) == '0')
				return false;
		}
		return true;
	}
	public static function prand($x, $y, $c = 1000){
		if(!is_array($c))
			$c = math::pnprime($c);
		$t0 = $t1 = self::rand($x, $y);
		while(true){
			if($t0 < $x && $t1 > $y)return false;
			if($t0 >= $x){
				if(self::isprime($t0, $c))
					return $t0;
				$t0 = self::dec($t0);
			}if($t1 <= $y){
				if($t0 != $t1 && self::isprime($t1, $c))
					return $t1;
				$t1 = self::inc($t1);
			}
		}
	}
	public static function pbrand($length, $c = 1000){
		if(!is_array($c))
			$c = math::pnprime($c);
		$min = self::powf('2', $length - 1);
		$max = self::dec(self::mul($min, '2'));
		return self::prand($min, $max, $c);
	}
	public static function sin($a, $c = 14){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$a = self::fmod($a, $c > 12 && ($p = self::PI($c)) ? self::mul($p, 2) : 2 * M_PI);
		$p = 1;
		$d = '1';
		$x = $a;
		$l = '';
		for($i = 2; $l != $x; $i += 2){
			$l = $x;
			$p += 2;
			$d = self::mul($d, -$i * ($i + 1));
			$x = self::add($x, self::div(self::powf($a, $p), $d, $c));
		}
		return $x;
	}
	public static function cos($a, $c = 14){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$a = self::fmod($a, $c > 12 && ($p = self::PI($c)) ? self::mul($p, 2) : 2 * M_PI);
		$p = 0;
		$d = '1';
		$x = 1;
		$l = '';
		for($i = 1; $l != $x; $i += 2){
			$l = $x;
			$p += 2;
			$d = self::mul($d, -$i * ($i + 1));
			$x = self::add($x, self::div(self::powf($a, $p), $d, $c));
		}
		return $x;
	}
	public static function rad($x, $c = 15){
		if(!self::_check($a))return false;
		return self::mul($x, aped('degree', $c));
	}
	public static function deg($x, $c = 15){
		if(!self::_check($x))return false;
		return self::mul($x, aped('radian', $c));
	}
	public static function tan($a, $c = 15){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		return self::div(self::sin($a), self::cos($a), $c);
	}
	public static function exp($a, $c = 10){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$a = explode('.', $a, 2);
		$m = $a[0] == 0 ? '1' : self::powf(self::E($c), $a[0], $c);
		return $m;
		if(!isset($a[1]))
			return $m;
		$a = "0.{$a[1]}";
		$d = '1';
		$x = self::inc($a);
		$l = '';
		for($i = 2;$l != $x;++$i){
			$l = $x;
			$d = self::mul($d, $i);
			$x = self::add($x, self::div(self::powf($a, $i), $d, $c));
		}
		return $m == 1 ? $x : self::mul($m, $x);
	}
	public static function rexp($a, $c = 10){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$a = explode('.', $a, 2);
		$m = $a[0] == 0 ? '1' : self::rpowf(self::E($c), $a[0], $c);
		return $m;
		if(!isset($a[1]))
			return $m;
		$a = "0.{$a[1]}";
		$d = '1';
		$x = self::inc($a);
		$l = '';
		for($i = 2;$l != $x;++$i){
			$l = $x;
			$d = self::mul($d, $i);
			$x = self::add($x, self::div(self::rpowf($a, $i, $c), $d, $c));
		}
		return $m == 1 ? $x : self::round(self::mul($m, $x), $c);
	}
	public static function ln($a, $c = 12){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$p = 1;
		$y = self::div(self::dec($a), self::inc($a), $c + 2);
		$x = "$y";
		$l = '';
		for($i = 0;$l != $x;++$i){
			$l = $x;
			$p+= 2;
			$x = self::add($x, self::div(self::powf($y, $p), $p, $c));
		}
		return self::mul($x, '2');
	}
	public static function rln($a, $c = 12){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$p = 1;
		$y = self::div(self::dec($a), self::inc($a), $c + 2);
		$x = "$y";
		$l = '';
		for($i = 0;$l != $x;++$i){
			$l = $x;
			$p+= 2;
			$x = self::add($x, self::div(self::rpowf($y, $p, $c), $p, $c));
		}
		return self::mul($x, '2');
	}
	public static function log($a, $b, $c = 12){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		return self::div(self::ln($a, $c), self::ln($b, $c), $c);
	}
	public static function pow($a, $b, $c = null){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		if(($c === null && strlen($a) * $b <= 10) || strlen($a) * $b <= 12 - $c)
			return (string)(pow($a, $b));
		if(strpos($b, '.') === false)
			return self::powf($a, $b);
		$b1 = self::floor($b);
		$b2 = '0.' . self::_th($b);
		$b = $b1 == 0 ? '1' : self::powf($a, $b1);
		$r = $b2 == 0 ? '1' : self::exp(self::mul(self::ln($a, $c), $b2), $c);
		return self::mul($r, $b);
	}
	public static function rpow($a, $b, $c = 14){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		if(($c === 14 && strlen($a) * $b <= 10) || strlen($a) * $b <= 12 - $c)
			return (string)(pow($a, $b));
		if(strpos($b, '.') === false)
			return self::powf($a, $b);
		$b1 = self::floor($b);
		$b2 = '0.' . self::_th($b);
		$b = $b1 == 0 ? '1' : self::rpowf($a, $b1, $c);
		$r = $b2 == 0 ? '1' : self::rexp(self::mul(self::rln($a, $c), $b2), $c);
		return self::round(self::mul($r, $b), $c);
	}
	public static function sinh($a, $c = 14){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$x = self::exp($a, $c);
		$y = self::div('1', $x, $c);
		return self::div(self::add($x, $y), '2', $c);
	}
	public static function cosh($a, $c = 14){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$x = self::exp($a, $c);
		$y = self::div('1', $x, $c);
		return self::div(self::sub($x, $y), '2', $c);
	}
	public static function tanh($a, $c = 14){
		if(!self::_check($a))return false;
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		$x = self::exp($a, $c);
		$y = self::div('1', $x, $c);
		return self::div(self::sub($x, $y), self::add($x, $y), $c);
	}
	public static function triangle($a, $p = 2, $c = 14){
		if(self::$precision > 0)
			$c = min(self::$precision, $c);
		if(!self::_check($a))return false;
		elseif($p === 0)return '1';
		elseif($p < 0)return self::div('1', self::triangle($a, -$p, $c), $c);
		$n = $a;
		for($i = 1;$i < $p;++$i)
			$n = self::mul($n, self::add($a, $i));
		return self::div($n, self::fact($p), $c);
	}
	// binary functions
	public static function xorx($a,$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$a = self::floor($a);
		$b = self::floor($b);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_xor(self::_get0($a), self::_get0($b)));
		return self::init(strrev(strrev(self::base_convert($a,10,'ascii')) ^ strrev(self::base_convert($b,10,'ascii'))),'ascii');
	}
	public static function andx($a,$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$a = self::floor($a);
		$b = self::floor($b);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_and(self::_get0($a), self::_get0($b)));
		return self::init(strrev(strrev(self::base_convert($a,10,'ascii')) & strrev(self::base_convert($b,10,'ascii'))),'ascii');
	}
	public static function orx($a,$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$a = self::floor($a);
		$b = self::floor($b);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_or(self::_get0($a), self::_get0($b)));
		return self::init(strrev(strrev(self::base_convert($a,10,'ascii')) | strrev(self::base_convert($b,10,'ascii'))),'ascii');
	}
	public static function shl($a,$b = 1){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::mul(self::floor($a), self::powf('2', $b));
	}
	public static function shr($a,$b = 1){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::div(self::floor($a), self::powf('2', $b), 0);
	}
	public static function rtl($a,$b = 1){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::init(binc::rtl(self::base_convert($a,10,2),$b),2);
	}
	public static function rtr($a,$b = 1){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::init(binc::rtr(self::base_convert($a,10,2),$b),2);
	}
	public static function shift($a,$b = 1){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		return self::mul(self::floor($a), self::powf('2', $b));
	}
	public static function resx($a,$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$a = self::floor($a);
		$b = self::floor($b);
		if(__apeip_data::$instGMP){
			$b = self::_get0($b);
			return gmp_strval(gmp_or($b, gmp_xor(self::_get0($a), $b)));
		}
		return self::init(binc::resx(self::base_convert($a,10,2),self::base_convert($b,10,2)),2);
	}
	public static function cmp($a,$b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		if($a == $b)return '0';
		if($a > $b)return '1';
		return '-1';
	}
	public static function neg($x){
		if(!self::_check($x))return false;
		$a = self::floor($a);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_neg(self::_get0($x)));
		return self::init(binc::neg(self::base_convert($x,10,2)),2);
	}
	public static function revb($x){
		if(!self::_check($x))return false;
		return self::init(strrev(self::base_convert($x,10,2)),2);
	}
	public static function bmin($length = 1){
		$length = (int)$length;
		if($length <= 0)return '0';
		if($length == 1)return '1';
		if($length < 30)return (string)(1 << ($length - 1));
		if(__apeip_data::$instBcmath)
			return bcpow('2', $length - 1);
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_pow('2', $length - 1));
		return self::powf('2', $length - 1);
	}
	public static function bmax($length = 1){
		$length = (int)$length;
		if($length <= 0)return '0';
		if($length == 1)return '1';
		if($length < 30)return (string)((1 << $length) - 1);
		if(__apeip_data::$instBcmath)
			return bcsub(bcpow('2', $length), '1');
		if(__apeip_data::$instGMP)
			return gmp_strval(gmp_sub(gmp_pow('2', $length), '1'));
		return self::inc(self::bmin($length + 1));
	}
	// convertor functions
	public static function tonumber($a = '0'){
		if(!self::_check($a))return false;
		return (float)$a;
	}
	public static function toBNC($a = 0){
		if(is_nan($a) || is_infinite($a)) {
			new APError("BNC", "the $a not is a number", APError::ARITHMETIC);
			return false;
		}
		$a = explode('E', $a);
		if(!isset($a[1]))return "{$a[0]}";
		$a = self::powTen($a[0], $a[1]);
		return $a;
	}
	public static function big($x){
		if(!is_numeric($x))
			return false;
		$code = thelinecode();
		$code = substr($code, stripos($code, 'big(') + 10, -1);
		if($code[0] === '"' || $code[0] === "'")
			$c = 1;
		else
			$c = 0;
		$num = '';
		while(is_numeric('0' . ltrim($num) . '0') && isset($code[$c]))
			$num .= $code[$c++];
		$num = substr(ltrim($num), 0, -1);
		if(!is_numeric($num))
			return false;
		return self::_get($num);
	}
	public static function init($number, $init = 10){
		return self::base_convert($number, $init, 10);
	}
	public static function bindec($bin){
		return self::base_convert($bin, 2, 10);
	}
	public static function octdec($oct){
		return self::base_convert($oct, 8, 10);
	}
	public static function hexdec($hex){
		return self::base_convert($hex, 16, 10);
	}
	public static function decbin($number){
		return self::base_convert($number, 10, 2);
	}
	public static function octbin($number){
		return self::base_convert($number, 10, 8);
	}
	public static function hexbin($number){
		return self::base_convert($number, 10, 16);
	}
	public static function decstr($number){
		return self::base_convert($number, 10, 'ascii');
	}
	public static function strdec($string){
		return self::base_convert($string, 'ascii', 10);
	}
	public static function intval($number){
		return intval($number);
	}
	// parser functions
	public static function baseconvert($text, $from = false, $to = false){
		if(is_string($to))$to = strtolower($to);
		if(is_string($from)){
			$from = strtolower($from);
			if($from == 'ascii' && ($to == '01' || $to == array('0', '1')))
				return ltrim(crypt::binencode($text), '0');
			if($from == 'ascii' && ($to == '01234' || $to == array('0', '1', '2', '3', '4')))
				return ltrim(crypt::base4encode($text), '0');
			if($from == 'ascii' && ($to == str::HEX_RANGE || $to == array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c')))
				return ltrim(crypt::hexencode($text), '0');
			if($from == 'ascii')
				return self::baseconvert(crypt::hexencode($text), str::HEX_RANGE, $to);
		}if(is_string($to)){
			if($to == 'ascii' && ($from == '01' || $from == array('0', '1')))
				return crypt::bindecode($text);
			if($to == 'ascii' && ($from == '01234' || $from == array('0', '1', '2', '3', '4')))
				return crypt::base4decode($text);
			if($to == 'ascii' && ($from == str::HEX_RANGE || $from == array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c')))
				return crypt::hexdecode($text);
			if($to == 'ascii'){
				$r = self::baseconvert($text, $from, str::HEX_RANGE);
				if(strlen($r) % 2 == 1)$r = '0'.$r;
				return crypt::hexdecode($r);
			}
		}
		$text = (string)$text;
		if(!is_array($from))$fromel = str_split($from);
		else $fromel = $from;
		if($from == $to)return $text;
		$frome = array();
		foreach($fromel as $key => $value)
			$frome[$value] = $key;
		unset($fromel);
		$fromc = count($frome);
		if(!is_array($to))$toe = str_split($to);
		else $toe = $to;
		$toc = count($toe);
		$texte = array_reverse(str_split($text));
		$textc = count($texte);
		$bs = '0';
		$th = '1';
		if($from === false)
			$bs = $text;
		else
			for($i = 0; $i < $textc; ++$i) {
				$bs = self::add($bs, self::mul(@$frome[$texte[$i]], $th));
				$th = self::mul($th, $fromc);
			}
		$r = '';
		if($to === false)return $bs === '' ? '0' : "$bs";
		while($bs > 0) {
			$r = $toe[self::mod($bs, $toc)] . $r;
			$bs = self::floor(self::div($bs, $toc));
		}
		return $r === '' ? $toe[0] : "$r";
	}
	public static function base_convert($str, $from, $to = 10){
		if($from == 1) {
			$str = (string)strlen($str);
			$from = 10;
		}
		if($from == $to)return $str;
		if($from <= 36 && is_numeric($from))$str = strtolower($str);
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/+=';
		$from = strtolower($from) == "ascii" ? "ascii" : substr($chars, 0, $from);
		$to = strtolower($to) == "ascii" ? "ascii" : substr($chars, 0, $to);
		$to = $to == '0123456789' ? false : $to;
		$from = $from == '0123456789' ? false : $from;
		return self::baseconvert($str, $from, $to);
	}
	public static function strle($number, $min = 1){
		return str_pad(self::base_convert($number, 10, 'ascii'), $min, "\0", STR_PAD_LEFT);
	}
	public static function strbe($number, $min = 1){
		return strrev(str_pad(self::base_convert($number, 10, 'ascii'), $min, "\0", STR_PAD_LEFT));
	}
	public static function intle($string){
		return self::base_convert($number, 'ascii', 10);
	}
	public static function intbe($string){
		return self::base_convert(strrev($number), 'ascii', 10);
	}
	public static function unsign($x){
		return self::init(math::bin($x), 2);
	}
	// calc function
	private static function calcarg($calc, $offset = null){
		preg_match('/(?:(?:(?<x>\((?:\g<x>|\\\\\(|\\\\\)|[^\)])*\))|\\\\\"|[^\"])*\"|[^,])+/', $calc, $match, 0, $offset === null ? 0 : $offset);
		return isset($match[0]) ? self::calc($match[0]) : '';
	}
	public static function calc($calc, $precision = 15){
		if(self::$precision > 0)
			$precision = min(self::$precision, $precision);
		$calc = preg_replace('/(PI|π|PHI|φ|E|DEG|RAD)([0-9])/', '$1*$2', $calc);
		$calc = preg_replace('/([0-9])(PI|π|PHI|φ|E|DEG|RAD)/', '$1*$2', $calc);
		$pi = self::PI($precision);
		$phi = self::PHI($precision);
		$e = self::E($precision);
		$deg = aped('degree', $precision);
		$rad = aped('radian', $precision);
		$calc = str_replace(array('PI', 'π', 'PHI', 'φ', 'E', 'DEG', 'RAD'), array($pi, $pi, $phi, $phi, $e, $deg, $rad), $calc);
		$calc = preg_replace_callback('/\"(?:\\\\\\\\|\\\\\"|[^\"])*\"|(?:0|0o|o)[0-7]+|(?:0x|x)[0-9a-f]+|(?:0b|b)[01]+|\.[0-9]+|[0-9]+\./i', function($x){
			if(substr($x[0], -1) == '.')return substr($x[0], 0, -1);
			switch($x[0][0]){
				case '.':
					return '0' . $x[0];
				case '"':
					return self::strdec(substr($x[0], 1, -1));
				case 'o':
					return self::octdec(substr($x[0], 1));
				case 'x':
					return self::hexdec(substr($x[0], 1));
				case 'b':
					return self::bindec(substr($x[0], 1));
				case '0':
					switch($x[0][1]){
						case 'o':
							return self::octdec(substr($x[0], 2));
						case 'x':
							return self::hexdec(substr($x[0], 2));
						case 'b':
							return self::bindec(substr($x[0], 2));
						default:
							return self::octdec(substr($x[0], 1));
					}
			}
		}, $calc);
		$calc = str_replace(array('<=>', ' ', "\n", "\r", "\t"), array('^', '', '', '', ''), $calc);
		do{
			$calc = str_replace(array('--', '-+', '+-', '++'), array('+', '-', '-', '+'), $prev = $calc);
		}while($prev != $calc);
		$calc = preg_replace('/(?!<[a-zA-Z])([0-9])(\(|\[|[a-zA-Z])/', '$1*$2', $calc);
		do{
			$end = substr($calc, -1);
			if($end === '+' || $end === '-')
				$calc .= '1';
			$calc = preg_replace_callback('/(?<![a-zA-Z])\((?:\\\\\(|\\\\\)|\"(?:\\\\|\\\"|[^\"])*\"|[^\(\)])*\)/', function($x){
				return self::calc(substr($x[0], 1, -1));
			}, $prev = $calc);
			$calc = preg_replace_callback('/(?<![a-zA-Z])\[(?:\\\\\[|\\\\\]|\"(?:\\\\|\\\"|[^\"])*\"|[^\[\]])*\]/', function($x){
				return self::floor(self::calc(substr($x[0], 1, -1), 0));
			}, $calc);
			$calc = preg_replace_callback('/(abs|acos|acosh|asin|asinh|atan|atan2|atanh|base|ceil|cos|cot|csc|deg|exp|expm1|floor|fmod|fumod|hypot|lcg|log|log10|log1p|max|min|pi|phi|rad|rand|round|sec|sin|sinh|sqrt|tan|tanh)(?:(?<x>\((?:\g<x>|\\\\\(|\\\\\)|[^\)])*\))|(?:\g<x>|\\\\\(|\\\\\)|[^\)])*)/', function($x)use($precision){
				$args = substr($x[2], 1, -1);
				switch($x[1]){
					case 'abs':
						return self::abs(self::calcarg($args));
					case 'acos':
						return self::acos(self::calcarg($args), $precision);
					case 'acosh':
						return self::acosh(self::calcarg($args), $precision);
					case 'asin':
						return self::asin(self::calcarg($args), $precision);
					case 'asinh':
						return self::asinh(self::calcarg($args), $precision);
					case 'atan':
						return self::atan(self::calcarg($args), $precision);
					case 'atan2':
						$arg = self::calcarg($args);
						return self::atan2($arg, self::calcarg($args, strlen($arg) + 1), $precision);
					case 'atanh':
						return self::atanh(self::calcarg($args), $precision);
					case 'base':
						$arg1 = self::calcarg($args);
						$len  = strlen($arg1) + 1;
						$arg2 = self::calcarg($args, $len);
						$arg3 = self::calcarg($args, strlen($arg2) + $len + 1);
						if($arg2 === '')$arg2 = '10';
						if($arg3 === '')$arg3 = '10';
						return self::base_convert($arg1, $arg2, $arg3);
					case 'ceil':
						return self::ceil(self::calcarg($args));
					case 'cos':
						return self::cos(self::calcarg($args), $precision);
					case 'cot':
						return self::cot(self::calcarg($args), $precision);
					case 'csc':
						return self::csc(self::calcarg($args), $precision);
					case 'deg':
						return self::deg(self::calcarg($args), $precision);
					case 'exp':
						return self::exp(self::calcarg($args), $precision);
					case 'expm1':
						return self::expm1(self::calcarg($args), $precision);
					case 'floor':
						return self::floor(self::calcarg($args));
					case 'fmod':
						return self::fmod(self::calcarg($args));
					case 'fumod':
						return self::fumod(self::calcarg($args));
					case 'hypot':
						$arg = self::calcarg($args);
						return self::hypot($arg, self::calcarg($args, strlen($arg) + 1), $precision);
					case 'lcg':
						$arg = self::calcarg($args);
						if($arg === '')$arg = null;
						return self::lcg($arg, $precision);
					case 'log':
						$arg = self::calcarg($args);
						return self::log($arg, self::calcarg($args, strlen($arg) + 1), $precision);
					case 'ln':
						return self::ln(self::calcarg($args), $precision);
					case 'max':
					case 'min':
						$arg = array();
						$now = self::calcarg($args);
						$len = strlen($now) + 1;
						while($len !== 1){
							$arg[] = $now;
							$now = self::calcarg($args, $len);
							$len += strlen($now) + 1;
						}
						return call_user_func_array($x[1], $arg);
					case 'nmod':
						return self::nmod(self::calcarg($args));
					case 'pi':
						return self::PI(self::calcarg($args), $precision);
					case 'phi':
						return self::PHI(self::calcarg($args), $precision);
					case 'rad':
						return self::rad(self::calcarg($args), $precision);
					case 'rand':
						$arg = self::calcarg($args);
						return self::rand($arg, self::calcarg($args, strlen($arg) + 1));
					case 'round':
						return self::round(self::calcarg($args));
					case 'sec':
						return self::sec(self::calcarg($args), $precision);
					case 'sin':
						return self::sin(self::calcarg($args), $precision);
					case 'sinh':
						return self::sinh(self::calcarg($args), $precision);
					case 'sqrt':
						return self::sqrt(self::calcarg($args), $precision);
					case 'tan':
						return self::tan(self::calcarg($args), $precision);
					case 'tanh':
						return self::tanh(self::calcarg($args), $precision);
					case 'umod':
						return self::umod(self::calcarg($args));
				}
			}, $calc);
			foreach(array(
				array(1, '~'),
				array(1, '\*\*', '\*\/', '\*%'),
				array(1, '\*', '\/', '%'),
				array(1, '\+', '-'),
				array(1, '_'),
				array(1, '>>', '<<', '<>>', '<<>', '<>'),
				array(1, '&', '\|', '^', '=>', '=<'),
				array(2, '!', '~'),
				array(3, '!', '~'),
				array(1, '&&', '\|\|', '==', '!=', '<=', '>=', '<', '>'),
			) as $signs){
				$regex = implode('|', array_slice($signs, 1));
				switch($signs[0]){
					case 1:
						$calc = preg_replace_callback("/(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)($regex)(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)/", function($x)use($precision){
							switch($x[2]){
								case '~':
									return self::rand($x[1], $x[3]);
								case '**':
									return self::pow($x[1], $x[3], $precision);
								case '*/':
									return self::pow($x[1], self::div('1', $x[3], $precision), $precision);
								case '*%':
									return self::powf($x[1], $x[3]);
								case '*':
									return self::mul($x[1], $x[3]);
								case '/':
									return self::div($x[1], $x[3], $precision);
								case '%':
									return self::mod($x[1], $x[3]);
								case '+':
									return self::add($x[1], $x[3]);
								case '-':
									return self::sub($x[1], $x[3]);
								case '_':
									return strpos($x[3], '.') !== false ? $x[1] . $x[3] : self::floor($x[1]) . $x[3];
								case '>>':
									return self::shr($x[1], $x[3]);
								case '<<':
									return self::shl($x[1], $x[3]);
								case '<>>':
									return self::rtr($x[1], $x[3]);
								case '<<>':
									return self::rtl($x[1], $x[3]);
								case '&':
									return self::andx($x[1], $x[3]);
								case '|':
									return self::orx($x[1], $x[3]);
								case '^':
									return self::xorx($x[1], $x[3]);
								case '=>':
									return self::resx($x[1], $x[3]);
								case '=<':
									return self::resx($x[3], $x[1]);
								case '&&':
									return $x[1] == 0 || $x[3] == 0 ? '0' : '1';
								case '||':
									return $x[1] == 0 && $x[3] == 0 ? '0' : '1';
								case '==':
									return $x[1] == $x[3] ? '1' : '0';
								case '!=':
									return $x[1] != $x[3] ? '1' : '0';
								case '<=':
									return $x[1] <= $x[3] ? '1' : '0';
								case '>=':
									return $x[1] >= $x[3] ? '1' : '0';
								case '>':
									return $x[1] > $x[3] ? '1' : '0';
								case '<':
									return $x[1] < $x[3] ? '1' : '0';
							}
						}, $calc);
					break;
					case 2:
						$calc = preg_replace_callback("/(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)($regex)/", function($x){
							switch($x[2]){
								case '!':
									return self::fact($x[1]);
								case '~':
									return self::revb($x[1]);
							}
						}, $calc);
					break;
					case 3:
						$calc = preg_replace_callback("/($regex)(-{0,1}[0-9]+\.[0-9]+|-{0,1}[0-9]+)/", function($x){
							switch($x[2]){
								case '!':
									return $x[2] == '0' ? '1' : '0';
								case '~':
									return self::neg($x[1]);
							}
						}, $calc);
				}
			}
		}while($prev != $calc);
		if($calc === '')return '0';
		return $calc;
	}
}
class Binc {
	// validator
	public static function is_binary($a){
		return preg_match('/^[01]+$/', $a);
	}
	// system functions
	private static function _check($a){
		if(!self::is_binary($a)) {
			if(strlen($a) > 20)$a = substr($a, 0, 12). '...' . substr($a, -5);
			new APError("apeipBin", "invalid binary \"$a\".", APError::ARITHMETIC);
			return false;
		}
		return true;
	}
	private static function _set($a, $b){
		if(!self::_check($a))return false;
		if(!self::_check($b))return false;
		$l = strlen($b) - strlen($a);
		if($l <= 0)return $a;
		else return str_repeat('0', $l). $a;
	}
	private static function _setall(&$a, &$b){
		$a = self::_set($a, $b);
		if($a === false)return false;
		$b = self::_set($b, $a);
		if($b === false)return false;
		return true;
	}
	private function _get($a){
		if(!self::_check($a))return false;
		$a = ltrim($a, '0');
		return $a ? $a : '0';
	}
	private function _setfull(&$a, &$b){
		$a = self::_get($a);
		if($a === false)return false;
		$b = self::_get($b);
		if($b === false)return false;
		self::_setall($a, $b);
		return true;
	}
	private function _getfull(&$a){
		$a = self::_get($a);
		if($a === false)return false;
		return true;
	}
	// parser functions
	// calc functions
	public static function xorx($a, $b){
		if(!self::_setfull($a, $b))return false;
		for($c = 0; isset($a[$c]); ++$c)$a[$c] = ($a[$c] == $b[$c]) ? '0' : '1';
		return $a;
	}
	public static function add($a, $b){
		if(!self::_setfull($a, $b))return false;
		if($a == 0)return $b;
		if($b == 0)return $a;
		$a = "0$a";
		$b = "0$b";
		$l = strlen($a);
		for($c = 0; $c < $l; ++$c) {
			$a[$c] = $a[$c] + $b[$c];
			$w = 0;
			while($a[$c - $w] == 2) {
				$a[$c - $w - 1] = $a[$c - $w - 1] + 1;
				$a[$c - $w] = 0;
				++$w;
			}
		}
		if($a[0] == '0')$a = substr($a, 1);
		return self::_get($a);
	}
	public static function inc($x){
		if(!self::_check($x))return false;
		for($i = strlen($x) - 1; $i > -2; --$i)
			if($i == -1)
				return "1$x";
			elseif($x[$i] == '0'){
				$x[$i] = '1';
				return $x;
			}else
				$x[$i] = '0';
	}
	public static function dec($x){
		if(!self::_check($x))return false;
		if($x == 0)return '0';
		for($i = strlen($x) - 1; $i > -1; --$i)
			if($x[$i] == '1'){
				$x[$i] = '0';
				return self::_get($x);
			}else
				$x[$i] = '1';
	}
	public static function sub($a, $b){
		if(!self::_setfull($a, $b))return false;
		if($b > $a)swap($a, $b);
		if($b == 0)return $a;
		if($a == $b)return 0;
		$l = strlen($a);
		$a = str_split($a);
		for($c = 0; $c < $l; ++$c) {
			$a[$c] = $a[$c] - $b[$c];
			$w = 0;
			while($a[$c - $w] == -1) {
				$k = 1;
				while($a[$c - $w - $k] == 0) {
					$a[$c - $w - $k] = 1;
					++$k;
				}
				$a[$c - $w - $k] = 0;
				$a[$c - $w] = 1;
				++$w;
			}
		}
		return self::_get(implode('', $a));
	}
	public static function mul($a, $b){
		if(!self::_setfull($a, $b))return false;
		$g = str_repeat('0', strlen($a));
		if($a == 0 || $b == 0)return '0';
		$l = strlen($a);
		for($x = 0; $x < $l; ++$x) {
			$r = '';
			for($y = 0; $y < $l; ++$y)$r.= $a[$x] * $b[$y];
			if($x > 0)$r.= str_repeat('0', $x);
			$g = self::add($g, $r);
		}
		return self::_get($g);
	}
	public static function div($a, $b){
		if(!self::_getfull($a))return false;
		if(!self::_getfull($b))return true;
		if($b > $a)swap($a, $b);
		$c = '';
		$d = '';
		for($i = 0; isset($a[$i]); ++$i){
			$d .= $a[$i];
			if($d >= $b){
				$c .= '1';
				$d = self::sub($d, $b);
			}else $c .= '0';
		}
		return self::_get($c);
	}
	public static function mod($a, $b){
		if(!self::_getfull($a))return false;
		if(!self::_getfull($b))return true;
		if($b > $a)swap($a, $b);
		$c = '';
		$d = '';
		for($i = 0; isset($a[$i]); ++$i){
			$d .= $a[$i];
			if($d >= $b){
				$c .= '1';
				$d = self::sub($d, $b);
			}else $c .= '0';
		}
		return $d;
	}
	public static function shr($a, $shift = 1){
		if(!self::_getfull($a))return false;
		if($shift == 0)return $a;
		$a = substr($a, 0, -$shift);
		return $a === '' || $a === false ? '0' : $a;
	}
	public static function shl($a, $shift = 1){
		if(!self::_getfull($a))return false;
		if($shift == 0)return $a;
		return $a . str_repeat('0', $shift);
	}
	public static function shift($a, $shift = 1){
		if(!self::_getfull($a))return false;
		if($shift == 0)return $a;
		if($shift < 0){
			$a = substr($a, 0, -$shift);
			return $a === '' || $a === false ? '0' : $a;
		}
		return $a . str_repeat('0', $shift);
	}
	public static function rtr($a, $rotate = 1){
		if(!self::_getfull($a))return false;
		if($rotate == 0)return $a;
		return substr($a, -$rotate) . substr($a, 0, -$rotate);
	}
	public static function rtl($a, $rotate = 1){
		if(!self::_getfull($a))return false;
		if($rotate == 0)return $a;
		return substr($a, $rotate) . substr($a, 0, $rotate);
	}
	public static function andx($a, $b){
		if(!self::_setfull($a, $b))return false;
		for($c = 0;isset($a[$c]);++$c){
			if($a[$c] === '1' && $b[$c] === '1');
			else $a[$c] = '0';
		}
		return self::_get($a);
	}
	public static function orx($a, $b){
		if(!self::_setfull($a, $b))return false;
		$l = strlen($a);
		for($c = 0;isset($a[$c]);++$c){
			if($a[$c] === '1' || $b[$c] === '1')
				$a[$c] = '1';
			else $a[$c] = '0';
		}
		return self::_get($a);
	}
	public static function resx($a, $b){
		if(!self::_setfull($a, $b))return false;
		$l = strlen($a);
		for($c = 0;isset($a[$c]);++$c){
			if($a[$c] === '1' && $b[$c] === '0')
				$a[$c] = '0';
			else $a[$c] = '1';
		}
		return self::_get($a);
	}
	public static function neg($x){
		return strtr($x, '01', '10');
	}

	// convertors
	public static function init($a, $init = 2){
		return bnc::base_convert($a, $init, 2);
	}
}
class BIC { // Big Integer Calculator
	public $number  = '0';
	public $base	= '0123456789';
	public $basenum = 510;
	public $baselen = 10;
	public $intlen  = 9;
	public $intmax  = 999999999;

	public function init($number, $base = null){
		if($number instanceof bic){
			if($base === null)$base = $number->base;
			$number = $number->number;
		}
		if($base === null)$base = self::FASTDEC;
		if(is_array($number) && (int)$base == $base){
			$this->basenum = $base;
			$this->base = $this->getbase($base);
			$this->baselen = strlen($this->base);
			$this->intlen = (int)(PHP_INT_SIZE * 8 / log($this->baselen, 2));
			$this->intmax = pow($this->baselen, $this->intlen) - 1;
			$this->number = array_map('intval', $number);
			return;
		}
		$this->basenum = $base;
		$base = $this->getbase($base);
		if($this->basenum == $base)
			$this->basenum = $this->parsebase($base);
		if($number !== '0' && !$number)
			$number = $base[0];
		$this->base = $base;
		$this->baselen = strlen($base);
		$this->intlen = (int)(PHP_INT_SIZE * 8 / log($this->baselen, 2));
		$this->intmax = pow($this->baselen, $this->intlen) - 1;
		if(!str::strinrange($number, $base))
			new APError('bic', "Invalid base range '$base' for number '$number'", APError::WARNING, APError::TTHROW);
		$this->number = $this->packbase($number);
		$this->getarg();
	}
	public function __construct($number, $base = 510){
		$this->init($number, $base);
	}
	public static function zero($base = 510){
		return new bic('', $base);
	}
	public static function one($base = 510){
		$int = new bic('', $base);
		return $int->inc();
	}
	public function chr($index){
		return isset($this->base[(int)$index]) ? $this->base[(int)$index] : $this->base[0];
	}
	public function ord($number){
		$number = strpos($this->base, $number);
		return $number === false ? 0 : $number;
	}
	public function has($number){
		return strpos($this->base, $number) !== false;
	}
	public function fast(){
		if($this->basenum >= 500)return;
		$this->number = $this->unpackbase($this->number);
		$this->basenum = $this->basenum % 500 + 500;
		$this->number = $this->packbase($this->number);
	}
	public function unfast(){
		if($this->basenum < 500)return;
		$this->number = $this->unpackbase($this->number);
		$this->basenum %= 500;
		$this->number = $this->packbase($this->number);
	}

	// operations
	private function getarg($number = null){
		if($number === null){
			while(($pop = array_pop($this->number)) === 0 || $pop === 0.0);
			if($pop === null)
				$this->number[] = 0;
			else
				$this->number[] = $pop;
			return;
		}
		if(is_string($number) || is_int($number) || is_float($number)){
			$number = ltrim($number, $this->base[0]);
			return $this->packbase($number);
		}elseif(is_array($number)){
			while(($pop = array_pop($number)) === 0);
			if($pop === null)
				$number[] = 0;
			else
				$number[] = $pop;
			return $number;
		}elseif(!($number instanceof bic))
			new APError('bic', "Invalid number '$number'", APError::WARNING, APError::TTHROW);
		return $number->copy()->conv($this->base)->number;
	}
	private function getobj($number){
		if(is_string($number) || is_int($number) || is_float($number)){
			$number = ltrim($number, $this->base[0]);
			return new bic($number, $this->base);
		}elseif(is_array($number)){
			while(($pop = array_pop($number)) === 0);
			if($pop === null)
				$number[] = 0;
			else
				$number[] = $pop;
			return new bic($number, $this->base);
		}elseif(!($number instanceof bic))
			new APError('bic', "Invalid number '$number'", APError::WARNING, APError::TTHROW);
		return $number->copy()->conv($this->base);
	}
	public function add($number){
		$a = $this->number;
		$b = $this->getarg($number);
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		$d = 0;
		for($i = 0; isset($b[$i]); ++$i){
			$d += $b[$i];
			if(isset($a[$i]))$a[$i] += $d;
			else $a[$i] = $d;
			if($a[$i] >= $s){
				$d = floor($a[$i] / $s);
				$a[$i] %= $s;
			}else $d = 0;
		}
		while($d > 0){
			if(isset($a[$i]))$a[$i] += $d;
			else $a[$i] = $d;
			if($a[$i] >= $s){
				$d = floor($a[$i] / $s);
				$a[$i] %= $s;
			}else $d = 0;
			++$i;
		}
		$this->number = $a;
		return $this;
	}
	public function inc(){
		$a = $this->number;
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		++$a[0];
		for($i = 0; $a[$i] == $s; ++$i){
			$a[$i] = 0;
			if(isset($a[$i + 1]))++$a[$i + 1];
			else $a[$i + 1] = 1;
		}
		$this->number = $a;
		return $this;
	}
	public function sub($number){
		$a = $this->number;
		$b = $this->getarg($number);
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		for($i = 0; isset($b[$i]); ++$i){
			if(!isset($a[$i]))$a[$i] = 0;
			if($a[$i] < $b[$i]){
				for($c = 1; isset($a[$i + $c]); ++$c)
					if($a[$i + $c] == 0)
						$a[$i + $c] = $s - 1;
					else{
						$a[$i + $c] -= 1;break;
					}
				if(!isset($a[$i + $c]))
					return $this->rsub($number);
				$a[$i] += $s;
			}
			$a[$i] -= $b[$i];
		}
		$this->number = $a;
		return $this;
	}
	public function rsub($number){
		$a = $this->number;
		$b = $this->getarg($number);
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		for($i = 0; isset($a[$i]); ++$i){
			if(!isset($b[$i]))$b[$i] = 0;
			if($b[$i] < $a[$i]){
				for($c = 1; isset($b[$i + $c]); ++$c)
					if($b[$i + $c] == 0)
						$b[$i + $c] = $s - 1;
					else{
						$b[$i + $c] -= 1;break;
					}
				if(!isset($b[$i + $c]))
					return $this->sub($number);
				$b[$i] += $s;
			}
			$b[$i] -= $a[$i];
		}
		$this->number = $b;
		return $this;
	}
	public function dec(){
		$a = $this->number;
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		if($a == array(0)){
			$this->number = array($s - 1);
			return $this;
		}--$a[0];
		for($i = 0; $a[$i] == -1; ++$i){
			$a[$i] = $s - 1;
			--$a[$i + 1];
		}
		$this->number = $a;
		return $this;
	}
	public function neg(){
		$a = $this->number;
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		for($i = 0; isset($a[$i]); ++$i)
			$a[$i] = $s - $a[$i] - 1;
		$this->getarg();
		$this->number = $a;
		return $this;
	}
	public function getsize($bit = false){
		$bit = count($this->number) * ($this->intlen + 1);
		return $bit === false ? (int)($bit / 8) : $bit;
	}
	public function mulTen($x, $push = false){
		if(!$push && $this->basenum > 255){
			$this->number = $this->unpackbase($this->number);
			$this->number.= str_repeat($this->base[0], $x);
			$this->number = $this->packbase($this->number);
		}else
			for($i = 0; $i < $x; ++$i)
				array_unshift($this->number, 0);
		return $this;
	}
	public function mul($number){
		if($this->basenum >= 500){
			$big = true;
			$this->unfast();
		}else $big = false;
		$a = $this->number;
		$b = $this->getarg($number);
		$s = $this->baselen;
		$this->number = array(0);
		for($i = 0; isset($b[$i]); ++$i){
			$v = $a;
			$d = 0;
			for($c = 0; isset($v[$c]); ++$c){
				$v[$c] = ($v[$c] * $b[$i]) + $d;
				if($v[$c] >= $s){
					$d = floor($v[$c] / $s);
					$v[$c] %= $s;
				}else $d = 0;
			}
			if($d > 0)
				$v[] = $d;
			for($c = 0; $c < $i; ++$c)
				array_unshift($v, 0);
			$this->add($v);
		}
		if($big)$this->fast();
		return $this;
	}
	public function mulTwo(){
		if($this->basenum >= 500){
			$big = true;
			$this->unfast();
		}else $big = false;
		$a = $this->number;
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		$d = 0;
		for($c = 0; isset($a[$c]); ++$c){
			$a[$c] = $a[$c] * 2 + $d;
			if($a[$c] >= $s){
				$d = floor($a[$c] / $s);
				$a[$c] %= $s;
			}else $d = 0;
		}
		if($d > 0)
			$a[] = $d;
		$this->number = $a;
		if($big)$this->fast();
		return $this;
	}
	public function cmp($number){
		$a = $this->number;
		$b = $this->getarg($number);
		if($this->basenum >= 500)$s = $this->intmax + 1;
		else $s = $this->baselen;
		$la = count($a);
		$lb = count($b);
		if($la > $lb)return 1;
		if($lb > $la)return -1;
		for($i = $la - 1; $i >= 0; --$i)
			if($a[$i] > $b[$i])return 1;
			elseif($b[$i] > $a[$i])return -1;
		return 0;
	}
	private function _div0($x){
		$s = $this->basenum;
		$int = new bic($x, $s);
		$muls = array();
		$int->save();
		while(--$s > 1){
			$muls[$s - 1] = $int->mul($s)->number;
			$int->reset();
		}
		$muls[0] = $int->number;
		return $muls;
	}
	private function _div1($muls){
		$s = $this->basenum;
		for($i = 0; $i < $s - 1; ++$i)
			if($this->cmp($muls[$i]) == -1)return $i;
		return $i;
	}
	public function div($number){
		if($this->basenum >= 500){
			$big = true;
			$this->unfast();
		}else $big = false;
		$a = $this->number;
		$b = $this->getarg($number);
		if($b == array(0)){
			new APError("BIC div", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		$s = $this->baselen;
		$muls = $this->_div0($b);
		$r = array(0);
		$p = new bic('', $this->base);
		$d = new bic('', $this->base);
		for($i = count($a) - 1; $i >= 0; --$i){
			array_unshift($d->number, $a[$i]);
			$d->getarg();
			$p->number = array($d->_div1($muls));
			$d->sub($p->save()->mul($b)->number);
			$p->back();
			array_unshift($r, $p->number[0]);
		}
		$this->number = $r;
		if($big)$this->fast();
		else $this->getarg();
		return $this;
	}
	public function mod($number){
		if($this->basenum >= 500){
			$big = true;
			$this->unfast();
		}else $big = false;
		$a = $this->number;
		$b = $this->getarg($number);
		if($b == array(0)){
			new APError("BIC mod", "not can div by Ziro", APError::ARITHMETIC);
			return false;
		}
		$s = $this->baselen;
		$muls = $this->_div0($b);
		$r = array(0);
		$p = new bic('', $this->base);
		$d = new bic('', $this->base);
		for($i = count($a) - 1; $i >= 0; --$i){
			array_unshift($d->number, $a[$i]);
			$d->getarg();
			$p->number = array($d->_div1($muls));
			$d->sub($p->save()->mul($b)->number);
			$p->back();
			array_unshift($r, $p->number[0]);
		}
		$this->number = $d->number;
		if($big)$this->fast();
		else $this->getarg();
		return $this;
	}
	private function _pow($number){
		if($number->number === array(0))
			return $this->number = array(1);
		if($number->number === array(1))
			return;
		if($number->number[0] % 2 == 1){
			$x = $this->number;
			$this->mul($x);
			$number->div(2);
			$this->_pow($number);
			$this->mul($x);
		}else{
			$this->mul($this->number);
			$number->div(2);
			$this->_pow($number);
		}
	}
	public function pow($number){
		$number = $this->getobj($number);
		$this->_pow($number);
		return $this;
	}
	private function _powmod($pow, $mod){
		if($mod->number === array(1))
			return $this->number = array(0);
		if($pow->number === array(0))
			return $this->number = array(1);
		if($pow->number === array(1))
			return;
		if($pow->number[0] % 2 == 1){
			$x = $this->number;
			$this->mul($x)->mod($mod);
			$pow->div(2);
			$this->_pow($pow);
			$this->mul($x)->mod($mod);
		}else{
			$this->mul($this->number)->mod($mod);
			$pow->div(2);
			$this->_pow($pow);
		}
	}
	public function powmod($pow, $mod){
		$pow = $this->getobj($pow);
		$mod = $this->getobj($mod);
		$this->_powmod($pow, $mod);
		return $this;
	}
	public function shl($count){
		for($i = 0; $i < $count; ++$i)
			array_unshift($this->number, 0);
		return $this;
	}
	public function shr($count){
		$this->number = array_slice($this->number, $count);
		if($this->number === array())
			$this->number = array();
		return $this;
	}
	public function rtl($count){
		for($i = 0; $i < $count; ++$i)
			$this->number[] = array_shift($this->number);
		return $this;
	}
	public function rtr($count){
		for($i = 0; $i < $count; ++$i)
			array_unshift($this->number, array_pop($this->number));
		return $this;
	}
	public function andx($by){
		$by = $this->getobj($by);
		$this->number = array_slice($this->number, 0, count($by->number));
		for($i = 0; isset($this->number[$i]); ++$i)
			$this->number[$i] &= $by->number[$i];
		$this->getarg();
		return $this;
	}
	public function orx($by){
		$by = $this->getobj($by);
		$c = count($by->number) - count($this->number);
		if($c > 0)$this->rtl($c);
		for($i = 0; isset($by->number[$i]); ++$i)
			$this->number[$i] |= $by->number[$i];
		$this->getarg();
		return $this;
	}
	public function xorx($by){
		$by = $this->getobj($by);
		$c = count($by->number) - count($this->number);
		if($c > 0)$this->rtl($c);
		for($i = 0; isset($by->number[$i]); ++$i)
			$this->number[$i] ^= $by->number[$i];
		$this->getarg();
		return $this;
	}
	public function resx($by){
		$by = $this->getobj($by);
		$c = count($by->number) - count($this->number);
		if($c > 0)$this->rtl($c);
		for($i = 0; isset($by->number[$i]); ++$i)
			$this->number[$i] = math::res($this->number[$i], $by->number[$i]);
		$this->getarg();
		return $this;
	}
	public function rands($length = 1, $type = 0){
		if($length <= 0){
			$this->number = array(0);
			return;
		}
		$number = array();
		for($i = 0; $i < $length; ++$i)
			$number[] = rand(0, $this->baselen - 1);
		$this->number = $number;
		$this->getarg();
		return $this;
	}
	public function rand($by, $type = 0){
		$by = $this->getobj($by);
		$n1 = array_reverse($this->number);
		$n2 = array_reverse($by->number);
		$c1 = count($n1);
		$c2 = count($n2);
		if($c1 < $c2){
			$c = $c2 - $c1;
			for($i = 0; $i < $c; ++$i)
				array_unshift($n1, 0);
		}elseif($c2 < $c1){
			$c = $c1 - $c2;
			for($i = 0; $i < $c; ++$i)
				array_unshift($n2, 0);
		}
		$n = array();
		$e = -1;
		for($i = 0; isset($n1[$i]); ++$i)
			if($e == -1){
				$n[] = $c = rand::int($n1[$i], $n2[$i], $type);
				if($n1[$i] == $n2[$i])$e = -1;
				elseif($c == $n1[$i])$e = 2;
				elseif($c == $n2[$i])$e = 0;
				else $e = 1;
			}elseif($e == 0){
				$n[] = $c = rand::int(0, $n2[$i], $type);
				if($c == $n2[$i])$e = 0;
				else $e = 1;
			}elseif($e == 2){
				$n[] = $c = rand::int($n1[$i], $this->baselen, $type);
				if($c == $n1[$i])$e = 2;
				else $e = 1;
			}else
				$n[] = rand::int(0, $this->baselen, $type);
		$this->number = array_reverse($n);
		$this->getarg();
		return $this;
	}
	public function reverse(){
		$this->number = array_reverse($this->number);
		return $this;
	}

	// algorithms
	public function fact($number){
		$this->number = array(1);
		while($number > 1){
			$this->mul(math::baseconvert($number, '0123456789', $this->base));
			--$number;
		}
		return $this;
	}
	public function sqrt(){
		$x = $this->copy();
		$y = new bic($this->base[1], $this->base);
		$two = $this->baselen == 2 ? array(1, 0) : array(2);
		$n = new bic('', $this->base);
		while($x != $y && $x->cmp($n->number) != -1) {
			$x->add($y->number)->div($two);
			$y = $this->copy()->div($x->number);
			$n->inc();
		}
		$this->number = $x->number;
		return $this;
	}

	// base functions
	const BASE32	 = 257;
	const BASE64	 = 258;
	const NSEC3		 = 259;
	const BCRYPT64   = 260;
	const BASE64URL  = 261;
	const BASELOWER  = 262;
	const BASEUPPER  = 263;
	const BASEALPHBA = 264;
	const BASEROMAN  = 265;
	const ASCII 	 = 256;
	const BASE256	 = 256;
	const BASEBIN	 = 2;
	const BASE4		 = 4;
	const BASEOCT	 = 8;
	const BASEDEC	 = 10;
	const BASEHEX	 = 16;
	const BASEEN	 = 36;
	const FASTBIN	 = 502;
	const FASTBASE4  = 504;
	const FASTOCT	 = 508;
	const FASTDEC	 = 510;
	const FASTHEX	 = 516;
	const BASEFAST   = 500;
	public function getbase($base){
		if((string)(int)$base === (string)$base && $base > 1){
			if($base >= 500){
				if($base > 536 || $base < 502)
					new APError('bic', "Invalid base $base", APError::WARNING, APError::TTHROW);
				$base -= 500;
			}
			if($base <= 65)
				return substr('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/+=', 0, (int)$base);
			switch($base){
				case self::BASE32  :return str::BASE32_RANGE;
				case self::BASE64  :return str::BASE64_RANGE;
				case self::NSEC3   :return str::NSEC3_RANGE;
				case self::BCRYPT64:return str::BCRYPT64_RANGE;
				case self::BASE64URL :return str::BASE64URL_RANGE;
				case self::BASELOWER :return str::LOWER_RANGE;
				case self::BASEUPPER :return str::UPPER_RANGE;
				case self::BASEALPHBA:return str::ALPHBA_RANGE;
				case self::BASEROMAN :return str::ROMAN_RANGE;
			}
			if($base <= 256)
				return substr(str::ASCII_RANGE, 0, $base);
		}
		if(strlen($base) > 1)
			return $base;
		new APError('bic', "Invalid base $base", APError::WARNING, APError::TTHROW);
	}
	private function parsebase($base){
		$l = strlen($base);
		if(substr('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/+=', 0, $l) == $base)
			return $l;
		switch($base){
			case str::BASE32_RANGE:self::BASE32;
			case str::BASE64_RANGE:self::BASE64;
			case str::NSEC3_RANGE :self::NSEC3;
			case str::BCRYPT64_RANGE :self::BCRYPT64;
			case str::BASE64URL_RANGE:self::BASE64URL;
			case str::LOWER_RANGE :self::BASELOWER;
			case str::UPPER_RANGE :self::BASEUPPER;
			case str::ALPHBA_RANGE:self::BASEALPHBA;
			case str::ROMAN_RANGE :self::BASEROMAN;
		}
		if(substr(str::ASCII_RANGE, 0, $l) == $base)
			return $l;
		return false;
	}
	private function packbase($box){
		if($this->basenum >= 500)
			return array_map(function($number){
				return (int)strtr(strrev($number), $this->base, str::DEC_RANGE);
			}, str_split(strrev($box), $this->intlen));
		else
			return array_map(function($number){
				return $number ? strpos($this->base, $number) : 0;
			}, str_split(strrev($box)));
	}
	private function unpackbase($box){
		if($this->basenum >= 500)
			$number = ltrim(strrev(implode('', array_map(function($number){
				return str_pad(strrev(strtr($number, str::DEC_RANGE, $this->base)), $this->intlen, $this->base[0]);
			}, $box))), $this->base[0]);
		else
			$number = ltrim(strrev(implode('', array_map(function($number){
				return $this->base[(int)$number];
			}, $box))), $this->base[0]);
		return $number === '' ? $this->base[0] : $number;
	}
	public function copy(){
		$int = new bic('', $this->base);
		$int->number = $this->number;
		return $int;
	}
	public function set($number){
		$this->number = $this->getarg($number);
		return $this;
	}
	public function strval(){
		return $this->unpackbase($this->number);
	}
	public function intval(){
		$number = $this->copy()->conv($this->basenum < 500 ? 10 : 510);
		return (int)$number->unpackbase($number->number);
	}
	public function baseval($base){
		$number = $this->copy()->conv($base);
		return $number->unpackbase($number->number);
	}
	public function __toString(){
		return $this->unpackbase($this->number);
	}

	// converters
	public function conv($base){
		if($this->basenum >= 500){
			$big = true;
			$this->unfast();
		}else $big = false;
		$base = new bic('', $base);
		if($this->base == $base->base){
			if($big)$this->fast();
			return $this;
		}
		$mul = math::baseconvert($this->baselen, '0123456789', $base->base);
		$num = array_reverse($this->number);
		foreach($num as $x)
			$base->mul($mul)->add($x);
		$this->number = $base->number;
		$this->base = $base->base;
		$this->basenum = $base->basenum;
		$this->baselen = $base->baselen;
		$this->intlen = $base->intlen;
		$this->intmax = $base->intmax;
		if($big)$this->fast();
		return $this;
	}
	public static function parse($number, $base){
		if(is_array($number)){
			foreach($number as &$item)
				$item = self::parse($item, $base);
			return $number;
		}elseif(is_int($number) || is_float($number)){
			$int = new bic((int)$number, 10);
			return $int->conv($base);
		}elseif(is_string($number))
			return new bic($number, $base);
		elseif($number === null)
			return new bic('', $base);
		else return false;
	}

	// backup
	private $backup = array();
	public function save(){
		$this->backup[] = array($this->number, $this->base, $this->basenum, $this->baselen, $this->intlen, $this->intmax);
		return $this;
	}
	public function back(){
		$pop = array_pop($this->backup);
		if(!$pop)
			$this->number = array(0);
		else{
			$this->number = $pop[0];
			$this->base = $pop[1];
			$this->basenum = $pop[2];
			$this->baselen = $pop[3];
			$this->intlen = $pop[4];
			$this->intmax = $pop[5];
		}
		return $this;
	}
	public function reset(){
		$pop = array_pop($this->backup);
		if(!$pop)
			$this->number = array(0);
		else{
			$this->number = $pop[0];
			$this->base = $pop[1];
			$this->basenum = $pop[2];
			$this->baselen = $pop[3];
			$this->intlen = $pop[4];
			$this->intmax = $pop[5];
			$this->backup[] = $pop;
		}
		return $this;
	}

	// max|min
	public static function min(){
		$ints = func_get_args();
		if(is_array($ints[0]) && !isset($ints[1]))
			$ints = $ints[0];
		$int = array_shift($ints);
		if($ints === array() || !$int)
			return false;
		foreach($ints as $cmp)
			if($int->cmp($cmp) == 1)
				$int = $cmp;
		return $int;
	}
	public static function max(){
		$ints = func_get_args();
		if(is_array($ints[0]) && !isset($ints[1]))
			$ints = $ints[0];
		$int = array_shift($ints);
		if($ints === array() || !$int)
			return false;
		foreach($ints as $cmp)
			if($int->cmp($cmp) == -1)
				$int = $cmp;
		return $int;
	}
	public static function average(){
		$ints = func_get_args();
		if(is_array($ints[0]) && !isset($ints[1]))
			$ints = $ints[0];
		$int = new bic('', isset($ints[0]->base) ? $ints[0]->base : array_shift($ints));
		$c = count($ints);
		if($c == 0)return false;
		foreach($ints as $ave)
			$int->add($ave);
		return $int->div($c);
	}
}

/* ---------- APEIP Cryptography ---------- */
class Crypt {
	protected static $crc8table = array(
		0x00, 0x07, 0x0E, 0x09, 0x1C, 0x1B, 0x12, 0x15, 0x38, 0x3F, 0x36, 0x31, 0x24, 0x23, 0x2A, 0x2D,
		0x70, 0x77, 0x7E, 0x79, 0x6C, 0x6B, 0x62, 0x65, 0x48, 0x4F, 0x46, 0x41, 0x54, 0x53, 0x5A, 0x5D,
		0xE0, 0xE7, 0xEE, 0xE9, 0xFC, 0xFB, 0xF2, 0xF5, 0xD8, 0xDF, 0xD6, 0xD1, 0xC4, 0xC3, 0xCA, 0xCD,
		0x90, 0x97, 0x9E, 0x99, 0x8C, 0x8B, 0x82, 0x85, 0xA8, 0xAF, 0xA6, 0xA1, 0xB4, 0xB3, 0xBA, 0xBD,
		0xC7, 0xC0, 0xC9, 0xCE, 0xDB, 0xDC, 0xD5, 0xD2, 0xFF, 0xF8, 0xF1, 0xF6, 0xE3, 0xE4, 0xED, 0xEA,
		0xB7, 0xB0, 0xB9, 0xBE, 0xAB, 0xAC, 0xA5, 0xA2, 0x8F, 0x88, 0x81, 0x86, 0x93, 0x94, 0x9D, 0x9A,
		0x27, 0x20, 0x29, 0x2E, 0x3B, 0x3C, 0x35, 0x32, 0x1F, 0x18, 0x11, 0x16, 0x03, 0x04, 0x0D, 0x0A,
		0x57, 0x50, 0x59, 0x5E, 0x4B, 0x4C, 0x45, 0x42, 0x6F, 0x68, 0x61, 0x66, 0x73, 0x74, 0x7D, 0x7A,
		0x89, 0x8E, 0x87, 0x80, 0x95, 0x92, 0x9B, 0x9C, 0xB1, 0xB6, 0xBF, 0xB8, 0xAD, 0xAA, 0xA3, 0xA4,
		0xF9, 0xFE, 0xF7, 0xF0, 0xE5, 0xE2, 0xEB, 0xEC, 0xC1, 0xC6, 0xCF, 0xC8, 0xDD, 0xDA, 0xD3, 0xD4,
		0x69, 0x6E, 0x67, 0x60, 0x75, 0x72, 0x7B, 0x7C, 0x51, 0x56, 0x5F, 0x58, 0x4D, 0x4A, 0x43, 0x44,
		0x19, 0x1E, 0x17, 0x10, 0x05, 0x02, 0x0B, 0x0C, 0x21, 0x26, 0x2F, 0x28, 0x3D, 0x3A, 0x33, 0x34,
		0x4E, 0x49, 0x40, 0x47, 0x52, 0x55, 0x5C, 0x5B, 0x76, 0x71, 0x78, 0x7F, 0x6A, 0x6D, 0x64, 0x63,
		0x3E, 0x39, 0x30, 0x37, 0x22, 0x25, 0x2C, 0x2B, 0x06, 0x01, 0x08, 0x0F, 0x1A, 0x1D, 0x14, 0x13,
		0xAE, 0xA9, 0xA0, 0xA7, 0xB2, 0xB5, 0xBC, 0xBB, 0x96, 0x91, 0x98, 0x9F, 0x8A, 0x8D, 0x84, 0x83,
		0xDE, 0xD9, 0xD0, 0xD7, 0xC2, 0xC5, 0xCC, 0xCB, 0xE6, 0xE1, 0xE8, 0xEF, 0xFA, 0xFD, 0xF4, 0xF3
	);
	protected static $crc16table = array(
		0x0000,	0xC0C1, 0xC181, 0x0140, 0xC301, 0x03C0, 0x0280, 0xC241,
		0xC601, 0x06C0, 0x0780, 0xC741, 0x0500, 0xC5C1, 0xC481, 0x0440,
		0xCC01, 0x0CC0, 0x0D80, 0xCD41, 0x0F00, 0xCFC1, 0xCE81, 0x0E40,
		0x0A00, 0xCAC1, 0xCB81, 0x0B40, 0xC901, 0x09C0, 0x0880, 0xC841,
		0xD801, 0x18C0, 0x1980, 0xD941, 0x1B00, 0xDBC1, 0xDA81, 0x1A40,
		0x1E00, 0xDEC1, 0xDF81, 0x1F40, 0xDD01, 0x1DC0, 0x1C80, 0xDC41,
		0x1400, 0xD4C1, 0xD581, 0x1540, 0xD701, 0x17C0, 0x1680, 0xD641,
		0xD201, 0x12C0, 0x1380, 0xD341, 0x1100, 0xD1C1, 0xD081, 0x1040,
		0xF001, 0x30C0, 0x3180, 0xF141, 0x3300, 0xF3C1, 0xF281, 0x3240,
		0x3600, 0xF6C1, 0xF781, 0x3740, 0xF501, 0x35C0, 0x3480, 0xF441,
		0x3C00, 0xFCC1, 0xFD81, 0x3D40, 0xFF01, 0x3FC0, 0x3E80, 0xFE41,
		0xFA01, 0x3AC0, 0x3B80, 0xFB41, 0x3900, 0xF9C1, 0xF881, 0x3840,
		0x2800, 0xE8C1, 0xE981, 0x2940, 0xEB01, 0x2BC0, 0x2A80, 0xEA41,
		0xEE01, 0x2EC0, 0x2F80, 0xEF41, 0x2D00, 0xEDC1, 0xEC81, 0x2C40,
		0xE401, 0x24C0, 0x2580, 0xE541, 0x2700, 0xE7C1, 0xE681, 0x2640,
		0x2200, 0xE2C1, 0xE381, 0x2340, 0xE101, 0x21C0, 0x2080, 0xE041,
		0xA001, 0x60C0, 0x6180, 0xA141, 0x6300, 0xA3C1, 0xA281, 0x6240,
		0x6600, 0xA6C1, 0xA781, 0x6740, 0xA501, 0x65C0, 0x6480, 0xA441,
		0x6C00, 0xACC1, 0xAD81, 0x6D40, 0xAF01, 0x6FC0, 0x6E80, 0xAE41,
		0xAA01, 0x6AC0, 0x6B80, 0xAB41, 0x6900, 0xA9C1, 0xA881, 0x6840,
		0x7800, 0xB8C1, 0xB981, 0x7940, 0xBB01, 0x7BC0, 0x7A80, 0xBA41,
		0xBE01, 0x7EC0, 0x7F80, 0xBF41, 0x7D00, 0xBDC1, 0xBC81, 0x7C40,
		0xB401, 0x74C0, 0x7580, 0xB541, 0x7700, 0xB7C1, 0xB681, 0x7640,
		0x7200, 0xB2C1, 0xB381, 0x7340, 0xB101, 0x71C0, 0x7080, 0xB041,
		0x5000, 0x90C1, 0x9181, 0x5140, 0x9301, 0x53C0, 0x5280, 0x9241,
		0x9601, 0x56C0, 0x5780, 0x9741, 0x5500, 0x95C1, 0x9481, 0x5440,
		0x9C01, 0x5CC0, 0x5D80, 0x9D41, 0x5F00, 0x9FC1, 0x9E81, 0x5E40,
		0x5A00, 0x9AC1, 0x9B81, 0x5B40, 0x9901, 0x59C0, 0x5880, 0x9841,
		0x8801, 0x48C0, 0x4980, 0x8941, 0x4B00, 0x8BC1, 0x8A81, 0x4A40,
		0x4E00, 0x8EC1, 0x8F81, 0x4F40, 0x8D01, 0x4DC0, 0x4C80, 0x8C41,
		0x4400, 0x84C1, 0x8581, 0x4540, 0x8701, 0x47C0, 0x4680, 0x8641,
		0x8201, 0x42C0, 0x4380, 0x8341, 0x4100, 0x81C1, 0x8081, 0x4040
	);
	protected static $crc32table = array(
		0x00000000, 0x77073096, 0xEE0E612C, 0x990951BA, 0x076DC419, 0x706AF48F, 0xE963A535, 0x9E6495A3,
		0x0EDB8832, 0x79DCB8A4, 0xE0D5E91E, 0x97D2D988, 0x09B64C2B, 0x7EB17CBD, 0xE7B82D07, 0x90BF1D91,
		0x1DB71064, 0x6AB020F2, 0xF3B97148, 0x84BE41DE, 0x1ADAD47D, 0x6DDDE4EB, 0xF4D4B551, 0x83D385C7,
		0x136C9856, 0x646BA8C0, 0xFD62F97A, 0x8A65C9EC, 0x14015C4F, 0x63066CD9, 0xFA0F3D63, 0x8D080DF5,
		0x3B6E20C8, 0x4C69105E, 0xD56041E4, 0xA2677172, 0x3C03E4D1, 0x4B04D447, 0xD20D85FD, 0xA50AB56B,
		0x35B5A8FA, 0x42B2986C, 0xDBBBC9D6, 0xACBCF940, 0x32D86CE3, 0x45DF5C75, 0xDCD60DCF, 0xABD13D59,
		0x26D930AC, 0x51DE003A, 0xC8D75180, 0xBFD06116, 0x21B4F4B5, 0x56B3C423, 0xCFBA9599, 0xB8BDA50F,
		0x2802B89E, 0x5F058808, 0xC60CD9B2, 0xB10BE924, 0x2F6F7C87, 0x58684C11, 0xC1611DAB, 0xB6662D3D,
		0x76DC4190, 0x01DB7106, 0x98D220BC, 0xEFD5102A, 0x71B18589, 0x06B6B51F, 0x9FBFE4A5, 0xE8B8D433,
		0x7807C9A2, 0x0F00F934, 0x9609A88E, 0xE10E9818, 0x7F6A0DBB, 0x086D3D2D, 0x91646C97, 0xE6635C01,
		0x6B6B51F4, 0x1C6C6162, 0x856530D8, 0xF262004E, 0x6C0695ED, 0x1B01A57B, 0x8208F4C1, 0xF50FC457,
		0x65B0D9C6, 0x12B7E950, 0x8BBEB8EA, 0xFCB9887C, 0x62DD1DDF, 0x15DA2D49, 0x8CD37CF3, 0xFBD44C65,
		0x4DB26158, 0x3AB551CE, 0xA3BC0074, 0xD4BB30E2, 0x4ADFA541, 0x3DD895D7, 0xA4D1C46D, 0xD3D6F4FB,
		0x4369E96A, 0x346ED9FC, 0xAD678846, 0xDA60B8D0, 0x44042D73, 0x33031DE5, 0xAA0A4C5F, 0xDD0D7CC9,
		0x5005713C, 0x270241AA, 0xBE0B1010, 0xC90C2086, 0x5768B525, 0x206F85B3, 0xB966D409, 0xCE61E49F,
		0x5EDEF90E, 0x29D9C998, 0xB0D09822, 0xC7D7A8B4, 0x59B33D17, 0x2EB40D81, 0xB7BD5C3B, 0xC0BA6CAD,
		0xEDB88320, 0x9ABFB3B6, 0x03B6E20C, 0x74B1D29A, 0xEAD54739, 0x9DD277AF, 0x04DB2615, 0x73DC1683,
		0xE3630B12, 0x94643B84, 0x0D6D6A3E, 0x7A6A5AA8, 0xE40ECF0B, 0x9309FF9D, 0x0A00AE27, 0x7D079EB1,
		0xF00F9344, 0x8708A3D2, 0x1E01F268, 0x6906C2FE, 0xF762575D, 0x806567CB, 0x196C3671, 0x6E6B06E7,
		0xFED41B76, 0x89D32BE0, 0x10DA7A5A, 0x67DD4ACC, 0xF9B9DF6F, 0x8EBEEFF9, 0x17B7BE43, 0x60B08ED5,
		0xD6D6A3E8, 0xA1D1937E, 0x38D8C2C4, 0x4FDFF252, 0xD1BB67F1, 0xA6BC5767, 0x3FB506DD, 0x48B2364B,
		0xD80D2BDA, 0xAF0A1B4C, 0x36034AF6, 0x41047A60, 0xDF60EFC3, 0xA867DF55, 0x316E8EEF, 0x4669BE79,
		0xCB61B38C, 0xBC66831A, 0x256FD2A0, 0x5268E236, 0xCC0C7795, 0xBB0B4703, 0x220216B9, 0x5505262F,
		0xC5BA3BBE, 0xB2BD0B28, 0x2BB45A92, 0x5CB36A04, 0xC2D7FFA7, 0xB5D0CF31, 0x2CD99E8B, 0x5BDEAE1D,
		0x9B64C2B0, 0xEC63F226, 0x756AA39C, 0x026D930A, 0x9C0906A9, 0xEB0E363F, 0x72076785, 0x05005713,
		0x95BF4A82, 0xE2B87A14, 0x7BB12BAE, 0x0CB61B38, 0x92D28E9B, 0xE5D5BE0D, 0x7CDCEFB7, 0x0BDBDF21,
		0x86D3D2D4, 0xF1D4E242, 0x68DDB3F8, 0x1FDA836E, 0x81BE16CD, 0xF6B9265B, 0x6FB077E1, 0x18B74777,
		0x88085AE6, 0xFF0F6A70, 0x66063BCA, 0x11010B5C, 0x8F659EFF, 0xF862AE69, 0x616BFFD3, 0x166CCF45,
		0xA00AE278, 0xD70DD2EE, 0x4E048354, 0x3903B3C2, 0xA7672661, 0xD06016F7, 0x4969474D, 0x3E6E77DB,
		0xAED16A4A, 0xD9D65ADC, 0x40DF0B66, 0x37D83BF0, 0xA9BCAE53, 0xDEBB9EC5, 0x47B2CF7F, 0x30B5FFE9,
		0xBDBDF21C, 0xCABAC28A, 0x53B39330, 0x24B4A3A6, 0xBAD03605, 0xCDD70693, 0x54DE5729, 0x23D967BF,
		0xB3667A2E, 0xC4614AB8, 0x5D681B02, 0x2A6F2B94, 0xB40BBE37, 0xC30C8EA1, 0x5A05DF1B, 0x2D02EF8D
	);
	protected static $crc32bzip2table = array(
		0x00000000, 0x04C11DB7, 0x09823B6E, 0x0D4326D9, 0x130476DC, 0x17C56B6B, 0x1A864DB2, 0x1E475005,
		0x2608EDB8, 0x22C9F00F, 0x2F8AD6D6, 0x2B4BCB61, 0x350C9B64, 0x31CD86D3, 0x3C8EA00A, 0x384FBDBD,
		0x4C11DB70, 0x48D0C6C7, 0x4593E01E, 0x4152FDA9, 0x5F15ADAC, 0x5BD4B01B, 0x569796C2, 0x52568B75,
		0x6A1936C8, 0x6ED82B7F, 0x639B0DA6, 0x675A1011, 0x791D4014, 0x7DDC5DA3, 0x709F7B7A, 0x745E66CD,
		0x9823B6E0, 0x9CE2AB57, 0x91A18D8E, 0x95609039, 0x8B27C03C, 0x8FE6DD8B, 0x82A5FB52, 0x8664E6E5,
		0xBE2B5B58, 0xBAEA46EF, 0xB7A96036, 0xB3687D81, 0xAD2F2D84, 0xA9EE3033, 0xA4AD16EA, 0xA06C0B5D,
		0xD4326D90, 0xD0F37027, 0xDDB056FE, 0xD9714B49, 0xC7361B4C, 0xC3F706FB, 0xCEB42022, 0xCA753D95,
		0xF23A8028, 0xF6FB9D9F, 0xFBB8BB46, 0xFF79A6F1, 0xE13EF6F4, 0xE5FFEB43, 0xE8BCCD9A, 0xEC7DD02D,
		0x34867077, 0x30476DC0, 0x3D044B19, 0x39C556AE, 0x278206AB, 0x23431B1C, 0x2E003DC5, 0x2AC12072,
		0x128E9DCF, 0x164F8078, 0x1B0CA6A1, 0x1FCDBB16, 0x018AEB13, 0x054BF6A4, 0x0808D07D, 0x0CC9CDCA,
		0x7897AB07, 0x7C56B6B0, 0x71159069, 0x75D48DDE, 0x6B93DDDB, 0x6F52C06C, 0x6211E6B5, 0x66D0FB02,
		0x5E9F46BF, 0x5A5E5B08, 0x571D7DD1, 0x53DC6066, 0x4D9B3063, 0x495A2DD4, 0x44190B0D, 0x40D816BA,
		0xACA5C697, 0xA864DB20, 0xA527FDF9, 0xA1E6E04E, 0xBFA1B04B, 0xBB60ADFC, 0xB6238B25, 0xB2E29692,
		0x8AAD2B2F, 0x8E6C3698, 0x832F1041, 0x87EE0DF6, 0x99A95DF3, 0x9D684044, 0x902B669D, 0x94EA7B2A,
		0xE0B41DE7, 0xE4750050, 0xE9362689, 0xEDF73B3E, 0xF3B06B3B, 0xF771768C, 0xFA325055, 0xFEF34DE2,
		0xC6BCF05F, 0xC27DEDE8, 0xCF3ECB31, 0xCBFFD686, 0xD5B88683, 0xD1799B34, 0xDC3ABDED, 0xD8FBA05A,
		0x690CE0EE, 0x6DCDFD59, 0x608EDB80, 0x644FC637, 0x7A089632, 0x7EC98B85, 0x738AAD5C, 0x774BB0EB,
		0x4F040D56, 0x4BC510E1, 0x46863638, 0x42472B8F, 0x5C007B8A, 0x58C1663D, 0x558240E4, 0x51435D53,
		0x251D3B9E, 0x21DC2629, 0x2C9F00F0, 0x285E1D47, 0x36194D42, 0x32D850F5, 0x3F9B762C, 0x3B5A6B9B,
		0x0315D626, 0x07D4CB91, 0x0A97ED48, 0x0E56F0FF, 0x1011A0FA, 0x14D0BD4D, 0x19939B94, 0x1D528623,
		0xF12F560E, 0xF5EE4BB9, 0xF8AD6D60, 0xFC6C70D7, 0xE22B20D2, 0xE6EA3D65, 0xEBA91BBC, 0xEF68060B,
		0xD727BBB6, 0xD3E6A601, 0xDEA580D8, 0xDA649D6F, 0xC423CD6A, 0xC0E2D0DD, 0xCDA1F604, 0xC960EBB3,
		0xBD3E8D7E, 0xB9FF90C9, 0xB4BCB610, 0xB07DABA7, 0xAE3AFBA2, 0xAAFBE615, 0xA7B8C0CC, 0xA379DD7B,
		0x9B3660C6, 0x9FF77D71, 0x92B45BA8, 0x9675461F, 0x8832161A, 0x8CF30BAD, 0x81B02D74, 0x857130C3,
		0x5D8A9099, 0x594B8D2E, 0x5408ABF7, 0x50C9B640, 0x4E8EE645, 0x4A4FFBF2, 0x470CDD2B, 0x43CDC09C,
		0x7B827D21, 0x7F436096, 0x7200464F, 0x76C15BF8, 0x68860BFD, 0x6C47164A, 0x61043093, 0x65C52D24,
		0x119B4BE9, 0x155A565E, 0x18197087, 0x1CD86D30, 0x029F3D35, 0x065E2082, 0x0B1D065B, 0x0FDC1BEC,
		0x3793A651, 0x3352BBE6, 0x3E119D3F, 0x3AD08088, 0x2497D08D, 0x2056CD3A, 0x2D15EBE3, 0x29D4F654,
		0xC5A92679, 0xC1683BCE, 0xCC2B1D17, 0xC8EA00A0, 0xD6AD50A5, 0xD26C4D12, 0xDF2F6BCB, 0xDBEE767C,
		0xE3A1CBC1, 0xE760D676, 0xEA23F0AF, 0xEEE2ED18, 0xF0A5BD1D, 0xF464A0AA, 0xF9278673, 0xFDE69BC4,
		0x89B8FD09, 0x8D79E0BE, 0x803AC667, 0x84FBDBD0, 0x9ABC8BD5, 0x9E7D9662, 0x933EB0BB, 0x97FFAD0C,
		0xAFB010B1, 0xAB710D06, 0xA6322BDF, 0xA2F33668, 0xBCB4666D, 0xB8757BDA, 0xB5365D03, 0xB1F740B4
	);
	protected static $verhoeffmul = array(
		array(0,1,2,3,4,5,6,7,8,9),
		array(1,2,3,4,0,6,7,8,9,5),
		array(2,3,4,0,1,7,8,9,5,6),
		array(3,4,0,1,2,8,9,5,6,7),
		array(4,0,1,2,3,9,5,6,7,8),
		array(5,9,8,7,6,0,4,3,2,1),
		array(6,5,9,8,7,1,0,4,3,2),
		array(7,6,5,9,8,2,1,0,4,3),
		array(8,7,6,5,9,3,2,1,0,4),
		array(9,8,7,6,5,4,3,2,1,0),
	);
	protected static $verhoeffper = array(
		array(0,1,2,3,4,5,6,7,8,9),
		array(1,5,7,6,2,8,3,0,9,4),
		array(5,8,0,3,7,9,6,1,4,2),
		array(8,9,1,6,0,4,3,5,2,7),
		array(9,4,5,3,1,2,6,8,7,0),
		array(4,2,8,6,5,7,3,9,0,1),
		array(2,7,9,3,8,0,6,4,1,5),
		array(7,0,4,6,9,1,3,2,5,8),
	);
	protected static $verhoeffinv = array(0,4,3,2,1,5,6,7,8,9);
	protected static $dammmatrix = array(
		array(0, 3, 1, 7, 5, 9, 8, 6, 4, 2),
		array(7, 0, 9, 2, 1, 5, 4, 8, 6, 3),
		array(4, 2, 0, 6, 8, 7, 1, 3, 5, 9),
		array(1, 7, 5, 0, 9, 8, 3, 4, 2, 6),
		array(6, 1, 2, 3, 0, 4, 5, 9, 7, 8),
		array(3, 6, 7, 4, 2, 0, 9, 5, 8, 1),
		array(5, 8, 6, 9, 7, 2, 0, 1, 3, 4),
		array(8, 9, 4, 5, 3, 6, 2, 0, 1, 7),
		array(9, 4, 3, 8, 6, 1, 7, 2, 0, 5),
		array(2, 5, 8, 1, 4, 3, 6, 7, 9, 0),
	);
	protected static $pearsonT = array(
		0x62, 0x06, 0x55, 0x96, 0x24, 0x17, 0x70, 0xa4, 0x87, 0xcf, 0xa9, 0x05, 0x1a, 0x40, 0xa5, 0xdb,
		0x3d, 0x14, 0x44, 0x59, 0x82, 0x3f, 0x34, 0x66, 0x18, 0xe5, 0x84, 0xf5, 0x50, 0xd8, 0xc3, 0x73,
		0x5a, 0xa8, 0x9c, 0xcb, 0xb1, 0x78, 0x02, 0xbe, 0xbc, 0x07, 0x64, 0xb9, 0xae, 0xf3, 0xa2, 0x0a,
		0xed, 0x12, 0xfd, 0xe1, 0x08, 0xd0, 0xac, 0xf4, 0xff, 0x7e, 0x65, 0x4f, 0x91, 0xeb, 0xe4, 0x79,
		0x7b, 0xfb, 0x43, 0xfa, 0xa1, 0x00, 0x6b, 0x61, 0xf1, 0x6f, 0xb5, 0x52, 0xf9, 0x21, 0x45, 0x37,
		0x3b, 0x99, 0x1d, 0x09, 0xd5, 0xa7, 0x54, 0x5d, 0x1e, 0x2e, 0x5e, 0x4b, 0x97, 0x72, 0x49, 0xde,
		0xc5, 0x60, 0xd2, 0x2d, 0x10, 0xe3, 0xf8, 0xca, 0x33, 0x98, 0xfc, 0x7d, 0x51, 0xce, 0xd7, 0xba,
		0x27, 0x9e, 0xb2, 0xbb, 0x83, 0x88, 0x01, 0x31, 0x32, 0x11, 0x8d, 0x5b, 0x2f, 0x81, 0x3c, 0x63,
		0x9a, 0x23, 0x56, 0xab, 0x69, 0x22, 0x26, 0xc8, 0x93, 0x3a, 0x4d, 0x76, 0xad, 0xf6, 0x4c, 0xfe,
		0x85, 0xe8, 0xc4, 0x90, 0xc6, 0x7c, 0x35, 0x04, 0x6c, 0x4a, 0xdf, 0xea, 0x86, 0xe6, 0x9d, 0x8b,
		0xbd, 0xcd, 0xc7, 0x80, 0xb0, 0x13, 0xd3, 0xec, 0x7f, 0xc0, 0xe7, 0x46, 0xe9, 0x58, 0x92, 0x2c,
		0xb7, 0xc9, 0x16, 0x53, 0x0d, 0xd6, 0x74, 0x6d, 0x9f, 0x20, 0x5f, 0xe2, 0x8c, 0xdc, 0x39, 0x0c,
		0xdd, 0x1f, 0xd1, 0xb6, 0x8f, 0x5c, 0x95, 0xb8, 0x94, 0x3e, 0x71, 0x41, 0x25, 0x1b, 0x6a, 0xa6,
		0x03, 0x0e, 0xcc, 0x48, 0x15, 0x29, 0x38, 0x42, 0x1c, 0xc1, 0x28, 0xd9, 0x19, 0x36, 0xb3, 0x75,
		0xee, 0x57, 0xf0, 0x9b, 0xb4, 0xaa, 0xf2, 0xd4, 0xbf, 0xa3, 0x4e, 0xda, 0x89, 0xc2, 0xaf, 0x6e,
		0x2b, 0x77, 0xe0, 0x47, 0x7a, 0x8e, 0x2a, 0xa0, 0x68, 0x30, 0xf7, 0x67, 0x0f, 0x0b, 0x8a, 0xef
	);
	protected static $keccakrndc = array(
		array(0x00000000, 0x00000001), array(0x00000000, 0x00008082), array(0x80000000, 0x0000808a), array(0x80000000, 0x80008000),
		array(0x00000000, 0x0000808b), array(0x00000000, 0x80000001), array(0x80000000, 0x80008081), array(0x80000000, 0x00008009),
		array(0x00000000, 0x0000008a), array(0x00000000, 0x00000088), array(0x00000000, 0x80008009), array(0x00000000, 0x8000000a),
		array(0x00000000, 0x8000808b), array(0x80000000, 0x0000008b), array(0x80000000, 0x00008089), array(0x80000000, 0x00008003),
		array(0x80000000, 0x00008002), array(0x80000000, 0x00000080), array(0x00000000, 0x0000800a), array(0x80000000, 0x8000000a),
		array(0x80000000, 0x80008081), array(0x80000000, 0x00008080), array(0x00000000, 0x80000001), array(0x80000000, 0x80008008)
	);
	protected static $md2s = array(
		41,  46,  67,  201, 162, 216, 124, 1,   61,  54,  84,  161, 236, 240, 6,
		19,  98,  167, 5,   243, 192, 199, 115, 140, 152, 147, 43,  217, 188,
		76,  130, 202, 30,  155, 87,  60,  253, 212, 224, 22,  103, 66,  111, 24,
		138, 23,  229, 18,  190, 78,  196, 214, 218, 158, 222, 73,  160, 251,
		245, 142, 187, 47,  238, 122, 169, 104, 121, 145, 21,  178, 7,   63,
		148, 194, 16,  137, 11,  34,  95,  33,  128, 127, 93,  154, 90,  144, 50,
		39,  53,  62,  204, 231, 191, 247, 151, 3,   255, 25,  48,  179, 72,  165,
		181, 209, 215, 94,  146, 42,  172, 86,  170, 198, 79,  184, 56,  210,
		150, 164, 125, 182, 118, 252, 107, 226, 156, 116, 4,   241, 69,  157,
		112, 89,  100, 113, 135, 32,  134, 91,  207, 101, 230, 45,  168, 2,   27,
		96,  37,  173, 174, 176, 185, 246, 28,  70,  97,  105, 52,  64,  126, 15,
		85,  71,  163, 35,  221, 81,  175, 58,  195, 92,  249, 206, 186, 197,
		234, 38,  44,  83,  13,  110, 133, 40,  132, 9,   211, 223, 205, 244, 65,
		129, 77,  82,  106, 220, 55,  200, 108, 193, 171, 250, 36,  225, 123,
		8,   12,  189, 177, 74,  120, 136, 149, 139, 227, 99,  232, 109, 233,
		203, 213, 254, 59,  0,   29,  57,  242, 239, 183, 14,  102, 88,  208, 228,
		166, 119, 114, 248, 235, 117, 75,  10,  49,  68,  80,  180, 143, 237,
		31,  26,  219, 153, 141, 51,  159, 17,  131, 20
	);

	private static function keccakf64(&$st, $rounds) {
		$keccakf_rotc = array(1, 3, 6, 10, 15, 21, 28, 36, 45, 55, 2, 14, 27, 41, 56, 8, 25, 43, 62, 18, 39, 61, 20, 44);
		$keccakf_piln = array(10, 7, 11, 17, 18, 3, 5, 16, 8, 21, 24, 4, 15, 23, 19, 13, 12,2, 20, 14, 22, 9, 6, 1);
		$keccakf_rndc = self::$keccakrndc;
		$bc = array();
		for($round = 0; $round < $rounds; ++$round) {
			for($i = 0; $i < 5; ++$i)
				$bc[$i] = array(
					$st[$i][0] ^ $st[$i + 5][0] ^ $st[$i + 10][0] ^ $st[$i + 15][0] ^ $st[$i + 20][0],
					$st[$i][1] ^ $st[$i + 5][1] ^ $st[$i + 10][1] ^ $st[$i + 15][1] ^ $st[$i + 20][1]
				);
			for($i = 0; $i < 5; ++$i) {
				$t = array(
					$bc[($i + 4) % 5][0] ^ (($bc[($i + 1) % 5][0] << 1) | ($bc[($i + 1) % 5][1] >> 31)) & (0xffffffff),
					$bc[($i + 4) % 5][1] ^ (($bc[($i + 1) % 5][1] << 1) | ($bc[($i + 1) % 5][0] >> 31)) & (0xffffffff)
				);
				for($j = 0; $j < 25; $j += 5)
					$st[$j + $i] = array(
						$st[$j + $i][0] ^ $t[0],
						$st[$j + $i][1] ^ $t[1]
					);
			}
			$t = $st[1];
			for($i = 0; $i < 24; ++$i) {
				$j = $keccakf_piln[$i];
				$bc[0] = $st[$j];
				$n = $keccakf_rotc[$i];
				$hi = $t[0];
				$lo = $t[1];
				if($n >= 32) {
					$n -= 32;
					$hi = $t[1];
					$lo = $t[0];
				}
				$st[$j] = array(
					(($hi << $n) | ($lo >> (32 - $n))) & (0xffffffff),
					(($lo << $n) | ($hi >> (32 - $n))) & (0xffffffff)
				);
				$t = $bc[0];
			}
			for($j = 0; $j < 25; $j += 5) {
				for($i = 0; $i < 5; ++$i)
					$bc[$i] = $st[$j + $i];
				for($i = 0; $i < 5; ++$i)
					$st[$j + $i] = array(
						$st[$j + $i][0] ^ ~$bc[($i + 1) % 5][0] & $bc[($i + 2) % 5][0],
						$st[$j + $i][1] ^ ~$bc[($i + 1) % 5][1] & $bc[($i + 2) % 5][1]
					);
			}
			$st[0] = array(
				$st[0][0] ^ $keccakf_rndc[$round][0],
				$st[0][1] ^ $keccakf_rndc[$round][1]
			);
		}
	}
	private static function keccak64($in_raw, $capacity, $outputlength, $suffix, $raw_output) {
		$capacity /= 8;
		$inlen = strlen($in_raw);
		$rsiz = 200 - 2 * $capacity;
		$rsizw = $rsiz / 8;
		$st = array();
		for($i = 0; $i < 25; ++$i)
			$st[] = array(0, 0);
		for($in_t = 0; $inlen >= $rsiz; $inlen -= $rsiz, $in_t += $rsiz) {
			for($i = 0; $i < $rsizw; ++$i) {
				$t = unpack('V*', substr($in_raw, $i * 8 + $in_t, 8));
				$st[$i] = array(
					$st[$i][0] ^ $t[2],
					$st[$i][1] ^ $t[1]
				);
			}
			self::keccakf64($st, 24);
		}
		$temp = substr($in_raw, $in_t, $inlen);
		$temp = str_pad($temp, $rsiz, "\0", STR_PAD_RIGHT);
		$temp[$inlen] = chr($suffix);
		$temp[$rsiz - 1] = chr(ord($temp[$rsiz - 1]) | 0x80);
		for($i = 0; $i < $rsizw; ++$i) {
			$t = unpack('V*', substr($temp, $i * 8, 8));
			$st[$i] = array(
				$st[$i][0] ^ $t[2],
				$st[$i][1] ^ $t[1]
			);
		}
		self::keccakf64($st, 24);
		$out = '';
		for($i = 0; $i < 25; ++$i)
			$out .= $t = pack('V*', $st[$i][1], $st[$i][0]);
		$r = substr($out, 0, $outputlength / 8);
		return $raw_output ? $r : bin2hex($r);
	}
	private static function keccakf32(&$st, $rounds) {
		$keccakf_rotc = array(1, 3, 6, 10, 15, 21, 28, 36, 45, 55, 2, 14, 27, 41, 56, 8, 25, 43, 62, 18, 39, 61, 20, 44);
		$keccakf_piln = array(10, 7, 11, 17, 18, 3, 5, 16, 8, 21, 24, 4, 15, 23, 19, 13, 12,2, 20, 14, 22, 9, 6, 1);
		$keccakf_rndc = array(
			array(0x0000, 0x0000, 0x0000, 0x0001), array(0x0000, 0x0000, 0x0000, 0x8082), array(0x8000, 0x0000, 0x0000, 0x0808a), array(0x8000, 0x0000, 0x8000, 0x8000),
			array(0x0000, 0x0000, 0x0000, 0x808b), array(0x0000, 0x0000, 0x8000, 0x0001), array(0x8000, 0x0000, 0x8000, 0x08081), array(0x8000, 0x0000, 0x0000, 0x8009),
			array(0x0000, 0x0000, 0x0000, 0x008a), array(0x0000, 0x0000, 0x0000, 0x0088), array(0x0000, 0x0000, 0x8000, 0x08009), array(0x0000, 0x0000, 0x8000, 0x000a),
			array(0x0000, 0x0000, 0x8000, 0x808b), array(0x8000, 0x0000, 0x0000, 0x008b), array(0x8000, 0x0000, 0x0000, 0x08089), array(0x8000, 0x0000, 0x0000, 0x8003),
			array(0x8000, 0x0000, 0x0000, 0x8002), array(0x8000, 0x0000, 0x0000, 0x0080), array(0x0000, 0x0000, 0x0000, 0x0800a), array(0x8000, 0x0000, 0x8000, 0x000a),
			array(0x8000, 0x0000, 0x8000, 0x8081), array(0x8000, 0x0000, 0x0000, 0x8080), array(0x0000, 0x0000, 0x8000, 0x00001), array(0x8000, 0x0000, 0x8000, 0x8008)
		);
		$bc = array();
		for($round = 0; $round < $rounds; ++$round) {
			for($i = 0; $i < 5; $i++)
				$bc[$i] = array(
					$st[$i][0] ^ $st[$i + 5][0] ^ $st[$i + 10][0] ^ $st[$i + 15][0] ^ $st[$i + 20][0],
					$st[$i][1] ^ $st[$i + 5][1] ^ $st[$i + 10][1] ^ $st[$i + 15][1] ^ $st[$i + 20][1],
					$st[$i][2] ^ $st[$i + 5][2] ^ $st[$i + 10][2] ^ $st[$i + 15][2] ^ $st[$i + 20][2],
					$st[$i][3] ^ $st[$i + 5][3] ^ $st[$i + 10][3] ^ $st[$i + 15][3] ^ $st[$i + 20][3]
				);
			for($i = 0; $i < 5; ++$i) {
				$t = array(
					$bc[($i + 4) % 5][0] ^ ((($bc[($i + 1) % 5][0] << 1) | ($bc[($i + 1) % 5][1] >> 15)) & (0xffff)),
					$bc[($i + 4) % 5][1] ^ ((($bc[($i + 1) % 5][1] << 1) | ($bc[($i + 1) % 5][2] >> 15)) & (0xffff)),
					$bc[($i + 4) % 5][2] ^ ((($bc[($i + 1) % 5][2] << 1) | ($bc[($i + 1) % 5][3] >> 15)) & (0xffff)),
					$bc[($i + 4) % 5][3] ^ ((($bc[($i + 1) % 5][3] << 1) | ($bc[($i + 1) % 5][0] >> 15)) & (0xffff))
				);
				for($j = 0; $j < 25; $j += 5)
					$st[$j + $i] = array(
						$st[$j + $i][0] ^ $t[0],
						$st[$j + $i][1] ^ $t[1],
						$st[$j + $i][2] ^ $t[2],
						$st[$j + $i][3] ^ $t[3]
					);
			}
			$t = $st[1];
			for($i = 0; $i < 24; ++$i) {
				$j = $keccakf_piln[$i];
				$bc[0] = $st[$j];
				$n = $keccakf_rotc[$i] >> 4;
				$m = $keccakf_rotc[$i] % 16;
				$st[$j] = array(
					((($t[(0+$n) %4] << $m) | ($t[(1+$n) %4] >> (16-$m))) & (0xffff)),
					((($t[(1+$n) %4] << $m) | ($t[(2+$n) %4] >> (16-$m))) & (0xffff)),
					((($t[(2+$n) %4] << $m) | ($t[(3+$n) %4] >> (16-$m))) & (0xffff)),
					((($t[(3+$n) %4] << $m) | ($t[(0+$n) %4] >> (16-$m))) & (0xffff))
				);
				$t = $bc[0];
			}
			for($j = 0; $j < 25; $j += 5) {
				for($i = 0; $i < 5; ++$i)
					$bc[$i] = $st[$j + $i];
				for($i = 0; $i < 5; ++$i)
					$st[$j + $i] = array(
						$st[$j + $i][0] ^ ~$bc[($i + 1) % 5][0] & $bc[($i + 2) % 5][0],
						$st[$j + $i][1] ^ ~$bc[($i + 1) % 5][1] & $bc[($i + 2) % 5][1],
						$st[$j + $i][2] ^ ~$bc[($i + 1) % 5][2] & $bc[($i + 2) % 5][2],
						$st[$j + $i][3] ^ ~$bc[($i + 1) % 5][3] & $bc[($i + 2) % 5][3]
					);
			}
			$st[0] = array(
				$st[0][0] ^ $keccakf_rndc[$round][0],
				$st[0][1] ^ $keccakf_rndc[$round][1],
				$st[0][2] ^ $keccakf_rndc[$round][2],
				$st[0][3] ^ $keccakf_rndc[$round][3]
			);
		}
	}
	private static function keccak32($in_raw, $capacity, $outputlength, $suffix, $raw_output) {
		$capacity /= 8;
		$inlen = strlen($in_raw);
		$rsiz = 200 - 2 * $capacity;
		$rsizw = $rsiz / 8;
		$st = array();
		for($i = 0; $i < 25; ++$i)
			$st[] = array(0, 0, 0, 0);
		for($in_t = 0; $inlen >= $rsiz; $inlen -= $rsiz, $in_t += $rsiz) {
			for($i = 0; $i < $rsizw; ++$i) {
				$t = unpack('v*', substr($in_raw, $i * 8 + $in_t, 8));
				$st[$i] = array(
					$st[$i][0] ^ $t[4],
					$st[$i][1] ^ $t[3],
					$st[$i][2] ^ $t[2],
					$st[$i][3] ^ $t[1]
				);
			}
			self::keccakf32($st, 24);
		}
		$temp = substr($in_raw, $in_t, $inlen);
		$temp = str_pad($temp, $rsiz, "\0", STR_PAD_RIGHT);
		$temp[$inlen] = chr($suffix);
		$temp[$rsiz - 1] = chr((int) $temp[$rsiz - 1] | 0x80);
		for($i = 0; $i < $rsizw; ++$i) {
			$t = unpack('v*', substr($temp, $i * 8, 8));
			$st[$i] = array(
				$st[$i][0] ^ $t[4],
				$st[$i][1] ^ $t[3],
				$st[$i][2] ^ $t[2],
				$st[$i][3] ^ $t[1]
			);
		}
		self::keccakf32($st, 24);
		$out = '';
		for($i = 0; $i < 25; $i++)
			$out .= $t = pack('v*', $st[$i][3],$st[$i][2], $st[$i][1], $st[$i][0]);
		$r = substr($out, 0, $outputlength / 8);
		return $raw_output ? $r: bin2hex($r);
	}
	public static function keccak($in_raw, $capacity, $outputlength, $suffix, $raw){
		return PHP_INT_SIZE === 8
			? self::keccak64($in_raw, $capacity, $outputlength, $suffix, $raw)
			: self::keccak32($in_raw, $capacity, $outputlength, $suffix, $raw);
	}
	private static function sha3_pad($padLength, $padType){
		switch($padType){
			case 3:
				$temp = "\x1F" . str_repeat("\0", $padLength - 1);
				$temp[$padLength - 1] = $temp[$padLength - 1] | "\x80";
				return $temp;
			default:
				return $padLength == 1 ? "\x86" : "\x06" . str_repeat("\0", $padLength - 2) . "\x80";
		}
	}
	private static function sha3_32($p, $c, $r, $d, $padType){
		$block_size = $r >> 3;
		$padLength = $block_size - (strlen($p) % $block_size);
		$num_ints = $block_size >> 2;
		$p.= self::sha3_pad($padLength, $padType);
		$n = strlen($p) / $r;
		$s = array(
			array(array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0)),
			array(array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0)),
			array(array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0)),
			array(array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0)),
			array(array(0, 0), array(0, 0), array(0, 0), array(0, 0), array(0, 0))
		);
		$p = str_split($p, $block_size);
		foreach($p as $pi) {
			$pi = unpack('V*', $pi);
			$x = $y = 0;
			for($i = 1; $i <= $num_ints; $i += 2) {
				$s[$x][$y][0]^= $pi[$i + 1];
				$s[$x][$y][1]^= $pi[$i];
				if(++$y == 5) {
					$y = 0;
					++$x;
				}
			}
			self::sha3proc32($s);
		}
		$z = '';
		$i = $j = 0;
		while(strlen($z) < $d) {
			$z.= pack('V2', $s[$i][$j][1], $s[$i][$j++][0]);
			if($j == 5) {
				$j = 0;
				++$i;
				if($i == 5) {
					$i = 0;
					self::sha3proc32($s);
				}
			}
		}
		return $z;
	}
	private static function sha3proc32(&$s){
		$ro = array(
			array( 0,  1, 62, 28, 27),
			array(36, 44,  6, 55, 20),
			array( 3, 10, 43, 25, 39),
			array(41, 45, 15, 21,  8),
			array(18,  2, 61, 56, 14)
		);
		$rc = array(
			array(0, 1),
			array(0, 32898),
			array(-2147483648, 32906),
			array(-2147483648, -2147450880),
			array(0, 32907),
			array(0, -2147483647),
			array(-2147483648, -2147450751),
			array(-2147483648, 32777),
			array(0, 138),
			array(0, 136),
			array(0, -2147450871),
			array(0, -2147483638),
			array(0, -2147450741),
			array(-2147483648, 139),
			array(-2147483648, 32905),
			array(-2147483648, 32771),
			array(-2147483648, 32770),
			array(-2147483648, 128),
			array(0, 32778),
			array(-2147483648, -2147483638),
			array(-2147483648, -2147450751),
			array(-2147483648, 32896),
			array(0, -2147483647),
			array(-2147483648, -2147450872)
		);
		for($round = 0; $round < 24; ++$round) {
			$parity = $rotated = array();
			for($i = 0; $i < 5; $i++) {
				$parity[] = array(
					$s[0][$i][0] ^ $s[1][$i][0] ^ $s[2][$i][0] ^ $s[3][$i][0] ^ $s[4][$i][0],
					$s[0][$i][1] ^ $s[1][$i][1] ^ $s[2][$i][1] ^ $s[3][$i][1] ^ $s[4][$i][1]
				);
				$rotated[] = Math::rl32($parity[$i], 1);
			}
			$temp = array(
				array($parity[4][0] ^ $rotated[1][0], $parity[4][1] ^ $rotated[1][1]),
				array($parity[0][0] ^ $rotated[2][0], $parity[0][1] ^ $rotated[2][1]),
				array($parity[1][0] ^ $rotated[3][0], $parity[1][1] ^ $rotated[3][1]),
				array($parity[2][0] ^ $rotated[4][0], $parity[2][1] ^ $rotated[4][1]),
				array($parity[3][0] ^ $rotated[0][0], $parity[3][1] ^ $rotated[0][1])
			);
			for($i = 0; $i < 5; ++$i)
				for($j = 0; $j < 5; ++$j) {
					$s[$i][$j][0]^= $temp[$j][0];
					$s[$i][$j][1]^= $temp[$j][1];
				}
			$st = $s;
			for($i = 0; $i < 5; ++$i)
				for($j = 0; $j < 5; ++$j)
					$st[(2 * $i + 3 * $j) % 5][$j] = Math::rl32($s[$j][$i], $ro[$j][$i]);
			for($i = 0; $i < 5; ++$i) {
				$s[$i][0] = array(
					$st[$i][0][0] ^ (~$st[$i][1][0] & $st[$i][2][0]),
					$st[$i][0][1] ^ (~$st[$i][1][1] & $st[$i][2][1])
				);
				$s[$i][1] = array(
					$st[$i][1][0] ^ (~$st[$i][2][0] & $st[$i][3][0]),
					$st[$i][1][1] ^ (~$st[$i][2][1] & $st[$i][3][1])
				);
				$s[$i][2] = array(
					$st[$i][2][0] ^ (~$st[$i][3][0] & $st[$i][4][0]),
					$st[$i][2][1] ^ (~$st[$i][3][1] & $st[$i][4][1])
				);
				$s[$i][3] = array(
					$st[$i][3][0] ^ (~$st[$i][4][0] & $st[$i][0][0]),
					$st[$i][3][1] ^ (~$st[$i][4][1] & $st[$i][0][1])
				);
				$s[$i][4] = array(
					$st[$i][4][0] ^ (~$st[$i][0][0] & $st[$i][1][0]),
					$st[$i][4][1] ^ (~$st[$i][0][1] & $st[$i][1][1])
				);
			}
			$s[0][0][0]^= $rc[$round][0];
			$s[0][0][1]^= $rc[$round][1];
		}
	}
	private static function sha3_64($p, $c, $r, $d, $padType){
		$block_size = $r >> 3;
		$padLength = $block_size - (strlen($p) % $block_size);
		$num_ints = $block_size >> 2;
		$p.= self::sha3_pad($padLength, $padType);
		$n = strlen($p) / $r;
		$s = array(
			array(0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0),
			array(0, 0, 0, 0, 0)
		);
		$p = str_split($p, $block_size);
		foreach($p as $pi) {
			$pi = unpack('P*', $pi);
			$x = $y = 0;
			foreach($pi as $subpi) {
				$s[$x][$y++]^= $subpi;
				if($y == 5) {
					$y = 0;
					++$x;
				}
			}
			self::sha3proc64($s);
		}
		$z = '';
		$i = $j = 0;
		while(strlen($z) < $d) {
			$z.= pack('P', $s[$i][$j++]);
			if($j == 5) {
				$j = 0;
				++$i;
				if($i == 5) {
					$i = 0;
					self::sha3proc64($s);
				}
			}
		}
		return $z;
	}
	private static function sha3proc64(&$s){
		$ro = array(
			array( 0,  1, 62, 28, 27),
			array(36, 44,  6, 55, 20),
			array( 3, 10, 43, 25, 39),
			array(41, 45, 15, 21,  8),
			array(18,  2, 61, 56, 14)
		);
		$rc = array(
			1,
			32898,
			-9223372036854742902,
			-9223372034707259392,
			32907,
			2147483649,
			-9223372034707259263,
			-9223372036854743031,
			138,
			136,
			2147516425,
			2147483658,
			2147516555,
			-9223372036854775669,
			-9223372036854742903,
			-9223372036854743037,
			-9223372036854743038,
			-9223372036854775680,
			32778,
			-9223372034707292150,
			-9223372034707259263,
			-9223372036854742912,
			2147483649,
			-9223372034707259384
		);
		for($round = 0; $round < 24; ++$round) {
			$parity = array();
			for($i = 0; $i < 5; ++$i)
				$parity[] = $s[0][$i] ^ $s[1][$i] ^ $s[2][$i] ^ $s[3][$i] ^ $s[4][$i];
			$tmp = array(
				$parity[4] ^ Math::rl64($parity[1], 1),
				$parity[0] ^ Math::rl64($parity[2], 1),
				$parity[1] ^ Math::rl64($parity[3], 1),
				$parity[2] ^ Math::rl64($parity[4], 1),
				$parity[3] ^ Math::rl64($parity[0], 1)
			);
			for($i = 0; $i < 5; ++$i)
				for($j = 0; $j < 5; ++$j)
					$s[$i][$j]^= $tmp[$j];
			$st = $s;
			for($i = 0; $i < 5; ++$i)
				for($j = 0; $j < 5; ++$j)
					$st[(2 * $i + 3 * $j) % 5][$j] = Math::rl64($s[$j][$i], $ro[$j][$i]);
			for($i = 0; $i < 5; ++$i)
				$s[$i] = array(
					$st[$i][0] ^ (~$st[$i][1] & $st[$i][2]),
					$st[$i][1] ^ (~$st[$i][2] & $st[$i][3]),
					$st[$i][2] ^ (~$st[$i][3] & $st[$i][4]),
					$st[$i][3] ^ (~$st[$i][4] & $st[$i][0]),
					$st[$i][4] ^ (~$st[$i][0] & $st[$i][1])
				);
			$s[0][0]^= $rc[$round];
		}
	}
	private static function sha3($p, $c, $r, $d, $padType, $raw){
		return PHP_INT_SIZE === 8
			? ($raw === true ? self::sha3_64($p, $c, $r, $d, $padType) : bin2hex(self::sha3_64($p, $c, $r, $d, $padType)))
			: ($raw === true ? self::sha3_32($p, $c, $r, $d, $padType) : bin2hex(self::sha3_32($p, $c, $r, $d, $padType)));
	}
	public static function crc32($data){
		if(function_exists('crc32'))return crc32($data);
		$c = 0xffffffff;
		for($i = 0; isset($data[$i]); ++$i)
			$c = self::$crc32table[$c ^ ord($data[$i])] ^ (($c >> 8) & 0xffffff);
		return $c ^ 0xffffffff;
	}
	public static function crc16($data){
		$c = 0;
		for($i = 0; isset($data[$i]); ++$i)
			$c = self::$crc16table[$c ^ ord($data[$i])] ^ ($c >> 8);
		return $c;
	}
	public static function crc8($data){
		$c = 0;
		for($i = 0; isset($data[$i]); ++$i)
			$c = self::$crc8table[$c ^ ord($data[$i])] ^ ($c >> 8);
		return $c;
	}
	public static function crc32bzip2($data){
		$c = 0xffffffff;
		for($i = 0; isset($data[$i]); ++$i)
			$c = self::$crc32bzip2table[($c >> 24) ^ ord($data[$i])] ^ ($c << 8);
		return $c ^ 0xffffffff;
	}
	public static function adler32($data){
		$a = 1;
		$b = 0;
		for($i = 0; isset($data[$i]); ++$i){
			$a = ($a + ord($data[$i])) % 65521;
			$b = ($b + $a) % 65521;
		}
		return ($b << 16) | $a;
	}
	public static function tdesktop_md5($data, $raw = null){
		$data = implode('', array_map('strrev', str_split(md5($data, true), 2)));
		return $raw === true ? $data : bin2hex($data);
	}
	public static function bsd($data){
		$sum = 0;
		for($i = 0; isset($data[$i]); ++$i)
			$sum = (($sum >> 1) + (($sum & 1) << 15) + chr($data[$i])) & 0xffff;
		return $sum;
	}
	public static function xor8($data){
		$lrc = 0;
		for($i = 0; isset($data[$i]); ++$i)
			$lrc = ($lrc + ord($data[$i])) & 0xff;
		return (($lrc ^ 0xff) + 1) & 0xff;
	}
	public static function luhn($data){
		$data .= '0';
		$sum = 0;
		$i = strlen($data);
		$odd = $i % 2;
		while(--$i >= 0) {
			$h = ord($data[$i]);
			$sum += $h;
			$odd === ($i % 2) ? $h > 4 ? ($sum += $h - 9) : ($sum += $h) : null;
		}
		return (10 - ($sum % 10)) % 10;
	}
	public static function verhoeff($number){
		$ck = 0;
		$l = strlen($number);
		$i = $l - 1;
		while(--$i >= 0)
			$ck = self::$verhoeffmul[$ck][self::$verhoeffper[($l - $i) % 8][(int)$number[$i]]];
		return self::$verhoeffinv[$ck];
	}
	public static function damm($number){
		$interim = 0;
		for($i = 0; isset($data[$i]); ++$i)
			$interim = self::$dammmatrix[$interim][(int)$data[$i]];
		return $interim;
	}
	private static function pearson16($data){
		$hash = array();
		$data = array_values(unpack('C*', $data));
		for($j = 0; $j < 8; ++$j) {
			$h = self::$pearsonT[($data[0] + $j) & 0xff];
			for($i = 1; isset($data[$i]); ++$i)
			   $h = self::$pearsonT[$h ^ $data[$i]];
			$hash[$j] = $h;
		}
		return chr($hash[0]) . chr($hash[1]) . chr($hash[2]) . chr($hash[3]) .
			   chr($hash[4]) . chr($hash[5]) . chr($hash[6]) . chr($hash[7]);
	}
	private static function md2($m){
		$length = strlen($m);
		$pad = 16 - ($length & 0xf);
		$m .= str_repeat(chr($pad), $pad);
		$length |= 0xf;
		$s = self::$md2s;
		$c = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$m = array_values(unpack('C*', $m));
		$l = 0;
		for($i = 0; $i < $length; $i += 16)
			for($j = 0; $j < 16; ++$j)
				$l = $c[$j] = $s[$m[$i + $j] ^ $l] ^ $c[$j];
		$m = array_merge($m, $c);
		$length += 16;
		$x = array(
			0, 0, 0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 0, 0, 0, 0,
			0, 0, 0, 0, 0, 0, 0, 0,
		);
		for($i = 0; $i < $length; $i += 16) {
			for($j = 0; $j < 16; ++$j) {
				$x[$j + 16] = $m[$i + $j];
				$x[$j + 32] = $x[$j + 16] ^ $x[$j];
			}
			$t = 0;
			for($j = 0; $j < 18; ++$j) {
				for($k = 0; $k < 48; ++$k)
					$x[$k] = $t = $x[$k] ^ $s[$t];
				$t = $t + $j;
			}
		}
		array_unshift($x, "C*");
		return call_user_func_array('pack', $x);
	}
	public static function mybb($plaintext, $salt = '', $raw = null){
		return md5(md5($salt) . md5($plaintext), $raw);
	}
	public static function hash($algo, $data, $raw = null){
		if(__apeip_data::$instMhash && defined('MHASH_' . ($algo = strtoupper($algo))))
			return $raw === true ? mhash(constant('MHASH_' . $algo), $data) : self::hexencode(mhash(constant('MHASH_' . $algo), $data));
		$algo = strtolower($algo);
		if(__apeip_data::$instHash && in_array($algo, hash_algos()))
			return hash($algo, $data, $raw === true);
		switch($algo){
			case 'adler32':
				return $raw === true ? pack('N', self::adler32($data)) : self::hexencode(pack('N', self::adler32($data)));
			case 'crc8':
				return $raw === true ? chr(self::crc8($data)) : self::hexencode(chr(self::crc8($data)));
			case 'crc16':
				return $raw === true ? pack('n', self::crc16($data)) : self::hexencode(pack('n', self::crc16($data)));
			case 'crc32b':
				return $raw === true ? pack('i', self::crc32($data)) : self::hexencode(pack('i', self::crc32($data)));
			case 'crc32':
				return $raw === true ? pack('i', self::crc32bzip2($data)) : self::hexencode(pack('i', self::crc32bzip2($data)));
			case 'bsd':
				return $raw === true ? pack('n', self::bsd($data)) : bin2hex(pack('n', self::bsd($data)));
			case 'xor8':
				return $raw === true ? chr(self::xor8($data)) : bin2hex(chr(self::xor8($data)));
			case 'keccak224':
				return self::keccak($data, 224, 224, 1, $raw === true);
			case 'keccak256':
				return self::keccak($data, 256, 256, 1, $raw === true);
			case 'keccak384':
				return self::keccak($data, 384, 384, 1, $raw === true);
			case 'keccak512':
				return self::keccak($data, 512, 512, 1, $raw === true);
			case 'shake128':
				return self::keccak($data, 128, 256, 0x1f, $raw === true);
			case 'shake256':
				return self::keccak($data, 256, 512, 0x1f, $raw === true);
			case 'sha3-224':
				return substr(self::sha3($data, 448, 1152, 28, 2, $raw === true), 0, -8);
			case 'sha3-224-full':
				return self::sha3($data, 448, 1152, 28, 2, $raw === true);
			case 'sha3-256':
				return self::sha3($data, 512, 1088, 32, 2, $raw === true);
			case 'sha3-384':
				return self::sha3($data, 768, 832, 48, 2, $raw === true);
			case 'sha3-512':
				return self::sha3($data, 1024, 576, 64, 2, $raw === true);
			case 'pearson16':
				return $raw === true ? self::pearson16($data) : self::hexencode(self::pearson16($data));
			case 'md2':
				return $raw === true ? substr(self::md2($data), 0, 16) : self::hexencode(substr(self::md2($data), 0, 16));
			case 'md2-full':
				return $raw === true ? self::md2($data) : self::hexencode(self::md2($data));
			case 'ntlm':
				return self::hash('md4', self::iconv($data, 'utf-8', 'utf-16le'), $raw === true);
			case 'mysql5':
				return self::hash('sha1', self::hash('sha1', $data, true), $raw === true);
			case 'add-chars':
				return $raw === true ? chr(array_sum(unpack('C*', $data))) : str_pad(dechex(array_sum(unpack('C*', $data)) & 0xff), 2, '0', STR_PAD_LEFT);
		}
		if(in_array($algo, self::crcalgos())){
			$length = self::crcalgo($algo);
			$length = ceil($length['length'] / 8);
			switch($length){
				case 1:
					return $raw === true ? chr(self::crc($algo, $data)) : bin2hex(chr(self::crc($algo, $data)));
				case 2:
					return $raw === true ? pack('n', self::crc($algo, $data)) : bin2hex(pack('n', self::crc($algo, $data)));
				case 3:
					return $raw === true ? substr(pack('i', self::crc($algo, $data)), 0, -1) : bin2hex(substr(pack('i', self::crc($algo, $data)), 0, -1));
				case 4:
					return $raw === true ? pack('i', self::crc($algo, $data)) : bin2hex(pack('i', self::crc($algo, $data)));
			}
		}
		new APError('Crypt hash', "Unknown hashing algorithm: $algo", APError::WARNING);
		return false;
	}
	public static function hash_repeat($algo, $data, $length = null, $raw = null){
		if($length === null)$length = strlen($data);
		$hash = self::hash($algo, $data, $raw);
		while(strlen($hash) < $length){
			$hash .= self::hash($algo, $hash . $data, $raw);
		}
		return substr($hash, 0, $length);
	}
	public static function hash_nsec3($qname, $salt = null, $iterations = 0){
		$hash = '';
		$salt = $salt === null ? '' : self::hexencode($salt);
		$qparts = explode('.', strtolower($qname));
		foreach($qparts as $part)
			$hash .= chr(strlen($part)) . $part;
		$hash .= "\0";
		do{
			$hash .= $salt;
			$hash = sha1($hash, true);
		}while(--$iterations >= 0);
		return self::nsec3encode($hash);
	}
	public static function hash_length($algo, $raw = null){
		$algos = array(
			"md2" => 16,		 "md4" => 16,		 "md5" => 16,
			"sha1" => 20,		"sha224" => 28,	  "sha256" => 32,
			"sha384" => 48,	  "sha512/224" => 28,  "sha512/256" => 32,
			"sha512" => 64,	  "sha3-224" => 28,	"sha3-256" => 32,
			"sha3-384" => 48,	"sha3-512" => 64,	"ripemd128" => 16,
			"ripemd160" => 20,   "ripemd256" => 32,   "ripemd320" => 40,
			"whirlpool" => 64,   "tiger128,3" => 16,  "tiger160,3" => 20,
			"tiger192,3" => 24,  "tiger128,4" => 16,  "tiger160,4" => 20,
			"tiger192,4" => 24,  "snefru" => 32,	  "snefru256" => 32,
			"gost" => 32,		"gost-crypto" => 32, "adler32" => 4,
			"crc32" => 4,		"crc32b" => 4,	   "crc16" => 2,
			"crc8" => 1,		 "bsd" => 2,		  "pearson" => 8,
			"fnv132" => 4,	   "fnv1a32" => 4,
			"fnv164" => 8,	   "fnv1a64" => 8,	  "joaat" => 4,
			"haval128,3" => 16,  "haval160,3" => 20,  "haval192,3" => 24,
			"haval224,3" => 28,  "haval256,3" => 32,  "haval128,4" => 16,
			"haval160,4" => 20,  "haval192,4" => 24,  "haval224,4" => 28,
			"haval256,4" => 32,  "haval128,5" => 16,  "haval160,5" => 20,
			"haval192,5" => 24,  "haval224,5" => 28,  "haval256,5" => 32,
			"keccak224" => 56,   "keccak256" => 64,   "keccak384" => 96,
			"keccak512" => 128,  "shake128"  => 64,   "shake256"  => 128,
			"ntlm" => 16,		"mysql5" => 20
		);
		if(!isset($algos[$algo]))return false;
		$length = $algos[$algo];
		if($raw === null)return $length;
		if($raw === true)return $length * 2;
		$algos = array(
			"md2" => 1,		"md4" => 4,		"md5" => 4,
			"sha256" => 2,	 "sha512/256" => 4, "sha512" => 2,
			"ripemd128" => 4,  "ripemd256" => 2,  "whirlpool" => 1,
			"tiger128,3" => 4, "tiger128,4" => 4, "snefru" => 1,
			"snefru256" => 1,  "gost" => 1,	   "gost-crypto" => 1,
			"haval128,3" => 8, "haval256,3" => 4, "haval128,4" => 8,
			"haval256,4" => 4, "haval128,5" => 8, "haval256,5" => 4,
			"ntlm" => 4
		);
		if(!isset($algos[$algo]))return null;
		return $length * $algos[$algo];
	}
	public static function hash_algos(){
		return array(
			"md2",		"md4",		"md5",		 "sha1",		"sha224",
			"sha256",	 "sha384",	 "sha512/224",  "sha512/256",  "sha512",
			"sha3-224",   "sha3-256",   "sha3-384",	"sha3-512",	"ripemd128",
			"ripemd160",  "ripemd256",  "ripemd320",   "whirlpool",   "tiger128,3",
			"tiger160,3", "tiger192,3", "tiger128,4",  "tiger160,4",  "tiger192,4",
			"snefru",	 "snefru256",  "gost",		"gost-crypto", "adler32",
			"crc32",	  "crc32b",	 "crc16",	   "crc8",		"bsd",
			"pearson",	"fnv132",
			"fnv1a32",	"fnv164",	  "fnv1a64",	"joaat",	   "haval128,3",
			"haval160,3", "haval192,3", "haval224,3",  "haval256,3",  "haval128,4",
			"haval160,4", "haval192,4", "haval224,4",  "haval256,4",  "haval128,5",
			"haval160,5", "haval192,5", "haval224,5",  "haval256,5",  "keccak224",
			"keccak256",  "keccak384",  "keccak512",   "shake128",	"shake256",
			"ntlm",	   "mysql5"
		);
	}
	public static function hash_hmac_algos(){
		return array(
			"md2",		"md4",		"md5",		"sha256",	 "sha512/256",
			"sha512",	 "ripemd128",  "ripemd256",  "whirlpool",  "tiger128,3",
			"tiger128,4", "snefru",	 "snefru256",  "gost",	   "gost-crypto",
			"haval128,3", "haval256,3", "haval128,4", "haval256,4", "haval128,5",
			"haval256,5", "ntlm"
		);
	}
	public static function hash_hmac($algo, $data, $key, $raw = null) {
		if(__apeip_data::$instHashHmac && in_array($algo, hash_hmac_algos()))
			return hash_hmac($algo, $data, $key, $raw === true);
		if(__apeip_data::$instMhash && defined('MHASH_' . strtoupper($algo)))
			return $raw === true ? mhash(constant('MHASH_' . strtoupper($algo)), $data, $key) :
				bin2hex(mhash(constant('MHASH_' . strtoupper($algo)), $data, $key));
		$b = self::hash_length($algo);
		if($b === false){
			trigger_error("Crypt::hash_hmac(): Unknown hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($b === null){
			trigger_error("Crypt::hash_hmac(): Non-cryptographic hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if(strlen($key) > $b)
			$key = self::hash($algo, $key, true);
		$key = str_pad($key, $b, "\0");
		$ipad = str_pad('', $b, "\x36");
		$opad = str_pad('', $b, "\x5c");
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;
		return self::hash($algo, $k_opad . self::hash($algo, $k_ipad . $data, true), $raw === true);
	}
	public static function hash_hkdf($algo, $ikm, $length = 0, $info = '', $salt = '', $hex = null){
		if(__apeip_data::$instHashHkdf && __apeip_data::$instHashHmac && in_array($algo, hash_hmac_algos()))
			return $hex === true ? bin2hex(hash_hkdf($algo, $ikm, $length, $info, $salt)) : hash_hkdf($algo, $ikm, $length, $info, $salt);
		if($length < 0){
			trigger_error("Crypt::hash_hkdf(): Length must be greater than or equal to 0: $length", E_USER_WARNING);
			return false;
		}
		$size = self::hash_length($algo);
		if($size === false){
			trigger_error("Crypt::hash_hkdf(): Unknown hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($size === null){
			trigger_error("Crypt::hash_hkdf(): Non-cryptographic hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($length > $size * 255){
			trigger_error("Crypt::hash_hkdf(): Length must be less than or equal to " . ($size * 255) . ": $length", E_USER_WARNING);
			return false;
		}
		if($length === 0)
			$length = $size;
		if($salt === '')
			$salt = str_repeat("\0", $size);
		$prk = self::hash_hmac($algo, $ikm, $salt, true);
		$okm = '';
		for($keyBlock = '', $blockIndex = 1; !isset($okm[$length - 1]); ++$blockIndex){
			$keyBlock = self::hash_hmac($algo, $keyBlock . $info . chr($blockIndex), $prk, true);
			$okm .= $keyBlock;
		}
		return substr($hex === true ? bin2hex($okm) : $okm, 0, $length);
	}
	public static function hash_pbkdf1($algo, $password, $salt, $iterations, $length = 0, $raw = null){
		if($length < 0){
			trigger_error("Crypt::hash_pbkdf1(): Length must be greater than or equal to 0: $length", E_USER_WARNING);
			return false;
		}
		$size = self::hash_length($algo, $raw === true);
		if($size === false){
			trigger_error("Crypt::hash_pbkdf1(): Unknown hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($size === null){
			trigger_error("Crypt::hash_pbkdf1(): Non-cryptographic hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($length == 0)
			$length = $size;
		$tmp = $password . $salt;
		for($i = 0; $i < $iterations; ++$i)
			$tmp = self::hash($algo, $tmp, true);
		return substr($raw === true ? $tmp : bin2hex($tmp), 0, $length);
	}
	public static function hash_pbkdf2($algo, $password, $salt, $iterations, $length = 0, $raw = null){
		if(__apeip_data::$instHashPbkdf2 && __apeip_data::$instHashHmac && in_array($algo, hash_hmac_algos()))
			return hash_pbkdf2($algo, $password, $salt, $iterations, $length, $raw === true);
		if($length < 0){
			trigger_error("Crypt::hash_pbkdf2(): Length must be greater than or equal to 0: $length", E_USER_WARNING);
			return false;
		}
		$size = self::hash_length($algo, $raw === true);
		if($size === false){
			trigger_error("Crypt::hash_pbkdf2(): Unknown hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($size === null){
			trigger_error("Crypt::hash_pbkdf2(): Non-cryptographic hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($length == 0)
			$length = $size;
		$output = '';
		$block_count = ceil($length / $size);
		for($block = 1; $block <= $block_count; ++$block) {
			$key1 = $key2 = self::hash_hmac($algo, $salt . pack('N', $block), $password, true);
			for($iteration = 1; $iteration < $iterations; ++$iteration)
				$key2 ^= $key1 = self::hash_hmac($algo, $key1, $password, true);
			$output .= $key2;
		}
		return substr($raw === true ? $output : bin2hex($output), 0, $length);
	}
	public static function hash_schneier($algo, $password, $salt, $iterations, $length = 0, $raw = null){
		if($length < 0){
			trigger_error("Crypt::hash_schneier(): Length must be greater than or equal to 0: $length", E_USER_WARNING);
			return false;
		}
		$saltlen = strlen($salt);
		if($saltlen > PHP_INT_MAX - 4) {
			trigger_error("Crypt::hash_schneier(): Supplied salt is too long, max of PHP_INT_MAX - 4 bytes: $saltlen supplied", E_USER_WARNING);
			return false;
		}
		$size = self::hash_length($algo, $raw === true);
		if($size === false){
			trigger_error("Crypt::hash_schneier(): Unknown hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($size === null){
			trigger_error("Crypt::hash_schneier(): Non-cryptographic hashing algorithm: $algo", E_USER_WANING);
			return false;
		}
		if($length == 0)
			$length = $size;
		$tmp = self::hash($algo, $password . $salt, true);
		for($i = 2; $i <= $iterations; ++$i)
			$tmp = self::hash($algo, $tmp . $password . $salt, true);
		return substr($raw === true ? $tmp : bin2hex($tmp), 0, $length);
	}
	public static function hash_equal($hash, $data, $algo = 'auto'){
		if(ctype_xdigit($hash))$raw = false;
		else $raw = true;
		if($algo == 'auto'){
			foreach(self::hash_algos() as $algo)
				if(self::hash($algo, $data, $raw) == $hash)
					return $algo;
			return false;
		}
		if(self::hash($algo, $data, $raw) == $hash)
			return $algo;
		return false;
	}

	public static function crctable($poly, $bitlen = 32, $revin = null, $revout = null){
		$mask = (((1 << ($bitlen - 1)) - 1) << 1) | 1;
		$highBit = 1 << ($bitlen - 1);
		$crctab = array();
		for($i = 0; $i < 256; ++$i) {
			$crc = $i;
			if($revin === true)
				$crc = math::brev($crc, 8);
			$crc <<= $bitlen - 8;
			for($j = 0; $j < 8; ++$j) {
				$bit = $crc & $highBit;
				$crc <<= 1;
				if($bit)
					$crc ^= $poly;
			}
			if($revout === true)
				$crc = math::brev($crc, $bitlen);
			$crc &= $mask;
			$crctab[] = $crc;
		}
		return $crctab;
	}
	public static function crcalgo($algo){
		$algo = strtolower($algo);
		$algos = array(
			'crc1'				=> array(0x1, 0x1, 0x0, 0x0, false, false),
			'crc4'				=> array(0x3, 0x4, 0x0, 0x0, true, true),
			'crc4/itu'			=> array(0x3, 0x4, 0x0, 0x0, true, true),
			'crc4/interlaken'   => array(0x3, 0x4, 0xf, 0xf, false, false),
			'crc8'				=> array(0x7,  0x8, 0x0,  0x0,  false, false),
			'crc8/cdma2000'	 	=> array(0x9b, 0x8, 0xff, 0x0,  false, false),
			'crc8/darc'			=> array(0x39, 0x8, 0x0,  0x0,  true, true),
			'crc8/dvb-s2'		=> array(0xd5, 0x8, 0x0,  0x0,  false, false),
			'crc8/ebu'			=> array(0x1d, 0x8, 0xff, 0x0,  true, true),
			'crc8/i-code'		=> array(0x1d, 0x8, 0xfd, 0x0,  false, false),
			'crc8/itu'			=> array(0x7,  0x8, 0x0,  0x55, false, false),
			'crc8/maxim'		=> array(0x31, 0x8, 0x0,  0x0,  true, true),
			'crc8/rohc'			=> array(0x7,  0x8, 0xff, 0x0,  true, true),
			'crc8/wcdma'		=> array(0x9b, 0x8, 0x0,  0x0,  true, true),
			'crc8/autosar'		=> array(0x2f, 0x8, 0xff, 0xff, false, false),
			'crc8/bluetooth'	=> array(0xa7, 0x8, 0x0,  0x0,  true, true),
			'crc8/gsma'			=> array(0x1d, 0x8, 0x0,  0x0,  false, false),
			'crc8/gsmb'			=> array(0x49, 0x8, 0x0,  0xff, false, false),
			'crc8/lte'			=> array(0x9b, 0x8, 0x0,  0x0,  false, false),
			'crc8/opensafety'   => array(0x2f, 0x8, 0x0,  0x0,  false, false),
			'crc8/sae-j1850'	=> array(0x1d, 0x8, 0xff, 0xff, false, false),
			'crc16'				=> array(0x8005, 0x10, 0x0,	0x0,	true, true),
			'crc16/arc'			=> array(0x8005, 0x10, 0x0,	0x0,	true, true),
			'crc16/aug-ccitt'   => array(0x1021, 0x10, 0x1d0f, 0x0,	false, false),
			'crc16/buypass'		=> array(0x8005, 0x10, 0x0,	0x0,	false, false),
			'crc16/ccitt-false' => array(0x1021, 0x10, 0xffff, 0x0,	false, false),
			'crc16/cdma2000'	=> array(0xc867, 0x10, 0xffff, 0x0,	false, false),
			'crc16/cms'			=> array(0x8005, 0x10, 0xffff, 0x0,	false, false),
			'crc16/dds'			=> array(0x8005, 0x10, 0x800d, 0x0,	false, false),
			'crc16/dect-r'		=> array(0x589,  0x10, 0x0,	0x1,	false, false),
			'crc16/dect-x'		=> array(0x589,  0x10, 0x0,	0x0,	false, false),
			'crc16/dnp'			=> array(0x3d65, 0x10, 0x0,	0xffff, true, true),
			'crc16/en-13757'	=> array(0x3d65, 0x10, 0x0,	0xffff, false, false),
			'crc16/genibus'		=> array(0x1021, 0x10, 0xffff, 0xffff, false, false),
			'crc16/gsm'			=> array(0x1021, 0x10, 0x0,	0xffff, false, false),
			'crc16/kermit'		=> array(0x1021, 0x10, 0x0,	0x0,	true, true),
			'crc16/lj1200'		=> array(0x6f63, 0x10, 0x0,	0x0,	false, false),
			'crc16/maxim'		=> array(0x8005, 0x10, 0x0,	0xffff, true, true),
			'crc16/mcrf4xx'		=> array(0x1021, 0x10, 0xffff, 0x0,	true, true),
			'crc16/modbus'		=> array(0x8005, 0x10, 0xffff, 0x0,	true, true),
			'crc16/opensafetya' => array(0x5935, 0x10, 0x0,	0x0,	false, false),
			'crc16/opensafetyb' => array(0x755b, 0x10, 0x0,	0x0,	false, false),
			'crc16/profibus'	=> array(0x1dcf, 0x10, 0xffff, 0xffff, false, false),
			'crc16/ps2ff'		=> array(0x1021, 0x10, 0x1d0f, 0x0,	false, false),
			'crc16/riello'		=> array(0x1021, 0x10, 0xb2aa, 0x0,	true, true),
			'crc16/t10-dif'		=> array(0x8bb7, 0x10, 0x0,	0x0,	false, false),
			'crc16/teledisk'	=> array(0xa097, 0x10, 0x0,	0x0,	false, false),
			'crc16/tms37157'	=> array(0x1021, 0x10, 0x89ec, 0x0,	true, true),
			'crc16/usb'		 	=> array(0x8005, 0x10, 0xffff, 0xffff, true, true),
			'crc16/x-25'		=> array(0x1021, 0x10, 0xffff, 0xffff, true, true),
			'crc16/xmodem'		=> array(0x1021, 0x10, 0x0,	0x0,	false, false),
			'crca'				=> array(0x1021, 0x10, 0xc6c6, 0x0,	true, true),
			'crc24'			 	=> array(0x864cfb, 0x18, 0xb704ce, 0x0,	  false, false),
			'crc24/flexraya'	=> array(0x5d6dcb, 0x18, 0xfedcba, 0x0,	  false, false),
			'crc24/flexrayb'	=> array(0x5d6dcb, 0x18, 0xabcdef, 0x0,	  false, false),
			'crc24/interlaken'  => array(0x328b63, 0x18, 0xffffff, 0xffffff, false, false),
			'crc24/ltea'		=> array(0x864cfb, 0x18, 0x0,	  0x0,	  false, false),
			'crc24/lteb'		=> array(0x800063, 0x18, 0x0,	  0x0,	  false, false),
			'crc32'				=> array(0x4c11db7,  0x20, 0xffffffff, 0xffffffff, true, true),
			'crc32c'			=> array(0x1edc6f41, 0x20, 0xffffffff, 0xffffffff, true, true),
			'crc32d'			=> array(0xa833982b, 0x20, 0xffffffff, 0xffffffff, true, true),
			'crc32q'			=> array(0x814141ab, 0x20, 0x0,		0x0,		false, false),
			'crc32/bzip2'		=> array(0x4c11db7,  0x20, 0xffffffff, 0xffffffff, false, false),
			'crc32/jamcrc'		=> array(0x4c11db7,  0x20, 0xffffffff, 0x0,		true, true),
			'crc32/mpeg-2'		=> array(0x4c11db7,  0x20, 0xffffffff, 0x0,		false, false),
			'crc32/posix'		=> array(0x4c11db7,  0x20, 0x0,		0xffffffff, false, false),
			'crc32/xfer'		=> array(0xaf,	   0x20, 0x0,		0x0,		false, false),
			'crc32/autosar'		=> array(0xf4acfb13, 0x20, 0xffffffff, 0xffffffff, true, true)
		);
		if(!isset($algos[$algo]))
			return false;
		$algo = $algos[$algo];
		return array(
			'polynomial' => $algo[0],
			'length'	 => $algo[1],
			'init'		 => $algo[2],
			'xorout'	 => $algo[3],
			'refin'		 => $algo[4],
			'refout'	 => $algo[5]
		);
	}
	public static function crcalgos(){
		return array(
			"crc1",			  "crc4",			  "crc4/itu",	   "crc4/interlaken",
			"crc8",			  "crc8/cdma2000",	 "crc8/darc",	  "crc8/dvb-s2",
			"crc8/ebu",		  "crc8/i-code",	   "crc8/itu",	   "crc8/maxim",
			"crc8/rohc",		 "crc8/wcdma",		"crc8/autosar",   "crc8/bluetooth",
			"crc8/gsma",		 "crc8/gsmb",		 "crc8/lte",	   "crc8/opensafety",
			"crc8/sae-j1850",	"crc16",			 "crc16/arc",	  "crc16/aug-ccitt",
			"crc16/buypass",	 "crc16/ccitt-false", "crc16/cdma2000", "crc16/cms",
			"crc16/dds",		 "crc16/dect-r",	  "crc16/dect-x",   "crc16/dnp",
			"crc16/en-13757",	"crc16/genibus",	 "crc16/gsm",	  "crc16/kermit",
			"crc16/lj1200",	  "crc16/maxim",	   "crc16/mcrf4xx",  "crc16/modbus",
			"crc16/opensafetya", "crc16/opensafetyb", "crc16/profibus", "crc16/ps2ff",
			"crc16/riello",	  "crc16/t10-dif",	 "crc16/teledisk", "crc16/tms37157",
			"crc16/usb",		 "crc16/x-25",		"crc16/xmodem",   "crca",
			"crc24",			 "crc24/flexraya",	"crc24/flexrayb", "crc24/interlaken",
			"crc24/ltea",		"crc24/lteb",		"crc32",		  "crc32c",
			"crc32d",			"crc32q",			"crc32/bzip2",	"crc32/jamcrc",
			"crc32/mpeg-2",	  "crc32/posix",	   "crc32/xfer",	 "crc32/autosar"
		);
	}
	private static function _crc($algo, $data, $crc = null){
		$mask = (((1 << ($algo['length'] - 1)) - 1) << 1) | 1;
		$high = 1 << ($algo['length'] - 1);
		if($crc === null)$crc = $algo['init'];
		elseif($algo['refout'] === true)
			$crc = math::brev($crc, $algo['length']);
		for($i = 0; isset($data[$i]); ++$i) {
			$char = ord($data[$i]);
			if($algo['refin'] === true)
				$char = math::brev($char, 8);
			for($j = 0x80; $j > 0; $j >>= 1) {
				$bit = $crc & $high;
				$crc <<= 1;
				if($char & $j)
					$bit ^= $high;
				if($bit)
					$crc ^= $algo['polynomial'];
			}
		}
		if($algo['refout'] === true)
			$crc = math::brev($crc, $algo['length']);
		$crc ^= $algo['xorout'];
		return $crc & $mask;
	}
	public static function crc($algo, $data = '123456789', $crc = null){
		$algo = self::crcalgo($algo);
		if($algo === false){
			new APError('Crypt crc', "Unknown CRC hashing algorithm", APError::WARNING);
			return false;
		}
		return self::_crc($algo, $data, $crc);
	}
	public static function crcfile($algo, $file, $crc = null){
		if(!is_file($file)){
			new APError('Crypt crcfile', 'No such file', APError::WARNING);
			return false;
		}
		$algo = self::crcalgo($algo);
		if($algo === false){
			new APError('Crypt crcfile', "Unknown CRC hashing algorithm", APError::WARNING);
			return false;
		}
		$file = fopen($file, 'r');
		$mem = ceil(apeip::memoryout_free() / 10);
		do{
			$read = fread($file, $mem);
			$crc = self::_crc($algo, $read, $crc);
		}while(strlen($read) == $mem);
		return $crc;
	}
	public static function crcnull($algo, $length = 0){
		return $length <= 0 ? self::crc($algo, '') : self::crc($algo, str_repeat("\0", $length));
	}

	public static function hexencode($string){
		if(__apeip_data::$instHex)
			return bin2hex($string);
		return array_value(pack('H*', $string), 1);
	}
	public static function hexdecode($string){
		$l = strlen($string);
		if($l % 2 === 1)$string = '0' . $string;
		if(__apeip_data::$instHex)
			return hex2bin($string);
		return pack('H*', $string);
	}
	public static function hexstrlen($string){
		return ceil(strlen($string) / 2);
	}
	public static function binencode($string){
		if(__apeip_data::$instHex)
				return strtr(bin2hex($string), array(
					'0000', '0001', '0010', '0011',
					'0100', '0101', '0110', '0111',
					'1000', '1001',
					'a' => '1010', 'b' => '1011', 'c' => '1100',
					'd' => '1101', 'e' => '1110', 'f' => '1111'
				));
		$bin = '';
		for($i = 0; isset($string[$i]); ++$i)
			$bin = substr(decbin(ord($string[$i]) | 256), 1);
		return $bin;
	}
	public static function bindecode($string){
		$l = strlen($string);
		if($l % 8 !== 0)$string = str_repeat('0', 8 - $l % 8) . $string;
		if(__apeip_data::$instHex)
			return hex2bin(strtr($string, array(
				"0000" => "0", "0001" => "1", "0010" => "2", "0011" => "3",
				"0100" => "4", "0101" => "5", "0110" => "6", "0111" => "7",
				"1000" => "8", "1001" => "9", "1010" => "a", "1011" => "b",
				"1100" => "c", "1101" => "d", "1110" => "e", "1111" => "f"
			)));
		$bin = '';
		for($i = 0; isset($string[$i]); $i += 8)
			$bin .= chr(bindec(substr($string, $i, 8)));
		return $bin;
	}
	public static function binstrlen($string){
		return ceil(strlen($string) / 8);
	}
	public static function base4encode($string){
		if(__apeip_data::$instHex)
				return strtr(bin2hex($string), array(
					'00', '01', '02', '03',
					'10', '11', '12', '13',
					'20', '21',
					'a' => '22', 'b' => '23', 'c' => '30',
					'd' => '31', 'e' => '32', 'f' => '33'
				));
		$bin = '';
		for($i = 0; isset($string[$i]); ++$i)
			$bin = substr(base_convert(ord($string[$i]) | 256, 10, 4), 1);
		return $bin;
	}
	public static function base4decode($string){
		$l = strlen($string);
		if($l % 4 !== 0)$string = str_repeat('0', 4 - $l % 4) . $string;
		if(__apeip_data::$instHex)
			return hex2bin(strtr($string, array(
				"00" => "0", "01" => "1", "02" => "2", "03" => "3",
				"10" => "4", "11" => "5", "12" => "6", "13" => "7",
				"20" => "8", "21" => "9", "22" => "a", "23" => "b",
				"30" => "c", "31" => "d", "32" => "e", "33" => "f"
			)));
		$bin = '';
		for($i = 0; isset($string[$i]); $i += 4)
			$bin .= chr(base_convert(substr($string, $i, 4), 4, 10));
		return $bin;
	}
	public static function base4strlen($string){
		return ceil(strlen($string) / 4);
	}
	public static function octencode($string){
		$oct = '';
		for($i = 0; isset($string[$i]); $i += 3){
			$i1 = isset($string[$i + 1]);
			$a1 = ord($string[$i]);
			$a2 = $i1 ? ord($string[$i + 1]) : 0;
			$oct .= $a1 >> 5;
			$oct .= ($a1 >> 2) & 7;
			$oct .= (($a1 & 3) << 1) | ($a2 >> 7);
			if($i1){
				$i2 = isset($string[$i + 2]);
				$a3 = $i2 ? ord($string[$i + 2]) : 0;
				$oct .= ($a2 >> 4) & 7;
				$oct .= ($a2 >> 1) & 7;
				$oct .= (($a2 & 1) << 2) | ($a3 >> 6);
				if($i2){
					$oct .= ($a3 >> 3) & 7;
					$oct .= $a3 & 7;
				}
			}
		}
		return $oct;
	}
	public static function octdecode($string){
		$l = strlen($string);
		if($l % 8 !== 0){
			$l = $l % 8;
			if($l < 4){
				if($l !== 3)$string .= str_repeat('0', 3 - $l) . $string;
			}elseif($l < 7){
				if($l !== 6)$string .= str_repeat('0', 6 - $l) . $string;
			}else $string .= str_repeat('0', 8 - $l);
		}
		$bin = '';
		for($i = 0; isset($string[$i]); $i += 8){
			$i1 = isset($string[$i + 3]);
			$bin .= chr(($string[$i] << 5) | ($string[$i + 1] << 2) | ($string[$i + 2] >> 1));
			if($i1){
				$i2 = isset($string[$i + 6]);
				$bin .= chr((($string[$i + 3] | (($string[$i + 2] & 1) << 3)) << 4) | ($string[$i + 4] << 1) | ($string[$i + 5] >> 2));
				if($i2)
					$bin .= chr((($string[$i + 6] | (($string[$i + 5] & 3) << 3)) << 3) | $string[$i + 7]);
			}
		}
		return $bin;
	}
	public static function octstrlen($string){
		return ceil(strlen($string) / 8 * 3);
	}
	public static function base64encode($string){
		if(__apeip_data::$instBase64)return base64_encode($string);
		$s = str::BASE64T_RANGE;
		$res = '';
		for($i = 0; isset($string[$i]); $i += 3){
			$i1 = isset($string[$i + 1]);
			$a1 = ord($string[$i]);
			$a2 = $i1 ? ord($string[$i + 1]) : 0;
			$res .= $s[$a1 >> 2];
			$res .= $s[(($a1 & 3) << 4) | ($a2 >> 4)];
			if($i1){
				$i2 = isset($string[$i + 2]);
				$a3 = $i2 ? ord($string[$i + 2]) : 0;
				$res .= $s[(($a2 & 15) << 2) | ($a3 >> 6)];
				if($i2)
					$res .= $s[$a3 & 63];
				else $res .= '=';
			}else $res .= '==';
		}
		return $res;
	}
	public static function base64decode($string){
		$l = strlen($string);
		if($l % 4 !== 0)$string .= str_repeat('=', 4 - $l % 4);
		if(__apeip_data::$instBase64)return base64_decode($string);
		$s = str::BASE64T_RANGE;
		$bin = '';
		for($i = 0; isset($string[$i]); $i += 4){
			$a1 = strpos($s, $string[$i]);
			$a2 = strpos($s, $string[$i + 1]);
			$bin .= ord(($a1 << 2) | ($a2 >> 4));
			if($string[$i + 2] != '='){
				$a3 = strpos($s, $string[$i + 2]);
				$bin .= ord((($a2 & 15) << 4) | ($a3 >> 2));
				if($string[$i + 3] != '='){
					$a4 = strpos($s, $string[$i + 3]);
					$bin .= ord((($a3 & 3) << 6) | $a4);
				}
			}
		}
		return $bin;
	}
	public static function base64strlen($string){
		return ceil(strlen($string) / 4 * 3);
	}
	public static function bcrypt64encode($string){
		return strtr(rtrim(self::base64encode($string), '='), str::BASE64T_RANGE, str::BCRYPT64_RANGE);
	}
	public static function bcrypt64decode($string){
		return self::base64decode(strtr($string, str::BCRYPT64_RANGE, str::BASE64T_RANGE));
	}
	public static function base64urlencode($string){
		return rtrim(strtr(self::base64encode($string), '+/', '-_'), '=');
	}
	public static function base64urldecode($string){
		return self::base64decode(str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=', STR_PAD_RIGHT));
	}
	public static function base32encode($string){
		$s = str::BASE32_RANGE;
		$res = '';
		for($i = 0; isset($string[$i]); $i += 5){
			$i1 = isset($string[$i + 1]);
			$a1 = ord($string[$i]);
			$res .= $s[$a1 >> 3];
			if($i1){
				$i2 = isset($string[$i + 2]);
				$a2 = ord($string[$i + 1]);
				$res .= $s[(($a1 & 7) << 2) | ($a2 >> 6)];
				$res .= $s[($a2 >> 1) & 0x1f];
				if($i2){
					$i3 = isset($string[$i + 3]);
					$a3 = ord($string[$i + 2]);
					$res .= $s[(($a2 & 1) << 4) | ($a3 >> 4)];
					if($i3){
						$i4 = isset($string[$i + 4]);
						$a4 = ord($string[$i + 3]);
						$res .= $s[(($a3 & 0xf) << 1) | ($a4 >> 7)];
						$res .= $s[($a4 >> 2) & 0x1f];
						if($i4){
							$a5 = ord($string[$i + 4]);
							$res .= $s[(($a4 & 3) << 3) | ($a5 >> 5)];
							$res .= $s[$a5 & 0x1f];
						}else $res .= $s[($a4 & 3) << 3] . '=';
					}else $res .= $s[($a3 & 0xf) << 1] . '===';
				}else $res .= $s[($a2 & 1) << 4] . '====';
			}else $res .= $s[($a1 & 7) << 2] . '======';
		}
		return $res;
	}
	public static function base32decode($string){
		$l = strlen($string);
		if($l % 8 !== 0)$string .= str_repeat('=', 8 - $l % 8);
		$s = str::BASE32_RANGE;
		$bin = '';
		for($i = 0; isset($string[$i]); $i += 8){
			$a1 = strpos($s, $string[$i]);
			$a2 = strpos($s, $string[$i + 1]);
			$bin .= chr(($a1 << 3) | ($a2 >> 2));
			if($string[$i + 2] != '='){
				$a3 = strpos($s, $string[$i + 2]);
				$a4 = strpos($s, $string[$i + 3]);
				$bin .= chr((($a2 & 3) << 6) | ($a3 << 1) | ($a4 >> 4));
				if($string[$i + 4] != '='){
					$a5 = strpos($s, $string[$i + 4]);
					$bin .= chr((($a4 & 0xf) << 4) | ($a5 >> 1));
					if($string[$i + 5] != '='){
						$a6 = strpos($s, $string[$i + 5]);
						$a7 = strpos($s, $string[$i + 6]);
						$bin .= chr((($a5 & 1) << 7) | ($a6 << 2) | ($a7 >> 3));
						if($string[$i + 6] != '='){
							$a8 = strpos($s, $string[$i + 7]);
							$bin .= chr((($a7 & 7) << 5) | $a8);
						}
					}
				}
			}
		}
		return $bin;
	}
	public static function base32strlen($string){
		return ceil(strlen($string) / 8 * 5);
	}
	public static function nsec3encode($string){
		return strtr(self::base32encode($string), str::BASE32_RANGE, str::NSEC3_RANGE);
	}
	public static function nsec3decode($string){
		return self::base32decode(strtr($string, str::NSEC3_RANGE, str::BASE32_RANGE));
	}
	public static function rleencode($string){
		$new = '';
		$count = 0;
		foreach(str_split($string) as $cur) {
			if($cur === "\0")
				++$count;
			else{
				if($count > 0) {
					$new .= "\x00".chr($count);
					$count = 0;
				}
				$new .= $cur;
			}
		}
		return $new;
	}
	public static function rledecode($string){
		$new = '';
		$last = '';
		foreach(str_split($string) as $cur) {
			if($last === "\0") {
				$new .= str_repeat($last, ord($cur));
				$last = '';
			}else{
				$new .= $last;
				$last = $cur;
			}
		}
		return $new . $last;
	}
	public static function datline($string){
		$datline = array();
		for($i = 0; isset($string[$i]); ++$i)
			$datline[] = strtr(decbin(ord($string[$i])), '01', '.-');
		return implode(' ', $datline);
	}
	public static function undatline($datline){
		$datline = explode(' ', $datline);
		$string = '';
		for($i = 0; isset($datline[$i]); ++$i)
			$string .= chr(bindec(strtr($datline[$i], '.-', '01')));
		return $string;
	}
	public static function datlinestrlen($datline){
		if($datline == '')return 0;
		return substr_count($datline, ' ') + 1;
	}
	public static function urlencode($string, $space = false){
		if(__apeip_data::$instUrlcoding)
			if($space === true)
				return str_replace(array('+', '%2B'), array('%20', '+'), urlencode($string));
			else return urlencode($string);
		$url = '';
		$string = (string)$string;
		for($i = 0; isset($string[$i]); ++$i){
			if(strpos(str::URLACCEPT_RANGE, $string[$i]) !== false)
				$url .= $string[$i];
			elseif($string[$i] === ' ' && $space !== true)$url .= '+';
			elseif($string[$i] === '+' && $space === true)$url .= '+';
			else{
				$c = ord($string[$i]);
				$url .= $c < 16 ? '%0' . strtoupper(dechex($c)) : '%' . strtoupper(dechex($c));
			}
		}
		return $url;
	}
	public static function urldecode($url, $space = false){
		if(__apeip_data::$instUrlcoding)return urldecode($url);
		$string = '';
		for($i = 0; isset($url[$i]); ++$i){
			if($url[$i] == '%'){
				$string .= chr(hexdec(substr($url, $i + 1, 2)));
				$i += 2;
			}elseif($url[$i] == '+' && $space !== true)$string .= ' ';
			else $string .= $url[$i];
		}
		return $string;
	}
	public static function fullurlencode($string, $space = false){
		if($string === '')return '';
		$string = '%' . implode('%', str_split(self::hexencode($string), 2));
		return $space === true ? $string : str_replace('%20', '+', $string);
	}

	public static function sizeencode($l){
		$arr = array("c*");
		while($l > 0) {
			$arr[] = $l & 0xff;
			$l >>= 8;
		}
		$size = call_user_func_array('pack',$arr);
		return chr(strlen($size)) . $size;
	}
	public static function sizedecode($str){
		$size = ord($str[0]);
		$size = substr($str, 1, $size);
		$arr = unpack("c*", $size);
		$size = 0;
		for($c = 1; isset($arr[$c]); ++$c)$size = $size * 255 + $arr[$c];
		return (int)$size;
	}

	public static function huffmanfill($data, $value = ''){
		if(!is_array($data[0][1]))
			$array = array($data[0][1] => $value . '0');
		else
			$array = self::huffmanfill($data[0][1], $value . '0');
		if(isset($data[1]))
			if(!is_array($data[1][1]))
				$array[$data[1][1]] = $value . '1';
			else
				$array += self::huffmanfill($data[1][1], $value . '1');
		return $array;
	}
	public static function huffmandictlen($dict){
		$max = -1;
		$min = -1;
		foreach($dict as $res){
			$res = strlen($res);
			if($max < $res)$max = $res;
			if($min === -1 || $min > $res)$min = $res;
		}
		return array($max, $min);
	}
	public static function huffmanentry(string &$value, $dict, $dictlen){
		$length = strlen($value);
		for($i = $dictlen[1]; $i <= $dictlen[0]; ++$i) {
			$need = substr($value, 0, $i);
			foreach($dict as $key => $val)
				if($need === $val) {
					$value = substr($value, $i);
					return $key;
				}
		}
		return null;
	}
	public static function huffmandict($data){
		$occ = array();
		while(isset($data[0])) {
			$occ[] = array(substr_count($data, $data[0]), $data[0]);
			$data = str_replace($data[0], '', $data);
		}
		sort($occ);
		while(count($occ) > 1) {
			$row1 = array_shift($occ);
			$row2 = array_shift($occ);
			$occ[] = array($row1[0] + $row2[0], array($row1, $row2));
			sort($occ);
		}
		print unce($occ);
		return self::huffmanfill(is_array($occ[0][1]) ? $occ[0][1] : $occ);
	}
	public static function huffmanencode($data, $dict = null){
		if($data === '')
			return '';
		if($dict === null)
			$dict = self::huffmandict($data);
		$bin = '';
		for($i = 0; isset($data[$i]); ++$i)
			if(isset($dict[$data[$i]]))
				$bin .= $dict[$data[$i]];
		$spl = str_split(1 . $bin . 1, 8);
		$bin = '';
		foreach($spl as $c)
			$bin .= chr(bindec(str_pad($c, 8, '0')));
		return $bin;
	}
	public static function huffmandecode($data, $dict){
		if($data === '')
			return '';
		$bin = '';
		$l = strlen($data);
		$res = '';
		$dictlen = self::huffmandictlen($dict);
		for($i = 0; $i < $l; ++$i) {
			$decbin = str_pad(decbin(ord($data[$i])), 8, '0', STR_PAD_LEFT);
			if($i === 0)
				$decbin = substr($decbin, strpos($decbin, '1') + 1);
			if($i + 1 == $l)
				$decbin = substr($decbin, 0, strrpos($decbin, '1'));
			$bin .= $decbin;
			while(($c = self::huffmanentry($bin, $dict, $dictlen)) !== null)
				$res .= $c;
		}
		return $res;
	}
	function huffmantable($length, $n, $max = 15) {
		$count = array();
		$symbol = array();
		$error = 0;

		for($l = 0; $l <= $max; ++$l)
			$count[$l] = 0;
		for($sym = 0; $sym < $n; ++$sym)
			++$count[$length[$sym]];
		if($count[0] != $n) {
			$left = 1;
			for($l = 1; $l <= $max; ++$l) {
				$left <<= 1;
				$left -= $count[$l];
				if($left < 0) {
					$error = $left;
					break;
				}
			}
			if($left >= 0) {
				$offs = array(1 => 0);
				for($l = 1; $l < $max; ++$l)
					$offs[$l + 1] = $offs[$l] + $count[$l];
				for($sym = 0; $sym < $n; ++$sym)
					if($length[$sym] != 0)
						$symbol[$offs[$length[$sym]]++] = $sym;
				$error = $left;
			}
		}
		return array(
			'count'  => $count,
			'symbol' => $symbol,
			'error'  => $error
		);
	}

	public static function xorcrypt($string, $key){
		return $string ^ str::equlen($string, $key);
	}
	public static function xorhash($string, $length = 1){
		$hash = substr($string, 0, $length);
		for($i = $length; isset($string[$i]); $i += $length)
			$hash ^= str_pad(substr($string, $i, $length), $length, "\0");
		return $hash;
	}

	public static function UI8SI8($number){
		return $number < 0x80 ? $number : $number - 0x100;
	}
	public static function UI16SI16($number){
		return $number < 0x8000 ? $number : $number - 0x10000;
	}
	public static function UI32SI32($number){
		return $number < 0x80000000 ? $number : $number - 0x100000000;
	}
	public static function UI64SI64($number){
		return $number < 0x8000000000000000 ? 0x7fffffffffffffff  - $number : $number;
	}
	public static function UIBCD8($number){
		return ($number >> 4) * 10 + ($number & 0xf);
	}
	public static function strbe($number, $min = 1, $sync = null, $signed = null){
		if($number < 0)
			new APError('Crypt strbe', 'number must be greater than or equal to 0', APError::WARNING, APError::TTHROW);
		$mask = $sync || $signed ? 0x7F : 0xFF;
		$str = '';
		if($signed === true)
			$number = $number & (0x80 << (8 * ($min - 1)));
		while($number != 0) {
			$quot = ($number / ($mask + 1));
			$str = chr(ceil(($quot - floor($quot)) * $mask)) . $str;
			$number = floor($quot);
		}
		return str_pad($str, $min, "\0", STR_PAD_LEFT);
	}
	public static function strle($number, $min = null, $sync = null) {
		$str = '';
		while($number > 0) {
			if($sync === true) {
				$str .= chr($number & 127);
				$number >>= 7;
			}else{
				$str .= chr($number & 255);
				$number >>= 8;
			}
		}
		return str_pad($str, $min, "\0", STR_PAD_RIGHT);
	}
	public static function intbe($word, $sync = null, $signed = null){
		$res = 0;
		$l = strlen($word);
		if($l === 0)
			return false;
		for($i = 0; $i < $l; ++$i)
			if($sync === true)
				$res += (ord($word[$i]) & 0x7F) * pow(2, ($l - 1 - $i) * 7);
			else
				$res += ord($word[$i]) * pow(256, ($l - 1 - $i));
		if($signed === true && $sync !== true)
			if($bytewordlen <= PHP_INT_SIZE) {
				$mask = 0x80 << (8 * ($l - 1));
				if($res & $mask)
					$res = 0 - ($res & ($mask - 1));
			}else
				new APError('intbe', 'Cannot have signed integers larger than '.(8 * PHP_INT_SIZE).'-bits ('.$l.')', APError::WARNING, APError::TTHROW);
		return $res;
	}
	public static function intle($word, $signed = null){
		return self::intbe(strrev($word), false, $signed === true);
	}

	const BOOM_ASCII = '';
	const BOOM_UTF8 = "\xEF\xBB\xBF";
	const BOOM_UTF16BE = "\xFE\xFF";
	const BOOM_UTF16LE = "\xFF\xFE";
	const BOOM_UTF32BE = "\0\0\xFE\xFF";
	const BOOM_UTF32LE = "\xFF\xFE\0\0";
	const BOOM_UTF7_1 = "\x2B\x2F\x76\x38";
	const BOOM_UTF7_2 = "\x2B\x2F\x76\x39";
	const BOOM_UTF7_3 = "\x2B\x2F\x76\x2B";
	const BOOM_UTF7_4 = "\x2B\x2F\x76\x2F";
	const BOOM_UTF7_5 = "\x2B\x2F\x76\x38\x2D";
	const BOOM_UTF1 = "\xF7\x64\x4C";
	const BOOM_UTF_EBCSIC = "\xDD\x73\x66\x73";
	const BOOM_SCSU = "\x0E\xFE\xFF";
	const BOOM_BOCU1 = "\xFB\xEE\x28";
	const BOOM_GB18030 = "\x84\x31\x95\x33";
	public static $caret_notation_chars = array(
		'^@', '^A', '^B', '^C', '^D', '^E', '^F', '^G', '^H',
		'^I', '^J', '^K', '^L', '^M', '^N', '^O', '^P', '^Q',
		'^R', '^S', '^T', '^U', '^V', '^W', '^X', '^Y', '^Z',
		'^[', '^]', '^^', '^_', 127 => '^?'
	);
	public static function caret_notation_encode($string){
		$bytes = range("\0", "\x1F");
		$bytes[] = "\x7F";
		return str_replace($bytes, self::$caret_notation_chars, $string);
	}
	public static function caret_notation_decode($string){
		$bytes = range("\0", "\x1F");
		$bytes[] = "\x7F";
		return str_replace(self::$caret_notation_chars, $bytes, $string);
	}

	public static function utf8encode($data){
		if(__apeip_data::$instUTF8)
			return utf8_encode($data);
		$utf8 = '';
		for($i = 0; isset($data[$i]); ++$i)
			if(($char = ord($data[$i])) < 128)
				// 0bbbbbbb
				$utf8 = $data[$i];
			elseif($char < 2048)
				// 110bbbbb 10bbbbbb
				$utf8 .= chr(($char >>   6) | 0xC0)
					   . chr(($char & 0x3F) | 0x80);
			elseif($char < 65536)
				// 1110bbbb 10bbbbbb 10bbbbbb
				$utf8 .= chr(($char >>  12) | 0xE0)
					   . chr(($char >>   6) | 0xC0)
					   . chr(($char & 0x3F) | 0x80);
			else
				// 11110bbb 10bbbbbb 10bbbbbb 10bbbbbb
				$utf8 .= chr(($char >>  18) | 0xF0)
					   . chr(($char >>  12) | 0xC0)
					   . chr(($char >>   6) | 0xC0)
					   . chr(($char & 0x3F) | 0x80);
		return $utf8;
	}
	public static function utf8decode($data){
		if(__apeip_data::$instUTF8)
			return utf8_decode($data);
		$string = '';
		for($i = 0; isset($data[$i]);) {
			if((($h = ord($data[$i])) | 0x07) == 0xF7) {
				// 11110bbb 10bbbbbb 10bbbbbb 10bbbbbb
				$char = (($h & 0x07) << 18) &
						((ord($data[$i + 1]) & 0x3F) << 12) &
						((ord($data[$i + 2]) & 0x3F) <<  6) &
						 (ord($data[$i + 3]) & 0x3F);
				$i += 4;
			}elseif(($h | 0x0F) == 0xEF) {
				// 1110bbbb 10bbbbbb 10bbbbbb
				$char = (($h & 0x0F) << 12) &
						((ord($data[$i + 1]) & 0x3F) <<  6) &
						 (ord($data[$i + 2]) & 0x3F);
				$i += 3;
			}elseif(($h | 0x1F) == 0xDF) {
				// 110bbbbb 10bbbbbb
				$char = (($h & 0x1F) <<  6) &
						 (ord($data[$i + 1]) & 0x3F);
				$i += 2;
			}elseif(($h | 0x7F) == 0x7F) {
				// 0bbbbbbb
				$string .= $data[$i];
				++$i;
				continue;
			}else{
				// error
				++$i;
				continue;
			}
			$string .= $char < 256 ? chr($char) : '?';
		}
		return $string;
	}
	public static function utf16beencode($data){
		$utf16be = '';
		for($i = 0; isset($data[$i]); ++$i)
			$utf16be .= "\0" . $data[$i];
		return $utf16be;
	}
	public static function utf16leencode($data){
		$utf16le = '';
		for($i = 0; isset($data[$i]); ++$i)
			$utf16le .= $data[$i] . "\0";
		return $utf16le;
	}
	public static function utf16bedecode($data){
		$string = '';
		for($i = 0; isset($data[$i + 1]); ++$i)
			$string .= $data[$i] == "\0" ? $data[$i + 1] : '?';
		return $string;
	}
	public static function utf16ledecode($data){
		$string = '';
		for($i = 0; isset($data[$i + 1]); ++$i)
			$string .= $data[$i + 1] == "\0" ? $data[$i] : '?';
		return $string;
	}

	const KEYBOARD_CONVERTER_AKAN 	  = "`\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\nɛ\nw\ne\nr\nt\ny\nu\ni\no\np\nq\nc\na\ns\nd\nf\ng\nh\nj\nk\nl\n;\n'\n\\\nz\nx\nɔ\nv\nb\nn\nm\n,\n.\n/\n~\n!\n@\n#\n$\n%\n^\n&\n*\n(\n)\n_\n+\nƐ\nW\nE\nR\nT\nY\nU\nI\nO\nP\nQ\nC\nA\nS\nD\nF\nG\nH\nJ\nK\nL\n:\n\"\n|\nZ\nX\nƆ\nV\nB\nN\nM\n<\n>\n?";
	const KEYBOARD_CONVERTER_ALBANIAN = "\\\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\nq\nw\ne\nr\nt\nz\nu\ni\no\np\nç\n@\na\ns\nd\nf\ng\nh\nj\nk\nl\në\n[\n]\ny\nx\nc\nv\nb\nn\nm\n,\n.\n/\n|\n!\n\"\n#\n$\n%\n^\n&\n*\n(\n)\n_\n+\nQ\nW\nE\nR\nT\nZ\nU\nI\nO\nP\nÇ\n'\nA\nS\nD\nF\nG\nH\nJ\nK\nL\nË\n{\n}\nY\nX\nC\nV\nB\nN\nM\n;\n:\n?";
	const KEYBOARD_CONVERTER_ARABIC   = "ذ\n١\n٢\n٣\n٤\n٥\n٦\n٧\n٨\n٩\n٠\n-\n=\nض\nص\nث\nق\nف\nغ\nع\nه\nخ\nح\nج\nد\nش\nس\nي\nب\nل\nا\nت\nن\nم\nك\nط\n\\\nئ\nء\nؤ\nر\nلا\nى\nة\nو\nز\nظ\nّ\n!\n@\n#\n$\n%\n^\n&\n*\n)\n(\n_\n+\nَ\nً\nُ\nٌ\nﻹ\nإ\n’\n÷\n×\n؛\n>\n<\nِ\nٍ\n]\n[\nلأ\nأ\nـ\n،\n/\n:\n\"\n|\n~\nْ\n{\n}\nلآ\nآ\n‘\n,\n.\n؟";
	const KEYBOARD_CONVERTER_AZERI	= "`\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\nq\nü\ne\nr\nt\ny\nu\ni\no\np\nö\nğ\na\ns\nd\nf\ng\nh\nj\nk\nl\nı\nə\n\\\nz\nx\nc\nv\nb\nn\nm\nç\nş\n.\n~\n!\n\"\nⅦ\n;\n%\n:\n?\n*\n(\n)\n_\n+\nQ\nÜ\nE\nR\nT\nY\nU\nİ\nO\nP\nÖ\nĞ\nA\nS\nD\nF\nG\nH\nJ\nK\nL\nI\nƏ\n/\nZ\nX\nC\nV\nB\nN\nM\nÇ\nŞ\n,";
	const KEYBOARD_CONVERTER_BANGLA   = "`\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\nৃ\nৌ\nৈ\nা\nী\nূ\nব\nহ\nগ\nদ\nজ\nড\n়\nো\nে\n্\nি\nু\nপ\nর\nক\nত\nচ\nট\n\\\n\nং\nম\nন\nব\nল\nস\n,\n.\nয\n~\n!\n\n\n\n\n\n\n\n(\n)\nঃ\nঋ\nঔ\nঐ\nআ\nঈ\nঊ\nভ\nঙ\nঘ\nধ\nঝ\nঢ\nঞ\nও\nএ\nঅ\nই\nউ\nফ\n\nখ\nথ\nছ\nঠ\n|\n\nঁ\nণ\n\n\n\nশ\nষ\n{\nয়";
	const KEYBOARD_CONVERTER_COPTIC   = "̈\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n·\n⸗\nⲑ\nⲱ\nⲉ\nⲣ\nⲧ\nⲯ\nⲩ\nⲓ\nⲟ\nⲡ\n[\n]\nⲁ\nⲥ\nⲇ\nⲫ\nⲅ\nⲏ\nϫ\nⲕ\nⲗ\n;\nʼ\ǹⲍ\nⲝ\nⲭ\nϣ\nⲃ\nⲛ\nⲙ\n,\n.\ń\n̑\n̄\n̆\nʹ\n͵\ṅ\ṇ\nⳤ\n*\n(\n)\n-\n̅\nⲐ\nⲰ\nⲈ\nⲢ\nⲦ\nⲮ\nⲨ\nⲒ\nⲞ\nⲠ\n{\n}\nⲀ\nⲤ\nⲆ\nⲪ\nⲄ\nⲎ\nϪ\nⲔ\nⲖ\n:\n⳿\n|\nⲌ\nⲜ\nⲬ\nϢ\nⲂ\nⲚ\nⲘ\n<\n>\n⳾";
	const KEYBOARD_CONVERTER_CROATIAN = "ş\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n'\n+\nq\nw\ne\nr\nt\nz\nu\ni\no\np\nš\nđ\na\ns\nd\nf\ng\nh\nj\nk\nl\nč\nć\nž\ny\nx\nc\nv\nb\nn\nm\n,\n.\n-\nÄ\n!\n\"\n#\n$\n%\n&\n/\n(\n)\n=\n?\n*\nQ\nW\nE\nR\nT\nZ\nU\nI\nO\nP\nŠ\nĐ\nA\nS\nD\nF\nG\nH\nJ\nK\nL\nČ\nĆ\nŽ\nY\nX\nC\nV\nB\nN\nM\n;\n:\n_";
	const KEYBOARD_CONVERTER_ENGLISH  = "`\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\nq\nw\ne\nr\nt\ny\nu\ni\no\np\n[\n]\na\ns\nd\nf\ng\nh\nj\nk\nl\n;\n'\n\\\nz\nx\nc\nv\nb\nn\nm\n,\n.\n/\n~\n!\n@\n#\n$\n%\n^\n&\n*\n(\n)\n_\n+\nQ\nW\nE\nR\nT\nY\nU\nI\nO\nP\n{\n}\nA\nS\nD\nF\nG\nH\nJ\nK\nL\n:\n\"\n|\nZ\nX\nC\nV\nB\nN\nM\n<\n>\n?";
	const KEYBOARD_CONVERTER_FARSI	= "`‍‍‍\n۱\n۲\n۳\n۴\n۵\n۶\n۷\n۸\n۹\n۰\n-\n=\nض\nص\nث\nق\nف\nغ\nع\nه\nخ\nح\nج\nچ\nش\nس\nی\nب\nل\nا\nت\nن\nم\nک\nگ\n\\\nظ\nط\nز\nر\nذ\nد\nپ\nو\n.\n/\n~\n!\n٫\n؍\n﷼\n٪n\×\n٬\n٭\n(\n)\n_\n+\nْ\nٌ\nٍ\nً\nُ\nِ\nَ\nّ\n[\n]\n{\n}\nؤ\nُ\nي\nإ\nأ\nآ\nة\n«\n»\n:\n؛\n|\nك\nٓ\nژ\nٰ\n‌\nٔ\nء\n<\n>\n؟";
	const KEYBOARD_CONVERTER_FRENCH   = "²\n&\né\n\"\n'\n(\n-\nè\n_\nç\nà\n)\n=\na\nz\ne\nr\nt\ny\nu\ni\no\np\nâ\n$\nq\ns\nd\nf\ng\nh\nj\nk\nl\nm\nù\n*\nw\nx\nc\nv\nb\nn\n,\n;\n:\n!\n\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n°\n+\nA\nZ\nE\nR\nT\nY\nU\nI\nO\nP\nÄ\n£\nQ\nS\nD\nF\nG\nH\nJ\nK\nL\nM\n%\nµ\nW\nX\nC\nV\nB\nN\n?\n.\n/\n§";
	const KEYBOARD_CONVERTER_GEORGIAN = "„\n!\n?\n№\n§\n%\n:\n.\n;\n,\n/\n–\n=\nღ\nჯ\nუ\nკ\nე\nნ\nგ\nშ\nწ\nზ\nხ\nც\nფ\nძ\nვ\nთ\nა\nპ\nრ\nო\nლ\nდ\nჟ\n(\nჭ\nჩ\nყ\nს\nმ\nი\nტ\nქ\nბ\nჰ\n“\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n+\nღ\nჯ\nუ\nკ\nე\nნ\nგ\nშ\nწ\nზ\nხ\nც\nფ\nძ\nვ\nთ\nა\nპ\nრ\nო\nლ\nდ\nჟ\n)\nჭ\nჩ\nყ\nს\nმ\nი\nტ\nქ\nბ\nჰ";
	const KEYBOARD_CONVERTER_GREEK	= "`\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\n;\nς\nε\nρ\nτ\nυ\nθ\nι\nο\nπ\n[\n]\nα\nσ\nδ\nφ\nγ\nη\nξ\nκ\nλ\nέ\n'\n\\\nζ\nχ\nψ\nω\nβ\nν\nμ\n,\n.\n/\n~\n!\n@\n#\n$\n%\n^\n&\n*\n(\n)\n_\n+\n:\n\nΕ\nΡ\nΤ\nΥ\nΘ\nΙ\nΟ\nΠ\n{\n}\nΑ\nΣ\nΔ\nΦ\nΓ\nΗ\nΞ\nΚ\nΛ\nΪ\n\n\"\n|\nΖ\nΧ\nΨ\nΩ\nΒ\nΝ\nΜ\n<\n>\n?";
	const KEYBOARD_CONVERTER_GUJARATI = "\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\nૌ\nૈ\nા\nી\nૂ\nબ\nહ\nગ\nદ\nજ\nડ\n઼\nો\nે\n્\nિ\nુ\nપ\nર\nક\nત\nચ\nટ\nૉ\n\nં\nમ\nન\nવ\nલ\nસ\n,\n.\nય\n\nઍ\nૅ\n\n\n\n\n\n\n(\n)\nઃ\nઋ\nઔ\nઐ\nઆ\nઈ\nઊ\nભ\nઙ\nઘ\nધ\nઝ\nઢ\nઞ\nઓ\nએ\nઅ\nઇ\nઉ\nફ\n\nખ\nથ\nછ\nઠ\nઑ\n\nઁ\nણ\n\n\nળ\nશ\nષ\n।\n";
	const KEYBOARD_CONVERTER_HEBREW   = ";\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\n/\n'\nק\nר\nא\nט\nו\nן\nם\nפ\n]\n[\nש\nד\nג\nכ\nע\nי\nח\nל\nך\nף\n,\\\nז\nס\nב\nה\nנ\nמ\nצ\nת\nץ\n.\n~\n!\n@\n#\n$\n%\n^\n&\n*\n)\n(\n_\n+\n<\n>\nקּ\nרּ\nאּ\nטּ\nוּ\nןּ\nּ\nפּ\n}\n{\nשּ\nדּ\nגּ\nכּ\n׳\nיּ\n״\nלּ\nךּ\n:\n\"\n|\nזּ\nסּ\nבּ\nהּ\nנּ\nמּ\nצּ\nתּ\n׆\n?";
	const KEYBOARD_CONVERTER_HINDI	= "\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\nृ\nौ\nै\nा\nी\nू\nब\nह\nग\nद\nज\nड\n़\nो\nे\n्\nि\nु\nप\nर\nक\nत\nच\nट\nॉ\n\nं\nम\nन\nव\nल\nस\n,\n.\nय\n\nऍ\nॅ\n#\n$\n\n\n\n\n(\n)\nः\nऋ\nऔ\nऐ\nआ\nई\nऊ\nभ\nङ\nघ\nध\nझ\nढ\nञ\nओ\nए\nअ\nइ\nउ\nफ\nऱ\nख\nथ\nछ\nठ\nऑ\n\nँ\nण\n\n\nळ\nश\nष\n।\nय़";
	const KEYBOARD_CONVERTER_JAPANESE = "ろ\nぬ\nふ\nあ\nう\nえ\nお\nや\nゆ\nよ\nわ\nほ\nへ\nた\nて\nい\nす\nか\nん\nな\nに\nら\nせ\n゛\n゜\nち\nと\nし\nは\nき\nく\nま\nの\nり\nれ\nけ\nむ\nつ\nさ\nそ\nひ\nこ\nみ\nも\nね\nる\nめ\n\n\nぁ\nぅ\nぇ\nぉ\nゃ\nゅ\nょ\nを\nー\n\n\n\nぃ\n\n\n\n\n\n\n\n「\n」\n\n\n\n\n\n\n\n\n\n\n\n\nっ\n\n\n\n\n\n\n、\n。\n・";
	const KEYBOARD_CONVERTER_KAZAKH   = "(\n\"\nә\nі\nң\nғ\n,\n.\nү\nұ\nқ\nө\nһ\nй\nц\nу\nк\nе\nн\nг\nш\nщ\nз\nх\nъ\nф\nы\nв\nа\nп\nр\nо\nл\nд\nж\nэ\n\\\nя\nч\nс\nм\nи\nт\nь\nб\nю\n№\n)\n!\nӘ\nІ\nҢ\nҒ\n;\n:\nҮ\nҰ\nҚ\nӨ\nҺ\nЙ\nЦ\nУ\nК\nЕ\nН\nГ\nШ\nЩ\nЗ\nХ\nЪ\nФ\nЫ\nВ\nА\nП\nР\nО\nЛ\nД\nЖ\nЭ\n/\nЯ\nЧ\nС\nМ\nИ\nТ\nЬ\nБ\nЮ\n?";
	const KEYBOARD_CONVERTER_KHMER	= "«\n១\n២\n៣\n៤\n៥\n៦\n៧\n៨\n៩\n០\nគ\nធ\nឆ\nឹ\nេ\nរ\nត\nយ\nុ\nិ\nោ\nផ\nៀ\nឨ\nា\nស\nដ\nថ\nង\nហ\n្\nក\nល\nើ\n់\nឮ\nឋ\nខ\nច\nវ\nប\nន\nម\nំុ\n។\n៊​\n»\n!\nៗ\n\"\n៛\n%\n៌\n័\n៏\n(\n)\n៝\nឪ\nឈ\nឺ\nែ\nឬ\nទ\nួ\nូ\nី\nៅ\nភ\nឿ\nឧ\nាំ\nៃ\nឌ\nធ\nឣ\nះ\nញ\nគ\nឡ\nោៈ\n៉\nឭ\nឍ\nឃ\nជ\nេះ\nព\nណ\nំ\nុះ\n៕\n?";
	const KEYBOARD_CONVERTER_KOREAN   = "`\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\nㅂ\nㅈ\nㄷ\nㄱ\nㅅ\nㅛ\nㅕ\nㅑ\nㅐ\nㅔ\n[\n]\nㅁ\nㄴ\nㅇ\nㄹ\nㅎ\nㅗ\nㅓ\nㅏ\nㅣ\n;\n'\n\\\nㅋ\nㅌ\nㅊ\nㅍ\nㅠ\nㅜ\nㅡ\n,\n.\n/\n~\n!\n@\n#\n$\n%\n^\n&\n*\n(\n)\n_\n+\nㅃ\nㅉ\nㄸ\nㄲ\nㅆ\n\n\n\nㅒ\nㅖ\n{\n}\n\n\n\n\n\n\n\n\n\n:\n\"\n|\n\n\n\n\n\n\n\n<\n>\n?";
	const KEYBOARD_CONVERTER_LAO	  = "*\nຢ\nຟ\nໂ\nຖ\nຸ\n\nູຄ\nຕ\nຈ\nຂ\nຊ\nໍ\nົ\nໄ\nຳ\nພ\nະ\nິ\nີ\nຮ\nນ\nຍ\nບ\nລ\nັ\nຫ\nກ\nດ\nເ\n້\n່\nາ\nສ\nວ\nງ\n“\nຜ\nປ\nແ\nອ\nຶ\nື\nທ\nມ\nໃ\nຝ\n/\n໑\n໒\n໓\n໔\n໌\nຼ\n໕\n໖\n໗\n໘\n໙\nໍ່\nົ້\n໐\nຳ້\n_\n+\nິ້\nີ້\nຣ\nໜ\nຽ\n-\nຫຼ\nັ້\n;\n.\n,\n:\n໊\n໋\n!\n?\n%\n=\n”\n₭\n(\nຯ\nx\nຶ້\nື້\nໆ\nໝ\n$\n)";
	const KEYBOARD_CONVERTER_MALAYALAM= "ൊ\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\nൃ\nൌ\nൈ\nാ\nീ\nൂ\nബ\nഹ\nഗ\nദ\nജ\nഡ\nർ\nോ\nേ\n്\nിു\nപ\nര\nക\nത\nച\nട\n\nെ\nം\nമ\nന\nവ\nല\nസ\n,\n.\nയ\nഒ\n\n\n\n\n\n\n\n\n(\n)\nഃ\nഋ\nഔ\nഐ\nആ\nഈ\nഊ\nഭ\nങ\nഘ\nധ\nഝ\nഢ\nഞ\nഓ\nഏ\nഅ\nഇ\nഉ\nഫ\nറ\nഖ\nഥ\nഛ\nഠ\n\nഎ\n\nണ\n\nഴ\nള\nശ\nഷ\n\n\n";
	const KEYBOARD_CONVERTER_RUSSIAN  = "ё\n1\n2\n3\n4\n5\n6\n7\n8\n9\n0\n-\n=\nй\nц\nу\nк\nе\nн\nг\nш\nщ\nз\nх\nъ\nф\nы\nв\nа\nп\nр\nо\nл\nд\nж\nэ\n\\\nя\nч\nс\nм\nи\nт\nь\nб\nю\n.\n!\n\"\n№\n;\n%\n:\n?\n*\n(\n)\n_\n+\nЙ\nЦ\nУ\nК\nЕ\nН\nГ\nШ\nЩ\nЗ\nХ\nЪ\nФ\nЫ\nВ\nА\nП\nР\nО\nЛ\nД\nЖ\nЭ\n/\nЯ\nЧ\nС\nМ\nИ\nТ\nЬ\nБ\nЮ\n,";
	private static function kcglks($lang){
		switch($lang){
			case 'AK': case "AKAN": return self::KEYBOARD_CONVERTER_AKAN; break;
			case 'AL': case "ALBANIAN": return self::KEYBOARD_CONVERTER_ALBANIAN; break;
			case 'AR': case "ARABIC": return self::KEYBOARD_CONVERTER_ARABIC; break;
			case 'AZ': case "AZERI": return self::KEYBOARD_CONVERTER_AZERI; break;
			case 'BA': case "BANGLA": return self::KEYBOARD_CONVERTER_BANGLA; break;
			case 'CO': case "COPTIC": return self::KEYBOARD_CONVERTER_COPTIC; break;
			case 'CR': case "CROATIAN": return self::KEYBOARD_CONVERTER_CROATIAN; break;
			case 'EN': case "ENGLISH": return self::KEYBOARD_CONVERTER_ENGLISH; break;
			case 'FA': case "FARSI": return self::KEYBOARD_CONVERTER_FARSI; break;
			case 'FR': case "FRENCH": return self::KEYBOARD_CONVERTER_FRENCH; break;
			case 'GE': case "GEORGIAN": return self::KEYBOARD_CONVERTER_GEORGIAN; break;
			case 'GR': case "GREEK": return self::KEYBOARD_CONVERTER_GREEK; break;
			case 'GU': case "GUJARATI": return self::KEYBOARD_CONVERTER_GUJARATI; break;
			case 'HE': case "HEBREW": return self::KEYBOARD_CONVERTER_HEBREW; break;
			case 'HI': case "HINDI": return self::KEYBOARD_CONVERTER_HINDI; break;
			case 'JA': case "JAPANESE": return self::KEYBOARD_CONVERTER_JAPANESE; break;
			case 'KA': case "KAZAKH": return self::KEYBOARD_CONVERTER_KAZAKH; break;
			case 'KH': case "KHMER": return self::KEYBOARD_CONVERTER_KHMER; break;
			case 'KO': case "KOREAN": return self::KEYBOARD_CONVERTER_KOREAN; break;
			case 'LA': case "LAO": return self::KEYBOARD_CONVERTER_LAO; break;
			case 'MA': case "MALAYALAM": return self::KEYBOARD_CONVERTER_MALAYALAM; break;
			case 'RU': case "RUSSIAN": return self::KEYBOARD_CONVERTER_RUSSIAN; break;
			default: return false;
		}
	}
	public static function keyconv($text, $from, $to){
		$from = strtoupper($from);
		$to = strtoupper($to);
		$from = self::kcglks($from);
		if($from === false){
			new APError('Crypt keyconv', 'Invalid from keyboard language', APError::WANING);
			return false;
		}
		$to = self::kcglks($to);
		if($to === false){
			new APError('Crypt keyconv', 'Invalid to keyboard language', APError::WANING);
			return false;
		}
		return str_replace(explode("\n", $from), explode("\n", $to), $text);
	}
	public static function keyget($text){
		$len = strlen($text);
		$coding = '';
		foreach(array('AK', 'AL', 'AR', 'AZ', 'BA', 'CO', 'CR', 'EN', 'FA', 'FR', 'GE',
					  'GR', 'GU', 'HE', 'HI', 'JA', 'KA', 'KH', 'KO', 'LA', 'MA', 'RU') as $lang)
			if(($now = strlen(str_replace(explode("\n", self::kcglks($lang)), '', $text))) < $len){
				$len = $now;
				$coding = $lang;
			}
		return $coding === '' ? false : $coding;
	}

	public static function roman2number($str){
		$number = 0;
		$values = array(
			'M' => 1000,
			'D' => 500,
			'C' => 100,
			'L' => 50,
			'X' => 10,
			'V' => 5,
			'I' => 1
		);
		$str = strtr($str, array(
			'CM' => 'DCCCC',
			'CD' => 'CCCC',
			'XC' => 'LXXXX',
			'XL' => 'XXXX',
			'IX' => 'VIIII',
			'IV' => 'IIII'
		));
		foreach($values as $r => $n)
			$number += $n * substr_count($str, $r);
		return $number;
	}
	public static function number2roman($number){
		if($number > 4999 || $number < 0)
			return false;
		$str = '';
		$values = array(
			'M' => 1000,
			'D' => 500,
			'C' => 100,
			'L' => 50,
			'X' => 10,
			'V' => 5,
			'I' => 1
		);
		foreach($values as $r => $n) {
			$str .= str_repeat($r, floor($number / $n));
			$number = $number % $n;
		}
		return strtr($str, array(
			'DCCCC' => 'CM',
			'CCCC' => 'CD',
			'LXXXX' => 'XC',
			'XXXX' => 'XL',
			'VIIII' => 'IX',
			'IIII' => 'IV'
		));
	}

	public static function rot($string, $n = 13){
		$letters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
		$n = (int)$n % 26;
		if(!$n)return $string;
		if($n < 0)$n += 26;
		if($n == 13 && function_exists('str_rot13'))
			return str_rot13($string);
		$replacement = substr($letters, $n * 2) . substr($letters, 0, $n * 2);
		return strtr($string, $letters, $replacement);
	}
	public static function unrot($string, $n = 13){
		$letters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
		$n = (int)$n % 26;
		if(!$n)return $string;
		if($n < 0)$n += 26;
		if($n == 13 && function_exists('str_rot13'))
			return str_rot13($string);
		$replacement = substr($letters, $n * 2) . substr($letters, 0, $n * 2);
		return strtr($string, $replacement, $letters);
	}

	const MAKE_TABLE_RANDOM = 0;
	const MAKE_TABLE_ODD = 1;
	const MAKE_TABLE_EVEN = 2;
	const MAKE_TABLE_MT = 3;
	const MAKE_TABLE_CALLABLE = 4;
	public static function makeTable($n = null, $l = 256, $algorithm = 2, $inv = false){
		if($inv === true){
			$table = self::makeTable($n, $l, $algorithm);
			$inv = array_combine($table, array_keys($table));
			ksort($inv, SORT_NUMERIC);
			return array($table, $inv);
		}
		if($n === null)
			$n = $l + 1;
		if($algorithm == self::MAKE_TABLE_RANDOM){
			$table = range(0, $l - 1);
			shuffle($table);
			return $table;
		}
		if($algorithm == self::MAKE_TABLE_MT){
			srand($n);
			$table = range(0, $l - 1);
			shuffle($table);
			srand();
			return $table;
		}
		if($algorithm == self::MAKE_TABLE_EVEN){
			$n *= 2;
			$ll = $l;
			$l = 1 << ceil(log($l, 2));
			$table = array_map(function($x)use($n, $l){
				return ($x ^ ($n * $x)) % $l;
			}, range(0, $l - 1));
			for(;$ll < $l; ++$ll)
				unset($table[array_search($ll, $table)]);
			return array_values($table);
		}
		if($algorithm == self::MAKE_TABLE_CALLABLE){
			$table = array();
			for($i = 0; $i < $l; ++$i)
				$table[$i] = $n($i) % $l;
			if($table !== $d = array_unique($table))
				new APError('Crypt::MakeTable', 'Callable not is one2one function', APError::WARNING, APError::TTHROW);
			return $table;
		}
		$n *= 2;
		++$n;
		while($l % $n == 0)++$n;
		$n %= $l;
		if($l % $n == 0)return self::makeTable($n, $l, $inv, self::MAKE_TABLE_EVEN);
		return array_map(function($x)use($n, $l){
			return $n * $x % $l;
		}, range(0, $l - 1));
	}

	protected static $tws = array(
		array(
			0xbe, 0x85, 0x27, 0x6b, 0xa0, 0xc3, 0x91, 0x39, 0x26, 0x28, 0x09, 0xb9, 0xee, 0x6f, 0x62, 0x87,
			0xe5, 0xde, 0xa6, 0xc9, 0xb3, 0x34, 0x8a, 0x7c, 0x86, 0xdf, 0x25, 0xd7, 0x8b, 0xe0, 0x13, 0x8e,
			0xaf, 0x95, 0xc4, 0xd9, 0x44, 0x81, 0x36, 0x15, 0x6e, 0x5b, 0xb4, 0x7b, 0xc5, 0x08, 0x17, 0x63,
			0xda, 0x02, 0x50, 0xd2, 0xbd, 0x21, 0xf9, 0x12, 0xcb, 0xf0, 0x7a, 0x11, 0x88, 0x6d, 0x7f, 0x45,
			0xff, 0x3e, 0x0e, 0xf2, 0x06, 0x4f, 0x20, 0x7d, 0x9d, 0x92, 0x59, 0xeb, 0x89, 0x76, 0xe3, 0x05,
			0x2d, 0x74, 0x98, 0x2b, 0x5e, 0xb7, 0x80, 0xa8, 0xec, 0x78, 0x54, 0x1a, 0xd5, 0x32, 0x18, 0xb8,
			0x58, 0x9c, 0xfb, 0x30, 0x47, 0x0b, 0xf1, 0xb1, 0xd4, 0x5a, 0x71, 0x51, 0x65, 0x38, 0x60, 0x5c,
			0x01, 0x77, 0xce, 0x10, 0xa2, 0x1e, 0x2f, 0x9b, 0xbc, 0x99, 0x6c, 0x4c, 0xcf, 0x52, 0xc2, 0x48,
			0xf6, 0x41, 0xcd, 0xed, 0xaa, 0x04, 0xfd, 0xca, 0x2c, 0xae, 0x9e, 0xea, 0x82, 0x5d, 0x0f, 0x1d,
			0xe6, 0x9f, 0x3d, 0xf7, 0x57, 0x55, 0xef, 0xd0, 0x1c, 0xb0, 0xf3, 0x00, 0xdd, 0x68, 0x3a, 0xa7,
			0x66, 0x3c, 0x14, 0x16, 0xd3, 0x8c, 0x3f, 0xf8, 0xd8, 0xfc, 0xc7, 0xf5, 0x94, 0xac, 0xe7, 0xbb,
			0xb6, 0xcc, 0x93, 0xfe, 0x79, 0xd6, 0x4a, 0xb2, 0x40, 0x42, 0x8d, 0x29, 0x1f, 0xfa, 0x73, 0x07,
			0xa5, 0x03, 0xe8, 0x4e, 0x23, 0xa1, 0x6a, 0x24, 0xbf, 0xc0, 0x31, 0x2e, 0x70, 0x64, 0x33, 0xb5,
			0x4b, 0x75, 0x3b, 0x72, 0x37, 0x1b, 0x83, 0xdc, 0xe4, 0xa9, 0x2a, 0xab, 0x46, 0x8f, 0xc6, 0x19,
			0x5f, 0x35, 0x4d, 0x43, 0x97, 0xba, 0xe2, 0xdb, 0xe1, 0x96, 0x53, 0x67, 0x61, 0x49, 0xc1, 0x90,
			0x84, 0x9a, 0xa3, 0xad, 0xd1, 0x7e, 0x56, 0xf4, 0xa4, 0x0a, 0xc8, 0x69, 0x0d, 0x0c, 0xe9, 0x22
		), array(
			0xab, 0xda, 0x3f, 0xeb, 0x19, 0x6f, 0xe3, 0x47, 0x39, 0xde, 0x3c, 0x2b, 0x2a, 0xd5, 0x66, 0xc0,
			0x58, 0xae, 0x81, 0x85, 0x8b, 0x06, 0x1c, 0xa1, 0xba, 0x1e, 0x17, 0xd0, 0xd4, 0x55, 0xaa, 0xf7,
			0xb5, 0x29, 0xec, 0xcf, 0x37, 0xed, 0xce, 0xd7, 0xe5, 0x62, 0x38, 0x14, 0xf9, 0x96, 0x0c, 0x4a,
			0x35, 0x90, 0x98, 0xe0, 0x92, 0x8e, 0x70, 0xa5, 0x26, 0xc6, 0x4e, 0x00, 0x0a, 0x4c, 0x65, 0xa6,
			0xe8, 0x57, 0xf0, 0x6c, 0x28, 0x7d, 0x93, 0x0f, 0xa7, 0x75, 0x99, 0x18, 0x16, 0x59, 0x56, 0x82,
			0xa2, 0xea, 0xb7, 0x76, 0xd6, 0x78, 0xef, 0x09, 0x07, 0x91, 0x3b, 0x08, 0xbd, 0xe1, 0x7b, 0xa0,
			0x6e, 0x49, 0x5a, 0xc8, 0x1d, 0xbb, 0x60, 0x5c, 0x36, 0x40, 0xc2, 0xf2, 0xe7, 0x8c, 0x4f, 0x2e,
			0x8a, 0xc5, 0x94, 0x45, 0xee, 0xb1, 0xbc, 0x27, 0xfd, 0xf6, 0xb0, 0x5f, 0x6d, 0xb8, 0xb6, 0x64,
			0x13, 0x3e, 0x12, 0x84, 0xc9, 0x30, 0xca, 0x6b, 0x79, 0x3d, 0x73, 0x0d, 0x15, 0x2d, 0xfc, 0xaf,
			0x83, 0xb4, 0x86, 0xfb, 0x2f, 0x4b, 0x23, 0x7c, 0x6a, 0x03, 0xbe, 0x74, 0x68, 0xd9, 0x01, 0xa9,
			0x31, 0xfa, 0x42, 0xb2, 0x54, 0x11, 0x67, 0x89, 0xdd, 0x5e, 0x95, 0x51, 0xbf, 0x43, 0x8f, 0x32,
			0x04, 0x5b, 0x9f, 0x97, 0x0b, 0x69, 0x72, 0xc1, 0xf4, 0xb9, 0x80, 0x21, 0x20, 0x1a, 0x25, 0xdf,
			0x8d, 0xf3, 0x7e, 0x9e, 0xd3, 0xfe, 0xf8, 0x4d, 0x7a, 0xa8, 0x44, 0x22, 0x9b, 0x88, 0x9a, 0xac,
			0x1f, 0xd2, 0xcc, 0x3a, 0x34, 0xe4, 0x53, 0xd1, 0x9d, 0xdb, 0x5d, 0x63, 0x24, 0xad, 0x05, 0x61,
			0xb3, 0x9c, 0xff, 0x1b, 0xf5, 0x52, 0xa4, 0x0e, 0x02, 0xc4, 0xc7, 0x87, 0x71, 0x77, 0xf1, 0x2c,
			0x33, 0xdc, 0xe9, 0x50, 0x7f, 0xc3, 0x46, 0xa3, 0xe6, 0xcb, 0x48, 0xe2, 0xcd, 0xd8, 0x41, 0x10
		), array(
			0x75, 0xb6, 0x20, 0x8c, 0xfa, 0x21, 0xfd, 0xbc, 0x2c, 0x03, 0xe3, 0x57, 0x0f, 0xb1, 0x61, 0xd0,
			0x60, 0x07, 0x6e, 0xb5, 0x25, 0x27, 0x9c, 0x19, 0xc8, 0x9e, 0x80, 0xc5, 0x7f, 0x32, 0x2e, 0xc0,
			0x18, 0x39, 0x2a, 0x4b, 0xd5, 0x56, 0xba, 0xc9, 0x7a, 0x22, 0x37, 0x3b, 0x55, 0x36, 0x83, 0xa2,
			0x0e, 0x12, 0x1d, 0xb9, 0xf6, 0x86, 0x5f, 0x05, 0xbe, 0x14, 0x2f, 0xe9, 0x8d, 0x4d, 0x0b, 0x66,
			0x3f, 0xeb, 0x68, 0x4e, 0x48, 0x44, 0x16, 0xed, 0xf9, 0x51, 0x9b, 0x82, 0xb7, 0x0c, 0x8a, 0x74,
			0x02, 0xe6, 0xf0, 0xd1, 0xf2, 0xd4, 0x1b, 0x6f, 0x1e, 0xec, 0xda, 0x59, 0xc7, 0xa7, 0x30, 0x8e,
			0xb2, 0x70, 0x10, 0x5e, 0x5a, 0x09, 0x50, 0x63, 0xee, 0xb0, 0x15, 0x5c, 0x24, 0x33, 0x5d, 0xb4,
			0xac, 0xaf, 0xe2, 0x77, 0x8b, 0x0a, 0xa9, 0xbf, 0x47, 0x95, 0x38, 0xe4, 0x9d, 0xf8, 0x88, 0xcc,
			0x9f, 0x49, 0x7c, 0xaa, 0x00, 0x54, 0x53, 0x94, 0xb3, 0x65, 0x6d, 0x52, 0xbb, 0x01, 0x1f, 0x85,
			0x45, 0x0d, 0x04, 0xc6, 0xad, 0x6a, 0xf1, 0xcb, 0xb8, 0x29, 0x06, 0x35, 0xe8, 0xf7, 0x7e, 0x08,
			0xdd, 0xef, 0x99, 0x73, 0x3e, 0x62, 0xcf, 0xdf, 0x26, 0xf5, 0xde, 0xa8, 0xa1, 0xe1, 0x17, 0xd2,
			0xce, 0xea, 0x6c, 0xcd, 0x1c, 0x97, 0xa0, 0xae, 0xab, 0x78, 0x13, 0x1a, 0x71, 0x69, 0x41, 0x64,
			0x2d, 0xc4, 0xc3, 0x4f, 0x46, 0x90, 0x81, 0x76, 0x67, 0xf4, 0x7b, 0x4a, 0x98, 0x84, 0x87, 0xa4,
			0xf3, 0x96, 0xd8, 0xdc, 0x79, 0x92, 0xa6, 0x2b, 0x58, 0x9a, 0x6b, 0xe7, 0x7d, 0xd3, 0xa3, 0xc1,
			0xff, 0xe5, 0x42, 0xd6, 0xfb, 0x11, 0x31, 0xca, 0x34, 0x23, 0x40, 0xd9, 0xfc, 0x3a, 0xdb, 0x93,
			0x28, 0xd7, 0x72, 0x89, 0xa5, 0xc2, 0x8f, 0x3d, 0x43, 0xbd, 0xfe, 0x3c, 0xe0, 0x5b, 0x91, 0x4c
		), array(
			0x9b, 0x70, 0x31, 0xc1, 0x85, 0x4f, 0x44, 0xbf, 0x2d, 0x0a, 0xf9, 0x65, 0xfd, 0xfc, 0x42, 0x8e,
			0x73, 0x3b, 0x37, 0x1e, 0xa2, 0x27, 0xa3, 0x2e, 0x5e, 0xdf, 0x5b, 0xd5, 0x98, 0x8f, 0x75, 0xbc,
			0x46, 0x35, 0xff, 0xc4, 0xc7, 0x1a, 0x08, 0x02, 0x09, 0xbb, 0xda, 0x53, 0x88, 0x50, 0xcb, 0x76,
			0x63, 0xca, 0x5d, 0xce, 0x15, 0xe1, 0x26, 0xd4, 0x6d, 0x07, 0x9e, 0xd2, 0xa1, 0x92, 0x41, 0xa6,
			0xb8, 0x81, 0xb9, 0xe3, 0x24, 0x3f, 0xdc, 0x64, 0x7f, 0xed, 0xb6, 0xd0, 0x7b, 0xe2, 0xc3, 0x45,
			0x32, 0x6b, 0x7d, 0xea, 0x5a, 0x95, 0xf6, 0x94, 0x60, 0x4a, 0x69, 0x29, 0x6f, 0x8d, 0x54, 0xe0,
			0x6e, 0xec, 0x0e, 0x2f, 0xcd, 0x6c, 0xa0, 0xeb, 0x9d, 0xfb, 0xc6, 0x03, 0x7a, 0x3d, 0x28, 0x0d,
			0xcc, 0x6a, 0xd3, 0xbe, 0x51, 0xd1, 0x4d, 0x71, 0x59, 0xb4, 0x3a, 0x2b, 0x17, 0x47, 0xf5, 0x3e,
			0x56, 0x25, 0x8c, 0xd6, 0xf0, 0x01, 0x18, 0x0f, 0x3c, 0x4c, 0x16, 0x1c, 0xa5, 0xba, 0x1f, 0xdd,
			0xef, 0x06, 0x49, 0xb2, 0xac, 0x21, 0xe9, 0xe4, 0x52, 0x79, 0xf1, 0x77, 0x61, 0x48, 0x8a, 0x91,
			0x04, 0xc5, 0x74, 0xf2, 0xf8, 0xc0, 0x12, 0x9f, 0x57, 0xd9, 0x84, 0xdb, 0xad, 0xf3, 0x89, 0x20,
			0x99, 0x67, 0xb7, 0x14, 0x2a, 0xcf, 0xb0, 0x55, 0x5f, 0x0b, 0xe5, 0xaf, 0x78, 0x34, 0x00, 0xc8,
			0xc9, 0xee, 0x7e, 0x05, 0x22, 0x2c, 0xde, 0xaa, 0xfa, 0x13, 0x87, 0x38, 0xb1, 0x82, 0x72, 0x7c,
			0x97, 0xf4, 0x33, 0xa4, 0x68, 0x5c, 0xb5, 0x1b, 0xa8, 0x23, 0x30, 0xe7, 0xd7, 0x9c, 0x11, 0x19,
			0x1d, 0xe8, 0xe6, 0x4e, 0xd8, 0x10, 0x90, 0xae, 0xc2, 0xfe, 0x8b, 0x4b, 0x58, 0x83, 0x0c, 0x96,
			0x39, 0x66, 0x43, 0x9a, 0xf7, 0xab, 0x80, 0x93, 0xa7, 0x36, 0xbd, 0x62, 0xa9, 0x86, 0xb3, 0x40
		), array(
			0x3b, 0x9e, 0xe8, 0x99, 0xb0, 0xde, 0x15, 0x58, 0x5b, 0x57, 0x3c, 0xb4, 0x2e, 0x8b, 0xe7, 0x47,
			0xff, 0xa5, 0x82, 0x80, 0x2b, 0x8c, 0x4c, 0x1a, 0x4b, 0x04, 0xbd, 0xe3, 0x16, 0x64, 0x19, 0xd0,
			0xbc, 0xbb, 0xcb, 0x96, 0xdc, 0xbe, 0x38, 0x77, 0x44, 0x21, 0x0c, 0x0b, 0xef, 0x8d, 0x6f, 0x94,
			0x85, 0xa0, 0xaf, 0xf0, 0xd4, 0x30, 0x68, 0x24, 0x2a, 0x08, 0xd3, 0x5a, 0x0a, 0x89, 0x81, 0x02,
			0x69, 0xfe, 0xa2, 0xad, 0xca, 0x73, 0xf6, 0x07, 0xfa, 0x61, 0x2f, 0x95, 0x3d, 0xc7, 0x3a, 0x6e,
			0xf3, 0xab, 0xe5, 0xd6, 0xa4, 0x1d, 0x4e, 0x41, 0x10, 0x4d, 0x62, 0xb1, 0x67, 0xda, 0xa9, 0x7b,
			0x66, 0xdf, 0x29, 0xdb, 0x7f, 0x3e, 0x0e, 0xa6, 0x9c, 0xb5, 0x98, 0x87, 0x43, 0x7c, 0x60, 0x05,
			0x36, 0xec, 0xb6, 0x8a, 0x9b, 0x49, 0x53, 0xed, 0x55, 0x88, 0xc8, 0x5e, 0x97, 0x45, 0xc2, 0xf4,
			0xba, 0x12, 0x4f, 0x90, 0x83, 0x13, 0x92, 0xeb, 0xcd, 0xa7, 0x70, 0x14, 0x6d, 0xc0, 0x35, 0xae,
			0x31, 0x59, 0x34, 0x46, 0x72, 0xaa, 0x2d, 0xb3, 0x32, 0x4a, 0xce, 0xcc, 0xe1, 0xd8, 0xc3, 0xb2,
			0x5f, 0x17, 0x50, 0xf7, 0xe6, 0x37, 0x3f, 0x48, 0xc9, 0x9f, 0x1e, 0x00, 0xcf, 0xdd, 0x11, 0x8f,
			0x7a, 0x75, 0xa3, 0xe0, 0x91, 0x20, 0x7e, 0x52, 0x7d, 0xb9, 0x18, 0x65, 0x76, 0x5c, 0x9a, 0xac,
			0x0f, 0xb7, 0x6a, 0xf5, 0xe9, 0x71, 0x39, 0xea, 0x63, 0x84, 0x86, 0xf9, 0xd2, 0xfc, 0x26, 0x23,
			0x1b, 0xd7, 0xd1, 0xc4, 0x1c, 0x0d, 0x54, 0x27, 0xfd, 0x9d, 0x01, 0xd9, 0xf1, 0xa8, 0x09, 0xbf,
			0x33, 0x5d, 0xfb, 0x06, 0xd5, 0x28, 0xf8, 0x6c, 0x40, 0xf2, 0x51, 0x03, 0x22, 0x25, 0x74, 0x56,
			0x42, 0xee, 0x6b, 0xc1, 0xb8, 0xe4, 0x79, 0x1f, 0xc6, 0x2c, 0xa1, 0x93, 0x8e, 0x78, 0xc5, 0xe2
		), array(
			0x84, 0x8d, 0x50, 0x09, 0x92, 0x37, 0x9a, 0x11, 0x9f, 0x65, 0x75, 0x3e, 0x4d, 0x91, 0x30, 0x0c,
			0x62, 0xe5, 0x31, 0xba, 0x39, 0x6a, 0x46, 0xae, 0x20, 0x17, 0xbb, 0x56, 0xb4, 0x32, 0x58, 0x8e,
			0x02, 0x05, 0x29, 0xe9, 0x6c, 0x14, 0xa8, 0x15, 0xf0, 0x99, 0x22, 0xd7, 0x08, 0xc0, 0x1e, 0x3a,
			0x5e, 0xe6, 0x1d, 0x6d, 0xe8, 0x9b, 0x2d, 0x2a, 0x7a, 0x21, 0xed, 0x2b, 0xfb, 0xf7, 0xa4, 0x40,
			0xea, 0xbe, 0xe2, 0xf8, 0x45, 0x90, 0xc4, 0x78, 0x44, 0x81, 0xcb, 0x23, 0xff, 0x3d, 0x43, 0xc3,
			0x66, 0x49, 0x8b, 0x86, 0x85, 0x2c, 0x25, 0x0b, 0xd8, 0x5b, 0x64, 0xfd, 0x6b, 0x6e, 0x63, 0x36,
			0x10, 0x0e, 0xa5, 0x67, 0xbf, 0x89, 0x3f, 0xc8, 0x42, 0xbd, 0x95, 0xda, 0xb2, 0x8a, 0x12, 0x57,
			0x61, 0xbc, 0xf2, 0xa3, 0x4f, 0x00, 0xc7, 0x73, 0xb9, 0xd4, 0x28, 0xca, 0x82, 0xdc, 0x9e, 0x1c,
			0x1a, 0xc6, 0x4b, 0x2e, 0xcd, 0x8f, 0x35, 0xce, 0x7e, 0xf3, 0x4e, 0x74, 0x03, 0x3c, 0x5f, 0xf6,
			0xc5, 0xfe, 0xd5, 0xef, 0x87, 0x79, 0xd1, 0xb5, 0xcc, 0xa2, 0xd9, 0x4a, 0x16, 0x7c, 0x19, 0x80,
			0xb6, 0xac, 0x2f, 0xde, 0xcf, 0xf4, 0xd6, 0x5d, 0xab, 0x76, 0x83, 0xb8, 0x70, 0x94, 0xb7, 0x71,
			0x69, 0x0d, 0x60, 0x88, 0x6f, 0x13, 0x01, 0x4c, 0x98, 0x33, 0x26, 0x8c, 0x07, 0xf9, 0x38, 0x77,
			0x1f, 0xdf, 0xf5, 0xc2, 0xc1, 0x1b, 0x93, 0x5c, 0x18, 0x27, 0xe7, 0x97, 0x7f, 0xb3, 0xb0, 0xa6,
			0x0f, 0x53, 0xaf, 0xdd, 0x55, 0x24, 0xe3, 0xf1, 0xd2, 0xeb, 0x5a, 0xee, 0xd3, 0xa0, 0xaa, 0xa7,
			0xfc, 0xad, 0x72, 0x0a, 0x7b, 0xe1, 0x51, 0xdb, 0x9c, 0x3b, 0xb1, 0x41, 0x59, 0x47, 0x68, 0xa1,
			0x52, 0x96, 0x54, 0xd0, 0xc9, 0xa9, 0x34, 0x9d, 0x7d, 0x48, 0x04, 0xe4, 0xec, 0x06, 0xfa, 0xe0
		)
	);
	protected static $tww = array(
		0xae, 0xde, 0xdf, 0xcc, 0x3b, 0xc1, 0x0a, 0x63, 0x45, 0x31, 0x6b, 0xc6, 0x77, 0x51, 0xe1, 0x5c,
		0xf9, 0xfa, 0x65, 0x07, 0xdb, 0xd2, 0x6a, 0x83, 0x44, 0x61, 0x4c, 0xbf, 0x1f, 0x52, 0x7d, 0xb3,
		0xd4, 0xf0, 0x99, 0x54, 0x05, 0x21, 0x67, 0x86, 0xa4, 0x6f, 0x9d, 0x5b, 0x13, 0xf1, 0x12, 0x68,
		0x1a, 0x2e, 0x7a, 0x0c, 0x2d, 0x56, 0x59, 0xc5, 0x5e, 0xdc, 0xf7, 0x26, 0x48, 0xd8, 0xa2, 0x4e,
		0x95, 0x93, 0xf2, 0x9a, 0xb7, 0x97, 0xc8, 0x0b, 0x64, 0x58, 0x60, 0xc3, 0x4f, 0x22, 0x5d, 0x73,
		0x2f, 0x5f, 0x88, 0x3c, 0x06, 0x20, 0xf6, 0x9f, 0x92, 0x47, 0x8d, 0xcf, 0xad, 0xe0, 0x28, 0xaa,
		0xe4, 0xee, 0xfd, 0x69, 0xa0, 0x78, 0x1e, 0xed, 0xc7, 0x27, 0x7e, 0xc9, 0x35, 0x40, 0xb9, 0xf4,
		0x79, 0x33, 0xc2, 0x49, 0xea, 0x1b, 0x7f, 0xca, 0x0e, 0xeb, 0x6d, 0x87, 0xfc, 0x94, 0xce, 0xd0,
		0x50, 0x82, 0x53, 0x8c, 0xd7, 0x2b, 0x3e, 0x38, 0xff, 0x09, 0xec, 0xaf, 0x4a, 0x23, 0x39, 0x66,
		0xa6, 0x0f, 0xd9, 0x14, 0x4b, 0x9e, 0x9c, 0xd5, 0x04, 0xb2, 0xdd, 0xab, 0x7b, 0xe8, 0x37, 0x91,
		0xb6, 0x0d, 0xa5, 0xef, 0x74, 0x41, 0xe7, 0x8e, 0x55, 0x8b, 0xac, 0xd3, 0xcb, 0xbc, 0x62, 0x16,
		0x00, 0xfe, 0x76, 0x72, 0x19, 0x2c, 0x3a, 0x1d, 0x3f, 0x10, 0xb4, 0x2a, 0x15, 0x6c, 0x8a, 0xda,
		0x08, 0xe5, 0x85, 0x96, 0x57, 0xb5, 0x71, 0x6e, 0xc0, 0xe2, 0x89, 0xe9, 0x01, 0x02, 0x9b, 0x32,
		0x3d, 0xe3, 0x17, 0x75, 0x34, 0x5a, 0x43, 0xbd, 0xd6, 0x11, 0x25, 0x7c, 0x90, 0xfb, 0x30, 0xb1,
		0xb8, 0xa9, 0xa7, 0x84, 0xd1, 0xe6, 0x24, 0x81, 0xf3, 0x03, 0xbb, 0xba, 0x29, 0xa3, 0x98, 0xf8,
		0x46, 0xa8, 0x80, 0x18, 0xcd, 0x36, 0x4d, 0xb0, 0xc4, 0x42, 0x70, 0xa1, 0x8f, 0xbe, 0x1c, 0xf5
	);
	public static function twist_encode($message, $rounds = 1){
		$length = strlen($message);
		if($length === 0)return '';
		$s = self::$tws;
		$w = self::$tww;
		$iv = $w[$rounds & 0xff];
		if($length === 1)
			return chr($s[1][((ord($message) ^ $iv) + $rounds) & 0xff]);
		$message = array_values(unpack('C*', $message));
		$l1 = $length - 1;
		for($round = 0; $round < $rounds; ++$round)
			for($i = 0; $i < $length; ++$i){
				for($j = 0; $j < $rounds; ++$j){
					$n = $i * $iv;
					$loc = $box = 0;
					if($i == 0)$loc = 1;
					$loc = ($j * $box + $loc + $n + $s[0][$message[$loc]]) % $l1;
					if($loc >= $i)++$loc;
					$box = ($j * $loc + $box + $n + $s[3][$message[$loc]]) % 6;
					$loc = ($j * $box + $loc + $n + $s[5][$message[$loc]]) % $l1;
					if($loc >= $i)++$loc;
					$box = ($j * $loc + $box + $n + $s[2][$message[$loc]]) % 6;
					$n1 = $n + $j * $loc;
					$n2 = $n + $j * $box;
					$loc1 = ($box + $loc + $n2 + $s[4][$message[$loc]]) % $l1;
					if($loc1 >= $i)++$loc1;
					$box1 = ($loc1 + $box + $n1 + $s[1][$message[$loc]]) % 6;
					$loc2 = ($box1 + $loc + $n2 + $s[4][$message[$loc1]]) % $l1;
					if($loc2 >= $i)++$loc2;
					$box2 = ($loc2 + $box + $n1 + $s[2][$message[$loc]]) % 6;
					$loc3 = ($box2 + $loc + $n2 + $s[0][$message[$loc2]]) % $l1;
					if($loc3 >= $i)++$loc3;
					$box3 = ($loc3 + $box + $n1 + $s[3][$message[$loc]]) % 6;
					$loc1 = ($box3 + $loc + $n2 + $s[5][$message[$loc3]]) % $l1;
					if($loc1 >= $i)++$loc1;
					$box1 = ($loc2 + $box1 + $n1 + $n2 + $w[$message[$loc]]) % 6;

					$message[$i]^= (($s[$box2][$message[$loc3]] ^ $s[$box1][$message[$loc1]]) + $s[$box3][$message[$loc2]]) & 0xff;
					$message[$i] = (($s[$box2][$message[$i]] ^ $s[$box3][$message[$loc2]]) + $s[$box1][$message[$loc3]]) & 0xff;
					$message[$i] = (($s[$box3][$message[$loc2]] ^ $s[$box2][$message[$loc3]]) + $s[$box1][$message[$i]] + $s[$box][$message[$loc]] + $iv) & 0xff;
					$message[$i] = (($s[$box3][$message[$i]] ^ $s[$box2][$message[$loc2]]) + $s[$box3][$message[$loc1]]) & 0xff;
					$message[$i]^= (($s[$box1][$message[$loc3]] ^ $s[$box2][$message[$loc2]]) + $s[$box1][$message[$loc1]]) & 0xff;
					$message[$i] = $s[$box][$message[$i] ^ $iv];
				}
			}
		array_unshift($message, 'C*');
		return call_user_func_array('pack', $message);
	}
	public static function twist_decode($message, $rounds = 1){
		$length = strlen($message);
		if($length === 0)return '';
		$s = self::$tws;
		$w = self::$tww;
		$iv = $w[$rounds & 0xff];
		if($length === 1){
			$message = $s[4][ord($message)] - $rounds;
			if($message < 0)$message += 256;
			return chr($message ^ $iv);
		}
		$message = array_values(unpack('C*', $message));
		$l1 = $length - 1;
		for($round = 0; $round < $rounds; ++$round)
			for($i = $l1; $i >= 0; --$i){
				for($j = $rounds - 1; $j >= 0; --$j){
					$n = $i * $iv;
					$loc = $box = 0;
					if($i == 0)$loc = 1;
					$loc = ($j * $box + $loc + $n + $s[0][$message[$loc]]) % $l1;
					if($loc >= $i)++$loc;
					$box = ($j * $loc + $box + $n + $s[3][$message[$loc]]) % 6;
					$loc = ($j * $box + $loc + $n + $s[5][$message[$loc]]) % $l1;
					if($loc >= $i)++$loc;
					$box = ($j * $loc + $box + $n + $s[2][$message[$loc]]) % 6;
					$n1 = $n + $j * $loc;
					$n2 = $n + $j * $box;
					$loc1 = ($box + $loc + $n2 + $s[4][$message[$loc]]) % $l1;
					if($loc1 >= $i)++$loc1;
					$box1 = ($loc1 + $box + $n1 + $s[1][$message[$loc]]) % 6;
					$loc2 = ($box1 + $loc + $n2 + $s[4][$message[$loc1]]) % $l1;
					if($loc2 >= $i)++$loc2;
					$box2 = ($loc2 + $box + $n1 + $s[2][$message[$loc]]) % 6;
					$loc3 = ($box2 + $loc + $n2 + $s[0][$message[$loc2]]) % $l1;
					if($loc3 >= $i)++$loc3;
					$box3 = ($loc3 + $box + $n1 + $s[3][$message[$loc]]) % 6;
					$loc1 = ($box3 + $loc + $n2 + $s[5][$message[$loc3]]) % $l1;
					if($loc1 >= $i)++$loc1;
					$box1 = ($loc2 + $box1 + $n1 + $n2 + $w[$message[$loc]]) % 6;
					$un = ($box + 3) % 6;
					$un1 = ($box1 + 3) % 6;
					$un2 = ($box2 + 3) % 6;
					$un3 = ($box3 + 3) % 6;

					$message[$i]   = $s[$un][$message[$i]] ^ $iv;
					$message[$i]   ^= (($s[$box1][$message[$loc3]] ^ $s[$box2][$message[$loc2]]) + $s[$box1][$message[$loc1]]) & 0xff;
					$message[$i]   -= $s[$box3][$message[$loc1]];
					if($message[$i] < 0)$message[$i] += 256;
					$message[$i]   ^= $s[$box2][$message[$loc2]];
					$message[$i]	= $s[$un3][$message[$i]];
					$message[$i]   -= ($s[$box3][$message[$loc2]] ^ $s[$box2][$message[$loc3]]) + $s[$box][$message[$loc]] + $iv;
					if($message[$i] < 0)$message[$i] = $message[$i] % 256 + 256;
					$message[$i]	= $s[$un1][$message[$i]];
					$message[$i]   -= $s[$box1][$message[$loc3]];
					if($message[$i] < 0)$message[$i] += 256;
					$message[$i]   ^= $s[$box3][$message[$loc2]];
					$message[$i]	= $s[$un2][$message[$i]];
					$message[$i]   ^= (($s[$box2][$message[$loc3]] ^ $s[$box1][$message[$loc1]]) + $s[$box3][$message[$loc2]]) & 0xff;
				}
			}
		array_unshift($message, 'C*');
		return call_user_func_array('pack', $message);
	}
	public static function twist_shuffle($message, $n = null, $algorithm = 2){
		$table = self::makeTable($n, strlen($message), $algorithm);
		return implode('', array_map(function($x)use($message){
			return $message[$x];
		}, $table));
	}
	public static function twist_unshuffle($message, $n = null, $algorithm = 2){
		$table = self::makeTable($n, strlen($message), $algorithm, true);
		return implode('', array_map(function($x)use($message){
			return $message[$x];
		}, $table[1]));
	}

	public static function endianness($x){
		$r = '';
		for($i = strlen($x) - 1; $i >= 0; --$i) {
			$b = ord($x[$i]);
			$p1 = ($b * 0x0802) & 0x22110;
			$p2 = ($b * 0x8020) & 0x88440;
			$r .= chr((($p1 | $p2) * 0x10101) >> 16);
		}
		return $r;
	}
	public static function quarterRound(&$a, &$b, &$c, &$d){
		$a += $b;$d ^= $a;$d = (($d << 16) & 0xffffffff) | ($d >> 16);
		$c += $d;$b ^= $c;$b = (($b << 12) & 0xffffffff) | ($b >> 20);
		$a += $b;$d ^= $a;$d = (($d << 8)  & 0xffffffff) | ($d >> 24);
		$c += $d;$b ^= $c;$b = (($b << 7)  & 0xffffffff) | ($b >> 25);
	}
	public static function doubleRound(&$x0, &$x1, &$x2, &$x3, &$x4, &$x5, &$x6, &$x7, &$x8, &$x9, &$x10, &$x11, &$x12, &$x13, &$x14, &$x15){
		self::quarterRound($x0, $x4, $x8,  $x12);
		self::quarterRound($x1, $x5, $x9,  $x13);
		self::quarterRound($x2, $x6, $x10, $x14);
		self::quarterRound($x3, $x7, $x11, $x15);
		self::quarterRound($x0, $x5, $x10, $x15);
		self::quarterRound($x1, $x6, $x11, $x12);
		self::quarterRound($x2, $x7, $x8,  $x13);
		self::quarterRound($x3, $x4, $x9,  $x14);
	}

	public static function codings(){
		return array(
			'bin', 'base4', 'oct', 'hex', 'base32', 'base64', 'bcrypt64', 'nsec3', 'url', 'twist'
		);
	}

	public static function ezmlm(string $addr){
		if(function_exists('ezmlm_hash'))
			return ezmlm_hash($addr);
		$addr = strtolower($addr);
		$h = 5381;
		for($j = 0; isset($addr[$j]); ++$j)
			$h = ($h + ($h << 5)) ^ ord($addr[$j]);
		return $h % 53;
	}

	public static function isbin($bin){return is_string($bin) && str_replace(array(0, 1), '', $bin) === '';}
	public static function isoct($oct){return is_string($oct) && str_replace(array(0, 1, 2, 3, 4, 5, 6, 7), '', $oct) === '';}
	public static function isdec($dec){return is_string($dec) && str_replace(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), '', $dec) === '';}
	public static function isfdec($dec){return is_string($dec) && str_replace(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '.'), '', $dec) === '';}
	public static function ishex($hex){return is_string($hex) && str_replace(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), '', $hex) === '';}
	public static function isbase4($base4){return is_string($base4) && str_replace(array(0, 1, 2, 3), '', $base4) === '';}
	public static function isbase32($base32){return is_string($base32) && str_replace(str_split(str::BASE32_RANGE), '', $base32) === '';}
	public static function isbase64($base64){return is_string($base64) && str_replace(str_split(str::BASE64_RANGE), '', $base64) === '';}
	public static function isbase64url($base64url){return is_string($base64url) && str_replace(str_split(str::BASE64URL_RANGE), '', $base64url) === '';}
	public static function isbcrypt32($bcrypt64){return is_string($bcrypt64) && str_replace(str_split(str::BCRYPT32_RANGE), '', $bcrypt64) === '';}
	public static function isnsec3($nsec3){return is_string($nsec3) && str_replace(str_split(str::NSEC3_RANGE), '', $nsec3) === '';}

	public static function parseUUID($UUID){
		$UUID = explode('-', $UUID, 6);
		if(!isset($UUID[4]) || isset($UUID[5])){
			new APError('crypt parseUUID', 'Invalid UUID code', APError::NOTIC);
			return false;
		}
		if(strlen($UUID[0]) != 8 || strlen($UUID[1]) != 4 || strlen($UUID[2]) != 4 || strlen($UUID[3]) != 4 || strlen($UUID[4]) != 12 ||
		   $UUID[2][0] != '1' || $UUID[3][0] != 'a')return false;
		$UUID[0] = array_value(unpack('N', crypt::hexdecode($UUID[0])), 1);
		$UUID[1] = array_value(unpack('n', crypt::hexdecode($UUID[1])), 1);
		$UUID[2] = array_value(unpack('n', crypt::hexdecode($UUID[2])), 1);
		$UUID[3] = array_value(unpack('n', crypt::hexdecode($UUID[3])), 1);
		$UUID[4] = crypt::hexdecode($UUID[4]);
		return $UUID;
	}
	public static function inet_ntop($ip){
		if(__apeip_data::$instInetTo)
			return inet_ntop($ip);
		if(strlen($ip) == 4)
			return implode('.', unpack("C4", $ip));
		elseif(strlen($ip) == 16)
			return implode(':', unpack("H4H4H4H4H4H4H4H4", $ip));
		new APError('inet_ntop', 'Invalid ip_addr value', APError::WARNING);
		return false;
	}
	public static function inet_pton($ip){
		if(__apeip_data::$instInetTo)
			return inet_pton($ip);
		if(net::isipv6($ip)){
			$ip = explode('.', $ip);
			if(!isset($ip[3]) || isset($ip[4]))return false;
			return pack("C4", $ip[0], $ip[1], $ip[2], $ip[3]);
		}elseif(net::isipv4($ip)){
			$ip = explode('.', $ip);
			if(!isset($ip[7]) || isset($ip[8]))return false;
			return pack("H4H4H4H4H4H4H4H4", $ip[0], $ip[1], $ip[2], $ip[3], $ip[4], $ip[5], $ip[6], $ip[7]);
		}return false;
	}
	public static function inet_rev($ip){
		if(net::isipv6($ip))
			return implode(':', array_reverse(explode(':', $ip)));
		elseif(net::isipv4($ip))
			return implode('.', array_reverse(explode('.', $ip)));
		return false;
	}

	public static function strength($password){
		$chars = count_chars($password, 3);
		sort($chars);
		$chars = implode('', $chars);
		$l = strlen($password);
		$c = strlen($chars);
		$strength = pow($l / 2, $c / 2);
		for($i = 0; $i < $l; ++$i){
			$n = $i + 1 == $l ? 0 : $i + 1;
			$p = $i == 0 ? $l - 1 : $i - 1;
			$n = strpos($chars, $password[$n]);
			$p = strpos($chars, $password[$p]);
			$h = strpos($chars, $password[$i]);
			$strength += abs($h - $n) / 2 + abs($h - $p) / 2 + abs($n - $h) / 3;
		}
		return $strength;
	}

	public static function diffie_hellman_key($a, $b, $g = array(0, 255), $p = array(0, 255)){
		if(is_array($g))$g = bnc::prand($g[0], $g[1]);
		if(is_array($p))$p = bnc::prand($p[0], $p[1]);
		$A = bnc::powmod($g, $a, $p);
		$B = bnc::powmod($g, $b, $p);
		if(pow($A, $a) < pow($B, $b))
			$s = bnc::powmod($A, $b, $p);
		else
			$s = bnc::powmod($B, $a, $p);
		return array(
			'a' => $a,
			'b' => $b,
			'g' => $g,
			'p' => $p,
			'A' => $A,
			'B' => $B,
			's' => $s
		);
	}
	public static function merkle_hellman_key($w, $q = null, $r = null){
		if($q === null)$q = array_sum($w) + rand(1, max($w));
		if($r === null || $r < 1 || $r >= $q)
			$r = rand(1, $q - 1);
		$b = array();
		for($i = 0; isset($w[$i]); ++$i)
			$b[$i] = $w[$i] * $r % $q;
		return array(
			'w' => $w,
			'b' => $b,
			'q' => $q,
			'r' => $r,
			'l' => count($w)
		);
	}
	public static function markle_hellman_encrypt($m, $a){
		$m = str_pad(substr(decbin($m), -$a['l']), $a['l'], '0', STR_PAD_LEFT);
		$c = 0;
		for($i = 0; isset($m[$i]); ++$i)
			$c += $m[$i] * $a['b'][$i];
		return $c;
	}
	public static function markle_hellman_decrypt($c, $a){
		$c = $c * math::modInv($a['r'], $a['q']) % $a['q'];
		$m = str_repeat('0', $a['l']);
		while(true){
			$r = 0;
			$l = -1;
			for($i = 0; isset($a['w'][$i]); ++$i)
				if($a['w'][$i] <= $c && $a['w'][$i] > $r){
					$r = $a['w'][$i];
					$l = $i;
				}
			if($l == -1)break;
			$c -= $r;
			$m[$l] = '1';
			if($c <= 0)break;
		}
		return bindec($m);
	}
	public static function elgamal_key($g, $q, $x, $y = null){
		if($y === null){
			$g = $x;
			$y = bnc::rand('1', $x);
			$x = bnc::rand('1', $x);
		}
		$c1 = bnc::powf($g, $y);
		$h = bnc::powf($h, $x);
		$s = bnc::powf($h, $y);
		return array(
			'G' => isset($g) ? $g : max($g, $q, $x, $y),
			'g' => $g,
			'q' => $q,
			'c1' => $c1,
			'h' => $h,
			's' => $s,
		);
	}
	public static function elgamal_encrypt($m, $a){
		return bnc::mul($m, $a['s']);
	}
	public static function elgamal_decrypt($c2, $a){
		return bnc::div($c2, $a['s'], 0);
	}
	public static $FIPS_186_3 = array(
		array(1024, 160),
		array(2048, 224),
		array(2048, 256),
		array(3072, 256)
	);
	public static function fingerprint($key, $algo = 'sha256'){
		switch($algo){
			case 'sha256':
				return substr(self::base64encode(self::hash('sha256', $key)), 0, -1);
			case 'sha1':
				return substr(chunk_split(self::hash('sha1', $key), 2, ':'), 0, -1);
			case 'md5':
				return substr(chunk_split(md5($key), 2, ':'), 0, -1);
		}
		return false;
	}

	public static function string_to_word8($string){
		return array_values(unpack('C*', $string));
	}
	public static function word8_to_string($word8){
		array_unshift($word8, 'C*');
		return call_user_func_array('pack', $word8);
	}
	public static function string_to_word16be($string){
		return array_map(function($x){
			$res = unpack('n', $x);
			return $res[1];
		}, str_split($string, 2));
	}
	public static function string_to_word16le($string){
		return array_map(function($x){
			$res = unpack('v', $x);
			return $res[1];
		}, str_split($string, 2));
	}
	public static function word8_to_word16le($word8){
		$word16 = array();
		for($i = 0; isset($word8[$i]); $i += 2)
			$word16[$i / 2] = isset($word8[$i + 1]) ? $word8[$i] | ($word8[$i + 1] << 8) : $word8[$i];
		return $word16;
	}
	public static function word8_to_word16be($word8){
		$word16 = array();
		for($i = 0; isset($word8[$i]); $i += 2)
			$word16[$i / 2] = isset($word8[$i + 1]) ? ($word8[$i] << 8) | $word8[$i + 1] : $word8[$i] << 8;
		return $word16;
	}
	public static function word16be_to_string($word16){
		return implode('', array_map(function($x){
			return pack('n', $x);
		}, $word16));
	}
	public static function word16le_to_string($word16){
		return implode('', array_map(function($x){
			return pack('v', $x);
		}, $word16));
	}
	public static function word16le_to_word8($word16){
		$word8 = array();
		for($i = 0; isset($word16[$i]); ++$i){
			$word8[$i * 2] = $word16[$i] & 0xff;
			$word8[$i * 2 + 1] = $word16[$i] >> 8;
		}
		return $word8;
	}
	public static function word16be_to_word8($word16){
		$word8 = array();
		for($i = 0; isset($word16[$i]); ++$i){
			$word8[$i * 2] = $word16[$i] >> 8;
			$word8[$i * 2 + 1] = $word16[$i] & 0xff;
		}
		return $word8;
	}
	public static function string_to_word32be($string){
		return array_map(function($x){
			$res = unpack('N', $x);
			return $res[1];
		}, str_split($string, 4));
	}
	public static function string_to_word32le($string){
		return array_map(function($x){
			$res = unpack('V', $x);
			return $res[1];
		}, str_split($string, 4));
	}
	public static function word8_to_word32be($word8){
		$word32 = array();
		for($i = 0; isset($word8[$i]); $i += 4){
			$word = $word8[$i] << 24;
			if(isset($word8[$i + 1]))$word |= $word8[$i + 1] << 16;
			if(isset($word8[$i + 2]))$word |= $word8[$i + 2] << 8;
			if(isset($word8[$i + 3]))$word |= $word8[$i + 3];
			$word32[$i / 4] = $word;
		}
		return $word32;
	}
	public static function word8_to_word32le($word8){
		$word32 = array();
		for($i = 0; isset($word8[$i]); $i += 4){
			$word = $word8[$i];
			if(isset($word8[$i + 1]))$word |= $word8[$i + 1] << 8;
			if(isset($word8[$i + 2]))$word |= $word8[$i + 2] << 16;
			if(isset($word8[$i + 3]))$word |= $word8[$i + 3] << 24;
			$word32[$i / 4] = $word;
		}
		return $word32;
	}
	public static function word32be_to_string($word32){
		return implode('', array_map(function($x){
			return pack('N', $x);
		}, $word32));
	}
	public static function word32le_to_string($word32){
		return implode('', array_map(function($x){
			return pack('V', $x);
		}, $word32));
	}
	public static function word32le_to_word8($word32){
		$word8 = array();
		for($i = 0; isset($word32[$i]); ++$i){
			$word8[$i * 4] = $word32[$i] & 0xff;
			$word8[$i * 4 + 1] = ($word32[$i] >> 8) & 0xff;
			$word8[$i * 4 + 2] = ($word32[$i] >> 16) & 0xff;
			$word8[$i * 4 + 3] = $word32[$i] >> 24;
		}
		return $word8;
	}
	public static function word32be_to_word8($word32){
		$word8 = array();
		for($i = 0; isset($word32[$i]); ++$i){
			$word8[$i * 4] = $word32[$i] >> 24;
			$word8[$i * 4 + 1] = ($word32[$i] >> 16) & 0xff;
			$word8[$i * 4 + 2] = ($word32[$i] >> 8) & 0xff;
			$word8[$i * 4 + 3] = $word32[$i] & 0xff;
		}
		return $word8;
	}
	public static function string_to_word64be($string){
		return array_map(function($x){
			$res = unpack('J', $x);
			return $res[1];
		}, str_split($string, 8));
	}
	public static function string_to_word64le($string){
		return array_map(function($x){
			$res = unpack('P', $x);
			return $res[1];
		}, str_split($string, 8));
	}
	public static function word8_to_word64be($word8){
		$word64 = array();
		for($i = 0; isset($word8[$i]); $i += 8){
			$word = $word8[$i] << 56;
			if(isset($word8[$i + 1]))$word |= $word8[$i + 1] << 48;
			if(isset($word8[$i + 2]))$word |= $word8[$i + 2] << 40;
			if(isset($word8[$i + 3]))$word |= $word8[$i + 3] << 32;
			if(isset($word8[$i + 4]))$word |= $word8[$i + 4] << 24;
			if(isset($word8[$i + 5]))$word |= $word8[$i + 5] << 16;
			if(isset($word8[$i + 6]))$word |= $word8[$i + 6] << 8;
			if(isset($word8[$i + 7]))$word |= $word8[$i + 7];
			$word64[$i / 8] = $word;
		}
		return $word64;
	}
	public static function word8_to_word64le($word8){
		$word64 = array();
		for($i = 0; isset($word8[$i]); $i += 8){
			$word = $word8[$i];
			if(isset($word8[$i + 1]))$word |= $word8[$i + 1] << 8;
			if(isset($word8[$i + 2]))$word |= $word8[$i + 2] << 16;
			if(isset($word8[$i + 3]))$word |= $word8[$i + 3] << 24;
			if(isset($word8[$i + 4]))$word |= $word8[$i + 4] << 32;
			if(isset($word8[$i + 5]))$word |= $word8[$i + 5] << 40;
			if(isset($word8[$i + 6]))$word |= $word8[$i + 6] << 48;
			if(isset($word8[$i + 7]))$word |= $word8[$i + 7] << 56;
			$word64[$i / 8] = $word;
		}
		return $word64;
	}
	public static function word64be_to_string($word64){
		return implode('', array_map(function($x){
			return pack('J', $x);
		}, $word64));
	}
	public static function word64le_to_string($word64){
		return implode('', array_map(function($x){
			return pack('P', $x);
		}, $word64));
	}
	public static function word64le_to_word8($word64){
		$word8 = array();
		for($i = 0; isset($word64[$i]); ++$i){
			$word8[$i * 8] = $word64[$i] & 0xff;
			$word8[$i * 8 + 1] = ($word64[$i] >> 8) & 0xff;
			$word8[$i * 8 + 2] = ($word64[$i] >> 16) & 0xff;
			$word8[$i * 8 + 3] = ($word64[$i] >> 24) & 0xff;
			$word8[$i * 8 + 4] = ($word64[$i] >> 32) & 0xff;
			$word8[$i * 8 + 5] = ($word64[$i] >> 40) & 0xff;
			$word8[$i * 8 + 6] = ($word64[$i] >> 48) & 0xff;
			$word8[$i * 8 + 7] = $word64[$i] >> 56;
		}
		return $word8;
	}
	public static function word64be_to_word8($word64){
		$word8 = array();
		for($i = 0; isset($word64[$i]); ++$i){
			$word8[$i * 8] = $word64[$i] >> 56;
			$word8[$i * 8 + 1] = ($word64[$i] >> 48) & 0xff;
			$word8[$i * 8 + 2] = ($word64[$i] >> 40) & 0xff;
			$word8[$i * 8 + 3] = ($word64[$i] >> 32) & 0xff;
			$word8[$i * 8 + 4] = ($word64[$i] >> 24) & 0xff;
			$word8[$i * 8 + 5] = ($word64[$i] >> 16) & 0xff;
			$word8[$i * 8 + 6] = ($word64[$i] >> 8) & 0xff;
			$word8[$i * 8 + 7] = $word64[$i] & 0xff;
		}
		return $word8;
	}
	public static function word16le_to_word16be($wordle){
		$wordbe = array();
		for($i = 0; isset($wordle[$i]); ++$i){
			$wordbe[$i] = $wordle[$i] >> 8;
			$wordbe[$i]|= ($wordle[$i] & 0xff) << 8;
		}
		return $wordbe;
	}
	public static function word16be_to_word16le($wordbe){
		$wordle = array();
		for($i = 0; isset($wordbe[$i]); ++$i){
			$wordle[$i] = ($wordbe[$i] & 0xff) << 8;
			$wordle[$i]|= $wordbe[$i] >> 8;
		}
		return $wordle;
	}
	public static function word32le_to_word32be($wordle){
		$wordbe = array();
		for($i = 0; isset($wordle[$i]); ++$i){
			$wordbe[$i] = $wordle[$i] >> 24;
			$wordbe[$i]|= (($wordle[$i] >> 16) & 0xff) << 8;
			$wordbe[$i]|= (($wordle[$i] >> 8) & 0xff) << 16;
			$wordbe[$i]|= ($wordle[$i] & 0xff) << 24;
		}
		return $wordbe;
	}
	public static function word32be_to_word32le($wordbe){
		$wordle = array();
		for($i = 0; isset($wordbe[$i]); ++$i){
			$wordle[$i] = ($wordbe[$i] & 0xff) << 24;
			$wordle[$i]|= (($wordbe[$i] >> 8) & 0xff) << 16;
			$wordle[$i]|= (($wordbe[$i] >> 16) & 0xff) << 8;
			$wordle[$i]|= $wordbe[$i] >> 24;
		}
		return $wordle;
	}
	public static function word64le_to_word64be($wordle){
		$wordbe = array();
		for($i = 0; isset($wordle[$i]); ++$i){
			$wordbe[$i] = $wordle[$i] >> 56;
			$wordbe[$i]|= (($wordle[$i] >> 48) & 0xff) << 8;
			$wordbe[$i]|= (($wordle[$i] >> 40) & 0xff) << 16;
			$wordbe[$i]|= (($wordle[$i] >> 32) & 0xff) << 24;
			$wordbe[$i]|= (($wordle[$i] >> 24) & 0xff) << 32;
			$wordbe[$i]|= (($wordle[$i] >> 16) & 0xff) << 40;
			$wordbe[$i]|= (($wordle[$i] >> 8) & 0xff) << 48;
			$wordbe[$i]|= ($wordle[$i] & 0xff) << 56;
		}
		return $wordbe;
	}
	public static function word64be_to_word64le($wordbe){
		$wordle = array();
		for($i = 0; isset($wordbe[$i]); ++$i){
			$wordle[$i] = ($wordbe[$i] & 0xff) << 56;
			$wordle[$i]|= (($wordbe[$i] >> 8) & 0xff) << 48;
			$wordle[$i]|= (($wordbe[$i] >> 16) & 0xff) << 40;
			$wordle[$i]|= (($wordbe[$i] >> 24) & 0xff) << 32;
			$wordle[$i]|= (($wordbe[$i] >> 32) & 0xff) << 24;
			$wordle[$i]|= (($wordbe[$i] >> 40) & 0xff) << 16;
			$wordle[$i]|= (($wordbe[$i] >> 48) & 0xff) << 8;
			$wordle[$i]|= $wordbe[$i] >> 56;
		}
		return $wordle;
	}
	public static function word16be_to_word32be($word16){
		$word32 = array();
		for($i = 0; isset($word16[$i]); $i += 2){
			$word32[$i / 2] = $word16[$i] << 16;
			if(isset($word16[$i + 1]))$word32[$i / 2] |= $word16[$i + 1];
		}
		return $word32;
	}
	public static function word16le_to_word32le($word16){
		$word32 = array();
		for($i = 0; isset($word16[$i]); $i += 2){
			$word32[$i / 2] = $word16[$i];
			if(isset($word16[$i + 1]))$word32[$i / 2] |= $word16[$i + 1] << 16;
		}
		return $word32;
	}
	public static function word16be_to_word32le($word16){
		return self::word16le_to_word32le(self::word16be_to_word16le($word16));
	}
	public static function word16le_to_word32be($word16){
		return self::word16be_to_word32be(self::word16le_to_word16be($word16));
	}
	public static function word32be_to_word16be($word32){
		$word16 = array();
		for($i = 0; isset($word32[$i]); ++$i){
			$word16[$i * 2] = $word32[$i] >> 16;
			$word16[$i * 2 + 1] = $word32[$i] & 0xffff;
		}
		return $word16;
	}
	public static function word32le_to_word16le($word16){
		$word16 = array();
		for($i = 0; isset($word32[$i]); ++$i){
			$word16[$i * 2] = $word32[$i] & 0xffff;
			$word16[$i * 2 + 1] = $word32[$i] >> 16;
		}
		return $word16;
	}
	public static function word32be_to_word16le($word32){
		return self::word32le_to_word16le(self::word32be_to_word32le($word32));
	}
	public static function word32le_to_word16be($word32){
		return self::word32be_to_word16be(self::word32le_to_word32be($word32));
	}
	public static function word16be_to_word64be($word16){
		$word64 = array();
		for($i = 0; isset($word16[$i]); $i += 4){
			$word = $word16[$i] << 48;
			if(isset($word16[$i + 1]))$word |= $word16[$i + 1] << 32;
			if(isset($word16[$i + 2]))$word |= $word16[$i + 2] << 16;
			if(isset($word16[$i + 3]))$word |= $word16[$i + 3];
			$word64[$i / 4] = $word;
		}
		return $word64;
	}
	public static function word16le_to_word64le($word16){
		$word64 = array();
		for($i = 0; isset($word16[$i]); $i += 4){
			$word = $word16[$i];
			if(isset($word16[$i + 1]))$word |= $word16[$i + 1] << 16;
			if(isset($word16[$i + 2]))$word |= $word16[$i + 2] << 32;
			if(isset($word16[$i + 3]))$word |= $word16[$i + 3] << 48;
			$word64[$i / 4] = $word;
		}
		return $word64;
	}
	public static function word16le_to_word64be($word16){
		return self::word16be_to_word64be(self::word16le_to_word16be($word16));
	}
	public static function word16be_to_word64le($word16){
		return self::word16le_to_word64le(self::word16be_to_word16le($word16));
	}
	public static function word64be_to_word16be($word64){
		$word16 = array();
		for($i = 0; isset($word64[$i]); ++$i){
			$word16[$i * 2] = $word64[$i] >> 48;
			$word16[$i * 2 + 1] = ($word64[$i] >> 32) & 0xffff;
			$word16[$i * 2 + 2] = ($word64[$i] >> 16) & 0xffff;
			$word16[$i * 2 + 3] = $word64[$i] & 0xffff;
		}
		return $word16;
	}
	public static function word64le_to_word16le($word64){
		$word16 = array();
		for($i = 0; isset($word64[$i]); ++$i){
			$word16[$i * 2] = $word64[$i] & 0xffff;
			$word16[$i * 2 + 1] = ($word64[$i] >> 16) & 0xffff;
			$word16[$i * 2 + 2] = ($word64[$i] >> 32) & 0xffff;
			$word16[$i * 2 + 3] = ($word64[$i] >> 48) & 0xffff;
		}
		return $word16;
	}
	public static function word64be_to_word16le($word64){
		return self::word64le_to_word16le(self::word64be_to_word64le($word64));
	}
	public static function word64le_to_word16be($word64){
		return self::word64be_to_word16be(self::word64le_to_word64be($word64));
	}
	public static function word32be_to_word64be($word32){
		$word64 = array();
		for($i = 0; isset($word16[$i]); $i += 2){
			$word64[$i / 2] = $word32[$i] << 16;
			if(isset($word32[$i + 1]))$word64[$i / 2] |= $word32[$i + 1];
		}
		return $word64;
	}
	public static function word32le_to_word64le($word64){
		$word64 = array();
		for($i = 0; isset($word32[$i]); $i += 2){
			$word64[$i / 2] = $word32[$i];
			if(isset($word32[$i + 1]))$word64[$i / 2] |= $word64[$i + 1] << 32;
		}
		return $word64;
	}
	public static function word32be_to_word64le($word32){
		return self::word32le_to_word64le(self::word32be_to_word32le($word32));
	}
	public static function word32le_to_word64be($word32){
		return self::word32be_to_word64be(self::word32le_to_word32be($word32));
	}
	public static function word64be_to_word32be($word64){
		$word32 = array();
		for($i = 0; isset($word64[$i]); ++$i){
			$word32[$i * 2] = $word64[$i] >> 32;
			$word32[$i * 2 + 1] = $word64[$i] & 0xffffffff;
		}
		return $word64;
	}
	public static function word64le_to_word32le($word32){
		$word32 = array();
		for($i = 0; isset($word64[$i]); ++$i){
			$word32[$i * 2] = $word64[$i] & 0xffffffff;
			$word32[$i * 2 + 1] = $word64[$i] >> 32;
		}
		return $word32;
	}
	public static function word64be_to_word32le($word64){
		return self::word64le_to_word32le(self::word64be_to_word64le($word64));
	}
	public static function word64le_to_word32be($word64){
		return self::word64be_to_word32be(self::word64le_to_word64be($word64));
	}

	protected static $tfq = array(
		array(
			0xA9, 0x67, 0xB3, 0xE8, 0x04, 0xFD, 0xA3, 0x76, 0x9A, 0x92, 0x80, 0x78, 0xE4, 0xDD, 0xD1, 0x38,
			0x0D, 0xC6, 0x35, 0x98, 0x18, 0xF7, 0xEC, 0x6C, 0x43, 0x75, 0x37, 0x26, 0xFA, 0x13, 0x94, 0x48,
			0xF2, 0xD0, 0x8B, 0x30, 0x84, 0x54, 0xDF, 0x23, 0x19, 0x5B, 0x3D, 0x59, 0xF3, 0xAE, 0xA2, 0x82,
			0x63, 0x01, 0x83, 0x2E, 0xD9, 0x51, 0x9B, 0x7C, 0xA6, 0xEB, 0xA5, 0xBE, 0x16, 0x0C, 0xE3, 0x61,
			0xC0, 0x8C, 0x3A, 0xF5, 0x73, 0x2C, 0x25, 0x0B, 0xBB, 0x4E, 0x89, 0x6B, 0x53, 0x6A, 0xB4, 0xF1,
			0xE1, 0xE6, 0xBD, 0x45, 0xE2, 0xF4, 0xB6, 0x66, 0xCC, 0x95, 0x03, 0x56, 0xD4, 0x1C, 0x1E, 0xD7,
			0xFB, 0xC3, 0x8E, 0xB5, 0xE9, 0xCF, 0xBF, 0xBA, 0xEA, 0x77, 0x39, 0xAF, 0x33, 0xC9, 0x62, 0x71,
			0x81, 0x79, 0x09, 0xAD, 0x24, 0xCD, 0xF9, 0xD8, 0xE5, 0xC5, 0xB9, 0x4D, 0x44, 0x08, 0x86, 0xE7,
			0xA1, 0x1D, 0xAA, 0xED, 0x06, 0x70, 0xB2, 0xD2, 0x41, 0x7B, 0xA0, 0x11, 0x31, 0xC2, 0x27, 0x90,
			0x20, 0xF6, 0x60, 0xFF, 0x96, 0x5C, 0xB1, 0xAB, 0x9E, 0x9C, 0x52, 0x1B, 0x5F, 0x93, 0x0A, 0xEF,
			0x91, 0x85, 0x49, 0xEE, 0x2D, 0x4F, 0x8F, 0x3B, 0x47, 0x87, 0x6D, 0x46, 0xD6, 0x3E, 0x69, 0x64,
			0x2A, 0xCE, 0xCB, 0x2F, 0xFC, 0x97, 0x05, 0x7A, 0xAC, 0x7F, 0xD5, 0x1A, 0x4B, 0x0E, 0xA7, 0x5A,
			0x28, 0x14, 0x3F, 0x29, 0x88, 0x3C, 0x4C, 0x02, 0xB8, 0xDA, 0xB0, 0x17, 0x55, 0x1F, 0x8A, 0x7D,
			0x57, 0xC7, 0x8D, 0x74, 0xB7, 0xC4, 0x9F, 0x72, 0x7E, 0x15, 0x22, 0x12, 0x58, 0x07, 0x99, 0x34,
			0x6E, 0x50, 0xDE, 0x68, 0x65, 0xBC, 0xDB, 0xF8, 0xC8, 0xA8, 0x2B, 0x40, 0xDC, 0xFE, 0x32, 0xA4,
			0xCA, 0x10, 0x21, 0xF0, 0xD3, 0x5D, 0x0F, 0x00, 0x6F, 0x9D, 0x36, 0x42, 0x4A, 0x5E, 0xC1, 0xE0
		), array(
			0x75, 0xF3, 0xC6, 0xF4, 0xDB, 0x7B, 0xFB, 0xC8, 0x4A, 0xD3, 0xE6, 0x6B, 0x45, 0x7D, 0xE8, 0x4B,
			0xD6, 0x32, 0xD8, 0xFD, 0x37, 0x71, 0xF1, 0xE1, 0x30, 0x0F, 0xF8, 0x1B, 0x87, 0xFA, 0x06, 0x3F,
			0x5E, 0xBA, 0xAE, 0x5B, 0x8A, 0x00, 0xBC, 0x9D, 0x6D, 0xC1, 0xB1, 0x0E, 0x80, 0x5D, 0xD2, 0xD5,
			0xA0, 0x84, 0x07, 0x14, 0xB5, 0x90, 0x2C, 0xA3, 0xB2, 0x73, 0x4C, 0x54, 0x92, 0x74, 0x36, 0x51,
			0x38, 0xB0, 0xBD, 0x5A, 0xFC, 0x60, 0x62, 0x96, 0x6C, 0x42, 0xF7, 0x10, 0x7C, 0x28, 0x27, 0x8C,
			0x13, 0x95, 0x9C, 0xC7, 0x24, 0x46, 0x3B, 0x70, 0xCA, 0xE3, 0x85, 0xCB, 0x11, 0xD0, 0x93, 0xB8,
			0xA6, 0x83, 0x20, 0xFF, 0x9F, 0x77, 0xC3, 0xCC, 0x03, 0x6F, 0x08, 0xBF, 0x40, 0xE7, 0x2B, 0xE2,
			0x79, 0x0C, 0xAA, 0x82, 0x41, 0x3A, 0xEA, 0xB9, 0xE4, 0x9A, 0xA4, 0x97, 0x7E, 0xDA, 0x7A, 0x17,
			0x66, 0x94, 0xA1, 0x1D, 0x3D, 0xF0, 0xDE, 0xB3, 0x0B, 0x72, 0xA7, 0x1C, 0xEF, 0xD1, 0x53, 0x3E,
			0x8F, 0x33, 0x26, 0x5F, 0xEC, 0x76, 0x2A, 0x49, 0x81, 0x88, 0xEE, 0x21, 0xC4, 0x1A, 0xEB, 0xD9,
			0xC5, 0x39, 0x99, 0xCD, 0xAD, 0x31, 0x8B, 0x01, 0x18, 0x23, 0xDD, 0x1F, 0x4E, 0x2D, 0xF9, 0x48,
			0x4F, 0xF2, 0x65, 0x8E, 0x78, 0x5C, 0x58, 0x19, 0x8D, 0xE5, 0x98, 0x57, 0x67, 0x7F, 0x05, 0x64,
			0xAF, 0x63, 0xB6, 0xFE, 0xF5, 0xB7, 0x3C, 0xA5, 0xCE, 0xE9, 0x68, 0x44, 0xE0, 0x4D, 0x43, 0x69,
			0x29, 0x2E, 0xAC, 0x15, 0x59, 0xA8, 0x0A, 0x9E, 0x6E, 0x47, 0xDF, 0x34, 0x35, 0x6A, 0xCF, 0xDC,
			0x22, 0xC9, 0xC0, 0x9B, 0x89, 0xD4, 0xED, 0xAB, 0x12, 0xA2, 0x0D, 0x52, 0xBB, 0x02, 0x2F, 0xA9,
			0xD7, 0x61, 0x1E, 0xB4, 0x50, 0x04, 0xF6, 0xC2, 0x16, 0x25, 0x86, 0x56, 0x55, 0x09, 0xBE, 0x91
		)
	);
	protected static $tfm = array(
		array(
			0xBCBC3275, 0xECEC21F3, 0x202043C6, 0xB3B3C9F4, 0xDADA03DB, 0x02028B7B, 0xE2E22BFB, 0x9E9EFAC8,
			0xC9C9EC4A, 0xD4D409D3, 0x18186BE6, 0x1E1E9F6B, 0x98980E45, 0xB2B2387D, 0xA6A6D2E8, 0x2626B74B,
			0x3C3C57D6, 0x93938A32, 0x8282EED8, 0x525298FD, 0x7B7BD437, 0xBBBB3771, 0x5B5B97F1, 0x474783E1,
			0x24243C30, 0x5151E20F, 0xBABAC6F8, 0x4A4AF31B, 0xBFBF4887, 0x0D0D70FA, 0xB0B0B306, 0x7575DE3F,
			0xD2D2FD5E, 0x7D7D20BA, 0x666631AE, 0x3A3AA35B, 0x59591C8A, 0x00000000, 0xCDCD93BC, 0x1A1AE09D,
			0xAEAE2C6D, 0x7F7FABC1, 0x2B2BC7B1, 0xBEBEB90E, 0xE0E0A080, 0x8A8A105D, 0x3B3B52D2, 0x6464BAD5,
			0xD8D888A0, 0xE7E7A584, 0x5F5FE807, 0x1B1B1114, 0x2C2CC2B5, 0xFCFCB490, 0x3131272C, 0x808065A3,
			0x73732AB2, 0x0C0C8173, 0x79795F4C, 0x6B6B4154, 0x4B4B0292, 0x53536974, 0x94948F36, 0x83831F51,
			0x2A2A3638, 0xC4C49CB0, 0x2222C8BD, 0xD5D5F85A, 0xBDBDC3FC, 0x48487860, 0xFFFFCE62, 0x4C4C0796,
			0x4141776C, 0xC7C7E642, 0xEBEB24F7, 0x1C1C1410, 0x5D5D637C, 0x36362228, 0x6767C027, 0xE9E9AF8C,
			0x4444F913, 0x1414EA95, 0xF5F5BB9C, 0xCFCF18C7, 0x3F3F2D24, 0xC0C0E346, 0x7272DB3B, 0x54546C70,
			0x29294CCA, 0xF0F035E3, 0x0808FE85, 0xC6C617CB, 0xF3F34F11, 0x8C8CE4D0, 0xA4A45993, 0xCACA96B8,
			0x68683BA6, 0xB8B84D83, 0x38382820, 0xE5E52EFF, 0xADAD569F, 0x0B0B8477, 0xC8C81DC3, 0x9999FFCC,
			0x5858ED03, 0x19199A6F, 0x0E0E0A08, 0x95957EBF, 0x70705040, 0xF7F730E7, 0x6E6ECF2B, 0x1F1F6EE2,
			0xB5B53D79, 0x09090F0C, 0x616134AA, 0x57571682, 0x9F9F0B41, 0x9D9D803A, 0x111164EA, 0x2525CDB9,
			0xAFAFDDE4, 0x4545089A, 0xDFDF8DA4, 0xA3A35C97, 0xEAEAD57E, 0x353558DA, 0xEDEDD07A, 0x4343FC17,
			0xF8F8CB66, 0xFBFBB194, 0x3737D3A1, 0xFAFA401D, 0xC2C2683D, 0xB4B4CCF0, 0x32325DDE, 0x9C9C71B3,
			0x5656E70B, 0xE3E3DA72, 0x878760A7, 0x15151B1C, 0xF9F93AEF, 0x6363BFD1, 0x3434A953, 0x9A9A853E,
			0xB1B1428F, 0x7C7CD133, 0x88889B26, 0x3D3DA65F, 0xA1A1D7EC, 0xE4E4DF76, 0x8181942A, 0x91910149,
			0x0F0FFB81, 0xEEEEAA88, 0x161661EE, 0xD7D77321, 0x9797F5C4, 0xA5A5A81A, 0xFEFE3FEB, 0x6D6DB5D9,
			0x7878AEC5, 0xC5C56D39, 0x1D1DE599, 0x7676A4CD, 0x3E3EDCAD, 0xCBCB6731, 0xB6B6478B, 0xEFEF5B01,
			0x12121E18, 0x6060C523, 0x6A6AB0DD, 0x4D4DF61F, 0xCECEE94E, 0xDEDE7C2D, 0x55559DF9, 0x7E7E5A48,
			0x2121B24F, 0x03037AF2, 0xA0A02665, 0x5E5E198E, 0x5A5A6678, 0x65654B5C, 0x62624E58, 0xFDFD4519,
			0x0606F48D, 0x404086E5, 0xF2F2BE98, 0x3333AC57, 0x17179067, 0x05058E7F, 0xE8E85E05, 0x4F4F7D64,
			0x89896AAF, 0x10109563, 0x74742FB6, 0x0A0A75FE, 0x5C5C92F5, 0x9B9B74B7, 0x2D2D333C, 0x3030D6A5,
			0x2E2E49CE, 0x494989E9, 0x46467268, 0x77775544, 0xA8A8D8E0, 0x9696044D, 0x2828BD43, 0xA9A92969,
			0xD9D97929, 0x8686912E, 0xD1D187AC, 0xF4F44A15, 0x8D8D1559, 0xD6D682A8, 0xB9B9BC0A, 0x42420D9E,
			0xF6F6C16E, 0x2F2FB847, 0xDDDD06DF, 0x23233934, 0xCCCC6235, 0xF1F1C46A, 0xC1C112CF, 0x8585EBDC,
			0x8F8F9E22, 0x7171A1C9, 0x9090F0C0, 0xAAAA539B, 0x0101F189, 0x8B8BE1D4, 0x4E4E8CED, 0x8E8E6FAB,
			0xABABA212, 0x6F6F3EA2, 0xE6E6540D, 0xDBDBF252, 0x92927BBB, 0xB7B7B602, 0x6969CA2F, 0x3939D9A9,
			0xD3D30CD7, 0xA7A72361, 0xA2A2AD1E, 0xC3C399B4, 0x6C6C4450, 0x07070504, 0x04047FF6, 0x272746C2,
			0xACACA716, 0xD0D07625, 0x50501386, 0xDCDCF756, 0x84841A55, 0xE1E15109, 0x7A7A25BE, 0x1313EF91
		), array(
			0xA9D93939, 0x67901717, 0xB3719C9C, 0xE8D2A6A6, 0x04050707, 0xFD985252, 0xA3658080, 0x76DFE4E4,
			0x9A084545, 0x92024B4B, 0x80A0E0E0, 0x78665A5A, 0xE4DDAFAF, 0xDDB06A6A, 0xD1BF6363, 0x38362A2A,
			0x0D54E6E6, 0xC6432020, 0x3562CCCC, 0x98BEF2F2, 0x181E1212, 0xF724EBEB, 0xECD7A1A1, 0x6C774141,
			0x43BD2828, 0x7532BCBC, 0x37D47B7B, 0x269B8888, 0xFA700D0D, 0x13F94444, 0x94B1FBFB, 0x485A7E7E,
			0xF27A0303, 0xD0E48C8C, 0x8B47B6B6, 0x303C2424, 0x84A5E7E7, 0x54416B6B, 0xDF06DDDD, 0x23C56060,
			0x1945FDFD, 0x5BA33A3A, 0x3D68C2C2, 0x59158D8D, 0xF321ECEC, 0xAE316666, 0xA23E6F6F, 0x82165757,
			0x63951010, 0x015BEFEF, 0x834DB8B8, 0x2E918686, 0xD9B56D6D, 0x511F8383, 0x9B53AAAA, 0x7C635D5D,
			0xA63B6868, 0xEB3FFEFE, 0xA5D63030, 0xBE257A7A, 0x16A7ACAC, 0x0C0F0909, 0xE335F0F0, 0x6123A7A7,
			0xC0F09090, 0x8CAFE9E9, 0x3A809D9D, 0xF5925C5C, 0x73810C0C, 0x2C273131, 0x2576D0D0, 0x0BE75656,
			0xBB7B9292, 0x4EE9CECE, 0x89F10101, 0x6B9F1E1E, 0x53A93434, 0x6AC4F1F1, 0xB499C3C3, 0xF1975B5B,
			0xE1834747, 0xE66B1818, 0xBDC82222, 0x450E9898, 0xE26E1F1F, 0xF4C9B3B3, 0xB62F7474, 0x66CBF8F8,
			0xCCFF9999, 0x95EA1414, 0x03ED5858, 0x56F7DCDC, 0xD4E18B8B, 0x1C1B1515, 0x1EADA2A2, 0xD70CD3D3,
			0xFB2BE2E2, 0xC31DC8C8, 0x8E195E5E, 0xB5C22C2C, 0xE9894949, 0xCF12C1C1, 0xBF7E9595, 0xBA207D7D,
			0xEA641111, 0x77840B0B, 0x396DC5C5, 0xAF6A8989, 0x33D17C7C, 0xC9A17171, 0x62CEFFFF, 0x7137BBBB,
			0x81FB0F0F, 0x793DB5B5, 0x0951E1E1, 0xADDC3E3E, 0x242D3F3F, 0xCDA47676, 0xF99D5555, 0xD8EE8282,
			0xE5864040, 0xC5AE7878, 0xB9CD2525, 0x4D049696, 0x44557777, 0x080A0E0E, 0x86135050, 0xE730F7F7,
			0xA1D33737, 0x1D40FAFA, 0xAA346161, 0xED8C4E4E, 0x06B3B0B0, 0x706C5454, 0xB22A7373, 0xD2523B3B,
			0x410B9F9F, 0x7B8B0202, 0xA088D8D8, 0x114FF3F3, 0x3167CBCB, 0xC2462727, 0x27C06767, 0x90B4FCFC,
			0x20283838, 0xF67F0404, 0x60784848, 0xFF2EE5E5, 0x96074C4C, 0x5C4B6565, 0xB1C72B2B, 0xAB6F8E8E,
			0x9E0D4242, 0x9CBBF5F5, 0x52F2DBDB, 0x1BF34A4A, 0x5FA63D3D, 0x9359A4A4, 0x0ABCB9B9, 0xEF3AF9F9,
			0x91EF1313, 0x85FE0808, 0x49019191, 0xEE611616, 0x2D7CDEDE, 0x4FB22121, 0x8F42B1B1, 0x3BDB7272,
			0x47B82F2F, 0x8748BFBF, 0x6D2CAEAE, 0x46E3C0C0, 0xD6573C3C, 0x3E859A9A, 0x6929A9A9, 0x647D4F4F,
			0x2A948181, 0xCE492E2E, 0xCB17C6C6, 0x2FCA6969, 0xFCC3BDBD, 0x975CA3A3, 0x055EE8E8, 0x7AD0EDED,
			0xAC87D1D1, 0x7F8E0505, 0xD5BA6464, 0x1AA8A5A5, 0x4BB72626, 0x0EB9BEBE, 0xA7608787, 0x5AF8D5D5,
			0x28223636, 0x14111B1B, 0x3FDE7575, 0x2979D9D9, 0x88AAEEEE, 0x3C332D2D, 0x4C5F7979, 0x02B6B7B7,
			0xB896CACA, 0xDA583535, 0xB09CC4C4, 0x17FC4343, 0x551A8484, 0x1FF64D4D, 0x8A1C5959, 0x7D38B2B2,
			0x57AC3333, 0xC718CFCF, 0x8DF40606, 0x74695353, 0xB7749B9B, 0xC4F59797, 0x9F56ADAD, 0x72DAE3E3,
			0x7ED5EAEA, 0x154AF4F4, 0x229E8F8F, 0x12A2ABAB, 0x584E6262, 0x07E85F5F, 0x99E51D1D, 0x34392323,
			0x6EC1F6F6, 0x50446C6C, 0xDE5D3232, 0x68724646, 0x6526A0A0, 0xBC93CDCD, 0xDB03DADA, 0xF8C6BABA,
			0xC8FA9E9E, 0xA882D6D6, 0x2BCF6E6E, 0x40507070, 0xDCEB8585, 0xFE750A0A, 0x328A9393, 0xA48DDFDF,
			0xCA4C2929, 0x10141C1C, 0x2173D7D7, 0xF0CCB4B4, 0xD309D4D4, 0x5D108A8A, 0x0FE25151, 0x00000000,
			0x6F9A1919, 0x9DE01A1A, 0x368F9494, 0x42E6C7C7, 0x4AECC9C9, 0x5EFDD2D2, 0xC1AB7F7F, 0xE0D8A8A8
		), array(
			0xBC75BC32, 0xECF3EC21, 0x20C62043, 0xB3F4B3C9, 0xDADBDA03, 0x027B028B, 0xE2FBE22B, 0x9EC89EFA,
			0xC94AC9EC, 0xD4D3D409, 0x18E6186B, 0x1E6B1E9F, 0x9845980E, 0xB27DB238, 0xA6E8A6D2, 0x264B26B7,
			0x3CD63C57, 0x9332938A, 0x82D882EE, 0x52FD5298, 0x7B377BD4, 0xBB71BB37, 0x5BF15B97, 0x47E14783,
			0x2430243C, 0x510F51E2, 0xBAF8BAC6, 0x4A1B4AF3, 0xBF87BF48, 0x0DFA0D70, 0xB006B0B3, 0x753F75DE,
			0xD25ED2FD, 0x7DBA7D20, 0x66AE6631, 0x3A5B3AA3, 0x598A591C, 0x00000000, 0xCDBCCD93, 0x1A9D1AE0,
			0xAE6DAE2C, 0x7FC17FAB, 0x2BB12BC7, 0xBE0EBEB9, 0xE080E0A0, 0x8A5D8A10, 0x3BD23B52, 0x64D564BA,
			0xD8A0D888, 0xE784E7A5, 0x5F075FE8, 0x1B141B11, 0x2CB52CC2, 0xFC90FCB4, 0x312C3127, 0x80A38065,
			0x73B2732A, 0x0C730C81, 0x794C795F, 0x6B546B41, 0x4B924B02, 0x53745369, 0x9436948F, 0x8351831F,
			0x2A382A36, 0xC4B0C49C, 0x22BD22C8, 0xD55AD5F8, 0xBDFCBDC3, 0x48604878, 0xFF62FFCE, 0x4C964C07,
			0x416C4177, 0xC742C7E6, 0xEBF7EB24, 0x1C101C14, 0x5D7C5D63, 0x36283622, 0x672767C0, 0xE98CE9AF,
			0x441344F9, 0x149514EA, 0xF59CF5BB, 0xCFC7CF18, 0x3F243F2D, 0xC046C0E3, 0x723B72DB, 0x5470546C,
			0x29CA294C, 0xF0E3F035, 0x088508FE, 0xC6CBC617, 0xF311F34F, 0x8CD08CE4, 0xA493A459, 0xCAB8CA96,
			0x68A6683B, 0xB883B84D, 0x38203828, 0xE5FFE52E, 0xAD9FAD56, 0x0B770B84, 0xC8C3C81D, 0x99CC99FF,
			0x580358ED, 0x196F199A, 0x0E080E0A, 0x95BF957E, 0x70407050, 0xF7E7F730, 0x6E2B6ECF, 0x1FE21F6E,
			0xB579B53D, 0x090C090F, 0x61AA6134, 0x57825716, 0x9F419F0B, 0x9D3A9D80, 0x11EA1164, 0x25B925CD,
			0xAFE4AFDD, 0x459A4508, 0xDFA4DF8D, 0xA397A35C, 0xEA7EEAD5, 0x35DA3558, 0xED7AEDD0, 0x431743FC,
			0xF866F8CB, 0xFB94FBB1, 0x37A137D3, 0xFA1DFA40, 0xC23DC268, 0xB4F0B4CC, 0x32DE325D, 0x9CB39C71,
			0x560B56E7, 0xE372E3DA, 0x87A78760, 0x151C151B, 0xF9EFF93A, 0x63D163BF, 0x345334A9, 0x9A3E9A85,
			0xB18FB142, 0x7C337CD1, 0x8826889B, 0x3D5F3DA6, 0xA1ECA1D7, 0xE476E4DF, 0x812A8194, 0x91499101,
			0x0F810FFB, 0xEE88EEAA, 0x16EE1661, 0xD721D773, 0x97C497F5, 0xA51AA5A8, 0xFEEBFE3F, 0x6DD96DB5,
			0x78C578AE, 0xC539C56D, 0x1D991DE5, 0x76CD76A4, 0x3EAD3EDC, 0xCB31CB67, 0xB68BB647, 0xEF01EF5B,
			0x1218121E, 0x602360C5, 0x6ADD6AB0, 0x4D1F4DF6, 0xCE4ECEE9, 0xDE2DDE7C, 0x55F9559D, 0x7E487E5A,
			0x214F21B2, 0x03F2037A, 0xA065A026, 0x5E8E5E19, 0x5A785A66, 0x655C654B, 0x6258624E, 0xFD19FD45,
			0x068D06F4, 0x40E54086, 0xF298F2BE, 0x335733AC, 0x17671790, 0x057F058E, 0xE805E85E, 0x4F644F7D,
			0x89AF896A, 0x10631095, 0x74B6742F, 0x0AFE0A75, 0x5CF55C92, 0x9BB79B74, 0x2D3C2D33, 0x30A530D6,
			0x2ECE2E49, 0x49E94989, 0x46684672, 0x77447755, 0xA8E0A8D8, 0x964D9604, 0x284328BD, 0xA969A929,
			0xD929D979, 0x862E8691, 0xD1ACD187, 0xF415F44A, 0x8D598D15, 0xD6A8D682, 0xB90AB9BC, 0x429E420D,
			0xF66EF6C1, 0x2F472FB8, 0xDDDFDD06, 0x23342339, 0xCC35CC62, 0xF16AF1C4, 0xC1CFC112, 0x85DC85EB,
			0x8F228F9E, 0x71C971A1, 0x90C090F0, 0xAA9BAA53, 0x018901F1, 0x8BD48BE1, 0x4EED4E8C, 0x8EAB8E6F,
			0xAB12ABA2, 0x6FA26F3E, 0xE60DE654, 0xDB52DBF2, 0x92BB927B, 0xB702B7B6, 0x692F69CA, 0x39A939D9,
			0xD3D7D30C, 0xA761A723, 0xA21EA2AD, 0xC3B4C399, 0x6C506C44, 0x07040705, 0x04F6047F, 0x27C22746,
			0xAC16ACA7, 0xD025D076, 0x50865013, 0xDC56DCF7, 0x8455841A, 0xE109E151, 0x7ABE7A25, 0x139113EF
		), array(
			0xD939A9D9, 0x90176790, 0x719CB371, 0xD2A6E8D2, 0x05070405, 0x9852FD98, 0x6580A365, 0xDFE476DF,
			0x08459A08, 0x024B9202, 0xA0E080A0, 0x665A7866, 0xDDAFE4DD, 0xB06ADDB0, 0xBF63D1BF, 0x362A3836,
			0x54E60D54, 0x4320C643, 0x62CC3562, 0xBEF298BE, 0x1E12181E, 0x24EBF724, 0xD7A1ECD7, 0x77416C77,
			0xBD2843BD, 0x32BC7532, 0xD47B37D4, 0x9B88269B, 0x700DFA70, 0xF94413F9, 0xB1FB94B1, 0x5A7E485A,
			0x7A03F27A, 0xE48CD0E4, 0x47B68B47, 0x3C24303C, 0xA5E784A5, 0x416B5441, 0x06DDDF06, 0xC56023C5,
			0x45FD1945, 0xA33A5BA3, 0x68C23D68, 0x158D5915, 0x21ECF321, 0x3166AE31, 0x3E6FA23E, 0x16578216,
			0x95106395, 0x5BEF015B, 0x4DB8834D, 0x91862E91, 0xB56DD9B5, 0x1F83511F, 0x53AA9B53, 0x635D7C63,
			0x3B68A63B, 0x3FFEEB3F, 0xD630A5D6, 0x257ABE25, 0xA7AC16A7, 0x0F090C0F, 0x35F0E335, 0x23A76123,
			0xF090C0F0, 0xAFE98CAF, 0x809D3A80, 0x925CF592, 0x810C7381, 0x27312C27, 0x76D02576, 0xE7560BE7,
			0x7B92BB7B, 0xE9CE4EE9, 0xF10189F1, 0x9F1E6B9F, 0xA93453A9, 0xC4F16AC4, 0x99C3B499, 0x975BF197,
			0x8347E183, 0x6B18E66B, 0xC822BDC8, 0x0E98450E, 0x6E1FE26E, 0xC9B3F4C9, 0x2F74B62F, 0xCBF866CB,
			0xFF99CCFF, 0xEA1495EA, 0xED5803ED, 0xF7DC56F7, 0xE18BD4E1, 0x1B151C1B, 0xADA21EAD, 0x0CD3D70C,
			0x2BE2FB2B, 0x1DC8C31D, 0x195E8E19, 0xC22CB5C2, 0x8949E989, 0x12C1CF12, 0x7E95BF7E, 0x207DBA20,
			0x6411EA64, 0x840B7784, 0x6DC5396D, 0x6A89AF6A, 0xD17C33D1, 0xA171C9A1, 0xCEFF62CE, 0x37BB7137,
			0xFB0F81FB, 0x3DB5793D, 0x51E10951, 0xDC3EADDC, 0x2D3F242D, 0xA476CDA4, 0x9D55F99D, 0xEE82D8EE,
			0x8640E586, 0xAE78C5AE, 0xCD25B9CD, 0x04964D04, 0x55774455, 0x0A0E080A, 0x13508613, 0x30F7E730,
			0xD337A1D3, 0x40FA1D40, 0x3461AA34, 0x8C4EED8C, 0xB3B006B3, 0x6C54706C, 0x2A73B22A, 0x523BD252,
			0x0B9F410B, 0x8B027B8B, 0x88D8A088, 0x4FF3114F, 0x67CB3167, 0x4627C246, 0xC06727C0, 0xB4FC90B4,
			0x28382028, 0x7F04F67F, 0x78486078, 0x2EE5FF2E, 0x074C9607, 0x4B655C4B, 0xC72BB1C7, 0x6F8EAB6F,
			0x0D429E0D, 0xBBF59CBB, 0xF2DB52F2, 0xF34A1BF3, 0xA63D5FA6, 0x59A49359, 0xBCB90ABC, 0x3AF9EF3A,
			0xEF1391EF, 0xFE0885FE, 0x01914901, 0x6116EE61, 0x7CDE2D7C, 0xB2214FB2, 0x42B18F42, 0xDB723BDB,
			0xB82F47B8, 0x48BF8748, 0x2CAE6D2C, 0xE3C046E3, 0x573CD657, 0x859A3E85, 0x29A96929, 0x7D4F647D,
			0x94812A94, 0x492ECE49, 0x17C6CB17, 0xCA692FCA, 0xC3BDFCC3, 0x5CA3975C, 0x5EE8055E, 0xD0ED7AD0,
			0x87D1AC87, 0x8E057F8E, 0xBA64D5BA, 0xA8A51AA8, 0xB7264BB7, 0xB9BE0EB9, 0x6087A760, 0xF8D55AF8,
			0x22362822, 0x111B1411, 0xDE753FDE, 0x79D92979, 0xAAEE88AA, 0x332D3C33, 0x5F794C5F, 0xB6B702B6,
			0x96CAB896, 0x5835DA58, 0x9CC4B09C, 0xFC4317FC, 0x1A84551A, 0xF64D1FF6, 0x1C598A1C, 0x38B27D38,
			0xAC3357AC, 0x18CFC718, 0xF4068DF4, 0x69537469, 0x749BB774, 0xF597C4F5, 0x56AD9F56, 0xDAE372DA,
			0xD5EA7ED5, 0x4AF4154A, 0x9E8F229E, 0xA2AB12A2, 0x4E62584E, 0xE85F07E8, 0xE51D99E5, 0x39233439,
			0xC1F66EC1, 0x446C5044, 0x5D32DE5D, 0x72466872, 0x26A06526, 0x93CDBC93, 0x03DADB03, 0xC6BAF8C6,
			0xFA9EC8FA, 0x82D6A882, 0xCF6E2BCF, 0x50704050, 0xEB85DCEB, 0x750AFE75, 0x8A93328A, 0x8DDFA48D,
			0x4C29CA4C, 0x141C1014, 0x73D72173, 0xCCB4F0CC, 0x09D4D309, 0x108A5D10, 0xE2510FE2, 0x00000000,
			0x9A196F9A, 0xE01A9DE0, 0x8F94368F, 0xE6C742E6, 0xECC94AEC, 0xFDD25EFD, 0xAB7FC1AB, 0xD8A8E0D8
		)
	);
	private static function twofish_setup_key($key, $length){
		$longs = unpack('V*', $key);
		$key = unpack('C*', $key);
		$m0 = self::$tfm[0];
		$m1 = self::$tfm[1];
		$m2 = self::$tfm[2];
		$m3 = self::$tfm[3];
		$q0 = self::$tfq[0];
		$q1 = self::$tfq[1];
		$K = $S0 = $S1 = $S2 = $S3 = array();
		switch($length) {
			case 0:
				for($i = 0, $j = 1; $i < 40; $i+= 2, $j+= 2) {
					$A = $m0[$i] ^ $m1[$i] ^ $m2[$i] ^ $m3[$i];
					$B = $m0[$j] ^ $m1[$j] ^ $m2[$j] ^ $m3[$j];
					$B = ($B << 8) | ($B >> 24 & 0xff);
					$A += $B;
					$K[] = $A;
					$A += $B;
					$K[] = $A << 9 | $A >> 23 & 0x1ff;
				}
				$S0 = $m0;
				$S1 = $m1;
				$S2 = $m2;
				$S3 = $m3;
			break;
			case 8:
				list($s3, $s2, $s1, $s0) = math::mdsrem($longs[1], $longs[2]);
				for($i = 0, $j = 1; $i < 40; $i+= 2, $j+= 2) {
					$A = $m0[$q0[$i] ^ $key[1]] ^
						 $m1[$q0[$i] ^ $key[2]] ^
						 $m2[$q1[$i] ^ $key[3]] ^
						 $m3[$q1[$i] ^ $key[4]];
					$B = $m0[$q0[$j] ^ $key[5]] ^
						 $m1[$q0[$j] ^ $key[6]] ^
						 $m2[$q1[$j] ^ $key[7]] ^
						 $m3[$q1[$j] ^ $key[8]];
					$B = ($B << 8) | ($B >> 24 & 0xff);
					$A += $B;
					$K[] = $A;
					$A += $B;
					$K[] = $A << 9 | $A >> 23 & 0x1ff;
				}
				for($i = 0; $i < 256; ++$i) {
					$S0[$i] = $m0[$q0[$i] ^ $s0];
					$S1[$i] = $m1[$q0[$i] ^ $s1];
					$S2[$i] = $m2[$q1[$i] ^ $s2];
					$S3[$i] = $m3[$q1[$i] ^ $s3];
				}
			break;
			case 16:
				list($s7, $s6, $s5, $s4) = math::mdsrem($longs[1], $longs[2]);
				list($s3, $s2, $s1, $s0) = math::mdsrem($longs[3], $longs[4]);
				for($i = 0, $j = 1; $i < 40; $i+= 2, $j+= 2) {
					$A = $m0[$q0[$q0[$i] ^ $key[ 9]] ^ $key[1]] ^
						 $m1[$q0[$q1[$i] ^ $key[10]] ^ $key[2]] ^
						 $m2[$q1[$q0[$i] ^ $key[11]] ^ $key[3]] ^
						 $m3[$q1[$q1[$i] ^ $key[12]] ^ $key[4]];
					$B = $m0[$q0[$q0[$j] ^ $key[13]] ^ $key[5]] ^
						 $m1[$q0[$q1[$j] ^ $key[14]] ^ $key[6]] ^
						 $m2[$q1[$q0[$j] ^ $key[15]] ^ $key[7]] ^
						 $m3[$q1[$q1[$j] ^ $key[16]] ^ $key[8]];
					$B = ($B << 8) | ($B >> 24 & 0xff);
					$A += $B;
					$K[] = $A;
					$A += $B;
					$K[] = $A << 9 | $A >> 23 & 0x1ff;
				}
				for($i = 0; $i < 256; ++$i) {
					$S0[$i] = $m0[$q0[$q0[$i] ^ $s4] ^ $s0];
					$S1[$i] = $m1[$q0[$q1[$i] ^ $s5] ^ $s1];
					$S2[$i] = $m2[$q1[$q0[$i] ^ $s6] ^ $s2];
					$S3[$i] = $m3[$q1[$q1[$i] ^ $s7] ^ $s3];
				}
			break;
			case 24:
				list($sb, $sa, $s9, $s8) = math::mdsrem($longs[1], $longs[2]);
				list($s7, $s6, $s5, $s4) = math::mdsrem($longs[3], $longs[4]);
				list($s3, $s2, $s1, $s0) = math::mdsrem($longs[5], $longs[6]);
				for($i = 0, $j = 1; $i < 40; $i+= 2, $j+= 2) {
					$A = $m0[$q0[$q0[$q1[$i] ^ $key[17]] ^ $key[ 9]] ^ $key[1]] ^
						 $m1[$q0[$q1[$q1[$i] ^ $key[18]] ^ $key[10]] ^ $key[2]] ^
						 $m2[$q1[$q0[$q0[$i] ^ $key[19]] ^ $key[11]] ^ $key[3]] ^
						 $m3[$q1[$q1[$q0[$i] ^ $key[20]] ^ $key[12]] ^ $key[4]];
					$B = $m0[$q0[$q0[$q1[$j] ^ $key[21]] ^ $key[13]] ^ $key[5]] ^
						 $m1[$q0[$q1[$q1[$j] ^ $key[22]] ^ $key[14]] ^ $key[6]] ^
						 $m2[$q1[$q0[$q0[$j] ^ $key[23]] ^ $key[15]] ^ $key[7]] ^
						 $m3[$q1[$q1[$q0[$j] ^ $key[24]] ^ $key[16]] ^ $key[8]];
					$B = ($B << 8) | ($B >> 24 & 0xff);
					$A += $B;
					$K[] = $A;
					$A += $B;
					$K[] = $A << 9 | $A >> 23 & 0x1ff;
				}
				for($i = 0; $i < 256; ++$i) {
					$S0[$i] = $m0[$q0[$q0[$q1[$i] ^ $s8] ^ $s4] ^ $s0];
					$S1[$i] = $m1[$q0[$q1[$q1[$i] ^ $s9] ^ $s5] ^ $s1];
					$S2[$i] = $m2[$q1[$q0[$q0[$i] ^ $sa] ^ $s6] ^ $s2];
					$S3[$i] = $m3[$q1[$q1[$q0[$i] ^ $sb] ^ $s7] ^ $s3];
				}
			break;
			case 32:
				list($sf, $se, $sd, $sc) = math::mdsrem($longs[1], $longs[2]);
				list($sb, $sa, $s9, $s8) = math::mdsrem($longs[3], $longs[4]);
				list($s7, $s6, $s5, $s4) = math::mdsrem($longs[5], $longs[6]);
				list($s3, $s2, $s1, $s0) = math::mdsrem($longs[7], $longs[8]);
				for($i = 0, $j = 1; $i < 40; $i+= 2, $j+= 2) {
					$A = $m0[$q0[$q0[$q1[$q1[$i] ^ $key[25]] ^ $key[17]] ^ $key[ 9]] ^ $key[1]] ^
						 $m1[$q0[$q1[$q1[$q0[$i] ^ $key[26]] ^ $key[18]] ^ $key[10]] ^ $key[2]] ^
						 $m2[$q1[$q0[$q0[$q0[$i] ^ $key[27]] ^ $key[19]] ^ $key[11]] ^ $key[3]] ^
						 $m3[$q1[$q1[$q0[$q1[$i] ^ $key[28]] ^ $key[20]] ^ $key[12]] ^ $key[4]];
					$B = $m0[$q0[$q0[$q1[$q1[$j] ^ $key[29]] ^ $key[21]] ^ $key[13]] ^ $key[5]] ^
						 $m1[$q0[$q1[$q1[$q0[$j] ^ $key[30]] ^ $key[22]] ^ $key[14]] ^ $key[6]] ^
						 $m2[$q1[$q0[$q0[$q0[$j] ^ $key[31]] ^ $key[23]] ^ $key[15]] ^ $key[7]] ^
						 $m3[$q1[$q1[$q0[$q1[$j] ^ $key[32]] ^ $key[24]] ^ $key[16]] ^ $key[8]];
					$B = ($B << 8) | ($B >> 24 & 0xff);
					$A += $B;
					$K[] = $A;
					$A += $B;
					$K[] = $A << 9 | $A >> 23 & 0x1ff;
				}
				for($i = 0; $i < 256; ++$i) {
					$S0[$i] = $m0[$q0[$q0[$q1[$q1[$i] ^ $sc] ^ $s8] ^ $s4] ^ $s0];
					$S1[$i] = $m1[$q0[$q1[$q1[$q0[$i] ^ $sd] ^ $s9] ^ $s5] ^ $s1];
					$S2[$i] = $m2[$q1[$q0[$q0[$q0[$i] ^ $se] ^ $sa] ^ $s6] ^ $s2];
					$S3[$i] = $m3[$q1[$q1[$q0[$q1[$i] ^ $sf] ^ $sb] ^ $s7] ^ $s3];
				}
			break;
		}
		return array($K, array($S0, $S1, $S2, $S3));
	}
	private static function twofish_encrypt($in, $key){
		$S0 = $key[1][0];
		$S1 = $key[1][1];
		$S2 = $key[1][2];
		$S3 = $key[1][3];
		$K  = $key[0];
		$in = unpack("V4", $in);
		$R0 = $K[0] ^ $in[1];
		$R1 = $K[1] ^ $in[2];
		$R2 = $K[2] ^ $in[3];
		$R3 = $K[3] ^ $in[4];
		$ki = 7;
		while($ki < 39) {
			$t0 = $S0[ $R0		& 0xff] ^
				  $S1[($R0 >>  8) & 0xff] ^
				  $S2[($R0 >> 16) & 0xff] ^
				  $S3[($R0 >> 24) & 0xff];
			$t1 = $S0[($R1 >> 24) & 0xff] ^
				  $S1[ $R1		& 0xff] ^
				  $S2[($R1 >>  8) & 0xff] ^
				  $S3[($R1 >> 16) & 0xff];
			$R2^= $t0 + $t1 + $K[++$ki];
			$R2 = ($R2 >> 1 & 0x7fffffff) | ($R2 << 31);
			$R3 = ((($R3 >> 31) & 1) | ($R3 << 1)) ^ ($t0 + ($t1 << 1) + $K[++$ki]);
			$t0 = $S0[ $R2		& 0xff] ^
				  $S1[($R2 >>  8) & 0xff] ^
				  $S2[($R2 >> 16) & 0xff] ^
				  $S3[($R2 >> 24) & 0xff];
			$t1 = $S0[($R3 >> 24) & 0xff] ^
				  $S1[ $R3		& 0xff] ^
				  $S2[($R3 >>  8) & 0xff] ^
				  $S3[($R3 >> 16) & 0xff];
			$R0^= $t0 + $t1 + $K[++$ki];
			$R0 = ($R0 >> 1 & 0x7fffffff) | ($R0 << 31);
			$R1 = ((($R1 >> 31) & 1) | ($R1 << 1)) ^ ($t0 + ($t1 << 1) + $K[++$ki]);
		}
		return pack("V4", $K[4] ^ $R2, $K[5] ^ $R3, $K[6] ^ $R0, $K[7] ^ $R1);
	}
	private static function twofish_decrypt($in, $key){
		$S0 = $key[1][0];
		$S1 = $key[1][1];
		$S2 = $key[1][2];
		$S3 = $key[1][3];
		$K  = $key[0];
		$in = unpack("V4", $in);
		$R0 = $K[4] ^ $in[1];
		$R1 = $K[5] ^ $in[2];
		$R2 = $K[6] ^ $in[3];
		$R3 = $K[7] ^ $in[4];
		$ki = 40;
		while($ki > 8) {
			$t0 = $S0[$R0	   & 0xff] ^
				  $S1[$R0 >>  8 & 0xff] ^
				  $S2[$R0 >> 16 & 0xff] ^
				  $S3[$R0 >> 24 & 0xff];
			$t1 = $S0[$R1 >> 24 & 0xff] ^
				  $S1[$R1	   & 0xff] ^
				  $S2[$R1 >>  8 & 0xff] ^
				  $S3[$R1 >> 16 & 0xff];
			$R3^= $t0 + ($t1 << 1) + $K[--$ki];
			$R3 = $R3 >> 1 & 0x7fffffff | $R3 << 31;
			$R2 = ($R2 >> 31 & 0x1 | $R2 << 1) ^ ($t0 + $t1 + $K[--$ki]);
			$t0 = $S0[$R2	   & 0xff] ^
				  $S1[$R2 >>  8 & 0xff] ^
				  $S2[$R2 >> 16 & 0xff] ^
				  $S3[$R2 >> 24 & 0xff];
			$t1 = $S0[$R3 >> 24 & 0xff] ^
				  $S1[$R3	   & 0xff] ^
				  $S2[$R3 >>  8 & 0xff] ^
				  $S3[$R3 >> 16 & 0xff];
			$R1^= $t0 + ($t1 << 1) + $K[--$ki];
			$R1 = $R1 >> 1 & 0x7fffffff | $R1 << 31;
			$R0 = ($R0 >> 31 & 0x1 | $R0 << 1) ^ ($t0 + $t1 + $K[--$ki]);
		}
		return pack("V4", $K[0] ^ $R2, $K[1] ^ $R3, $K[2] ^ $R0, $K[3] ^ $R1);
	}
	protected static $bfs = array(
		array(
			0xd1310ba6, 0x98dfb5ac, 0x2ffd72db, 0xd01adfb7, 0xb8e1afed, 0x6a267e96, 0xba7c9045, 0xf12c7f99,
			0x24a19947, 0xb3916cf7, 0x0801f2e2, 0x858efc16, 0x636920d8, 0x71574e69, 0xa458fea3, 0xf4933d7e,
			0x0d95748f, 0x728eb658, 0x718bcd58, 0x82154aee, 0x7b54a41d, 0xc25a59b5, 0x9c30d539, 0x2af26013,
			0xc5d1b023, 0x286085f0, 0xca417918, 0xb8db38ef, 0x8e79dcb0, 0x603a180e, 0x6c9e0e8b, 0xb01e8a3e,
			0xd71577c1, 0xbd314b27, 0x78af2fda, 0x55605c60, 0xe65525f3, 0xaa55ab94, 0x57489862, 0x63e81440,
			0x55ca396a, 0x2aab10b6, 0xb4cc5c34, 0x1141e8ce, 0xa15486af, 0x7c72e993, 0xb3ee1411, 0x636fbc2a,
			0x2ba9c55d, 0x741831f6, 0xce5c3e16, 0x9b87931e, 0xafd6ba33, 0x6c24cf5c, 0x7a325381, 0x28958677,
			0x3b8f4898, 0x6b4bb9af, 0xc4bfe81b, 0x66282193, 0x61d809cc, 0xfb21a991, 0x487cac60, 0x5dec8032,
			0xef845d5d, 0xe98575b1, 0xdc262302, 0xeb651b88, 0x23893e81, 0xd396acc5, 0x0f6d6ff3, 0x83f44239,
			0x2e0b4482, 0xa4842004, 0x69c8f04a, 0x9e1f9b5e, 0x21c66842, 0xf6e96c9a, 0x670c9c61, 0xabd388f0,
			0x6a51a0d2, 0xd8542f68, 0x960fa728, 0xab5133a3, 0x6eef0b6c, 0x137a3be4, 0xba3bf050, 0x7efb2a98,
			0xa1f1651d, 0x39af0176, 0x66ca593e, 0x82430e88, 0x8cee8619, 0x456f9fb4, 0x7d84a5c3, 0x3b8b5ebe,
			0xe06f75d8, 0x85c12073, 0x401a449f, 0x56c16aa6, 0x4ed3aa62, 0x363f7706, 0x1bfedf72, 0x429b023d,
			0x37d0d724, 0xd00a1248, 0xdb0fead3, 0x49f1c09b, 0x075372c9, 0x80991b7b, 0x25d479d8, 0xf6e8def7,
			0xe3fe501a, 0xb6794c3b, 0x976ce0bd, 0x04c006ba, 0xc1a94fb6, 0x409f60c4, 0x5e5c9ec2, 0x196a2463,
			0x68fb6faf, 0x3e6c53b5, 0x1339b2eb, 0x3b52ec6f, 0x6dfc511f, 0x9b30952c, 0xcc814544, 0xaf5ebd09,
			0xbee3d004, 0xde334afd, 0x660f2807, 0x192e4bb3, 0xc0cba857, 0x45c8740f, 0xd20b5f39, 0xb9d3fbdb,
			0x5579c0bd, 0x1a60320a, 0xd6a100c6, 0x402c7279, 0x679f25fe, 0xfb1fa3cc, 0x8ea5e9f8, 0xdb3222f8,
			0x3c7516df, 0xfd616b15, 0x2f501ec8, 0xad0552ab, 0x323db5fa, 0xfd238760, 0x53317b48, 0x3e00df82,
			0x9e5c57bb, 0xca6f8ca0, 0x1a87562e, 0xdf1769db, 0xd542a8f6, 0x287effc3, 0xac6732c6, 0x8c4f5573,
			0x695b27b0, 0xbbca58c8, 0xe1ffa35d, 0xb8f011a0, 0x10fa3d98, 0xfd2183b8, 0x4afcb56c, 0x2dd1d35b,
			0x9a53e479, 0xb6f84565, 0xd28e49bc, 0x4bfb9790, 0xe1ddf2da, 0xa4cb7e33, 0x62fb1341, 0xcee4c6e8,
			0xef20cada, 0x36774c01, 0xd07e9efe, 0x2bf11fb4, 0x95dbda4d, 0xae909198, 0xeaad8e71, 0x6b93d5a0,
			0xd08ed1d0, 0xafc725e0, 0x8e3c5b2f, 0x8e7594b7, 0x8ff6e2fb, 0xf2122b64, 0x8888b812, 0x900df01c,
			0x4fad5ea0, 0x688fc31c, 0xd1cff191, 0xb3a8c1ad, 0x2f2f2218, 0xbe0e1777, 0xea752dfe, 0x8b021fa1,
			0xe5a0cc0f, 0xb56f74e8, 0x18acf3d6, 0xce89e299, 0xb4a84fe0, 0xfd13e0b7, 0x7cc43b81, 0xd2ada8d9,
			0x165fa266, 0x80957705, 0x93cc7314, 0x211a1477, 0xe6ad2065, 0x77b5fa86, 0xc75442f5, 0xfb9d35cf,
			0xebcdaf0c, 0x7b3e89a0, 0xd6411bd3, 0xae1e7e49, 0x00250e2d, 0x2071b35e, 0x226800bb, 0x57b8e0af,
			0x2464369b, 0xf009b91e, 0x5563911d, 0x59dfa6aa, 0x78c14389, 0xd95a537f, 0x207d5ba2, 0x02e5b9c5,
			0x83260376, 0x6295cfa9, 0x11c81968, 0x4e734a41, 0xb3472dca, 0x7b14a94a, 0x1b510052, 0x9a532915,
			0xd60f573f, 0xbc9bc6e4, 0x2b60a476, 0x81e67400, 0x08ba6fb5, 0x571be91f, 0xf296ec6b, 0x2a0dd915,
			0xb6636521, 0xe7b9f9b6, 0xff34052e, 0xc5855664, 0x53b02d5d, 0xa99f8fa1, 0x08ba4799, 0x6e85076a
		), array(
			0x4b7a70e9, 0xb5b32944, 0xdb75092e, 0xc4192623, 0xad6ea6b0, 0x49a7df7d, 0x9cee60b8, 0x8fedb266,
			0xecaa8c71, 0x699a17ff, 0x5664526c, 0xc2b19ee1, 0x193602a5, 0x75094c29, 0xa0591340, 0xe4183a3e,
			0x3f54989a, 0x5b429d65, 0x6b8fe4d6, 0x99f73fd6, 0xa1d29c07, 0xefe830f5, 0x4d2d38e6, 0xf0255dc1,
			0x4cdd2086, 0x8470eb26, 0x6382e9c6, 0x021ecc5e, 0x09686b3f, 0x3ebaefc9, 0x3c971814, 0x6b6a70a1,
			0x687f3584, 0x52a0e286, 0xb79c5305, 0xaa500737, 0x3e07841c, 0x7fdeae5c, 0x8e7d44ec, 0x5716f2b8,
			0xb03ada37, 0xf0500c0d, 0xf01c1f04, 0x0200b3ff, 0xae0cf51a, 0x3cb574b2, 0x25837a58, 0xdc0921bd,
			0xd19113f9, 0x7ca92ff6, 0x94324773, 0x22f54701, 0x3ae5e581, 0x37c2dadc, 0xc8b57634, 0x9af3dda7,
			0xa9446146, 0x0fd0030e, 0xecc8c73e, 0xa4751e41, 0xe238cd99, 0x3bea0e2f, 0x3280bba1, 0x183eb331,
			0x4e548b38, 0x4f6db908, 0x6f420d03, 0xf60a04bf, 0x2cb81290, 0x24977c79, 0x5679b072, 0xbcaf89af,
			0xde9a771f, 0xd9930810, 0xb38bae12, 0xdccf3f2e, 0x5512721f, 0x2e6b7124, 0x501adde6, 0x9f84cd87,
			0x7a584718, 0x7408da17, 0xbc9f9abc, 0xe94b7d8c, 0xec7aec3a, 0xdb851dfa, 0x63094366, 0xc464c3d2,
			0xef1c1847, 0x3215d908, 0xdd433b37, 0x24c2ba16, 0x12a14d43, 0x2a65c451, 0x50940002, 0x133ae4dd,
			0x71dff89e, 0x10314e55, 0x81ac77d6, 0x5f11199b, 0x043556f1, 0xd7a3c76b, 0x3c11183b, 0x5924a509,
			0xf28fe6ed, 0x97f1fbfa, 0x9ebabf2c, 0x1e153c6e, 0x86e34570, 0xeae96fb1, 0x860e5e0a, 0x5a3e2ab3,
			0x771fe71c, 0x4e3d06fa, 0x2965dcb9, 0x99e71d0f, 0x803e89d6, 0x5266c825, 0x2e4cc978, 0x9c10b36a,
			0xc6150eba, 0x94e2ea78, 0xa5fc3c53, 0x1e0a2df4, 0xf2f74ea7, 0x361d2b3d, 0x1939260f, 0x19c27960,
			0x5223a708, 0xf71312b6, 0xebadfe6e, 0xeac31f66, 0xe3bc4595, 0xa67bc883, 0xb17f37d1, 0x018cff28,
			0xc332ddef, 0xbe6c5aa5, 0x65582185, 0x68ab9802, 0xeecea50f, 0xdb2f953b, 0x2aef7dad, 0x5b6e2f84,
			0x1521b628, 0x29076170, 0xecdd4775, 0x619f1510, 0x13cca830, 0xeb61bd96, 0x0334fe1e, 0xaa0363cf,
			0xb5735c90, 0x4c70a239, 0xd59e9e0b, 0xcbaade14, 0xeecc86bc, 0x60622ca7, 0x9cab5cab, 0xb2f3846e,
			0x648b1eaf, 0x19bdf0ca, 0xa02369b9, 0x655abb50, 0x40685a32, 0x3c2ab4b3, 0x319ee9d5, 0xc021b8f7,
			0x9b540b19, 0x875fa099, 0x95f7997e, 0x623d7da8, 0xf837889a, 0x97e32d77, 0x11ed935f, 0x16681281,
			0x0e358829, 0xc7e61fd6, 0x96dedfa1, 0x7858ba99, 0x57f584a5, 0x1b227263, 0x9b83c3ff, 0x1ac24696,
			0xcdb30aeb, 0x532e3054, 0x8fd948e4, 0x6dbc3128, 0x58ebf2ef, 0x34c6ffea, 0xfe28ed61, 0xee7c3c73,
			0x5d4a14d9, 0xe864b7e3, 0x42105d14, 0x203e13e0, 0x45eee2b6, 0xa3aaabea, 0xdb6c4f15, 0xfacb4fd0,
			0xc742f442, 0xef6abbb5, 0x654f3b1d, 0x41cd2105, 0xd81e799e, 0x86854dc7, 0xe44b476a, 0x3d816250,
			0xcf62a1f2, 0x5b8d2646, 0xfc8883a0, 0xc1c7b6a3, 0x7f1524c3, 0x69cb7492, 0x47848a0b, 0x5692b285,
			0x095bbf00, 0xad19489d, 0x1462b174, 0x23820e00, 0x58428d2a, 0x0c55f5ea, 0x1dadf43e, 0x233f7061,
			0x3372f092, 0x8d937e41, 0xd65fecf1, 0x6c223bdb, 0x7cde3759, 0xcbee7460, 0x4085f2a7, 0xce77326e,
			0xa6078084, 0x19f8509e, 0xe8efd855, 0x61d99735, 0xa969a7aa, 0xc50c06c2, 0x5a04abfc, 0x800bcadc,
			0x9e447a2e, 0xc3453484, 0xfdd56705, 0x0e1e9ec9, 0xdb73dbd3, 0x105588cd, 0x675fda79, 0xe3674340,
			0xc5c43465, 0x713e38d8, 0x3d28f89e, 0xf16dff20, 0x153e21e7, 0x8fb03d4a, 0xe6e39f2b, 0xdb83adf7
		), array(
			0xe93d5a68, 0x948140f7, 0xf64c261c, 0x94692934, 0x411520f7, 0x7602d4f7, 0xbcf46b2e, 0xd4a20068,
			0xd4082471, 0x3320f46a, 0x43b7d4b7, 0x500061af, 0x1e39f62e, 0x97244546, 0x14214f74, 0xbf8b8840,
			0x4d95fc1d, 0x96b591af, 0x70f4ddd3, 0x66a02f45, 0xbfbc09ec, 0x03bd9785, 0x7fac6dd0, 0x31cb8504,
			0x96eb27b3, 0x55fd3941, 0xda2547e6, 0xabca0a9a, 0x28507825, 0x530429f4, 0x0a2c86da, 0xe9b66dfb,
			0x68dc1462, 0xd7486900, 0x680ec0a4, 0x27a18dee, 0x4f3ffea2, 0xe887ad8c, 0xb58ce006, 0x7af4d6b6,
			0xaace1e7c, 0xd3375fec, 0xce78a399, 0x406b2a42, 0x20fe9e35, 0xd9f385b9, 0xee39d7ab, 0x3b124e8b,
			0x1dc9faf7, 0x4b6d1856, 0x26a36631, 0xeae397b2, 0x3a6efa74, 0xdd5b4332, 0x6841e7f7, 0xca7820fb,
			0xfb0af54e, 0xd8feb397, 0x454056ac, 0xba489527, 0x55533a3a, 0x20838d87, 0xfe6ba9b7, 0xd096954b,
			0x55a867bc, 0xa1159a58, 0xcca92963, 0x99e1db33, 0xa62a4a56, 0x3f3125f9, 0x5ef47e1c, 0x9029317c,
			0xfdf8e802, 0x04272f70, 0x80bb155c, 0x05282ce3, 0x95c11548, 0xe4c66d22, 0x48c1133f, 0xc70f86dc,
			0x07f9c9ee, 0x41041f0f, 0x404779a4, 0x5d886e17, 0x325f51eb, 0xd59bc0d1, 0xf2bcc18f, 0x41113564,
			0x257b7834, 0x602a9c60, 0xdff8e8a3, 0x1f636c1b, 0x0e12b4c2, 0x02e1329e, 0xaf664fd1, 0xcad18115,
			0x6b2395e0, 0x333e92e1, 0x3b240b62, 0xeebeb922, 0x85b2a20e, 0xe6ba0d99, 0xde720c8c, 0x2da2f728,
			0xd0127845, 0x95b794fd, 0x647d0862, 0xe7ccf5f0, 0x5449a36f, 0x877d48fa, 0xc39dfd27, 0xf33e8d1e,
			0x0a476341, 0x992eff74, 0x3a6f6eab, 0xf4f8fd37, 0xa812dc60, 0xa1ebddf8, 0x991be14c, 0xdb6e6b0d,
			0xc67b5510, 0x6d672c37, 0x2765d43b, 0xdcd0e804, 0xf1290dc7, 0xcc00ffa3, 0xb5390f92, 0x690fed0b,
			0x667b9ffb, 0xcedb7d9c, 0xa091cf0b, 0xd9155ea3, 0xbb132f88, 0x515bad24, 0x7b9479bf, 0x763bd6eb,
			0x37392eb3, 0xcc115979, 0x8026e297, 0xf42e312d, 0x6842ada7, 0xc66a2b3b, 0x12754ccc, 0x782ef11c,
			0x6a124237, 0xb79251e7, 0x06a1bbe6, 0x4bfb6350, 0x1a6b1018, 0x11caedfa, 0x3d25bdd8, 0xe2e1c3c9,
			0x44421659, 0x0a121386, 0xd90cec6e, 0xd5abea2a, 0x64af674e, 0xda86a85f, 0xbebfe988, 0x64e4c3fe,
			0x9dbc8057, 0xf0f7c086, 0x60787bf8, 0x6003604d, 0xd1fd8346, 0xf6381fb0, 0x7745ae04, 0xd736fccc,
			0x83426b33, 0xf01eab71, 0xb0804187, 0x3c005e5f, 0x77a057be, 0xbde8ae24, 0x55464299, 0xbf582e61,
			0x4e58f48f, 0xf2ddfda2, 0xf474ef38, 0x8789bdc2, 0x5366f9c3, 0xc8b38e74, 0xb475f255, 0x46fcd9b9,
			0x7aeb2661, 0x8b1ddf84, 0x846a0e79, 0x915f95e2, 0x466e598e, 0x20b45770, 0x8cd55591, 0xc902de4c,
			0xb90bace1, 0xbb8205d0, 0x11a86248, 0x7574a99e, 0xb77f19b6, 0xe0a9dc09, 0x662d09a1, 0xc4324633,
			0xe85a1f02, 0x09f0be8c, 0x4a99a025, 0x1d6efe10, 0x1ab93d1d, 0x0ba5a4df, 0xa186f20f, 0x2868f169,
			0xdcb7da83, 0x573906fe, 0xa1e2ce9b, 0x4fcd7f52, 0x50115e01, 0xa70683fa, 0xa002b5c4, 0x0de6d027,
			0x9af88c27, 0x773f8641, 0xc3604c06, 0x61a806b5, 0xf0177a28, 0xc0f586e0, 0x006058aa, 0x30dc7d62,
			0x11e69ed7, 0x2338ea63, 0x53c2dd94, 0xc2c21634, 0xbbcbee56, 0x90bcb6de, 0xebfc7da1, 0xce591d76,
			0x6f05e409, 0x4b7c0188, 0x39720a3d, 0x7c927c24, 0x86e3725f, 0x724d9db9, 0x1ac15bb4, 0xd39eb8fc,
			0xed545578, 0x08fca5b5, 0xd83d7cd3, 0x4dad0fc4, 0x1e50ef5e, 0xb161e6f8, 0xa28514d9, 0x6c51133c,
			0x6fd5c7e7, 0x56e14ec4, 0x362abfce, 0xddc6c837, 0xd79a3234, 0x92638212, 0x670efa8e, 0x406000e0
		), array(
			0x3a39ce37, 0xd3faf5cf, 0xabc27737, 0x5ac52d1b, 0x5cb0679e, 0x4fa33742, 0xd3822740, 0x99bc9bbe,
			0xd5118e9d, 0xbf0f7315, 0xd62d1c7e, 0xc700c47b, 0xb78c1b6b, 0x21a19045, 0xb26eb1be, 0x6a366eb4,
			0x5748ab2f, 0xbc946e79, 0xc6a376d2, 0x6549c2c8, 0x530ff8ee, 0x468dde7d, 0xd5730a1d, 0x4cd04dc6,
			0x2939bbdb, 0xa9ba4650, 0xac9526e8, 0xbe5ee304, 0xa1fad5f0, 0x6a2d519a, 0x63ef8ce2, 0x9a86ee22,
			0xc089c2b8, 0x43242ef6, 0xa51e03aa, 0x9cf2d0a4, 0x83c061ba, 0x9be96a4d, 0x8fe51550, 0xba645bd6,
			0x2826a2f9, 0xa73a3ae1, 0x4ba99586, 0xef5562e9, 0xc72fefd3, 0xf752f7da, 0x3f046f69, 0x77fa0a59,
			0x80e4a915, 0x87b08601, 0x9b09e6ad, 0x3b3ee593, 0xe990fd5a, 0x9e34d797, 0x2cf0b7d9, 0x022b8b51,
			0x96d5ac3a, 0x017da67d, 0xd1cf3ed6, 0x7c7d2d28, 0x1f9f25cf, 0xadf2b89b, 0x5ad6b472, 0x5a88f54c,
			0xe029ac71, 0xe019a5e6, 0x47b0acfd, 0xed93fa9b, 0xe8d3c48d, 0x283b57cc, 0xf8d56629, 0x79132e28,
			0x785f0191, 0xed756055, 0xf7960e44, 0xe3d35e8c, 0x15056dd4, 0x88f46dba, 0x03a16125, 0x0564f0bd,
			0xc3eb9e15, 0x3c9057a2, 0x97271aec, 0xa93a072a, 0x1b3f6d9b, 0x1e6321f5, 0xf59c66fb, 0x26dcf319,
			0x7533d928, 0xb155fdf5, 0x03563482, 0x8aba3cbb, 0x28517711, 0xc20ad9f8, 0xabcc5167, 0xccad925f,
			0x4de81751, 0x3830dc8e, 0x379d5862, 0x9320f991, 0xea7a90c2, 0xfb3e7bce, 0x5121ce64, 0x774fbe32,
			0xa8b6e37e, 0xc3293d46, 0x48de5369, 0x6413e680, 0xa2ae0810, 0xdd6db224, 0x69852dfd, 0x09072166,
			0xb39a460a, 0x6445c0dd, 0x586cdecf, 0x1c20c8ae, 0x5bbef7dd, 0x1b588d40, 0xccd2017f, 0x6bb4e3bb,
			0xdda26a7e, 0x3a59ff45, 0x3e350a44, 0xbcb4cdd5, 0x72eacea8, 0xfa6484bb, 0x8d6612ae, 0xbf3c6f47,
			0xd29be463, 0x542f5d9e, 0xaec2771b, 0xf64e6370, 0x740e0d8d, 0xe75b1357, 0xf8721671, 0xaf537d5d,
			0x4040cb08, 0x4eb4e2cc, 0x34d2466a, 0x0115af84, 0xe1b00428, 0x95983a1d, 0x06b89fb4, 0xce6ea048,
			0x6f3f3b82, 0x3520ab82, 0x011a1d4b, 0x277227f8, 0x611560b1, 0xe7933fdc, 0xbb3a792b, 0x344525bd,
			0xa08839e1, 0x51ce794b, 0x2f32c9b7, 0xa01fbac9, 0xe01cc87e, 0xbcc7d1f6, 0xcf0111c3, 0xa1e8aac7,
			0x1a908749, 0xd44fbd9a, 0xd0dadecb, 0xd50ada38, 0x0339c32a, 0xc6913667, 0x8df9317c, 0xe0b12b4f,
			0xf79e59b7, 0x43f5bb3a, 0xf2d519ff, 0x27d9459c, 0xbf97222c, 0x15e6fc2a, 0x0f91fc71, 0x9b941525,
			0xfae59361, 0xceb69ceb, 0xc2a86459, 0x12baa8d1, 0xb6c1075e, 0xe3056a0c, 0x10d25065, 0xcb03a442,
			0xe0ec6e0e, 0x1698db3b, 0x4c98a0be, 0x3278e964, 0x9f1f9532, 0xe0d392df, 0xd3a0342b, 0x8971f21e,
			0x1b0a7441, 0x4ba3348c, 0xc5be7120, 0xc37632d8, 0xdf359f8d, 0x9b992f2e, 0xe60b6f47, 0x0fe3f11d,
			0xe54cda54, 0x1edad891, 0xce6279cf, 0xcd3e7e6f, 0x1618b166, 0xfd2c1d05, 0x848fd2c5, 0xf6fb2299,
			0xf523f357, 0xa6327623, 0x93a83531, 0x56cccd02, 0xacf08162, 0x5a75ebb5, 0x6e163697, 0x88d273cc,
			0xde966292, 0x81b949d0, 0x4c50901b, 0x71c65614, 0xe6c6c7bd, 0x327a140a, 0x45e1d006, 0xc3f27b9a,
			0xc9aa53fd, 0x62a80f00, 0xbb25bfe2, 0x35bdd2f6, 0x71126905, 0xb2040222, 0xb6cbcf7c, 0xcd769c2b,
			0x53113ec0, 0x1640e3d3, 0x38abbd60, 0x2547adf0, 0xba38209c, 0xf746ce76, 0x77afa1c5, 0x20756060,
			0x85cbfe4e, 0x8ae88dd8, 0x7aaaf9b0, 0x4cf9aa7e, 0x1948c25c, 0x02fb8a8c, 0x01c36ae4, 0xd6ebe1f9,
			0x90d4f869, 0xa65cdea0, 0x3f09252d, 0xc208e69f, 0xb74e6132, 0xce77e25b, 0x578fdfe3, 0x3ac372e6
		)
	);
	protected static $bfp = array(
		0x243f6a88, 0x85a308d3, 0x13198a2e, 0x03707344, 0xa4093822, 0x299f31d0,
		0x082efa98, 0xec4e6c89, 0x452821e6, 0x38d01377, 0xbe5466cf, 0x34e90c6c,
		0xc0ac29b7, 0xc97c50dd, 0x3f84d5b5, 0xb5470917, 0x9216d5d9, 0x8979fb1b
	);
	private static function blowfish_setup_key($key, $length){
		$p = array();
		$s = self::$bfs;
		$pa = self::$bfp;
		$key = array_values(unpack('C*', $key));
		for($j = 0, $i = 0; $i < 18; ++$i) {
			for($data = 0, $k = 0; $k < 4; ++$k) {
				$data = ($data << 8) | $key[$j];
				if(++$j >= $length)
					$j = 0;
			}
			$p[] = $pa[$i] ^ $data;
		}
		$data = "\0\0\0\0\0\0\0\0";
		for($i = 0; $i < 18; $i += 2) {
			list($l, $r) = self::blowfish_encrypt($data, array($p, $s));
			$data = pack('N2', $l, $r);
			$p[$i	] = $l;
			$p[$i + 1] = $r;
		}
		for($i = 0; $i < 4; ++$i) {
			for($j = 0; $j < 256; $j += 2) {
				list($l, $r) = self::blowfish_encrypt($data, array($p, $s));
				$data = pack('N2', $l, $r);
				$s[$i][$j	] = $l;
				$s[$i][$j + 1] = $r;
			}
		}
		return array($p, $s);
	}
	private static function blowfish_encrypt($in, $key){
		$p = $key[0];
		$s0 = $key[1][0];
		$s1 = $key[1][1];
		$s2 = $key[1][2];
		$s3 = $key[1][3];
		$in = unpack('N2', $in);
		$l = $in[1];
		$r = $in[2];
		for($i = 0; $i < 16; $i+= 2) {
			$l^= $p[$i];
			$r^= (($s0[$l >> 24 & 0xff] + $s1[$l >> 16 & 0xff]) ^ $s2[$l >> 8 & 0xff]) + $s3[$l & 0xff];
			$r^= $p[$i + 1];
			$l^= (($s0[$r >> 24 & 0xff] + $s1[$r >> 16 & 0xff]) ^ $s2[$r >> 8 & 0xff]) + $s3[$r & 0xff];
		}
		return array($r ^ $p[17], $l ^ $p[16]);
	}
	private static function blowfish_decrypt($in, $key){
		$p = $key[0];
		$s0 = $key[1][0];
		$s1 = $key[1][1];
		$s2 = $key[1][2];
		$s3 = $key[1][3];
		$in = unpack('N2', $in);
		$l = $in[1];
		$r = $in[2];
		for($i = 17; $i > 2; $i-= 2) {
			$l^= $p[$i];
			$r^= (($s0[$l >> 24 & 0xff] + $s1[$l >> 16 & 0xff]) ^ $s2[$l >> 8 & 0xff]) + $s3[$l & 0xff];
			$r^= $p[$i - 1];
			$l^= (($s0[$r >> 24 & 0xff] + $s1[$r >> 16 & 0xff]) ^ $s2[$r >> 8 & 0xff]) + $s3[$r & 0xff];
		}
		return array($r ^ $p[0], $l ^ $p[1]);
	}
	private static function salsa_n($x, $rounds = 20){
		list(, $x0, $x1, $x2, $x3, $x4, $x5, $x6, $x7, $x8, $x9, $x10, $x11, $x12, $x13, $x14, $x15) = unpack('V*', $x);
		$p0 = $x0;   $p1 = $x1;   $p2 = $x2;   $p3 = $x3;
		$p4 = $x4;   $p5 = $x5;   $p6 = $x6;   $p7 = $x7;
		$p8 = $x8;   $p9 = $x9;   $p10 = $x10; $p11 = $x11;
		$p12 = $x12; $p13 = $x13; $p14 = $x14; $p15 = $x15;
		$rounds = (int)($rounds / 2);
		for($i = 0; $i < $rounds; ++$i){
			$x0+= $x4;   $x12^= $x0; $x12 = math::rtl32($x12, 16);
			$x8+= $x12;  $x4^= $x8;  $x4 = math::rtl32($x4, 12);
			$x0+= $x4;   $x12^= $x0; $x12 = math::rtl32($x12, 8);
			$x8+= $x12;  $x4^= $x8;  $x4 = math::rtl32($x4, 7);
			$x1+= $x5;   $x13^= $x1; $x13 = math::rtl32($x13, 16);
			$x9+= $x13;  $x5^= $x9;  $x5 = math::rtl32($x5, 12);
			$x1+= $x5;   $x13^= $x1; $x13 = math::rtl32($x13, 8);
			$x9+= $x13;  $x5^= $x9;  $x5 = math::rtl32($x5, 7);
			$x2+= $x6;   $x14^= $x2; $x14 = math::rtl32($x14, 16);
			$x10+= $x14; $x6^= $x10; $x6 = math::rtl32($x6, 12);
			$x2+= $x6;   $x14^= $x2; $x14 = math::rtl32($x14, 8);
			$x10+= $x14; $x6^= $x10; $x6 = math::rtl32($x6, 7);
			$x3+= $x7;   $x15^= $x3; $x15 = math::rtl32($x15, 16);
			$x11+= $x15; $x7^= $x11; $x7 = math::rtl32($x7, 12);
			$x3+= $x7;   $x15^= $x3; $x15 = math::rtl32($x15, 8);
			$x11+= $x15; $x7^= $x11; $x7 = math::rtl32($x7, 7);
			$x0+= $x5;   $x15^= $x0; $x15 = math::rtl32($x15, 16);
			$x10+= $x15; $x5^= $x10; $x5 = math::rtl32($x5, 12);
			$x0+= $x5;   $x15^= $x0; $x15 = math::rtl32($x15, 8);
			$x10+= $x15; $x5^= $x10; $x5 = math::rtl32($x5, 7);
			$x1+= $x6;   $x12^= $x1; $x12 = math::rtl32($x12, 16);
			$x11+= $x12; $x6^= $x11; $x6 = math::rtl32($x6, 12);
			$x1+= $x6;   $x12^= $x1; $x12 = math::rtl32($x12, 8);
			$x11+= $x12; $x6^= $x11; $x6 = math::rtl32($x6, 7);
			$x2+= $x7;   $x13^= $x2; $x13 = math::rtl32($x13, 16);
			$x8+= $x13;  $x7^= $x8;  $x7 = math::rtl32($x7, 12);
			$x2+= $x7;   $x13^= $x2; $x13 = math::rtl32($x13, 8);
			$x8+= $x13;  $x7^= $x8;  $x7 = math::rtl32($x7, 7);
			$x3+= $x4;   $x14^= $x3; $x14 = math::rtl32($x14, 16);
			$x9+= $x14;  $x4^= $x9;  $x4 = math::rtl32($x4, 12);
			$x3+= $x4;   $x14^= $x3; $x14 = math::rtl32($x14, 8);
			$x9+= $x14;  $x4^= $x9;  $x4 = math::rtl32($x4, 7);
		}
		$x0+= $p0;   $x1+= $p1;   $x2+= $p2;   $x3+= $p3;
		$x4+= $p4;   $x5+= $p5;   $x6+= $p6;   $x7+= $p7;
		$x8+= $p8;   $x9+= $p9;   $x10+= $p10; $x11+= $p11;
		$x12+= $p12; $x13+= $p13; $x14+= $p14; $x15+= $p15;
		return pack('V*', $x0, $x1, $x2, $x3, $x4, $x5, $x6, $x7, $x8, $x9, $x10, $x11, $x12, $x13, $x14, $x15);
	}
	public static function xor_crypt($message, $key){
		return $message ^ str::equlen($message, $key);
	}
	public static function vigenere_prepare($string){
		return preg_replace("/[^A-Z]/", '', strtoupper($string));
	}
	public static function vigenere_encrypt($message, $key){
		$message = self::vigenere_prepare($message);
		$length = strlen($message);
		$key = str::subrep(self::vigenere_prepare($key), $length);
		for($i = 0; $i < $length; ++$i){
			$row = ord($key[$i]) - 65;
			$col = ord($message[$i]) - 65;
			$message[$i] = chr(($row + $col) % 26 + 65);
		}
		return $message;
	}
	public static function vigenere_decrypt($message, $key){
		$message = self::vigenere_prepare($message);
		$length = strlen($message);
		$key = str::subrep(self::vigenere_prepare($key), $length);
		for($i = 0; $i < $length; ++$i){
			$row = ord($key[$i]) - 65;
			$col = ord($message[$i]) - 65;
			$message[$i] = chr(($row > $col ? $col - $row + 26 : $col - $row) + 65);
		}
		return $message;
	}
	public static function enigma_setup_key($key){ // length 13 bytes
		$t1 = $deck = array();
		$t3 = $t2 = array_fill(0, 256, 0);
		$length = strlen($key);
		$seed = 123;
		for($i = 0; $i < 13; ++$i)
			$seed = ($seed & 0xffffffff) * ord($key[$i]) + $i;
		for($i = 0; $i < 256; ++$i){
			$t1[] = $i;
			$deck[] = $i;
		}
		for($i = 0; $i < 256; ++$i){
			$seed = (5 * ($seed & 0xffffffff) + ord($key[$i % 13])) & 0xffffffff;
			$random = $seed % 65521;
			$k = 255 - $i;
			$ic = ($random & 0377) % ($k + 1);
			$random = $random >> 8;
			$temp = $t1[$k];
			$t1[$k] = $t1[$ic];
			$t1[$ic] = $temp;
			if($t3[$k] != 0)
				continue;
			$ic = ($random & 0377) % $k;
			while($t3[$ic] != 0)
				$ic = ($ic + 1) % $k;
			$t3[$k] = $ic;
			$t3[$ic] = $k;
		}
		for($i = 0; $i < 256; ++$i){
			$pos = $t1[$i] & 0377;
			$t2[$pos] = $i;
		}
		return array($deck, array($t1, $t2, $t3));
	}
	public static function enigma($message, $key){
		$nr2 = $nr1 = $n2 = $n1 = 0;
		$t1 = $key[1][0];
		$t2 = $key[1][1];
		$t3 = $key[1][2];
		for($j = 0; isset($message[$j]); ++$j){
			$i = ord($message[$j]);
			$nr1 = $n1;
			$pos1 = ($i + $nr1) & 0377;
			$pos3 = ($t1[$pos1] + $nr2) & 0377;
			$pos2 = ($t3[$pos3] - $nr2) & 0377;
			$i = $t2[$pos2] - $nr1;
			$message[$j] = chr($i);
			++$n1;
			if($n1 == 256){
				$n1 = 0;
				$nr2 = $n2 = ($n2 + 1) & 0xff;
			}
		}
		return $message;
	}
	protected static $skipjackF = array(
		0xa3, 0xd7, 0x09, 0x83, 0xf8, 0x48, 0xf6, 0xf4, 0xb3, 0x21, 0x15, 0x78, 0x99, 0xb1, 0xaf, 0xf9,
		0xe7, 0x2d, 0x4d, 0x8a, 0xce, 0x4c, 0xca, 0x2e, 0x52, 0x95, 0xd9, 0x1e, 0x4e, 0x38, 0x44, 0x28,
		0x0a, 0xdf, 0x02, 0xa0, 0x17, 0xf1, 0x60, 0x68, 0x12, 0xb7, 0x7a, 0xc3, 0xe9, 0xfa, 0x3d, 0x53,
		0x96, 0x84, 0x6b, 0xba, 0xf2, 0x63, 0x9a, 0x19, 0x7c, 0xae, 0xe5, 0xf5, 0xf7, 0x16, 0x6a, 0xa2,
		0x39, 0xb6, 0x7b, 0x0f, 0xc1, 0x93, 0x81, 0x1b, 0xee, 0xb4, 0x1a, 0xea, 0xd0, 0x91, 0x2f, 0xb8,
		0x55, 0xb9, 0xda, 0x85, 0x3f, 0x41, 0xbf, 0xe0, 0x5a, 0x58, 0x80, 0x5f, 0x66, 0x0b, 0xd8, 0x90,
		0x35, 0xd5, 0xc0, 0xa7, 0x33, 0x06, 0x65, 0x69, 0x45, 0x00, 0x94, 0x56, 0x6d, 0x98, 0x9b, 0x76,
		0x97, 0xfc, 0xb2, 0xc2, 0xb0, 0xfe, 0xdb, 0x20, 0xe1, 0xeb, 0xd6, 0xe4, 0xdd, 0x47, 0x4a, 0x1d,
		0x42, 0xed, 0x9e, 0x6e, 0x49, 0x3c, 0xcd, 0x43, 0x27, 0xd2, 0x07, 0xd4, 0xde, 0xc7, 0x67, 0x18,
		0x89, 0xcb, 0x30, 0x1f, 0x8d, 0xc6, 0x8f, 0xaa, 0xc8, 0x74, 0xdc, 0xc9, 0x5d, 0x5c, 0x31, 0xa4,
		0x70, 0x88, 0x61, 0x2c, 0x9f, 0x0d, 0x2b, 0x87, 0x50, 0x82, 0x54, 0x64, 0x26, 0x7d, 0x03, 0x40,
		0x34, 0x4b, 0x1c, 0x73, 0xd1, 0xc4, 0xfd, 0x3b, 0xcc, 0xfb, 0x7f, 0xab, 0xe6, 0x3e, 0x5b, 0xa5,
		0xad, 0x04, 0x23, 0x9c, 0x14, 0x51, 0x22, 0xf0, 0x29, 0x79, 0x71, 0x7e, 0xff, 0x8c, 0x0e, 0xe2,
		0x0c, 0xef, 0xbc, 0x72, 0x75, 0x6f, 0x37, 0xa1, 0xec, 0xd3, 0x8e, 0x62, 0x8b, 0x86, 0x10, 0xe8,
		0x08, 0x77, 0x11, 0xbe, 0x92, 0x4f, 0x24, 0xc5, 0x32, 0x36, 0x9d, 0xcf, 0xf3, 0xa6, 0xbb, 0xac,
		0x5e, 0x6c, 0xa9, 0x13, 0x57, 0x25, 0xb5, 0xe3, 0xbd, 0xa8, 0x3a, 0x01, 0x05, 0x59, 0x2a, 0x46
	);
	public static function skipjack_gPermutation($bytes, $key, $decrypt = false){
		$l = ord($bytes[0]);
		$r = ord($bytes[1]);
		if($decrypt)
			for($i = 0; $i < 4; ++$i)
				if($i == 0 || $i == 2)
					$l ^= self::$skipjackF[$r ^ ord($key[$i])];
				else
					$r ^= self::$skipjackF[$l ^ ord($key[$i])];
		else
			for($i = 3; $i >= 0; --$i)
				if($i == 0 || $i == 2)
					$l ^= self::$skipjackF[$r ^ ord($key[$i])];
				else
					$r ^= self::$skipjackF[$l ^ ord($key[$i])];
		return chr($l) . chr($r);
	}
	public static function skipjack_ruleA($bytes, $key, $i, $decrypt = false){
		$w = str_split($bytes, 2);
		if($decrypt){
			$w[4] = $w[0] ^ $w[1] ^ math::decstr($i);
			$w[0] = self::skipjack_gPermutation($w[1], $key, true);
			$w[1] = $w[2];
			$w[2] = $w[3];
			$w[3] = $w[4];
		}else{
			$w[4] = $w[3];
			$w[3] = $w[2];
			$w[2] = $w[1];
			$w[1] = self::skipjack_gPermutation($w[0], $key);
			$w[0] = $w[1] ^ $w[4] ^ math::decstr($i);
		}
		return $w[0] . $w[1] . $w[2] . $w[3];
	}
	public static function skipjack_ruleB($bytes, $key, $i, $decrypt = false){
		$w = str_split($bytes, 2);
		if($decrypt){
			$w[4] = $w[0];
			$w[0] = self::skipjack_gPermutation($w[1], $key, true);
			$w[1] = $w[0] ^ $w[2] ^ math::decstr($i);
			$w[2] = $w[3];
			$w[3] = $w[4];
		}else{
			$w[4] = $w[3];
			$w[3] = $w[2];
			$w[2] = $w[0] ^ $w[1] ^ math::decstr($i);
			$w[1] = self::skipjack_gPermutation($w[0], $key);
			$w[0] = $w[4];
		}
		return $w[0] . $w[1] . $w[2] . $w[3];
	}
	public static function skipjack_encrypt($message, $key){
		for($i = 1; $i <= 32; ++$i){
			$subkey = substr($key, 4 * $i - 4, 4);
			if($i >= 1 && $i <= 8)
				$message = self::skipjack_ruleA($message, $subkey, $i);
			if($i >= 9 && $i <= 16)
				$message = self::skipjack_ruleB($message, $subkey, $i);
			if($i >= 17 && $i <= 24)
				$message = self::skipjack_ruleA($message, $subkey, $i);
			if($i >= 25 && $i <= 32)
				$message = self::skipjack_ruleB($message, $subkey, $i);
		}
		return $message;
	}
	public static function skipjack_decrypt($message, $key){
		for($i = 32; $i >= 1; --$i){
			$subkey = substr($key, 4 * $i - 4, 4);
			if($i <= 32 && $i >= 25)
				$message = self::skipjack_ruleB($message, $subkey, $i, true);
			if($i <= 24 && $i >= 17)
				$message = self::skipjack_ruleA($message, $subkey, $i, true);
			if($i <= 16 && $i >= 9)
				$message = self::skipjack_ruleB($message, $subkey, $i, true);
			if($i <= 8 && $i >= 1)
				$message = self::skipjack_ruleA($message, $subkey, $i, true);
		}
		return $message;
	}
	protected static $rc2pi = array(
		0xD9, 0x78, 0xF9, 0xC4, 0x19, 0xDD, 0xB5, 0xED, 0x28, 0xE9, 0xFD, 0x79, 0x4A, 0xA0, 0xD8, 0x9D,
		0xC6, 0x7E, 0x37, 0x83, 0x2B, 0x76, 0x53, 0x8E, 0x62, 0x4C, 0x64, 0x88, 0x44, 0x8B, 0xFB, 0xA2,
		0x17, 0x9A, 0x59, 0xF5, 0x87, 0xB3, 0x4F, 0x13, 0x61, 0x45, 0x6D, 0x8D, 0x09, 0x81, 0x7D, 0x32,
		0xBD, 0x8F, 0x40, 0xEB, 0x86, 0xB7, 0x7B, 0x0B, 0xF0, 0x95, 0x21, 0x22, 0x5C, 0x6B, 0x4E, 0x82,
		0x54, 0xD6, 0x65, 0x93, 0xCE, 0x60, 0xB2, 0x1C, 0x73, 0x56, 0xC0, 0x14, 0xA7, 0x8C, 0xF1, 0xDC,
		0x12, 0x75, 0xCA, 0x1F, 0x3B, 0xBE, 0xE4, 0xD1, 0x42, 0x3D, 0xD4, 0x30, 0xA3, 0x3C, 0xB6, 0x26,
		0x6F, 0xBF, 0x0E, 0xDA, 0x46, 0x69, 0x07, 0x57, 0x27, 0xF2, 0x1D, 0x9B, 0xBC, 0x94, 0x43, 0x03,
		0xF8, 0x11, 0xC7, 0xF6, 0x90, 0xEF, 0x3E, 0xE7, 0x06, 0xC3, 0xD5, 0x2F, 0xC8, 0x66, 0x1E, 0xD7,
		0x08, 0xE8, 0xEA, 0xDE, 0x80, 0x52, 0xEE, 0xF7, 0x84, 0xAA, 0x72, 0xAC, 0x35, 0x4D, 0x6A, 0x2A,
		0x96, 0x1A, 0xD2, 0x71, 0x5A, 0x15, 0x49, 0x74, 0x4B, 0x9F, 0xD0, 0x5E, 0x04, 0x18, 0xA4, 0xEC,
		0xC2, 0xE0, 0x41, 0x6E, 0x0F, 0x51, 0xCB, 0xCC, 0x24, 0x91, 0xAF, 0x50, 0xA1, 0xF4, 0x70, 0x39,
		0x99, 0x7C, 0x3A, 0x85, 0x23, 0xB8, 0xB4, 0x7A, 0xFC, 0x02, 0x36, 0x5B, 0x25, 0x55, 0x97, 0x31,
		0x2D, 0x5D, 0xFA, 0x98, 0xE3, 0x8A, 0x92, 0xAE, 0x05, 0xDF, 0x29, 0x10, 0x67, 0x6C, 0xBA, 0xC9,
		0xD3, 0x00, 0xE6, 0xCF, 0xE1, 0x9E, 0xA8, 0x2C, 0x63, 0x16, 0x01, 0x3F, 0x58, 0xE2, 0x89, 0xA9,
		0x0D, 0x38, 0x34, 0x1B, 0xAB, 0x33, 0xFF, 0xB0, 0xBB, 0x48, 0x0C, 0x5F, 0xB9, 0xB1, 0xCD, 0x2E,
		0xC5, 0xF3, 0xDB, 0x47, 0xE5, 0xA5, 0x9C, 0x77, 0x0A, 0xA6, 0x20, 0x68, 0xFE, 0x7F, 0xC1, 0xAD,
		0xD9, 0x78, 0xF9, 0xC4, 0x19, 0xDD, 0xB5, 0xED, 0x28, 0xE9, 0xFD, 0x79, 0x4A, 0xA0, 0xD8, 0x9D,
		0xC6, 0x7E, 0x37, 0x83, 0x2B, 0x76, 0x53, 0x8E, 0x62, 0x4C, 0x64, 0x88, 0x44, 0x8B, 0xFB, 0xA2,
		0x17, 0x9A, 0x59, 0xF5, 0x87, 0xB3, 0x4F, 0x13, 0x61, 0x45, 0x6D, 0x8D, 0x09, 0x81, 0x7D, 0x32,
		0xBD, 0x8F, 0x40, 0xEB, 0x86, 0xB7, 0x7B, 0x0B, 0xF0, 0x95, 0x21, 0x22, 0x5C, 0x6B, 0x4E, 0x82,
		0x54, 0xD6, 0x65, 0x93, 0xCE, 0x60, 0xB2, 0x1C, 0x73, 0x56, 0xC0, 0x14, 0xA7, 0x8C, 0xF1, 0xDC,
		0x12, 0x75, 0xCA, 0x1F, 0x3B, 0xBE, 0xE4, 0xD1, 0x42, 0x3D, 0xD4, 0x30, 0xA3, 0x3C, 0xB6, 0x26,
		0x6F, 0xBF, 0x0E, 0xDA, 0x46, 0x69, 0x07, 0x57, 0x27, 0xF2, 0x1D, 0x9B, 0xBC, 0x94, 0x43, 0x03,
		0xF8, 0x11, 0xC7, 0xF6, 0x90, 0xEF, 0x3E, 0xE7, 0x06, 0xC3, 0xD5, 0x2F, 0xC8, 0x66, 0x1E, 0xD7,
		0x08, 0xE8, 0xEA, 0xDE, 0x80, 0x52, 0xEE, 0xF7, 0x84, 0xAA, 0x72, 0xAC, 0x35, 0x4D, 0x6A, 0x2A,
		0x96, 0x1A, 0xD2, 0x71, 0x5A, 0x15, 0x49, 0x74, 0x4B, 0x9F, 0xD0, 0x5E, 0x04, 0x18, 0xA4, 0xEC,
		0xC2, 0xE0, 0x41, 0x6E, 0x0F, 0x51, 0xCB, 0xCC, 0x24, 0x91, 0xAF, 0x50, 0xA1, 0xF4, 0x70, 0x39,
		0x99, 0x7C, 0x3A, 0x85, 0x23, 0xB8, 0xB4, 0x7A, 0xFC, 0x02, 0x36, 0x5B, 0x25, 0x55, 0x97, 0x31,
		0x2D, 0x5D, 0xFA, 0x98, 0xE3, 0x8A, 0x92, 0xAE, 0x05, 0xDF, 0x29, 0x10, 0x67, 0x6C, 0xBA, 0xC9,
		0xD3, 0x00, 0xE6, 0xCF, 0xE1, 0x9E, 0xA8, 0x2C, 0x63, 0x16, 0x01, 0x3F, 0x58, 0xE2, 0x89, 0xA9,
		0x0D, 0x38, 0x34, 0x1B, 0xAB, 0x33, 0xFF, 0xB0, 0xBB, 0x48, 0x0C, 0x5F, 0xB9, 0xB1, 0xCD, 0x2E,
		0xC5, 0xF3, 0xDB, 0x47, 0xE5, 0xA5, 0x9C, 0x77, 0x0A, 0xA6, 0x20, 0x68, 0xFE, 0x7F, 0xC1, 0xAD
	);
	protected static $rc2invpi = array(
		0xD1, 0xDA, 0xB9, 0x6F, 0x9C, 0xC8, 0x78, 0x66, 0x80, 0x2C, 0xF8, 0x37, 0xEA, 0xE0, 0x62, 0xA4,
		0xCB, 0x71, 0x50, 0x27, 0x4B, 0x95, 0xD9, 0x20, 0x9D, 0x04, 0x91, 0xE3, 0x47, 0x6A, 0x7E, 0x53,
		0xFA, 0x3A, 0x3B, 0xB4, 0xA8, 0xBC, 0x5F, 0x68, 0x08, 0xCA, 0x8F, 0x14, 0xD7, 0xC0, 0xEF, 0x7B,
		0x5B, 0xBF, 0x2F, 0xE5, 0xE2, 0x8C, 0xBA, 0x12, 0xE1, 0xAF, 0xB2, 0x54, 0x5D, 0x59, 0x76, 0xDB,
		0x32, 0xA2, 0x58, 0x6E, 0x1C, 0x29, 0x64, 0xF3, 0xE9, 0x96, 0x0C, 0x98, 0x19, 0x8D, 0x3E, 0x26,
		0xAB, 0xA5, 0x85, 0x16, 0x40, 0xBD, 0x49, 0x67, 0xDC, 0x22, 0x94, 0xBB, 0x3C, 0xC1, 0x9B, 0xEB,
		0x45, 0x28, 0x18, 0xD8, 0x1A, 0x42, 0x7D, 0xCC, 0xFB, 0x65, 0x8E, 0x3D, 0xCD, 0x2A, 0xA3, 0x60,
		0xAE, 0x93, 0x8A, 0x48, 0x97, 0x51, 0x15, 0xF7, 0x01, 0x0B, 0xB7, 0x36, 0xB1, 0x2E, 0x11, 0xFD,
		0x84, 0x2D, 0x3F, 0x13, 0x88, 0xB3, 0x34, 0x24, 0x1B, 0xDE, 0xC5, 0x1D, 0x4D, 0x2B, 0x17, 0x31,
		0x74, 0xA9, 0xC6, 0x43, 0x6D, 0x39, 0x90, 0xBE, 0xC3, 0xB0, 0x21, 0x6B, 0xF6, 0x0F, 0xD5, 0x99,
		0x0D, 0xAC, 0x1F, 0x5C, 0x9E, 0xF5, 0xF9, 0x4C, 0xD6, 0xDF, 0x89, 0xE4, 0x8B, 0xFF, 0xC7, 0xAA,
		0xE7, 0xED, 0x46, 0x25, 0xB6, 0x06, 0x5E, 0x35, 0xB5, 0xEC, 0xCE, 0xE8, 0x6C, 0x30, 0x55, 0x61,
		0x4A, 0xFE, 0xA0, 0x79, 0x03, 0xF0, 0x10, 0x72, 0x7C, 0xCF, 0x52, 0xA6, 0xA7, 0xEE, 0x44, 0xD3,
		0x9A, 0x57, 0x92, 0xD0, 0x5A, 0x7A, 0x41, 0x7F, 0x0E, 0x00, 0x63, 0xF2, 0x4F, 0x05, 0x83, 0xC9,
		0xA1, 0xD4, 0xDD, 0xC4, 0x56, 0xF4, 0xD2, 0x77, 0x81, 0x09, 0x82, 0x33, 0x9F, 0x07, 0x86, 0x75,
		0x38, 0x4E, 0x69, 0xF1, 0xAD, 0x23, 0x73, 0x87, 0x70, 0x02, 0xC2, 0x1E, 0xB8, 0x0A, 0xFC, 0xE6
	);
	public static function rc2_setup_key($key, $length, $size){
		$key = array_values(unpack('C*', $key));
		$t = ($size + 7) >> 3;
		$tm = 0xFF >> (8 * $t - $t1);
		$pi = self::$rc2pi;
		for($i = $length; $i < 128; ++$i)
			$key[$i] = $pi[$key[$i - 1] + $key[$i - $t]];
		$i = 128 - $t;
		$key[$i] = $pi[$key[$i] & $tm];
		while(--$i >= 0)
			$key[$i] = $pi[$key[$i + 1] ^ $key[$i + $t]];
		$key[0] = self::$rc2invpi[$key[0]];
		array_unshift($key, 'C*');
		$key = call_user_func_array('pack', $key);
		$key = unpack('Ca/Cb/v*', $key);
		array_unshift($key, $pi[$key['a']] | ($key['b'] << 8));
		unset($key['a'], $key['b']);
		return $key;
	}
	public static function rc2_encrypt($in, $key){
		list(, $r0, $r1, $r2, $r3) = unpack('v4', $in);
		$limit = 20;
		$actions = array($limit => 44, 44 => 64);
		$j = 0;
		while(true) {
			$r0 = (($r0 + $keys[$j++] + ((($r1 ^ $r2) & $r3) ^ $r1)) & 0xFFFF) << 1;
			$r0 |= $r0 >> 16;
			$r1 = (($r1 + $keys[$j++] + ((($r2 ^ $r3) & $r0) ^ $r2)) & 0xFFFF) << 2;
			$r1 |= $r1 >> 16;
			$r2 = (($r2 + $keys[$j++] + ((($r3 ^ $r0) & $r1) ^ $r3)) & 0xFFFF) << 3;
			$r2 |= $r2 >> 16;
			$r3 = (($r3 + $keys[$j++] + ((($r0 ^ $r1) & $r2) ^ $r0)) & 0xFFFF) << 5;
			$r3 |= $r3 >> 16;
			if($j === $limit) {
				if($limit === 64)
					break;
				$r0 += $keys[$r3 & 0x3F];
				$r1 += $keys[$r0 & 0x3F];
				$r2 += $keys[$r1 & 0x3F];
				$r3 += $keys[$r2 & 0x3F];
				$limit = $actions[$limit];
			}
		}
		return pack('vvvv', $r0, $r1, $r2, $r3);
	}
	public static function rc2_decrypt($in, $key){
		list(, $r0, $r1, $r2, $r3) = unpack('v4', $in);
		$limit = 44;
		$actions = array($limit => 20, 20 => 0);
		$j = 64;
		while(true) {
			$r3 = ($r3 | ($r3 << 16)) >> 5;
			$r3 = ($r3 - $keys[--$j] - ((($r0 ^ $r1) & $r2) ^ $r0)) & 0xFFFF;
			$r2 = ($r2 | ($r2 << 16)) >> 3;
			$r2 = ($r2 - $keys[--$j] - ((($r3 ^ $r0) & $r1) ^ $r3)) & 0xFFFF;
			$r1 = ($r1 | ($r1 << 16)) >> 2;
			$r1 = ($r1 - $keys[--$j] - ((($r2 ^ $r3) & $r0) ^ $r2)) & 0xFFFF;
			$r0 = ($r0 | ($r0 << 16)) >> 1;
			$r0 = ($r0 - $keys[--$j] - ((($r1 ^ $r2) & $r3) ^ $r1)) & 0xFFFF;
			if($j === $limit) {
				if($limit === 0)
					break;
				$r3 = ($r3 - $keys[$r2 & 0x3F]) & 0xFFFF;
				$r2 = ($r2 - $keys[$r1 & 0x3F]) & 0xFFFF;
				$r1 = ($r1 - $keys[$r0 & 0x3F]) & 0xFFFF;
				$r0 = ($r0 - $keys[$r3 & 0x3F]) & 0xFFFF;
				$limit = $actions[$limit];
			}
		}
		return pack('vvvv', $r0, $r1, $r2, $r3);
	}
	public static function rc4_setup_key($key, $length){
		$stream = range(0, 255);
		$j = 0;
		for($i = 0; $i < 256; ++$i) {
			$j = ($j + $stream[$i] + ord($key[$i % $length])) & 0xff;
			swap($stream[$i], $stream[$j]);
		}
		return array(
			0, 0, $stream
		);
	}
	public static function rc4_crypt($message, &$key, $continuous = false){
		if($continuous){
			$i = &$key[0];
			$j = &$key[1];
			$stream = &$key[2];
		}else{
			$i = $key[0];
			$j = $key[1];
			$stream = $key[3];
		}
		for($k = 0; isset($message[$k]); ++$k) {
			$i = ($i + 1) & 0xff;
			$ksi = $stream[$i];
			$j = ($j + $ksi) & 0xff;
			$ksj = $stream[$j];
			$stream[$i] = $ksj;
			$stream[$j] = $ksi;
			$message[$k] = $message[$k] ^ chr($stream[($ksj + $ksi) & 0xff]);
		}
		return $message;
	}
	protected static $DESshuffle;
	protected static $DESshuffleip;
	protected static $DESshuffleinvip;
	protected static $DESipmap = array(
		0x00, 0x10, 0x01, 0x11, 0x20, 0x30, 0x21, 0x31, 0x02, 0x12, 0x03, 0x13, 0x22, 0x32, 0x23, 0x33,
		0x40, 0x50, 0x41, 0x51, 0x60, 0x70, 0x61, 0x71, 0x42, 0x52, 0x43, 0x53, 0x62, 0x72, 0x63, 0x73,
		0x04, 0x14, 0x05, 0x15, 0x24, 0x34, 0x25, 0x35, 0x06, 0x16, 0x07, 0x17, 0x26, 0x36, 0x27, 0x37,
		0x44, 0x54, 0x45, 0x55, 0x64, 0x74, 0x65, 0x75, 0x46, 0x56, 0x47, 0x57, 0x66, 0x76, 0x67, 0x77,
		0x80, 0x90, 0x81, 0x91, 0xA0, 0xB0, 0xA1, 0xB1, 0x82, 0x92, 0x83, 0x93, 0xA2, 0xB2, 0xA3, 0xB3,
		0xC0, 0xD0, 0xC1, 0xD1, 0xE0, 0xF0, 0xE1, 0xF1, 0xC2, 0xD2, 0xC3, 0xD3, 0xE2, 0xF2, 0xE3, 0xF3,
		0x84, 0x94, 0x85, 0x95, 0xA4, 0xB4, 0xA5, 0xB5, 0x86, 0x96, 0x87, 0x97, 0xA6, 0xB6, 0xA7, 0xB7,
		0xC4, 0xD4, 0xC5, 0xD5, 0xE4, 0xF4, 0xE5, 0xF5, 0xC6, 0xD6, 0xC7, 0xD7, 0xE6, 0xF6, 0xE7, 0xF7,
		0x08, 0x18, 0x09, 0x19, 0x28, 0x38, 0x29, 0x39, 0x0A, 0x1A, 0x0B, 0x1B, 0x2A, 0x3A, 0x2B, 0x3B,
		0x48, 0x58, 0x49, 0x59, 0x68, 0x78, 0x69, 0x79, 0x4A, 0x5A, 0x4B, 0x5B, 0x6A, 0x7A, 0x6B, 0x7B,
		0x0C, 0x1C, 0x0D, 0x1D, 0x2C, 0x3C, 0x2D, 0x3D, 0x0E, 0x1E, 0x0F, 0x1F, 0x2E, 0x3E, 0x2F, 0x3F,
		0x4C, 0x5C, 0x4D, 0x5D, 0x6C, 0x7C, 0x6D, 0x7D, 0x4E, 0x5E, 0x4F, 0x5F, 0x6E, 0x7E, 0x6F, 0x7F,
		0x88, 0x98, 0x89, 0x99, 0xA8, 0xB8, 0xA9, 0xB9, 0x8A, 0x9A, 0x8B, 0x9B, 0xAA, 0xBA, 0xAB, 0xBB,
		0xC8, 0xD8, 0xC9, 0xD9, 0xE8, 0xF8, 0xE9, 0xF9, 0xCA, 0xDA, 0xCB, 0xDB, 0xEA, 0xFA, 0xEB, 0xFB,
		0x8C, 0x9C, 0x8D, 0x9D, 0xAC, 0xBC, 0xAD, 0xBD, 0x8E, 0x9E, 0x8F, 0x9F, 0xAE, 0xBE, 0xAF, 0xBF,
		0xCC, 0xDC, 0xCD, 0xDD, 0xEC, 0xFC, 0xED, 0xFD, 0xCE, 0xDE, 0xCF, 0xDF, 0xEE, 0xFE, 0xEF, 0xFF
	);
	protected static $DESinvipmap = array(
		0x00, 0x80, 0x40, 0xC0, 0x20, 0xA0, 0x60, 0xE0, 0x10, 0x90, 0x50, 0xD0, 0x30, 0xB0, 0x70, 0xF0,
		0x08, 0x88, 0x48, 0xC8, 0x28, 0xA8, 0x68, 0xE8, 0x18, 0x98, 0x58, 0xD8, 0x38, 0xB8, 0x78, 0xF8,
		0x04, 0x84, 0x44, 0xC4, 0x24, 0xA4, 0x64, 0xE4, 0x14, 0x94, 0x54, 0xD4, 0x34, 0xB4, 0x74, 0xF4,
		0x0C, 0x8C, 0x4C, 0xCC, 0x2C, 0xAC, 0x6C, 0xEC, 0x1C, 0x9C, 0x5C, 0xDC, 0x3C, 0xBC, 0x7C, 0xFC,
		0x02, 0x82, 0x42, 0xC2, 0x22, 0xA2, 0x62, 0xE2, 0x12, 0x92, 0x52, 0xD2, 0x32, 0xB2, 0x72, 0xF2,
		0x0A, 0x8A, 0x4A, 0xCA, 0x2A, 0xAA, 0x6A, 0xEA, 0x1A, 0x9A, 0x5A, 0xDA, 0x3A, 0xBA, 0x7A, 0xFA,
		0x06, 0x86, 0x46, 0xC6, 0x26, 0xA6, 0x66, 0xE6, 0x16, 0x96, 0x56, 0xD6, 0x36, 0xB6, 0x76, 0xF6,
		0x0E, 0x8E, 0x4E, 0xCE, 0x2E, 0xAE, 0x6E, 0xEE, 0x1E, 0x9E, 0x5E, 0xDE, 0x3E, 0xBE, 0x7E, 0xFE,
		0x01, 0x81, 0x41, 0xC1, 0x21, 0xA1, 0x61, 0xE1, 0x11, 0x91, 0x51, 0xD1, 0x31, 0xB1, 0x71, 0xF1,
		0x09, 0x89, 0x49, 0xC9, 0x29, 0xA9, 0x69, 0xE9, 0x19, 0x99, 0x59, 0xD9, 0x39, 0xB9, 0x79, 0xF9,
		0x05, 0x85, 0x45, 0xC5, 0x25, 0xA5, 0x65, 0xE5, 0x15, 0x95, 0x55, 0xD5, 0x35, 0xB5, 0x75, 0xF5,
		0x0D, 0x8D, 0x4D, 0xCD, 0x2D, 0xAD, 0x6D, 0xED, 0x1D, 0x9D, 0x5D, 0xDD, 0x3D, 0xBD, 0x7D, 0xFD,
		0x03, 0x83, 0x43, 0xC3, 0x23, 0xA3, 0x63, 0xE3, 0x13, 0x93, 0x53, 0xD3, 0x33, 0xB3, 0x73, 0xF3,
		0x0B, 0x8B, 0x4B, 0xCB, 0x2B, 0xAB, 0x6B, 0xEB, 0x1B, 0x9B, 0x5B, 0xDB, 0x3B, 0xBB, 0x7B, 0xFB,
		0x07, 0x87, 0x47, 0xC7, 0x27, 0xA7, 0x67, 0xE7, 0x17, 0x97, 0x57, 0xD7, 0x37, 0xB7, 0x77, 0xF7,
		0x0F, 0x8F, 0x4F, 0xCF, 0x2F, 0xAF, 0x6F, 0xEF, 0x1F, 0x9F, 0x5F, 0xDF, 0x3F, 0xBF, 0x7F, 0xFF
	);
	protected static $DESs = array(
		array(
			0x00808200, 0x00000000, 0x00008000, 0x00808202, 0x00808002, 0x00008202, 0x00000002, 0x00008000,
			0x00000200, 0x00808200, 0x00808202, 0x00000200, 0x00800202, 0x00808002, 0x00800000, 0x00000002,
			0x00000202, 0x00800200, 0x00800200, 0x00008200, 0x00008200, 0x00808000, 0x00808000, 0x00800202,
			0x00008002, 0x00800002, 0x00800002, 0x00008002, 0x00000000, 0x00000202, 0x00008202, 0x00800000,
			0x00008000, 0x00808202, 0x00000002, 0x00808000, 0x00808200, 0x00800000, 0x00800000, 0x00000200,
			0x00808002, 0x00008000, 0x00008200, 0x00800002, 0x00000200, 0x00000002, 0x00800202, 0x00008202,
			0x00808202, 0x00008002, 0x00808000, 0x00800202, 0x00800002, 0x00000202, 0x00008202, 0x00808200,
			0x00000202, 0x00800200, 0x00800200, 0x00000000, 0x00008002, 0x00008200, 0x00000000, 0x00808002
		), array(
			0x40084010, 0x40004000, 0x00004000, 0x00084010, 0x00080000, 0x00000010, 0x40080010, 0x40004010,
			0x40000010, 0x40084010, 0x40084000, 0x40000000, 0x40004000, 0x00080000, 0x00000010, 0x40080010,
			0x00084000, 0x00080010, 0x40004010, 0x00000000, 0x40000000, 0x00004000, 0x00084010, 0x40080000,
			0x00080010, 0x40000010, 0x00000000, 0x00084000, 0x00004010, 0x40084000, 0x40080000, 0x00004010,
			0x00000000, 0x00084010, 0x40080010, 0x00080000, 0x40004010, 0x40080000, 0x40084000, 0x00004000,
			0x40080000, 0x40004000, 0x00000010, 0x40084010, 0x00084010, 0x00000010, 0x00004000, 0x40000000,
			0x00004010, 0x40084000, 0x00080000, 0x40000010, 0x00080010, 0x40004010, 0x40000010, 0x00080010,
			0x00084000, 0x00000000, 0x40004000, 0x00004010, 0x40000000, 0x40080010, 0x40084010, 0x00084000
		), array(
			0x00000104, 0x04010100, 0x00000000, 0x04010004, 0x04000100, 0x00000000, 0x00010104, 0x04000100,
			0x00010004, 0x04000004, 0x04000004, 0x00010000, 0x04010104, 0x00010004, 0x04010000, 0x00000104,
			0x04000000, 0x00000004, 0x04010100, 0x00000100, 0x00010100, 0x04010000, 0x04010004, 0x00010104,
			0x04000104, 0x00010100, 0x00010000, 0x04000104, 0x00000004, 0x04010104, 0x00000100, 0x04000000,
			0x04010100, 0x04000000, 0x00010004, 0x00000104, 0x00010000, 0x04010100, 0x04000100, 0x00000000,
			0x00000100, 0x00010004, 0x04010104, 0x04000100, 0x04000004, 0x00000100, 0x00000000, 0x04010004,
			0x04000104, 0x00010000, 0x04000000, 0x04010104, 0x00000004, 0x00010104, 0x00010100, 0x04000004,
			0x04010000, 0x04000104, 0x00000104, 0x04010000, 0x00010104, 0x00000004, 0x04010004, 0x00010100
		), array(
			0x80401000, 0x80001040, 0x80001040, 0x00000040, 0x00401040, 0x80400040, 0x80400000, 0x80001000,
			0x00000000, 0x00401000, 0x00401000, 0x80401040, 0x80000040, 0x00000000, 0x00400040, 0x80400000,
			0x80000000, 0x00001000, 0x00400000, 0x80401000, 0x00000040, 0x00400000, 0x80001000, 0x00001040,
			0x80400040, 0x80000000, 0x00001040, 0x00400040, 0x00001000, 0x00401040, 0x80401040, 0x80000040,
			0x00400040, 0x80400000, 0x00401000, 0x80401040, 0x80000040, 0x00000000, 0x00000000, 0x00401000,
			0x00001040, 0x00400040, 0x80400040, 0x80000000, 0x80401000, 0x80001040, 0x80001040, 0x00000040,
			0x80401040, 0x80000040, 0x80000000, 0x00001000, 0x80400000, 0x80001000, 0x00401040, 0x80400040,
			0x80001000, 0x00001040, 0x00400000, 0x80401000, 0x00000040, 0x00400000, 0x00001000, 0x00401040
		), array(
			0x00000080, 0x01040080, 0x01040000, 0x21000080, 0x00040000, 0x00000080, 0x20000000, 0x01040000,
			0x20040080, 0x00040000, 0x01000080, 0x20040080, 0x21000080, 0x21040000, 0x00040080, 0x20000000,
			0x01000000, 0x20040000, 0x20040000, 0x00000000, 0x20000080, 0x21040080, 0x21040080, 0x01000080,
			0x21040000, 0x20000080, 0x00000000, 0x21000000, 0x01040080, 0x01000000, 0x21000000, 0x00040080,
			0x00040000, 0x21000080, 0x00000080, 0x01000000, 0x20000000, 0x01040000, 0x21000080, 0x20040080,
			0x01000080, 0x20000000, 0x21040000, 0x01040080, 0x20040080, 0x00000080, 0x01000000, 0x21040000,
			0x21040080, 0x00040080, 0x21000000, 0x21040080, 0x01040000, 0x00000000, 0x20040000, 0x21000000,
			0x00040080, 0x01000080, 0x20000080, 0x00040000, 0x00000000, 0x20040000, 0x01040080, 0x20000080
		), array(
			0x10000008, 0x10200000, 0x00002000, 0x10202008, 0x10200000, 0x00000008, 0x10202008, 0x00200000,
			0x10002000, 0x00202008, 0x00200000, 0x10000008, 0x00200008, 0x10002000, 0x10000000, 0x00002008,
			0x00000000, 0x00200008, 0x10002008, 0x00002000, 0x00202000, 0x10002008, 0x00000008, 0x10200008,
			0x10200008, 0x00000000, 0x00202008, 0x10202000, 0x00002008, 0x00202000, 0x10202000, 0x10000000,
			0x10002000, 0x00000008, 0x10200008, 0x00202000, 0x10202008, 0x00200000, 0x00002008, 0x10000008,
			0x00200000, 0x10002000, 0x10000000, 0x00002008, 0x10000008, 0x10202008, 0x00202000, 0x10200000,
			0x00202008, 0x10202000, 0x00000000, 0x10200008, 0x00000008, 0x00002000, 0x10200000, 0x00202008,
			0x00002000, 0x00200008, 0x10002008, 0x00000000, 0x10202000, 0x10000000, 0x00200008, 0x10002008
		), array(
			0x00100000, 0x02100001, 0x02000401, 0x00000000, 0x00000400, 0x02000401, 0x00100401, 0x02100400,
			0x02100401, 0x00100000, 0x00000000, 0x02000001, 0x00000001, 0x02000000, 0x02100001, 0x00000401,
			0x02000400, 0x00100401, 0x00100001, 0x02000400, 0x02000001, 0x02100000, 0x02100400, 0x00100001,
			0x02100000, 0x00000400, 0x00000401, 0x02100401, 0x00100400, 0x00000001, 0x02000000, 0x00100400,
			0x02000000, 0x00100400, 0x00100000, 0x02000401, 0x02000401, 0x02100001, 0x02100001, 0x00000001,
			0x00100001, 0x02000000, 0x02000400, 0x00100000, 0x02100400, 0x00000401, 0x00100401, 0x02100400,
			0x00000401, 0x02000001, 0x02100401, 0x02100000, 0x00100400, 0x00000000, 0x00000001, 0x02100401,
			0x00000000, 0x00100401, 0x02100000, 0x00000400, 0x02000001, 0x02000400, 0x00000400, 0x00100001
		), array(
			0x08000820, 0x00000800, 0x00020000, 0x08020820, 0x08000000, 0x08000820, 0x00000020, 0x08000000,
			0x00020020, 0x08020000, 0x08020820, 0x00020800, 0x08020800, 0x00020820, 0x00000800, 0x00000020,
			0x08020000, 0x08000020, 0x08000800, 0x00000820, 0x00020800, 0x00020020, 0x08020020, 0x08020800,
			0x00000820, 0x00000000, 0x00000000, 0x08020020, 0x08000020, 0x08000800, 0x00020820, 0x00020000,
			0x00020820, 0x00020000, 0x08020800, 0x00000800, 0x00000020, 0x08020020, 0x00000800, 0x00020820,
			0x08000800, 0x00000020, 0x08000020, 0x08020000, 0x08020020, 0x08000000, 0x00020000, 0x08000820,
			0x00000000, 0x08020820, 0x00020020, 0x08000020, 0x08020000, 0x08000800, 0x08000820, 0x00000000,
			0x08020820, 0x00020800, 0x00020800, 0x00000820, 0x00000820, 0x00020020, 0x08000000, 0x08020800
		)
	);
	protected static $DESpc1 = array(
		0x00, 0x00, 0x08, 0x08, 0x04, 0x04, 0x0C, 0x0C, 0x02, 0x02, 0x0A, 0x0A, 0x06, 0x06, 0x0E, 0x0E,
		0x10, 0x10, 0x18, 0x18, 0x14, 0x14, 0x1C, 0x1C, 0x12, 0x12, 0x1A, 0x1A, 0x16, 0x16, 0x1E, 0x1E,
		0x20, 0x20, 0x28, 0x28, 0x24, 0x24, 0x2C, 0x2C, 0x22, 0x22, 0x2A, 0x2A, 0x26, 0x26, 0x2E, 0x2E,
		0x30, 0x30, 0x38, 0x38, 0x34, 0x34, 0x3C, 0x3C, 0x32, 0x32, 0x3A, 0x3A, 0x36, 0x36, 0x3E, 0x3E,
		0x40, 0x40, 0x48, 0x48, 0x44, 0x44, 0x4C, 0x4C, 0x42, 0x42, 0x4A, 0x4A, 0x46, 0x46, 0x4E, 0x4E,
		0x50, 0x50, 0x58, 0x58, 0x54, 0x54, 0x5C, 0x5C, 0x52, 0x52, 0x5A, 0x5A, 0x56, 0x56, 0x5E, 0x5E,
		0x60, 0x60, 0x68, 0x68, 0x64, 0x64, 0x6C, 0x6C, 0x62, 0x62, 0x6A, 0x6A, 0x66, 0x66, 0x6E, 0x6E,
		0x70, 0x70, 0x78, 0x78, 0x74, 0x74, 0x7C, 0x7C, 0x72, 0x72, 0x7A, 0x7A, 0x76, 0x76, 0x7E, 0x7E,
		0x80, 0x80, 0x88, 0x88, 0x84, 0x84, 0x8C, 0x8C, 0x82, 0x82, 0x8A, 0x8A, 0x86, 0x86, 0x8E, 0x8E,
		0x90, 0x90, 0x98, 0x98, 0x94, 0x94, 0x9C, 0x9C, 0x92, 0x92, 0x9A, 0x9A, 0x96, 0x96, 0x9E, 0x9E,
		0xA0, 0xA0, 0xA8, 0xA8, 0xA4, 0xA4, 0xAC, 0xAC, 0xA2, 0xA2, 0xAA, 0xAA, 0xA6, 0xA6, 0xAE, 0xAE,
		0xB0, 0xB0, 0xB8, 0xB8, 0xB4, 0xB4, 0xBC, 0xBC, 0xB2, 0xB2, 0xBA, 0xBA, 0xB6, 0xB6, 0xBE, 0xBE,
		0xC0, 0xC0, 0xC8, 0xC8, 0xC4, 0xC4, 0xCC, 0xCC, 0xC2, 0xC2, 0xCA, 0xCA, 0xC6, 0xC6, 0xCE, 0xCE,
		0xD0, 0xD0, 0xD8, 0xD8, 0xD4, 0xD4, 0xDC, 0xDC, 0xD2, 0xD2, 0xDA, 0xDA, 0xD6, 0xD6, 0xDE, 0xDE,
		0xE0, 0xE0, 0xE8, 0xE8, 0xE4, 0xE4, 0xEC, 0xEC, 0xE2, 0xE2, 0xEA, 0xEA, 0xE6, 0xE6, 0xEE, 0xEE,
		0xF0, 0xF0, 0xF8, 0xF8, 0xF4, 0xF4, 0xFC, 0xFC, 0xF2, 0xF2, 0xFA, 0xFA, 0xF6, 0xF6, 0xFE, 0xFE
	);
	protected static $DESpc2c = array(
		array(
			0x00000000, 0x00000400, 0x00200000, 0x00200400, 0x00000001, 0x00000401, 0x00200001, 0x00200401,
			0x02000000, 0x02000400, 0x02200000, 0x02200400, 0x02000001, 0x02000401, 0x02200001, 0x02200401
		), array(
			0x00000000, 0x00000800, 0x08000000, 0x08000800, 0x00010000, 0x00010800, 0x08010000, 0x08010800,
			0x00000000, 0x00000800, 0x08000000, 0x08000800, 0x00010000, 0x00010800, 0x08010000, 0x08010800,
			0x00000100, 0x00000900, 0x08000100, 0x08000900, 0x00010100, 0x00010900, 0x08010100, 0x08010900,
			0x00000100, 0x00000900, 0x08000100, 0x08000900, 0x00010100, 0x00010900, 0x08010100, 0x08010900,
			0x00000010, 0x00000810, 0x08000010, 0x08000810, 0x00010010, 0x00010810, 0x08010010, 0x08010810,
			0x00000010, 0x00000810, 0x08000010, 0x08000810, 0x00010010, 0x00010810, 0x08010010, 0x08010810,
			0x00000110, 0x00000910, 0x08000110, 0x08000910, 0x00010110, 0x00010910, 0x08010110, 0x08010910,
			0x00000110, 0x00000910, 0x08000110, 0x08000910, 0x00010110, 0x00010910, 0x08010110, 0x08010910,
			0x00040000, 0x00040800, 0x08040000, 0x08040800, 0x00050000, 0x00050800, 0x08050000, 0x08050800,
			0x00040000, 0x00040800, 0x08040000, 0x08040800, 0x00050000, 0x00050800, 0x08050000, 0x08050800,
			0x00040100, 0x00040900, 0x08040100, 0x08040900, 0x00050100, 0x00050900, 0x08050100, 0x08050900,
			0x00040100, 0x00040900, 0x08040100, 0x08040900, 0x00050100, 0x00050900, 0x08050100, 0x08050900,
			0x00040010, 0x00040810, 0x08040010, 0x08040810, 0x00050010, 0x00050810, 0x08050010, 0x08050810,
			0x00040010, 0x00040810, 0x08040010, 0x08040810, 0x00050010, 0x00050810, 0x08050010, 0x08050810,
			0x00040110, 0x00040910, 0x08040110, 0x08040910, 0x00050110, 0x00050910, 0x08050110, 0x08050910,
			0x00040110, 0x00040910, 0x08040110, 0x08040910, 0x00050110, 0x00050910, 0x08050110, 0x08050910,
			0x01000000, 0x01000800, 0x09000000, 0x09000800, 0x01010000, 0x01010800, 0x09010000, 0x09010800,
			0x01000000, 0x01000800, 0x09000000, 0x09000800, 0x01010000, 0x01010800, 0x09010000, 0x09010800,
			0x01000100, 0x01000900, 0x09000100, 0x09000900, 0x01010100, 0x01010900, 0x09010100, 0x09010900,
			0x01000100, 0x01000900, 0x09000100, 0x09000900, 0x01010100, 0x01010900, 0x09010100, 0x09010900,
			0x01000010, 0x01000810, 0x09000010, 0x09000810, 0x01010010, 0x01010810, 0x09010010, 0x09010810,
			0x01000010, 0x01000810, 0x09000010, 0x09000810, 0x01010010, 0x01010810, 0x09010010, 0x09010810,
			0x01000110, 0x01000910, 0x09000110, 0x09000910, 0x01010110, 0x01010910, 0x09010110, 0x09010910,
			0x01000110, 0x01000910, 0x09000110, 0x09000910, 0x01010110, 0x01010910, 0x09010110, 0x09010910,
			0x01040000, 0x01040800, 0x09040000, 0x09040800, 0x01050000, 0x01050800, 0x09050000, 0x09050800,
			0x01040000, 0x01040800, 0x09040000, 0x09040800, 0x01050000, 0x01050800, 0x09050000, 0x09050800,
			0x01040100, 0x01040900, 0x09040100, 0x09040900, 0x01050100, 0x01050900, 0x09050100, 0x09050900,
			0x01040100, 0x01040900, 0x09040100, 0x09040900, 0x01050100, 0x01050900, 0x09050100, 0x09050900,
			0x01040010, 0x01040810, 0x09040010, 0x09040810, 0x01050010, 0x01050810, 0x09050010, 0x09050810,
			0x01040010, 0x01040810, 0x09040010, 0x09040810, 0x01050010, 0x01050810, 0x09050010, 0x09050810,
			0x01040110, 0x01040910, 0x09040110, 0x09040910, 0x01050110, 0x01050910, 0x09050110, 0x09050910,
			0x01040110, 0x01040910, 0x09040110, 0x09040910, 0x01050110, 0x01050910, 0x09050110, 0x09050910
		), array(
			0x00000000, 0x00000004, 0x00001000, 0x00001004, 0x00000000, 0x00000004, 0x00001000, 0x00001004,
			0x10000000, 0x10000004, 0x10001000, 0x10001004, 0x10000000, 0x10000004, 0x10001000, 0x10001004,
			0x00000020, 0x00000024, 0x00001020, 0x00001024, 0x00000020, 0x00000024, 0x00001020, 0x00001024,
			0x10000020, 0x10000024, 0x10001020, 0x10001024, 0x10000020, 0x10000024, 0x10001020, 0x10001024,
			0x00080000, 0x00080004, 0x00081000, 0x00081004, 0x00080000, 0x00080004, 0x00081000, 0x00081004,
			0x10080000, 0x10080004, 0x10081000, 0x10081004, 0x10080000, 0x10080004, 0x10081000, 0x10081004,
			0x00080020, 0x00080024, 0x00081020, 0x00081024, 0x00080020, 0x00080024, 0x00081020, 0x00081024,
			0x10080020, 0x10080024, 0x10081020, 0x10081024, 0x10080020, 0x10080024, 0x10081020, 0x10081024,
			0x20000000, 0x20000004, 0x20001000, 0x20001004, 0x20000000, 0x20000004, 0x20001000, 0x20001004,
			0x30000000, 0x30000004, 0x30001000, 0x30001004, 0x30000000, 0x30000004, 0x30001000, 0x30001004,
			0x20000020, 0x20000024, 0x20001020, 0x20001024, 0x20000020, 0x20000024, 0x20001020, 0x20001024,
			0x30000020, 0x30000024, 0x30001020, 0x30001024, 0x30000020, 0x30000024, 0x30001020, 0x30001024,
			0x20080000, 0x20080004, 0x20081000, 0x20081004, 0x20080000, 0x20080004, 0x20081000, 0x20081004,
			0x30080000, 0x30080004, 0x30081000, 0x30081004, 0x30080000, 0x30080004, 0x30081000, 0x30081004,
			0x20080020, 0x20080024, 0x20081020, 0x20081024, 0x20080020, 0x20080024, 0x20081020, 0x20081024,
			0x30080020, 0x30080024, 0x30081020, 0x30081024, 0x30080020, 0x30080024, 0x30081020, 0x30081024,
			0x00000002, 0x00000006, 0x00001002, 0x00001006, 0x00000002, 0x00000006, 0x00001002, 0x00001006,
			0x10000002, 0x10000006, 0x10001002, 0x10001006, 0x10000002, 0x10000006, 0x10001002, 0x10001006,
			0x00000022, 0x00000026, 0x00001022, 0x00001026, 0x00000022, 0x00000026, 0x00001022, 0x00001026,
			0x10000022, 0x10000026, 0x10001022, 0x10001026, 0x10000022, 0x10000026, 0x10001022, 0x10001026,
			0x00080002, 0x00080006, 0x00081002, 0x00081006, 0x00080002, 0x00080006, 0x00081002, 0x00081006,
			0x10080002, 0x10080006, 0x10081002, 0x10081006, 0x10080002, 0x10080006, 0x10081002, 0x10081006,
			0x00080022, 0x00080026, 0x00081022, 0x00081026, 0x00080022, 0x00080026, 0x00081022, 0x00081026,
			0x10080022, 0x10080026, 0x10081022, 0x10081026, 0x10080022, 0x10080026, 0x10081022, 0x10081026,
			0x20000002, 0x20000006, 0x20001002, 0x20001006, 0x20000002, 0x20000006, 0x20001002, 0x20001006,
			0x30000002, 0x30000006, 0x30001002, 0x30001006, 0x30000002, 0x30000006, 0x30001002, 0x30001006,
			0x20000022, 0x20000026, 0x20001022, 0x20001026, 0x20000022, 0x20000026, 0x20001022, 0x20001026,
			0x30000022, 0x30000026, 0x30001022, 0x30001026, 0x30000022, 0x30000026, 0x30001022, 0x30001026,
			0x20080002, 0x20080006, 0x20081002, 0x20081006, 0x20080002, 0x20080006, 0x20081002, 0x20081006,
			0x30080002, 0x30080006, 0x30081002, 0x30081006, 0x30080002, 0x30080006, 0x30081002, 0x30081006,
			0x20080022, 0x20080026, 0x20081022, 0x20081026, 0x20080022, 0x20080026, 0x20081022, 0x20081026,
			0x30080022, 0x30080026, 0x30081022, 0x30081026, 0x30080022, 0x30080026, 0x30081022, 0x30081026
		), array(
			0x00000000, 0x00100000, 0x00000008, 0x00100008, 0x00000200, 0x00100200, 0x00000208, 0x00100208,
			0x00000000, 0x00100000, 0x00000008, 0x00100008, 0x00000200, 0x00100200, 0x00000208, 0x00100208,
			0x04000000, 0x04100000, 0x04000008, 0x04100008, 0x04000200, 0x04100200, 0x04000208, 0x04100208,
			0x04000000, 0x04100000, 0x04000008, 0x04100008, 0x04000200, 0x04100200, 0x04000208, 0x04100208,
			0x00002000, 0x00102000, 0x00002008, 0x00102008, 0x00002200, 0x00102200, 0x00002208, 0x00102208,
			0x00002000, 0x00102000, 0x00002008, 0x00102008, 0x00002200, 0x00102200, 0x00002208, 0x00102208,
			0x04002000, 0x04102000, 0x04002008, 0x04102008, 0x04002200, 0x04102200, 0x04002208, 0x04102208,
			0x04002000, 0x04102000, 0x04002008, 0x04102008, 0x04002200, 0x04102200, 0x04002208, 0x04102208,
			0x00000000, 0x00100000, 0x00000008, 0x00100008, 0x00000200, 0x00100200, 0x00000208, 0x00100208,
			0x00000000, 0x00100000, 0x00000008, 0x00100008, 0x00000200, 0x00100200, 0x00000208, 0x00100208,
			0x04000000, 0x04100000, 0x04000008, 0x04100008, 0x04000200, 0x04100200, 0x04000208, 0x04100208,
			0x04000000, 0x04100000, 0x04000008, 0x04100008, 0x04000200, 0x04100200, 0x04000208, 0x04100208,
			0x00002000, 0x00102000, 0x00002008, 0x00102008, 0x00002200, 0x00102200, 0x00002208, 0x00102208,
			0x00002000, 0x00102000, 0x00002008, 0x00102008, 0x00002200, 0x00102200, 0x00002208, 0x00102208,
			0x04002000, 0x04102000, 0x04002008, 0x04102008, 0x04002200, 0x04102200, 0x04002208, 0x04102208,
			0x04002000, 0x04102000, 0x04002008, 0x04102008, 0x04002200, 0x04102200, 0x04002208, 0x04102208,
			0x00020000, 0x00120000, 0x00020008, 0x00120008, 0x00020200, 0x00120200, 0x00020208, 0x00120208,
			0x00020000, 0x00120000, 0x00020008, 0x00120008, 0x00020200, 0x00120200, 0x00020208, 0x00120208,
			0x04020000, 0x04120000, 0x04020008, 0x04120008, 0x04020200, 0x04120200, 0x04020208, 0x04120208,
			0x04020000, 0x04120000, 0x04020008, 0x04120008, 0x04020200, 0x04120200, 0x04020208, 0x04120208,
			0x00022000, 0x00122000, 0x00022008, 0x00122008, 0x00022200, 0x00122200, 0x00022208, 0x00122208,
			0x00022000, 0x00122000, 0x00022008, 0x00122008, 0x00022200, 0x00122200, 0x00022208, 0x00122208,
			0x04022000, 0x04122000, 0x04022008, 0x04122008, 0x04022200, 0x04122200, 0x04022208, 0x04122208,
			0x04022000, 0x04122000, 0x04022008, 0x04122008, 0x04022200, 0x04122200, 0x04022208, 0x04122208,
			0x00020000, 0x00120000, 0x00020008, 0x00120008, 0x00020200, 0x00120200, 0x00020208, 0x00120208,
			0x00020000, 0x00120000, 0x00020008, 0x00120008, 0x00020200, 0x00120200, 0x00020208, 0x00120208,
			0x04020000, 0x04120000, 0x04020008, 0x04120008, 0x04020200, 0x04120200, 0x04020208, 0x04120208,
			0x04020000, 0x04120000, 0x04020008, 0x04120008, 0x04020200, 0x04120200, 0x04020208, 0x04120208,
			0x00022000, 0x00122000, 0x00022008, 0x00122008, 0x00022200, 0x00122200, 0x00022208, 0x00122208,
			0x00022000, 0x00122000, 0x00022008, 0x00122008, 0x00022200, 0x00122200, 0x00022208, 0x00122208,
			0x04022000, 0x04122000, 0x04022008, 0x04122008, 0x04022200, 0x04122200, 0x04022208, 0x04122208,
			0x04022000, 0x04122000, 0x04022008, 0x04122008, 0x04022200, 0x04122200, 0x04022208, 0x04122208
		)
	);
	protected static $DESpc2d = array(
		array(
			0x00000000, 0x00000001, 0x08000000, 0x08000001, 0x00200000, 0x00200001, 0x08200000, 0x08200001,
			0x00000002, 0x00000003, 0x08000002, 0x08000003, 0x00200002, 0x00200003, 0x08200002, 0x08200003
		), array(
			0x00000000, 0x00100000, 0x00000800, 0x00100800, 0x00000000, 0x00100000, 0x00000800, 0x00100800,
			0x04000000, 0x04100000, 0x04000800, 0x04100800, 0x04000000, 0x04100000, 0x04000800, 0x04100800,
			0x00000004, 0x00100004, 0x00000804, 0x00100804, 0x00000004, 0x00100004, 0x00000804, 0x00100804,
			0x04000004, 0x04100004, 0x04000804, 0x04100804, 0x04000004, 0x04100004, 0x04000804, 0x04100804,
			0x00000000, 0x00100000, 0x00000800, 0x00100800, 0x00000000, 0x00100000, 0x00000800, 0x00100800,
			0x04000000, 0x04100000, 0x04000800, 0x04100800, 0x04000000, 0x04100000, 0x04000800, 0x04100800,
			0x00000004, 0x00100004, 0x00000804, 0x00100804, 0x00000004, 0x00100004, 0x00000804, 0x00100804,
			0x04000004, 0x04100004, 0x04000804, 0x04100804, 0x04000004, 0x04100004, 0x04000804, 0x04100804,
			0x00000200, 0x00100200, 0x00000A00, 0x00100A00, 0x00000200, 0x00100200, 0x00000A00, 0x00100A00,
			0x04000200, 0x04100200, 0x04000A00, 0x04100A00, 0x04000200, 0x04100200, 0x04000A00, 0x04100A00,
			0x00000204, 0x00100204, 0x00000A04, 0x00100A04, 0x00000204, 0x00100204, 0x00000A04, 0x00100A04,
			0x04000204, 0x04100204, 0x04000A04, 0x04100A04, 0x04000204, 0x04100204, 0x04000A04, 0x04100A04,
			0x00000200, 0x00100200, 0x00000A00, 0x00100A00, 0x00000200, 0x00100200, 0x00000A00, 0x00100A00,
			0x04000200, 0x04100200, 0x04000A00, 0x04100A00, 0x04000200, 0x04100200, 0x04000A00, 0x04100A00,
			0x00000204, 0x00100204, 0x00000A04, 0x00100A04, 0x00000204, 0x00100204, 0x00000A04, 0x00100A04,
			0x04000204, 0x04100204, 0x04000A04, 0x04100A04, 0x04000204, 0x04100204, 0x04000A04, 0x04100A04,
			0x00020000, 0x00120000, 0x00020800, 0x00120800, 0x00020000, 0x00120000, 0x00020800, 0x00120800,
			0x04020000, 0x04120000, 0x04020800, 0x04120800, 0x04020000, 0x04120000, 0x04020800, 0x04120800,
			0x00020004, 0x00120004, 0x00020804, 0x00120804, 0x00020004, 0x00120004, 0x00020804, 0x00120804,
			0x04020004, 0x04120004, 0x04020804, 0x04120804, 0x04020004, 0x04120004, 0x04020804, 0x04120804,
			0x00020000, 0x00120000, 0x00020800, 0x00120800, 0x00020000, 0x00120000, 0x00020800, 0x00120800,
			0x04020000, 0x04120000, 0x04020800, 0x04120800, 0x04020000, 0x04120000, 0x04020800, 0x04120800,
			0x00020004, 0x00120004, 0x00020804, 0x00120804, 0x00020004, 0x00120004, 0x00020804, 0x00120804,
			0x04020004, 0x04120004, 0x04020804, 0x04120804, 0x04020004, 0x04120004, 0x04020804, 0x04120804,
			0x00020200, 0x00120200, 0x00020A00, 0x00120A00, 0x00020200, 0x00120200, 0x00020A00, 0x00120A00,
			0x04020200, 0x04120200, 0x04020A00, 0x04120A00, 0x04020200, 0x04120200, 0x04020A00, 0x04120A00,
			0x00020204, 0x00120204, 0x00020A04, 0x00120A04, 0x00020204, 0x00120204, 0x00020A04, 0x00120A04,
			0x04020204, 0x04120204, 0x04020A04, 0x04120A04, 0x04020204, 0x04120204, 0x04020A04, 0x04120A04,
			0x00020200, 0x00120200, 0x00020A00, 0x00120A00, 0x00020200, 0x00120200, 0x00020A00, 0x00120A00,
			0x04020200, 0x04120200, 0x04020A00, 0x04120A00, 0x04020200, 0x04120200, 0x04020A00, 0x04120A00,
			0x00020204, 0x00120204, 0x00020A04, 0x00120A04, 0x00020204, 0x00120204, 0x00020A04, 0x00120A04,
			0x04020204, 0x04120204, 0x04020A04, 0x04120A04, 0x04020204, 0x04120204, 0x04020A04, 0x04120A04
		), array(
			0x00000000, 0x00010000, 0x02000000, 0x02010000, 0x00000020, 0x00010020, 0x02000020, 0x02010020,
			0x00040000, 0x00050000, 0x02040000, 0x02050000, 0x00040020, 0x00050020, 0x02040020, 0x02050020,
			0x00002000, 0x00012000, 0x02002000, 0x02012000, 0x00002020, 0x00012020, 0x02002020, 0x02012020,
			0x00042000, 0x00052000, 0x02042000, 0x02052000, 0x00042020, 0x00052020, 0x02042020, 0x02052020,
			0x00000000, 0x00010000, 0x02000000, 0x02010000, 0x00000020, 0x00010020, 0x02000020, 0x02010020,
			0x00040000, 0x00050000, 0x02040000, 0x02050000, 0x00040020, 0x00050020, 0x02040020, 0x02050020,
			0x00002000, 0x00012000, 0x02002000, 0x02012000, 0x00002020, 0x00012020, 0x02002020, 0x02012020,
			0x00042000, 0x00052000, 0x02042000, 0x02052000, 0x00042020, 0x00052020, 0x02042020, 0x02052020,
			0x00000010, 0x00010010, 0x02000010, 0x02010010, 0x00000030, 0x00010030, 0x02000030, 0x02010030,
			0x00040010, 0x00050010, 0x02040010, 0x02050010, 0x00040030, 0x00050030, 0x02040030, 0x02050030,
			0x00002010, 0x00012010, 0x02002010, 0x02012010, 0x00002030, 0x00012030, 0x02002030, 0x02012030,
			0x00042010, 0x00052010, 0x02042010, 0x02052010, 0x00042030, 0x00052030, 0x02042030, 0x02052030,
			0x00000010, 0x00010010, 0x02000010, 0x02010010, 0x00000030, 0x00010030, 0x02000030, 0x02010030,
			0x00040010, 0x00050010, 0x02040010, 0x02050010, 0x00040030, 0x00050030, 0x02040030, 0x02050030,
			0x00002010, 0x00012010, 0x02002010, 0x02012010, 0x00002030, 0x00012030, 0x02002030, 0x02012030,
			0x00042010, 0x00052010, 0x02042010, 0x02052010, 0x00042030, 0x00052030, 0x02042030, 0x02052030,
			0x20000000, 0x20010000, 0x22000000, 0x22010000, 0x20000020, 0x20010020, 0x22000020, 0x22010020,
			0x20040000, 0x20050000, 0x22040000, 0x22050000, 0x20040020, 0x20050020, 0x22040020, 0x22050020,
			0x20002000, 0x20012000, 0x22002000, 0x22012000, 0x20002020, 0x20012020, 0x22002020, 0x22012020,
			0x20042000, 0x20052000, 0x22042000, 0x22052000, 0x20042020, 0x20052020, 0x22042020, 0x22052020,
			0x20000000, 0x20010000, 0x22000000, 0x22010000, 0x20000020, 0x20010020, 0x22000020, 0x22010020,
			0x20040000, 0x20050000, 0x22040000, 0x22050000, 0x20040020, 0x20050020, 0x22040020, 0x22050020,
			0x20002000, 0x20012000, 0x22002000, 0x22012000, 0x20002020, 0x20012020, 0x22002020, 0x22012020,
			0x20042000, 0x20052000, 0x22042000, 0x22052000, 0x20042020, 0x20052020, 0x22042020, 0x22052020,
			0x20000010, 0x20010010, 0x22000010, 0x22010010, 0x20000030, 0x20010030, 0x22000030, 0x22010030,
			0x20040010, 0x20050010, 0x22040010, 0x22050010, 0x20040030, 0x20050030, 0x22040030, 0x22050030,
			0x20002010, 0x20012010, 0x22002010, 0x22012010, 0x20002030, 0x20012030, 0x22002030, 0x22012030,
			0x20042010, 0x20052010, 0x22042010, 0x22052010, 0x20042030, 0x20052030, 0x22042030, 0x22052030,
			0x20000010, 0x20010010, 0x22000010, 0x22010010, 0x20000030, 0x20010030, 0x22000030, 0x22010030,
			0x20040010, 0x20050010, 0x22040010, 0x22050010, 0x20040030, 0x20050030, 0x22040030, 0x22050030,
			0x20002010, 0x20012010, 0x22002010, 0x22012010, 0x20002030, 0x20012030, 0x22002030, 0x22012030,
			0x20042010, 0x20052010, 0x22042010, 0x22052010, 0x20042030, 0x20052030, 0x22042030, 0x22052030
		), array(
			0x00000000, 0x00000400, 0x01000000, 0x01000400, 0x00000000, 0x00000400, 0x01000000, 0x01000400,
			0x00000100, 0x00000500, 0x01000100, 0x01000500, 0x00000100, 0x00000500, 0x01000100, 0x01000500,
			0x10000000, 0x10000400, 0x11000000, 0x11000400, 0x10000000, 0x10000400, 0x11000000, 0x11000400,
			0x10000100, 0x10000500, 0x11000100, 0x11000500, 0x10000100, 0x10000500, 0x11000100, 0x11000500,
			0x00080000, 0x00080400, 0x01080000, 0x01080400, 0x00080000, 0x00080400, 0x01080000, 0x01080400,
			0x00080100, 0x00080500, 0x01080100, 0x01080500, 0x00080100, 0x00080500, 0x01080100, 0x01080500,
			0x10080000, 0x10080400, 0x11080000, 0x11080400, 0x10080000, 0x10080400, 0x11080000, 0x11080400,
			0x10080100, 0x10080500, 0x11080100, 0x11080500, 0x10080100, 0x10080500, 0x11080100, 0x11080500,
			0x00000008, 0x00000408, 0x01000008, 0x01000408, 0x00000008, 0x00000408, 0x01000008, 0x01000408,
			0x00000108, 0x00000508, 0x01000108, 0x01000508, 0x00000108, 0x00000508, 0x01000108, 0x01000508,
			0x10000008, 0x10000408, 0x11000008, 0x11000408, 0x10000008, 0x10000408, 0x11000008, 0x11000408,
			0x10000108, 0x10000508, 0x11000108, 0x11000508, 0x10000108, 0x10000508, 0x11000108, 0x11000508,
			0x00080008, 0x00080408, 0x01080008, 0x01080408, 0x00080008, 0x00080408, 0x01080008, 0x01080408,
			0x00080108, 0x00080508, 0x01080108, 0x01080508, 0x00080108, 0x00080508, 0x01080108, 0x01080508,
			0x10080008, 0x10080408, 0x11080008, 0x11080408, 0x10080008, 0x10080408, 0x11080008, 0x11080408,
			0x10080108, 0x10080508, 0x11080108, 0x11080508, 0x10080108, 0x10080508, 0x11080108, 0x11080508,
			0x00001000, 0x00001400, 0x01001000, 0x01001400, 0x00001000, 0x00001400, 0x01001000, 0x01001400,
			0x00001100, 0x00001500, 0x01001100, 0x01001500, 0x00001100, 0x00001500, 0x01001100, 0x01001500,
			0x10001000, 0x10001400, 0x11001000, 0x11001400, 0x10001000, 0x10001400, 0x11001000, 0x11001400,
			0x10001100, 0x10001500, 0x11001100, 0x11001500, 0x10001100, 0x10001500, 0x11001100, 0x11001500,
			0x00081000, 0x00081400, 0x01081000, 0x01081400, 0x00081000, 0x00081400, 0x01081000, 0x01081400,
			0x00081100, 0x00081500, 0x01081100, 0x01081500, 0x00081100, 0x00081500, 0x01081100, 0x01081500,
			0x10081000, 0x10081400, 0x11081000, 0x11081400, 0x10081000, 0x10081400, 0x11081000, 0x11081400,
			0x10081100, 0x10081500, 0x11081100, 0x11081500, 0x10081100, 0x10081500, 0x11081100, 0x11081500,
			0x00001008, 0x00001408, 0x01001008, 0x01001408, 0x00001008, 0x00001408, 0x01001008, 0x01001408,
			0x00001108, 0x00001508, 0x01001108, 0x01001508, 0x00001108, 0x00001508, 0x01001108, 0x01001508,
			0x10001008, 0x10001408, 0x11001008, 0x11001408, 0x10001008, 0x10001408, 0x11001008, 0x11001408,
			0x10001108, 0x10001508, 0x11001108, 0x11001508, 0x10001108, 0x10001508, 0x11001108, 0x11001508,
			0x00081008, 0x00081408, 0x01081008, 0x01081408, 0x00081008, 0x00081408, 0x01081008, 0x01081408,
			0x00081108, 0x00081508, 0x01081108, 0x01081508, 0x00081108, 0x00081508, 0x01081108, 0x01081508,
			0x10081008, 0x10081408, 0x11081008, 0x11081408, 0x10081008, 0x10081408, 0x11081008, 0x11081408,
			0x10081108, 0x10081508, 0x11081108, 0x11081508, 0x10081108, 0x10081508, 0x11081108, 0x11081508
		)
	);
	public static function des_shuffle(){
		self::$DESshuffle = str_split(strtr(crypt::binencode(str::ASCII_RANGE), '01', "\0\xff"), 8);
		self::$DESs[0] = array_map('intval', self::$DESs[0]);
		self::$DESs[1] = array_map('intval', self::$DESs[1]);
		self::$DESs[2] = array_map('intval', self::$DESs[2]);
		self::$DESs[3] = array_map('intval', self::$DESs[3]);
		self::$DESs[4] = array_map('intval', self::$DESs[4]);
		self::$DESs[5] = array_map('intval', self::$DESs[5]);
		self::$DESs[6] = array_map('intval', self::$DESs[6]);
		self::$DESs[7] = array_map('intval', self::$DESs[7]);
		for($i = 0; $i < 256; ++$i){
			self::$DESshuffleip = self::$DESshuffle[self::$DESipmap];
			self::$DESshuffleinvip = self::$DESshuffle[self::$DESinvipmap];
		}
	}
	public static function des_setup_key($key, $rounds){
		if(!self::$DESshuffle)
			self::des_shuffle();
		$shuffle = self::$DESshuffle;
		$pc1 = self::$DESpc1;
		$pc2c = self::$DESpc2c;
		$pc2d = self::$DESpc2d;
		$shifts = array(1, 1, 2, 2, 2, 2, 2, 2, 1, 2, 2, 2, 2, 2, 2, 1);
		$keys = array();
		for($round = 0; $round < $rounds; ++$round) {
			$key = str_pad(substr($key, $round * 8, 8), 8, "\0");
			list(, $l, $r) = unpack('N2', $key);
			$key = ($shuffle[$pc1[ $r		& 0xFF]] & "\x80\x80\x80\x80\x80\x80\x80\x00") |
				   ($shuffle[$pc1[($r >>  8) & 0xFF]] & "\x40\x40\x40\x40\x40\x40\x40\x00") |
				   ($shuffle[$pc1[($r >> 16) & 0xFF]] & "\x20\x20\x20\x20\x20\x20\x20\x00") |
				   ($shuffle[$pc1[($r >> 24) & 0xFF]] & "\x10\x10\x10\x10\x10\x10\x10\x00") |
				   ($shuffle[$pc1[ $l		& 0xFF]] & "\x08\x08\x08\x08\x08\x08\x08\x00") |
				   ($shuffle[$pc1[($l >>  8) & 0xFF]] & "\x04\x04\x04\x04\x04\x04\x04\x00") |
				   ($shuffle[$pc1[($l >> 16) & 0xFF]] & "\x02\x02\x02\x02\x02\x02\x02\x00") |
				   ($shuffle[$pc1[($l >> 24) & 0xFF]] & "\x01\x01\x01\x01\x01\x01\x01\x00");
			$key = unpack('Nc/Nd', $key);
			$c = ( $key['c'] >> 4) & 0x0FFFFFFF;
			$d = (($key['d'] >> 4) & 0x0FFFFFF0) | ($key['c'] & 0x0F);
			$keys[$round] = array(array(), array_fill(0, 32, 0));
			for($i = 0, $ki = 31; $i < 16; ++$i, $ki-= 2) {
				$c <<= $shifts[$i];
				$c = ($c | ($c >> 28)) & 0x0FFFFFFF;
				$d <<= $shifts[$i];
				$d = ($d | ($d >> 28)) & 0x0FFFFFFF;
				$cp = $pc2c[0][ $c >> 24		] | $pc2c[1][($c >> 16) & 0xFF] |
					  $pc2c[2][($c >>  8) & 0xFF] | $pc2c[3][ $c		& 0xFF];
				$dp = $pc2d[0][ $d >> 24		] | $pc2d[1][($d >> 16) & 0xFF] |
					  $pc2d[2][($d >>  8) & 0xFF] | $pc2d[3][ $d		& 0xFF];
				$val1 = ( $cp		& 0xFF000000) | (($cp <<  8) & 0x00FF0000) |
						(($dp >> 16) & 0x0000FF00) | (($dp >>  8) & 0x000000FF);
				$val2 = (($cp <<  8) & 0xFF000000) | (($cp << 16) & 0x00FF0000) |
						(($dp >>  8) & 0x0000FF00) | ( $dp		& 0x000000FF);
				$keys[$round][0][	   ] = $val1;
				$keys[$round][1][$ki - 1] = $val1;
				$keys[$round][0][	   ] = $val2;
				$keys[$round][1][$ki	] = $val2;
			}
		}
		switch($rounds) {
			case 3:
				return array(
					array_merge($keys[0][0], $keys[1][1],$keys[2][0]),
					array_merge($keys[2][1], $keys[1][0], $keys[0][1])
				);
			case 2:
				return array(
					array_merge($keys[0][0], $keys[1][1]),
					array_merge($keys[1][0], $keys[0][1])
				);
			case 1:
				return array($keys[0][0], $keys[0][1]);
			default:
				$array = array(array(), array());
				for($round = 0; $round < $rounds; ++$round){
					$array[0][] = $keys[$round][$round % 2];
					array_unshift($array[1], $keys[$round][$round % 2 + 1]);
				}
				return array(
					call_user_func_array('array_merge', $array[0]),
					call_user_func_array('array_merge', $array[1])
				);
		}
	}
	public static function des_proccess($block, $key, $rounds){
		if(!self::$DESshuffle)
			self::des_shuffle();
		$s = self::$DESs;
		$shuffle = self::des_shuffle();
		$shuffleip = self::$DESshuffleip;
		$shuffleinvip = self::$DESshuffleinvip;
		$ki = -1;
		list(, $l, $r) = unpack('N2', $block);
		$block = ($shuffleip[ $r		& 0xFF] & "\x80\x80\x80\x80\x80\x80\x80\x80") |
				 ($shuffleip[($r >>  8) & 0xFF] & "\x40\x40\x40\x40\x40\x40\x40\x40") |
				 ($shuffleip[($r >> 16) & 0xFF] & "\x20\x20\x20\x20\x20\x20\x20\x20") |
				 ($shuffleip[($r >> 24) & 0xFF] & "\x10\x10\x10\x10\x10\x10\x10\x10") |
				 ($shuffleip[ $l		& 0xFF] & "\x08\x08\x08\x08\x08\x08\x08\x08") |
				 ($shuffleip[($l >>  8) & 0xFF] & "\x04\x04\x04\x04\x04\x04\x04\x04") |
				 ($shuffleip[($l >> 16) & 0xFF] & "\x02\x02\x02\x02\x02\x02\x02\x02") |
				 ($shuffleip[($l >> 24) & 0xFF] & "\x01\x01\x01\x01\x01\x01\x01\x01");
		list(, $l, $r) = unpack('N2', $block);
		for($round = 0; $round < $rounds; ++$round) {
			for($i = 0; $i < 16; ++$i) {
				$b1 = (($r >>  3) & 0x1FFFFFFF) ^ ($r << 29) ^ $keys[++$ki];
				$b2 = (($r >> 31) & 0x00000001) ^ ($r <<  1) ^ $keys[++$ki];
				$t = $s[0][($b1 >> 24) & 0x3F] ^ $s[1][($b2 >> 24) & 0x3F] ^
					 $s[2][($b1 >> 16) & 0x3F] ^ $s[3][($b2 >> 16) & 0x3F] ^
					 $s[4][($b1 >>  8) & 0x3F] ^ $s[5][($b2 >>  8) & 0x3F] ^
					 $s[6][ $b1		& 0x3F] ^ $s[7][ $b2		& 0x3F] ^ $l;
				$l = $r;
				$r = $t;
			}
			swap($l, $r);
		}
		return ($shuffleinvip[($r >> 24) & 0xFF] & "\x80\x80\x80\x80\x80\x80\x80\x80") |
			   ($shuffleinvip[($l >> 24) & 0xFF] & "\x40\x40\x40\x40\x40\x40\x40\x40") |
			   ($shuffleinvip[($r >> 16) & 0xFF] & "\x20\x20\x20\x20\x20\x20\x20\x20") |
			   ($shuffleinvip[($l >> 16) & 0xFF] & "\x10\x10\x10\x10\x10\x10\x10\x10") |
			   ($shuffleinvip[($r >>  8) & 0xFF] & "\x08\x08\x08\x08\x08\x08\x08\x08") |
			   ($shuffleinvip[($l >>  8) & 0xFF] & "\x04\x04\x04\x04\x04\x04\x04\x04") |
			   ($shuffleinvip[ $r		& 0xFF] & "\x02\x02\x02\x02\x02\x02\x02\x02") |
			   ($shuffleinvip[ $l		& 0xFF] & "\x01\x01\x01\x01\x01\x01\x01\x01");
	}
	public static function des_encrypt($message, $key, $rounds){
		return self::des_proccess($message, $key[0], $rounds);
	}
	public static function des_decrypt($message, $key, $rounds){
		return self::des_proccess($message, $key[1], $rounds);
	}
	public static function tripledes_setup_key($key, $rounds){
		return array(
			self::des_setup_key(substr($key, 0, 8), $rounds),
			self::des_setup_key(substr($key, 8, 8), $rounds),
			self::des_setup_key(substr($Key, 16, 8), $rounds)
		);
	}
	public static function tripledes_encrypt($message, $key, $rounds){
		return self::des_proccess(
			self::des_proccess(
				self::des_proccess($message, $key[0][0], $rounds),
			$key[1][1], $rounds)
		, $key[2][0], $rounds);
	}
	public static function tripledes_decrypt($message, $key, $rounds){
		$message = str_pad($message, (strlen($message) + 7) & 0xFFFFFFF8, "\0");
		return self::des_proccess(
			self::des_proccess(
				self::des_proccess($message, $key[2][1], $rounds),
			$key[1][0], $rounds),
		$key[0][1], $rounds);
	}

	public static function pkcs5($algo, $password, $salt, $iterations, $length = 0, $raw = false){
		return self::hash_pbkdf2($algo, $password, $salt, $iterations, $length, $raw);
	}
}

/* ---------- Rand ---------- */
class Rand {
	const NORMAL = 0;
	const MD5 = 1;
	const RAND = 2;
	const URAND = 3;
	const WINCOM = 4;
	const BNC = 5;
	const MT19937 = 0;
	const MTPHP = 1;

	private static $seedcount = 0;
	public static function makeseed($fast = false){
		$time = microtime();
		$seed = (int)(substr($time, 11) + substr($time, 2, 8));
		if($fast === true)return $seed;
		if(__apeip_data::$instHrTime){
			$time = hrtime();
			$seed = (int)($seed + $time[0] + $time[1]);
		}
		if($fast === 0)return $seed;
		$seed = (int)($seed + memory_get_usage() * apeip::$pid);
		return (int)($seed + (++self::$seedcount));
	}
	public static function phpseed(){
		return (int)(microtime(true) * 1000000 * apeip::$pid);
	}
	public static function bsdseed($seed = null){
		if($seed === null)$seed = self::makeseed();
		return (int)(1103515245 * $seed + 12345);
	}
	public static function msseed($seed = null){
		if($seed === null)$seed = self::makeseed();
		return (int)(214013 * $seed + 2531011) >> 16;
	}

	private static $mtstate = array();
	private static $mtindex = 625;
	public static function mtinit($seed = null){
		if($seed === null)$seed = self::msseed();
		if(PHP_INT_SIZE === 8){
			$int0 = $seed & 0xffffffff;
			$int1 = ($seed >> 32) & 0xffffffff;
			$state = array($seed);
			for($i = 1; $i < 312; ++$i) {
				$int0 ^= $int1 >> 30;
				$carry = (0x4c957f2d * $int0) + $i;
				$int1 = ((0x4c957f2d * $int1) & 0xffffffff) +
						((0x5851f42d * $int0) & 0xffffffff) +
						($carry >> 32) & 0xffffffff;
				$int0 = $carry & 0xffffffff;
				$state[$i] = ($int1 << 32) | $int0;
			}
			self::$mtstate = $state;
			self::$mtindex = $i;
		}else{
			$state = array($seed & 0xffffffff);
			$int0 = $seed & 0xffff;
			$int1 = ($seed >> 16) & 0xffff;
			for($i = 1; $i < 624; ++$i) {
				$int0 ^= $int1 >> 14;
				$carry = (0x8965 * $int0) + $i;
				$int1 = ((0x8965 * $int1) + (0x6C07 * $int0) + ($carry >> 16)) & 0xffff;
				$int0 = $carry & 0xffff;
				$state[$i] = ($int1 << 16) | $int0;
			}
			self::$mtstate = $state;
			self::$mtindex = $i;
		}
	}
	public static function mttwist($m, $u, $v){
		if(PHP_INT_SIZE === 8){
			$y = ($u & -2147483648) | ($v & 0x7fffffff);
			return $m ^ (($y >> 1) & 0x7fffffffffffffff) ^ (-5403634167711393303 * ($v & 1));
		}else{
			$y = ($u & 0x80000000) | ($v & 0x7fffffff);
			return $m ^ (($y >> 1) & 0x7fffffff) ^ (0x9908b0df * ($v & 1));
		}
	}
	public static function mtint(){
		if(PHP_INT_SIZE === 8){
			if(self::$mtindex >= 312) {
				if(self::$mtindex === 313)
					self::mtinit(5489);
				$state = self::$mtstate;
				for($i = 0; $i < 156; ++$i)
					$state[$i] = self::mttwist($state[$i + 156], $state[$i], $state[$i + 1]);
				for(; $i < 311; ++$i)
					$state[$i] = self::mttwist($state[$i - 156], $state[$i], $state[$i + 1]);
				$state[311] = self::mttwist($state[155], $state[311], $state[0]);
				self::$mtstate = $state;
				self::$mtindex = 0;
			}
			$y = self::$mtstate[self::$mtindex++];
			$y ^= ($y >> 29) & 0x0000000555555555;
			$y ^= ($y << 17) & 0x71d67fffeda60000;
			$y ^= ($y << 37) &  -2270628950310912;
			$y ^= ($y >> 43) & 0x00000000001fffff;
			return $y;
		}else{
			if(self::$mtindex >= 624) {
				if(self::$mtindex === 625)
					self::mtinit(5489);
				$state = self::$mtstate;
				for($i = 0; $i < 227; ++$i)
					$state[$i] = self::mttwist($state[$i + 397], $state[$i], $state[$i + 1]);
				for(; $i < 623; ++$i)
					$state[$i] = self::mttwist($state[$i - 227], $state[$i], $state[$i + 1]);
				$state[623] = self::mttwist($state[396], $state[623], $state[0]);
				self::$mtstate = $state;
				self::$mtindex = 0;
			}
			$y = self::$mtstate[self::$mtindex++];
			$y ^= ($y >> 11) & 0x001fffff;
			$y ^= ($y <<  7) & 0x9d2c5680;
			$y ^= ($y << 15) & 0xefc60000;
			$y ^= ($y >> 18) & 0x00003fff;
			return $y;
		}
	}
	public static function mtintpb(){
		if(PHP_INT_SIZE === 8)
			return (self::mtint() >> 1) & 0x7fffffffffffffff;
		return (self::mtint() >> 1) & 0x7fffffff;
	}
	public static function mtrand($min, $max){
		if($max < $min)swap($max, $min);
		if(PHP_INT_SIZE === 8)
			return (int)($min + (($max - $min + 1) * (self::mtint() / 0x8000000000000000)));
		return (int)($min + (($max - $min + 1) * (self::mtint() / 0x80000000)));
	}
	public static function mtrandseed($min, $max, $seed = null){
		$mtstate = self::$mtstate;
		$mtindex = self::$mtindex;
		self::mtinit($seed);
		$rand = self::mtrand($min, $max);
		self::$mtstate = $mtstate;
		self::$mtindex = $mtindex;
	}

	public static function int($min, $max, $type = 0){
		if($max < $min)swap($max, $min);
		switch($type){
			case 2:
			case 3:
			case 4:
				if(function_exists('random_int'))
					return random_int($min, $max);
				self::mtinit();
				return self::mtrand($min, $max);
			case 5:
				return bnc::rand(floor($min), floor($max));
			default:
				return rand($min, $max);
		}
	}
	public static function bytes($length = 1, $type = 0){
		if($length <= 0)return '';
		switch($type){
			case 1:
				$bin = '';
				self::mtinit();
				for($i = 0; $i < $length; $i += 16)
					$bin .= md5(self::mtint(), true);
				return substr($bin ,0, $length);
			case 2:
				if(__apeip_data::$hasDev && is_readable(proc::$root . '/dev/random')){
					$file = fopen(proc::$root . '/dev/random', 'rb');
					stream_set_read_buffer($file, 0);
					$bin = fread($file, $length);
					fclose($file);
					return $bin;
				}
				if(__apeip_data::$instRandomDiv)
					return random_bytes($length);
				if(__apeip_data::$instOpenSSL)
					return openssl_random_pseudo_bytes($length);
				$bin = '';
				self::mtinit();
				for($i = 0; $i < $length; ++$i)
					$bin .= chr(self::mtrand(0, 255));
				return $bin;
			case 3:
				if(__apeip_data::$instRandomDiv)
					return random_bytes($length);
				if(__apeip_data::$instOpenSSL)
					return openssl_random_pseudo_bytes($length);
				if(__apeip_data::$hasDev && is_readable(proc::$root . '/dev/urandom')){
					$file = fopen(proc::$root . '/dev/urandom', 'rb');
					stream_set_read_buffer($file, 0);
					$bin = fread($file, $length);
					fclose($file);
					return $bin;
				}
				$bin = '';
				self::mtinit();
				for($i = 0; $i < $length; ++$i)
					$bin .= chr(self::mtrand(0, 255));
				return $bin;
			case 4:
				if(__apeip_data::$instCOMDotNet){
					try{
						$com = @new \COM("CAPICOM.Utilities.1");
						return $com->GetRandom($length, 0);
					}catch(Exception $e){}
					new APError('Crypt randbytes', 'The system not support COM.Net: CAPICOM.UTilities.1', APError::WARNING);
				}else new APError('Crypt randbytes', 'The COM.Net extension not installed', APError::WARNING);
			case 5:
				$min = bnc::powf('2', $length * 8 - 1);
				$max = bnc::sub(bnc::mulTwo($min), '1');
				$rand = bnc::rand($min, $max);
				$rand = bnc::base_convert($rand, 10, 'ascii');
				return substr($rand, 1);
		}
		$bin = '';
		for($i = 0; $i < $length; ++$i)
			$bin .= chr(rand(0, 255));
		return $bin;
	}
	public static function iv($cipher, $type = 0){
		if(substr($cipher, -3) == 'des' && is_numeric(substr($cipher, 0, -3)))$cipher = 'des';
		$size = crypt::blocklength($cipher);
		if($size === null){
			new APError('Crypt decrypt', 'Undefined cipher name', APError::WARNING);
			return false;
		}
		return self::bytes($size, $type);
	}
	public static function hex($length = 1, $type = 0){
		return substr(crypt::hexencode(self::bytes(ceil($length / 2), $type)), 0, $length);
	}
	public static function bin($length = 1, $type = 0){
		return substr(crypt::binencode(self::bytes(ceil($length / 8), $type)), 0, $length);
	}
	public static function oct($length = 1, $type = 0){
		return substr(crypt::octencode(self::bytes(ceil($length / 8 * 3), $type)), 0, $length);
	}
	public static function base64($length = 1, $type = 0){
		return substr(crypt::base64encode(self::bytes(ceil($length / 4 * 3), $type)), 0, $length);
	}
	public static function base64url($length = 1, $type = 0){
		return substr(crypt::base64urlencode(self::bytes(ceil($length / 4 * 3), $type)), 0, $length);
	}
	public static function base32($length = 1, $type = 0){
		return substr(crypt::base32encode(self::bytes(ceil($length / 8 * 5), $type)), 0, $length);
	}
	public static function bcrypt64($length = 1, $type = 0){
		return substr(crypt::bcrypt64encode(self::bytes(ceil($length / 4 * 3), $type)), 0, $length);
	}
	public static function hash($algo = 'md5', $length = 1, $type = 0, $raw = false){
		return crypt::hash($algo, self::bytes($length, $type), $raw);
	}
	public static function dec($length = 1, $type = 0){
		$dec = '';
		switch($type){
			case 2:
			case 3:
			case 4:
				if(function_exists('random_int')){
					for($i = 0; $i < $length; ++$i)
						$dec .= random_int(0, 9);
					return $dec;
				}
				self::mtinit();
				for($i = 0; $i < $length; ++$i)
					$dec .= self::mtrand(0, 9);
				return $dec;
			case 5:
				return substr(bnc::_rand0($length), 2);
		}
		for($i = 0; $i < $length; ++$i)
			$dec .= rand(0, 9);
		return $dec;
	}
	public static function big($min, $max, $type = 0){
		if($max < $min)swap($max, $min);
		$abs = bnc::inc(bnc::sub($max, $min));
		$rand = '0.' . self::dec(strlen($max), $type);
		$rand = bnc::floor(bnc::add(bnc::mul($abs, $rand), $min));
		return !is_string($min) && !is_string($max) ? (float)$rand : $rand;
	}
	public static function decimal($type = 0){
		return 1 - self::int(0, PHP_INT_MAX, $type) / PHP_INT_MAX;
	}
	public static function randnormal($mean = 0, $stdDev = 1, $type = 0){
		$U1 = self::decimal($type);
		$U2 = self::decimal($type);
		$normal = sqrt(-2 * log($U1)) * sin(2 * M_PI * $U2);
		return $mean + $stdDev * $normal;
	}
	public static function bool($number){
		if($number <= 0)
			return rand(0, -$number + 1) === 0;
		return rand(0, $number) !== 0;
	}

	public static function key($array, $type = 0){
		$keys = array_keys($array);
		$count = count($keys);
		return $keys[self::int(0, $count - 1, $type)];
	}
	public static function value($array, $type = 0){
		$values = array_values($array);
		$count = count($values);
		return $values[self::int(0, $count - 1, $type)];
	}

	public static function query($query){
		$min = $max = $number = 0;
		$query = str_replace("\t", ' ', $query);
		$query = explode("\n", strtoupper(trim($query, "\n")));
		foreach($query as $row){
			$row = trim($row, ' ');
			do {
				$row = str_replace('  ', ' ', $prev = $row);
			}while($prev != $row);
			$row = explode(' ', $row);
			$cmd = '';
			$arg = array();
			foreach($row as $n => $col)
				if(is_numeric($col)){
					$cmd .= '@';
					$arg[] = $col;
				}else
					$cmd .= '.' . $col;
			switch($cmd){
				case '@.TO@':
					$min = (int)$arg[0];
					$max = (int)$arg[1];
					$number = rand($min, $max);
				break;
				case '.RAND@.TO@':
					$min = (int)$arg[0];
					$max = (int)$arg[1];
					$number = self::int($min, $max, self::RAND);
				break;
				case '.URAND@.TO@':
					$min = (int)$arg[0];
					$max = (int)$arg[1];
					$number = self::int($min, $max, self::URAND);
				break;
				case '.XNNUMBER@.TO@':
					$min = (int)$arg[0];
					$max = (int)$arg[1];
					$number = self::int($min, $max, self::XNNUMBER);
				break;
				case '.ADD@.TO@':
					$min += (int)$arg[0];
					$max += (int)$arg[1];
					$number += rand($min, $max);
				break;
				case '.SUB@.TO@':
					$min -= (int)$arg[0];
					$max -= (int)$arg[1];
					$number -= rand($min, $max);
				break;
				case '.MUL@.TO@':
					$min *= (int)$arg[0];
					$max *= (int)$arg[1];
					$number *= rand($min, $max);
				break;
				case '.OR@.TO@':
					if(rand(0, 1) == 1)break;
					$min = (int)$arg[0];
					$max = (int)$arg[1];
					$number = rand($min, $max);
				break;
				case '.OR@.TO@.FOR@':
					if(self::bool((int)$arg[2]))break;
					$min = (int)$arg[0];
					$max = (int)$arg[1];
					$number = rand($min, $max);
				break;
				case '.FROM@.TO@':
					$min = (int)$arg[0];
					$max = (int)$arg[1];
				break;
				case '.MIN@':
					$min = (int)$arg[0];
				break;
				case '.MAX@':
					$max = (int)$arg[0];
				break;
				// rand(number ** attract) ** (1 / attract)
				case '.ATTRACT.RIGHT@':
					$attract = (int)$arg[0];
					$mmin = pow($min, $attract);
					$mmax = pow($max, $attract);
					$mmax+= 0.99999999999999999;
					$a = PHP_INT_MAX / $mmax;
					if($a < 1)break;
					$a = ceil($a);
					$mmin *= $a;
					$mmax *= $a;
					$number = floor(pow(rand($mmin, $mmax) / $a, 1 / $attract));
				break;
				case '.ATTRACT.LEFT@':
					$attract = -(int)$arg[0];
					$mmin = pow($min, $attract);
					$mmax = pow($max, $attract);
					$mmax+= 0.99999999999999999;
					$a = PHP_INT_MAX / $mmax;
					if($a < 1)break;
					$a = ceil($a);
					$mmin *= $a;
					$mmax *= $a;
					$number = floor(pow(rand((int)$mmin, (int)$mmax) / $a, 1 / $attract));
				break;
			}
		}
		return $number;
	}

	private static $sinseed;
	private static $sinindx;
	public static function sininit($seed = null){
		if($seed === null)$seed = self::msseed();
		self::$sinseed = (int)$seed;
		self::$sinindx = 0;
	}
	public static function sinrand($min, $max){
		if($min > $max)swap($min, $max);
		$x = ($max - $min + 1);
		return floor($min + $x * ((sin(self::$sinseed * $x + (self::$sinindx++))+1)/2));
	}
}

/* ---------- APED ---------- */
class APED {
	private static $objOw = false, $objWe = false, $objMe = false;

	const VERSION = '4.4.1';
	public $zlib = false;

	private static function serializetag($obj, $i){
		$c = 1;
		$b = false;
		$l = $i;
		while($c !== 0){
			++$i;
			if($b === true){
				if($obj[$i] == '"')$b = false;
				elseif($obj[$i] == '\\')++$i;
			}
			elseif($obj[$i] == '{')++$c;
			elseif($obj[$i] == '}')--$c;
			elseif($obj[$i] == '"')$b = true;
		}
		return $i - $l + 1;
	}
	private static function unserializetag($obj, $tag, $i){
		$c = 1;
		$b = false;
		$l = $i;
		while($c !== 0){
			++$i;
			if($b === true){
				if($obj[$i] == '"')$b = false;
				elseif($obj[$i] == '\\')++$i;
			}
			elseif($obj[$i] == $tag[0])++$c;
			elseif($obj[$i] == $tag[1] && $tag == '[]')--$c;
			elseif($obj[$i] == $tag[1]){--$c;$b = true;}
			elseif($obj[$i] == '"' || $obj[$i] == 'p' || $obj[$i] == 'P' || $obj[$i] == '}' || $obj[$i] == '>')$b = true;
		}
		++$i;
		if($tag != '[]')
			while($obj[$i++] != '"')
				if($obj[$i] == '\\')++$i;
		return $i - $l;
	}
	private static function serializeobj($obj, $cls = null){
		if($obj == 'N;')return 'N';
		if($obj == 'b:0;')return 'f';
		if($obj == 'b:1;')return 't';
		if($obj == 'a:0:{}')return '|';
		if($obj[0] == 'i'){
			$num = substr($obj, 2, -1);
			$nm  = $num < 0 ? ~crypt::hexdecode(base_convert(-$num, 10, 16)) : crypt::hexdecode(base_convert($num, 10, 16));
			return 'i' . ($num < 0 ? chr(256 - strlen($nm)) : chr(strlen($nm))) . $nm;
		}
		if($obj[0] == 'd'){
			$num = substr($obj, 2, -1);
			$e = explode('E', $num, 2);
			$num = $e[0];
			$e = pack('v', isset($e[1]) ? $e[1] * 1 : 0);
			$d = strpos($num, '.');
			$d = chr($d === false ? 0 : $d);
			$num = str_replace('.', '', $num);
			$nm  = $num < 0 ? ~crypt::hexdecode(base_convert(-$num, 10, 16)) : crypt::hexdecode(base_convert($num, 10, 16));
			return 'd' . $d . $e . ($num < 0 ? chr(256 - strlen($nm)) : chr(strlen($nm))) . $nm;
		}
		if($obj[0] == 's')
			return '"' . str_replace(array('\\', '"'), array('\\\\', '\"'), substr($obj, strpos($obj, ':', 3) + 2, -2)) . '"';
		if($obj[0] == 'R')
			return 'R' . self::sizeencode((float)substr($obj, 2, -1));
		if($obj[0] == 'r')
			return 'r' . self::sizeencode((float)substr($obj, 2, -1));
		if($obj[0] == 'x' || $obj[0] == 'm')
			return $obj[0] . self::serializeobj(substr($obj, 2));
		if($obj[0] == 'O')
			return '{' . self::serializeobj(substr($obj, strpos($obj, '{', ($p = strpos($obj, ':', 2)) + ($l = substr($obj, 2, $p - 2) + 2) + 3)), $t = substr($obj, $p + 2, $l - 2)) . '}'
				. ($t == 'stdClass' ? '' : $t) . '"';
		if($obj[0] == 'C')
			return '<' . self::serializeobj(substr($obj, strpos($obj, '{', ($p = strpos($obj, ':', 2)) + ($l = substr($obj, 2, $p - 2) + 2) + 3)), $t = substr($obj, $p + 2, $l - 2)) . '>'
				. ($t == 'ArrayIterator' ? '' : $t) . '"';
		if($obj[0] == 'a')
			return '[' . self::serializeobj(substr($obj, strpos($obj, '{', 4))) . ']';
		if($obj == '{}')return '';
		if($obj[0] == '{'){
			$res = '';
			for($i = 1; $obj[$i] != '}';){
				if($obj[$i] == 'x' || $obj[$i] == 'm'){
					$res .= $obj[$i];
					$i += 2;
				}elseif(in_array($obj[$i], array('N', 'b', 'i', 'd', 'R', 'r'))){
					$res .= self::serializeobj($r = substr($obj, $i, ($p = strpos($obj, ';', $i)) - $i + 1));
					$i = $p + 1;
				}elseif($obj[$i] == 's'){
					$l = substr($obj, $i + 2, ($p = strpos($obj, ':', $i + 2)) - $i - 2);
					$str = substr($obj, $p + 1, $l + 2);
					if($cls !== null){
						if(strpos($str, "\"\0*\0") === 0)$str = 'P' . substr($str, 4);
						if(strpos($str, "\"\0$cls\0") === 0)$str = 'p' . substr($str, strlen($cls) + 3);
					}$res .= $str;
					$i = $p + $l + 4;
				}elseif(substr($obj, $i, 6) == 'a:0:{}'){
					$res .= '|';
					$i += 6;
				}elseif($obj[$i] == 'a'){
					$i = strpos($obj, '{', $i + 4);
					$l = self::serializetag($obj, $i);
					$res .= '[' . self::serializeobj(substr($obj, $i, $l)) . ']';
					$i += $l;
				}elseif($obj[$i] == 'O'){
					$t = substr($obj, ($p = strpos($obj, ':', $i + 3)) + 2, $l = (int)substr($obj, $i + 2, $p - $i));
					$i = strpos($obj, '{', $p + $l + 5);
					$l = self::serializetag($obj, $i);
					$res .= '{' . self::serializeobj(substr($obj, $i, $l), $t) . '}' . ($t == 'stdClass' ? '' : $t) . '"';
					$i += $l;
				}elseif($obj[$i] == 'C'){
					$t = substr($obj, ($p = strpos($obj, ':', $i + 3)) + 2, $l = (int)substr($obj, $i + 2, $p - $i));
					$i = strpos($obj, '{', $p + $l + 5);
					$l = self::serializetag($obj, $i);
					$res .= '<' . self::serializeobj(substr($obj, $i, $l), $t) . '>' . ($t == 'ArrayIterator' ? '' : $t) . '"';
					$i += $l;
				}elseif($obj[$i] == ';')++$i;
			}
			if(strpos($res, "i\1\0") === 0)
				return substr($res, 3);
			return $res;
		}
	}
	public static function unserializeobj($obj, $cls = null){
		if($obj == 'N')return 'N;';
		if($obj == 'f')return 'b:0;';
		if($obj == 't')return 'b:1;';
		if($obj == '|')return 'a:0:{}';
		if($obj == ';')return '';
		if($obj[0] == 'i'){
			$l = ord($obj[1]);
			$num = substr($obj, 2, $l > 127 ? 256 - $l : $l);
			return 'i:' . ((int)($l > 127 ? -base_convert(crypt::hexencode($num), 16, 10) : base_convert(crypt::hexencode($num), 16, 10))) . ';';
		}
		if($obj[0] == 'd'){
			$d = ord($obj[1]);
			$e = array_value(unpack('v', $obj[2] . $obj[3]), 1);
			$l = ord($obj[4]);
			$num = substr($obj, 5, $l > 127 ? 256 - $l : $l);
			$num = $l > 127 ? -base_convert(crypt::hexencode($num), 16, 10) : base_convert(crypt::hexencode($num), 16, 10);
			if($d != 0)$num = substr_replace($num, '.', $d, 0);
			return 'd:' . ((float)$num * pow(10, $e)) . ';';
		}
		if($obj[0] == 'p' && $cls === null)$cls = 'stdClass';
		if($obj[0] == '"' || $obj[0] == 'P' || $obj[0] == 'p')
			$obj = $obj[0] . str_replace(array('\"', '\\\\'), array('"', '\\'), substr($obj, 1, -1)) . '"';
		if($obj[0] == '"')
			return 's:' . (strlen($obj) - 2) . ':"' . substr($obj, 1, -1) . '";';
		if($obj[0] == 'P')
			return 's:' . (strlen($obj) + 1) . ":\"\0*\0" . substr($obj, 1, -1) . '";';
		if($obj[0] == 'p')
			return 's:' . (strlen($obj) + strlen($cls)) . ":\"\0$cls\0" . substr($obj, 1, -1) . '";';
		if($obj[0] == 'R')
			return 'R:' . self::sizedecode(substr($obj, 1)) . ';';
		if($obj[0] == 'r')
			return 'r:' . self::sizedecode(substr($obj, 1)) . ';';
		if($obj[0] == 'x' || $obj[0] == 'm')
			return $obj[0] . ':' . (in_array($obj[1], array('[', '{', '<')) ? self::unserializeobj(substr($obj, 1), $cls) . ';' : self::unserializeobj(substr($obj, 1), $cls));
		if($obj[0] == '['){
			$obj = ':' . substr($obj, 1, -1);
			return 'a:' . self::unserializeobj($obj);
		}
		if($obj[0] == '{'){
			$l = strrpos($obj, '}', 1) + 1;
			$cls = substr($obj, $l, -1);
			if($cls === '')$cls = 'stdClass';
			$obj = self::unserializeobj(':' . substr($obj, 1, $l - 2), $cls);
			return 'O:' . strlen($cls) . ':"' . $cls . '":' . $obj;
		}
		if($obj[0] == '<'){
			$l = strrpos($obj, '>', 1) + 1;
			$cls = substr($obj, $l, -1);
			if($cls === '')$cls = 'ArrayIterator';
			$obj = self::unserializeobj(';' . substr($obj, 1, $l - 2), $cls);
			return 'C:' . strlen($cls) . ':"' . $cls . '":' . $obj;
		}
		if($obj[0] == ':' || $obj[0] == ';'){
			if($obj[0] == ';')$C = true;
			else $C = false;
			$res = '';
			$c = 0;
			for($i = 1; isset($obj[$i]); ++$c){
				if(in_array($obj[$i], array('N', 'f', 't', '|', ';')))
					$res .= self::unserializeobj($obj[$i++]);
				elseif($obj[$i] == 'i'){
					$l = ord($obj[$i + 1]);
					if($l > 127)$l = 256 - $l;
					$res .= self::unserializeobj(substr($obj, $i, $l + 2));
					$i += $l + 2;
				}elseif($obj[$i] == 'd'){
					$l = ord($obj[$i + 4]);
					if($l > 127)$l = 256 - $l;
					$res .= self::unserializeobj(substr($obj, $i, $l + 5));
					$i += $l + 5;
				}elseif($obj[$i] == '"' || $obj[$i] == 'p' || $obj[$i] == 'P'){
					$l = $i;
					while($obj[++$i] != '"')
						if($obj[$i] == '\\')++$i;
					++$i;
					$res .= self::unserializeobj(substr($obj, $l, $i - $l), $cls);
				}elseif($obj[$i] == 'x' || $obj[$i] == 'm'){
					if(substr($res, -1) != ';')$res .= ';';
					$res .= $obj[$i++] . ':';
					--$c;
				}elseif($obj[$i] == 'r' || $obj[$i] == 'R'){
					$res .= $obj[$i] . ':';
					$res .= self::sizedecode(substr($obj, $i + 1, $p = ord($obj[$i + 1]) + 1)) . ';';
					$i += $p + 1;
				}elseif($obj[$i] == '['){
					$l = self::unserializetag($obj, '[]', $i);
					$res .= self::unserializeobj(substr($obj, $i, $l));
					$i += $l;
				}elseif($obj[$i] == '{'){
					$l = self::unserializetag($obj, '{}', $i);
					$res .= self::unserializeobj(substr($obj, $i, $l));
					$i += $l;
				}elseif($obj[$i] == '<'){
					$l = self::unserializetag($obj, '<>', $i);
					$res .= self::unserializeobj(substr($obj, $i, $l));
					$i += $l;
				}
			}
			return $C ? strlen($res) . ':{' . $res . '}' : ($c % 2 === 1 ? (($c + 1) / 2) . ':{i:0;' . $res . '}' : ($c / 2) . ':{' . $res . '}');
		}
	}
	public static function serialize($input){
		return self::serializeobj(serialize($input));
	}
	public static function unserialize($input){
		return @unserialize(self::unserializeobj($input));
	}
	public static function isserialize($input){
		return $input === 'f' || self::unserialize($input) !== false;
	}
	function json_last_error() {
		if(__apeip_data::$jsonerror > 10)
			return __apeip_data::$jsonerror;
		if(__apeip_data::$instJson)
			return json_last_error();
		return __apeip_data::$jsonerror;
	}
	function json_last_error_msg() {
		if(__apeip_data::$instJson)
			return json_last_error_msg();
		if(__apeip_data::$jsonerror > 11)
			return 'Unknown';
		return array_value(array(
			'No error',
			'Maximum stack depth exceeded',
			'Invalid or malformed JSON',
			'Control character error, possibly incorrectly encoded',
			'Syntax error',
			'Malformed UTF-8 characters, possibly incorrectly encoded',
			'One or more recursive references in the value to be encoded',
			'Inf and NaN cannot be JSON encoded',
			'A value of a type that cannot be encoded was given',
			'A property name that cannot be encoded was given',
			'Malformed UTF-16 characters, possibly incorrectly encoded',
			'Key cannot be Object or Array'
		), __apeip_data::$jsonerror);
	}
	private static function _jsonencode($value, $options = 0, $depth = 512){
		if($value === null)
			return 'null';
		if($value === false)
			return 'false';
		if($value === true)
			return 'true';
		switch(gettype($value)){
			case 'string':
				if($options & JSON_NUMERIC_CHECK && is_numeric($value))
					return ($value + 0) . '';
				if(~$options & JSON_UNESCAPED_UNICODE)
					$value = unicode_encode($value);
				$value = '"' . str_replace(array('\\', '"', "\n", "\r", "\t"), array('\\\\', '\"', '\n', '\r', '\t'), $value) . '"';
				if($options & JSON_HEX_TAG)
					$value = str_replace(array('<', '>'), array('\u003C', '\u003E'), $value);
				if($options & JSON_HEX_AMP)
					$value = str_replace('&', '\u0026', $value);
				if($options & JSON_HEX_APOS)
					$value = str_replace("'", '\u0027', $value);
				if($options & JSON_HEX_QUOT)
					$value = str_replace('"', '\u0022', $value);
				if(~$options & JSON_UNESCAPED_SLASHES)
					$value = str_replace('/', '\/', $value);
				return $value;
			break;
			case 'integer':
			case 'double':
			case 'float':
				if(is_infinite($value) || is_nan($value)){
					__apeip_data::$jsonerror = JSON_ERROR_INF_OR_NAN;
					if(~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)return null;
					return '0';
				}
				if($options & JSON_PRESERVE_ZERO_FRACTION && !is_int($value))
					return $value . '.0';
				return (string)$value;
			break;
			case 'array':
			case 'object':
				if($depth <= 0){
					__apeip_data::$jsonerror = JSON_ERROR_DEPTH;
					if(~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)return null;
				}
				if($options & JSON_PRETTY_PRINT){
					if(is_array($value) && ~$options & JSON_FORCE_OBJECT){
						$str = "[\n" . str::PRETTY_CHAR;
						$c = 0;
						foreach($value as $key => $val){
							if($key == $c++)
								$str .= str_replace("\n","\n" . str::PRETTY_CHAR,self::_jsonencode($val, $options, $depth - 1)) . ",\n" . str::PRETTY_CHAR;
							else{
								$str = '';
								break;
							}
							if(__apeip_data::$jsonerror > 0 && ~$options & JSON_FORCE_OBJECT)return null;
						}
					}else $str = '';
					if($str){
						if($str == "[\n" . str::PRETTY_CHAR)
							$str = '[]';
						else
							$str = substr_replace($str,"\n]",-6,6);
						return $str;
					}
					if(is_object($value))
						$value = (array)$value;
					$str = "{\n" . str::PRETTY_CHAR;
					foreach($value as $key => $val){
						if($key[0] == "\0")continue;
						$str .= self::_jsonencode((string)$key, $options, $depth - 1) . ': ' . str_replace("\n", "\n" . str::PRETTY_CHAR, self::_jsonencode($val,$options,$depth - 1)) . ",\n" . str::PRETTY_CHAR;
						if(__apeip_data::$jsonerror > 0 && ~$options & JSON_FORCE_OBJECT)return null;
					}
					if($str == "{\n" . str::PRETTY_CHAR)
						$str = '{}';
					else
						$str = substr_replace($str, "\n}", -6, 6);
					return $str;
				}
				if(is_array($value) && ~$options & JSON_FORCE_OBJECT){
					$str = '[';
					$c = 0;
					foreach($value as $key => $val){
						if($key == $c++)
							$str .= self::_jsonencode($val,$options,$depth - 1) . ',';
						else{
							$str = '';
							break;
						}
						if(__apeip_data::$jsonerror > 0 && ~$options & JSON_FORCE_OBJECT)return null;
					}
				}else $str = '';
				if($str){
					if($str == '[')
						$str = '[]';
					else $str[strlen($str) - 1] = ']';
					return $str;
				}
				if(is_object($value))
					$value = (array)$value;
				$str = '{';
				foreach($value as $key => $val){
					if($key[0] == "\0")continue;
					$str .= self::_jsonencode((string)$key,$options,$depth - 1) . ':' . self::_jsonencode($val,$options,$depth - 1) . ',';
					if(__apeip_data::$jsonerror > 0 && ~$options & JSON_FORCE_OBJECT)return null;
				}
				if($str == '{')
					$str = '{}';
				else
					$str[strlen($str) - 1] = '}';
				return $str;
			break;
			default:
				__apeip_data::$jsonerror = JSON_ERROR_UNSUPPORTED_TYPE;
				if(~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)return null;
				return '';
		}
	}
	public static function jsonencode($value, $options = 0, $depth = 512){
		if(__apeip_data::$instJson)
			return json_encode($value, $options, $depth);
		__apeip_data::$jsonerror = JSON_ERROR_NONE;
		return self::_jsonencode($value, $options, $depth);
	}
	private static function _jsondecode($value, $assoc = false, $depth = 512, $options = 0){
		if($value == 'null')
			return null;
		if($value == 'false')
			return false;
		if($value == 'true')
			return true;
		if(is_numeric($value))
			return (float)$value;
		if($value[0] == '"'){
			$l = strlen($value);
			if($value[$l - 1] !== '"' || preg_match("/(?<!\\\\)\"/", $value = substr($value, 1, -1))){
				__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
				return null;
			}
			$value = unicode_decode($value);
			if(preg_match("/(?<!\\\\)\\\\u/", $value)){
				__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
				return null;
			}
			return str_replace(array('\"','\/','\\\\'),array('"','/','\\'),$value);
		}
		if($options & JSON_PARSE_JAVASCRIPT && $value[0] == "'"){
			$l = strlen($value);
			if($value[$l - 1] !== "'" || preg_match("/(?<!\\\\)'/", $value = substr($value, 1, -1))){
				__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
				return null;
			}
			$value = unicode_decode($value);
			if(preg_match("/(?<!\\\\)\\\\u/", $value)){
				__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
				return null;
			}
			return str_replace(array("\\'",'\/','\\\\'),array("'",'/','\\'),$value);
		}
		if($value[0] == '['){
			if($depth <= 0){
				__apeip_data::$jsonerror = JSON_ERROR_DEPTH;
				if(~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)return null;
			}
			$value = substr($value, 1, -1);
			$poses = array();
			$prev = $pos = 0;
			preg_replace_callback("/\"(?:\\\\\"|[^\"])*\"|'(?:\\\\'|[^'])*'|(?<x>\[((?:\g<x>|\\\\\[|\\\\\]|\"(?:\\\\\"|[^\"])*\"|'(?:\\\\'|[^'])*'|[^\[\]])*)\])|(?<y>\{((?:\g<y>|\\\\\{|\\\\\}|\"(?:\\\\\"|[^\"])*\"|'(?:\\\\'|[^'])*'|[^\{\}])*)\})|,/",
				function($x)use(&$poses, &$pos, &$prev, $value){
					$pos = strpos($value, $x[0], $pos) + strlen($x[0]);
					if($x[0] == ','){
						$poses[] = substr($value, $prev, $pos - 1 - $prev);
						$prev = $pos;
					}
					return '';
				}, $value);
			$pos = substr($value, $prev);
			if($pos !== '')
				$poses[] = $pos;
			foreach($poses as &$pos){
				$pos = self::_jsondecode(trim($pos), $assoc, $depth - 1, $options);
				if($pos === null)return null;
			}
			return $poses;
		}
		if($value[0] == '{'){
			if($depth <= 0){
				__apeip_data::$jsonerror = JSON_ERROR_DEPTH;
				if(~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)return null;
			}
			$value = substr($value, 1, -1);
			$poses = array();
			$prev = $pos = 0;
			preg_replace_callback("/\"(?:\\\\\"|[^\"])*\"|'(?:\\\\'|[^'])*'|(?<x>\[((?:\g<x>|\\\\\[|\\\\\]|\"(?:\\\\\"|[^\"])*\"|'(?:\\\\'|[^'])*'|[^\[\]])*)\])|(?<y>\{((?:\g<y>|\\\\\{|\\\\\}|\"(?:\\\\\"|[^\"])*\"|'(?:\\\\'|[^'])*'|[^\{\}])*)\})|,|:/",
				function($x)use(&$poses, &$pos, &$prev, $value){
					$pos = strpos($value, $x[0], $pos) + strlen($x[0]);
					if($x[0] == ','){
						$poses[] = array(',', substr($value, $prev, $pos - 1 - $prev));
						$prev = $pos;
					}elseif($x[0] == ':'){
						$poses[] = array(':', substr($value, $prev, $pos - 1 - $prev));
						$prev = $pos;
					}
					return '';
				}, $value);
			$pos = substr($value, $prev);
			if($pos !== '')
				$poses[] = array(',', $pos);
			if(count($pos) % 2 === 0 || (isset($poses[0]) && $poses[0][0] == ',')){
				__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
				return null;
			}
			foreach($poses as $k=>&$pos){
				if(isset($poses[$k - 1]) && $poses[$k - 1][0] == $pos[0]){
					__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
					return null;
				}
				if($pos[1] == 'null')
					$pos[1] = null;
				else{
					$pos[1] = self::_jsondecode(trim($pos[1]), $assoc, $depth - 1, $options);
					if($pos[1] === null)return null;
				}
			}
			if($options & JSON_OBJECT_AS_ARRAY || $assoc === true){
				$obj = array();
				for($i = 0;isset($poses[$i]);$i += 2)
					$obj[$poses[$i][1]] = $poses[$i + 1][1];
			}else{
				$obj = new stdClass;
				for($i = 0;isset($poses[$i]);$i += 2)
					$obj->{$poses[$i][1]} = $poses[$i + 1][1];
			}
			return $obj;
		}
		__apeip_data::$jsonerror = JSON_ERROR_SYNTAX;
		return null;
	}
	public static function jsondecode($value, $assoc = false, $depth = 512, $options = 0){
		if(__apeip_data::$instJson)
			return json_decode($value, $assoc, $depth, $options);
		__apeip_data::$jsonerror = JSON_ERROR_NONE;
		return self::_jsondecode($value, $assoc, $depth, $options);
	}

	public static function sizeencode($l){
		$n = ceil(log($l, 256));
		$l = dechex($l - (int)pow(256, $n - 1) + 1);
		return str_pad(crypt::hexdecode($l), $n, "\0", STR_PAD_LEFT);
	}
	public static function sizedecode($l){
		$n = strlen($l) - 1;
		$l = hexdec(crypt::hexencode($l));
		$v = $l >> $n * 8;
		if($v == 1 && $v << $n * 8 == $l)
			return $l;
		return $l + pow(256, $n) - 1;
	}
	public static function encodeon($key){
		switch(gettype($key)){
			case "NULL":
				$type = 1;
				$key = '';
			break;
			case "boolean":
				if($key)
					$type = 2;
				else
					$type = 3;
				$key = '';
			break;
			case "integer":
			case "double":
			case "float":
				$type = 4;
				if($key == floor($key)){
					$pkey = math::decstr($key);
					if(!is_numeric($pkey))
						$key = $pkey;
					else
						$key = (string)$key;
				}else
					$key = (string)$key;
			break;
			case "string":
				$type = 5;
			break;
			case "array":
				$type = 6;
				$key = substr(serialize($key),2,-1);
			break;
			case "object":
				if(is_closure($key)){
					$type = 8;
					$key = unce($key);
				}else{
					$type = 7;
					$key = substr(serialize($key),2,-1);
				}
			break;
			default:
				new APError("APED", "unsupported Type", APError::TYPE, APError::TTHROW);
		}
		$key = chr($type).$key;
		$l = strlen($key);
		$s = self::sizeencode($l);
		$l = strlen($s);
		return chr($l).$s.$key;
	}
	public static function encodevw($key){
		switch(gettype($key)){
			case "NULL":
				$type = 1;
				$key = '';
			break;
			case "boolean":
				if($key)
					$type = 2;
				else
					$type = 3;
				$key = '';
			break;
			case "integer":
			case "double":
			case "float":
				$type = 4;
				if($key == floor($key)){
					$pkey = math::decstr($key);
					if(!is_numeric($pkey))
						$key = $pkey;
					else
						$key = (string)$key;
				}else
					$key = (string)$key;
			break;
			case "string":
				$type = 5;
			break;
			case "array":
				$type = 6;
				$key = substr(serialize($key),2,-1);
			break;
			case "object":
				if(is_closure($key)){
					$type = 8;
					$key = unce($key);
				}else{
					$type = 7;
					$key = substr(serialize($key),2,-1);
				}
			break;
			default:
				new APError("APED", "unsupported Type", APError::TYPE, APError::TTHROW);
		}
		return chr($type).$key;
	}
	public static function decodeon($key){
		$type = ord($key[0]);
		$key = substr_replace($key,'',0,1);
		switch($type){
			case 1:
				$key = null;
			break;
			case 2:
				$key = true;
			break;
			case 3:
				$key = false;
			break;
			case 4:
				if(!is_numeric($key))
					$key = math::strdec($key);
				$key = $key + 0;
			break;
			case 5:
			break;
			case 6:
				$key = unserialize("a:$key}");
			break;
			case 7:
				$key = unserialize("O:$key}");
			break;
			case 8:
				$key = eval("return $key;");
			break;
			default:
				new APError("APED", "unsupported Type", APError::TYPE, APError::TTHROW);
		}
		return $key;
	}
	public static function encodeel($key,$value){
		$key .= $value;
		$l = strlen($key);
		$s = self::sizeencode($l);
		$l = strlen($s);
		return chr($l).$s.$key;
	}
	public static function decodeel($key){
		$l = ord($key[0]);
		$s = substr($key,0,$l);
		$s = self::sizedecode($s);
		$value = substr($key,$l+$s+1);
		$key = substr($key,$l+1,$s);
		$l = ord($value[0]);
		$s = substr($value,0,$l);
		$s = self::sizedecode($s);
		$value = substr($value,$l+1,$s);
		return array($key,$value);
	}
	public static function decodenz($key){
		return self::decodeon(substr($key,ord($key[0]) + 1));
	}
	public static function decodeez($key){
		return self::decodeel(substr($key,ord($key[0]) + 1));
	}

	// constructors
	public $obj, $type;
	public static function give($obj){
		$aped = new APED;
		if($obj instanceof APEDString ||
		   $obj instanceof APEDFile   ||
		   $obj instanceof APEDURL	||
		   $obj instanceof APEDSQLi)
			$aped->obj = $obj;
		elseif($obj instanceof APED)
			$aped->obj = $obj->obj;
		elseif($obj instanceof APEDObject)
			$aped->obj = $obj->obj->obj;
		else return false;
		if($aped->obj instanceof APEDString){
			$aped->type = "string";
			$aped->setCreatedTime();
		}elseif($aped->obj instanceof APEDFile){
			$aped->type = "file";
			$aped->loadCreatedTime();
		}elseif($aped->obj instanceof APEDURL)
			$aped->type = "url";
		elseif($aped->obj instanceof APEDSQLi){
			$aped->type = "sqli";
			$aped->loadCreatedTime();
		}
		return $aped;
	}
	public static function string($data = ''){
		$obj = new APED;
		$obj->obj = new APEDString($data);
		$obj->type = "string";
		if(!$data)
			$obj->setCreatedTime();
		return $obj;
	}
	public static function file($file){
		if(!is_file($file) && !@touch($file))
			new APError('Aped::file', "Not such file \"$file\"", APError::WARNING, APError::TTHROW);
		$obj = new APED;
		$obj->obj = new APEDFile($file);
		$obj->type = "file";
		$obj->loadCreatedTime();
		return $obj;
	}
	public static function url($url){
		$obj = new APED;
		$obj->obj = new APEDURL($url);
		$obj->type = "url";
		return $obj;
	}
	public static function tmp($data = ''){
		$obj = new APED;
		$file = tmpfile();
		fwrite($file,$data);
		$obj->obj = new APEDFile($file);
		$obj->type = "file";
		if(!$data)
			$obj->setCreatedTime();
		return $obj;
	}
	public static function memory($data = ''){
		$obj = new APED;
		$file = fopen("data://aped/application,$data",'r+b');
		$obj->obj = new APEDFile($file);
		$obj->type = "file";
		if(!$data)
			$obj->setCreatedTime();
		return $obj;
	}
	public static function input(){
		$obj = new APED;
		$obj->obj = new APEDURL('php://input');
		$obj->type = "url";
		return $obj;
	}
	public static function apeip_data(){
		if(self::$objOw)
			return self::$objOw;
		if(__apeip_data::$objFile)$obj = aped::file(__apeip_data::$objFile);
		elseif(file_exists(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped'))$obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		elseif(file_exists('contents.aped'))$obj = aped::file('contents.aped');
		else $obj = aped::url("https://raw.githubusercontent.com/apeip/php-openAPEIP/master/contents.aped");
		$obj->obj = true;
		return $obj;
	}
	public static function sqli($host, $username, $password = '', $database = ''){
		if(!__apeip_data::$instMySQLi)
			return false;
		$obj = new APED;
		$obj->obj = new APEDSQLi($host, $username, $password, $database);
		$obj->type = "sqli";
		if($this->obj->maked)
			$obj->setCreatedTime();
		return $obj;
	}
	public static function me(){
		if(self::$objMe)
			return self::$objMe;
		if(__apeip_data::$objFile)$obj = aped::file(__apeip_data::$objFile);
		elseif(file_exists(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped'))$obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		elseif(file_exists('contents.aped'))$obj = aped::file('contents.aped');
		else $obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		$obj = $obj->mdir('m')->mdir(thefile());
		$obj->obj = true;
		return $obj;
	}
	public static function we(){
		if(self::$objWe)
			return self::$objWe;
		if(__apeip_data::$objFile)$obj = aped::file(__apeip_data::$objFile);
		elseif(file_exists(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped'))$obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		elseif(file_exists('contents.aped'))$obj = aped::file('contents.aped');
		else $obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		$obj = $obj->mdir('w');
		$obj->obj = true;
		return $obj;
	}
	public static function _aped_file_flush($make = false){
		if(__apeip_data::$objFile)$obj = aped::file(__apeip_data::$objFile);
		elseif(file_exists(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped'))$obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		elseif(file_exists('contents.aped'))$obj = aped::file('contents.aped');
		else $obj = aped::url("https://raw.githubusercontent.com/apeip/php-openAPEIP/master/contents.aped");
		self::$objOw = $obj;
		if(!$make && $obj->type == 'url')
			return;
		elseif($obj->type == 'url')
			$obj = aped::file(__apeip_data::$dirname . DIRECTORY_SEPARATOR . 'contents.aped');
		self::$objMe = $obj->mdir('m')->mdir(thefile());
		self::$objWe = $obj->mdir('w');
		return;
	}
	const TMP = 0;
	const MEMORY = 1;
	const INPUT = 2;
	public static function open($file = ''){
		if(is_aped($file))
			return self::give($file);
		if(is_resource($file) || file_exists($file))
			return self::file($file);
		if($file == 'tmp' || $file == self::TMP)
			return self::tmp($file);
		if($file == 'memory' || $file == self::MEMORY)
			return self::memory($file);
		if($file == 'input' || $file == self::INPUT)
			return self::input();
		if(strpos($file, 'mysqli:') == 0){
			$file = explode('/', substr($file, 7));
			if(!isset($file[1]))$file[1] = '';
			$file[0] = explode('@', $file[0], 2);
			$file[0][0] = explode(':', $file[0][0], 2);
			if(!isset($file[0][0][1]))
				$file[0][0][1] = '';
			$obj = self::sqli($file[0][1], $file[0][0][0], $file[0][0][1], $file[1]);
			for($i = 2; isset($file[$i]); ++$i)
				$obj = $obj->dir($file[$i]);
			return $obj;
		}
		if(is_url($file))
			return self::url($file);
		return self::string($file);
	}

	// NS (namespaces)
	public $ns = array();
	public function getNSs(){
		if($this->ns == array())return '';
		return implode("\xff",$this->ns)."\xff";
	}
	public function encodeNS($key){
		switch(gettype($key)){
			case "NULL":
				$type = 1;
				$key = '';
			break;
			case "boolean":
				if($key)
					$type = 2;
				else
					$type = 3;
				$key = '';
			break;
			case "integer":
			case "double":
			case "float":
				$type = 4;
				if($key == floor($key)){
					$pkey = math::decstr($key);
					if(!is_numeric($pkey))
						$key = $pkey;
					else
						$key = (string)$key;
				}else
					$key = (string)$key;
			break;
			case "string":
				$type = 5;
			break;
			case "array":
				$type = 6;
				$key = $this->zlib ? self::serialize($key) : substr(serialize($key),2,-1);
			break;
			case "object":
				if(is_closure($key)){
					$type = 8;
					$key = unce($key);
				}else{
					$type = 7;
					$key = $this->zlib ? self::serialize($key) : substr(serialize($key),2,-1);
				}
			break;
			default:
				new APError("APED", "unsupported Type", APError::TYPE, APError::TTHROW);
		}
		if($this->zlib){
			$z = crypt::gzdeflate($key,9,31);
			if(strlen($z) < strlen($key)){
				$type += 20;
				$key = $z;
			}
		}
		$key = chr($type).$this->getNSs().$key;
		$l = strlen($key);
		$s = self::sizeencode($l);
		$l = strlen($s);
		return chr($l).$s.$key;
	}
	public function decodeNS($key){
		$type = ord($key[0]);
		$key = substr_replace($key,'',0,1);
		$ns = $this->getNSs();
		if($ns){
			if(strpos($key,$ns) !== 0)
				return false;
			$key = substr($key,strlen($ns));
		}
		$p = strpos(str_replace("\\\xff",'',$key),"\xff");
		if($p != -1 && $p != false)
				return false;
		$key = str_replace("\\\xff","\xff",$key);
		if($type > 20){
			$type -= 20;
			$key = crypt::gzinflate($key);
			$z = true;
		}else $z = false;
		switch($type){
			case 1:
				$key = null;
			break;
			case 2:
				$key = true;
			break;
			case 3:
				$key = false;
			break;
			case 4:
				if(!is_numeric($key))
					$key = math::strdec($key);
				$key = $key + 0;
			break;
			case 5:
			break;
			case 6:
				$key = $z == true ? self::unserialize($key) : unserialize("a:$key}");
			break;
			case 7:
				$key = $z == true ? self::unserialize($key) : unserialize("O:$key}");
			break;
			case 8:
				$key = eval("return $key;");
			break;
			default:
				new APError("APED", "unsupported Type", APError::TYPE, APError::TTHROW);
		}
		return $key;
	}
	public function decodeNSz($data){
		return $this->decodeNS(substr($data,ord($data[0])+1));
	}
	
	public function getNS(){
		return array_map("self::decodeon",$this->ns);
	}
	public function isNS($ns = false){
		if($ns)return $this->getNS() == $ns;
		return $this->ns != array();
	}
	public function isInNS($ns = false){
		if($ns)return in_array($ns, $this->getNS());
		return $this->ns != array();
	}
	public function isLastNS($ns){
		if($this->ns == array())return false;
		return self::decodeon(end($this->ns)) == $ns;
	}
	public function openNS($ns){
		$this->ns[] = self::encodevw($ns);
		return $this;
	}
	public function backNS(){
		unset($this->ns[count($this->ns) - 1]);
		return $this;
	}
	public function mainNS(){
		$this->ns = array();
		return $this;
	}
	public function allNSs(){
		$ns = array();
		$this->readkeys(function($x)use(&$ns){
			$key = explode($key, "\xff", substr_count(substr($key, 0, strpos($key, "\\\xff")), "\xff") + 1);
			for($c = 0;isset($key[$c + 1]);)
				$ns[] = self::decodeon(str_replace("\\\xff", "\xff", $key[$c++]));
		});
		return array_unique($ns);
	}
	
	// size info
	public function get(){
		return $this->obj->get();
	}
	public function get_hash($algo = 'md5'){
		return crypt::hash($algo, $this->obj->get());
	}
	public function get_hmac($algo = 'md5', $pass = ''){
		return crypt::hash_hmac($algo, $this->obj->get(), $pass);
	}
	public function __toString(){
		return $this->obj->get();
	}
	public function size(){
		return $this->obj->size();
	}
	public function countall(){
		return $this->obj->count();
	}
	public function count(){
		$c = 0;
		$this->readkeys(function()use(&$c){
			++$c;
		});
		return $c;
	}

	// savers
	public $save = false, $aped = false;
	public function save(){
		if($this->type != 'url' && $this->type != 'sqli' && $this->obj->isChild())
			return $this->obj->save();
	}
	public function saveTo($file){
		return $this->obj->saveto($file);
	}
	public function __destruct(){
		if($this->type == 'close')
			return;
		if($this->type != 'url')
			$this->setLastModified();
		if(!$this->save && $this->type != 'url' && $this->type != 'sqli')
			$this->save();
	}
	public function close(){
		if($this->type != 'url')
			$this->setLastModified();
		if(!$this->save && $this->type != 'url' && $this->type != 'sqli')
			$this->save();
		if($this->type == 'file')
			fclose($this->obj->stream());
		$this->obj = null;
		$this->type = 'close';
		if(self::$objOw && self::$objOw->type == 'close'){
			self::$objOw = false;
		if(self::$objWe && self::$objWe->type == 'close')self::$objWe = false;
		if(self::$objMe && self::$objMe->type == 'close')self::$objMe = false;
		}
	}
	public function isChild(){
		return $this->obj->isChild();
	}
	public function owner(){
		$owner = $this->obj->owner();
		return $owner === false ? false : self::give($owner);
	}
	public function unlink(){
		switch($this->type){
			case 'file':unlink($this->obj->locate());$this->close();break;
			case 'sqli':mysqli_query($this->obj->stream(), "DROP DATABASE {$this->obj->database}");$this->close();break;
			default:$this->close();break;
		}
	}

	// get location
	public function locate(){
		if($this->type === 'string')
			new APError("APEDString", "String data not have locate", APError::WARNING, APError::TTHROW);
		return $this->obj->locate();
	}
	public function stream(){
		if($this->type === 'string')
			new APError("APEDString", "String data not have locate", APError::WARNING, APError::TTHROW);
		return $this->obj->stream();
	}
	
	// copy
	public function copy(){
		if($this->type === 'string')
			return aped::string($this->obj->get());
		elseif($this->type === 'url')
			return aped::url($this->obj->locate());
		else
			return aped::file($this->obj->stream());
	}

	// headers
	public function setName($name){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->set("\x01\x02\x09n",self::encodeon($name));
		return $this;
	}
	public function getName(){
		$name = $this->obj->value("\x01\x02\x09n");
		if(!$name)return;
		return self::decodenz($name);
	}
	public function setDescription($desc){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->set("\x01\x02\x09d",self::encodeon($desc));
		return $this;
	}
	public function getDescription(){
		$desc = $this->obj->value("\x01\x02\x09d");
		if(!$desc)return;
		return self::decodenz($desc);
	}
	private function setLastModified(){
		if($this->type === 'url')
			return false;
		$this->obj->set("\x01\x02\x09m",self::encodeon(floor(microtime(true) * 1000000)));
		return true;
	}
	public function getLastModified(){
		$modifi = $this->obj->value("\x01\x02\x09m");
		if(!$modifi)return false;
		return self::decodenz($modifi) / 1000000;
	}
	private function setCreatedTime(){
		if($this->type === 'url')
			return false;
		$this->obj->set("\x01\x02\x09c",self::encodeon(floor(microtime(true) * 1000000)));
		$this->obj->set("\x01\x02\x09m",self::encodeon(0));
		return true;
	}
	public function getCreatedTime(){
		$modifi = $this->obj->value("\x01\x02\x09c");
		if(!$modifi)return false;
		return self::decodenz($modifi) / 1000000;
	}
	public function loadCreatedTime(){
		if($this->type == 'file' && !$this->obj->getByte())
			$this->setCreatedTime();
		elseif($this->type == 'sqli' && !$this->obj->value("\x01\x02\x09c"))
			$this->setCreatedTime();
	}
	public function dateCreatedTime($format){
		$modifi = $this->obj->value("\x01\x02\x09c");
		if(!$modifi)return;
		return date($format, self::decodenz($modifi) / 1000000);
	}
	public function dateLastModified($format){
		$modifi = $this->obj->value("\x01\x02\x09m");
		if(!$modifi)return;
		return date($format, self::decodenz($modifi) / 1000000);
	}
	public function hasName(){
		return $this->obj->iskey("\x01\x02\x09n");
	}
	public function hasDescription(){
		return $this->obj->iskey("\x01\x02\x09d");
	}

	// convertor
	public function convert($to = 'string', $file = ''){
		if($to == 'sqli'){
			$sql = new APED;
			$sql->obj = new APEDSQLi($file);
			$this->readkey(function($key)use($sql, $file){
				if($this->isdir($key))
					$this->dir($key)->convert('sqli', $file . '/a' . crypt::hexencode(self::encodeon($key)));
				else $sql->set($key, $this->value($key));
			});
			$this->type = 'sqli';
			$this->obj = $sql;
			if($sql->maked)
				$this->setCreatedTime();
			return true;
		}
		switch($this->type){
			case "string":
				switch($to){
					case "string":break;
					case "file":
						if(is_string($file)){
							if(!file_exists($file))
								return false;
							else $file = fopen($file,"r+b");
						}elseif(!is_resource($file) || !stream::mode($file))
							return false;
						if(stream::mode($file) != 'r+b')
							$file = stream::fclone($file,'r+b');
						fwrite($file,$this->obj->get());
						$this->type = "file";
						$this->obj = new APEDFile($file);
					break;
					case "tmp":
						$file = tmpfile();
						fwrite($file,$this->obj->get());
						$this->type = "file";
						$this->obj = new APEDFile($file);
					break;
					default:
						return false;
				}
			break;
			case "file":
				switch($to){
					case "string":
						$this->type = "string";
						$this->obj = new APEDString($this->obj->get());
					break;
					case "file":
						if(is_string($file)){
							if(!file_exists($file))
								return false;
							else $file = fopen($file,"r+b");
						}elseif(!is_resource($file) || !stream::mode($file))
							return false;
						if(stream::mode($file) != 'r+b')
							$file = stream::fclone($file,'r+b');
						stream_copy_to_stream($this->obj->stream(),$file);
						$this->type = 'file';
						$this->obj = new APEDFile($file);
					break;
					case "tmp":
						$file = tmpfile();
						stream_copy_to_stream($this->obj->stream(),$file);
						$this->type = 'file';
						$this->obj = new APEDFile($file);
					break;
					default:
						return false;
				}
			break;
			case "url":
				switch($to){
					case "string":
						$this->type = "string";
						$this->obj = new APEDString($this->obj->get());
					break;
					case "file":
						if(is_string($file)){
							if(!file_exists($file))
								return false;
							else $file = fopen($file,"r+b");
						}elseif(!is_resource($file) || !stream::mode($file))
							return false;
						if(stream::mode($file) != 'r+b')
							$file = stream::fclone($file,'r+b');
						stream_copy_to_stream($this->obj->stream(),$file);
						$this->type = 'file';
						$this->obj = new APEDFile($file);
					break;
					case "tmp":
						$file = tmpfile();
						stream_copy_to_stream($this->obj->stream(),$file);
						$this->type = 'file';
						$this->obj = new APEDFile($file);
					break;
					default:
						return false;
				}
			break;
			case 'sqli':
				return false;
			break;
			default:
				return false;
		}
		if($this->save)
			$this->save();
		return true;
	}

	// keys
	public function iskey($key){
		return $this->obj->iskey($this->encodeNS($key));
	}
	public function key($value){
		$key = $this->obj->key(self::encodeon($value));
		return $this->decodeNS($key);
	}
	public function keys($value){
		$keys = $this->obj->keys(self::encodeon($value));
		$kys = array();
		$ns = $this->getNSs();
		foreach($keys as $key){
			if(!$ns || strpos($key, $ns) === 0)
				$kys[] = $this->decodeNS($key);
		}
		return $kys;
	}
	public function keyNS($value){
		$key = $this->obj->key(self::encodeon($value));
		$key = explode($key, "\xff", substr_count(substr($key, 0, strpos($key, "\\\xff")), "\xff") + 1);
		foreach($key as &$k)
			$k = self::decodeon(str_replace("\\\xff", "\xff", $k));
		return $key;
	}
	public function keysNS($value){
		$keys = $this->obj->keys(self::encodeon($value));
		foreach($keys as &$key){
			$key = explode($key, "\xff", substr_count(substr($key, 0, strpos($key, "\\\xff")), "\xff") + 1);
			foreach($key as &$k)
				$k = self::decodeon(str_replace("\\\xff", "\xff", $k));
		}
		return $keys;
	}

	// values
	public function isvalue($value){
		return $this->obj->isvalue(self::encodeon($value));
	}
	public function value($key, $length = null){
		$keyNS = $this->encodeNS($key);
		$value = $this->obj->value($keyNS, $length === null ? null : strlen($keyNS) - strlen($key) + $length + 2);
		return $length === null ? self::decodenz($value) : substr(self::decodenz($value), 0, $length);
	}
	public function subvalue($key, $offset = 0, $length = null){
		$keyNS = $this->encodeNS($key);
		$value = $this->obj->value($keyNS, $length === null ? null : strlen($keyNS) - strlen($key) + $length + 2);
		return $length === null ? substr(self::decodenz($value), $offset) : substr(self::decodenz($value), $offset, $length);
	}
	public function valen($key){
		$keyNS = $this->encodeNS($key);
		$value = $this->obj->valen($keyNS);
		return $value === false ? false : $value - strlen(self::sizeencode($value)) - 2;
	}

	// dirs
	public function isdir($dir){
		return $this->obj->isdir($this->encodeNS($dir));
	}
	public function havedir($dir){
		return $this->decodeNS($this->obj->havedir());
	}
	public function dir($dir){
		$dir = $this->obj->dir($this->encodeNS($dir));
		if(!$dir)return false;
		return self::give($dir);
	}
	public function make($dir,$ret = null){
		if($this->type == 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$dir = $this->encodeNS($dir);
		if($this->type == 'sqli')
			if($ret)
				return self::give($this->obj->make($dir, true));
			else
				return $this->obj->make($dir);
		$this->obj->set($dir,"\x01\x01\x09");
		if($this->save)
			$this->save();
		if($ret){
			if($this->type == "string")
				$obj = new APEDString();
			else
				$obj = new APEDFile(tmpfile());
			$obj->setme(array($this->obj,$dir));
			return self::give($obj);
		}
		return $this;
	}
	public function mdir($dir){
		$name = $this->encodeNS($dir);
		if($this->type == 'sqli')
			return self::give($this->obj->mdir($name));
		$dir = $this->obj->dir($name);
		if(!$dir){
			if($this->type === 'url')
				new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
			$this->obj->add($name,"\x01\x01\x09");
			if($this->save)
				$this->save();
			if($this->type == "string")
				$obj = new APEDString();
			else
				$obj = new APEDFile(tmpfile());
			$obj->setme(array($this->obj,$name));
			return self::give($obj);
		}
		return self::give($dir);
	}

	// setters
	public function set($key,$value){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->set($this->encodeNS($key),self::encodeon($value));
		if($this->save)
			$this->save();
		return $this;
	}
	public function rename($from,$to){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->rename($this->encodeNS($from),self::encodeNS($to));
		if($this->save)
			$this->save();
		return $this;
	}
	public function reset(){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->reset();
		if($this->save)
			$this->save();
		return $this;
	}
	public function delete($key){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->delete($this->encodeNS($key));
		if($this->save)
			$this->save();
		return $this;
	}

	// Math
	public function join($key,$value){
		$this->set($key,$x = $this->value($key) . $value);
		return $x;
	}
	public function sjoin($key,$value){
		$this->set($key,$x = $value . $this->value($key));
		return $x;
	}
	public function madd($key,$count = 1){
		$this->set($key,$x = $this->value($key) + $count);
		return $x;
	}
	public function msub($key,$count = 1){
		$this->set($key,$x = $this->value($key) - $count);
		return $x;
	}
	public function mdiv($key,$count = 1){
		$this->set($key,$x = $this->value($key) / $count);
		return $x;
	}
	public function mmul($key,$count = 1){
		$this->set($key,$x = $this->value($key) * $count);
		return $x;
	}
	public function mmod($key,$count = 1){
		$this->set($key,$x = $this->value($key) % $count);
		return $x;
	}
	public function mpow($key,$count = 2){
		$this->set($key,$x = pow($this->value($key), $count));
		return $x;
	}
	public function msqrt($key,$count = 2){
		$this->set($key,$x = pow($this->value($key), 1 / $count));
		return $x;
	}
	public function mxor($key,$count = 1){
		$this->set($key,$x = $this->value($key) ^ $count);
		return $x;
	}
	public function mand($key,$count = 1){
		$this->set($key,$x = $this->value($key) & $count);
		return $x;
	}
	public function mor($key,$count = 1){
		$this->set($key,$x = $this->value($key) | $count);
		return $x;
	}
	public function mshl($key,$count = 1){
		$this->set($key,$x = $this->value($key) % $count);
		return $x;
	}
	public function mshr($key,$count = 1){
		$this->set($key,$x = $this->value($key) % $count);
		return $x;
	}
	
	// Hashing
	public function hash_set($key, $value, $algo = 'md5'){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$hash = crypt::hash($algo, $value, true);
		return $hash ? $this->set($key, $hash) : false;
	}
	public function hmac_set($key, $value, $algo = 'md5', $pass = ''){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$hash = crypt::hash_hmac($algo, $value, $pass, true);
		return $hash ? $this->set($key, $hash) : false;
	}
	public function hash_equal($key, $value, $algo = 'md5'){
		$hash = crypt::hash($algo, $value, true);
		return $hash ? $this->value($key) === $hash : false;
	}
	public function hmac_equal($key, $value, $algo = 'md5', $pass = ''){
		$hash = crypt::hash_hmac($algo, $value, $pass, true);
		return $hash ? $this->value($key) === $hash : false;
	}

	// type
	public function type($x){
		return $this->iskey($x)?"key":($this->isvalue($x)?"value":false);
	}
	public function keytype($x){
		$g = $this->value($x);
		if(!$g)return false;
		$g = substr_replace($g,'',0,ord($g[0])+1);
		if($g == "\x0a")return "list";
		if($g[0] == "\x09")return "dir";
		return "value";
	}
	
	// readers
	public function setlist($data){
		foreach($data as $key=>$value)
			$this->set($key,$value);
		return $this;
	}
	public function allkeys(){
		$keys = array();
		$this->obj->allkey(function($key)use(&$keys){
			if($key[0] == "\x09")return;
			$key = $this->decodeNS($key);
			if($key)$keys[] = $key;
		});
		return $keys;
	}
	public function all(){
		$all = array();
		$this->obj->all(function($key,$value)use(&$all){
			if($key[0] == "\x09")return;
			$key = $this->decodeNS($key);
			if(!$key)return;
			$value = substr($value,ord($value[0])+1);
			if($value[0] == "\x09")
				 $all[] = array($key,self::give(new APEDString(substr_replace($value,'',0,1))));
			elseif($value[0] && $value[0] == "\x0a")
				$all[] = array($key);
			else $all[] = array($key,self::decodeon($value));
		});
		return $all;
	}
	public function readkeys($func){
		$this->obj->allkey(function($k)use($func){
			if($k[0] == "\x09")return;
			$k = $this->decodeNS($k);
			if($k)$func($k);
		});
		return $this;
	}
	public function read($func){
		$this->obj->all(function($k,$v)use($func){
			if($k[0] == "\x09")return;
			$v = substr($v, ord($v[0]) + 1);
			$k = $this->decodeNS($k);
			if($v[0] == "\x09")$func($k,self::give(new APEDString(substr($v,1))));
			elseif($k)$func($k,self::decodeon($v));
		});
		return $this;
	}
	public function map($func){
		$this->obj->map(function($k,$v)use($func){
			if($k[0] == "\x09")return $v;
			$k = $this->decodeNS($k);
			if($k)return self::encodeon($func($k,self::decodenz($v)));
			return $v;
		});
		return $this;
	}
	
	// dump
	private function _dump($k){
		$c = 0;
		$this->obj->all(function($key,$value)use(&$c,$k){
			if($key[0] == "\x09"){
				switch($key[1]){
					case 'n':print "$k# name : ".unce(self::decodenz($value))."\n";return;
					case 'd':print "$k# description : ".unce(self::decodenz($value))."\n";return;
					case 'm':print "$k# modified time : ".date(DATE_RFC822, (int)(self::decodenz($value) / 1000000))."\n";return;
					case 'c':print "$k# created time : ".date(DATE_RFC822, (int)(self::decodenz($value) / 1000000))."\n";return;
					case 'g':print "$k# GLOBALS object : ".unce(self::decodenz($value), true)."\n";return;
				}
				return;
			}
			$key = $this->decodeNS($key);
			++$c;
			if($this->type == 'sqli' && $value == "\x01\x01\x09"){
				print "$k#$c dir ".unce($key)."\n";
				self::give(new APEDSQLi(array($this->obj, 'a' . crypt::hexencode($this->encodeNS($key)))))->_dump("$k| ");
			}elseif($value[ord($value[0])+1] == "\x09"){
				print "$k#$c dir ".unce($key)."\n";
				self::give(new APEDString(substr_replace($value,'',0,ord($value[0])+2)))->_dump("$k| ");
			}elseif(isset($value[2]) && $value[2] == "\x0a")
				print "$k#$c list ".unce($key)."\n";
			else print "$k#$c ".unce($key)." : ".unce(self::decodenz($value))."\n";
		});
	}
	public function dump(){
		$this->_dump('');
	}

	// lists
	public function add($key){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->set($this->encodeNS($key),"\x01\x01\x0a");
		if($this->save)
			$this->save();
		return $this;
	}
	public function islist($key){
		return $this->obj->value($this->encodeNS($key)) == "\x01\x01\x0a";
	}
	public function at($x){
		$at = $this->obj->numberat($x);
		if($at[0][0] == "\x09")
			switch($at[0][1]){
				case 'n':return array('name',self::decodenz($at[1]),true);
				case 'd':return array('description',self::decodenz($at[1]),true);
				case 'm':return array('last_modified_time',self::decodenz($at[1]) / 1000000,true);
				case 'c':return array('created_time',self::decodenz($at[1]) / 1000000,true);
				case 'g':return array('global_object',self::decodenz($at[1]),true);
			}
		$at[0] = $this->decodeNS($at[0]);
		if(!$at[0])return false;
		if($at[1][$p = ord($at[1][0])+1] == "\x09")
			return array($at[0],self::give(new APEDString(substr_replace($at[1],'',0,$p+1))));
		elseif($at[1][$p] == "\x0a")
			return array($at[0]);
		return array($at[0],self::decodenz($at[1]));
	}
	public function keyat($x){
		$at = $this->obj->keyat($x);
		if($at[0] == "\x09")
			return false;
		if(!$at)return false;
		$at = $this->decodeNS($at);
		if(!$at)return false;
		return $at;
	}
	public function of($key){
		return $this->obj->numberof($this->encodeNS($key));
	}
	public function alllist(){
		$keys = $this->obj->keys("\x01\x01\x0a");
		$kys = array();
		$ns = $this->getNSs();
		foreach($keys as $key){
			if(!$ns || strpos($key, $ns) === 0)
				$kys[] = $this->decodeNS($key);
		}
		return $kys;
	}

	// aped json
	public function json(){
		$json = new APEDJson($this);
		$this->read(function($key,$value)use(&$json){
			if($value instanceof APED)
				$json->$key = $value->json();
			else $json->$key = $value;
		});
		return $json;
	}

	// random element
	public function random(){
		$count = $this->count();
		if($count < 4){
			if($count < 1)return false;
			if($count == 1){
				$at = $this->at(1);
				if(isset($at[2]) && $at[2])
					return false;
				return $at;
			}
			if($count == 2){
				$at1 = $this->at(1);
				$at2 = $this->at(2);
				$at = array($at1,$at2);
				if(isset($at1[2]) && $at1[2])unset($at[0]);
				if(isset($at2[2]) && $at2[2])unset($at[1]);
				if($at == array())
					return false;
				return $at[array_rand($at)];
			}
			$at1 = $this->at(1);
			$at2 = $this->at(2);
			$at3 = $this->at(3);
			$at = array($at1,$at2,$at3);
			if(isset($at1[2]) && $at1[2])unset($at[0]);
			if(isset($at2[2]) && $at2[2])unset($at[1]);
			if(isset($at3[2]) && $at3[2])unset($at[2]);
			if($at == array())
				return false;
			return $at[array_rand($at)];
		}
		if($count < 10){
			$arr = $this->all();
			return $arr[array_rand($arr)];
		}
		$random = $this->at(rand(1,$count));
		while(isset($random[2]) && $random[2])
			$random = $this->at(rand(1,$count));
		return $random;
	}

	// search
	const STARTED_BY = 0;
	const HAVE_IN = 1;
	const HAVE_OUT = 2;
	const HAVE_IN_OUT = 3;
	const MATCH_CHARS = 4;
	const MATCH_REGEX = 5;
	public function search($by,$type = 0){
		$keys = array();
		$values = array();
		switch($type){
			case self::SEARCH_BY:
				$this->all(function($key,$value)use(&$keys,&$values,$by){
					if(strpos($key,$by) === 0)$keys[] = $key;
					if(strpos($value,$by) === 0)$values[] = $value;
				});
			break;
			case self::HAVE_IN:
				$this->all(function($key,$value)use(&$keys,&$values,$by){
					if(strpos($key,$by) != -1)$keys[] = $key;
					if(strpos($value,$by) != -1)$values[] = $value;
				});
			break;
			case self::HAVE_OUT:
				$this->all(function($key,$value)use(&$keys,&$values,$by){
					if(strpos($by,$key) != -1)$keys[] = $key;
					if(strpos($by,$value) != -1)$values[] = $value;
				});
			break;
			case self::HAVE_IN_OUT:
				$this->all(function($key,$value)use(&$keys,&$values,$by){
					if(strpos($key,$by) != -1 || strpos($by,$key) != -1)$keys[] = $key;
					if(strpos($value,$by) != -1 || strpos($by,$value) != -1)$values[] = $values;
				});
			break;
			case self::MATCH_CHARS:
				$this->all(function($key,$value)use(&$keys,&$values,$by){
					if(preg_match("/".implode(' *',array_map(function($x){
						return preg_quote($x,'/');
					},str_split($key)))."/",$key))$keys[] = $key;
					if(preg_match("/".implode(' *',array_map(function($x){
						return preg_quote($x,'/');
					},str_split($value)))."/",$value))$values[] = $value;
				});
			break;
			case self::MATCH_REGEX:
				$this->all(function($key,$value)use(&$keys,&$values,$by){
					if(preg_match($by,$key))$keys[] = $key;
					if(preg_match($by,$value))$values[] = $value;
				});
			break;
			default:
				new APError("APED", "invalid search type", APError::NOTIC);
				return false;
		}
		return array($keys,$values);
	}
	
	// position
	public $position = 1;
	public function currect(){
		return $this->at($this->position);
	}
	public function eof(){
		return $this->count() <= $position || $position;
	}
	public function next($count = null){
		if($count === null)$count = 1;
		$this->position+= $count;
		return $this;
	}
	public function prev($count = null){
		if($count === null)$count = 1;
		$this->position-= $count;
		return $this;
	}
	public function go($index){
		$this->position = $index;
		return $this;
	}
	public function pos(){
		return $this->position;
	}
	public function start(){
		$this->position = 1;
		return $this;
	}
	public function end(){
		$this->position = $this->count();
		return $this;
	}
	public function seek($offset, $whence = 0){
		switch($whence){
			case SEEK_SET:
				$this->position = $offset;
			break;
			case SEEK_CUR:
				$this->position += $offset;
			break;
			case SEEK_END:
				$this->position = $this->count() + $offset;
		}
	}

	// pop/push/shift/unshift
	public function push($key, $value){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->set($this->encodeNS($key),self::encodeon($value));
		if($this->save)
			$this->save();
		return $this;
	}
	public function pop($onlyremove = false){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$result = $this->obj->pop($onlyremove);
		if($result === false || $result === true)
			return $result;
		return array($this->decodeNS($result[0]), self::decodenz($result[1]));
	}
	public function shift($onlyremove = false){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$result = $this->obj->shift($onlyremove);
		if($result === false || $result === true)
			return $result;
		return array($this->decodeNS($result[0]), self::decodenz($result[1]));
	}
	public function unshift($key, $value){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->unshift($this->encodeNS($key),self::encodeon($value));
		if($this->save)
			$this->save();
		return $this;
	}
	public function rightadd($value){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$this->obj->unshift($this->encodeNS($key),"\x01\x01\x0a");
		if($this->save)
			$this->save();
		return $this;
	}

	// has
	public function has($key, $value){
		return $this->obj->has($this->encodeNS($key),self::encodeon($value));
	}

	// password
	public function password_encode($password,$limit = 5242880){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$password = self::encodeon($password);
		return $this->obj->password_encode($password,$limit);
	}
	public function password_decode($password){
		if($this->type === 'url')
			new APError("APEDURL", "Can not change URL address contents", APError::WARNING, APError::TTHROW);
		$password = self::encodeon($password);
		return $this->obj->password_decode($password);
	}

	// globaling/unglobaling
	public function globaling(){
		$glb = $this->obj->value("\x01\x02\x09g");
		if(!$glb)return false;
		$array = (array)(object)$GLOBALS;
		unset($array['GLOBALS']);
		$me = arr::search($this, $array, true);
		$last = array_pop($me);
		$GLOBALS = self::decodenz($glb);
		$why = &$array;
		foreach($me as $key => $value)
			if(!isset($why[$key]) || !is_array($why[$key])){
				$why[$key] = array();
				$why = &$why[$key];
			}
		$why[$last] = $this;
		return true;
	}
	public function unglobaling(){
		if($this->type === 'url')
			return false;
		$array = (array)(object)$GLOBALS;
		unset($array['GLOBALS']);
		$me = arr::search($this, $array, true);
		$last = array_pop($me);
		$why = &$array;
		foreach($me as $key => $value)
			$why = &$why[$key];
		unset($why[$last]);
		$this->obj->set("\x01\x02\x09g", self::encodeon($array));
		return true;
	}
	public function globalextract(){
		$this->obj->all(function($k,$v)use($func){
			if($k[0] == "\x09")return;
			$k = $this->decodeNS($k);
			if($k)$GLOBALS[$k] = self::decodenz($v);
		});
	}

	// compact/extract
	public function compact($directory, $onlyfiles = null){
		$files = @dirscan($directory);
		if($files === false)return false;
		if($onlyfiles === true){
			foreach($files as $file)
				if(is_file($directory .DIRECTORY_SEPARATOR. $file))
					$this->set($file, file_get_contents($directory .DIRECTORY_SEPARATOR. $file));
		}else foreach($files as $file)
			if(is_dir($directory .DIRECTORY_SEPARATOR. $file))
				$this->mdir($file)->compact($directory .DIRECTORY_SEPARATOR. $file);
			else
				$this->set($file, file_get_contents($directory .DIRECTORY_SEPARATOR. $file));
	}
	public function extract($directory){
		if(!file_exists($directory))mkdir($directory);
		$this->read(function($file, $content)use($directory){
			if(is_aped($content)){
				mkdir($directory .DIRECTORY_SEPARATOR. $file);
				$content->extract($directory .DIRECTORY_SEPARATOR. $file);
			}else file_put_contents($directory .DIRECTORY_SEPARATOR. $file, $content);
		});
	}

	// json coding
	const JSON_ERROR_KEY_OBJECT = 11;
	public function jsoncode($file = null, $options = 0, $depth = 512){
		__apeip_data::$jsonerror = JSON_ERROR_NONE;
		if($depth <= 0){
			__apeip_data::$jsonerror = JSON_ERROR_DEPTH;
			if(~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)return null;
		}
		if(!$file){
			$string = '';
			$this->read(function($key, $value)use(&$string, $options, $depth){
				if((__apeip_data::$jsonerror == self::JSON_ERROR_KEY_OBJECT && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)) || is_array($key) || is_object($key)){
					__apeip_data::$jsonerror = self::JSON_ERROR_KEY_OBJECT;
					return null;
				}
				if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
					return null;
				$key = self::jsonencode($key, $options, $depth - 1);
				if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
					return null;
				if($value instanceof APED){
					$value = $value->jsonencode(null, $options, $depth - 1);
					if($value === null)
						return null;
					$string .= $key . ($options & JSON_PRETTY_PRINT ? ': ' . str_replace("\n","\n" . str::PRETTY_CHAR,$value) . ",\n" . str::PRETTY_CHAR : ':' . $value . ',');
				}else{
					$value = self::jsonencode($value, $options, $depth - 1);
					if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
						return null;
					$string .= $key . ($options & JSON_PRETTY_PRINT ? ': ' . str_replace("\n","\n" . str::PRETTY_CHAR,$value) . ",\n" . str::PRETTY_CHAR : ':' . $value . ',');
				}
			});
			if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
				return null;
			if(__apeip_data::$jsonerror == self::JSON_ERROR_KEY_OBJECT && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
				return null;
			if($options & JSON_PRETTY_PRINT)
				return $string == '' ? "{\n}" : "{\n" . str::PRETTY_CHAR . substr_replace($string, "\n}", -6, 6);
			return $string == '' ? '{}' : '{' . substr_replace($string, '}', -1, 1);
		}else{
			if(is_array($file))
				list($file, $number) = $file;
			else{
				$number = 1;
				$f = fopen($file, 'w');
				if(!$f)
					return false;
				fclose($f);
				$file = fopen($file, 'a');
			}
			if($options & JSON_PRETTY_PRINT)
				fwrite($file, ($number == 1 ? '{' : "{\n" . str_repeat(str::PRETTY_CHAR, $number)));
			else
				fwrite($file, '{');
			$started = true;
			$this->readkeys(function($key)use(&$started, $file, $options, $depth, $number){
				if((__apeip_data::$jsonerror == self::JSON_ERROR_KEY_OBJECT && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR)) || is_array($key) || is_object($key)){
					__apeip_data::$jsonerror = self::JSON_ERROR_KEY_OBJECT;
					return null;
				}
				if($started)
					$started = false;
				else fwrite($file, $options & JSON_PRETTY_PRINT ? ",\n" . str_repeat(str::PRETTY_CHAR, $number) : ',');
				$dir = $this->dir($key);
				$kyj = self::jsonencode($key, $options, $depth - 1);
				if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
					return null;
				fwrite($file, $kyj . ($options & JSON_PRETTY_PRINT ? ': ' : ':'));
				if(!$dir){
					$value = $this->value($key);
					$value = self::jsonencode($value, $options, $depth - 1);
					if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
						return null;
					fwrite($file, $options & JSON_PRETTY_PRINT ? str_replace("\n","\n" . str_repeat(str::PRETTY_CHAR, $number),$value) : $value);
				}else{
					$dir->jsonencode(array($file, $number + 1), $options, $depth - 1);
					if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
						return null;
				}
			});
			if(self::json_last_error() != JSON_ERROR_NONE && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
				return null;
			if(__apeip_data::$jsonerror == self::JSON_ERROR_KEY_OBJECT && (~$options & JSON_PARTIAL_OUTPUT_ON_ERROR))
				return null;
			if($options & JSON_PRETTY_PRINT)
				fwrite($file, "\n" . ($number == 1 ? '}' : str_repeat(str::PRETTY_CHAR, $number - 1) . '}'));
			else
				fwrite($file, '}');
			if($number == 1)fclose($file);
			return true;
		}
	}
}

class APEDJson {
	private $obj;
	public function __construct(APED $obj){
		$this->obj = $obj;
	}
	private function _save($x){
		foreach($x as $k=>$v){
			if(is_object($v) && ($v instanceof stdClass || $v instanceof APEDJson)){
				if(!$this->obj->isdir($k))
					$this->obj->make($k);
				$tmp = new APEDJson($this->obj->dir($k));
				$tmp->_save((array)$v);
			}else
			$this->obj->set($k,$v);
		}
	}
	public function aped(){
		return $this->obj;
	}
	public function save(){
		$arr = (array)$this;
		unset($arr["\x00APEDJson\x00xnd"]);
		$this->_save($arr);
	}
}

class APEDString {
	private $data = '',$parent = false;
	public function __construct($data = null){
		$this->data = $data !== null ? $data : '';
	}
	public function isChild(){
		return $this->parent !== false;
	}
	public function owner(){
		if($this->parent === false)
			return false;
		return $this->parent[0];
	}
	public function setme($parent){
		$this->parent = $parent;
	}
	public function save(){
		if(@$this->data[0] == "\xff")return false;
		if($this->parent){
			$data = "\x09".$this->data;
			$s = strlen($data);
			$s = aped::sizeencode($s);
			$l = strlen($s);
			$data = chr($l).$s.$data;
			$this->parent[0]->set($this->parent[1],$data);
			$this->parent[0]->save();
		}
	}
	public function saveto($file){
		return fput($file, $this->data);
	}
	public function reset(){
		$this->data = '';
	}
	public function get(){
		return $this->data;
	}
	public function getByte(){
		return $this->data ? $this->data[0] : null;
	}
	public function size(){
		return strlen($this->data);
	}
	public function iskey($key){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$key = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key)
				return true;
			$c+= $s;
		}
		return false;
	}
	public function numberof($key){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		$o = 1;
		for($c = 0;isset($data[$c]);++$o){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key)
				return $o;
			$c+= $s;
		}
		return false;
	}
	public function value($key, $length = null){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$c+= $h;
				$s-= $h;
				if($length !== null && $s > $length)
					$s = $length;
				return substr($data,$c,$s);
			}
			$c+= $s;
		}
		return false;
	}
	public function valen($key){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$c+= $h;
				$s-= $h;
				return $s;
			}
			$c+= $s;
		}
		return false;
	}
	public function key($value){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			$h = substr($data,$c,$l);
			$c+= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			$c+= $h;
			$l = ord($data[$c++]);
			$h = substr($data,$c,$l);
			$c+= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $h;
				continue;
			}
			$v = substr($data,$c,$h);
			if($v == $value)
				return $k;
			$c+= $h;
		}
		return false;
	}
	public function keys($value){
		if(@$this->data[0] == "\xff")return array();
		$data = $this->data;
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		$ks = array();
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			$h = substr($data,$c,$l);
			$c+= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			$c+= $h;
			$l = ord($data[$c++]);
			$h = substr($data,$c,$l);
			$c+= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $h;
				continue;
			}
			$v = substr($data,$c,$h);
			if($v == $value)
				$ks[] = $k;
			$c+= $h;
		}
		return $ks;
	}
	public function isvalue($value){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$value = aped::encodeon($value);
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			$h = substr($data,$c,$l);
			$c+= $l;
			$h = aped::sizedecode($h);
			$c+= $h;
			$l = ord($data[$c++]);
			$h = substr($data,$c,$l);
			$c+= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $h;
				continue;
			}
			$v = substr($data,$c,$h);
			if($v == $value)
				return true;
			$c+= $h;
		}
		return false;
	}
	private function replace($key,$value){
		$data = &$this->data;
		$u = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$t = ord($data[$c++]);
			$s = substr($data,$c,$t);
			$c+= $t;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$l = 2+$t+$l;
				$value = aped::encodeel($u,$value);
				$data = substr_replace($data,$value,$c-$l,$s+$l);
				return true;
			}
			$c+= $s;
		}
		return false;
	}
	public function set($key,$value){
		if(@$this->data[0] == "\xff")return false;
		if(!$this->replace($key,$value))
			$this->data .= aped::encodeel($key,$value);
	}
	public function add($key,$value){
		$this->data .= aped::encodeel($key,$value);
	}
	public function delete($key){
		if(@$this->data[0] == "\xff")return false;
		$data = &$this->data;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$c+= $h;
				$s-= $h;
				$l = 2+$t+$l+$h;
				$data = substr_replace($data,'',$c-$l,$s+$l);
				return true;
			}
			$c+= $s;
		}
		return false;
	}
	public function rename($from,$to){
		$this->delete($to);
		$data = &$this->data;
		$from = substr($from,ord($from[0])+1);
		$z = strlen($from);
		$q = strlen($to)-ord($to[0])-1;
		for($c = 0;isset($data[$c]);){
			$t = ord($data[$c++]);
			$s = substr($data,$c,$t);
			$c+= $t;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $from){
				$s += $l + 1;
				$s += $q - $h;
				$s = aped::sizeencode($s);
				$value = chr(strlen($s)).$s.$to;
				$data = substr_replace($data,$value,$c-$l-$t-2,$h+$l+$t+2);
				return true;
			}
			$c+= $s;
		}
		return false;
	}
	public function isdir($key){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$c+= $h;
				return $data[$c + ord($data[$c]) + 1] == "\x09";
			}
			$c+= $s;
		}
		return false;
	}
	public function havedir(){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			$c+= $h;
			if($data[$c + ord($data[$c]) + 1] == "\x09")
				return $k;
			$c+= $s - $h;
		}
		return false;
	}
	public function dir($key){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$j = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$c+= $h;
				if($data[$c + ($u = ord($data[$c]) + 1)] != "\x09")
					return false;
				$obj = new APEDString(substr($data,$c + $u + 1,$s - $u - 1));
				$obj->setme(array($this,$j));
				return $obj;
			}
			$c+= $s;
		}
		return false;
	}
	public function count(){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		$o = 0;
		for($c = 0;isset($data[$c]);++$o){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$c+= $s;
		}
		return $o;
	}
	public function allkey($func){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			$func($k);
			$c+= $s;
		}
	}
	public function all($func){
		if(@$this->data[0] == "\xff")return false;
		$data = $this->data;
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			$v = substr($data,$c+$h,$s-$h);
			$func($k,$v);
			$c+= $s;
		}
	}
	public function map($func){
		if(@$this->data[0] == "\xff")return false;
		$data = &$this->data;
		for($c = 0;isset($data[$c]);){
			$t = ord($data[$c++]);
			$s = substr($data,$c,$t);
			$c+= $t;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$o = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($o);
			$k = substr($data,$c,$h);
			$v = substr($data,$c+$h,$s-$h);
			$value = aped::encodeel(chr($l).$o.$k, $func($k,$v));
			$data = substr_replace($data,$value,$c-$l-3,$s+$l+3);
			$c+= strlen($value) - $t - 3;
		}
	}
	public function numberat($o){
		if(@$this->data[0] == "\xff")return false;
		if($o < 1)return false;
		$data = $this->data;
		for($c = 0;isset($data[$c]);--$o){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			if($o > 1){
				$c+= $s;
				continue;
			}
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			$v = substr($data,$c+$h,$s-$h);
			return array($k,$v);
		}
	}
	public function keyat($o){
		if(@$this->data[0] == "\xff")return false;
		if($o < 1)return false;
		$data = $this->data;
		for($c = 0;isset($data[$c]);--$o){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			if($o > 1){
				$c+= $s;
				continue;
			}
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = substr($data,$c,$h);
			return $k;
		}
	}
	public function unshift($key,$value){
		if(@$this->data[0] == "\xff")return false;
		if(!$this->replace($key,$value))
			$this->data = aped::encodeel($key,$value) . $this->data;
	}
	public function pop($onlyremove = false){
		$data = &$this->data;
		for($c = 0;isset($data[$c]);){
			$t = ord($data[$c++]);
			$s = substr($data,$c,$t);
			$c+= $t;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			$c+= $s;
		}
		if($c == 0)return false;
		if($onlyremove){
			$data = substr($data, 0, $c - $s - $l - $t - 2);
			$this->data = $data;
			return true;
		}
		$c-= $s;
		$k = substr($data,$c,$h);
		$v = substr($data,$c + $h,$s - $h);
		$this->data = substr($data, 0, $c - $l - $t - 2);
		return array($k, $v);
	}
	public function shift($onlyremove = false){
		$data = &$this->data;
		for($c = 0;isset($data[$c]);){
			$t = ord($data[$c++]);
			$s = substr($data,$c,$t);
			$c+= $t;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($data[$c] != "\x09"){
				$c -= $l + $t + 2;
				break;
			}
			$c+= $s;
		}
		if(!isset($data[$c]))return false;
		$t = ord($data[$c++]);
		$s = substr($data,$c,$t);
		$c+= $t;
		$s = aped::sizedecode($s);
		if($onlyremove){
			$this->data = substr_replace($data, '', $c - $t - 1, $s + $t + 1);
			return true;
		}
		$l = ord($data[$c++]);
		--$s;
		$h = substr($data,$c,$l);
		$c+= $l;
		$s-= $l;
		$h = aped::sizedecode($h);
		$k = substr($data,$c,$h);
		$v = substr($data,$c + $h,$s - $h);
		$this->data = substr_replace($data, '', $c - $l - $t - 2, $l + $t + 2 + $s);
		return array($k, $v);
	}
	public function has($key, $value){
		$data = $this->data;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		$p = strlen($value);
		for($c = 0;isset($data[$c]);){
			$l = ord($data[$c++]);
			$s = substr($data,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$l = ord($data[$c++]);
			--$s;
			$h = substr($data,$c,$l);
			$c+= $l;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$c+= $s;
				continue;
			}
			$k = substr($data,$c,$h);
			if($k == $key){
				$c+= $h;
				$s-= $h;
				if($s !== $p)return false;
				return substr($data,$c,$s) == $value;
			}
			$c+= $s;
		}
		return false;
	}
	public function password_encode($password,$limit){
		if($this->data === '' || $limit < 0)
			return false;
		if($limit === 0)$limit = strlen($this->data);
		$iv = $password . sha1($password) . $password;
		$iv = substr(md5($iv), 0, 16);
		$content = str_split($this->data,$limit);
		foreach($content as &$content){
			$content = openssl_encrypt($content,'AES-192-CTR',$password,1,$iv);
			$s = aped::sizeencode(strlen($content));
			$l = strlen($s);
			$content = chr($l).$s.$content;
		}
		$this->data = "\xff".$content;
		return true;
	}
	public function password_decode($password){
		if($this->data === '')
			return false;
		$iv = $password . sha1($password) . $password;
		$iv = substr(md5($iv), 0, 16);
		$content = substr_replace($this->data,'',0,1);
		$c = 0;
		while(isset($content[$c])){
			$p = $c;
			$l = ord($content[$c++]);
			$s = substr($content,$c,$l);
			$c+= $l;
			$s = aped::sizedecode($s);
			$data = substr($content,$c,$s);
			$c+= $s;
			$data = openssl_decrypt($data,'AES-192-CTR',$password,1,$iv);
			if($data === false)
				return false;
			$content = substr_replace($content,$data,$p,$c - $p);
		}
		$this->data = $content;
		return true;
	}
}

class APEDFile {
	private $file,$parent = false;
	public function __construct($file = false){
		if($file===false)$file = tmpfile();
		elseif(is_string($file)){
			if(!file_exists($file))
				touch($file);
			$file = fopen($file,"r+b");
		}elseif(is_resource($file) && stream::mode($file) == "r+b");
		else new APError('APEDFile', "Invalid file", APError::WARNING, APError::TTHROW);
		if($file){
			$this->file = $file;
			rewind($file);
		}else new APError('APEDFile', "Invalid file", APError::WARNING, APError::TTHROW);
	}
	public function isChild(){
		return $this->parent !== false;
	}
	public function setme($parent){
		$this->parent = $parent;
	}
	public function owner(){
		if($this->parent === false)
			return false;
		return $this->parent[0];
	}
	public function save(){
		if($this->parent){
			$file = $this->parent[0]->stream();
			$fl = $this->file;
			$a = tmpfile();
			$key = $this->parent[1];
			$u = $key;
			$key = substr($key,ord($key[0])+1);
			$z = strlen($key);
			while(($t = fgetc($file)) !== false){
				$d = $t;
				$t = ord($t);
				$s = fread($file,$t);
				$d.= $s;
				$s = aped::sizedecode($s);
				$l = fgetc($file);
				$d.= $l;
				$l = ord($l);
				--$s;
				$h = fread($file,$l);
				$d.= $h;
				$s-= $l;
				$h = aped::sizedecode($h);
				if($h != $z){
					$d.= fread($file,$s);
					fwrite($a,$d);
					continue;
				}
				$k = fread($file,$h);
				$d.= $k;
				if($k == $key){
					fseek($file,$s-$h,SEEK_CUR);
					$s4 = $this->size();
					$s0 = $s4+1;
					$s1 = aped::sizeencode($s0);
					$s2 = strlen($s1);
					$s0 = chr($s2).$s1."\x09";
					$s1 = strlen($u)+strlen($s0)+$s4;
					$s1 = aped::sizeencode($s1);
					$s2 = strlen($s1);
					fwrite($a,chr($s2).$s1.$u.$s0);
					stream_copy_to_stream($fl,$a);
					rewind($fl);
					stream_copy_to_stream($file,$a);
					rewind($file);
					rewind($a);
					stream_copy_to_stream($a,$file);
					fclose($a);
					ftruncate($file,ftell($file));
					rewind($file);
					$this->parent[0]->save();
					return true;
				}
				$d.= fread($file,$s-$h);
				fwrite($a,$d);
			}
			fclose($a);
			rewind($file);
		}
	}
	public function saveto($file){
		$file = fopen($file, 'w');
		if(!$file)return false;
		stream_copy_to_stream($this->file, $file);
		fclose($file);
		return true;
	}
	public function locate(){
		return stream::name($this->file);
	}
	public function get(){
		$r = stream_get_contents($this->file);
		rewind($this->file);
		return $r;
	}
	public function getByte(){
		$c = fgetc($this->file);
		rewind($this->file);
		return $c;
	}
	public function reset(){
		ftruncate($this->file,0);
		rewind($this->file);
	}
	public function size(){
		$f = $this->file;
		fseek($f,0,SEEK_END);
		$s = ftell($f);
		rewind($f);
		return $s;
	}
	public function stream(){
		return $this->file;
	}
	public function iskey($key){
		$file = $this->file;
		$key = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				rewind($file);
				return true;
			}
			fseek($file,$s-$h,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function numberof($key){
		$file = $this->file;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		$o = 1;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				++$o;
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				rewind($file);
				return $o;
			}
			fseek($file,$s-$h,SEEK_CUR);
			++$o;
		}
		rewind($file);
		return false;
	}
	public function value($key, $length = null){
		$file = $this->file;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$s-= $h;
				if($length !== null && $s > $length)
					$s = $length;
				$r = fread($file,$s);
				rewind($file);
				return $r;
			}
			fseek($file,$s-$h,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function valen($key){
		$file = $this->file;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$s-= $h;
				rewind($file);
				return $s;
			}
			fseek($file,$s-$h,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function key($value){
		$file = $this->file;
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$h,SEEK_CUR);
				continue;
			}
			$v = fread($file,$h);
			if($v == $value){
				rewind($file);
				return $k;
			}
		}
		rewind($file);
		return false;
	}
	public function keys($value){
		$file = $this->file;
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		$ks = array();
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$h,SEEK_CUR);
				continue;
			}
			$v = fread($file,$h);
			if($v == $value)
				$ks[] = $k;
		}
		rewind($file);
		return $ks;
	}
	public function isvalue($value){
		$file = $this->file;
		$value = aped::encodeon($value);
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$h,SEEK_CUR);
				continue;
			}
			$v = fread($file,$h);
			if($v == $value){
				rewind($file);
				return true;
			}
		}
		rewind($file);
		return false;
	}
	private function replace($key,$value){
		$file = $this->file;
		$a = tmpfile();
		$u = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($t = fgetc($file)) !== false){
			$d = $t;
			$t = ord($t);
			$s = fread($file,$t);
			$d.= $s;
			$s = aped::sizedecode($s);
			$l = fgetc($file);
			$d.= $l;
			$l = ord($l);
			--$s;
			$h = fread($file,$l);
			$d.= $h;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$d.= fread($file,$s);
				fwrite($a,$d);
				continue;
			}
			$k = fread($file,$h);
			$d.= $k;
			if($k == $key){
				fseek($file,$s-$h,SEEK_CUR);
				$value = aped::encodeel($u,$value);
				fwrite($a,$value);
				stream_copy_to_stream($file,$a);
				rewind($file);
				rewind($a);
				stream_copy_to_stream($a,$file);
				fclose($a);
				ftruncate($file,ftell($file));
				rewind($file);
				return true;
			}
			$d.= fread($file,$s-$h);
			fwrite($a,$d);
		}
		fclose($a);
		rewind($file);
		return false;
	}
	public function set($key,$value){
		if(!$this->replace($key,$value)){
			$file = stream::fclone($this->file,'ab');
			fwrite($file,aped::encodeel($key,$value));
			fclose($file);
		}
	}
	public function add($key,$value){
		$file = stream::fclone($this->file,'ab');
		fwrite($file,aped::encodeel($key,$value));
		fclose($file);
	}
	public function delete($key){
		$file = $this->file;
		$a = tmpfile();
		$u = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($t = fgetc($file)) !== false){
			$d = $t;
			$t = ord($t);
			$s = fread($file,$t);
			$d.= $s;
			$s = aped::sizedecode($s);
			$l = fgetc($file);
			$d.= $l;
			$l = ord($l);
			--$s;
			$h = fread($file,$l);
			$d.= $h;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$d.= fread($file,$s);
				fwrite($a,$d);
				continue;
			}
			$k = fread($file,$h);
			$d.= $k;
			if($k == $key){
				fseek($file,$s-$h,SEEK_CUR);
				stream_copy_to_stream($file,$a);
				rewind($file);
				rewind($a);
				stream_copy_to_stream($a,$file);
				fclose($a);
				ftruncate($file,ftell($file));
				rewind($file);
				return true;
			}
			$d.= fread($file,$s-$h);
			fwrite($a,$d);
		}
		fclose($a);
		rewind($file);
		return false;
	}
	public function rename($from,$to){
		$this->delete($to);
		$file = $this->file;
		$a = tmpfile();
		$from = substr($from,ord($from[0])+1);
		$z = strlen($from);
		$q = strlen($to)-ord($to[0])-1;
		while(($t = fgetc($file)) !== false){
			$d = $t;
			$t = ord($t);
			$s = fread($file,$t);
			$d.= $s;
			$s = aped::sizedecode($s);
			$l = fgetc($file);
			$d.= $l;
			$l = ord($l);
			--$s;
			$h = fread($file,$l);
			$d.= $h;
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				$d.= fread($file,$s);
				fwrite($a,$d);
				continue;
			}
			$k = fread($file,$h);
			$d.= $k;
			if($k == $from){
				$s += $l + 1;
				$s += $q - $h;
				$s = aped::sizeencode($s);
				fwrite($a, chr(strlen($s)).$s.$to);
				stream_copy_to_stream($file,$a);
				rewind($file);
				rewind($a);
				stream_copy_to_stream($a,$file);
				fclose($a);
				ftruncate($file,ftell($file));
				rewind($file);
				return true;
			}
			$d.= fread($file,$s-$h);
			fwrite($a,$d);
		}
		fclose($a);
		rewind($file);
		return false;
	}
	public function isdir($key){
		$file = $this->file;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$l = ord(fgetc($file));
				fseek($file,$l,SEEK_CUR);
				$r = fgetc($file) == "\x09";
				rewind($file);
				return $r;
			}
			fseek($file,$s-$h,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function havedir(){
		$file = $this->file;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$l = ord(fgetc($file));
			fseek($file,$l,SEEK_CUR);
			if(fgetc($file) == "\x09"){
				rewind($file);
				return $k;
			}
			fseek($file,$s-$h-$l-1,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function dir($key){
		$file = $this->file;
		$j = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				continue;
			}
			$k = fread($file,$h);
			$s-= $h;
			if($k == $key){
				$u = ord(fgetc($file));
				fseek($file,$u,SEEK_CUR);
				if(fgetc($file) != "\x09"){
					rewind($file);
					return false;
				}
				$s-= $u + 2;
				$tmp = tmpfile();
				$obj = new APEDFile($tmp);
				$s0 = (int)($s / 1048576);
				$s1 = $s - $s0;
				for($i = 0; $i < $s0; ++$i)
					fwrite($tmp,fread($file,1048576));
				if($s1)fwrite($tmp,fread($file,$s1));
				rewind($tmp);
				$obj->setme(array($this,$j));
				rewind($file);
				return $obj;
			}
			fseek($file,$s,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function count(){
		$file = $this->file;
		$o = 0;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			fseek($file,$s,SEEK_CUR);
			++$o;
		}
		rewind($file);
		return $o;
	}
	public function allkey($func){
		$file = $this->file;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$func($k);
			fseek($file,$s-$h,SEEK_CUR);
		}
		rewind($file);
	}
	public function all($func){
		$file = $this->file;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$v = fread($file,$s-$h);
			$func($k,$v);
		}
		rewind($file);
	}
	public function map($func){
		$file = $this->file;
		$a = tmpfile();
		while(($t = fgetc($file)) !== false){
			$t = ord($t);
			$s = fread($file,$t);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$o = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($o);
			$k = fread($file,$h);
			$v = fread($file,$s-$h);
			$value = aped::encodeel(chr($l).$o.$k, $func($k,$v));
			fwrite($a,$value);
		}
		stream_copy_to_stream($file,$a);
		rewind($file);
		rewind($a);
		stream_copy_to_stream($a,$file);
		fclose($a);
		ftruncate($file,ftell($file));
		rewind($file);
	}
	public function numberat($o){
		if($o < 1)return false;
		$file = $this->file;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			if($o > 1){
				fseek($file,$s,SEEK_CUR);
				--$o;
				continue;
			}
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$v = fread($file,$s-$h);
			rewind($file);
			return array($k,$v);
		}
		rewind($file);
		return $o;
	}
	public function keyat($o){
		if($o < 1)return false;
		$file = $this->file;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			if($o > 1){
				fseek($file,$s,SEEK_CUR);
				--$o;
				continue;
			}
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			rewind($file);
			return $k;
		}
		rewind($file);
		return $o;
	}
	public function unshift($key,$value){
		$file = $this->file;
		$a = tmpfile();
		fwrite($a,aped::encodeel($key,$value));
		while(($t = fgetc($file)) !== false){
			$d = $t;
			$t = ord($t);
			$s = fread($file,$t);
			$d.= $s;
			$s = aped::sizedecode($s);
			$l = fgetc($file);
			$d.= $l;
			$l = ord($l);
			--$s;
			$h = fread($file,$l);
			$d.= $h;
			$s-= $l;
			$h = aped::sizedecode($h);
			$d.= fread($file,$s);
			fwrite($a,$d);
		}
		stream_copy_to_stream($file,$a);
		rewind($file);
		rewind($a);
		stream_copy_to_stream($a,$file);
		fclose($a);
		ftruncate($file,ftell($file));
		rewind($file);
		return false;
	}
	public function pop($onlyremove = false){
		$file = $this->file;
		$a = tmpfile();
		while(($t = fgetc($file)) !== false){
			$d = $t;
			$t = ord($t);
			$s = fread($file,$t);
			$d.= $s;
			$s = aped::sizedecode($s);
			fseek($file, $s, SEEK_CUR);
			$e = feof($file);
			fseek($file, -$s, SEEK_CUR);
			if($e){
				if($onlyremove){
					fseek($file, $s, SEEK_CUR);
					stream_copy_to_stream($file,$a);
					rewind($file);
					rewind($a);
					stream_copy_to_stream($a,$file);
					fclose($a);
					ftruncate($file,ftell($file));
					rewind($file);
					return true;	
				}
				$l = fgetc($file);
				$l = ord($l);
				--$s;
				$h = fread($file,$l);
				$s-= $l;
				$h = aped::sizedecode($h);
				$k = fread($file,$h);
				$v = fread($file,$s - $h);
				stream_copy_to_stream($file,$a);
				rewind($file);
				rewind($a);
				stream_copy_to_stream($a,$file);
				fclose($a);
				ftruncate($file,ftell($file));
				rewind($file);
				return array($k, $v);
			}
			$d.= fread($file,$s);
			fwrite($a,$d);
		}
		fclose($a);
		rewind($file);
		return false;
	}
	public function shift($onlyremove = false){
		$file = $this->file;
		$a = tmpfile();
		while(($t = fgetc($file)) !== false){
			$d = $t;
			$t = ord($t);
			$s = fread($file,$t);
			$d.= $s;
			$s = aped::sizedecode($s);
			$l = fgetc($file);
			$d.= $l;
			$l = ord($l);
			--$s;
			$h = fread($file,$l);
			$d.= $h;
			$s-= $l;
			$h = aped::sizedecode($h);
			$d.= $k = fread($file, $h);
			if($k[0] != "\x09"){
				fseek($file, -$l - $t - $h - 2, SEEK_CUR);
				break;
			}
			$d.= fread($file,$s - $h);
			fwrite($a,$d);
		}
		if($t === false)return false;
		$t = ord(fgetc($file));
		$s = fread($file,$t);
		$s = aped::sizedecode($s);
		if($onlyremove){
			fseek($file, $s, SEEK_CUR);
			stream_copy_to_stream($file,$a);
			rewind($file);
			rewind($a);
			stream_copy_to_stream($a,$file);
			fclose($a);
			ftruncate($file,ftell($file));
			rewind($file);
			return true;
		}
		$l = ord(fgetc($file));
		--$s;
		$h = fread($file,$l);
		$s-= $l;
		$h = aped::sizedecode($h);
		$k = fread($file,$h);
		$v = fread($file,$s - $h);
		stream_copy_to_stream($file,$a);
		rewind($file);
		rewind($a);
		stream_copy_to_stream($a,$file);
		fclose($a);
		ftruncate($file,ftell($file));
		rewind($file);
		return array($k, $v);
	}
	public function has($key, $value){
		$file = $this->file;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		$p = strlen($value);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fseek($file,$s,SEEK_CUR);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$s-= $h;
				if($s !== $p){
					rewind($file);
					return false;
				}
				$r = fread($file,$s);
				rewind($file);
				return $r == $value;
			}
			fseek($file,$s-$h,SEEK_CUR);
		}
		rewind($file);
		return false;
	}
	public function password_encode($password, $limit = 5242880){
		if($limit === 0)$limit = $this->size();
		$file = $this->file;
		$tmp = tmpfile();
		$iv = $password . sha1($password) . $password;
		$iv = substr(md5($iv), 0, 16);
		while(($content = fread($file,$limit)) !== ''){
			$content = openssl_encrypt($content,'AES-192-CTR',$password,1,$iv);
			$s = aped::sizeencode(strlen($content));
			$l = strlen($s);
			$content = chr($l).$s.$content;
			fwrite($tmp,$content);
		}
		rewind($file);
		rewind($tmp);
		stream_copy_to_stream($tmp,$file);
		rewind($file);
		fclose($tmp);
		return true;
	}
	public function password_decode($password){
		$file = $this->file;
		$tmp = tmpfile();
		$iv = $password . sha1($password) . $password;
		$iv = substr(md5($iv), 0, 16);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$data = fread($file,$s);
			$data = openssl_decrypt($data,'AES-192-CTR',$password,1,$iv);
			if($data === false)
				return false;
			fwrite($tmp,$data);
		}
		rewind($file);
		rewind($tmp);
		stream_copy_to_stream($tmp,$file);
		rewind($file);
		fclose($tmp);
		return true;
	}
}

class APEDURL {
	private $url = '';
	public function __construct($file){
		$this->url = $file;
	}
	public function get(){
		return fget($this->url);
	}
	public function getByte(){
		$file = fopen($this->url,'rb');
		$c = fgetc($file);
		fclose($file);
		return $c;
	}
	public function size(){
		return strlen($this->get());
	}
	public function locate(){
		return $this->url;
	}
	public function stream(){
		return fopen($this->url,'rb');
	}
	public function saveto($file){
		$file = fopen($file, 'w');
		$from = fopen($this->url,'rb');
		if(!$file)return false;
		stream_copy_to_stream($from, $file);
		fclose($from);
		fclose($file);
		return true;
	}
	public function iskey($key){
		$file = fopen($this->url,'rb');
		$key = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$s);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				fclose($file);
				return true;
			}
			fread($file,$s-$h);
		}
		fclose($file);
		return false;
	}
	public function numberof($key){
		$file = fopen($this->url,'rb');
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		$o = 1;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$s);
				++$o;
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				fclose($file);
				return $o;
			}
			fread($file,$s-$h);
			++$o;
		}
		fclose($file);
		return false;
	}
	public function value($key, $length = null){
		$file = fopen($this->url,'rb');
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$s);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$s-= $h;
				if($length !== null && $s > $length)
					$s = $length;
				$r = fread($file,$s);
				fclose($file);
				return $r;
			}
			fread($file,$s-$h);
		}
		fclose($file);
		return false;
	}
	public function valen($key){
		$file = fopen($this->url,'rb');
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$s);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$s-= $h;
				fclose($file);
				return $s;
			}
			fread($file,$s-$h);
		}
		fclose($file);
		return false;
	}
	public function key($value){
		$file = fopen($this->url,'rb');
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			if($h != $z){
				fclose($file,$h);
				continue;
			}
			$v = fread($file,$h);
			if($v == $value){
				rewind($file);
				return $k;
			}
		}
		fclose($file);
		return false;
	}
	public function keys($value){
		$file = fopen($this->url,'rb');
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		$ks = array();
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$h);
				continue;
			}
			$v = fread($file,$h);
			if($v == $value)
				$ks[] = $k;
		}
		fclose($file);
		return $ks;
	}
	public function isvalue($value){
		$file = fopen($this->url,'rb');
		$value = aped::encodeon($value);
		$value = substr($value,ord($value[0])+1);
		$z = strlen($value);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			$l = ord(fgetc($file));
			$h = fread($file,$l);
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$h);
				continue;
			}
			$v = fread($file,$h);
			if($v == $value){
				fclose($file);
				return true;
			}
		}
		fclose($file);
		return false;
	}
	public function isdir($key){
		$file = fopen($this->url,'rb');
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$s);
				continue;
			}
			$k = fread($file,$h);
			if($k == $key){
				$l = ord(fgetc($file));
				fread($file,$l);
				$r = fgetc($file) == "\x09";
				fclose($file);
				return $r;
			}
			fread($file,$s-$h);
		}
		fclose($file);
		return false;
	}
	public function havedir(){
		$file = fopen($this->url,'rb');
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$l = ord(fgetc($file));
			fread($file,$l);
			if(fgetc($file) == "\x09"){
				rewind($file);
				return $k;
			}
			fread($file,$s-$h-$l-1);
		}
		fclose($file);
		return false;
	}
	public function dir($key){
		$file = fopen($this->url,'rb');
		$j = $key;
		$key = substr($key,ord($key[0])+1);
		$z = strlen($key);
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			if($h != $z){
				fread($file,$s);
				continue;
			}
			$k = fread($file,$h);
			$s-= $h;
			if($k == $key){
				$u = ord(fgetc($file));
				fread($file,$u);
				if(fgetc($file) != "\x09"){
					fclose($file);
					return false;
				}
				$s-= $u + 2;
				$tmp = tmpfile();
				$obj = new APEDFile($tmp);
				$s0 = (int)($s / 1048576);
				$s1 = $s - $s0;
				for($i = 0; $i < $s0; ++$i)
					fwrite($tmp,fread($file,1048576));
				if($s1)fwrite($tmp,fread($file,$s1));
				rewind($tmp);
				fclose($file);
				return $obj;
			}
			fread($file,$s);
		}
		fclose($file);
		return false;
	}
	public function count(){
		$file = fopen($this->url,'rb');
		$o = 0;
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			fread($file,$s);
			++$o;
		}
		fclose($file);
		return $o;
	}
	public function allkey($func){
		$file = fopen($this->url,'rb');
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$func($k);
			fread($file,$s-$h);
		}
		fclose($file);
	}
	public function all($func){
		$file = fopen($this->url,'rb');
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$v = fread($file,$s-$h);
			$func($k,$v);
		}
		fclose($file);
	}
	public function numberat($o){
		if($o < 1)return false;
		$file = fopen($this->url,'rb');
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			if($o > 1){
				fread($file,$s);
				--$o;
				continue;
			}
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			$v = fread($file,$s-$h);
			fclose($file);
			return array($k,$v);
		}
		fclose($file);
		return $o;
	}
	public function keyat($o){
		if($o < 1)return false;
		$file = fopen($this->url,'rb');
		while(($l = fgetc($file)) !== false){
			$l = ord($l);
			$s = fread($file,$l);
			$s = aped::sizedecode($s);
			if($o > 1){
				fread($file,$s);
				--$o;
				continue;
			}
			$l = ord(fgetc($file));
			--$s;
			$h = fread($file,$l);
			$s-= $l;
			$h = aped::sizedecode($h);
			$k = fread($file,$h);
			fclose($file);
			return $k;
		}
		fclose($file);
		return $o;
	}
}

class APEDSQLi {
	private $sql,$parent = false;
	public $host,$username,$password,$database,$maked = false;
	public static function remsize($key){
		return substr($key, ord($key[0]) + 1);
	}
	public function __construct($host, $username = null, $password = '', $database = ''){
		if(is_array($host)){
			$this->sql = $host[0]->sql;
			$this->host = $host[0]->host;
			$this->username = $host[0]->username;
			$this->password = $host[0]->password;
			$this->database = $host[0]->database;
			$this->parent = $host;
			return;
		}elseif($username === null){
			return $this->username . ($this->password ? ':' . $this->password : '') . '@' . $this->host . '/' .
			$this->database . ($this->parent ? '/' . $this->parent[1] : '');
			$host = explode('/', $host, 3);
			if(isset($host[2]))$path = $host[2];
			$database = $host[1];
			$host = explode('@', $host[0], 2);
			$host[0] = explode(':', $host[0], 2);
			$username = $host[0][0];
			$password = isset($host[0][1]) ? $host[0][1] : '';
			$host = $host[1];
		}
		$this->sql = mysqli_connect($host, $username, $password);
		if(!$this->sql)
			new APError('APEDSQLi', "Invalid SQLi connection", APError::WARNING, APError::TTHROW);
		// mysqli_set_charset($this->sql, 'ISO-8859-1');
		if($database && !mysqli_select_db($this->sql, $database)){
			mysqli_query($this->sql, "CREATE DATABASE IF NOT EXISTS `" . mysqli_quote($database) . "`");
			mysqli_select_db($this->sql, $database);
			mysqli_query($this->sql, "CREATE TABLE _ (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			$this->maked = true;
		}elseif(!($result = mysqli_query("SHOW TABLES LIKE '_'")) || mysqli_num_rows($result) == 0){
			mysqli_query($this->sql, "CREATE TABLE _ (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			$this->maked = true;
		}
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		if(isset($path))
			$this->parent = array($this->sql, $path);
	}
	public function isChild(){
		return $this->parent !== false;
	}
	public function setme($parent){
		$this->parent = $parent;
	}
	public function owner(){
		if($this->parent === false)
			return false;
		return $this->parent[0];
	}
	public function save(){
		return false;
	}
	public function saveto($file){
		return false;
	}
	public function stream(){
		return $this->sql;
	}
	public function locate(){
		return $this->username . ($this->password ? ':' . $this->password : '') . '@' . $this->host . '/' .
			$this->database . ($this->parent ? '/' . $this->parent[1] : '');
	}
	public function get(){
		return false;
	}
	public function reset(){
		if($this->parent){
			$path = $this->parent[1];
			$select = mysqli_query($this->sql, "SELECT * FROM $path");
			$select = mysqli_fetch_assoc($select);
			unset($select['id']);
			foreach($select as $key => $value)
				if($value == 'a010109'){
					$table = $path . '/a' . crypt::hexencode($key);
					mysqli_query($this->sql, "DROP TABLE $table");
				}
			mysqli_query($this->sql, "DROP TABLE $path");
			mysqli_query($this->sql, "CREATE TABLE $path (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
		}else{
			$db = mysqli_quote($this->database);
			mysqli_query($this->sql, "DROP DATABASE $db");
			mysqli_query($this->sql, "CREATE DATABASE $db");
			mysqli_select_db($this->sql, $this->database);
			mysqli_query($this->sql, "CREATE TABLE _ (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			mysqli_query($this->sql, "INSERT INTO _ () VALUES ()");
		}
	}
	public function size(){
		$tables = mysqli_query($this->sql, "SHOW TABLES");
		$size = 0;
		while($row = mysqli_fetch_assoc($tables)){
			$table = mysqli_quote($row["Table_in_{$this->database}"]);
			$select = mysqli_query($this->sql, "SELECT * FROM $table");
			$size += array_sum($select->lengths);
		}
		return $size;
	}
	public function iskey($key){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		return (bool)mysqli_query($this->sql, "SELECT $key FROM $table");
	}
	public function numberof($key){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		$select = mysqli_query($this->sql, "SELECT $key FROM $table");
		if($select){
			$select = mysqli_fetch_assoc($select);
			unset($select['id']);
			return array_search($key, array_keys($select), true);
		}
		return false;
	}
	public function value($key){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		$select = mysqli_query($this->sql, "SELECT $key FROM $table");
		if($select){
			$select = mysqli_fetch_assoc($select);
			$value = crypt::hexdecode(substr($select[$key], 1));
			return $value;
		}
		return false;
	}
	public function valen($key){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = crypt::hexdecode(substr($key, 1));
		$select = mysqli_query($this->sql, "SELECT $key FROM $table");
		if($select){
			$select = mysqli_fetch_assoc($select);
			unset($select['id']);
			return ceil(strlen($select[$key]) * 3 / 4);
		}
		return false;
	}
	public function key($value){
		$table = $this->parent ? $this->parent[1] : '_';
		$value = 'a' . crypt::hexencode($value);
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		$key = array_search($value, $select, true);
		if($key === false)
			return false;
		return self::remsize(crypt::hexdecode(substr($key, 1)));
	}
	public function keys($value){
		$table = $this->parent ? $this->parent[1] : '_';
		$value = 'a' . crypt::hexencode($value);
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		$keys = array();
		foreach($select as $key => $test)
			if($value == $test)
				$keys[] = self::remsize(crypt::hexdecode(substr($key, 1)));
		return $keys;
	}
	public function isvalue($value){
		$table = $this->parent ? $this->parent[1] : '_';
		$value = 'a' . crypt::hexencode($value);
		return (bool)mysqli_query($this->sql, "SELECT * FROM $table LIKE $value");
	}
	public function set($key,$value){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		$value = 'a' . crypt::hexencode($value);
		if(!mysqli_query($this->sql, "SELECT $key FROM $table"))
			mysqli_query($this->sql, "ALTER TABLE $table ADD COLUMN $key TEXT");
		mysqli_query($this->sql, "UPDATE $table SET `$key`='$value'");
	}
	public function add($key,$value){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		$value = 'a' . crypt::hexencode($value);
		mysqli_query($this->sql, "ALTER TABLE $table ADD COLUMN $key TEXT");
		mysqli_query($this->sql, "UPDATE $table SET `$key`='$value'");
	}
	public function delete($key){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		mysqli_query($this->sql, "ALTER TABLE $table DROP COLUMN $key");
	}
	public function rename($from,$to){
		$table = $this->parent ? $this->parent[1] : '_';
		$from = 'a' . crypt::hexencode($key);
		$select = mysqli_query($this->sql, "SELECT $key FROM $table");
		if($select){
			$select = mysqli_fetch_assoc($select);
			$value = crypt::hexdecode(substr($select[$from], 1));
		}else return false;
		if(!mysqli_query($this->sql, "SELECT $to FROM $table"))
			mysqli_query($this->sql, "ALTER TABLE $table ADD COLUMN $to TEXT");
		mysqli_query($this->sql, "UPDATE $table SET `$to`='$value'");
		if($value == 'a010109'){
			$from = $this->parent ? $this->parent[1] . '/' . $from : $from;
			$to = $this->parent ? $this->parent[1] . '/' . $to : $to;
			$select = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM $from"));
			unset($select['id']);
			mysqli_query($this->sql, "DROP TABLE $from");
			mysqli_query($this->sql, "CREATE TABLE $to (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			mysqli_query($this->sql, "INSERT INTO $to () VALUES ()");
			$query = "UPDATE $to SET ";
			foreach($select as $key => $value){
				mysqli_query($this->sql, "ALTER TABLE $to ADD COLUMN $key TEXT");
				$query .= "`$key`='$value',";
			}
			mysqli_query($this->sql, substr($query, 0, -1));
		}
		return true;
	}
	public function isdir($key){
		$key = 'a' . crypt::hexencode($key);
		$table = $this->parent ? $this->parent[1] . '/' . $key : $key;
		return (bool)mysqli_query($this->sql, "SHOW TABLES LIKE $table");
	}
	public function dir($key){
		$key = 'a' . crypt::hexencode($key);
		$table = $this->parent ? $this->parent[1] . '/' . $key : $key;
		if(!($result = mysqli_query($this->sql, "SHOW TABLES LIKE '$table'")) || mysqli_num_rows($result) == 0)
			return false;
		return new APEDSQLi(array($this, $table));
	}
	public function mdir($key){
		$key = 'a' . crypt::hexencode($key);
		$table = $this->parent ? $this->parent[1] . '/' . $key : $key;
		if(!($result = mysqli_query($this->sql, "SHOW TABLES LIKE '$table'")) || mysqli_num_rows($result) == 0){
			mysqli_query($this->sql, "CREATE TABLE $table (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			mysqli_query($this->sql, "INSERT INTO $table () VALUES ()");
		}
		$pnt = $this->parent ? $this->parent[1] : '_';
		if(!mysqli_query($this->sql, "SELECT $key FROM $pnt"))
			mysqli_query($this->sql, "ALTER TABLE $pnt ADD COLUMN $key TEXT");
		mysqli_query($this->sql, "UPDATE $pnt SET $key='a010109'");
		return new APEDSQLi(array($this, $table));
	}
	public function havedir(){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		foreach($select as $key => $value)
			if($value == 'a010109')
				return self::remsize(crypt::hexdecode(substr($key, 1)));
		return false;
	}
	public function make($key,$ret = false){
		$key = 'a' . crypt::hexencode($key);
		$table = $this->parent ? $this->parent[1] . '/' . $key : $key;
		if(($result = mysqli_query($this->sql, "SHOW TABLES LIKE '$table'")) && mysqli_num_rows($result) > 0)
			mysqli_query($this->sql, "DROP TABLE $table");
		$res = mysqli_query($this->sql, "CREATE TABLE $table (
			id INT AUTO_INCREMENT PRIMARY KEY
		)");
		mysqli_query($this->sql, "INSERT INTO $table () VALUES ()");
		if(!$res)return false;
		$pnt = $this->parent ? $this->parent[1] : '_';
		if(!mysqli_query($this->sql, "SELECT $key FROM $pnt"))
			mysqli_query($this->sql, "ALTER TABLE $pnt ADD COLUMN $key TEXT");
		mysqli_query($this->sql, "UPDATE $pnt SET $key='a010109'");
		if($ret)
			return new APEDSQLi(array($this, $table));
		return true;
	}
	public function count(){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		return count($select);
	}
	public function allkey($func){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		foreach($select as $key => $value)
			$func(self::remsize(crypt::hexdecode(substr($key, 1))));
	}
	public function all($func){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		foreach($select as $key => $value)
			$func(self::remsize(crypt::hexdecode(substr($key, 1))), crypt::hexdecode(substr($value, 1)));
	}
	public function map($func){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		$query = "UPDATE $table SET ";
		foreach($select as $key => $value){
			$value = $func(self::remsize(crypt::hexdecode(substr($key, 1))), crypt::hexdecode(substr($value, 1)));
			$value = 'a' . crypt::hexencode($value);
			$query .= "$key=$value,";
		}
		mysqli_query($this->sql, substr($query, 0, -1));
	}
	public function numberat($o){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		$keys = array_keys($select);
		return isset($keys[$o]) ? array($keys[$o], $select[$keys[$o]]) : false;
	}
	public function keyat($o){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		$select = array_keys($select);
		return isset($select[$o]) ? $select[$o] : false;
	}
	public function unshift($key,$value){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		if(isset($select[$key]))unset($select[$key]);
		mysqli_query($this->sql, "DROP TABLE $table");
		mysqli_query($this->sql, "CREATE TABLE $table (
			id INT AUTO_INCREMENT PRIMARY KEY
		)");
		mysqli_query($this->sql, "INSERT INTO $table () VALUES ()");
		$key = 'a' . crypt::hexencode($key);
		$value = 'a' . crypt::hexencode($value);
		$keys = "`$key`,";
		$query = "`$key`='$value',";
		foreach($select as $key => $value){
			$key = 'a' . crypt::hexencode($key);
			$value = 'a' . crypt::hexencode($value);
			$keys .= "`$key`,";
			$query .= "`$key`='$value',";
		}
		mysqli_query($this->sql, "ALTER TABLE $table ADD COLUMN " . substr($keys, 0, -1) . " TEXT");
		mysqli_query($this->sql, "UPDATE $table SET " . substr($query, 0, -1));
	}
	public function pop($onlyremove = false){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$select = mysqli_fetch_assoc($select);
		unset($select['id']);
		$value = end($select);
		mysqli_query($this->sql, "ALTER TABLE $table DROP COLUMN $key");
		return array(self::remsize(crypt::hexdecode(substr($key, 1))), crypt::hexdecode(substr($value, 1)));
	}
	public function shift($onlyremove = false){
		$table = $this->parent ? $this->parent[1] : '_';
		$select = mysqli_query($this->sql, "SELECT * FROM $table");
		$key = key($select);
		$value = $select[$key];
		mysqli_query($this->sql, "ALTER TABLE $table DROP COLUMN $key");
		return array(self::remsize(crypt::hexdecode(substr($key, 1))), crypt::hexdecode(substr($value, 1)));
	}
	public function has($key, $value){
		$table = $this->parent ? $this->parent[1] : '_';
		$key = 'a' . crypt::hexencode($key);
		$value = 'a' . crypt::hexencode($value);
		return (bool)mysqli_query($this->sql, "SELECT $key FROM $table LIKE $value");
	}
	public function password_encode($password){
		$iv = $password . sha1($password) . $password;
		$iv = substr(md5($iv), 0, 16);
		$password2 = strrev($password);
		$tmp = $iv2 = strrev($iv);
		$iv2 = substr(md5($iv2 . $password2), 0, 16);
		$password2 ^= str::equlen($password2, md5($password2 . $tmp));
		$tables = mysqli_query("SHOW TABLES");
		while($table = mysqli_fetch_assoc($tables)){
			$table = $table["Table_in_{$this->database}"];
			$select = mysqli_query($this->sql, "SELECT * FROM $table");
			$select = mysqli_fetch_assoc($select);
			mysqli_query($this->sql, "DROP TABLE $table");
			$table = crypt::base64urldecode(openssl_encrypt('a' . crypt::hexencode($table),'AES-192-CTR',$password,1,$iv2));
			mysqli_query($this->sql, "CREATE TABLE $table (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			mysqli_query($this->sql, "INSERT INTO $table () VALUES ()");
			foreach($select as $key => $value){
				$key = 'a' . crypt::hexencode(openssl_encrypt(crypt::hexdecode(substr($key, 1)),'AES-192-CTR',$password,1,$iv));
				$value = 'a' . crypt::hexencode(openssl_encrypt(crypt::hexdecode(substr($key, 1)),'AES-192-CTR',$password2,1,$iv2));
				mysqli_query($this->sql, "INSERT INTO $table (`$key`) VALUES ('$value')");
			}
		}
		return true;
	}
	public function password_decode($password){
		$iv = $password . sha1($password) . $password;
		$iv = substr(md5($iv), 0, 16);
		$password2 = strrev($password);
		$tmp = $iv2 = strrev($iv);
		$iv2 = substr(md5($iv2 . $password2), 0, 16);
		$password2 ^= str::equlen($password2, md5($password2 . $tmp));
		$tables = mysqli_query("SHOW TABLES");
		while($table = mysqli_fetch_assoc($tables)){
			$table = $table["Table_in_{$this->database}"];
			$select = mysqli_query($this->sql, "SELECT * FROM $table");
			$select = mysqli_fetch_assoc($select);
			mysqli_query($this->sql, "DROP TABLE $table");
			$table = crypt::base64urldecode(openssl_decrypt('a' . crypt::hexencode($table),'AES-192-CTR',$password,1,$iv2));
			mysqli_query($this->sql, "CREATE TABLE $table (
				id INT AUTO_INCREMENT PRIMARY KEY
			)");
			mysqli_query($this->sql, "INSERT INTO $table () VALUES ()");
			foreach($select as $key => $value){
				$key = 'a' . crypt::hexencode(openssl_decrypt(crypt::hexdecode(substr($key, 1)),'AES-192-CTR',$password,1,$iv));
				$value = 'a' . crypt::hexencode(openssl_decrypt(crypt::hexdecode(substr($key, 1)),'AES-192-CTR',$password2,1,$iv2));
				mysqli_query($this->sql, "INSERT INTO $table (`$key`) VALUES ('$value')");
			}
		}
		return true;
	}
}

// --------- Color ---------- //
class Color {
	public static function rgb($red, $green, $blue){
		return ((($red & 0xff) << 16) | (($green & 0xff) << 8) | ($blue & 0xff));
	}
	public static function rgba($red, $green, $blue, $alpha){
		return ((($alpha & 0xff) << 24) | (($red & 0xff) << 16) | (($green & 0xff) << 8) | ($blue & 0xff));
	}
	public static function unrgb($color){
		return array(($color >> 16) & 0xff, ($color >> 8) & 0xff, $color & 0xff);
	}
	public static function unrgba($color){
		return array(($color >> 16) & 0xff, ($color >> 8) & 0xff, $color & 0xff, ($color >> 24) & 0xff);
	}
	private static function _hue($a, $b, $h){
		if($h < 0)
			$h += 1;
		if($h > 1)
			$h -= 1;
		if(6 * $h < 1)
			return $a + ($b - $a) * 6 * $h;
		if(2 * $h < 1)
			return $b;
		if(3 * $h < 2)
			return $a + ($b - $a) * (2 / 3 - $h) * 6;
		return $a;
	}
	public static function hslrgb($h, $s, $l){
		if($s == 0)
			return array($l * 255, $l * 255, $l * 255);
		if($l < 0.5)
			$a = $l * (1 + $s);
		else
			$a = ($l + $s) - ($s * $l);
		$b = 2 * $l - $a;
		return array(
			255 * self::_hue($b, $a, $h + 1 / 3),
			255 * self::_hue($b, $a, $h),
			255 * self::_hue($b, $a, $h - 1 / 3)
		);
	}
	public static function rgbhsl($r, $g, $b){
		$r /= 255;
		$g /= 255;
		$b /= 255;
		$min = min($r, $g, $b);
		$max = max($r, $g, $b);
		$delta = $max - $min;
		$l = ($max + $min) / 2;
		if($delta == 0)
			$s = $h = 0;
		else{
			if($l < 0.5)$s = $delta / ($max + $min);
			else 		$s = $delta / (2 - $max - $min);
			$dr = ((($max - $r) / 6) + ($delta / 2)) / $delta;
			$dg = ((($max - $g) / 6) + ($delta / 2)) / $delta;
			$db = ((($max - $b) / 6) + ($delta / 2)) / $delta;
			if	($r == $max)$h = $db - $dg;
			elseif($g == $max)$h = (1 / 3) + $dr - $db;
			elseif($b == $max)$h = (2 / 3) + $dg - $dr;
			if($h < 0)++$h;
			if($h > 1)--$h;
		}
		return array($h, $s, $l);
	}
	public static function hsl($h, $s, $l){
		$rgb = self::hslrgb($h, $s, $l);
		return self::rgb($rgb[0], $rgb[1], $rgb[2]);
	}
	public static function hsla($h, $s, $l, $a){
		$rgb = self::hslrgb($h, $s, $l);
		return self::rgba($rgb[0], $rgb[1], $rgb[2], $a);
	}
	public static function unhsl($color){
		$rgb = self::unrgb($color);
		return self::rgbhsl($rgb[0], $rgb[1], $rgb[2]);
	}
	public static function unhsla($color){
		$rgba = self::unrgba($color);
		$hsla = self::rgbhsl($rgb[0], $rgb[1], $rgb[2]);
		$hsla[] = $rgb[3];
		return $hsla;
	}
	public static function hsvrgb($h, $s, $v){
		if($s == 0)
			return array($v * 255, $v * 255, $v * 255);
		$h *= 6;
		$i = floor($h);
		$a = $v * (1 - $s);
		$b = $v * (1 - $s * ($h - $i));
		$c = $v * (1 - $s * (1 - ($h - $i)));
		switch($i){
			case 0: return array($v * 255, $c * 255, $a * 255);
			case 1: return array($b * 255, $v * 255, $a * 255);
			case 2: return array($a * 255, $v * 255, $c * 255);
			case 3: return array($a * 255, $b * 255, $v * 255);
			case 4: return array($c * 255, $a * 255, $v * 255);
			default:return array($v * 255, $a * 255, $b * 255);
		}
	}
	public static function rgbhsv($r, $g, $b){
		$r /= 255;
		$g /= 255;
		$b /= 255;
		$min = min($r, $g, $b);
		$max = max($r, $g, $b);
		$delta = $max - $min;
		$v = $max;
		if($max == 0)
		   $s = $h = 0;
		else{
		   $s = $delta / $max;
		   $dr = ((($max - $r) / 6) + ($max / 2)) / $delta;
		   $dg = ((($max - $g) / 6) + ($max / 2)) / $delta;
		   $db = ((($max - $b) / 6) + ($max / 2)) / $delta;
		   if	($r == $max)$h = $b - $dg;
		   elseif($g == $max)$h = (1 / 3) + $dr - $db;
		   elseif($b == $max)$h = (2 / 3) + $dg - $dr;
		   if($h < 0)++$h;
		   if($h > 1)--$h;
		}
		return array($h, $s, $v);
	}
	public static function hsv($h, $s, $v){
		$rgb = self::hsvrgb($h, $s, $v);
		return self::rgb($rgb[0], $rgb[1], $rgb[2]);
	}
	public static function hsva($h, $s, $v, $a){
		$rgb = self::hsvrgb($h, $s, $v);
		return self::rgba($rgb[0], $rgb[1], $rgb[2], $a);
	}
	public static function unhvl($color){
		$rgb = self::unrgb($color);
		return self::rgbhsv($rgb[0], $rgb[1], $rgb[2]);
	}
	public static function unhsva($color){
		$rgba = self::unrgba($color);
		$hsva = self::rgbhsv($rgb[0], $rgb[1], $rgb[2]);
		$hsva[] = $rgb[3];
		return $hsva;
	}
	public static function hslhsv($h, $s, $l){
		$s *= $l < 0.5 ? $l : 1 - $l;
		return array($h, 2 * $s / ($l + $s), $l + $s);
	}
	public static function hsvhsl($h, $s, $v){
		return array($h, $s * $v / (($h = (2 - $s) * $v) < 1 ? $h : 2 - $h), $h / 2);
	}
	public static function red($color, $r = null){
		if($r === null)return ($color >> 16) & 0xff;
		return (((($color >> 24) << 8) | ($r & 0xff)) << 16) | ($color & 0xffff);
	}
	public static function green($color, $g = null){
		if($g === null)return ($color >> 8) & 0xff;
		return (((($color >> 16) << 8) | ($g & 0xff)) << 8) | ($color & 0xff);
	}
	public static function blue($color, $b = null){
		if($b === null)return $color & 0xff;
		return (($color >> 8) << 8) | ($b & 0xff);
	}
	public static function alpha($color, $a = null){
		if($a === null)return ($color >> 24) & 0xff;
		return ($color & 0xffffff) | (($a & 0xff) << 24);
	}
	public static function rgbhex($r, $g, $b){
		return str_pad(dechex(self::rgb($r, $g, $b)), 6, '0');
	}
	public static function rgbahex($r, $g, $b, $a){
		return str_pad(dechex(self::rgba($r, $g, $b, $a)), 8, '0');
	}
	public static function hexrgb($hex){
		return self::unrgb(hexdec($hex));
	}
	public static function hexrgba($hex){
		return self::unrgba(hexdec($hex));
	}
	public static function islight($r, $g, $b, $threshold = 130){
		return (($r * 299 + $g * 587 + $b * 114 ) / 1000 > $threshold);
	}
	public static function isdark($r, $g, $b, $threshold = 130){
		return (($r * 299 + $g * 587 + $b * 114 ) / 1000 <= $threshold);
	}
	public static function mixrgb($r1, $g1, $b1, $r2, $g2, $b2, $amount = 0){
		$m1 = $amount / 100 + 1;
		$m2 = 2 - $r1;
		return array(
			($r1 * $m1 + $r2 * $m2) / 2,
			($g1 * $m1 + $g2 * $m2) / 2,
			($b1 * $m1 + $b2 * $m2) / 2
		);
	}
	public static function mixrgba($r1, $g1, $b1, $a1, $r2, $g2, $b2, $a2, $amount = 0){
		$m1 = $amount / 100 + 1;
		$m2 = 2 - $r1;
		return array(
			($r1 * $a1 * (1 - $a2) * $m1 + $r2 * $a2 * $m2) / 2,
			($g1 * $a1 * (1 - $a2) * $m1 + $g2 * $a2 * $m2) / 2,
			($b1 * $a1 * (1 - $a2) * $m1 + $b2 * $a2 * $m2) / 2,
			($a1 * (1 - $a2) * $m1 + $a2 * $m2) / 2
		);
	}
	public static function mix($c1, $c2, $amount = 0){
		$c1 = self::unrgb($c1);
		$c2 = self::unrgb($c2);
		return self::mixrgba($c1[0], $c1[1], $c1[2], $c2[0], $c2[1], $c2[2], $amount);
	}
	public static function mixa($c1, $c2, $amount = 0){
		$c1 = self::unrgba($c1);
		$c2 = self::unrgba($c2);
		return self::mixrgba($c1[0], $c1[1], $c1[2], $c1[3], $c2[0], $c2[1], $c2[2], $c2[3], $amount);
	}
	public static function grayscale($r, $g, $b){
		$x = $r * 0.3 + $g * 0.59 + $b * 0.11;
		return array($x, $x, $x);
	}
	public static function invert($r, $g, $b){
		return array(255 - $r, 255 - $g, 255 - $b);
	}
	public static function random(){
		return array(rand(0, 255), rand(0, 255), rand(0, 255));
	}
	public static function lighten($r, $g, $b, $amount = 1){
		$amount /= 100;
		return self::modrgb($r + $r * $amount, $g + $g * $amount, $b + $b * $amount);
	}
	public static function brightness($r, $g, $b, $l){
		$hsl = self::rgbhsl($r, $g, $b);
		$hsl[2] = $l < 0 ? $l - floor($l) + 1 : $l - floor($l);
		return self::rgb($hsl[0], $hsl[1], $hsl[2]);
	}
	public static function modrgb($r, $g, $b){
		return array(
			$r < 0 ? $r % 256 + 256 : $r % 256,
			$g < 0 ? $g % 256 + 256 : $g % 256,
			$b < 0 ? $b % 256 + 256 : $b % 256
		);
	}
	public static function modrgba($r, $g, $b, $a){
		return array(
			$r < 0 ? $r % 256 + 256 : $r % 256,
			$g < 0 ? $g % 256 + 256 : $g % 256,
			$b < 0 ? $b % 256 + 256 : $b % 256,
			$a < 0 ? $a % 256 + 256 : $a % 256
		);
	}
	public static function modhsl($h, $s, $l){
		return array(
			$h < 0 ? $h - floor($h) + 1 : $h - floor($h),
			$s < 0 ? $s - floor($s) + 1 : $s - floor($s),
			$l < 0 ? $l - floor($l) + 1 : $l - floor($l)
		);
	}
	public static function modhsv($h, $s, $l){
		return array(
			$h < 0 ? $h - floor($h) + 1 : $h - floor($h),
			$s < 0 ? $s - floor($s) + 1 : $s - floor($s),
			$v < 0 ? $v - floor($v) + 1 : $v - floor($v)
		);
	}
	public static function saturate($r, $g, $b, $amount = 1){
		$hsl = self::rgbhsl($r, $g, $b);
		$hsl[1] = $hsl[1] + $hsl[1] * ($amount / 100);
		$hsl[1] = $hsl[1] < 0 ? $hsl[1] - floor($hsl[1]) + 1 : $hsl[1] - floor($hsl[1]);
		return self::rgb($hsl[0], $hs[1], $hsl[2]);
	}
	public static function sepia($r, $g, $b){
		return array(
			$r * 0.393 + $g * 0.769 + $b * 0.189,
			$r * 0.349 + $g * 0.686 + $b * 0.168,
			$r * 0.272 + $g * 0.534 + $g * 0.131
		);
	}
	public static function contrast($r, $g, $b, $amount = 1){
		return self::modrgb($r + $amount, $g + $amount, $b + $amount);
	}
	public static function hue($r, $g, $b, $h){
		$hsl = self::rgbhsl($r, $g, $b);
		$hsl[0] = $h < 0 ? $h - floor($h) + 1 : $h - floor($h);
		return self::rgb($hsl[0], $hsl[1], $hsl[2]);
	}
}

// ---------- File ---------- //
class XNGraphicPNG {
	const E_NONE = 0;
	const E_INVALID_HEADER = 1;

	public $error = 0,
		   $width = 0,
		   $height = 0,
		   $data = '',
		   $comments = array(),
		   $pixels = array();
	public function parse($content){
		$this->error = self::E_NONE;
		if(substr($content, 0, 8) != "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")
			return $this->error = self::E_INVALID_HEADER;
		$length = strlen($content);
		$offset = 8;
		while($offset < $length){
			$dlen = array_value(unpack('N', substr($content, $offset, 4)), 1);
			$offset += 4;
			$type = substr($content, $offset, 4);
			$offset += 4;
			$raw = array_value(unpack('N', $type), 1);
			$data = substr($content, $offset, $dlen);
			$offset += $dlen + 4;
			switch($type){
				case 'IHDR':
					$this->width  = array_value(unpack('N', substr($data, 0, 4)), 1);
					$this->height = array_value(unpack('N', substr($data, 4, 4)), 1);
					$this->bit_depth = ord($data[8]);
					$this->color_type = ord($data[9]);
					$this->compression_method = ord($data[10]);
					$this->filter_method = ord($data[11]);
					$this->interlace_method = ord($data[12]);
					if($this->compression_method === 0)$this->compression_method = 'zlib';
					$this->color_palette = (bool)($this->color_type & 1);
					$this->true_color = (bool)($this->color_type & 2);
					$this->color_alpha = (bool)($this->color_type & 4);
				break;
				case 'CgBI':
					$this->iphone = true;
				break;
				case 'PLTE':
					$this->palette = array();
					for($i = 0; $i < 256; ++$i){
						$red   = ord($data[$i * 3]);
						$green = ord($data[$i * 3 + 1]);
						$blue  = ord($data[$i * 3 + 2]);
						$this->palette[$i] = color::rgb($red, $green, $blue);
					}
				break;
				case 'tRNS':
					switch($this->color_type){
						case 0:
							$this->transparent_color_gray = array_value(unpack('n', substr($data, 0, 2)), 1);
						break;
						case 2:
							$this->transparent_color_red   = array_value(unpack('n', substr($data, 0, 2)), 1);
							$this->transparent_color_green = array_value(unpack('n', substr($data, 2, 2)), 1);
							$this->transparent_color_blue  = array_value(unpack('n', substr($data, 4, 2)), 1);
						break;
						case 3:
							$this->palette_opacity = array();
							for($i = 0; isset($data[$i]); ++$i)
								$this->palette_opacity[$i] = ord($data[$i]);
					}
				break;
				case 'gAMA':
					$this->gamma = crypt::intbe($data) / 100000;
				break;
				case 'cHRM':
					$this->white_x = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->white_y = array_value(unpack('N', substr($data, 4, 4)), 1) / 100000;
					$this->red_x   = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->red_y   = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->green_x = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->green_y = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->blue_x  = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->blue_y  = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
				break;
				case 'sRGB':
					$this->reindering_intent = array_value(unpack('N', $data), 1);
					switch($this->reindering_intent){
						case 0:
							$this->reindering_intent = 'Perceptual';
						break;
						case 100000:
							$this->reindering_intent = 'Relative colorimetric';
						break;
						case 200000:
							$this->reindering_intent = 'Saturation';
						break;
						case 300000:
							$this->reindering_intent = 'Absolute colorimetric';
					}
				break;
				case 'iCCP':
					list($this->profile_name, $compression) = explode("\0", $data, 2);
					$this->compression_method = ord($compression[0]);
					if($this->compression_method === 0)$this->compression_method = 'zlib';
					$this->compression_profile = substr($compression, 1);
				break;
				case 'tEXt':
					list($keyword, $text) = explode("\0", $data, 2);
					if(!isset($this->comments[$keyword]))$this->comments[$keyword] = array();
					$this->comments[$keyword][] = array(
						'text' => $text
					);
				break;
				case 'zTXt':
					list($keyword, $otherdata) = explode("\0", $data, 2);
					$compression = ord($otherdata[0]);
					$text = substr($otherdata, 1);
					if($compression === 0)
						$text = gzuncompress($text);
					if(!isset($this->comments[$keyword]))$this->comments[$keyword] = array();
					$this->comments[$keyword][] = array(
						'compression' => $compression,
						'text' => $text
					);
				break;
				case 'iTXt':
					list($keyword, $otherdata) = explode("\0", $data, 2);
					$compression = $otherdata[0] != "\0";
					$compression_method = ord($otherdata[1]);
					list($language_tag, $translated_keyword, $text) = explode("\0", substr($otherdata, 2), 3);
					if($compression === true && $compression_method === 0)
						$text = gzuncompress($text);
					if(!isset($this->comments[$keyword]))$this->comments[$keyword] = array();
					$this->comments[$keyword][] = array(
						'translated_keyword' => $translated_keyword,
						'language_tag' => $language_tag,
						'compression' => $compression === true ? $compression_method : false,
						'content' => $text
					);
				break;
				case 'bKGD':
					switch($this->color_type){
						case 0:
						case 4:
							$this->background_gray = array_value(unpack('N', $data), 1);
						break;
						case 2:
						case 6:
							$this->background_red   = array_value(unpack('N', substr($data, 0, $this->bit_depth)), 1);
							$this->background_green = array_value(unpack('N', substr($data, $this->bit_depth, $this->bit_depth)), 1);
							$this->background_blue  = array_value(unpack('N', substr($data, $this->bit_depth * 2, $this->bit_depth)), 1);
						break;
						case 3:
							$this->background_index = array_value(unpack('N', $data), 1);
					}
				break;
				case 'pHYs':
					$this->pixels_per_unit_x = array_value(unpack('N', substr($data, 0, 4)), 1);
					$this->pixels_per_unit_y = array_value(unpack('N', substr($data, 4, 4)), 1);
					$this->unit = ord($data[8]);
					if($this->unit === 0)$this->unit = 'unknown';
					elseif($this->unit === 1)$this->unit = 'meter';
				break;
				case 'sBIT':
					switch($this->color_type){
						case 0:
							$this->significant_bits_gray = ord($data[0]);
						break;
						case 2:
						case 3:
							$this->significant_bits_red   = ord($data[0]);
							$this->significant_bits_green = ord($data[1]);
							$this->significant_bits_blue  = ord($data[2]);
						break;
						case 4:
							$this->significant_bits_gray  = ord($data[0]);
							$this->significant_bits_alpha = ord($data[1]);
						break;
						case 6:
							$this->significant_bits_red   = ord($data[0]);
							$this->significant_bits_green = ord($data[1]);
							$this->significant_bits_blue  = ord($data[2]);
							$this->significant_bits_alpha = ord($data[3]);
						break;
					}
				break;
				case 'sPLT':
					list($palettename, $otherdata) = explode("\0", $data, 2);
					$this->palette_name = $palettename;
					$this->sample_depth_bits = ord($otherdata[0]);
					$this->sample_depth_bytes = $this->sample_depth_bits / 8;
					$this->suggested_palette = array(
						'red'   => array(),
						'green' => array(),
						'blue'  => array(),
						'alpha' => array()
					);
					for($c = 1; isset($otherdata[$i]);){
						$this->suggested_palette['red'][]   = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
						$this->suggested_palette['green'][] = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
						$this->suggested_palette['blue'][]  = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
						$this->suggested_palette['alpha'][] = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
					}
				break;
				case 'hIST':
					$this->palette_histogram = array();
					for($c = 0; isset($data[$c]); $c += 2)
						$this->palette_histogram[$c] = array_value(unpack('n', substr($data, $c / 2, 2)), 1);
				break;
				case 'tIME':
					$this->last_modification = gmmktime(
						ord($data[4]),
						ord($data[5]),
						ord($data[6]),
						ord($data[2]),
						ord($data[3]),
						array_key(unpack('n', substr($data, 0, 2)), 1)
					);
				break;
				case 'oFFs':
					$this->position_x = crypt::intbe(substr($data, 0, 4), false, true);
					$this->position_y = crypt::intbe(substr($data, 4, 4), false, true);
					$this->offset_unit = ord($data[8]);
					if($this->offset_unit === 0)$this->offset_unit = 'unknown';
					elseif($this->offset_unit === 1)$this->offset_unit = 'meter';
				break;
				case 'pCAL':
					list($calibrationname, $otherdata) = explode("\0", $data, 2);
					$this->calibration_name = $calibrationname;
					$this->original_zero = crypt::intbe(substr($data, 0, 4), false, true);
					$this->original_max  = crypt::intbe(substr($data, 4, 4), false, true);
					$this->equation_type = ord($data[8]);
					switch($this->equation_type){
						case 0:
							$this->equation_type = 'Linear mapping';
						break;
						case 1:
							$this->equation_type = 'Base-e exponential mapping';
						break;
						case 2:
							$this->equation_type = 'Arbitrary-base exponential mapping';
						break;
						case 3:
							$this->equation_type = 'Hyperbolic mapping';
					}
					$this->parameter_count = ord($data[9]);
					$this->parameters = explode("\0", substr($data, 10));
				break;
				case 'sCAL':
					$this->scale_unit = ord($data[0]);
					if($this->scale_unit === 0)$this->scale_unit = 'unknown';
					elseif($this->scale_unit === 1)$this->scale_unit = 'meter';
					list($this->pixel_width, $this->pixel_height) = explode("\0", substr($data, 1));
				break;
				case 'gIFg':
					if(!isset($this->gifs)){
						$this->gifs = array();
						$this->gif_count = 0;
					}
					$this->gifs[$this->gif_count]['disposal_method'] = ord($data[0]);
					$this->gifs[$this->gif_count]['user_input_flag'] = ord($data[1]);
					$this->gifs[$this->gif_count]['delay_time']	  = unpack('n', substr($data, 2, 2));
					++$this->gif_count;
				break;
				case 'gIFx':
					if(!isset($this->extenstions)){
						$this->extensions = array();
						$this->extension_count = 0;
					}
					$this->extensions[$this->extension_count]['application_identifier'] = substr($data, 0, 8);
					$this->extensions[$this->extension_count]['authentication_code']	= substr($data, 8, 3);
					$this->extensions[$this->extension_count]['application_data']	   = substr($data, 11);
					++$this->extension_count;
				break;
				case 'IDAT':
					if($this->compression_method == 'zlib')
						if(isset($this->iphone) && $this->iphone)
							$this->data .= $data;
						else
							$this->data .= gzuncompress($data);
					else
						$this->data .= $data;
				break;
				case 'IEND':
				break 2;
			}
		}
		$offset = 0;
		if($this->color_alpha)
			for($y = 0; $y < $this->height; ++$y){
				$this->pixels[$y] = array();
				++$offset;
				for($x = 0; $x < $this->width; ++$x){
					$this->pixels[$y][$x] = crypt::intbe(substr($this->data, $offset, 3));
					$alpha = 127 - ord($this->data[$offset + 3]);
					$this->pixels[$y][$x] = color::alpha($this->pixels[$y][$x], $alpha < 0 ? $alpha + 256 : $alpha);
					$offset += 4;
				}
			}
		else
			for($y = 0; $y < $this->height; ++$y){
				$this->pixels[$y] = array();
				++$offset;
				for($x = 0; $x < $this->width; ++$x){
					$this->pixels[$y][$x] = array_value(unpack('N', substr($this->data, $offset, 3)), 1);
					$offset += 3;
				}
			}
		$this->data = '';
		return true;
	}
	public function make(){
		$file = "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A";
		$data = '';
		if($this->bit_depth)
			foreach($this->pixels as $row){
				$data .= "\0";
				foreach($row as $col){
					$rgb = color::unrgba($col);
					$rgb[3] = $rgb[3] > 127 ? -($rgb[3] - 256 - 127) : -($rgb[3] - 127);
					$data .= pack('N', color::rgba($rgb[0], $rgb[1], $rgb[2], $rgb[3]));
				}
			}
		else
			foreach($this->pixels as $row){
				$data .= "\0";
				foreach($row as $col)
					$data .= color::strbe($col, 3);
			}
		if(isset($this->idat_length))
			$data = str_split($data, max(1, min($this->idat_length, 4228250625)));
		else
			$data = str_split($data, 1677721600);
		foreach(array('IHDR', 'CgBI', 'PLTE', 'tRNS', 'gAMA', 'cHRM', 'cHRM', 'sRGB', 'iCCP', 'tEXt', 'bKGD',
					  'pHYs', 'sBIT', 'sPLT', 'hIST', 'tIME', 'oFFs', 'pCAL', 'sCAL', 'gIFg', 'gIFx', 'IDAT', 'IEND') as $header){
			$content = '';
			switch($header){
				case 'IHDR':
					$content .= pack('N', $this->width);
					$content .= pack('N', $this->height);
					$content .= chr($this->bit_depth);
					$content .= chr($this->color_type);
					$content .= chr($this->compression_method);
					$content .= chr($this->filter_method);
					$content .= chr($this->interlace_method);
				break;
				case 'CgBI':
					if(!isset($this->iphone) || $this->iphone !== true)
						continue 2;
				break;
				case 'PLTE':
					if(!isset($this->palette))continue 2;
					for($i = 0; $i < 256; ++$i){
						$rgb = color::unrgb($this->palette[$i]);
						$content .= chr($rgb[0]) . chr($rgb[1]) . chr($rgb[2]);
					}
				break;
				case 'tRNS':
					switch($this->color_type){
						case 0:
							if(!isset($this->transparent_color_gray))
							   continue 3;
							$content .= pack('n', $this->transparent_color_gray);
						break;
						case 2:
							if(!isset($this->transparent_color_red) ||
							   !isset($this->transparent_color_green) ||
							   !isset($this->transparent_color_blue))
							   continue 3;
							$content .= pack('n', $this->transparent_color_red);
							$content .= pack('n', $this->transparent_color_green);
							$content .= pack('n', $this->transparent_color_blue);
						break;
						case 3:
							if(!isset($this->palette_opacity))
								continue 3;
							for($i = 0; isset($this->palette_opacity[$i]); ++$i)
								$content .= chr($this->palette_opacity[$i]);
						break;
					}
				break;
				case 'gAMA':
					if(!isset($this->gamma))continue 2;
					$content .= crypt::strbe($this->gamma * 100000);
				break;
				case 'cHRM':
					if(!isset($this->white_x) ||
					   !isset($this->white_y) ||
					   !isset($this->red_x) ||
					   !isset($this->red_y) ||
					   !isset($this->green_x) ||
					   !isset($this->green_y) ||
					   !isset($this->blue_x) ||
					   !isset($this->blue_y))continue 2;
					$content .=
						pack('N', $this->white_x * 100000) .
						pack('N', $this->white_y * 100000) .
						pack('N', $this->red_x   * 100000) .
						pack('N', $this->red_y   * 100000) .
						pack('N', $this->green_x * 100000) .
						pack('N', $this->green_y * 100000) .
						pack('N', $this->blue_x  * 100000) .
						pack('N', $this->blue_y  * 100000);
				break;
				case 'sRGB':
					if(!isset($this->reindering_intent))
						continue 2;
					switch($this->reindering_intent){
						case 'Perceptual':
							$content .= pack('N', 0);
						break;
						case 'Relative colorimetric':
							$content .= pack('N', 100000);
						break;
						case 'Saturation':
							$content .= pack('N', 200000);
						break;
						case 'Absolute colorimetric':
							$content .= pack('N', 300000);
					}
				break;
				case 'iCCP':
					if(!isset($this->profile_name) ||
					   !isset($this->compression_method) ||
					   !isset($this->compression_file))continue 2;
					$content .= $this->profile_name . "\0";
					$content .= chr($this->compression_method == 'zlib' ? 0 : $this->compression_method);
					$content .= $this->compression_profile;
				break;
				case 'tEXt':
					foreach($this->comments as $keyword => $comment){
						$content = $keyword . "\0";
						if(isset($comment['language_tag'])){
							$content .= $comment['compression'] === false ? "\0\0" : "\1" . ord($comment['compression']);
							$content .= $comment['language_tag'] . "\0" . $comment['translated_keyword'] . "\0";
							$content .= $comment['compression'] === 0 ? gzcompress($comment['text'], 9) : $comment['text'];
							$header = 'iEXt';
						}elseif(isset($comment['compression'])){
							$context .= chr($comment['compression']);
							$content .= $comment['compression'] === 0 ? gzcompress($comment['text']) : $comment['text'];
							$header = 'zEXt';
						}else{
							$comment .= $comment['text'];
							$header = 'tEXt';
						}
						$file .= pack('N', strlen($content)) . $header . $content . crypt::hash('crc32', $content, true);
					}
				continue 2;
				case 'bKGD':
					switch($this->color_type){
						case 0:
						case 4:
							if(!isset($this->background_gray))continue 3;
							$content .= pack('N', $this->background_gray);
						break;
						case 2:
						case 6:
							if(!isset($this->background_red) ||
							   !isset($this->background_green) ||
							   !isset($this->background_blue))continue 3;
							$content .= pack('N', $this->background_red);
							$content .= pack('N', $this->background_green);
							$content .= pack('N', $this->background_blue);
						break;
						case 3:
							if(!isset($this->background_index))
								continue 3;
							$content .= pack('N', $this->background_index);
					}
				break;
				case 'pHYs':
					if(!isset($this->pixels_per_unit_x) ||
					   !isset($this->pixels_per_unit_y) ||
					   !isset($this->unit))continue 2;
					switch($this->unit){
						case 'unknown': $unit = 0; break;
						case 'meter'  : $unit = 1; break;
						default	   : $unit = $this->unit; break;
					}
					$content .= pack('N', $this->pixels_per_unit_x);
					$content .= pack('N', $this->pixels_per_unit_y);
					$content .= chr($unit);
				break;
				case 'sBIT':
					switch($this->color_type){
						case 0:
							if(!isset($this->significant_bits_gray))
								continue 3;
							$content .= chr($this->significant_bits_gray);
						break;
						case 2:
						case 3:
							if(!isset($this->significant_bits_red) ||
							   !isset($this->significant_bits_green) ||
							   !isset($this->significant_bits_blue))continue 3;
							$content .= chr($this->significant_bits_red);
							$content .= chr($this->significant_bits_green);
							$content .= chr($this->significant_bits_blue);
						break;
						case 4:
							if(!isset($this->significant_bits_gray) ||
							   !isset($this->significant_bits_alpha))continue 3;
								$content .= chr($this->significant_bits_gray);
								$content .= chr($this->significant_bits_alpha);
						break;
						case 6:
							if(!isset($this->significant_bits_red) ||
							   !isset($this->significant_bits_green) ||
							   !isset($this->significant_bits_blue) ||
							   !isset($this->significant_bits_alpha))continue 3;
							$content .= chr($this->significant_bits_red);
							$content .= chr($this->significant_bits_green);
							$content .= chr($this->significant_bits_blue);
							$content .= chr($this->significant_bits_alpha);
						break;
					}
				break;
				case 'sPLT':
					if(!isset($this->palette_name) ||
					   !isset($this->sample_depth_bits) ||
					   !isset($this->sample_depth_bytes) ||
					   !isset($this->suggested_palette))continue 2;
					$content .= $this->palette_name . "\0";
					$content .= chr($this->sample_depth_bits);
					$count = count($this->suggested_palette['red']);
					for($i = 0; $i < $count; ++$i){
						$content .= crypt::strbe($this->suggested_palette['red'][$i]  , $this->sample_depth_bytes);
						$content .= crypt::strbe($this->suggested_palette['green'][$i], $this->sample_depth_bytes);
						$content .= crypt::strbe($this->suggested_palette['blue'][$i] , $this->sample_depth_bytes);
						$content .= crypt::strbe($this->suggested_palette['alpha'][$i], $this->sample_depth_bytes);
					}
				break;
				case 'tIME':
					if(isset($this->update_last_modification) && $this->update_last_modification === true)
						$this->last_modification = gmmktime(gmdate("H"), gmdate("i"), gmdate("s"), gmdate("n"), gmdate("j"), gmdate("Y"));
					if(!isset($this->last_modification))continue 2;
					$last_modification = getdate($this->last_modification);
					$this->last_modification = gmmktime(
						ord($data[4]),
						ord($data[5]),
						ord($data[6]),
						ord($data[2]),
						ord($data[3]),
						array_key(unpack('n', substr($data, 0, 2)), 1)
					);
					$content .= pack('n', $last_modification['year']);
					$content .= chr($last_modification['mon']);
					$content .= chr($last_modification['mday']);
					$content .= chr($last_modification['hours']);
					$content .= chr($last_modification['minutes']);
					$content .= chr($last_modification['seconds']);
				break;
				case 'oFFs':
					if(!isset($this->position_x) ||
					   !isset($this->position_y) ||
					   !isset($this->offset_unit))continue 2;
					switch($this->offset_unit){
						case 'unknown': $unit = 0; break;
						case 'meter':   $unit = 1; break;
						default:		$unit = $this->offset_unit; break;
					}
					$content .= crypt::strbe($this->position_x, 4, false, true);
					$content .= crypt::strbe($this->position_y, 4, false, true);
					$content .= chr($unit);
				break;
				case 'pCAL':
					if(!isset($this->calibration_name) ||
					   !isset($this->original_zero) ||
					   !isset($this->original_max) ||
					   !isset($this->equation_type) ||
					   !isset($this->parameter_count) ||
					   !isset($this->parameters))continue 2;
					$content .= $calibration_name . "\0";
					$content .= crypt::strbe($this->original_zero, 4, false, true);
					$content .= crypt::strbe($this->original_max , 4, false, true);
					switch($this->equation_type){
						case 'Linear mapping':
							$equation_type = 0;
						break;
						case 'Base-e exponential mapping':
							$equation_type = 1;
						break;
						case 'Arbitrary-base exponential mapping':
							$equation_type = 2;
						break;
						case 'Hyperbolic mapping':
							$equation_type = 3;
					}
					$content .= chr($equation_type);
					$content .= chr($this->parameter_count);
					$content .= implode("\0", $this->parameters);
				break;
				case 'sCAL':
					if(!isset($this->scale_unit) ||
					   !isset($this->pixel_width) ||
					   !isset($this->pixel_height))continue 2;
					switch($this->scale_unit){
						case 'unknown': $unit = 0; break;
						case 'meter':   $unit = 1; break;
						default:		$unit = $this->scale_unit; break;
					}
					$content .= chr($unit);
					$content .= $this->pixel_width . "\0" . $this->pixel_height;
				break;
				case 'gIFg':
					if(!isset($this->gifs))continue 2;
					foreach($this->gifs as $gif){
						$content = chr($gif['disposal_method']);
						$content.= chr($gif['user_input_flag']);
						$content.= pack('n', $gif['delay_time']);
						$file .= pack('N', strlen($content)) . $header . $content . crypt::hash('crc32', $content, true);
					}
				continue 2;
				case 'gIFx':
					if(!isset($this->extenstions))continue 2;
					foreach($this->extenstions as $extenstion){
						$content = $extenstion['application_identifier'];
						$content.= $extenstion['authentication_code'];
						$content.= $extenstion['application_data'];
						$file .= pack('N', strlen($content)) . $header . $content . crypt::hash('crc32', $content, true);
					}
				continue 2;
				case 'IDAT':
					if($this->compression_method == 'zlib' && (!isset($this->iphone) || !$this->iphone))
						foreach($data as $packet){
							$packet = gzcompress($packet, 9);
							$file .= pack('N', strlen($packet)) . $header . $packet . crypt::hash('crc32', $packet, true);
						}
					else
						foreach($data as $packet)
							$file .= pack('N', strlen($packet)) . $header . $packet . crypt::hash('crc32', $packet, true);
				continue 2;
				case 'IEND':
				break;
			}
			$file .= pack('N', strlen($content)) . $header . $content . crypt::hash('crc32', $content, true);
		}
		return $file;
	}
}
class XNBigGraphicPNG {
	const E_NONE = 0;
	const E_INVALID_HEADER = 1;
	const E_INVALID_FILE = 2;

	public $error = 0,
		   $width = 0,
		   $height = 0,
		   $comments = array(),
		   $pixels;

	public function parse($file){
		$this->error = self::E_NONE;
		if(!is_resource($file)){
			$file = @fopen($file, 'r');
			if($file === false)
				return $this->error = self::E_INVALID_FILE;
		}else rewind($file);
		$this->pixels = tmpfile();
		if(fread($file, 8) != "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A")
			return $this->error = self::E_INVALID_HEADER;
		$length = stream::size($file, true);
		while(ftell($file) < $length){
			$dlen = array_value(unpack('N', fread($file, 4)), 1);
			$type = fread($file, 4);
			$raw = array_value(unpack('N', $type), 1);
			$data = $dlen !== 0 ? fread($file, $dlen) : '';
			$crc = fread($file, 4);
			switch($type){
				case 'IHDR':
					$this->width  = array_value(unpack('N', substr($data, 0, 4)), 1);
					$this->height = array_value(unpack('N', substr($data, 4, 4)), 1);
					$this->bit_depth = ord($data[8]);
					$this->color_type = ord($data[9]);
					$this->compression_method = ord($data[10]);
					$this->filter_method = ord($data[11]);
					$this->interlace_method = ord($data[12]);
					if($this->compression_method)$this->compression_method = 'zlib';
					$this->color_palette = (bool)($this->color_type & 1);
					$this->true_color = (bool)($this->color_type & 2);
					$this->color_alpha = (bool)($this->color_type & 4);
				break;
				case 'CgBI':
					$this->iphone = true;
				break;
				case 'PLTE':
					$this->palette = array();
					for($i = 0; $i < 256; ++$i){
						$red   = ord($data[$i * 3]);
						$green = ord($data[$i * 3 + 1]);
						$blue  = ord($data[$i * 3 + 2]);
						$this->palette[$i] = color::rgb($red, $green, $blue);
					}
				break;
				case 'tRNS':
					switch($this->color_type){
						case 0:
							$this->transparent_color_gray = array_value(unpack('n', substr($data, 0, 2)), 1);
						break;
						case 2:
							$this->transparent_color_red   = array_value(unpack('n', substr($data, 0, 2)), 1);
							$this->transparent_color_green = array_value(unpack('n', substr($data, 2, 2)), 1);
							$this->transparent_color_blue  = array_value(unpack('n', substr($data, 4, 2)), 1);
						break;
						case 3:
							$this->palette_opacity = array();
							for($i = 0; isset($data[$i]); ++$i)
								$this->palette_opacity[$i] = ord($data[$i]);
					}
				break;
				case 'gAMA':
					$this->gamma = crypt::intbe($data) / 100000;
				break;
				case 'cHRM':
					$this->white_x = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->white_y = array_value(unpack('N', substr($data, 4, 4)), 1) / 100000;
					$this->red_x   = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->red_y   = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->green_x = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->green_y = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->blue_x  = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
					$this->blue_y  = array_value(unpack('N', substr($data, 0, 4)), 1) / 100000;
				break;
				case 'sRGB':
					$this->reindering_intent = array_value(unpack('N', $data), 1);
					switch($this->reindering_intent){
						case 0:
							$this->reindering_intent = 'Perceptual';
						break;
						case 100000:
							$this->reindering_intent = 'Relative colorimetric';
						break;
						case 200000:
							$this->reindering_intent = 'Saturation';
						break;
						case 300000:
							$this->reindering_intent = 'Absolute colorimetric';
					}
				break;
				case 'iCCP':
					list($this->profile_name, $compression) = explode("\0", $data, 2);
					$this->compression_method = ord($compression[0]);
					if($this->compression_method === 0)$this->compression_method = 'zlib';
					$this->compression_profile = substr($compression, 1);
				break;
				case 'tEXt':
					list($keyword, $text) = explode("\0", $data, 2);
					if(!isset($this->comments[$keyword]))$this->comments[$keyword] = array();
					$this->comments[$keyword][] = $text;
				break;
				case 'zTXt':
					list($keyword, $otherdata) = explode("\0", $data, 2);
					$compression = ord($otherdata[0]);
					$text = substr($otherdata, 1);
					if($compression === 0)
						$text = gzuncompress($text);
					if(!isset($this->comments[$keyword]))$this->comments[$keyword] = array();
					$this->comments[$keyword][] = $text;
				break;
				case 'iTXt':
					list($keyword, $otherdata) = explode("\0", $data, 2);
					$compression = $otherdata[0] != "\0";
					$compression_method = ord($otherdata[1]);
					list($language_tag, $translated_keyword, $text) = explode("\0", substr($otherdata, 2), 3);
					if($compression === true && $compression_method === 0)
						$text = gzuncompress($text);
					if(!isset($this->comments[$keyword]))$this->comments[$keyword] = array();
					$this->comments[$keyword][] = array(
						'translated_keyword' => $translated_keyword,
						'language_tag' => $language_tag,
						'content' => $text
					);
				break;
				case 'bKGD':
					switch($this->color_type){
						case 0:
						case 4:
							$this->background_gray = array_value(unpack('N', $data), 1);
						break;
						case 2:
						case 6:
							$this->background_red   = array_value(unpack('N', substr($data, 0, $this->bit_depth)), 1);
							$this->background_green = array_value(unpack('N', substr($data, $this->bit_depth, $this->bit_depth)), 1);
							$this->background_blue  = array_value(unpack('N', substr($data, $this->bit_depth * 2, $this->bit_depth)), 1);
						break;
						case 3:
							$this->background_index = array_value(unpack('N', $data), 1);
					}
				break;
				case 'pHYs':
					$this->pixels_per_unit_x = array_value(unpack('N', substr($data, 0, 4)), 1);
					$this->pixels_per_unit_y = array_value(unpack('N', substr($data, 4, 4)), 1);
					$this->unit = ord($data[8]);
					if($this->unit === 0)$this->unit = 'unknown';
					elseif($this->unit === 1)$this->unit = 'meter';
				break;
				case 'sBIT':
					switch($this->color_type){
						case 0:
							$this->significant_bits_gray = ord($data[0]);
						break;
						case 2:
						case 3:
							$this->significant_bits_red   = ord($data[0]);
							$this->significant_bits_green = ord($data[1]);
							$this->significant_bits_blue  = ord($data[2]);
						break;
						case 4:
							$this->significant_bits_gray  = ord($data[0]);
							$this->significant_bits_alpha = ord($data[1]);
						break;
						case 6:
							$this->significant_bits_red   = ord($data[0]);
							$this->significant_bits_green = ord($data[1]);
							$this->significant_bits_blue  = ord($data[2]);
							$this->significant_bits_alpha = ord($data[3]);
						break;
					}
				break;
				case 'sPLT':
					list($palettename, $otherdata) = explode("\0", $data, 2);
					$this->palette_name = $palettename;
					$this->sample_depth_bits = ord($otherdata[0]);
					$this->sample_depth_bytes = $this->sample_depth_bits / 8;
					$this->suggested_palette = array(
						'red'   => array(),
						'green' => array(),
						'blue'  => array(),
						'alpha' => array()
					);
					for($c = 1; isset($otherdata[$i]);){
						$this->suggested_palette['red'][]   = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
						$this->suggested_palette['green'][] = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
						$this->suggested_palette['blue'][]  = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
						$this->suggested_palette['alpha'][] = crypt::intbe(substr($otherdata, $i, $this->sample_depth_bytes));
						$i += $this->sample_depth_bytes;
					}
				break;
				case 'hIST':
					$this->palette_histogram = array();
					for($c = 0; isset($data[$c]); $c += 2)
						$this->palette_histogram[$c] = array_value(unpack('n', substr($data, $c / 2, 2)), 1);
				break;
				case 'tIME':
					$this->last_modification = gmmktime(
						ord($data[4]),
						ord($data[5]),
						ord($data[6]),
						ord($data[2]),
						ord($data[3]),
						array_key(unpack('n', substr($data, 0, 2)), 1)
					);
				break;
				case 'oFFs':
					$this->position_x = crypt::intbe(substr($data, 0, 4), false, true);
					$this->position_y = crypt::intbe(substr($data, 4, 4), false, true);
					$this->offset_unit = ord($data[8]);
					if($this->offset_unit === 0)$this->offset_unit = 'unknown';
					elseif($this->offset_unit === 1)$this->offset_unit = 'meter';
				break;
				case 'pCAL':
					list($calibrationname, $otherdata) = explode("\0", $data, 2);
					$this->calibration_name = $calibrationname;
					$this->original_zero = crypt::intbe(substr($data, 0, 4), false, true);
					$this->original_max  = crypt::intbe(substr($data, 4, 4), false, true);
					$this->equation_type = ord($data[8]);
					switch($this->equation_type){
						case 0:
							$this->equation_type = 'Linear mapping';
						break;
						case 1:
							$this->equation_type = 'Base-e exponential mapping';
						break;
						case 2:
							$this->equation_type = 'Arbitrary-base exponential mapping';
						break;
						case 3:
							$this->equation_type = 'Hyperbolic mapping';
					}
					$this->parameter_count = ord($data[9]);
					$this->parameters = explode("\0", substr($data, 10));
				break;
				case 'sCAL':
					$this->scale_unit = ord($data[0]);
					if($this->scale_unit === 0)$this->scale_unit = 'unknown';
					elseif($this->scale_unit === 1)$this->scale_unit = 'meter';
					list($this->pixel_width, $this->pixel_height) = explode("\0", substr($data, 1));
				break;
				case 'gIFg':
					if(!isset($this->gifs)){
						$this->gifs = array();
						$this->gif_count = 0;
					}
					$this->gifs[$this->gif_count]['disposal_method'] = ord($data[0]);
					$this->gifs[$this->gif_count]['user_input_flag'] = ord($data[1]);
					$this->gifs[$this->gif_count]['delay_time']	  = unpack('n', substr($data, 2, 2));
					++$this->gif_count;
				break;
				case 'gIFx':
					if(!isset($this->extenstions)){
						$this->extensions = array();
						$this->extension_count = 0;
					}
					$this->extensions[$this->extension_count]['application_identifier'] = substr($data, 0, 8);
					$this->extensions[$this->extension_count]['authentication_code']	= substr($data, 8, 3);
					$this->extensions[$this->extension_count]['application_data']	   = substr($data, 11);
					++$this->extension_count;
				break;
				case 'IDAT':
					if($this->compression_method == 'zlib')
						if(isset($this->iphone) && $this->iphone)
							fwrite($this->pixels, $data);
						else
							fwrite($this->pixels, gzuncompress($data));
					else
						fwrite($this->pixels, $data);
				break;
				case 'IEND':
				break 2;
			}
		}
		fseek($this->pixels, 0);
		return true;
	}
	public function make($file){
		$this->error = self::E_NONE;
		if(!is_resource($file)){
			$file = @fopen($file, 'r');
			if($file === false)
				return $this->error = self::E_INVALID_FILE;
		}else rewind($file);
		fwrite($file, "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A");
	}
}
class XNGraphicArray {
	const E_NONE = 0;
	const E_INVALID_PIXELS = 0;

	public $error = 0,
		   $width = 0,
		   $height = 0,
		   $pixels = array();
	public function parse($array){
		$this->error = self::E_NONE;
		if(!isset($array[0][0]))
			return $this->error = self::E_INVALID_PIXELS;
		$width = count($array[0]);
		$height = count($array);
		foreach($array as $row)
			if(!is_array($row) || count($row) != $width)
				return $this->error = self::E_INVALID_PIXELS;
		$this->width = $width;
		$this->height = $height;
		$this->pixels = $array;
		return true;
	}
	public function make(){
		return $this->pixels;
	}
}

/* ---------- Stream ---------- */
class Stream {
	public static function seek($stream, $index, $curent = null){
		if($curent === true)
			return fseek($stream, $index, SEEK_CUR);
		if($index < 0)
			return fseek($stream, $index + 1, SEEK_END);
		return fseek($stream, $index, SEEK_SET);
	}
	public static function size($stream, $back = null){
		if($back === true){
			$locate = ftell($stream);
			fseek($stream, 0, SEEK_END);
			$size = ftell($stream);
			fseek($stream, $locate);
			return $size;
		}fseek($stream, 0, SEEK_END);
		return ftell($stream);
	}
	public static function eofsize($stream, $back = null){
		if($back === true){
			$locate = ftell($stream);
			fseek($stream, 0, SEEK_END);
			$size = ftell($stream);
			fseek($stream, $locate);
			return $size - $locate;
		}$locate = ftell($stream);
		fseek($stream, 0, SEEK_END);
		return ftell($stream) - $locate;
	}
	public static function hasIndex($stream, $index, $back = null){
		$locate = ftell($stream);
		if($locate > $index)return true;
		if($back === true){
			fseek($stream, 0, SEEK_END);
			$size = ftell($stream);
			fseek($stream, $locate);
			return $size > $index;
		}fseek($stream, 0, SEEK_END);
		return ftell($stream) > $index;
	}
	public static function index($stream, $index, $back = null){
		if($back === true){
			self::seek($stream, $index);
			return fgetc($stream);
		}$locate = ftell($stream);
		self::seek($stream, $index);
		$c = fgetc($stream);
		fseek($stream, $locate);
		return $c;
	}
	public static function slice($stream, $offset, $limit = null, $back = null){
		if($limit === 0)return '';
		if($back === true){
			if($limit === null){
				self::seek($stream, $offset);
				return stream_get_contents($stream);
			}if($limit < 0)
				$limit += self::size($stream) - $offset;
			self::seek($stream, $offset);
			return fread($stream, $limit);
		}$locate = ftell($stream);
		if($limit === null){
			self::seek($stream, $offset);
			$slice = stream_get_contents($stream);
		}else{
			if($limit < 0)
				$limit += self::size($stream) - $offset;
			self::seek($stream, $offset);
			$slice = fread($stream, $limit);
		}fseek($stream, $locate);
		return $slice;
	}
	public static function slicing($stream, $offset, $limit = null, $back = null){
		if($limit !== null && $limit >= $offset)$limit -= $offset;
		return self::slicing($stream, $offset, $limit, $back);
	}
	public static function name($stream){
		return @array_value(stream_get_meta_data($stream), 'uri');
	}
	public static function mode($stream){
		return @array_value(stream_get_meta_data($stream), 'mode');
	}
	public static function pos($stream, $search, $offset = null, $back = null){
		if($search == '')
			return 0;
		if($offset !== null)self::seek($stream, $offset, $back === true);
		$locate = ftell($stream);
		$pos = false;
		$l = strlen($search);
		$read = fread($stream, $l);
		for($i = $locate + $l; !feof($stream); ++$i){
			if($read === $search){
				$pos = $i;break;
			}$read = substr($read, 1) . fgetc($i);
		}
		if($back === true)fseek($stream, $locate);
		return $pos;
	}
	public static function ipos($stream, $search, $offset = null, $back = null){
		if($search == '')
			return 0;
		if($offset !== null)self::seek($stream, $offset, $back === true);
		$search = strtolower($search);
		$locate = ftell($stream);
		$pos = false;
		$l = strlen($search);
		$read = strtolower(fread($stream, $l));
		for($i = $locate + $l; !feof($stream); ++$i){
			if($read === $search){
				$pos = $i;break;
			}$read = substr($read, 1) . strtolower(fgetc($i));
		}
		if($back === true)fseek($stream, $locate);
		return $pos;
	}
	public static function rpos($stream, $search, $offset = null, $back = null){
		if($search == '')
			return 0;
		if($offset !== null)self::seek($stream, $offset, $back === true);
		$locate = ftell($stream);
		$pos = false;
		$l = strlen($search);
		if($l > $locate)return false;
		fseek($stream, -$l, SEEK_CUR);
		$read = fread($stream, $l);
		fseek($stream, -$l - 1, SEEK_CUR);
		for($i = $locate - $l - 1; $i >= 0; ++$i){
			if($read === $search){
				$pos = $i;break;
			}$read = substr($read, 1) . fgetc($i);
			fseek($stream, -2, SEEK_CUR);
		}
		if($back === true)fseek($stream, $locate);
		return $pos;
	}
	public static function ripos($stream, $search, $offset = null, $back = null){
		if($search == '')
			return 0;
		if($offset !== null)self::seek($stream, $offset, $back === true);
		$search = strtolower($search);
		$locate = ftell($stream);
		$pos = false;
		$l = strlen($search);
		if($l > $locate)return false;
		fseek($stream, -$l, SEEK_CUR);
		$read = strtolower(fread($stream, $l));
		fseek($stream, -$l - 1, SEEK_CUR);
		for($i = $locate - $l - 1; $i >= 0; ++$i){
			if($read === $search){
				$pos = $i;break;
			}$read = substr($read, 1) . strtolower(fgetc($i));
			fseek($stream, -2, SEEK_CUR);
		}
		if($back === true)fseek($stream, $locate);
		return $pos;
	}
	public static function read($stream, $limit = null, $back = null){
		if($limit == null){
			if($back === true){
				$locate = ftell($stream);
				$read = stream_get_contents($stream);
				fseek($stream, $locate);
				return $read;
			}return stream_get_contents($stream);
		}if($back === true){
			$locate = ftell($stream);
			$read = fread($stream, $limit);
			fseek($stream, $locate);
			return $read;
		}if($limit < 0)
			$limit += self::size($stream, true);
		return fread($stream, $limit);
	}
	public static function prevread($stream, $limit = null){
		if($limit === null)$limit = ftell($stream);
		fseek($stream, -$limit, SEEK_CUR);
		return fread($stream, $limit);
	}
	public static function next($stream, $smallnexting = null){
		fseek($stream, 1, SEEK_CUR);
		$c = fgetc($stream);
		if($smallnexting === true)
			fseek($stream, -1, SEEK_CUR);
		return $c;
	}
	public static function current($stream, $currecting = null){
		$c = fgetc($stream);
		if($currecting === true)
			fseek($stream, -1, SEEK_CUR);
		return $c;
	}
	public static function prev($stream, $preving = null){
		fseek($stream, -1, SEEK_CUR);
		$c = fgetc($stream);
		if($preving === true)
			fseek($stream, -1, SEEK_CUR);
		return $c;
	}
	public static function first($stream, $back = null){
		if($back === true){
			$locate = ftell($stream);
			fseek($stream, 0);
			$c = fgetc($stream);
			fseek($stream, $locate);
			return $c;
		}fseek($stream, 0);
		$c = fgetc($stream);
		fseek($stream, 0);
		return $c;
	}
	public static function last($stream, $back = null){
		if($back === true){
			$locate = ftell($stream);
			fseek($stream, -1, SEEK_END);
			$c = fgetc($stream);
			fseek($sream, $locate);
			return $c;
		}fseek($stream, -1, SEEK_END);
		return fgetc($stream);
	}
	public static function skip($stream){
		fseek($stream, 1, SEEK_CUR);
	}
	public static function packet($stream, $length = 1, $format = null, $back = null){
		if($length === 0)return 0;
		if($back === true){
			$locate = ftell($stream);
			$read = fread($stream, $length);
			fseek($stream, $locate);
		}else $read = fread($stream, $length);
		if($format === null || $format == 'be')
			return crypt::intbe($read);
		if($format == 'le')
			return crypt::intle($read);
		if($fromat == 'int')
			return math::base_convert($read, 'ascii', 10);
		return unpack($format, $read);
	}
	public static function match($stream, $regex, $flags = 0, $offset = null, $back = null){
		if($back === true)$locate = ftell($stream);
		if($offset !== null)self::seek($stream, $offset);
		do{
			$line = fgets($stream);
			if(preg_match($regex, $line, $match, $flags))break;
		}while(!feof($stream));
		if($back === true)fseek($stream, $locate);
		return !isset($match) || $match === array() ? false : $match;
	}
	public static function match_all($stream, $regex, $flags = 0, $offset = null, $back = null){
		if($back === true)$locate = ftell($stream);
		if($offset !== null)self::seek($stream, $offset);
		$matches = array();
		do{
			$line = fgets($stream);
			if(preg_match($regex, $line, $match, $flags))
				$matches[] = $match;
		}while(!feof($stream));
		if($back === true)fseek($stream, $locate);
		if(!isset($match) || $matches === array())return false;
		return call_user_func_array('array_array_merge', $matches);
	}
	public static function pregpos($stream, $regex, $offset = null, $back = null){
		if($back === true)$locate = ftell($stream);
		if($offset !== null)self::seek($stream, $offset);
		do{
			$line = fgets($stream);
			if(($pos = pregpos($regex, $line)) !== false){
				$pos += ftell($stream) - strlen($line);
				break;
			}
		}while(!feof($stream));
		if($back === true)fseek($stream, $locate);
		return !isset($pos) || $pos === false ? false : $pos;
	}
	public static function delete($stream, $context = null){
		$name = self::name($stream);
		if(!$name)return $name;
		if($context === null)
			unlink($name);
		else
			unlink($name, $context);
	}
	public static function fclone($stream, $mode = null){
		$data = @stream_get_meta_data($stream);
		if(!$data)return false;
		return fopen($data['uri'], $mode === null ? $data['mode'] : $mode);
	}
	public static function reopen($stream, $mode = null){
		$data = @stream_get_meta_data($stream);
		if(!$data)return false;
		fclose($stream);
		return fopen($data['uri'], $mode === null ? $data['mode'] : $mode);
	}
	public static function output(){
		return fopen('php://output', 'w');
	}
	public static function input(){
		return fopen('php://input', 'r');
	}
	public static function canmode($file){
		$file = strtolower($file);
		if($file == 'php://output')return 'w';
		if($file == 'php://input') return 'r';
		if(substr($file, 0, 7) == 'http://' ||
		   substr($file, 0, 8) == 'https://')
			return 'r';
		if(substr($file, 0, 6) == 'ftp://' ||
		   substr($file, 0, 6) == 'php://')return 'rw';
		$mode = '';
		if(is_readable($file))$mode .= 'r';
		if(is_writable($file))$mode .= 'w';
		return $mode;
	}
	public static function copy($from, $to, $offset = null, $length = null, $back = null){
		if($back === true)$locate = ftell($from);
		if($offset !== null)
			self::seek($from, $offset);
		if($length === null)$length = -1;
		elseif($length < 0)$length -= 1;
		$res = stream_copy_to_stream($from, $to, $length);
		if($back === true)fseek($from, $locate);
		return $res;
	}
	public static function forcewrite($stream, $message, $length = null){
		if($length === null)$length = strlen($message);
		$writed = 0;
		while($writed !== $length){
			$writed += $result = fwrite($stream, substr($message, $writed), $length - $writed);
			if($result === false || $result === 0)
				return false;
		}
		return true;
	}
	public static function predict($stream, $predict, $back = null){
		if($back === true){
			$length = strlen($predict);
			$res = fread($stream, $length) == $predict;
			fseek($stream, -$length, SEEK_CUR);
			return $res;
		}return fread($stream, strlen($predict)) == $predict;
	}
	public static function predoned($stream, $predoned){
		$length = strlen($predict);
		fseek($stream, -$length, SEEK_CUR);
		return fread($stream, $length) == $predoned;
	}
	public static function writeln($stream, $content, $length = null){
		if($length === null)
			return fwrite($stream, $content . "\n");
		$res = fwrite($stream, $content, $length);
		return fwrite($stream, "\n", 1) + $res;
	}
	public static function readto($stream, $to = "\n", $length = null, $back = null){
		if($back === true)$locate = ftell($stream);
		if($to == "\n"){
			if($length === null)
				$res = feof($stream) ? substr(fgets($stream), 0, -1) : false;
			else
				$res = feof($stream) ? rtrim(fgets($stream, $length), "\n") : false;
			if($back === true)fseek($stream, $locate);
			return $res;
		}
		$res = '';
		if($length === null){
			while(($c = fgetc($stream)) !== $to && $c !== false)
				$res .= $c;
			if($res === '' && $c === false)return false;
			if($back === true)fseek($stream, $locate);
			return $res;
		}
		while(($c = fgetc($stream)) !== $to && $c !== false && --$length >= 0)
			$res .= $c;
		if($res === '' && $c === false)return false;
		if($back === true)fseek($stream, $locate);
		return $res;
	}
	public static function readrto($stream, $to = "\n", $length = null, $back = null){
		if($back === true)$locate = ftell($stream);
		$res = '';
		if($length === null){
			while(($c = self::prev($stream)) !== $to && $c !== false)
				$res .= $c;
			if($res === '' && $c === false)return false;
			if($back === true)fseek($stream, $locate);
			return $res;
		}
		while(($c = self::prev($stream)) !== $to && $c !== false && --$length >= 0)
			$res .= $c;
		if($res === '' && $c === false)return false;
		if($back === true)fseek($stream, $locate);
		return $res;
	}
	public static function closed($stream){
		return gettype($stream) === 'resource (closed)';
	}
	public static function lseek($stream, $offset, $whence = 0){
		switch($whence){
			case SEEK_SET:
				fseek($stream, 0);
				while($offset --> 0 && !feof($stream))
					fgets($stream);
			break;
			case SEEK_CUR:
				while($offset --> 0 && !feof($stream))
					fgets($stream);
			break;
			case SEEK_END:
				fseek($stream, -1, SEEK_END);
				while($offset --> 0)
					while(true){
						$ch = fgetc($stream);
						fseek($stream, -2, SEEK_CUR);
						if($ch === false)break 2;
						if($ch == "\n")break;
					}
				fseek($stream, 2, SEEK_CUR);
			break;
		}
	}
	public static function wread($stream, $limit = 1, $back = false){
		if($back === true)$locate = ftell($stream);
		$r = '';
		$l = $limit + 1;
		do{
			$r .= $p = stream_get_contents($f);
			if($p !== '')
				$l = $limit;
		}while($p !== '' || --$l >= 0);
		if($back === true)fseek($stream, $locate);
		return $r;
	}
	public static function wait($stream, $limit = 1, $back = true){
		if($back === true)$locate = ftell($stream);
		$free = (int)(apeip::memlimitfree() / 10);
		$l = $limit + 1;
		do{
			$p = stream_get_contents($f, $free);
			if($p !== '')
				$l = $limit;
		}while($p !== '' || --$l >= 0);
		if($back === true)fseek($stream, $locate);
	}
	public static function isseekable($stream, $back = true){
		if($back === true)$locate = ftell($stream);
		ob_start();
		$seek = fseek($stream, -1, SEEK_CUR);
		$content = ob_get_clean();
		if($seek == -1 && $content !== '')
			return false;
		if($back === true)fseek($stream, $locate);
		return true;
	}
	public static function isreadable($stream){
		$data = @stream_get_meta_data($stream);
		if(!$data)return false;
		$uri = strtolower($data['uri']);
		return (
			strpos($data['mode'], 'r') !== false ||
			strpos($data['mode'], 'w+') !== false ||
			strpos($data['mode'], 'a+') !== false ||
			strpos($data['mode'], 'x+') !== false
		) && (
			(is_file($data['uri']) && is_readable($data['uri'])) ||
			(!is_file($data['uri']) && (
				(!self::isseekable($stream, true) && fgetc($stream) !== false) ||
				(fgetc($stream) !== false && fseek($stream, -1, SEEK_CUR) === 0) ||
				$uri == 'php://input' ||
				substr($uri, 0, 4) == 'data'
			))
		);
	}
	public static function iswritable($stream){
		$data = @stream_get_meta_data($stream);
		if(!$data)return false;
		$uri = strtolower($data['uri']);
		return (
			strpos($data['mode'], 'r+') !== false ||
			strpos($data['mode'], 'w') !== false ||
			strpos($data['mode'], 'a') !== false ||
			strpos($data['mode'], 'x') !== false
		) && (
			(is_file($data['uri']) && is_writable($data['uri'])) || 
			(!is_file($data['uri']) &&
				!self::isseekable($stream, true) && fgetc($stream) === false ||
				substr($uri, 0, 4) == 'data'
			)
		);
	}
	public static function compact($reader, $writer){
		$protocol = str_shuffle(str::ALPHBA_NUMBERS_RANGE . '-.');
		stream_wrapper_register($protocol, '__StreamRWCompact');
		$tmp = apeip::$tmp;
		apeip::$tmp = array($reader, $writer);
		$stream = fopen("$protocol://", '');
		stream_wrapper_unregister($protocol);
		apeip::$tmp = $tmp;
		return $stream;
	}
	public static function merge(){
		$streams = func_get_args();
		$protocol = str_shuffle(str::ALPHBA_NUMBERS_RANGE . '-.');
		stream_wrapper_register($protocol, '__StreamsMerge');
		$tmp = apeip::$tmp;
		apeip::$tmp = $streams;
		$stream = fopen("$protocol://", '');
		stream_wrapper_unregister($protocol);
		apeip::$tmp = $tmp;
		return $stream;
	}
}
class __StreamRWCompact {
	protected $reader, $writer;
	public function stream_open(){
		$this->reader = apeip::$tmp[0];
		$this->writer = apeip::$tmp[1];
		return true;
	}
	public function stream_close(){
		fclose($this->reader);
		fclose($this->writer);
	}
	public function stream_eof(){
		return feof($this->reader);
	}
	public function stream_flush(){
		return fflush($this->writer);
	}
	public function stream_lock($operation){
		return flock($this->writer, $operation);
	}
	public function stream_metadata($path, $option, $value){
		$reader = stream_get_meta_data($this->reader);
		$writer = stream_get_meta_data($this->writer);
		$reader['handle'] = $this->reader;
		$writer['handle'] = $this->writer;
		return array(
			'reader' => $reader,
			'writer' => $writer
		);
	}
	public function stream_read($count){
		return fread($this->reader, $count);
	}
	public function stream_seek($offset, $whence = null){
		return fseek($this->reader, $offset, $whence);
	}
	public function stream_set_option($option, $arg1, $arg2){
		return stream_set_option($this->reader, $option, $arg1, $arg2) && stream_set_option($this->writer, $option, $arg1, $arg2);
	}
	public function stream_stat(){
		return array(
			'reader' => fstat($this->reader),
			'writer' => fstat($this->writer)
		);
	}
	public function stream_tell(){
		return ftell($this->reader);
	}
	public function stream_truncate($new_size){
		return ftruncate($this->reader, $new_size);
	}
	public function stream_write($data){
		return fwrite($this->writer, $data);
	}
}
class __StreamsMerge {
	protected $streams;
	public function stream_open(){
		$this->streams = apeip::$tmp;
		return true;
	}
	public function stream_close(){
		foreach($this->streams as $stream)
			fclose($stream);
	}
	public function stream_eof(){
		$eof = true;
		foreach($this->streams as $stream)
			$eof = $eof && feof($stream);
		return $eof;
	}
	public function stream_flush(){
		$res = true;
		foreach($this->streams as $stream)
			$res = $res && fflush($stream);
		return $res;
	}
	public function stream_lock($operation){
		$res = true;
		foreach($this->streams as $stream)
			$res = $res && flock($stream, $operation);
		return $res;
	}
	public function stream_metadata($path, $option, $value){
		$data = array();
		foreach($this->streams as $i => $stream){
			$data[$i] = stream_get_meta_data($stream);
			$data[$i]['handle'] = $stream;
		}
		return $data;
	}
	public function stream_read($count){
		$read = '';
		if($count < 0)
			for($i = 0; isset($this->streams[$i]) && strlen($read) < $count; ++$i)
				$read .= fread($this->streams[$i], $count);
		else
			foreach($this->streams as $stream)
				$read .= fread($stream, $count);
		return $read;
	}
	public function stream_seek($offset, $whence = null){
		$seek = 0;
		foreach($this->streams as $stream)
			$seek += fseek($stream, $offset, $whence);
		return $seek;
	}
	public function stream_set_option($option, $arg1, $arg2){
		$res = true;
		foreach($this->streams as $stream)
			$res = $res && stream_set_option($stream, $option, $arg1, $arg2);
		return $res;
	}
	public function stream_stat(){
		$stat = array();
		foreach($this->streams as $stream)
			$stat[] = fstat($stream);
		return $stat;
	}
	public function stream_tell(){
		$tell = 0;
		foreach($this->streams as $stream)
			$tell += ftell($stream);
		return $tell;
	}
	public function stream_truncate($new_size){
		$res = true;
		foreach($this->streams as $stream)
			$res = $res && ftruncate($this->reader, $new_size);
		return $res;
	}
	public function stream_write($data){
		$l = strlen($data);
		$writed = 0;
		if($data < 0)
			for($i = 0; isset($this->streams[$i]) && $writed < $l; ++$i)
				$writed += fwrite($this->streams[$i], substr($data, $writed, $l - $writed));
		else
			foreach($this->streams as $stream)
				$writed += fwrite($this->streams[$i], $data);
		return $writed;
	}
}

// ---------- Str ---------- //
class Str {
	public static function rtl($str, $shift = 1){
		$l = strlen($str);
		$shift = $shift < 0 ? 1 : $shift % $l;
		return substr($str, $shift, $l - 1) . substr($str, 0, $shift);
	}
	public static function rtr($str, $shift = 1){
		$l = strlen($str);
		$shift = $shift < 0 ? 1 : $shift % $l;
		return substr($str, $l - $shift, $l - 1) . substr($str, 0, $l - $shift);
	}
	public static function shr(&$str, $shift = 1){
		$shr = (string)substr($str, -$shift);
		$str = (string)substr($str, 0, -$shift);
		return $shr;
	}
	public static function shl(&$str, $shift = 1){
		$shl = (string)substr($str, 0, $shift);
		$str = (string)substr($str, $shift);
		return $shl;
	}
	public static function maxchar($string){
		return max(array_keys(count_chars($string)));
	}
	public static function minchar($string){
		return min(array_keys(count_chars($string)));
	}
	public static function usefulldict($string){
		return array_keys(crypt::huffmandict($string));
	}
	public static function range(){
		$chars = func_get_args();
		return range(call_user_func_array(array('str', 'minchar'), $chars),call_user_func_array(array('str', 'maxchar'), $chars));
	}
	public static function toString($str){
		switch(gettype($str)) {
			case "NULL":
				return 'NULL';
			case "boolean":
				if($str)return 'true';
				return 'false';
			case "string":
				return $str;
			case "double":
			case "int":
				return "$str";
			case "array":
			case "object":
				return unce($str);
		}
		new APError("str", "unsupported Type", APError::TYPE, APError::TTHROW);
	}
	public static function toregex($str){
		return str_replace("\Q\E", '', "\Q" . str_replace('\E', '\E\\\E\Q', $str). "\E");
	}
	const NUMBER_RANGE = '0123456789';
	const FLOAT_RANGE = '0123456789.';
	const ROMAN_RANGE = 'MDCLXVI';
	const ALPHBA_RANGE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	const LOWER_RANGE = 'abcdefghijklmnopqrstuvwxyz';
	const UPPER_RANGE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	const FA_ALPHBA_RANGE = 'ابپتثجچحخدذرزژسشصضطظعغفقکگلمنوهی';
	const AR_ALPHBA_RANGE = 'ابتثجحخدذرزسشصضطظعغفقکلمنوهی';
	const SPACE_RANGE = "\n\r\t ";
	const NUL_BYTE = "\0";
	const ASCII_RANGE = "\0\1\2\3\4\5\6\7\x8\x9\xa\xb\xc\xd\xe\xf\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1a\x1b\x1c\x1d\x1e\x1f" . 
		"\x20\x21\x22\x23\x24\x25\x26\x27\x28\x29\x2a\x2b\x2c\x2d\x2e\x2f\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x3a\x3b\x3c\x3d\x3e\x3f" .
		"\x40\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4a\x4b\x4c\x4d\x4e\x4f\x50\x51\x52\x53\x54\x55\x56\x57\x58\x59\x5a\x5b\x5c\x5d\x5e\x5f" .
		"\x60\x61\x62\x63\x64\x65\x66\x67\x68\x69\x6a\x6b\x6c\x6d\x6e\x6f\x70\x71\x72\x73\x74\x75\x76\x77\x78\x79\x7a\x7b\x7c\x7d\x7e\x7f" .
		"\x80\x81\x82\x83\x84\x85\x86\x87\x88\x89\x8a\x8b\x8c\x8d\x8e\x8f\x90\x91\x92\x93\x94\x95\x96\x97\x98\x99\x9a\x9b\x9c\x9d\x9e\x9f" .
		"\xa0\xa1\xa2\xa3\xa4\xa5\xa6\xa7\xa8\xa9\xaa\xab\xac\xad\xae\xaf\xb0\xb1\xb2\xb3\xb4\xb5\xb6\xb7\xb8\xb9\xba\xbb\xbc\xbd\xbe\xbf" .
		"\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf" .
		"\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf7\xf8\xf9\xfa\xfb\xfc\xfd\xfe\xff";
	const BITFLAGS_RANGE = "\0\1\2\4\x8\x10\x20\x40\x80";
	const CONTROL_RANGE = "\0\1\2\3\4\5\6\7\x8\x9\xa\xb\xc\xd\xe\xf\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1a\x1b\x1c\x1d\x1e\x1f\x7f";
	const BLANK_RANGE = " \t";
	const BIN_RANGE = '01';
	const OCT_RANGE = '01234567';
	const DEC_RANGE = '0123456789';
	const HEXA_RANGE = '0123456789abcdefABCDEF';
	const HEX_RANGE  = '0123456789abcdef';
	const HEXU_RANGE = '0123456789ABCDEF';
	const BASE4_RANGE = '0123';
	const BASE64_RANGE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
	const BASE64T_RANGE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
	const BASE64URL_RANGE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
	const BCRYPT64_RANGE = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	const BASE32_RANGE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789=';
	const NSEC3_RANGE = '0123456789abcdefghijklmnopqrstuv=';
	const BASE128_RANGE = '!#$%()*,.0123456789:;=@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_abcdefghijklmnopqrstuvwxyz{|}~¡¢£¤¥¦§¨©ª«¬®¯°±²³´µ¶·¸¹º»¼½¾¿ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎ';
	const URLACCEPT_RANGE = '-.0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
	const ALPHBA_NUMBERS_RANGE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	const WORD_RANGE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
	const GM_USERNAME_RANGE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-_';
	const TG_USERNAME_RANGE = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
	const TG_TOKEN_REGEX = "/[0-9]{4,16}:AA[GFHE][a-zA-Z0-9-_]{32}/";
	const TG_USERNAME_REGEX = "/[a-zA-Z](?:[a-zA-Z0-9]|(?<!_)_){4,31}(?<!_)/";
	const HTML_TAGNAME_REGEX = "/[^ \n\r\t>\"'=]*/";
	const NUMBER_REGEX = "/[0-9]+(?:\.[0-9]+){0,1}|\.[0-9]+|[0-9]+\./";
	const HEX_REGEX = "/[0-9a-fA-F]+/";
	const BINARY_REGEX = "/[01]+/";
	const OCT_REGEX = "/[0-7]+/";
	const DEC_REGEX = "/[0-9]+/";
	const LINK_REGEX = "/(?:[a-zA-Z0-9]+:\/\/){0,1}(?:(?:[^ \n\r\t\.\/\\#?]+\.)*[^ \n\r\t\.\/\\#@?]{1,61}\.[^ \n\r\t\.\/\\#@?]{2,})(?:(?:(?:\/+)[^ \n\r\t\/\\#@?]+)*(?:\/*))(?:\?[^ \n\r\t\/\\#]*){0,1}(?:#[^ \n\r\t\/]*){0,1}/";
	const EMAIL_REGEX = "/(?:[^ \n\r\t\/\\#?@]+)@(?:(?:[^ \n\r\t\.\/\\#?]+\.)*[^ \n\r\t\.\/\\#@?]{1,61}\.[^ \n\r\t\.\/\\#@?]{2,})/";
	const FILENAME_REGEX = "/[^ \n\r\t\/\\#@?]+/";
	const DIRACTORY_REGEX = "/(?:(?:(?:\/+)[^ \n\r\t\/\\#@?]+)*(?:\/*))/";
	const PHP_VAR_REGEX = "/\${1,}[^ \n\r\t~`!@#$%^&*\(\)_\+=-\\\\\[\]\{\}:;\"'\|,\.?\/<>0-9][^ \n\r\t~`!@#$%^&*\(\)_\+=-\\\\\[\]\{\}:;\"'\|,\.?\/<>]*/";
	const PRETTY_CHAR = "\x20\x20\x20\x20";

	public static $ASCII_LIST = array(
		"\x0", "\x1", "\x2", "\x3", "\x4", "\x5", "\x6", "\x7", "\x8", "\x9", "\xa", "\xb", "\xc", "\xd", "\xe", "\xf",
		"\x10","\x11","\x12","\x13","\x14","\x15","\x16","\x17","\x18","\x19","\x1a","\x1b","\x1c","\x1d","\x1e","\x1f",
		"\x20","\x21","\x22","\x23","\x24","\x25","\x26","\x27","\x28","\x29","\x2a","\x2b","\x2c","\x2d","\x2e","\x2f",
		"\x30","\x31","\x32","\x33","\x34","\x35","\x36","\x37","\x38","\x39","\x3a","\x3b","\x3c","\x3d","\x3e","\x3f",
		"\x40","\x41","\x42","\x43","\x44","\x45","\x46","\x47","\x48","\x49","\x4a","\x4b","\x4c","\x4d","\x4e","\x4f",
		"\x50","\x51","\x52","\x53","\x54","\x55","\x56","\x57","\x58","\x59","\x5a","\x5b","\x5c","\x5d","\x5e","\x5f",
		"\x60","\x61","\x62","\x63","\x64","\x65","\x66","\x67","\x68","\x69","\x6a","\x6b","\x6c","\x6d","\x6e","\x6f",
		"\x70","\x71","\x72","\x73","\x74","\x75","\x76","\x77","\x78","\x79","\x7a","\x7b","\x7c","\x7d","\x7e","\x7f",
		"\x80","\x81","\x82","\x83","\x84","\x85","\x86","\x87","\x88","\x89","\x8a","\x8b","\x8c","\x8d","\x8e","\x8f",
		"\x90","\x91","\x92","\x93","\x94","\x95","\x96","\x97","\x98","\x99","\x9a","\x9b","\x9c","\x9d","\x9e","\x9f",
		"\xa0","\xa1","\xa2","\xa3","\xa4","\xa5","\xa6","\xa7","\xa8","\xa9","\xaa","\xab","\xac","\xad","\xae","\xaf",
		"\xb0","\xb1","\xb2","\xb3","\xb4","\xb5","\xb6","\xb7","\xb8","\xb9","\xba","\xbb","\xbc","\xbd","\xbe","\xbf",
		"\xc0","\xc1","\xc2","\xc3","\xc4","\xc5","\xc6","\xc7","\xc8","\xc9","\xca","\xcb","\xcc","\xcd","\xce","\xcf",
		"\xd0","\xd1","\xd2","\xd3","\xd4","\xd5","\xd6","\xd7","\xd8","\xd9","\xda","\xdb","\xdc","\xdd","\xde","\xdf",
		"\xe0","\xe1","\xe2","\xe3","\xe4","\xe5","\xe6","\xe7","\xe8","\xe9","\xea","\xeb","\xec","\xed","\xee","\xef",
		"\xf0","\xf1","\xf2","\xf3","\xf4","\xf5","\xf6","\xf7","\xf8","\xf9","\xfa","\xfb","\xfc","\xfd","\xfe","\xff"
	);

	public static function charinrange($char, $range){
		if($char === '')return false;
		return strpos($range, $char[0]) !== false;
	}
	public static function strinrange($str, $range){
		for($c = 0;isset($str[$c]);++$c)
			if(strpos($range, $str[$c]) === false)
				return false;
		return true;
	}
	public static function getinrange($str, $range){
		$string = '';
		for($c = 0;isset($str[$c]);++$c)
			if(strpos($range, $str[$c]) !== false)
				$string .= $str[$c];
		return $string;
	}
	public static function random($range, $length = 1){
		if($length < 1)$length = 1;
		if(is_string($range))
			$range = str_split($range);
		if(is_object($range))
			$range = (array)$range;
		if(!is_array($range))
			return false;
		$str = '';
		for($i = 0; $i < $length; ++$i)
			$str .= $range[array_rand($range)];
		return $str;
	}

	// calc functions
	public static function xorn($a, $b){
		$al = strlen($a);
		$bl = strlen($b);
		$l = max($al, $bl);
		$n = '';
		for($i = 0; $i < $l; ++$i) {
			if(!isset($a[$i]) || !isset($b[$i]) || $a[$i] != $b[$i])$n.= '1';
			else $n.= '0';
		}
		return $n;
	}
	public static function xor_chars($chars, $string){
		$str = '';
		for($i = 0;isset($chars[$i]);++$i)
			if(strpos($string, $chars[$i]) === false)
				$str .= $chars[$i];
		return $str;
	}
	private static function mequal(&$a, &$b){
		$la = strlen($a);
		$lb = strlen($b);
		if($lb - $la > 0)$a = str_repeat("\0", $lb - $la) . $a;
		if($la - $lb > 0)$b = str_repeat("\0", $la - $lb) . $b;
		return max($la, $lb);
	}
	public static function add($a, $b){
		$c = '';
		$l = self::mequal($a, $b);
		$p = 0;
		while(--$l >= 0){
			$p += ord($a[$l]) + ord($b[$l]);
			$c = chr($p) . $c;
			$p = floor($p / 256);
		}
		if($p != 0)$c = chr($p) . $c;
		$c = ltrim($c, "\0");
		return $c === '' ? "\0" : $c;
	}
	public static function sub($a, $b){
		$c = '';
		$l = self::mequal($a, $b);
		$p = 0;
		while(--$l >= 0){
			$p += ord($a[$l]) - ord($b[$l]);
			$c = chr($p) . $c;
			$p = floor($p / 256);
		}
		if($p != 0)$c = ~(chr(-$p) . $c);
		$c = ltrim($c, "\0");
		return $c === '' ? "\0" : $c;
	}
	public static function mul($a, $b){
		$c = '';
		$l = self::mequal($a, $b);
		$p = 0;
		while(--$l >= 0){
			$p += ord($a[$l]) * ord($b[$l]);
			$c = chr($p) . $c;
			$p = floor($p / 256);
		}
		if($p != 0)$c = chr($p) . $c;
		$c = ltrim($c, "\0");
		return $c === '' ? "\0" : $c;
	}
	public static function divTwo($x, &$d = false){
		for($i = 0; isset($x[$i]); ++$i){
			$h = ord($x[$i]);
			$b = $d ? 128 : 0;
			if($h % 2 == 1)$d = true;
			else $d = false;
			$x[$i] = chr((int)($h / 2) + $b);
		}
		$x = ltrim($x, "\0");
		return $x === '' ? "\0" : $x;
	}
	public static function rand($a, $b){
		self::mequal($a, $b);
		$r = '';
		$e = -1;
		for($i = 0; isset($a[$i]); ++$i)
			if($e == -1){
				$r .= $c = chr(rand(ord($a[$i]), ord($b[$i])));
				if($a[$i] == $b[$i])$e = -1;
				elseif($c == $a[$i])$e = 2;
				elseif($c == $b[$i])$e = 0;
				else $e = 1;
			}elseif($e == 0){
				$r .= $c = chr(rand(0, ord($b[$i])));
				if($c == $b[$i])$e = 0;
				else $e = 1;
			}elseif($e == 2){
				$r .= $c = chr(rand(ord($a[$i]), 0xff));
				if($c == $a[$i])$e = 2;
				else $e = 1;
			}else
				$r .= chr(rand(0, 0xff));
		$r = ltrim($r, "\0");
		return $r === '' ? "\0" : $r;
	}

	// split functions
	public static function splitr($string, $length = null){
		if($length === null)return strrev($string);
		return implode('', array_map('strrev', str_split($string, $length)));
	}
	public static function rsplit($string, $length = null){
		if($length === null)return $string;
		return implode('', array_reverse(str_split($string, $length)));
	}
	public static function rsplitr($string, $length = null){
		if($length === null)return strrev($string);
		return implode('', array_reverse(array_map('strrev', str_split($string, $length))));
	}
	public static function rea($string){
		for($i = 1; isset($string[$i]); ++$i)
			$string = self::splitr($string, $i);
		return $string;
	}
	public static function unrea($string){
		for($i = strlen($string) - 1; $i > 0; --$i)
			$string = self::splitr($string, $i);
		return $string;
	}
	public static function split($string, $size = 1, $jump = 0, $count = -1){
		if(is_array($size)){
			$split = array();
			$s = 0;
			foreach($size as $n){
				$spl = substr($string, $s, $n);
				if(!$spl)return $split;
				$split[] = $spl;
				$s += $n + $jump;
			}
			if(isset($string[$s]))
				$split[] = substr($string, $s);
			return $split;
		}++$jump;
		if($count == 0)$count = PHP_INT_MAX;
		elseif($count < 0)$count += strlen($string);
		$split = array();
		for($i = 0; isset($string[$i]) && --$count >= 0; $i += $jump)
			$split[] = substr($string, $i, $size);
		if(isset($string[$i]))
			$split[] = substr($string, $i);
		return $split;
	}
	public static function equlen($string1, $string2){
		$l1 = strlen($string1);
		$l2 = strlen($string2);
		return substr(str_repeat($string2, ceil($l1 / $l2)), 0, $l1);
	}
	public static function subrep($string, $length){
		$l = strlen($string);
		return substr(str_repeat($string, ceil($length / $l)), 0, $length);
	}
	
	// replace
	private static function nreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = stripos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function ireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = stripos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function rreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = strrpos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function rireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = strripos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function lreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = stripos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function lireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = stripos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function lrreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = strrpos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function lrireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = strripos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to, $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function creplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = stripos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function cireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = stripos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function crreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = strrpos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function crireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += strlen($string);
		$l = strlen($from);
		$pos = 0;
		do{
			$pos = strripos($string, $from, $pos);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function clreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = stripos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function clireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = stripos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function clrreplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = strrpos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function clrireplace($from, $to, $string, $count = 0){
		if($count < 0)$count += pow(strlen($string), 2);
		$l = strlen($from);
		do{
			$pos = strripos($string, $from);
			if($pos === false)break;
			$string = substr_replace($string, $to($from, $to, $string, $pos), $pos, $l);
		}while(--$count > 0);
		return $string;
	}
	private static function preplace($from, $to, $string, $count = 0){
		return preg_replace($from, $to, $string, $count);
	}
	private static function pcreplace($from, $to, $string, $count = 0){
		return preg_replace_callback($from, function()use($to){
			return $to;
		}, $string, $count);
	}
	private static function cpreplace($from, $to, $string, $count = 0){
		$pos = 0;
		return preg_replace_callback($from, function($match)use($from, $to, $string, &$pos){
			$pos += strpos($string, $match[0], $pos) + strlen($match[0]);
			return $to($match, $from, $string, $pos);
		},$to, $string, $count);
	}
	private static function plreplace($from, $to, $string, $count = 0){
		do{
			$string = preg_replace($from, $to, $prev = $string, $count);
			$count -= $num;
		}while($prev != $string && $count > 0);
		return $string;
	}
	private static function pclreplace($from, $to, $string, $count = 0){
		do{
			$pos = 0;
			$string = preg_replace_callback($from, function($match)use($from, $to, $string, &$pos){
				$pos = strpos($string, $match[0], $pos) + strlen($match[0]);
				return $to($match, $from, $string, $pos);
			}, $prev = $string, $count, $num);
			$count -= $num;
		}while($prev != $string && $count > 0);
		return $string;
	}
	private static function cplreplace($from, $to, $string, $count = 0){
		do{
			$string = preg_replace_callback($from, $to, $prev = $string, -1, $count);
			$count -= $num;
		}while($prev != $string && $count > 0);
		return $string;
	}
	public static function replace($from, $to, $string, $mode = '', $offset = 0, $count = -1){
		if($count == 0)return $string;
		$mode = strtolower($mode);
		$si = is_array($string);
		if($si){
			foreach($string as &$i)
				$i = self::replace($from, $to, $i, $mode, $count);
			return $string;
		}
		$fi = is_array($from);
		$ti = is_array($to);
		if($fi || $ti){
			if($fi && $ti)
				foreach($from as $k => $f){
					if(is_array($f))
						foreach($f as $i)
							$string = self::replace($i, $to[$k], $string, $mode, $count);
					else $string = self::replace($f, $to[$k], $string, $mode, $count);
				}
			elseif($fi)
				foreach($from as $f)
					$string = self::replace($f, $to, $string, $mode, $count);
			else
				foreach($to as $t)
					$string = self::replace($from, $t, $string, $mode, $count);
			return $string;
		}
		$start = substr($string, 0, $offset);
		$string = substr($string, $offset);
		if($string === false)$string = '';
		$func = '';
		if(is_closure($to))
			$func = 'c';
		elseif($mode == '' || $mode == 'd' || strpos($mode, 'n') !== false)
			$func = 'n';
		elseif(strpos($mode, 'h') !== false)
			$func = 'h';
		$d = strpos($mode, 'd') !== false;
		if(($d && $to == '') || (!$d && $from == '')){
			if($d)swap($from, $to, $string);
			$l = strlen($string);
			if($func == 'c'){
				if($count < 0)$count += $l;
				$pos = 0;
				do{
					if(!isset($string[$pos + 1]))break;
					$r = $to($string, ++$pos);
					$string = substr_replace($string, $r, $pos, 0);
					$pos += strlen($r);
				}while(--$count > 0);
				return $start . $string;
			}else{
				if($count < 0)$count += $l - 1;
				$string = str_split($string);
				if($count >= $l)return implode($to, $string);
				return $start . implode($to, array_slice($string, 0, $count)) . $to . implode('', array_slice($string, $count));
			}
		}
		if($func != 'n' && $func != 'h'){
			if(strpos($mode, 'p') !== false){
				$func .= 'p';
				if(strpos($mode, 'c') !== false)$func .= 'c';
				if($func == 'cpc')$func = 'cp';
				if(strpos($mode, 'l') !== false)$func .= 'l';
				if(strpos($mode, 'i') !== false)$from .= 'i';
			}else{
				if(strpos($mode, 'l') !== false)$func .= 'l';
				if(strpos($mode, 'i') !== false)$func .= 'i';
				if(strpos($mode, 'r') !== false)$func .= 'r';
			}
		}
		if($d)swap3($from, $to, $string);
		if($func == 'h')return $start . str_replace($from, $to, $string, $count);
		return $start . call_user_func("str::{$func}replace", $from, $to, $string, $count);
	}

	// indexof
	public static function indexof($string, $search, $mode = '', $offset = 0, $count = 1){
		if($count <= 0)return 0;
		if(strpos($mode, 'r') !== false)$func = 'r';
		else $func = '';
		$mode = strtolower($mode);
		if(is_array($search)){
			$poss = array();
			foreach($search as $i){
				$pos = self::indexof($string, $i, $mode, $offset, $count);
				if($pos !== false)$poss[] = $pos;
			}
			if($poss === array())return false;
			return $func == '' ? min($poss) : max($poss);
		}
		if(strpos($mode, 'p') !== false){
			if(strpos($mode, 'i') !== false)$search .= 'i';
			--$offset;
			do{
				$offset = pregpos($search, $string, $offset + 1);
				if($offset === false)return false;
			}while(--$count > 0);
			return $offset;
		}
		if(strpos($mode, 'i') !== false)$func .= 'i';
		if($mode == '' || $mode == 'i')
			++$offset;
		else --$offset;
		do{
			if($mode == '' || $mode == 'i')
				$offset = call_user_func("str{$func}pos", $string, $search, $offset + 1);
			else
				$offset = call_user_func("str{$func}pos", substr($string, 0, $offset - 1), $search);
			if($offset === false)return false;
		}while(--$count > 0);
		return $offset;
	}

	// explode|implode
	public static function explode($delimiter, $string, $mode = '', $limit = -1){
		if($string === '')return array();
		$mode = strtolower($mode);
		if(is_array($string)){
			$result = array();
			foreach($string as $str)
				$result[] = self::split($delimiter, $str, $mode, $limit);
			return $result;
		}if(is_array($delimiter)){
			if(strpos($mode, 'p') !== false){
				$result = array($string);
				foreach($delimiter as $x){
					if(strpos($mode, 'i') !== false)$x .= 'i';
					foreach($result as &$string)
						$string = self::split($x, $string, 'p', $limit);
					$result = call_user_func_array('array_merge', $result);
				}
				return $result;
			}
			$delimiter = '/' . implode('|', array_map(function($x){
				return preg_quote($x, '/');
			}, $delimiter)) . '/';
			if(strpos($mode, 'i') !== false)
				$delimiter .= 'i';
			return preg_split($delimiter, $string, $limit);
		}
		if(strpos($mode, 'p') !== false){
			if(strpos($mode, 'i') !== false)$delimiter .= 'i';
			return preg_split($delimiter, $string, $limit);
		}
		if(strpos($mode, 'i') !== false)
			$string = str_ireplace($delimiter, strtolower($delimiter), $string);
		return explode($delimiter, $string, $limit < 0 ? PHP_INT_MAX : $limit);
	}
	const IMPLODE_IN = 0;
	const IMPLODE_OUT = 1;
	const IMPLODE_LEFT = 2;
	const IMPLODE_RIGHT = 3;
	public static function implode($glue, $array = '', $count = -1, $option = 0){
		if($array === '')
			return implode('', $glue);
		if($count == 0 || $glue === array())
			return '';
		$string = '';
		--$count;
		if($option == self::IMPLODE_OUT){
			$array[] = '';
			array_unshift($array, '');
		}elseif($option == self::IMPLODE_LEFT)
			array_unshift($array, '');
		elseif($option == self::IMPLODE_RIGHT)
			$array[] = '';
		if(is_callable($glue)){
			$last = array_pop($array);
			if($count < 0)
				foreach($array as $key => $value)
					$string .= $value . $glue($value, $key);
			else{
				$c = 0;
				foreach($array as $key => $value)
					if(++$c <= $count)
						$string .= $value . $glue($value, $key);
					else break;
			}
		}elseif(is_array($glue)){
			$last = array_pop($array);
			$glue = array_values($glue);
			$n = count($glue);
			$c = -1;
			if($count < 0)
				foreach($array as $key => $value)
					$string .= $value . $glue[(++$c) % $n];
			else
				foreach($array as $key => $value)
					if(++$c < $count)
						$string .= $value . $glue[$c % $n];
					else break;
		}elseif($count < 0)
			return implode($glue, $array);
		else
			return implode($glue, array_slice($array, 0, $count + 1));
		return $string . $last;
	}

	public static function pop(&$string, $length = 1){
		if($string === '')return false;
		$l = strlen($string);
		$char = $string[$l - 1];
		$string = substr($string, 0, $l - $length - 1);
		return $char;
	}
	public static function push(&$string){
		$args = func_get_args();
		if(is_array($args[1]))
			$args = $args[1];
		else
			$args = array_slice($args, 1);
		$string .= implode('', $args);
	}
	public static function shift(&$string, $length = 1){
		if($string === '')return false;
		$shift = $string[0];
		$string = substr($string, $length);
		return $shift;
	}
	public static function unshift(&$string){
		$args = func_get_args();
		if(is_array($args[1]))
			$args = $args[1];
		else
			$args = array_slice($args, 1);
		$string = implode('', $args) . $string;
	}
	public static function popat(&$string, $index){
		$pop = $string[$index];
		if(!isset($string[$index]))
			return $pop;
		$string = substr_replace($string, '', $index, 1);
		return $pop;
	}
	public static function insert(&$string, $index, $char = "\0"){
		if($index == 0)$string = $char . $string;
		else $string = substr_replace($string, $char, $index, 0);
	}
	public static function outsert(&$string, $index, $length = null){
		if($length === null){
			$out = substr($string, $index);
			$string = substr_replace($string, '', $index);
			return $out;
		}
		$out = substr($string, $index, $length);
		$string = substr_replace($string, '', $index, $length);
		return $out;
	}

	// printf
	public static function sprintf($format){
		$args = array_slice(func_get_args(), 1);
		do {
			$prev = $format;
			foreach($args as $n => $arg)
				if(is_array($arg)){
					foreach($arg as $key => $value){
						$key = preg_quote($key, '/');
						$key = "/(?<!(?<!\\\\)\\\\)(?:(?<!i)\{{$key}|i(?i)\{{$key})(?<!(?<!\\\\)\\\\)\}/";
						if(is_callable($value))
							$format = preg_replace_callback($key, $value, $format);
						elseif(is_array($value))
							$format = preg_replace_callback($key, function($x)use(&$value){
								if($value === array())return $x[0];
								return array_shift($value);
							}, $format);
						else
							$format = preg_replace_callback($key, function($x)use($value){
								return $value;
							}, $format);
					}
					unset($args[$n]);
				}
			$args = array_values($args);
			$c = count($args);
			$position = -1;
			if($c > 0)
			$format = preg_replace_callback("/(?<!(?<!%)%)%(?:[0-9.]f|[0-9]+(?:d|)|[bcdeEfFgGosuxX+-=])(?:(?<!(?<!%)%)%!|)/", function($x)use(&$position, $args, $c){
				if(substr($x[0], -2) == '%!'){
					$x = substr($x[0], 1, -2);
					$show = false;
				}else{
					$x = substr($x[0], 1);
					$show = true;
				}
				if(is_numeric($x)){
					$position = (int)$x;
					if($show && isset($args[$position]))
						return $args[$position];
					elseif($show){
						$position = $c - 1;
						return "%$x";
					}
				}elseif($x == '='){
					if($show && $position == -1){
						if(isset($args[++$position]))
							return $args[++$position];
					}elseif(isset($args[$position]))
						return $args[$position];
					else return '%=';
				}elseif($x == '+'){
					++$position;
					if($show && isset($args[$position]))
						return $args[$position];
					elseif($show){
						--$position;
						return '%+';
					}
				}elseif($x == '-'){
					--$position;
					if($show && isset($args[$position]))
						return $args[$position];
					elseif($show){
						++$position;
						return '%-';
					}
				}else{
					++$position;
					if($show && isset($args[$position])){
						return sprintf("%$x", $args[$position]);
					}elseif($show){
						--$position;
						return "%$x";
					}
				}
				return '';
			}, $format);
			if(!isset($looped))
				$format = preg_replace_callback("/(?<!(?<!\\\\)\\\\)\+(\{(?:\\\\\{|\\\\\}|(?1)|[^{}])*\})/", function($x)use(&$args){
					$args[] = substr($x[0], 2, -1);
					return '';
				}, $format);
			$looped = null;
		}while(isset($args[$c]));
		$format = preg_replace_callback("/(?<!(?<!%)%)(?:%{[a-zA-Z0-9_]+}|%ENV:[a-zA-Z0-9_]+)/i", function($x){
			if(substr($x[0], 0, 2) == '%{'){
				$env = getenv(substr($x[0], 2, -1));
				if(is_string($env))
					return $env;
			}else
				return getenv(substr($x[0], 5));
			return $x[0];
		}, $format);
		$format = preg_replace("/(?<!(?<!\\\\)\\\\)!(\{(?:\\\\\{|\\\\\}|(?1)|[^{}])*\})/", '', $format);
		$format = preg_replace_callback("/(?<!(?<!\\\\)\\\\)#(\{(?:\\\\\{|\\\\\}|(?1)|[^{}])*\})/", function($x){
			$x = substr($x[0], 2, -1);
			if(is_callable($x))
				return $x();
			return eval("return $x;");
		}, $format);
		return str_replace(array('%%', '\{', '\}', '\#{', '\+{', '\!{', '\i{'), array('%', '{', '}', '#{', '+{', '!{', 'i{'), $format);
	}
	public static function printf($format){
		$format = call_user_func_array('str::sprintf', func_get_args());
		print $format;
		return $format;
	}
	public static function fprintf($handle, $format){
		$format = call_user_func_array('str::sprintf', array_slice(func_get_args(), 1));
		return fwrite($handle, $format);
	}
	public static function vsprintf($format, $args){
		$params = array($format, array());
		$c = 0;
		foreach($args as $k => $arg)
			if($k == $c){
				++$c;
				$params[] = $arg;
			}else
				$params[1][$k] = $arg;
		return call_user_func_array('str::sprintf', $params);
	}
	public static function vprintf($format, $args){
		$format = self::vsprintf($format, $args);
		print $format;
		return $format;
	}
	public static function vfprintf($handle, $format, $args){
		$format = self::vsprintf($format, $args);
		return fwrite($handle, $format);
	}

	public static function change($string, $arg1, $arg2){
		return strtr($string, array(
			$from => $to,
			$to => $from
		));
	}

	// trim
	public static function trim($string, $mask = " \n\r\t", $flags = '', $count = -1){
		$flags = strtolower($flags);
		$right = strpos($flags, 'r') !== false;
		$left = strpos($flags, 'l') !== false;
		$i = strpos($flags, 'i') !== false;
		if(is_array($string)){
			foreach($string as &$value)
				$value = self::trim($string, $mask, $flags, $count);
			return $string;
		}
		if($count < 0)
			if(!is_array($mask))
				if($i)
					if(($right && $left) || (!$right && !$left))
						return trim($string, strtolower($mask) . strtoupper($mask));
					elseif($right)
						return rtrim($string, strtolower($mask) . strtoupper($mask));
					else
						return ltrim($string, strtolower($mask) . strtoupper($mask));
				else
					if(($right && $left) || (!$right && !$left))
						return trim($string, $mask);
					elseif($right)
						return rtrim($string, $mask);
					else
						return ltrim($string, $mask);
			else
				if(($right && $left) || (!$right && !$left))
					if(!$i)
						foreach($mask as $msk){
							$l = strlen($msk);
							while(substr($string, 0, $l) == $msk)
								$string = substr($string, $l);
							while(substr($string, -$l) == $msk)
								$string = substr($string, 0, -$l);
						}
					else
						foreach($mask as $msk){
							$l = strlen($msk);
							$msk = strtolower($msk);
							while(strtolower(substr($string, 0, $l)) == $msk)
								$string = substr($string, $l);
							while(strtolower(substr($string, -$l)) == $msk)
								$string = substr($string, 0, -$l);
						}
				elseif($right)
					if(!$i)
						foreach($mask as $msk){
							$l = strlen($msk);
							while(substr($string, -$l) == $msk)
								$string = substr($string, 0, -$l);
						}
					else
						foreach($mask as $msk){
							$l = strlen($msk);
							$msk = strtolower($msk);
							while(strtolower(substr($string, -$l)) == $msk)
								$string = substr($string, 0, -$l);
						}
				else
					if(!$i)
						foreach($mask as $msk){
							$l = strlen($msk);
							while(substr($string, 0, $l) == $msk)
								$string = substr($string, $l);
						}
					else
						foreach($mask as $msk){
							$l = strlen($msk);
							$msk = strtolower($msk);
							while(strtolower(substr($string, 0, $l)) == $msk)
								$string = substr($string, $l);
						}
		else
			if(is_array($mask))
				if(($right && $left) || (!$right && !$left))
					if(!$i)
						for($i = 0; $i < $count && isset($mask[$i]); ++$i){
							$l = strlen($mask[$i]);
							while(substr($string, 0, $l) == $mask[$i])
								$string = substr($string, $l);
							while(substr($string, -$l) == $mask[$i])
								$string = substr($string, 0, -$l);
						}
					else
						for($i = 0; $i < $count && isset($mask[$i]); ++$i){
							$l = strlen($mask[$i]);
							$mask[$i] = strtolower($mask[$i]);
							while(strtolower(substr($string, 0, $l)) == $mask[$i])
								$string = substr($string, $l);
							while(strtolower(substr($string, -$l)) == $mask[$i])
								$string = substr($string, 0, -$l);
						}
				elseif($right)
					if(!$i)
						for($i = 0; $i < $count && isset($mask[$i]); ++$i){
							$l = strlen($mask[$i]);
							while(substr($string, -$l) == $mask[$i])
								$string = substr($string, 0, -$l);
						}
					else
						for($i = 0; $i < $count && isset($mask[$i]); ++$i){
							$l = strlen($mask[$i]);
							$mask[$i] = strtolower($mask[$i]);
							while(strtolower(substr($string, -$l)) == $mask[$i])
								$string = substr($string, 0, -$l);
						}
				else
					if(!$i)
						for($i = 0; $i < $count && isset($mask[$i]); ++$i){
							$l = strlen($mask[$i]);
							while(substr($string, 0, $l) == $mask[$i])
								$string = substr($string, $l);
						}
					else
						for($i = 0; $i < $count && isset($mask[$i]); ++$i){
							$l = strlen($mask[$i]);
							$mask[$i] = strtolower($mask[$i]);
							while(strtolower(substr($string, 0, $l)) == $mask[$i])
								$string = substr($string, $l);
						}
	}
}

// ---------- Arr ---------- //
class Arr {
	public static function repeat($array, $count = 1){
		if($count <= 0)return array();
		$array = (array)$array;
		if($count == 1)return $array;
		if($count == 2)return array_merge($array, $array);
		if($count == 3)return array_merge($array, $array, $array);
		if($count % 2 == 1)
			return array_merge(self::repeat(array_merge($array, $array), ($count - 1) / 2), $array);
		else
			return self::repeat(array_merge($array, $array), $count / 2);
	}
	public static function equlen($array1, $array2){
		$l1 = count($array1);
		$l2 = count($array2);
		return array_slice(self::repeat($array2, ceil($l1 / $l2)), 0, $l1);
	}
	public static function subrep($array, $length){
		$l = count($array);
		return array_slice(self::repeat($array, ceil($length / $l)), 0, $length);
	}
	public static function slice_replace($array, $offset, $length = null){
		$replace = array_slice(func_get_args(), 3);
		if($length === null || $length === true || $length === false)
			return array_merge(array_slice($array, 0, $offset), $replace);
		return array_merge(array_slice($array, 0, $offset), $replace, array_slice($array, $offset + $length));
	}
	public static function value2key($array){
		return array_combine($array, array_keys($array));
	}
	public static function valuemap($func){
		$args = array_slice(func_get_args(), 1);
		if(!isset($args[0]))return;
		if(!is_array($args[0]))
			return call_user_func_array($func, $args);
		array_unshift($args, $func);
		return call_user_func_array('array_map', $args);
	}
	public static function valuemapall($func){
		$args = array_slice(func_get_args(), 1);
		if(!isset($args[0]))return;
		if(!is_array($args[0]))
			return call_user_func_array($func, $args);
		return array_map(function()use($func){
			$args = func_get_args();
			array_unshift($args, $func);
			return call_user_func_array('arr::mapall', $args);
		});
	}
	public static function keymap($func){
		$args = array_slice(func_get_args(), 1);
		if(!isset($args[0]))return;
		if(!is_array($args[0]))
			return call_user_func_array($func, $args);
		$keys = array();
		for($i = 0; isset($args[$i]); ++$i)
			if(is_array($args[$i]))
				$keys[] = array_keys($args[$i]);
			else $keys[] = $args[$i];
		array_unshift($keys, $func);
		$keys = call_user_func_array('array_map', $keys);
		$res = array();
		for($i = 0; isset($keys[$i]); ++$i)
			if(is_array($args[$i]))
				$res[$keys[$i]] = $args[$i];
			else
				$res[] = $keys[$i];
		return $res;
	}
	public static function keymapall($func){
		$args = array_slice(func_get_args(), 1);
		if(!isset($args[0]))return;
		if(!is_array($args[0]))
			return call_user_func_array($func, $args);
		return self::keymap(function()use($func){
			$args = func_get_args();
			array_unshift($args, $func);
			return call_user_func_array('arr::mapall', $args);
		});
	}
	public static function map($func){
		$args = array_slice(func_get_args(), 1);
		if(!isset($args[0]))return;
		if(!is_array($args[0]))
			return call_user_func_array($func, $args);
		$keys = array();
		for($i = 0; isset($args[$i]); ++$i)
			if(is_array($args[$i]))
				$keys[] = self::keyvalue($args[$i]);
			else $keys[] = $args[$i];
		array_unshift($keys, $func);
		$keys = call_user_func_array('array_map', $keys);
		$res = array();
		for($i = 0; isset($keys[$i]); ++$i)
			if(is_array($args[$i]))
				$res[$keys[$i][0]] = $keys[$i][1];
			else
				$res[] = $keys[$i];
		return $res;
	}
	public static function mapall($func){
		$args = array_slice(func_get_args(), 1);
		if(!isset($args[0]))return;
		if(!is_array($args[0]))
			return call_user_func_array($func, $args);
		return self::map(function()use($func){
			$args = func_get_args();
			array_unshift($args, $func);
			return call_user_func_array('arr::mapall', $args);
		});
	}
	public static function copy($array){
		return (array)(object)$array;
	}
	public static function settype(&$array, $type){
		foreach($array as &$x)
			settype($x, $type);
	}
	public static function map_add($array, $add = 1){
		if(is_array($add))
			return array_map(function($x, $y){
				return $x + $y;
			}, $array, $add);
		return array_map(function($x)use($add){
			return $x + $add;
		}, $array);
	}
	public static function map_sub($array, $sub = 1){
		if(is_array($sub))
			return array_map(function($x, $y){
				return $x - $y;
			}, $array, $sub);
		return array_map(function($x)use($sub){
			return $x - $sub;
		}, $array);
	}
	public static function map_mul($array, $mul = 2){
		if(is_array($mul))
			return array_map(function($x, $y){
				return $x * $y;
			}, $array, $mul);
		return array_map(function($x)use($mul){
			return $x * $mul;
		}, $array);
	}
	public static function map_neg($array){
		return array_map(function($x){
			return -$x;
		}, $array);
	}
	public static function map_value($array, $value){
		return array_map(function()use($value){
			return $value;
		}, $array);
	}
	public static function map_map($callback, $array, $count = 2){
		$array = self::map_repeat($array, $count);
		return array_map(function()use($callback){
			return call_user_func_array($callback, array_value(func_get_args(), 0));
		}, $array);
	}
	public static function map_combine($array){
		$args = func_get_args();
		$count = count($args);
		if($count < 0)return array_map('array_reverse', call_user_func_array('arr::map_combine', $args));
		if($count == 1)return array_map(function($x){
			return array($x);
		}, $array);
		$last = array(array());
		for($c = 0; $c < $count; ++$c){
			$map = array();
			for($i = 0; isset($last[$i]); ++$i)
				for($j = 0; isset($args[$c][$j]); ++$j)
					$map[] = array_merge($last[$i], array($args[$c][$j]));
			$last = $map;
		}
		return $last;
	}
	public static function map_repeat($array, $count = 2){
		if($count < 0)return array_map('array_reverse', self::map_repeat($array, -$count));
		if($count == 0)return array_map(function($x){
			return array();
		}, $array);
		$array = $last = array_map(function($x){
			return array($x);
		}, $array);
		if($count == 1)return $last;
		for($c = 1; $c < $count; ++$c){
			$map = array();
			for($i = 0; isset($last[$i]); ++$i)
				for($j = 0; isset($array[$j]); ++$j)
					$map[] = array_merge($last[$i], $array[$j]);
			$last = $map;
		}
		return $last;
	}
	public static function map_combine_unique($array){
		$args = func_get_args();
		$count = count($args);
		if($count < 0)return array_map('array_reverse', call_user_func_array('arr::map_combine_unique', $args));
		if($count == 1)return array_map(function($x){
			return array($x);
		}, $array);
		$last = array(array());
		for($c = 0; $c < $count; ++$c){
			$map = array();
			for($i = 0; isset($last[$i]); ++$i)
				for($j = 0; isset($args[$c][$j]); ++$j)
					if(in_array($args[$c][$j], $last[$i]))
						$map[] = array_merge($last[$i], array($args[$c][$j]));
			$last = $map;
		}
		return $last;
	}
	public static function map_repeat_unique($array, $count = 2){
		if($count < 0)return array_map('array_reverse', self::map_repeat_unique($array, -$count));
		if($count == 0)return array_map(function($x){
			return array();
		}, $array);
		$array = $last = array_map(function($x){
			return array($x);
		}, $array);
		if($count == 1)return $last;
		for($c = 1; $c < $count; ++$c){
			$map = array();
			for($i = 0; isset($last[$i]); ++$i)
				for($j = 0; isset($array[$j]); ++$j)
					if(in_array($array[$j][0], $last[$i]))
						$map[] = array_merge($last[$i], $array[$j]);
			$last = $map;
		}
		return $last;
	}
	public static function oncing($array){
		$res = array();
		foreach($array as $key => $value){
			if(is_array($value))
				foreach($res as $r){
					$b = false;
					foreach($value as $v)
						if(!in_array($v, $r))
							$b = true;
					if($b === false)continue 2;
				}
			$res[$key] = $value;
		}
		return $res;
	}
	public static function matrix_reverse($array){
		array_unshift($array, function(){
			return func_get_args();
		});
		return call_user_func_array('array_map', $array);
	}
	public static function implodeall($glue, $pieces){
		return implode($glue, array_map(function($x)use($glue){
			if(is_array($x))
				return self::implodeall($glue, $x);
			return $x;
		}, $pieces));
	}
	public static function childsup($array){
		return call_user_func_array('array_merge', array_map(function($x){
			if(is_array($x))
				return self::childsup($x);
			return array($x);
		}, $array));
	}
	public static function explodall($string){
		$delimiters = array_slice(func_get_args(), 1);
		$delimiters = '/' . implode('|', array_map(function($x){
			return array_unique($x, '/');
		}, $array)) . '/';
		return preg_split($delimiteres, $string);
	}
	public static function keyat($key, $array){
		return array_value(array_keys($array), $key);
	}
	public static function valueat($key, $value){
		return array_value(array_values($array), $value);
	}
	public static function keyof($key, $array){
		return array_search($key, array_keys($array));
	}
	public static function valueof($value, $array){
		return array_search($value, array_values($array));
	}
	public static function reverse_values($array){
		return array_combine(array_keys($array), array_reverse($array));
	}
	public static function reverse_keys($array){
		return array_combine(array_reverse(array_key($array)), $array);
	}
	public static function reverse_all($array){
		return array_reverse(array_map(function($x){
			if(is_array($x))
				return self::reverse_all($x);
			return $x;
		}, $array));
	}
	public static function keyvalue($array){
		return array_map(function($x, $y){
			return array($x, $y);
		}, array_keys($array), $array);
	}
	public static function one2one($array){
		return $array === array_unique($array);
	}
	public static function func_range($func, $count = 1){
		return array_map($func, range(0, $count));
	}
	public static function out($array, $index){
		if(!isset($array[$index]))
			return $array[$index];
		$res = $array[$index];
		unset($array[$index]);
		return $res;
	}
	public static function popat(&$array, $key){
		$pop = $array[$key];
		if(!isset($array[$key]))
			return $pop;
		unset($array[$key]);
		return $pop;
	}
	public static function insert(&$array, $index, $value){
		if($index == 0)array_unshift($array, $value);
		else $array = array_merge(array_slice($array, 0, $index), array($value), array_slice($array, $index));
	}
	public static function outsert(&$array, $index, $length = null){
		if($length === null){
			$out = array_slice($array, $index);
			$array = array_slice($array, 0, $index);
			return $out;
		}
		$out = array_slice($array, $index, $length);
		$array = array_merge(array_slice($array, 0, $index), array_slice($array, $index + $length));
		return $out;
	}
	public static function shuffle($array){
		shuffle($array);
		return $array;
	}
	public static function object2array($object){
		$object = (array)$object;
		foreach($object as &$x)
			if(is_object($x))
				$x = object2array($x);
		return $object;
	}
	public static function array2object($array){
		$array = (object)$array;
		foreach($array as &$x)
			if(is_array($x))
				$x = array2object($x);
		return $array;
	}
	public static function search($needle, $array, $strict = false){
		$keys = array();
		$key = array_search($needle, $array, $strict);
		if($key !== false)
			$keys[] = array($key);
		foreach($array as $value)
			if(is_array($value))
				$keys[] = self::search($needle, $value, $strict);
		if($keys === array())return array();
		return call_user_func_array('array_merge', $keys);
	}
	public static function andIf($needle, $func){
		foreach($needle as $key => $value)
			if(!$func($value, $key))return false;
		return true;
	}
	public static function orIf($needle, $func){
		foreach($needle as $key => $value)
			if($func($value, $key))return true;
		return false;
	}
}

// ---------- XNDOM ---------- //
/*
class XNDOM {
	public static function getElementsByTagName($dom, $tagname){
		if($dom instanceof DOMDocument || $dom instanceof DOMElement)
			return $dom->getElementsByTagName($tagname);
		new APError('XNDOM::getElementsByTagName', 'not given a DOM Object', APError::WARNING);
		return false;
	}
	public static function getElementsByTagNameNS($dom, $namespaceURI, $localName){
		if($dom instanceof DOMDocument || $dom instanceof DOMElement)
			return $dom->getElementsByTagNameNS($namespaceURI, $localName);
		new APError('XNDOM::getElementsByTagNameNS', 'not given a DOM Object', APError::WARNING);
		return false;
	}
	public static function getElementById($dom, $id){
		if($dom instanceof DOMDocument)
			return $dom->getElementById($id);
		if($dom instanceof DOMElement)
			return $dom->ownerDocument->getElementById($id);
		new APError('XNDOM::getElementById', 'not given a DOM Object', APError::WARNING);
		return false;
	}
	public static function XPathSelectorAll($dom, $query, $registerNodeNS = true){
		if($dom instanceof DOMXPath)
			return $dom->query('//' . $query, null, $registerNodeNS);
		if($dom instanceof DOMDocument){
			$dom = new DOMXPath($dom);
			return $dom->query('//' . $query, null, $registerNodeNS);
		}
		if($dom instanceof DOMElement){
			$xpath = new DOMXPath($dom->ownerDocument);
			return $xpath->query('./' . $query, $dom, $registerNodeNS);
		}
		new APError('XNDOM::XPathSelectorAll', 'not given a DOM Object', APError::WARNING);
		return false;
	}
	public static function XPathSelector($dom, $query, $registerNodeNS = true){
		if(!($dom instanceof DOMXPath || $dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::XPathSelector', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		$list = self::XPathSelectorAll($dom, $query, $registerNodeNS);
		if($list === false)return false;
		if($list->length === 0)return null;
		return $list[0];
	}
	public static function getElementsByAttribute($dom, $attributeName, $value = null){
		if(!($dom instanceof DOMXPath || $dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::getElementsByAttribute', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		if($value === null)
			return self::XPathSelectorAll($dom, "*[@$attributeName]");
		$value = str_replace(array('\\', "'"), array('\\\\', "\\'"), $value);
		return self::XPathSelectorAll($dom, "*[@$attributeName='$value']");
	}
	public static function getElementsByName($dom, $name){
		if(!($dom instanceof DOMXPath || $dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::getElementsByName', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		return self::getElementsByAttribute($dom, 'name', $name);
	}
	public static function getElementsByClassName($dom, $className){
		if(!($dom instanceof DOMXPath || $dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::getElementsByClassName', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		return self::getElementsByAttribute($dom, 'class', $className);
	}
	public static function Element2Document($dom){
		if($dom instanceof DOMElement){
			$document = new DOMDocument;
			$document->appendChild($document->importNode($dom, true));
			return $document;
		}
		new APError('XNDOM::Element2Document', 'not given a DOMElement Object', APError::WARNING);
		return false;
	}
	public static function outerHTML($dom){
		if($dom instanceof DOMDocument)
			return $dom->saveHTML();
		if($dom instanceof DOMElement){
			$document = new DOMDocument;
			$document->appendChild($document->importNode($dom, true));
			return $document->saveHTML();
		}
		new APError('XNDOM::outerHTML', 'not given a DOM Object', APError::WARNING);
		return false;
	}
	public static function innerHTML($dom){
		if(!($dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::innterHTML', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		$outer = self::outerHTML($dom);
		$searcher = preg_replace_callback('/"(?:\\\\\\\\|\\\\"|[^"])*"/', function($x){
			return str_replace(array('<', '>'), '.', $x[0]);
		}, $outer);
		return substr($outer, strpos($searcher, '>') + 1, -(strlen($dom->nodeName) + 4));
	}
	public static function innerText($dom){
		if(!($dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::innterText', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		return $dom->nodeValue;
	}
	public static function NodeList2Array($nodeList){
		if($nodeList instanceof DOMNodeList){
			$array = array();
			foreach($nodeList as $node)
				$array[] = $node;
			return $array;
		}
		new APError('XNDOM::NodeList2Array', 'not given a DOMNodeList Object', APError::WARNING);
		return false;
	}
	public static function getClassList($element){
		if($element instanceof DOMElement){
			$class = $element->getAttribute('class');
			return $class === null ? array() : explode(' ', $class);
		}
		new APError('XNDOM::getClassList', 'not given a DOMElement Object', APError::WARNING);
		return false;
	}
	public static function createHTMLElement($name, $value = ''){
		return in_array($name, array('img', 'meta', 'base', 'link', 'input', 'output', 'br', 'hr')) ? "<$name/>" : "<$name>$value</$name>";
	}
	public static function loadHTML($html, $version = '1.0', $encoding = null){
		if($encoding === null)
			$dom = new DOMDocument($version);
		else
			$dom = new DOMDocument($version, $encoding);
		$dom->loadHTML($html);
		return $dom;
	}
	public static function loadHTMLFile($file, $version = '1.0', $encoding = null){
		if($encoding === null)
			$dom = new DOMDocument($version);
		else
			$dom = new DOMDocument($version, $encoding);
		$dom->loadHTMLFile($file);
		return $dom;
	}
	public static function getHead($dom, $append = false){
		if($dom instanceof DOMDocument){
			$head = $dom->getElementsByTagName('head');
			if($head === null)
				if($append === true){
					$head = $dom->createElement('head');
					$dom->appendChild($head);
					return $head;
				}else return null;
			return $head;
		}
		new APError('XNDOM::getHead', 'not given a DOMDocument Object', APError::WARNING);
		return false;
	}
	public static function getBody($dom, $append = false){
		if($dom instanceof DOMDocument){
			$body = $dom->getElementsByTagName('body');
			if($body === null)
				if($append === true){
					$body = $dom->createElement('body');
					$dom->appendChild($head);
					return $body;
				}else return null;
			return $body;
		}
		new APError('XNDOM::getHead', 'not given a DOMDocument Object', APError::WARNING);
		return false;
	}
	public static function getScriptCodes($dom){
		if(!($dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::getScripts', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		$scripts = self::NodeList2Array($dom->getElementsByTagName('script'));
		foreach($scripts as &$script)
			$script = $script->nodeValue;
		return implode("\n", $scripts);
	}
	public static function getStyleCodes($dom){
		if(!($dom instanceof DOMDocument || $dom instanceof DOMElement)){
			new APError('XNDOM::getScripts', 'not given a DOM Object', APError::WARNING);
			return false;
		}
		$scripts = self::NodeList2Array($dom->getElementsByTagName('style'));
		foreach($scripts as &$script)
			$script = $script->nodeValue;
		return implode("\n", $scripts);
	}
	public static function beautyXML($xml){
		$xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
		$token   = strtok($xml, "\n");
		$result  = '';
		$pad	 = 0; 
		$matches = array();
		while($token !== false){
			if(preg_match('/.+<\/\w[^>]*>$/', $token, $matches))
				$indent = 0;
			elseif(preg_match('/^<\/\w/', $token, $matches)){
				--$pad;
				$indent = 0;
			}elseif(preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches))
				$indent = 1;
			else
				$indent = 0;
			$line	 = str_pad($token, strlen($token) + $pad, ' ', STR_PAD_LEFT);
			$result .= $line . "\n";
			$token   = strtok("\n");
			$pad	+= $indent;
		}
		return $result;
	}
}
*/

// ---------- Net ---------- //
class Net {
	const HEADERS_STRING = 0;
	const HEADERS_LINES = 1;
	const HEADERS_LIST = 2;
	public static function headers_convert($headers, $to = 0){
		if(is_string($headers))
			switch($to){
				case self::HEADERS_STRING:
					return $headers;
				case self::HEADERS_LINES:
					return explode("\r\n", $headers);
				case self::HEADERS_LIST:
					$lines = explode("\r\n", $headers);
					$headers = array();
					foreach($lines as $line){
						if($line === '')continue;
						$line = explode(':', $line, 2);
						$line[0] = rtrim($line[0], ' ');
						$line[1] = ltrim($line[1], ' ');
						$headers[$line[0]] = $line[1];
					}
					return $headers;
				default:
					return self::HEADERS_STRING;
			}
		if(isset($headers[0]) || $headers === array())
			switch($to){
				case self::HEADERS_STRING:
					return implode("\r\n", $headers);
				break;
				case self::HEADERS_LINES:
					return $headers;
				case self::HEADERS_LIST:
					$list = array();
					foreach($lines as $line){
						if($line === '')continue;
						$line = explode(':', $line, 2);
						$line[0] = rtrim($line[0], ' ');
						$line[1] = ltrim($line[1], ' ');
						$list[$line[0]] = $line[1];
					}
					return $list;
				default:
					return self::HEADERS_LINES;
			}
		if(is_array($headers))
			switch($to){
				case self::HEADERS_STRING:
					$lines = array();
					foreach($headers as $key => $header)
						$lines[] = "$key: $header";
					return implode("\r\n", $lines);
				case self::HEADERS_LINES:
					$lines = array();
					foreach($headers as $key => $header)
						$lines[] = "$key: $header";
					return $lines;
				case self::HEADERS_LIST:
					return $headers;
				default:
					return self::HEADERS_LIST;
			}
		new APError('Net headers_convert', 'not available headers', APError::WARNING);
		return false;
	}
	public static function key2header($key){
		return ucwords(strtr(strtolower($key), ' _', '--'), '-');
	}
	public static function makeHeader($key, $value){
		return ucwords(strtr(strtolower($key), ' _', '--'), '-') . ': ' . $value;
	}
	public static function parseHeader($header){
		$header = explode(':', rtrim($header, "\r\n"), 2);
		$header[1] = ltrim($header[1], ' ');
		return $header;
	}
	public static function parseCookie($cookie){
		if(substr($cookie, -1) == ';')
			$cookie = substr($cookie, 0, -1);
		$cookie = explode('; ', $cookie);
		$value = array_shift($cookie);
		$value = explode('=', $value, 2);
		$key = $value[0];
		$value = isset($value[1]) ? $value[1] : null;
		$args = array();
		foreach($cookie as $elemv){
			$elemv = explode('=', $elemv, 2);
			$args[strtolower($elemv[0])] = isset($elemv[1]) ? $elemv[1] : null;
		}
		$res = array('key' => crypt::urldecode($key), 'value' => crypt::urldecode($value));
		if(isset($args['path']))
			$res['path'] = $args['path'];
		if(isset($args['domain']))
			$res['domain'] = $args['domain'];
		if(isset($args['expires']))
			$res['expires'] = strtotime($args['expires']);
		if(isset($args['created']))
			$res['created'] = strtotime($args['created']);
		if(isset($args['samesite']))
			$res['samesite'] = $args['samesite'];
		if(isset($args['secure']))
			$res['secure'] = true;
		else $res['secure'] = false;
		if(isset($args['httponly']))
			$res['httponly'] = true;
		else $res['httponly'] = false;
		return $res;
	}
	public static function parseCookies($cookies){
		$cookies = explode('; ', $cookies);
		$list = array();
		foreach($cookies as $cookie){
			$cookie = explode('=', $cookie, 2);
			$list[crypt::urldecode($cookie[0])] = crypt::urldecode($cookie[1]);
		}
		return $list;
	}
	public static function makeCookie($args){
		if(!isset($args['key']) || !isset($args['value']) || !isset($args['expires']))
			return false;
		$res = crypt::urlencode($args['key']) . '=' . crypt::urlencode($args['value']) . ';';
		if(!isset($args['secure']))$args['secure'] = false;
		if(!isset($args['httponly']))$args['httponly'] = false;
		if(is_numeric($args['expires']))$args['expires'] = date(DATE_COOKIE, $args['expires']);
		$res .= 'Expires=' . $args['expires'] . ';';
		if(isset($args['created']))
			$res .= ' Created=' . $args['created'] . ';';
		if(isset($args['path']))
			$res .= ' Path=' . $args['path'] . ';';
		if(isset($args['domain']))
			$res .= ' Domain=' . $args['domain'] . ';';
		if(isset($args['samesite']))
			$res .= ' SameSite=' . $args['samesite'] . ';';
		if($args['httponly'] === true && $args['secure'] === true)
			$res .= ' Secure; HttpOnly';
		elseif($args['secure'] === true)
			$res .= ' Secure';
		elseif($args['httponly'] === true)
			$res .= ' HttpOnly';
		return $res;
	}
	public static function makeCookies(){
		$args = func_get_args();
		$res = array();
		if(isset($args[0]) && is_array($args[0])){
			$args = $args[0];
			foreach($args as $key => $value)
				$res[] = crypt::urlencode($key) . '=' . crypt::urlencode($value);
		}else
			for($i = 0; isset($args[$i + 1]); $i += 2)
				$res[] = crypt::urlencode($args[$i]) . '=' . crypt::urlencode($args[$i + 1]);
		return implode('; ', $res);
	}
	public static function headerTop($method = 'GET', $path = '/', $httpversion = 'HTTP/1.0'){
		if(is_numeric($httpversion))$httpversion = 'HTTP/' . ((int)$httpversion == $httpversion ? $httpversion . '.0' : $httpversion);
		else $httpversion = strtoupper($httpversion);
		$method = strtoupper($method);
		if(!in_array($method, self::$httpmethods))
			return false;
		return $method . ' ' . str_replace('%2F', '/', crypt::urlencode($path === '' ? '/' : $path)) . ' ' . $httpversion;
	}
	public static function parseHeaderTop($header){
		$header = explode(' ', trim($header, "\r\n\t "), 4);
		if(!isset($header[2]) || isset($header[3]))
			return false;
		$header[1] = crypt::urldecode($header[1]);
		$header[2] = explode('/', $header[2], 3);
		if(!isset($header[2][1]) || isset($header[2][2]) || (float)$header[2][1] == 0 || !in_array($header[0], self::$httpmethods))
			return false;
		return $header;
	}
	public static function perm2str($perm){
		if(strlen($perm) !== 4)
			return false;
		if($perm[0] == '0')$str = '-';
		else $str = 'd';
		$a = (int)$perm[1];
		$b = (int)$perm[2];
		$c = (int)$perm[3];
		$str .= $a & 4 ? 'r' : '-';
		$str .= $a & 2 ? 'w' : '-';
		$str .= $a & 1 ? 'x' : '-';
		$str .= $b & 4 ? 'r' : '-';
		$str .= $b & 2 ? 'w' : '-';
		$str .= $b & 1 ? 'x' : '-';
		$str .= $c & 4 ? 'r' : '-';
		$str .= $c & 2 ? 'w' : '-';
		$str .= $c & 1 ? 'x' : '-';
		return $str;
	}
	public static function str2perm($str){
		if(strlen($str) !== 10)
			return false;
		if($str[0] == '-')$perm = '0';
		else $perm = '1';
		$a = 0;
		$b = 0;
		$c = 0;
		$a |= $str[1] == 'r' ? 4 : 0;
		$a |= $str[2] == 'w' ? 2 : 0;
		$a |= $str[3] == 'x' ? 1 : 0;
		$b |= $str[4] == 'r' ? 4 : 0;
		$b |= $str[5] == 'w' ? 2 : 0;
		$b |= $str[6] == 'x' ? 1 : 0;
		$c |= $str[7] == 'r' ? 4 : 0;
		$c |= $str[8] == 'w' ? 2 : 0;
		$c |= $str[9] == 'x' ? 1 : 0;
		return $perm . $a . $b . $c;
	}

	public static function varaddr_parse($address){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			@eval("\$GLOBALS$address;");
		}catch(Error $e){
			new APError('Net varaddr_parse', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
		return "\$GLOBALS$address";
	}
	public static function varaddr_has($address){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			return @eval("return isset(\$GLOBALS$address);");
		}catch(Error $e){
			new APError('Net varaddr_has', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
	}
	public static function varaddr_set($address, $value){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			@eval("\$GLOBALS$address = \$value;");
		}catch(Error $e){
			new APError('Net varaddr_set', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
	}
	public static function varaddr_get($address){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			return @eval("return \$GLOBALS$address;");
		}catch(Error $e){
			new APError('Net varaddr_get', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
	}
	public static function &varaddr_passed($address){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			@eval("\$result = &\$GLOBALS$address;");
			return $result;
		}catch(Error $e){
			new APError('Net varaddr_passed', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
	}
	public static function varaddr_delete($address){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			@eval("unset(\$GLOBALS$address);");
		}catch(Error $e){
			new APError('Net varaddr_delete', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
	}
	public static function varaddr_code($code, $address){
		if(isset($address[0]) && $address[0] == '$')$address = substr($address, 1);
		$pos = min(strpos($address, '['), strpos($address, '-'));
		$address = "['" . str_replace(array('\\', "'"), array('\\\\', "\\'"), $pos === false ? $address : substr($address, 0, $pos)) .
			"']" . ($pos === false ? '' : substr($address, $pos));
		try{
			@eval("\$GLOBALS$address;");
		}catch(Error $e){
			new APError('Net varaddr_code', "Invalid variable address", APError::WARNING, APError::TTHROW);
		}
		return preg_replace('/(?<!(?<!%)%)%var/', "\$GLOBALS$address", $code);
	}

	const PROTOCOL_EVERY = 1;
	const INFORMATION = 2;
	const LOWER_ARGS = 4;
	const QUERY_URLCODING = 8;
	public static function parseurl($url, $options = 0){
		$info = $parse = array();
		$pos = strpos($url, '#');
		if($pos !== false){
			$parse['fragment'] = substr($url, $pos + 1);
			$url = substr($url, 0, $pos);
		}
		$pos = strpos($url, '?');
		if($pos !== false){
			$parse['query'] = substr($url, $pos + 1);
			$url = substr($url, 0, $pos);
			if($options & self::QUERY_URLCODING)
				$parse['query'] = crypt::urldecode($parse['query']);
		}
		$pos = strpos($url, '://');
		if($pos !== false){
			$parse['scheme'] = substr($url, 0, $pos);
			if((!($options & self::PROTOCOL_EVERY) && ($parse['scheme'] === '' || !str::strinrange($parse['scheme'], str::GM_USERNAME_RANGE . '+'))) ||
				(($options & self::INFORMATION) && in_array(strtolower($parse['scheme']), array('file', 'var')))){
				unset($parse['scheme']);
				$pos = true;
			}
		}
		if($pos !== false && $pos !== true){
			$url = substr($url, $pos + 3);
			$pos = strpos($url, '/');
			if($pos !== false){
				$parse['path'] = substr($url, $pos);
				$url = substr($url, 0, $pos);
			}
			$pos = strpos($url, '@');
			if($pos !== false){
				$parse['user'] = substr($url, 0, $pos);
				$url = substr($url, $pos + 1);
				$pos = strpos($parse['user'], ':');
				if($pos !== false){
					$parse['pass'] = substr($parse['user'], $pos + 1);
					$parse['user'] = substr($parse['user'], 0, $pos);
				}
			}
			$pos = strpos($url, '%');
			if($pos !== false){
				$parse['proxyhost'] = substr($url, 0, $pos);
				$url = substr($url, $pos + 1);
				$pos = strpos($parse['proxyhost'], ':');
				if($pos !== false){
					$parse['proxyport'] = (int)substr($parse['proxyhost'], $pos + 1);
					$parse['proxyhost'] = substr($parse['proxyhost'], 0, $pos);
				}
				$pos = strpos($url, '%');
				if($pos !== false){
					$parse['proxytype'] = substr($url, 0, $pos);
					$url = substr($url, $pos + 1);
					if($parse['proxytype'] == '')
						unset($parse['proxytype']);
				}
			}
			$pos = strrpos($url, ':');
			if($pos !== false){
				$parse['host'] = substr($url, 0, $pos);
				$parse['port'] = (int)substr($url, $pos + 1);
			}else $parse['host'] = $url;
		}elseif($pos === false){
			$pos = strpos($url, ':');
			if($pos !== false){
				$parse['scheme'] = substr($url, 0, $pos);
				$parse['path'] = substr($url, $pos + 1);
			}else $parse['path'] = $url;
		}else
			$parse['path'] = $url;
		if($options & self::LOWER_ARGS){
			if(isset($parse['scheme']))$parse['scheme'] = strtolower($parse['scheme']);
			if(isset($parse['proxyhost']))$parse['proxyhost'] = strtolower($parse['proxyhost']);
			if(isset($parse['host']))$parse['host'] = strtolower($parse['host']);
		}elseif($options & self::INFORMATION && isset($parse['scheme']))
			$parse['scheme'] = strtolower($parse['scheme']);
		if($options & self::INFORMATION){
			if(isset($parse['scheme'])){
				if(isset(self::$protocols[$parse['scheme']])){
					$info['protocol'] = $parse['scheme'];
					if(isset($parse['port']))
						foreach(self::$protocols[$parse['scheme']] as $scheme => $port)
							if(is_array($port)){
								if(in_array($parse['port'], $port))
									$info['scheme'] = $scheme;
							}elseif($port == $parse['port'])
								$info['scheme'] = $scheme;
				}else{
					if(isset(self::$protocols['udp'][$parse['scheme']]))
						$info['protocol'] = 'udp';
					elseif(isset(self::$protocols['tcp'][$parse['scheme']]))
						$info['protocol'] = 'tcp';
					elseif(isset(self::$protocols['ssl'][$parse['scheme']]))
						$info['protocol'] = 'ssl';
					$info['scheme'] = $parse['scheme'];
					if(isset($info['protocol']) && !isset($parse['port'])){
						$parse['port'] = self::$protocols[$info['protocol']][$info['scheme']];
						if(is_array($parse['port']))
							if(is_string($parse['port'][0]))
								$parse['port'] = $parse['port'][1];
							else $parse['port'] = $parse['port'][0];
					}
				}
				if(isset($parse['proxyhost']))$info['proxyhost'] = $parse['proxyhost'];
				if(isset($parse['proxyport']))$info['proxyport'] = $parse['proxyport'];
				if(isset($parse['host']))$info['host'] = $parse['host'];
				if(isset($parse['port']))$info['port'] = $parse['port'];
				if(isset($parse['user']))$info['user'] = $parse['user'];
				if(isset($parse['pass']))$info['pass'] = $parse['pass'];
				if(isset($parse['path']))$info['path'] = $parse['path'];
				if(isset($parse['query']))$info['query'] = $parse['query'];
				if(isset($parse['fragment']))$info['fragment'] = $parse['fragment'];
				return $info;
			}
		}
		if(isset($parse['scheme']))$info['scheme'] = $parse['scheme'];
		if(isset($parse['proxyhost']))$info['proxyhost'] = $parse['proxyhost'];
		if(isset($parse['proxyport']))$info['proxyport'] = $parse['proxyport'];
		if(isset($parse['host']))$info['host'] = $parse['host'];
		if(isset($parse['port']))$info['port'] = $parse['port'];
		if(isset($parse['user']))$info['user'] = $parse['user'];
		if(isset($parse['pass']))$info['pass'] = $parse['pass'];
		if(isset($parse['path']))$info['path'] = $parse['path'];
		if(isset($parse['query']))$info['query'] = $parse['query'];
		if(isset($parse['fragment']))$info['fragment'] = $parse['fragment'];
		return $info;
	}

	public static function isipv4($ip){
		return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
	}
	public static function isipv6($ip){
		return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
	}
	public static function isip($ip){
		return filter_var($ip, FILTER_VALIDATE_IP);
	}
	public static function ipcheck($range, $ip){
		$range = preg_replace('/(?:#|\/\/|>)[^\n|]*|\/\*(?:[^\/]|\/[^*])*\*\//', '|', $range);
		$ranges = preg_split('/[ \n\r\t|]+/i', $range);
		$ipv6 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
		$ip = $ipv6 ? explode(':', $ip) : explode('.', $ip);
		if($ipv6){
			$n = count($ip);
			if($n > 8)return false;
			$s = array_search($ip, '', true);
			if($s !== false){
				$a = array();
				for($i = 0; $i < 9 - $n; ++$i)
					$a[] = 0;
				$ip = array_merge(array_slice($ip, 0, $s), $a, array_slice($ip, $s + 1));
			}
		}
		foreach($ranges as $range){
			if($range === '')continue;
			if($range == '*')return true;
			if($ipv6 && strpos($range, ':') !== false){
				$range = explode(':', $range);
				$c = count($ip);
				if($c > 8)continue;
				$s = array_search($ip, '', true);
				if($s !== false && $c <= 8){
					$a = array();
					for($i = 0; $i < 9 - $c; ++$i)
						$a[] = 0;
					$range = array_merge(array_slice($range, 0, $s), $a, array_slice($range, $s + 1));
				}
				for($i = 0; $i < 8; ++$i){
					if($range[$i] == $ip[$i] || $range[$i] == '*')continue;
					$r = explode(',', str_replace(
						array('%i', '%n', '%0', '%1', '%2', '%3', '%4', '%5', '%6', '%7'),
						array($i, 8, $ip[0], $ip[1], $ip[2], $ip[3], $ip[4], $ip[5], $ip[6], $ip[7])
					, $range[$i]));
					for($c = 0; isset($r[$c]); ++$c){
						if($r[$c] == $ip[$i])continue 2;
						$a = strpos($r[$c], '-');
						$b = strpos($r[$c], '/');
						if($b !== false && $b !== false && $b < $a)
							continue 3;
						elseif($a !== false && $b !== false)
							$v = range((int)substr($r[$c], 0, $a), (int)substr($r[$c], $a + 1, $b - $a - 1), (int)substr($r[$c], $b + 1));
						elseif($a !== false)
							$v = range((int)substr($r[$c], 0, $a), (int)substr($r[$c], $a + 1));
						elseif($b !== false)
							$v = range((int)substr($r[$c], 0, $b), 255, (int)substr($r[$c], $b + 1));
						else continue 3;
						if(in_array($ip[$i], $v))
							continue 2;
						continue 3;
					}
				}
				return true;
			}elseif(!$ipv6){
				$range = explode('.', $range);
				for($i = 0; $i < 4; ++$i){
					if($range[$i] == $ip[$i] || $range[$i] == '*')continue;
					$r = explode(',', str_replace(
						array('%i', '%n', '%0', '%1', '%2', '%3'),
						array($i, 4, $ip[0], $ip[1], $ip[2], $ip[3])
					, $range[$i]));
					for($c = 0; isset($r[$c]); ++$c){
						if($r[$c] == $ip[$i])continue 2;
						$a = strpos($r[$c], '-');
						$b = strpos($r[$c], '/');
						if($b !== false && $b !== false && $b < $a)
							continue 3;
						elseif($a !== false && $b !== false)
							$v = range((int)substr($r[$c], 0, $a), (int)substr($r[$c], $a + 1, $b - $a - 1), (int)substr($r[$c], $b + 1));
						elseif($a !== false)
							$v = range((int)substr($r[$c], 0, $a), (int)substr($r[$c], $a + 1));
						elseif($b !== false)
							$v = range((int)substr($r[$c], 0, $b), 255, (int)substr($r[$c], $b + 1));
						else continue 3;
						if(in_array($ip[$i], $v))
							continue 2;
						continue 3;
					}
				}
				return true;
			}
		}
		return false;
	}

	public static function realpath($path = ''){
		if($path === '')
			return getenv('SCRIPT_NAME');
		$path = file::realpath($path);
		if(strpos($path, PUBLICDIR) !== 0)
			return false;
		$path = substr($path, strlen(PUBLICDIR) - 1);
		if(DIRECTORY_SEPARATOR == '\\')
			return strtr($path, '\\', '/');
		return $path;
	}
	public static function pathfile($path = '', $exists = false){
		if($path === '')
			return getenv('SCRIPT_FILENAME');
		return file::realpath(PUBLICDIR . '/' . $path);
	}
	public static function inpath($file, $path, $exists = false){
		if($exists){
			$file = file::realpath($file, $exists);
			if(!$file)return false;
			$path = file::realpath($file, $exists);
			if(!$file)return false;
		}else{
			$file = file::realpath($file);
			if(!$file)return false;
			$path = file::realpath($file);
			if(!$file)return false;
		}
		$file = rtrim($file, DIRECTORY_SEPARATOR);
		$path = rtrim($path, DIRECTORY_SEPARATOR);
		return stripos($file, $path) === 0;
	}

	const AF_INET = 0;
	const AF_INET6 = 1;
	const SOCK_STREAM = 1;
	const SOCK_DGRAM = 2;
	const SOCK_RAW = 3;
	const SOCK_RDM = 4;
	const SOCK_SEQPACKET = 5;

	const PROTO_IP = 0;
	const PROTO_ICMP = 1;
	const PROTO_TCP = 6;
	const PROTO_UDP = 17;
	const PROTO_RDP = 27;

	public static $transports = array(
		'HOPOPT', 'ICMP', 'IGMP', 'GGP', 'IPv4',
		'ST', 'TCP', 'CBT', 'EGP', 'IGP', 'BBN-RCC-MON',
		'NVP-II', 'PUP', 'ARGUS', 'XNET', 'CHAOS',
		'UDP', 'MUX', 'DCN-MEAS', 'HMP', 'PRM', 'XNS-IDP',
		'TRUNK-1', 'TRUNK-2', 'LEAF-1', 'LEAF-2', 'RDP',
		'IRTP', 'ISO-TP4', 'NETBLT', 'MFE-NSP', 'MERIT-INP',
		'DCCP', '3PC', 'IDPR', 'XTP', 'DDP', 'IDPR-CMTP',
		'TP++', 'IL', 'IPv6', 'SDRP', 'IPv6-Route',
		'IPv6-Frag', 'IDRP', 'RSVP', 'GRE', 'DSR', 'BNA',
		'ESP', 'AH', 'I-NLSP', 'SWIPE', 'NARP', 'MOBILE',
		'TLSP', 'SKIP', 'IPv6-ICMP', 'IPv6-NoNxt', 'IPv6-Opts',
		'', 'CFTP', '', 'SAT-EXPAK', 'KRYPTOLAN', 'RVD', 'IPPC',
		'', 'SAT-MON', 'VISA', 'IPCV', 'CPNX', 'CPHB', 'WSN',
		'PVP', 'BR-SAT-MON', 'SUN-ND', 'WB-MON', 'WB-EXPAK',
		'ISO-IP', 'VMTP', 'SECURE-VMTP', 'VINES', 'TTP',
		'IPTM', 'NSFNET-IGP', 'DGP', 'TCF', 'EIGRP', 'OSPFIGP',
		'Sprite-RPC', 'LARP', 'MTP', 'AX.25', 'IPIP', 'MICP',
		'SCC-SP', 'ETHERIP', 'ENCAP', '', 'GMTP', 'IFMP', 'PNNI',
		'PIM', 'ARIS', 'SCPS', 'QNX', 'A/N', 'IPComp', 'SNP',
		'Compaq-Peer', 'IPX-in-IP', 'VRRP', 'PGM', '', 'L2TP',
		'DDX', 'IATP', 'STP', 'SRP', 'UTI', 'SMP', 'SM', 'PTP',
		'ISIS in IPv4', 'FIRE', 'CRTP', 'CRUDP', 'SSCOPMCE',
		'IPLT', 'SPS', 'PIPE', 'SCTP', 'FC', 'RSVP-E2E-IGNORE',
		'Mobility Header', 'UDPLite', 'MPLS-in-IP', 'manet',
		'HIP', 'Shim6', 'WESP', 'ROHC'
	);
	public static $protocols = array(
		1 => 'TCPMUX',
		5 => '5',
		7 => 'Echo',
		9 => 'Discard',
		11 => 'systat',
		13 => 'Daytime',
		15 => 'netstat',
		17 => 'QOTD',
		18 => 'MessageSend',
		19 => 'CHARGEN',
		20 => 'FTP',
		21 => 'FTP',
		22 => 'SSH',
		23 => 'Telnet',
		25 => 'SMTP',
		37 => 'Time',
		42 => 'NAMESERVER',
		43 => 'WHOIS',
		49 => 'TACACS',
		51 => 'IMP',
		52 => 'XNS',
		53 => 'DNS',
		54 => 'XNS',
		56 => 'XNS',
		58 => 'XNS',
		61 => 'NIFTP',
		67 => 'BOOTP',
		68 => 'BOOTP',
		69 => 'TFTP',
		70 => 'Gopher',
		71 => 'NETRJS',
		72 => 'NETRJS',
		73 => 'NETRJS',
		74 => 'NETRJS',
		79 => 'Finger',
		80 => 'HTTP',
		81 => 'TorPark',
		82 => 'TorPark',
		88 => 'Kerberos',
		90 => 'PointCast',
		101 => 'NIC',
		102 => 'TSAP',
		104 => 'DICOM',
		105 => 'CCSO',
		107 => 'RTelNet',
		108 => 'SNA',
		109 => 'POP2',
		110 => 'POP3',
		111 => 'ONCRPC',
		113 => 'Ident',
		115 => 'SFTP',
		117 => 'UUCP',
		118 => 'SQL',
		119 => 'NNTP',
		123 => 'NTP',
		135 => 'DCE',
		138 => 'NetBIOS',
		139 => 'NetBIOS',
		143 => 'IMAP',
		152 => 'BFTP',
		153 => 'SGMP',
		156 => 'SQL',
		158 => 'DMSP',
		161 => 'SNMP',
		162 => 'SNMPTRAP',
		170 => 'PostScript',
		177 => 'XDMCP',
		179 => 'BGP',
		194 => 'IRC',
		201 => 'AppleTalk',
		209 => 'QMTP',
		210 => 'ANSI',
		213 => 'IPX',
		218 => 'MPP',
		220 => 'IMAP',
		259 => 'ESRO',
		262 => 'Arcisdms',
		264 => 'BGMP',
		280 => 'http-mgmt',
		300 => 'ThinLinc',
		308 => 'Novastor Online Backup',
		311 => 'Mac OS X Server',
		318 => 'TSP',
		319 => 'PTP',
		320 => 'PTP',
		350 => 'MATIP', // A
		351 => 'MATIP', // B
		356 => 'cloanto-net-1',
		366 => 'ODMR',
		369 => 'Rpc2portmap',
		370 => 'codaauth2',
		371 => 'ClearCase',
		383 => 'HP data alarm manager',
		384 => 'A Remote Network Server System',
		387 => 'AURP',
		388 => 'Unidata LDM',
		389 => 'LDAP',
		399 => 'DEC',
		401 => 'UPS',
		427 => 'SLP',
		433 => 'NNSP',
		434 => 'MIP',
		443 => 'HTTPS',
		444 => 'SNPP',
		445 => 'Microsoft-DS',
		464 => 'Kerberos',
		465 => 'SMPTPS',
		475 => 'Aladdin Knowledge Systems',
		491 => 'GO-Global',
		497 => 'Retrospect',
		500 => 'IKE',
		502 => 'Modbus',
		504 => 'Citadel',
		510 => 'FCP',
		512 => 'Rexec',
		513 => 'rlogin',
		514 => 'rsh',
		515 => 'LPD',
		518 => 'NTalk',
		520 => 'RIP',
		521 => 'RIPng',
		524 => 'NCP',
		525 => 'Timeserver',
		530 => 'RPC',
		532 => 'netnews',
		533 => 'netwall',
		540 => 'UUCP',
		542 => 'commerce',
		543 => 'klogin',
		544 => 'kshell',
		546 => 'DHCPv6 client',
		547 => 'DHCPv6 server',
		548 => 'AFP',
		550 => 'new-who',
		554 => 'RTSP',
		556 => 'Remotefs',
		560 => 'rmonitor',
		561 => 'monitor',
		563 => 'NNTPS',
		564 => '9P',
		585 => 'IMAPS',
		587 => 'SMTP',
		591 => 'FileMaker',
		593 => 'HTTP RPC Ep Map',
		601 => 'syslog',
		604 => 'TUNNEL profile',
		623 => 'ASF-RMCP',
		625 => 'ODProxy',
		631 => 'IPP',
		635 => 'RLZ DBase',
		636 => 'LDAPS',
		639 => 'MSDP',
		641 => 'SupportSoft Nexus Remote Command',
		643 => 'SANity',
		646 => 'LDP',
		647 => 'DHCP',
		648 => 'RRP',
		651 => 'IEEE-MMS',
		653 => 'SupportSoft Nexus Remote Command',
		654 => 'MMP',
		655 => 'Tinc VPN daemon',
		657 => 'IBM RMC',
		660 => 'Mac OS X Server',
		666 => 'Doom',
		674 => 'ACAP',
		688 => 'REALM-RUSD',
		690 => 'VATP',
		691 => 'MS Exchange',
		694 => 'Linux-HA',
		695 => 'IEEE-MMS-SSL',
		698 => 'OLSR',
		700 => 'EPP',
		701 => 'LMP',
		702 => 'IRIS',
		706 => 'SILC',
		711 => 'Cisco Tag Distribution',
		712 => 'TBRPF',
		749 => 'Kerberos',
		750 => 'kerberos-iv',
		751 => 'kerberos_master',
		752 => 'passwd_server',
		753 => 'RRH',
		754 => 'tell send',
		760 => 'krbupdate',
		782 => 'Conserver serial-console management server',
		783 => 'SpamAssassin spamd daemon',
		800 => 'mdbs-daemon',
		808 => 'Microsoft Net.TCP Port Sharing Service',
		829 => 'Certificate Management',
		830 => 'NETCONF over SSH',
		831 => 'NETCONF over BEEP',
		832 => 'NETCONF for SOAP over HTTPS',
		833 => 'NETCONF for SOAP over BEEP',
		843 => 'Adobe Flash',
		847 => 'DHCP Failover',
		848 => 'GDOI',
		853 => 'DNS over TLS',
		860 => 'iSCSI',
		861 => 'OWAMP',
		862 => 'TWAMP',
		873 => 'rsync file synchronization',
		888 => 'CDDBP',
		897 => 'Brocade SMI-S RPC',
		898 => 'Brocade SMI-S RPC SSL',
		902 => 'VMware ESXi',
		903 => 'VMware ESXi',
		953 => 'RNDC',
		987 => 'Microsoft Remote Web Workplace',
		989 => 'FTPS',
		990 => 'FTPS',
		991 => 'NAS',
		992 => 'Telnet SSL',
		993 => 'IMAPS',
		994 => 'IRCS',
		995 => 'POP3S',
		1010 => 'ThinLinc',
		1023 => 'NFS'
	);
	public static $httpmethods = array(
		'GET', 'HEAD', 'POST', 'PUT', 'DELETE',
		'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'
	);
	protected static $status = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported',
		226 => 'IM Used',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Switch Proxy',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		419 => 'Authentication Timeout',
		420 => 'Enhance Your Calm',
		420 => 'Method Failure',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		424 => 'Method Failure',
		425 => 'Unordered Collection',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		444 => 'No Response',
		449 => 'Retry With',
		450 => 'Blocked by Windows Parental Controls',
		451 => 'Redirect',
		451 => 'Unavailable For Legal Reasons',
		494 => 'Request Header Too Large',
		495 => 'Cert Error',
		496 => 'No Cert',
		497 => 'HTTP to HTTPS',
		499 => 'Client Closed Request',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',
		509 => 'Bandwidth Limit Exceeded',
		510 => 'Not Extended',
		511 => 'Network Authentication Required',
		598 => 'Network read timeout error',
		599 => 'Network connect timeout error',
	);

	public static function address(){
		$host = getenv('SERVER_NAME');
		return (getenv('SERVER_PORT') == 443 ? 'https' : 'http') . '://' . (net::isipv6($host) ? "[$host]" : $host) . getenv('SCRIPT_NAME');
	}
	public static function origin(){
		$host = getenv('SERVER_NAME');
		return (getenv('SERVER_PORT') == 443 ? 'https' : 'http') . '://' . (net::isipv6($host) ? "[$host]" : $host);
	}
	public static function server(){return getenv('SERVER_NAME') . ':' . getenv('SERVER_PORT');}
	public static function connecter(){return stream::compact(fopen('php://input', 'r'), fopen('php://output', 'w'));}
	public static function sockaddress(){return (getenv('SERVER_PORT') == 443 ? 'tls' : 'tcp') . '://' . getenv('SERVER_NAME') . ':' . getenv('SERVER_PORT') . getenv('SCRIPT_NAME');}
	public static function scheme(){return getenv('SERVER_PORT') == 443 ? 'https' : 'http';}
	public static function protocol(){return getenv('SERVER_PORT') == 443 ? 'tls' : 'tcp';}
	public static function locatocol(){return 'internet';}
	public static function cryptocol(){return getenv('SERVER_PORT') == 443 ? 'SSL' : 'none';}
	public static function port(){return (int)getenv('SERVER_PORT');}
	public static function host(){return getenv('SERVER_NAME');}
	public static function ip(){return gethostbyname(getenv('SERVER_NAME'));}
	public static function addr(){$addr = getenv('SERVER_ADDR');return self::isipv6($addr) ? "[$addr]" : $addr;}
	public static function path(){return getenv('SCRIPT_NAME');}
	public static function httpmethod(){return getenv('REQUEST_METHOD');}
	public static function httpversion(){$version = getenv('SERVER_PROTOCOL');if($version)return (float)substr($version, 5);return 1.0;}
	public static function httpstatuscode(){return http_status_code();}
	public static function httpstatusmsg(){return self::$status[http_response_code()];}
	public static function response_query(){return ob_get_contents();}
	public static function request_query(){return apeip::$query;}
	public static function request_headers($type = 0){
		if(function_exists('apache_request_headers'))
			$header = apache_request_headers();
		else{
			$header = '';
			foreach($_SERVER as $key => $value)
				if(substr($key, 0, 5) == 'HTTP_')
					$header .= self::makeHeader(substr($key, 5), $value) . "\r\n";
		}
		$header = self::headers_convert($header, $type);
		$version = self::httpversion();
		if($type == self::HEADERS_STRING)
			$header = self::httpmethod() . ' ' . self::path() . ' HTTP/' . ((int)$version == $version ? $version . '.0' : $version) . "\r\n" . $header;
		elseif($type == self::HEADERS_LINES)
			array_unshift($header, self::httpmethod() . ' ' . self::path() . ' HTTP/' . ((int)$version == $version ? $version . '.0' : $version));
		return $header;
	}
	public static function response_headers($type = 0){
		if(!function_exists('apache_response_headers'))
			return false;
		$header = apache_response_headers();
		$header = self::headers_convert($header, $type);
		$version = self::httpversion();
		if($type == self::HEADERS_STRING)
			$header = 'HTTP/' . ((int)$version == $version ? $version . '.0' : $version) . ' ' . http_status_code() . ' ' . self::httpstatusmsg() . "\r\n" . $header;
		elseif($type == self::HEADERS_LINES)
			array_unshift($header, 'HTTP/' . ((int)$version == $version ? $version . '.0' : $version) . ' ' . http_status_code() . ' ' . self::httpstatusmsg());
		return $header;
	}
	public static function httprequest(){return self::request_headers(self::HEADERS_STRING) . "\r\n" . apeip::$query;}
	public static function httpresponse(){return self::response_headers(self::HEADERS_STRING) . "\r\n" . ob_get_contents();}

	public static function json_app(){header("Content-Type: application/json");}
	public static function text_app($type = "plain"){header("Content-Type: " . (strpos($type, 'text/') === 0 ? $type : "text/$type"));}
	public static function html_app(){header("Content-Type: text/html");}
	public static function image_app($type = "png"){header("Content-Type: " . (strpos($type, 'image/') === 0 ? $type : "image/$type"));}
	public static function audio_app($type = "mp3"){header("Content-Type: " . (strpos($type, 'audio/') === 0 ? $type : "audio/$type"));}
	public static function doc_app($doc = "exe"){header("Content-Type: " . (strpos($type, 'application/') === 0 ? $type : "application/$type"));}
	public static function video_app($type = "mp4"){header("Content-Type: " . (strpos($type, 'video/') === 0 ? $type : "video/$type"));}
	public static function redirect_app($loc){header("Location: $loc");}
	public static function referesh_app(){header("Location: " . getenv('REQUEST_URI'));}

	public static function dirvar_locate($var){
		$var = explode('/', $var);
		foreach($var as &$index){
			$index = explode('.', $index);
			$index[0] = '[' . unce($index[0]) . ']';
			for($i = 1; isset($index[$i]); ++$i)
				if($index[$i] === '' || strpos(str::DEC_RANGE, $index[$i][0]) !== false || !str::strinrange($index[$i], str::WORD_RANGE))
					$index[0] .= '->{' . unce($index[$i]) . '}';
				else
					$index[0] .= '->' . $index[$i];
			$index = $index[0];
		}
		return implode('', $var);
	}
	public static function dirvar_get($var, &$map = null){
		if($map === null)$map = &$GLOBALS;
		return eval('return $map' . self::dirvar_locate($var) . ';');
	}
	public static function dirvar_has($var, &$map = null){
		if($map === null)$map = &$GLOBALS;
		return eval('return isset($map' . self::dirvar_locate($var) . ');');
	}
	public static function dirval_set($var, $value, &$map = null){
		if($map === null)$map = &$GLOBALS;
		eval('$map' . self::dirvar_locate($var) . ' = $value;');
	}
	public static function dirvar_delete($var, &$map = null){
		if($map === null)$map = &$GLOBALS;
		eval('unset($map' . self::dirvar_locate($var) . ');');
	}
}

/* ---------- file|dir ---------- */
class file {
	public static function read($file, $length = -1, $offset = -1){
		$file = fopen($file, 'r');
		if(!$file)
			return false;
		$read = stream_get_contents($file, $length, $offset);
		fclose($file);
		return $read;
	}
	public static function write($file, $content = ''){
		$file = fopen($file, 'w');
		if(!$file)
			return false;
		$res = fwrite($file, $content);
		fclose($file);
		return $res;
	}
	public static function append($file, $content){
		$file = fopen($file, 'a');
		if(!$file)
			return false;
		$res = fwrite($file, $content);
		fclose($file);
		return $res;
	}
	public static function wait($file, $limit = 1){
		$file = fopen($file, 'r');
		if(!$file)
			return false;
		stream::wait($file, $limit, false);
		$tell = ftell($file);
		fclose($file);
		return $tell;
	}
	public static function merge($file){
		$file = fopen($file, 'a');
		if(!$file)
			return false;
		$files = array_slice(func_get_args(), 1);
		$res = 0;
		foreach($files as $merge){
			$merge = fopen($file, 'r');
			if(!$merge)continue;
			$res += stream_copy_to_stream($file, $merge);
			fclose($merge);
		}
		fclose($file);
		return $res;
	}
	public static function reset($file){
		$file = fopen($file, 'w');
		if(!$file)
			return false;
		ftruncate($file, 0);
		fclose($file);
		return true;
	}
	public static function cmp($file1, $file2){
		$limit = ceil(apeip::memoryout_free() / 20);
		$file1 = fopen($file1, 'r');
		if(!$file1)return false;
		$file2 = fopen($file2, 'r');
		if(!$file2)return false;
		do {
			$read1 = fread($file1, $limit);
			$read2 = fread($file2, $limit);
			if($read1 === $read2)continue;
			$len1 = strlen($read1);
			$len2 = strlen($read2);
			if($len1 < $len2)return -1;
			if($len1 > $len2)return 1;
			return 0;
		}while($read1 !== '');
		return true;
	}

	public static function realpath($path = '', $exists = false){
		if($path === ''){
			$path = getenv('SCRIPT_FILENAME');
			if($path){
				if(DIRECTORY_SEPARATOR == '\\')
					$path = strtr($path, '/', '\\');
				return $path;
			}
			$file = thefile();
			if($exists)
				return file_exists($file) ? $file : false;
			return $file;
		}
		if($exists === true)
			return realpath($path);
		$cwd = getcwd();
		$root = max(strpos($cwd, ':\\') + 2, strpos($cwd, '://') + 3);
		if($root === false)$root = 'file://';
		else $root = strtr(substr($cwd, 0, $root), '\\', '//');
		$path = strtr($path, '\\', '/');
		if(strtolower(substr($path, 0, 7)) == 'file://')
			$path = $root . substr($path, 7);
		elseif($path[0] == '/')
			$path = $root . ltrim($path, '/');
		elseif(substr($path, 0, 2) == './')
			$path = strtr($cwd, '\\', '/') . substr($path, 1);
		elseif(substr($path, 0, 3) == '../')
			$path = strtr(dirname($cwd), '\\', '/') . substr($path, 2);
		elseif(strpos($path, $root) !== 0)
			$path = strtr($cwd, '\\', '/') . '/' . $path;
		do{
			$path = str_replace(array('//', '/./'), array('/', '/'), $prev = $path);
		}while($prev !== $path);
		$l = strlen($root);
		while(true){
			if(substr($path, 0, $l + 3) == $root . '../'){
				$path = substr_replace($path, '', $l, 3);
				continue;
			}
			$pos = strpos($path, '/../');
			if($pos === false)break;
			$prev = strrpos(substr($path, 0, $pos), '/');
			$path = substr_replace($path, '', $prev, $pos + 3 - $prev);
		}
		if(DIRECTORY_SEPARATOR == '\\')
			return strtr($path, '/', '\\');
		return $path;
	}
	public static function pathname($path){
		$path = strtr($path, '\\', '/');
		if(strtolower(substr($path, 0, 7)) == 'file://')
			$path = substr($path, 7);
		elseif($path[0] == '/')
			$path = ltrim($path, '/');
		elseif(substr($path, 0, 2) == './')
			$path = substr($path, 2);
		elseif(substr($path, 0, 3) == '../')
			$path = substr($path, 3);
		do{
			$path = str_replace(array('//', '/./'), array('/', '/'), $prev = $path);
		}while($prev !== $path);
		while(true){
			$pos = strpos($path, '/../');
			if($pos === false)break;
			$prev = strrpos(substr($path, 0, $pos), '/');
			$path = substr_replace($path, '', $prev, $pos + 3 - $prev);
		}
		if(DIRECTORY_SEPARATOR == '\\')
			return strtr($path, '/', '\\');
		return $path;
	}
	public static function dirname($path){
		return dirname($path);
	}
	public static function filename($path){
		return pathinfo($path, PATHINFO_FILENAME);
	}
	public static function getextension($path){
		return pathinfo($path, PATHINFO_EXTENSION);
	}
	public static function basename($path){
		return basename($path);
	}
}

class dir {
	public static function files($dir = ''){
		if($dir === '')
			$dir = getcwd();
		$scan = scandir($dir);
		unset($scan[0]);
		if($scan[1] == '..')
			unset($scan[1]);
		return array_values($scan);
	}
	public static function delete($name = ''){
		if($name === '')
			$name = getcwd();
		$dir = opendir($name);
		if(!$dir)
			return false;
		readdir($dir);
		while(($file = $name .DIRECTORY_SEPARATOR. readdir($dir)) !== false)
			if($dir == '.' || $dir == '..');
			elseif(is_dir($file))
				self::delete($file);
			else
				unlink($file);
		closedir($dir);
		unlink($dir);
		return true;
	}
	public static function remake($dir = ''){
		if(!file_exists($dir))
			return mkdir($dir);
		if(!self::delete($dir))
			return false;
		return mkdir($dir);
	}
	public static function copy($from, $to){
		$dir = opendir($from);
		if(!$dir)
			return false;
		self::remake($to);
		readdir($dir);
		while(($file = readdir($dir)) !== false)
			if($dir == '.' || $dir == '..');
			elseif(is_dir($from .DIRECTORY_SEPARATOR. $file))
				self::copy($from .DIRECTORY_SEPARATOR. $file, $to .DIRECTORY_SEPARATOR. $file);
			else
				copy($from .DIRECTORY_SEPARATOR. $file, $to .DIRECTORY_SEPARATOR. $file);
		closedir($dir);
		return true;
	}
}
function fget($file, $length = -1, $offset = -1){
	$file = fopen($file, 'r');
	if(!$file)
		return false;
	$read = stream_get_contents($file, $length, $offset);
	fclose($file);
	return $read;
}
function fput($file, $content = ''){
	$file = fopen($file, 'w');
	if(!$file)
		return false;
	$res = fwrite($file, $content);
	fclose($file);
	return $res;
}
function fadd($file, $content){
	$file = fopen($file, 'a');
	if(!$file)
		return false;
	$res = fwrite($file, $content);
	fclose($file);
	return $res;
}
function fwait($file, $limit = 1){
	$file = fopen($file, 'r');
	if(!$file)
		return false;
	stream::wait($file, $limit, false);
	$tell = ftell($file);
	fclose($file);
	return $tell;
}
function freset($file){
	$file = fopen($file, 'w');
	if(!$file)
		return false;
	ftruncate($file, 0);
	fclose($file);
	return true;
}


/* ---------- Proc|Console --------- */
class Proc {
	public static $root = '';

	private static function parse_table($table, $header = false){
		do {
			$table = str_replace(array("\n ", " \n", '  '), array("\n", "\n", ' '), $prev = $table);
		}while($table != $prev);
		$table = explode("\n", $table);
		if($header)array_shift($table);
		return array_map(function($x){
			return explode(' ', $x);
		}, $table);
	}

	public static function version(){
		return str_replace('version ', '', fget(self::$root . "/proc/version"));
	}
	public static function uptime(){
		$uptime = explode(' ', fget(self::$root . "/proc/uptime"));
		return array((float)$uptime[0], (float)$uptime[1]);
	}
	public static function net_connections($proto){
		switch($proto){
			case 'tcp':
			case 'udp':
			case 'raw':
			case 'tcp6':
			case 'udp6':
			case 'raw6':
				return array_map(function($row){
					$array = array();
					$local = explode(':', $row[1]);
					$local[0] = net::inet_ntop(crypt::hexdecode($local[0]));
					$local[1] = hexdec($local[1]);
					$local = "{$local[0]}:{$local[1]}";
					$array['local'] = $local;
					$remote = explode(':', $row[2]);
					$remote[0] = net::inet_ntop(crypt::hexdecode($remote[0]));
					$remote[1] = hexdec($remote[1]);
					$remote = "{$remote[0]}:{$remote[1]}";				
					$array['remote'] = $remote;
					$array['state'] = hexdec($row[2]);
					$queue = explode(':', $row[3]);
					$array['tranmit_queue'] = hexdec($queue);
					$array['receive_queue'] = hexdec($queue);
					$timer = explode(':', $row[4]);
					$array['timer'] = hexdec($time[0]);
					$array['expires'] = hexdec($timer[1]);
					$array['unrecovered_rto'] = hexdec($row[5]);
					$array['uid'] = hexdec($row[6]);
					$array['timeout'] = hexdec($row[7]);
					$array['inode'] = (int)$row[8];
					if(isset($row[9]))$array['reference_count'] = hexdec($row[9]);
					if(isset($row[10]))$array['pointer'] = hexdec($row[10]);
					if(isset($row[11]))$array['retransmit_timeout'] = hexdec($row[11]);
					return $array;
				}, self::parse_table(fget(self::$root . "/proc/net/$proto"), true));
			case 'unix':
				return array_map(function($row){
					$array = array();
					$array['number'] = hexdec(substr($row[0], 0, -1));
					$array['reference_count'] = hexdec($row[1]);
					$array['protocol'] = hexdec($row[2]);
					$array['flags'] = hexdec($row[3]);
					$array['type'] = hexdec($row[4]);
					$array['state'] = hexdec($row[5]);
					$array['inode'] = (int)$row[6];
					$array['path'] = $row[7];
					return $array;
				}, self::parse_table(fget(self::$root . "/proc/net/unix"), true));
		}
		new APError('proc::net_connections', "Invalid protocol $proto", APError::WARNING);
		return false;
	}
	public static function command_line(){
		return fget(self::$root . "/proc/cmdline");
	}
	public static function cpuinfo(){
		$cpus = explode("\npower management:\n\n", fget(self::$root . "/proc/cpuinfo"));
		array_pop($cpus);
		return array_map(function($cpu){
			$array = array();
			$cpu = explode("\n", $cpu);
			foreach($cpu as $row){
				$row = explode(' : ', $row, 2);
				$array[$row[0]] = $row[1];
			}
			return $array;
		}, $cpus);
	}
	public static function meminfo(){
		$mem = explode("\n", fget(self::$root . "/proc/meminfo"));
		$result = array();
		foreach($mem as $row){
			$row = explode(':', $row, 2);
			$row[1] = trim($row[1], ' ');
			if(substr($row[1], -3) == ' kB')
				$result[$row[0]] = substr($row[1], 0, -3) * 1024;
			else
				$result[$row[0]] = (int)$row[1];
		}
		return $result;
	}
	public static function loadavg(){
		$loadavg = explode(' ', fget(self::$root . "/proc/loadavg"));
		$result = array((float)$loadavg[0], (float)$loadavg[1], (float)$loadavg[2]);
		$loadavg[3] = explode('/', $loadavg[3], 2);
		$result['runnig_proces'] = (int)$loadavg[3][0];
		$result['proces'] = (int)$loadavg[3][1];
		$result['last_proc_id'] = (int)$loadavg[4];
		return $result;
	}
	public static function mounts(){
		return array_map(function($row){
			$row = explode(' ', $row, 6);
			return array(
				'partition' => $row[0],
				'mount_point' => $row[1],
				'path' => $row[2],
				'options' => $row[3],
				'dump' => (int)$row[4],
				'fsck_order' => (int)$row[5]
			);
		}, self::parse_table(fget(self::$root . "/proc/mounts")));
	}

	public static function proc_command_line($id = null){
		if($id === null)$id = apeip::$pid;
		return fget(self::$root . "/proc/$id/cmdline");
	}
	public static function proc_command($id = null){
		if($id === null)$id = apeip::$pid;
		return rtrim(fget(self::$root . "/proc/$id/comm"), "\n");
	}
	public static function proc_wchan($id = null){
		if($id === null)$id = apeip::$pid;
		return (int)fget(self::$root . "/proc/$id/wchan");
	}
	public static function proc_exe_link($id = null, $to = null){
		if($id === null)$id = apeip::$pid;
		if($to === true)
			return fget(self::$root . "/proc/$id/exe");
		if(is_string($to))
			return copy(self::$root . "/proc/$id/exe", $to);
		return self::$root . "/proc/$id/exe";
	}
	public static function proc_oom_adj($id = null){
		if($id === null)$id = apeip::$pid;
		return (int)fget(self::$root . "/proc/$id/oom_adj");
	}
	public static function proc_oom_score($id = null){
		if($id === null)$id = apeip::$pid;
		return (int)fget(self::$root . "/proc/$id/oom_score");
	}
	public static function proc_oom_score_adj($id = null){
		if($id === null)$id = apeip::$pid;
		return (int)fget(self::$root . "/proc/$id/oom_score_adj");
	}
	public static function proc_cpuset($id = null){
		if($id === null)$id = apeip::$pid;
		return fget(self::$root . "/proc/$id/cpuset");
	}
	public static function proc_stack($id = null){
		if($id === null)$id = apeip::$pid;
		$stack = explode("\n", fget(self::$root . "/proc/$id/stack"));
		$result = array();
		foreach($stack as $row){
			$row = explode(' ', $stack, 2);
			$result[substr($row[0], 2, -2)] = $row[1];
		}
		return $result;
	}
	public static function proc_status($id = null){
		if($id === null)$id = apeip::$pid;
		$status = self::parse_table(fget(self::$root . "/proc/$id/status"));
		$result = array();
		foreach($status as $row){
			$row = explode(': ', $row, 2);
			$result[$row[0]] = $row[1];
		}
		return $result;
	}
	public static function proc_stat($id = null){
		if($id === null)$id = apeip::$pid;
		$stat = explode(' ', fget(self::$root . "/proc/$id/stat"));
		return array(
			'pid' => (int)$stat[0],
			'comm' => $stat[1],
			'stat' => $stat[2],
			'ppid' => (int)$stat[3],
			'pgrp' => (int)$stat[4],
			'session' => (int)$stat[5],
			'tty_nr' => (int)$stat[6],
			'tpgid' => (int)$stat[7],
			'flags' => (int)$stat[8],
			'minflt' => (int)$stat[9],
			'cminflt' => (int)$stat[10],
			'majflt' => (int)$stat[11],
			'cmajflt' => (int)$stat[12],
			'utime' => (int)$stat[13],
			'stime' => (int)$stat[14],
			'cutime' => (int)$stat[15],
			'cstime' => (int)$stat[16],
			'priority' => (int)$stat[17],
			'nice' => (int)$stat[18],
			'num_threads' => (int)$stat[19],
			'itrealvalue' => (int)$stat[20],
			'starttime' => $stat[21],
			'vsize' => (int)$stat[22],
			'rss' => (int)$stat[23],
			'rsslim' => (int)$stat[24],
			'startcode' => $stat[25],
			'endcode' => (int)$stat[26],
			'startstack' => (int)$stat[27],
			'kstkesp' => (int)$stat[28],
			'kstkeip' => (int)$stat[29],
			'signal' => (int)$stat[30],
			'blocked' => (int)$stat[31],
			'sigignore' => (int)$stat[32],
			'sigcatch' => (int)$stat[33],
			'wchan' => (int)$stat[34],
			'nswap' => (int)$stat[35],
			'cnswap' => (int)$stat[36],
			'exit_signal' => (int)$stat[37],
			'processor' => (int)$stat[38],
			'rt_priority' => (int)$stat[39],
			'plicy' => (int)$stat[40],
			'delayacct_blkio_ticks' => $stat[41],
			'guest_time' => (int)$stat[42],
			'cguest_time' => (int)$stat[43],
			'start_data' => (int)$stat[44],
			'end_data' => (int)$stat[45],
			'start_brk' => (int)$stat[46],
			'arg_start' => (int)$stat[47],
			'arg_end' => (int)$stat[48],
			'env_start' => (int)$stat[49],
			'env_end' => (int)$stat[50],
			'exit_code' => (int)$stat[51]
		);
	}
	public static function proc_statm($id = null){
		if($id === null)$id = apeip::$pid;
		$statm = explode(' ', fget(self::$root . "/proc/$id/statm"));
		return array(
			'size' => (int)$statm[0],
			'resident' => (int)$statm[1],
			'shared' => (int)$statm[2],
			'text' => (int)$statm[3],
			'lib' => (int)$statm[4],
			'data' => (int)$statm[5],
			'dirty_pages' => (int)$statm[6]
		);
	}
	public static function proc_times($id = null){
		if(($id === null || $id == apeip::$pid) && __apeip_data::$instPosix)
			return posix_times();
		$stat = self::proc_stat($id);
		return array(
			'ticks' => $stat['delayacct_blkio_ticks'],
			'utime' => $stat['utime'],
			'stime' => $stat['stime'],
			'cutime' => $stat['cutime'],
			'cstime' => $stat['cstime']
		);
	}
	public static function proc_environ($id = null){
		if($id === null)$id = apeip::$pid;
		$environ = explode(' ', fget(self::$root . "/proc/$id/environ"));
		$result = array();
		foreach($environ as $row){
			$row = explode('=', $row, 2);
			if(!isset($row[1]))
				$result[] = $row[0];
			else
				$result[$row[0]] = $row[1];
		}
		return $result;
	}
	public static function proc_io($id = null){
		if($id === null)$id = apeip::$pid;
		$io = explode("\n", fget(self::$root . "/proc/$id/io"));
		$result = array();
		foreach($io as $row){
			$row = explode(': ', $row, 2);
			$result[$row[0]] = (int)$row[1];
		}
		return $result;
	}
	public static function proc_limits($id = null){
		if($id === null)$id = apeip::$pid;
		$limits = explode("\n", fget(self::$root . "/proc/$id/limits"));
		$result = array();
		foreach($limits as $limit){
			$name = strtr(rtrim(substr($limit, 0, 26), ' '), ' ', '_');
			$name[0] = strtolower($name[0]);
			$result[$name] = array();
			$result[$name]['soft_limit'] = rtrim(substr($limit, 26, 21), ' ');
			$result[$name]['hard_limit'] = rtrim(substr($limit, 47, 21), ' ');
			$result[$name]['units'] = rtrim(substr($limit, 68), ' ');
		}
		return $result;
	}
	public static function proc_auxv($id = null){
		if($id === null)$id = apeip::$pid;
		return fget(self::$root . "/proc/$id/auxv");
	}
	public static function proc_maps($id = null){
		if($id === null)$id = apeip::$pid;
		return array_map(function($row){
			$array = array();
			$row[0] = explode('-', $row[0], 2);
			$array['from'] = $row[0][0];
			$array['to'] = $row[0][1];
			$array['length'] = hexdec($row[0][1]) - hexdec($row[0][0]);
			$array['perms'] = $row[1];
			$array['offset'] = $row[2];
			$array['dev'] = $row[3];
			$array['path'] = $row[4];
			return $array;
		}, self::parse_table(fget(self::$root . "/proc/$id/maps")));
	}
	public static function proc_patch_state($id = null){
		if($id === null)$id = apeip::$pid;
		return (int)fget(self::$root . "/proc/$id/patch_state");
	}
	public static function proc_session_id($id = null){
		if($id === null)$id = apeip::$pid;
		return (int)fget(self::$root . "/proc/$id/sessionid");
	}
	public static function proc_paths(){
		$paths = scandir(self::$root . '/proc');
		$procs = array();
		foreach($paths as $path)
			if(is_numeric($path))
				$procs[] = (int)$path;
		return $procs;
	}

	public static function dev_random($length = 1){
		$file = fopen(self::$root . "/dev/random", 'r');
		if(!$file)
			return false;
		$read = fread($file, $length);
		fclose($file);
		return $read;
	}
	public static function dev_urandom($length = 1){
		$file = fopen(self::$root . "/dev/urandom", 'r');
		if(!$file)
			return false;
		$read = fread($file, $length);
		fclose($file);
		return $read;
	}
	public static function dev_hardware_random($length = 1){
		$file = fopen(self::$root . "/dev/hw_random", 'r');
		if(!$file)
			return false;
		$read = fread($file, $length);
		fclose($file);
		return $read;
	}

	public static function tmp_files(){
		return dir::files(sys_get_temp_dir());
	}

	public static function sysdev_cdrom_info(){
		$cdrom = fget(self::$root . "/proc/sys/dev/cdrom/info");
		$result = array();
		$table = explode("\n", $cdrom);
		$table[0] = explode(':', $table[0], 2);
		if(isset($table[0][1]))
			$result['id'] = trim($table[0][1]);
		for($i = 2; isset($table[$i]); ++$i){
			$row = explode(':', $table[$i], 2);
			$result[$row[0]] = trim($row[1]);
		}
		return $result;
	}
	public static function sysdev_cdrom_lock(){
		return (bool)fget(self::$root . "/proc/sys/dev/cdrom/lock");
	}
	public static function sysdev_cdrom_debug(){
		return (bool)fget(self::$root . "/proc/sys/dev/cdrom/debug");
	}
	public static function sysdev_cdrom_autoclose(){
		return (bool)fget(self::$root . "/proc/sys/dev/cdrom/autoclose");
	}
	public static function sysdev_cdrom_autoeject(){
		return (bool)fget(self::$root . "/proc/sys/dev/cdrom/autoeject");
	}
	public static function sysdev_cdrom_check_media(){
		return (bool)fget(self::$root . "/proc/sys/dev/cdrom/check_media");
	}

	public static function kernel_version(){
		return fget(self::$root . "/proc/sys/kernel/version");
	}
	public static function kernel_domainname(){
		return fget(self::$root . "/proc/sys/kernel/domainname");
	}
	public static function kernel_hostname(){
		return fget(self::$root . "/proc/sys/kernel/hostname");
	}
	public static function kernel_uses_pid(){
		return (int)fget(self::$root . "/proc/sys/kernel/core_uses_pid");
	}
	public static function kernel_pipe_limit(){
		return (int)fget(self::$root . "/proc/sys/kernel/core_pipe_limit");
	}
	public static function kernel_core_pattern(){
		return fget(self::$root . "/proc/sys/kernel/core_pattern");
	}

	const SIGHUB = 1;
	const SIGINT = 2;
	const SIGQUIT = 3;
	const SIGILL = 4;
	const SIGTRAP = 5;
	const SIGABRT = 6;
	const SIGBUS = 7;
	const SIGFPE = 8;
	const SIGKILL = 9;
	const SIGUSR1 = 10;
	const SIGSEGV = 11;
	const SIGUSER2 = 12;
	const SIGPIPE = 13;
	const SIGALRM = 14;
	const SIGTERM = 15;
	const SIGSTKFLT = 16;
	const SIGHCLD = 17;
	const SIGCONT = 18;
	const SIGSTOP = 19;
	const SIGTSTP = 20;
	const SIGTTIN = 21;
	const SIGTTOU = 22;
	const SIGURG = 23;
	const SIGXCPU = 24;
	const SIGXFSZ = 25;
	const SIGVTALRM = 26;
	const SIGPROF = 27;
	const SIGWINCH = 28;
	const SIGIO = 29;
	const SIGPWR = 30;
	const SIGSYS = 31;
	const SIGRTMIN = 34;
	const SIGRTMAX = 64;
	public static function getpid(){
		return apeip::$pid;
	}
	public static function getuid(){
		return getmyuid();
	}
	public static function getgid(){
		return getmygid();
	}
	public static function getinode(){
		return getmyinode();
	}
	public static function kill($id = null, $sig = 9){
		if($id === null)$id = apeip::$pid;
		if(__apeip_data::$instPosix)
			return posix_kill($id, $sig);
		return exec("kill -$sig $id");
	}
	public static function pidof($name){
		$pid = exec('pidof ' . unce($name));
		if($pid === '')return false;
		return (int)$pid;
	}
	public static function pkill($name, $sig = 9){
		if($id === null)$id = apeip::$pid;
		return exec("pkill -$sig " . unce($name));
	}
	public static function nanotime($float = false){
		$time = exec('date +%s%N');
		return $float ? (int)$time / 1000000000 : $time;
	}
	public static function shell_random(){
		return (int)exec('echo \$RANDOM');
	}

	public static function wifi_networks(){
		if(apeip::$isWIN){
			$networks = shell_exec('netsh wlan show networks mode=Bssid');
			$networks = explode("\n", $networks);
			$info = array();
			$SSIDs = array();
			$SSID = -1;
			$BSSID = -1;
			$BSSIDs = array();
			foreach($networks as $row){
				$row = explode(':', $row, 2);
				$row[0] = trim($row[0], ' ');
				if($row[0] === '')continue;
				if(isset($row[1])){
					$row[1] = trim($row[1], ' ');
					if($row[0][1] == strtolower($row[0][1]))
						$row[0] = strtr(strtolower($row[0]), ' ', '_');
					$p = strpos($row[0], '_(');
					if($p > 0)
						$row[0] = substr($row[0], 0, $p);
					if(strpos($row[0], 'SSID') === 0){
						if($BSSID != -1)
							$SSIDs[$SSID]['BSSID'] = $BSSIDs;
						++$SSID;
						$BSSID = -1;
						$BSSIDs = array();
						$SSIDs[$SSID] = array(
							'title' => $row[1]
						);
					}elseif(strpos($row[0], 'BSSID') === 0){
						++$BSSID;
						$BSSIDs[$BSSID] = array(
							'id' => $row[1]
						);
					}elseif($BSSID != -1)
						$BSSIDs[$BSSID][$row[0]] = $row[1];
					elseif($SSID != -1)
						$SSIDs[$SSID][$row[0]] = $row[1];
					else
						$info[$row[0]] = $row[1];
				}
			}
			if($BSSID != -1 && $SSID != -1)
				$SSIDs[$SSID]['BSSID'] = $BSSIDs;
			if($SSID != -1)
				$info['SSID'] = $SSIDs;
			return $info;
		}else return false;
	}
	public static function wifi_interfaces(){
		if(apeip::$isWIN){
			$networks = shell_exec('netsh wlan show interfaces');
			$networks = explode("\n\n", $networks);
			array_shift($networks);
			array_pop($networks);
			$last = count($networks) - 1;
			foreach($networks as $key => &$network){
				if(!is_int($key))continue;
				$network = explode("\n", $network);
				$info = array();
				foreach($network as &$row){
					$row = explode(':', $row, 2);
					if(!isset($row[1])){
						$info[] = trim($row[0], ' ');
						continue;
					}
					$row[0] = trim($row[0], ' ');
					$row[1] = trim($row[1], ' ');
					if($row[0][1] == strtolower($row[0][1]))
						$row[0] = strtr(strtolower($row[0]), ' ', '_');
					$p = strpos($row[0], '_(');
					if($p > 0)
						$row[0] = substr($row[0], 0, $p);
					$info[$row[0]] = $row[1];
				}
				if($key == $last)
					foreach($info as $key => $value)
						$networks[$key] = $value;
				else
					$network = $info;
			}
			unset($networks[$last]);
			return $networks;
		}else return false;
	}
}

if(apeip::$isConsole){
	class Console {
		public static function write($content, $length = -1){
			$content = str_replace(array('\\', "\e["), array('\\\\', "\e\["), $content);
			if($length == -1)print $content;
			else return fwrite(STDOUT, $content, $length);
		}
		public static function writeln($content, $length = -1) {
			$content = str_replace(array('\\', "\e["), array('\\\\', "\e\["), $content);
			if($length == -1)print "$content\n";
			else return fwrite(STDOUT, "$content\n", $length + 1);
		}
		public static function error($content, $length = -1){
			if($length == -1)return fwrite(STDERR, $content);
			return fwrite(STRERR, $content, $length);
		}

		public static function clear(){
			if(apeip::$isWIN && !apeip::$isWIN7)
				system('cls');
			else
				system('clear');
		}
		public static function delch($count = 1){
			print "\e[${count}P";
		}
		public static function unprint($count = 1){
			print "\e[${count}D" . str_repeat(' ', $count) . "\e[${count}D";
		}

		public static function getch($hide = false){
			$term = shell_exec('stty -g');
			system('stty -icanon');
			if($hide){
				$ch = fgetc(STDIN);
				print "\e[1D \e[1D";
			}else $ch = fgetc(STDIN);
			system("stty '$term'");
			return $ch;
		}
		public static function read($length = 1, $hide = false){
			$read = '';
			for($i = 0; $i < $length; ++$i)
				$read .= self::getch($hide);
			return $read;
		}
		public static function readln($length = -1, $hide = false){
			if($length == -1 && !$hide)
				return readline();
			$line = '';
			if($length == -1)
				do {
					$line .= $ch = self::getch($hide);
				}while($ch != "\n" && $ch != "\r");
			else
				do {
					$line .= $ch = self::getch($hide);
				}while($ch != "\n" && $ch != "\r" && --$length >= 0);
			return $line;
		}
		public static function preg_read($pattern, $hide = false, &$matches = null, $flags = 0){
			$read = '';
			while(true){
				for($i = 0; isset($read[$i]); ++$i){
					$sub = substr($read, $i);
					if(preg_match($pattern, $sub, $matches, $flags))
						return $sub;
				}
				$read .= self::getch($hide);
			}
		}
		public static function prompt($question = '', $hide = false){
			print $question;
			return self::readln($hide);
		}

		const FORMAT_BOLD = 1;
		const FORMAT_DIM = 2;
		const FORMAT_ITALIC = 3;
		const FORMAT_UNDERLINE = 4;
		const FORMAT_BLINK = 5;
		const FORMAT_MINVERTED = 7;
		const FORMAT_HIDDEN = 8;
		const RESET_ALL = 0;
		const RESET_BOLD = 21;
		const RESET_DIM = 22;
		const RESET_ITALIC = 23;
		const RESET_UNDERLINE = 24;
		const RESET_BLINK = 25;
		const RESET_MINVERTED = 27;
		const RESET_HIDDEN = 28;

		const FOREGROUND_DEFAULT = 39;
		const FOREGROUND_BLACK = 30;
		const FOREGROUND_RED = 31;
		const FOREGROUND_GREEN = 32;
		const FOREGROUND_YELLOW = 33;
		const FOREGROUND_BLUE = 34;
		const FOREGROUND_MAGENTA = 35;
		const FOREGROUND_CYAN = 36;
		const FOREGROUND_LIGHT_GRAY = 37;
		const FOREGROUND_DARK_GRAY = 90;
		const FOREGROUND_LIGHT_RED = 91;
		const FOREGROUND_LIGHT_GREEN = 92;
		const FOREGROUND_LIGHT_YELLOW = 93;
		const FOREGROUND_LIGHT_BLUE = 94;
		const FOREGROUND_LIGHT_MAGENTA = 95;
		const FOREGROUND_LIGHT_CYAN = 96;
		const FOREGROUND_WHITE = 97;
		
		const BACKGROUND_DEFAULT = 49;
		const BACKGROUND_BLACK = 40;
		const BACKGROUND_RED = 41;
		const BACKGROUND_GREEN = 42;
		const BACKGROUND_YELLOW = 43;
		const BACKGROUND_BLUE = 44;
		const BACKGROUND_MAGENTA = 45;
		const BACKGROUND_CYAN = 46;
		const BACKGROUND_LIGHT_GRAY = 47;
		const BACKGROUND_DARK_GRAY = 100;
		const BACKGROUND_LIGHT_RED = 101;
		const BACKGROUND_LIGHT_GREEN = 102;
		const BACKGROUND_LIGHT_YELLOW = 103;
		const BACKGROUND_LIGHT_BLUE = 104;
		const BACKGROUND_LIGHT_MAGENTA = 105;
		const BACKGROUND_LIGHT_CYAN = 106;
		const BACKGROUND_WHITE = 107;

		public static function setstyle($style){
			print "\e[${style}m";
		}
		public static function foreground256($n){
			print "\e[38;5;${n}m";
		}
		public static function background256($n){
			print "\e[48;5;${n}m";
		}

		const CURSOR_UP = 1;
		const CURSOR_DOWN = 2;
		const CURSOR_FORWARD = 3;
		const CURSOR_BACK = 4;
		const CURSOR_NEXT_LINE = 5;
		const CURSOR_PREV_LINE = 6;
		const CURSOR_START_LINE = 7;
		public static function cursor($type, $count = 1){
			if(!in_array($type, array(1, 2, 3, 4, 5, 6, 7)))
				new APError('Console', "Invalid cursor move model", APError::WARNING, APError::TTHROW);
			if($type == 7)
				print "\e[1F\e[1B";
			else
				print "\e[$count" . chr($type + 64);
		}
		public static function cursorto($x, $y){
			print "\e[$x;${y}H";
		}
		public static function cursor_save(){
			print "\e[s";
		}
		public static function cursor_restore(){
			print "\e[u";
		}
		public static function cursor_show(){
			print "\e[25h";
		}
		public static function cursor_hide(){
			print "\e[25l";
		}

		const SCROLL_UP = 1;
		const SCROLL_DOWN = 2;
		public static function scroll($type, $count = 1){
			if($type != 1 || $type != 2)
				new APError('Console', "Invalid scroll move model", APError::WARNING, APError::TTHROW);
			print "\e[$count" . chr($type + 82);
		}

		const ERASE_CURSOR_TO_END_SCREEN = 0;
		const ERASE_CURSOR_TO_BEGIN_SCREEN = 1;
		const ERASE_SCREEN = 2;
		const ERASE_CURSOR_TO_END_LINE = 3;
		const ERASE_CURSOR_TO_BEGIN_LINE = 4;
		const ERASE_LINE = 5;
		public static function erase($type = 2){
			if(!in_array($type, array(0, 1, 2, 3, 4, 5)))
				new APError('Console', "Invalid erase model", APError::WARNING, APError::TTHROW);
			if($type > 3)
				print "\e[" . ($type - 3) . 'K';
			else
				print "\e[${type}J";
		}
		public static function insertLine(){
			print "\e[L";
		}
		public static function deleteLine(){
			print "\e[M";
		}
		public static function output_enable(){
			print "\e[+";
		}
		public static function output_disable(){
			print "\e[-";
		}

		public static function AUXport($on = true){
			print $on ? "\e[5i" : "\e[4i";
		}

		public static function warn_song(){
			print "\7";
		}
		public static function warning($string){
			print "\7";
			return fwrite(STDERR, $string);
		}

		public static function flash(){
			print "\e[?5h";
		}
		public static function unflash(){
			print "\e[?5l";
		}
	}
}

__apeip_data::$endMemory = memory_get_usage();
apeip::$memoryUsage = __apeip_data::$endMemory - __apeip_data::$startMemory;
__apeip_data::$endTime = microtime(true);
apeip::$loadTime = __apeip_data::$endTime - __apeip_data::$startTime;
?>