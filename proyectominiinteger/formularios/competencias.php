<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <h4>Competencias</h4>
        <input type="text" name="competencia" placeholder="Insertar Competencia"><br>
        <?php
            if (isset($_POST['disciplina'])) {
                $disciplina = $_POST['disciplina'];
                echo "Se ha seleccionado: " . $disciplina . "<br>";
            }
        ?>
        <input type="submit" value="Registrar-datos" name="registrardatos">
    </form>
</body>
</html>