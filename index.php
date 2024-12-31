<?php
include_once 'Email.php';
session_start();
if (!isset($_SESSION['usersArray'])) {
    $_SESSION['usersArray'] = [];
}
if (!isset($_SESSION['emails'])) {
    $_SESSION['emails'] = [];
    $fp = fopen("files/emails.txt", "r");
    while (!feof($fp)) {
        $linea = trim(fgets($fp));
        $contentLine = explode(",", $linea);

        if (!in_array($contentLine[0], $_SESSION['usersArray'])) {
            $_SESSION['usersArray'][] = $contentLine[0];
        }
        if (isset($contentLine[1])) {
            if (!in_array($contentLine[1], $_SESSION['usersArray'])) {
                $_SESSION['usersArray'][] = $contentLine[1];
            }
        }
        if (isset($contentLine[1]) && isset($contentLine[2]) && isset($contentLine[3])) {
            $email = new Email($contentLine[0], $contentLine[1], $contentLine[3], $contentLine[2]);
            $_SESSION['emails'][] = $email;
        }
    }
    fclose($fp);
}

if (isset($_COOKIE['usuario'])) {
    $_SESSION['usuario'] = $_COOKIE['usuario'];

}

echo "Bienvenido " . $_SESSION['usuario'];


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

    if (isset($_POST['send'])) {
        $email = new Email($_SESSION['usuario'], $_POST['nombreExistente'], $_POST['text'], date("d-m-Y"));
        $_SESSION['emails'][] = $email;
    }

    for ($i = 0; $i < count($_SESSION['emails']); $i++) {
        if (isset($_POST["destacar$i"])) {
            $_SESSION['emails'][$i]->destacarAsunto();
        }
        if (isset($_POST["retrasar$i"])) {
            $_SESSION['emails'][$i]->retrasarEnvio();

        }
    }

    ?>
    <form method="post">
        Receptor <select name="nombreExistente">
            <?php

            foreach ($_SESSION['usersArray'] as $value) {
                echo "<option value='$value'>$value</option>";
            }

            ?>
        </select><br>
        Asunto <textarea name="text"></textarea><br>

        <input type="submit" name="send" value="Enviar">

    </form>
    <table border="1">
        <?php
        for ($i = 0; $i < count($_SESSION['emails']); $i++) {
            echo "<tr>";
            echo "<td>" . $_SESSION['emails'][$i]->getEmisor() . "</td>";
            echo "<td>" . $_SESSION['emails'][$i]->getReceptor() . "</td>";
            if ($_SESSION['emails'][$i]->comprobarImportante()) {

                echo "<td style='color:green'>" . $_SESSION['emails'][$i]->getAsunto() . "</td>";
            } else {
                echo "<td>" . $_SESSION['emails'][$i]->getAsunto() . "</td>";

            }
            echo "<td>" . $_SESSION['emails'][$i]->getFecha() . "</td>";
            if ($_SESSION['emails'][$i]->getEmisor() == $_SESSION['usuario']) {
                echo $_SESSION['emails'][$i]->getEmisor();
                echo $_SESSION['usuario'];
                echo "<td><form method='post'><input type='submit' value='Destacar' name='destacar$i'></form></td>";
                echo "<td><form method='post'><input type='submit' value='Retrasar' name='retrasar$i'></form></td>";

            }
            echo "</tr>";
        }
        ?>
    </table>
    <form action="login.php">
        <input type="submit" value="Cerrar sesion">
    </form>

</body>

</html>