<?php

$servidor = "localhost";
$usuario = "root";
$clave = "";
$base_datos = "login_php";


try {
    $con = new mysqli($servidor, $usuario, $clave, $base_datos);
    
    if ($con->connect_error) {
        throw new Exception("Error de conexión a la base de datos");
    }
    

    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    if (empty($nombre) || empty($email) || empty($password)) {
        throw new Exception("Todos los campos son obligatorios");
    }
    
    
    $stmt = $con->prepare("SELECT id, nombre, password FROM datos WHERE nombre = ? AND email = ?");
    $stmt->bind_param("ss", $nombre, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        
        if (password_verify($password, $usuario['password'])) {
            echo "<script>alert('Bienvenido $nombre'); window.location.href = 'bienvenido.php';</script>";
        } else {
            throw new Exception("Usuario o contraseña incorrectos");
        }
    } else {
        throw new Exception("Usuario o contraseña incorrectos");
    }
    
} catch (Exception $e) {
    echo "<script>alert('".addslashes($e->getMessage())."'); window.history.back();</script>";
} finally {
    if (isset($con)) {
        $con->close();
    }
}
?>