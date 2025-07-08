<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "login_php";

try {
    $con = new mysqli($servidor, $usuario, $password, $base_datos);
    
    if ($con->connect_error) {
        throw new Exception("Error de conexión a la base de datos");
    }

    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password) ) {
        throw new Exception("Todos los campos son obligatorios");
    }
    
    if ($password !== $confirm_password) {
        throw new Exception("Las contraseñas no coinciden");
    }
    
 
    $stmt = $con->prepare("SELECT id FROM datos WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows > 0) {
        throw new Exception("Este email ya está registrado");
    }
    

    $hash = password_hash($password, PASSWORD_DEFAULT);
    
   
    $stmt = $con->prepare("INSERT INTO datos (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $hash);
    
    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href = 'login.html';</script>";
    } else {
        throw new Exception("Error al registrar el usuario");
    }
    
} catch (Exception $e) {
    echo "<script>alert('".addslashes($e->getMessage())."'); window.history.back();</script>";
} finally {
    if (isset($con)) {
        $con->close();
    }
}
?>