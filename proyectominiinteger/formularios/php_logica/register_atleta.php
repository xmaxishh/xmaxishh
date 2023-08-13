<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Tarjeta Identificatoria</title>
	<link rel="stylesheet" href="estilos.css">
</head>
<body>
	<div class="contenedor">
		<?php
// Incluir la clase de conexión
include_once "../../Persistencia/conexion.php";

// Crear la clase register_atleta y heredar de la clase conexion
class register_atleta extends conexion {
    public function cargarAtleta($nombre, $pais, $fecha_nacimiento, $genero, $foto) {
        // Escapar los valores para evitar inyección de SQL
        $nombre_escaped = $this->conectar()->real_escape_string($nombre);
        $pais_escaped = $this->conectar()->real_escape_string($pais);
        $fecha_nacimiento_escaped = $this->conectar()->real_escape_string($fecha_nacimiento);
        $genero_escaped = $this->conectar()->real_escape_string($genero);
        $foto_escaped = $this->conectar()->real_escape_string($foto);

        // Insertar datos en la tabla de atletas
        $query = "INSERT INTO atletas (nombre, pais, fecha_nacimiento, genero, foto) VALUES ('$nombre_escaped', '$pais_escaped', '$fecha_nacimiento_escaped', '$genero_escaped', '$foto_escaped')";
        if ($this->conectar()->query($query)) {
            echo "<h2>Tarjeta Identificatoria</h2>";
            echo "<p>Nombre: <span class='resaltar'>$nombre</span></p>";
            echo "<p>País:<span class='resaltar'> $pais</p>";
            echo "<p>Fecha de Nacimiento:<span class='resaltar'>$fecha_nacimiento</p>";
            echo "<p>Género:<span class='resaltar'> $genero</p>";
            echo "<p>Foto:</p>";
            echo "<img src='../fotos_atletas/$foto' alt='Foto del atleta'>";
            echo "<a class='back-button' href='../../index.php'>Inicio</a>";
            echo "<a class='back-button' href='../atleta.php'>Volver</a>";
        } else {
            echo "<p class='error'>Error al registrar el atleta: " . $this->conectar()->error . "</p>";
            echo "<a class='back-button' href='../../index.php'>Inicio</a>";
            echo "<a class='back-button' href='../atleta.php'>Volver</a>";
        }

        // Desconectar de la base de datos
        $this->desconectar();
    }
}


    // Validar la imagen
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Obtener información del archivo
        $foto = $_FILES['foto'];
        $foto_nombre = $foto['name'];
        $foto_tipo = $foto['type'];
        $foto_tamano = $foto['size'];

        // Comprobar si el tipo de archivo es una imagen
        $permitidos = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($foto_tipo, $permitidos)) {
            echo "<p class='error'>Error: Solo se permiten imágenes en formato JPEG, PNG o GIF.</p>";
            echo "<a class='back-button' href='../../index.php'>Inicio</a>";
            echo "<a class='back-button' href='../atleta.php'>Volver</a>";
            exit;
        }

        // Comprobar el tamaño máximo de la imagen (por ejemplo, 5 MB)
        $tamano_maximo = 5 * 1024 * 1024; // 5 MB en bytes
        if ($foto_tamano > $tamano_maximo) {
            echo "<p class='error'>Error: El tamaño de la imagen es demasiado grande.</p>";
            echo "<a class='back-button' href='../../index.php'>Inicio</a>";
            echo "<a class='back-button' href='../atleta.php'>Volver</a>";
            exit;
        }

        // Resto del código para procesar la imagen y guardarla en el servidor...

        // Si se ha procesado correctamente la imagen, crear una instancia de la clase "register_atleta"
        $register_atleta = new register_atleta();

        // Llamar al método "cargarAtleta" de la clase "register_atleta"
        $register_atleta->cargarAtleta($nombre, $pais, $fecha_nacimiento, $genero, $foto_nombre);
    } else {
        echo "<p class='error'>Error al cargar la foto: " . $_FILES['foto']['error'] . "</p>";
        echo "<a class='back-button' href='../../index.php'>Inicio</a>";
        echo "<a class='back-button' href='../atleta.php'>Volver</a>";
    }


?>

	</div>
</body>
</html>