<link href="../css/w3.css" rel="stylesheet">

<div id="w3-container">
        <div id="btnAddTitular">
            <button id="goNuevoTitular" class=""><i class="icon-plus"></i>Agregar</button>
        </div>
        <div>
            <table id="listadoTitulares" class="table table-striped table-bordered table-hover table-condensed listaOK">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>N° de Doc.</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody id="listaTitularesOK">
                    <?php echo $consultaDeTitulares; ?>
                </tbody>
            </table>
        </div>
</div>