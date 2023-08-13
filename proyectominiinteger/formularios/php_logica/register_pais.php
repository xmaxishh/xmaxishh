<!DOCTYPE html>
<html>
<head>
  <title>Resultado del Registro</title>
  <style>
     
    body {
      margin: 0;
      padding: 0;
      font-family: Montserrat;
      background-image:url("../../img/pais.jpg");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      color:white;
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color:white;
    }

    .message {
      padding: 20px;
      background-color: #333;
      color:white;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .success {
      color: white;
   
    }

    .error {
      color: #ff0000;
    }

    .back-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #ff4500;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      cursor: pointer;
      margin-inline: 5px;
    }

    .back-button:hover {
      background-color: #af3915;
    }
  </style>
  </style>
</head>
<body>
  <div class="container">
    <div class="message">
      <?php
  include_once "../../Persistencia/conexion.php";
     
     class RegisterPais extends Conexion {
         public function cargarPaises($bandera, $nombre) {
             $conexion = $this->conectar();
     
             // Escapar el valor del nombre del país para evitar inyección de SQL
             $nombre_pais = $conexion->real_escape_string($nombre);
     
             // Consultar si el país ya existe en la base de datos
             $query = "SELECT nombre FROM paises WHERE nombre = '$nombre_pais'";
             $result = $conexion->query($query);
     
             if ($result && $result->num_rows > 0) {
                 echo "<p class=\"error\">Error: El nombre del país '$nombre' ya ha sido registrado.</p>";
                 echo "<a class=\"back-button\" href=\"../../index.php\">Inicio</a>";
                 echo "<a class=\"back-button\" href=\"../pais.php\">Volver</a>";
                 exit; // Detener la ejecución del script
             }
     
             // Si pasa las validaciones anteriores, podemos agregar el país a la base de datos
             $sql = "INSERT INTO paises (bandera, nombre) VALUES ('$bandera', '$nombre_pais')";
     
             if ($conexion->query($sql)) {
                 echo "<p class=\"success\">El país '$nombre' ha sido registrado correctamente.</p>";
             } else {
                 echo "Error: " . $sql . "<br>" . $conexion->error;
             }
     
             $this->desconectar();
         }
     }
     
     // Uso de la clase RegisterPais
     if (isset($_POST["pais"])) {
         $pais = trim($_POST["pais"]); 
     
         if (empty($pais)) {
             echo "<p class=\"error\">Error: El nombre del país no puede estar vacío.</p>";
             echo "<a class=\"back-button\" href=\"../../index.php\">Inicio</a>";
             echo "<a class=\"back-button\" href=\"../pais.php\">Volver</a>";
             exit; // Detener la ejecución del script
         }
     
         $register_pais = new RegisterPais();
         $register_pais->cargarPaises("", $pais);
     
         // Mostrar el botón de volver
         echo "<a class=\"back-button\" href=\"../../index.php\">Inicio</a>";
         echo "<a class=\"back-button\" href=\"../pais.php\">Volver</a>";
     }
     ?>
    </div>
  </div>
</body>
</html>
