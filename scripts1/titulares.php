<?php
//session_start();
include 'chequear_sesion.php'
?>
<!--<script type="text/javascript" src="js/jsTitular.js?<?php //echo time();           ?>"></script>-->
<script src="js/libs/jquery-validate/jquery.validate.min.js"></script>
<script src="js/libs/jquery-validate/messages_es.js"></script>

<script type="text/javascript">
  var accion = "<?php echo $_GET['accion'] ?>";
  var tabla = "<?php echo $_GET['accion'] ?>";
</script>

<?php
include 'conexion.inc.php';

if (!$conexion) {
  $error = 'Error de conexion';
} else {
  $accion = $_REQUEST['accion'];
  switch ($accion) {
    case 'eliminar-titular':
      if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        extract($_GET);
        $consulta = "delete from titulares where id = $id";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
          $mensaje = 'El titular fue eliminado correctamente.';
        } else {
          $error = 'No se pudo eliminar el titular.';
        }
      } else {
        $error = 'No se indico el titular que desea eliminar.';
      }
    // no break
    case 'nuevo-titular':
      echo 'Nuevo: ' . $_POST['nombre'] . ' ' . $_POST['apellido'];
      break;
    case 'editar-titular':
    default:
      $accion = $_REQUEST['accion'];
      if ($accion == 'titulares') {
        $consulta = 'select id, id_persona, apellido, nombre, nro_docu from titulares_full';
      } elseif ($accion == 'cotitulares') {
        $consulta = 'select id, id_titular, id_persona, apellido, nombre, nro_docu from cotitulares_full';
      } else {
        $consulta = 'select id, id_titular, id_persona, apellido, nombre, nro_docu from garantes_full';
      }

      $resultado = @mysqli_query($conexion, $consulta);
      if (!$resultado) {
        $error = 'No se puede acceder a los datos.';
      } else {
        ?>



        <!-- Aca se coloca el boton para agregar un registro y la lista de titulares -->
        <div>
            <?php
            if (isset($error)) {
              echo "<div class='w3-panel w3-pale-red'><p>$error</p></div>";
            } else {
              ?>

              <!-- Dialogo para buscar un titular -->
              <div id="dialog-buscar-titular" title="Buscar titular" class="modal fade bd-example-modal-lg" role="dialog">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h3>Buscar titular</h3>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">

                          </div>
                      </div>

                      <label for="txt-titular-buscado">Ingrese el nombre o apellido del titular</label>
                      <input type="text" id="txt-titular-buscado" class="form-control">
                      <br>
                      <table class="table" id="tbl-titulares-buscados">
                      </table>
                  </div>
              </div>

              <!-- Dialogo con formulario para editar los datos de un titular -->
              <div class="modal fade bd-example-modal-lg" role="dialog" id="dialog-edit-tit" title="Titular" >
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">

                          <div class="modal-header">
                              <h3 class="modal-title">Editar titular</h3>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>

                          <div class="modal-body">

                              <form id="form-titular">

                                  <input type="hidden" id="accion" name="accion" />
                                  <input type="hidden" id="id" name="id">
                                  <input type="hidden" id="id_persona" name="id_persona" >

                                  <?php
                                  if (($_GET['accion'] == 'cotitulares') || ($_GET['accion'] == 'garantes')) {
                                    echo '<div class="form-row">
                                            <div class="form-group col-md-11">
                                              <label for="titular">Titular</label>
                                              <input id="titular" name="titular" value="" readonly="readonly" type="text" class="form-control">
                                              <input id="id_titular" name="id_titular" type="hidden">
                                              <span class="campo-invalido"></span>
                                            </div>
                                            <div class="form-group col-md-1">
                                              <label>&nbsp;</label>
                                              <button id="btn-buscar-titular" class="btn btn-success bloque" data-toggle="modal" data-target="#dialog-buscar-titular">...</button>
                                            </div>
                                          </div>';
                                  }
                                  include 'campos_persona.php';
                                  ?>
                                  <button type="submit" name="aceptar" class="btn btn-success" >Aceptar</button>
                              </form>
                          </div>

                          <!-- <div class="modal-footer">

                          </div> -->
                      </div>
                  </div>
              </div>              


              <?php
// Configuro el titulo de la pagina y el tipo_persona para saber en que tabla debo grabar
              if ($_REQUEST['accion'] == 'titulares') {
                $titulo = 'Titulares';
                $tipo_persona = 'titulares';
              } elseif ($_REQUEST['accion'] == 'cotitulares') {
                $titulo = 'Cotitulares';
                $tipo_persona = 'cotitulares';
              } else {
                $titulo = 'Garantes';
                $tipo_persona = 'garantes';
              }
              echo "<input type='hidden' id='tipo_persona' value='$tipo_persona'>";
              ?>

              <?php echo "<h3>$titulo</h3>"; ?>
                                                                                                                                                                                                                                                                                                                                                                                      <!--<button id="goNuevoTitular" class="btn btn-primary btn-small"><i class="icon-plus"></i>Agregar</button>-->

              <!--                        <div id="area-notif" class="container alerta"></div>-->
              <button type="button" id="btn-nuevo-titular" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#dialog-edit-tit">Nuevo</button>

              <table id="listadoTitulares" class="table table-sm table-hover top20">
                  <thead class="thead-dark">
                      <tr>
                          <th scope="col">Nombre</th>
                          <th scope="col">Apellido</th>
                          <th scope="col">N° de Doc.</th>
                          <th scope="col" colspan="2">Operaciones</th>
                      </tr>
                  </thead>

                  <tbody id="listaTitularesOK"></tbody>

              </table>
          </div>
        <?php }
        ?>

        </div>
        <?php
      }
      break;
  }
}
?>

<script src="js/titulares.js?<?php echo time(); ?>"></script>

<!-- Aca se coloca el dialogo de confirmacion de borrado -->
<!--<div id="dialogo-borrar" title="Eliminar registro" class="modal-dialog">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;">Confirma que desea eliminar este registro?</span></p>
</div>-->
