<?php
  /* Chequeo que el usuario se haya logueado. Aca asumo que ya se hizo session_start() */
  if (!isset($_SESSION['username'])) {
    header('location: /operatoriasNew');
  }
?>