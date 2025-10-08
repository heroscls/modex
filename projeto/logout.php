<?php
    session_start();

<<<<<<< HEAD
    $_SESSION = [];

=======
    
    $_SESSION = [];

    
>>>>>>> c3ab04824da2c090f9a07975c79641f1923491ed
    if(ini_get("session.use_cookies")){
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() -42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
    }

<<<<<<< HEAD
    session_destroy();

=======
    
    session_destroy();

    
>>>>>>> c3ab04824da2c090f9a07975c79641f1923491ed
    header("Location: login.php");
    exit;

?>