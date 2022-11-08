<?php
declare(strict_types=1);
// include_once '/includes/autoload.php';

// ini settings
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
ini_set('error_reporting', (string)E_ALL);
ini_set('log_errors', 'On');

use Eric\CodeChallenge\KnightPlay;

require_once '../classes/knightPlay.php';

$demo = new KnightPlay(5, 15);
$demo->start();
$demo->saveLog();

echo $demo->summary();