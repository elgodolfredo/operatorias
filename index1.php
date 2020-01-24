<?php
session_start();

error_reporting(0);

set_include_path('scripts');
include 'funciones.inc.php';
include 'comunes.inc.php';

if (isset($_REQUEST['accion']) && ($_REQUEST['accion'] == 'logout')) {
    session_destroy();
    header("location: $path");
    exit();
}

include 'conexion.inc.php';

if (!$conexion) {
    echo 'Error de conexion';
    exit();
}

// Cargo la configuracion del sistema
$scriptSeteaConfig = cargarConfiguracion($conexion); // A partir de aca tengo la variable $_SESSION['config']
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="js/libs/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <link href="css/font-awesome.min.css" rel="stylesheet">

        <link href="css/estilos.css?<?php echo time(); ?>" rel="stylesheet">

        <link rel="shortcut icon" href="favicon.ico">

    <!-- <script src="js/libs/jquery-ui-1.12.1/external/jquery/jquery.js"></script> -->

        <script src="js/libs/jquery-3.1.1.min.js"></script>

    <!-- <script src="js/libs/jquery-ui-1.12.1/jquery-ui.min.js"></script> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <script src="js/comunes.js?<?php echo time(); ?>"></script>

        <?php
        echo $scriptSeteaConfig;
        ?>

        <script>
            $(function () {
                //
            });
        </script>

        <title>Operatorias</title>
    </head>





    <body>
        <div>

            <?php
//            if (isset($_REQUEST['accion']) && ($_REQUEST['accion'] == 'logout')) {
//                session_destroy();
//                header("location: $path");
//                exit();
//            }
//
//      if (isset($_REQUEST['accion']) && $_REQUEST['accion'] == 'login') {
//
//      }

            if (!isset($_SESSION['username'])) {
                include 'login.php';
            } else {
                ?>

                <!-- Menu -->
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <!--           <a class="navbar-brand" href="#">Navbar</a>
                              <button class="navbar-toggler" type="button" data-toggledark"collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                              </button> -->
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php?accion=titulares">Titulares <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?accion=cotitulares">Cotitulares</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?accion=garantes">Garantes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?accion=creditos">Creditos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?accion=logout">Salir</a>
                            </li>
                        </ul>
                    </div>
                    <div style="text-align: right; color: white;">
                        <?php
                        echo 'Usuario: ' . $_SESSION['username'];
                        ?>
                    </div>                  
                </nav>

                <div class="container top20">
                    
                    <div id="area-notif" class="container alerta"></div>
                    
                    <?php
                    // Segun sea la accion, muestro el contenido
                    $accion = $_REQUEST['accion'];
                    switch ($accion) {
                        case 'titulares':
                        case 'eliminar-titular':
                        case 'editar-titular':
                        case 'nuevo-titular':
                        case 'cotitulares':
                        case 'eliminar-cotitular':
                        case 'editar-cotitular':
                        case 'nuevo-cotitular':
                        case 'garantes':
                        case 'eliminar-garante':
                        case 'editar-garante':
                        case 'nuevo-garante':
                            include 'titulares.php';
                            break;
                        case 'creditos':
                            include 'creditos.php';
                            break;
                        default:
                            include 'default.php';
                            break;
                    }
                    ?>
                </div>
                <?php
            }
            ?>

        </div>
    </body>
</html>
