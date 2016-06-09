<?php

// CONSTANTS COMMON IN ALL THE WEB PROJECT
define("SERVER_NAME", "localhost");
//define("SERVER_USER", "xampp_server");
//define("SERVER_PASSWORD", "password");
//define("SERVER_DB_NAME", "web_project");
define("SERVER_USER", "s231050");
define("SERVER_PASSWORD", "vagstiou");
define("SERVER_DB_NAME", "s231050");



define("MAX_SESSION_TIME", 120); //2 min

//CONSTRAINTS ON ADDING A RESERVATION
define("AVAILABLE_PRINTERS", 4);
define("FIRST_PRINTER", 1);

define("HOUR_MIN", 60);

define("MAX_HOUR", 23);
define("MIN_HOUR", 0);
define("MAX_MIN", 59);
define("MIN_MIN", 0);
define("MAX_DURATION", 1440); //1440 min => 24h
define("MIN_DURATION", 1);

//CONSTRAINTS ON REMOVING A RESERVATION
define("MIN_MARGIN", 1); //1 min

//VALUES TO CHECK IF COOKIES ARE ENABLED
define("COOKIE_ENABLED_TIMEOUT", 3600);
define("COOKIE_PREV_PAGE_TIMEOUT", 60);

?>