<?php

include_once "../utils/utils.php";
include_once "../db/connect.php";
include_once "../constants.php";
include_once "../process/users.php";

$db = null;
if (isset($DB_PASS) && isset($DB_USER) && isset($DB_HOST) && isset($DB_NAME))
{
    $db = connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}
else
{
    display_response("error", "Database connection failed", 500);
}

// Check if the request is a GET request
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    display_errors(false);
    $_POST = json_decode(file_get_contents("php://input"), true);

    if (isset($_POST['query']))
    {
        switch ($_POST['query'])
        {
            // Get all products
            case 'login':
                try
                {
                    login($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            case 'register':
                try
                {
                    register($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            case 'profile':
                try
                {
                    profile($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            case 'vendor_profile':
                try
                {
                    vendor_profile($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            case 'logout':
                try
                {
                    logout($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            case 'add_vendor':
                try
                {
                    add_user($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            case 'remove_vendor':
                try
                {
                    remove_user($db);
                } catch (Exception $e)
                {
                    display_response("error", $e->getMessage(), 500);
                }
                break;
            default:
                display_response("error", "Unknown request.", 403);
                break;
        }
    }
    else
    {
        display_response("error", "Query parameter missing.", 403);
    }
}