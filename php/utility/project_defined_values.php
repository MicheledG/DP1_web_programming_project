<?php

// CONSTANTS COMMON IN ALL THE WEB PROJECT
define("SERVER_NAME", "localhost");
define("SERVER_USER", "xampp_server");
define("SERVER_PASSWORD", "password");
define("SERVER_DB_NAME", "web_project");

define("MAX_SESSION_TIME", 10); //10 sec

//CONSTRAINTS ON ADDING A RESERVATION
define("AVAILABLE_PRINTERS", 4);
define("FIRST_PRINTER", 1);

define("HOUR_MIN", 60);

define("MAX_HOUR", 23);
define("MIN_HOUR", 0);
define("MAX_MIN", 59);
define("MIN_MIN", 0);
define("MAX_DURATION", 120);
define("MIN_DURATION", 1);

//CONSTRAINTS ON REMOVING A RESERVATION
define("MIN_MARGIN", 1); //1 min

//VALUES TO CHECK IF COOKIES ARE ENABLED
define("COOKIE_ENABLED_TIMEOUT", 3600);
define("COOKIE_PREV_PAGE_TIMEOUT", 60);

?>