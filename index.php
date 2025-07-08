<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "login_php";

$enlace = mysqli_connect($servidor, $usuario, $password, $base_datos);

if (!$enlace) {
    die("Error de conexión: " . mysqli_connect_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['nombre'], $_POST['email'], $_POST['mensaje'])) {
        
        $nombre = mysqli_real_escape_string($enlace, $_POST['nombre']);
        $email = mysqli_real_escape_string($enlace, $_POST['email']);
        $password = mysqli_real_escape_string($password, $_POST['password']);

        $insertardatos = "INSERT INTO datos VALUES('$nombre', '$email', '$password', '')";
        
        if (mysqli_query($enlace, $insertardatos)) {
            echo "<script>alert('Registro exitoso');</script>";
        } else {
            echo "<script>alert('Error al registrar: " . mysqli_error($enlace) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario con PHP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-gray-300 p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-cyan-800">Formulario de PHP</h2>

        <form action="" method="post" class="space-y-4">
            <div>
                <label for="nombre" class="block text-cyan-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="block text-cyan-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="block text-cyan-700 text-sm font-bold mb-2">Mensaje:</label>
                <input type="password" id="password" name="password" required
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" id="registro" name="registro"
                        class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
                    Registrarse
                </button>
            </div>
        </form>
    </div>
</body>
</html>