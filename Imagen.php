<?php
// Tamaño del cuadro 
$ancho = 600;
$alto = 200;
$ventas = array(
    array(
        "nombre" => "NOMBRE",
        "no_ventas" => "NO. VENTAS",
        "total" => "TOTAL",
    ),
    array(
        "nombre" => "BENJAS",
        "no_ventas" => 1,
        "total" => 1000000,
    ),
    array(
        "nombre" => "TONY",
        "no_ventas" => 100000,
        "total" => 5000,
    ),
    array(
        "nombre" => "INGE",
        "no_ventas" => 0,
        "total" => 0,
    ),
    array(
        "nombre" => "DANIEL",
        "no_ventas" => 10,
        "total" => 5,
    ),
    array(
        "nombre" => "Daniela",
        "no_ventas" => 100,
        "total" => 1000000000000,
    ),
    array(
        "nombre" => "Itzel",
        "no_ventas" => 100,
        "total" => 80,
    ),
    array(
        "nombre" => "Mariana",
        "no_ventas" => 100,
        "total" => 800,
    ),
     array(
        "nombre" => "Yocelin",
        "no_ventas" => 25648,
        "total" => 369852,
    ),
);

// Aqui vamos a calcular totales
$total_ventas = 0;  //se iniciara de 0
$total_ventas_sin_encabezado = 0; //solo agaarra los valores de total
foreach ($ventas as $Money => $venta) {
    if ($Money !== 0) {
        $total_ventas += $venta['total'];
        $total_ventas_sin_encabezado += $venta['total'];
    }
}

// Líneas verticales y su posición
$posicionesLineas = array(300, 400);

// Líneas horizontales y su posición 
$numFilas = count($ventas) + 1; 

// Crea la imagen 
$imagen = imagecreate($ancho, $alto);

// Colores a usar en la imagen
$colorblanco = imagecolorallocate($imagen, 255, 255, 255);
$coloram = imagecolorallocate($imagen, 0, 0, 255);
$colorRojo = imagecolorallocate($imagen, 255, 0, 0);
$colorNegro = imagecolorallocate($imagen, 0, 0, 0);

// Dibujar líneas verticales
foreach ($posicionesLineas as $posicion) {
    imageline($imagen, $posicion, 0, $posicion, $alto, $colorNegro);
}

// Dibujar líneas horizontales y escribir datos de ventas
$intervaloFilas = $alto / ($numFilas+1);
for ($i = 0; $i < $numFilas; $i++) {
    $y = $intervaloFilas * ($i + 1);

    // Dibujar líneas horizontales
    imageline($imagen, 0, $y, $ancho, $y, $colorNegro);

    // Escribir datos de ventas en cada espacio formado por las líneas
    if ($i < count($ventas)) {
        $venta = $ventas[$i];
        $nombre = $venta['nombre'];
        $no_ventas = $venta['no_ventas'];
        $total = ($i != 0) ? "$" . number_format((float) $venta['total'], 2, ".", ",") : $venta['total'];

        // Ajustar las coordenadas x para evitar superposición con las líneas verticales
        imagestring($imagen, 3, 10, $y - 10, $nombre, $colorNegro);
        imagestring($imagen, 3, $posicionesLineas[0] + 9, $y - 13, $no_ventas, $colorNegro);
        imagestring($imagen, 3, $posicionesLineas[1] + 9, $y - 13, $total, $colorNegro);
    } else {
        // Agregar una fila adicional para mostrar los totales
        imagestring($imagen, 3, 10, $y - 10, "Money ganado:", $colorNegro);
        imagestring($imagen, 3, $posicionesLineas[0] + 9, $y - 13, "", $colorNegro);
        imagestring($imagen, 3, $posicionesLineas[1] + 9, $y - 13, "$" . number_format((float) $total_ventas, 2, ".", ","), $colorNegro);
    }
}


// Guardar la imagen en un archivo temporal
$image_path = tempnam(sys_get_temp_dir(), 'ventas_');
imagepng($imagen, $image_path);

// Liberar memoria
imagedestroy($imagen);

// Configurar encabezados para la descarga
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="ventas.png"');
header('Content-Length: ' . filesize($image_path));

// Enviar el archivo
readfile($image_path);

// Eliminar el archivo temporal
unlink($image_path);
?>