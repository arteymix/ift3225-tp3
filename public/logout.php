<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();
session_destroy();

header('HTTP/1.1 302 Temporary');
header('Location: '.\TP3\URL::rebase('/'));
exit;
