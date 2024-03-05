<?php

use \Bitrix\Main\Loader;

// composer
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php';

require 'kint.phar'; //подключение дебаггера kint

include 'constants.php'; //подключение файла с константами
include 'functions.php'; //подключение файла с функциями
include 'agents.php'; //подключение файла с агентами
