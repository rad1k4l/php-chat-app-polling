<?php

require_once __DIR__ . '/../core/autoloader.php';
require_once  __DIR__ . '/../boot/storage.php';


// ini_set("display_errors" );
session_start();

router()->run();

response()->send();

session_write_close();

#EOF