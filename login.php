<?php
session_start();
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}
if (isset($_COOKIE['usuarios'])) {
    $_SESSION['usuarios'] = unserialize($_COOKIE['usuarios']);
}
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = "";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    if (isset($_POST['registrar'])) {

        $encontrado = false;
        foreach ($_SESSION['usuarios'] as $value) {

            if ($_POST['newUser'] == $value) {
                echo "Usuario ya existente";
                $encontrado = true;
                break;
            }
        }
        if (!$encontrado) {
            $_SESSION['usuarios'][] = $_POST['newUser'];
            setcookie("usuarios", serialize($_SESSION['usuarios']), strtotime("+1 year"));
            $_SESSION['usuario']=$_POST['newUser'];
            setcookie("usuario",$_SESSION['usuario'],strtotime("+1 year"));
            header("location:index.php");
        }
        

    }
    if (isset($_POST["login"])) {
        $_SESSION['usuario']=$_POST['getUser'];
        setcookie("usuario",$_SESSION['usuario'],strtotime("+1 year"));
        header("location:index.php");
    }
    ?>
    <form  method="post">
        <?php
        if ($_SESSION['usuarios'] != []) {
            echo "Inciar sesion<br>";
            echo "<select name='getUser'>";
            foreach ($_SESSION['usuarios'] as $value) {
                echo "<option value='$value'>" . $value . "</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Iniciar sesion' name='login'>";
        }


        ?>
    </form>
    <hr>
    <form method="post">
        Registrarse
        <br>Usuario<input type="text" name="newUser" required>
        <br><input type="submit" name="registrar">
    </form>


</body>

</html>