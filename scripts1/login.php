<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    include 'conexion.inc.php';
    if (!$conexion) {
        $error = 'No se puede acceder a la base de datos';
    } else {
        // proceso de logueo
        // extract($_POST);
        // extraigo de a uno los parametros
        $username = $_POST['username'];
        $password = $_POST['password'];

        $consulta = "select * from usuarios where username = '$username' limit 1";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            if (mysqli_num_rows($resultado) > 0) {
                // Verifico la contraseña
                $registro = mysqli_fetch_assoc($resultado);
                
                if ($registro['password'] == cifrar($password)) {
                    // usuario y password correctos
                    $_SESSION['username'] = $username;
                } else {
                    
                    $_SESSION['mensaje'] = 'Usuario o Contraseña incorrectos';
                }
                
            } else {
                $_SESSION['mensaje'] = 'Usuario o Contraseña incorrectos';
            }
        } else {
            $_SESSION['mensaje'] = 'Error de comprobacion de credenciales';
        }
    }

    header("location: $path");
    exit();
}
?>

<?php
if (isset($error)) {
    echo "<div class='w3-panel w3-pale-red'><p>$error</p></div>";
}
?>

<form id="form-login" method="post" action="index.php">
    <div id='img-login'>
    </div>

    <input type="hidden" name="accion" value="login">
    
    <div class="form-group">
        <div>
            <label for="username" class="w3-text-gray">Usuario</label>
            <input type="text" id="username" name="username" class="form-control" autofocus value="admin">
            <span class="campo-invalido"></span>
        </div>
    </div>

    <div>
        <div class="form-group">
            <label for="password" class="w3-text-gray">Contrase&ntilde;a</label>
            <input type="password" id="password" name="password" class="form-control" value="admin">
            <span class="campo-invalido"></span>
        </div>
    </div>


    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
</form>

<script src="scripts/login.js?<?php echo time(); ?>"></script>
