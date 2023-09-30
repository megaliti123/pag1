<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro y Estadísticas de Empleados</title>
</head>
<body>

<?php
// Inicializar el arreglo para almacenar los datos de las personas
$personas = [];

// Verificar si se enviaron datos mediante el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
    // Recoger los datos del formulario de registro
    for ($i = 1; $i <= 5; $i++) {
        $nombre = $_POST["nombre$i"];
        $apellido = $_POST["apellido$i"];
        $sexo = $_POST["sexo$i"];
        $edad = $_POST["edad$i"];
        $estadoCivil = $_POST["estadoCivil$i"];
        
        // Verificar si el campo de sueldo fue enviado
        $sueldoKey = "sueldo$i";
        $sueldo = isset($_POST[$sueldoKey]) ? $_POST[$sueldoKey] : 0;

        // Almacenar los datos en un arreglo asociativo
        $personas[] = [
            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "Sexo" => $sexo,
            "Edad" => $edad,
            "Estado Civil" => $estadoCivil,
            "Sueldo" => $sueldo
        ];
    }
}

// Mostrar los datos ingresados
if (!empty($personas)) {
    echo "<h2>Datos Ingresados:</h2>";
    foreach ($personas as $index => $persona) {
        echo "<h3>Persona " . ($index + 1) . ":</h3>";
        foreach ($persona as $key => $value) {
            echo "<p><strong>$key:</strong> $value</p>";
        }
    }

    // Calcular estadísticas
    $totalMujeres = 0;
    $totalHombresCasados = 0;
    $totalMujeresViudas = 0;
    $sumaEdadHombres = 0;
    $countHombres = 0;

    foreach ($personas as $persona) {
        $sexo = $persona['Sexo'];
        $estadoCivil = $persona['Estado Civil'];
        $sueldo = $persona['Sueldo'];

        // Estadística 1: Total de mujeres
        if ($sexo == 'Femenino') {
            $totalMujeres++;
        }

        // Estadística 2: Total de hombres casados que ganan más de 2500
        if ($sexo == 'Masculino' && $estadoCivil == 'Casado' && $sueldo > 2500) {
            $totalHombresCasados++;
        }

        // Estadística 3: Total de mujeres viudas que ganan más de 1000
        if ($sexo == 'Femenino' && $estadoCivil == 'Viudo' && $sueldo > 1000) {
            $totalMujeresViudas++;
        }

        // Estadística 4: Edad promedio de los hombres
        if ($sexo == 'Masculino') {
            $sumaEdadHombres += $persona['Edad'];
            $countHombres++;
        }
    }

    // Calcular la edad promedio de los hombres
    $promedioEdadHombres = $countHombres > 0 ? $sumaEdadHombres / $countHombres : 0;

    // Mostrar las estadísticas
    echo "<h2>Estadísticas Calculadas:</h2>";
    echo "<p>Total de mujeres: $totalMujeres</p>";
    echo "<p>Total de hombres casados que ganan más de 2500: $totalHombresCasados</p>";
    echo "<p>Total de mujeres viudas que ganan más de 1000: $totalMujeresViudas</p>";
    echo "<p>Edad promedio de los hombres: $promedioEdadHombres</p>";
}
?>

<h2>Registro de Personas</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <h3>Persona <?php echo $i; ?></h3>
        <label for="nombre<?php echo $i; ?>">Nombre:</label>
        <input type="text" name="nombre<?php echo $i; ?>" required>
        <br>

        <label for="apellido<?php echo $i; ?>">Apellido:</label>
        <input type="text" name="apellido<?php echo $i; ?>" required>
        <br>

        <label for="sexo<?php echo $i; ?>">Sexo:</label>
        <select name="sexo<?php echo $i; ?>" required>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
        </select>
        <br>

        <label for="edad<?php echo $i; ?>">Edad:</label>
        <input type="number" name="edad<?php echo $i; ?>" required>
        <br>

        <label for="estadoCivil<?php echo $i; ?>">Estado Civil:</label>
        <select name="estadoCivil<?php echo $i; ?>" required>
            <option value="Soltero">Soltero</option>
            <option value="Casado">Casado</option>
            <option value="Viudo">Viudo</option>
            <option value="Divorciado">Divorciado</option>
        </select>
        <br>

        <!-- Agregamos el campo de sueldo -->
        <label for="sueldo<?php echo $i; ?>">Sueldo:</label>
        <input type="number" name="sueldo<?php echo $i; ?>" required>
        <br><br>
    <?php endfor; ?>

    <input type="submit" name="registrar" value="Registrar">
</form>

</body>
</html>
