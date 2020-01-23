<?php
//include 'conexion.php';
?>
<h2>Generar debito</h2>
<hr>

<form action="">
  <div class="form-group">
    <label for="organismo">Organismo</label>
    <!-- <input type="text" name="organismo" id="organismo" class="form-control"> -->
    <?php
      generarOrganismos($conexion, '', '', "idOrgTit", '');
    ?>
  </div>

  <div class="form-group">
    <label for="periodo">Periodo</label>
    <select name="" id="" class="form-control">
      <option value="">01</option>
      <option value="">02</option>
      <option value="">03</option>
      <option value="">04</option>
      <option value="">05</option>
      <option value="">06</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Generar</button>

</form>

<script src="js/debitos.js"></script>