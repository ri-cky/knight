<?php
declare(strict_types=1);

// ini settings
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
ini_set('error_reporting', (string)E_ALL);
ini_set('log_errors', 'On');

use Eric\CodeChallenge\KnightPlay;

require_once 'src/classes/knightPlay.php';

$demo = new KnightPlay(7, 15);
$demo->start();
$demo->saveLog();

echo $demo->summary();