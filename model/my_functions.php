<?php
    declare(strict_types=1);

    function dd($value) : void {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";

        die();
    }    

    /** Test access */
    function testAccess() : void {
        /** Check for user`s sessions */
        !isset($_SESSION['role']) ? header("Location: /") : null;	

        if($_SESSION['role'] !== "ROLE_ADMIN") {						
            header("Location: /login");
        }
    }
?>