<?php

include "../utils/utils.php";
include "../db/connect.php";
include "../db/construct.php";
include "../db/fill.php";

include "../constants.php";

display_errors(false);

if (isset($DB_PASS) && isset($DB_USER) && isset($DB_HOST) && isset($DB_NAME))
{
    $db = connect_firstime($DB_HOST, $DB_USER, $DB_PASS);
}

if (isset($db))
{
    construct($db);
    fill($db);
    display_response("success", "Database initialized", 200);
}
else
{
    display_response("error", "Database connection failed", 500);
}
