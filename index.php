<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes morosos</title>
    <?php include("../../modLinks.php") ?>
</head>

<body>
    <!-- CABECERA -->
    <header class="container mt-3 p-2">
        <div class="d-flex justify-content-between col-12">
            <h1 class="m-0"><i class="icon-user"></i> Registro de morosos</h1>
            <button id="cerrar-sesion-btn" type="button" class="btn btn-outline-light"><i class="icon-logout"></i>Salir</button>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container pt-3">
        <!-- NAV TABS -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="registro-clilente-tab" data-bs-toggle="tab" data-bs-target="#registro-clilente" type="button" role="tab" aria-controls="registro-clilente" aria-selected="true">Registro de clientes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="clientes-registrados-tab" data-bs-toggle="tab" data-bs-target="#clientes-registrados" type="button" role="tab" aria-controls="clientes-registrados" aria-selected="false">Clientes registrados</button>
            </li>
        </ul>

        <!-- TAB PANES -->
        <div class="tab-content">
            <!-- Registro de clientes -->
            <div class="tab-pane active py-3 px-5" id="registro-clilente" role="tabpanel" aria-labelledby="registro-clilente-tab">
                <h4 class="text-muted">Datos de registro</h4>
                <form id="datos-registro-frm">
                    <div class="input-group">
                        <div class="input-group-text col-1">
                            <span>Codigo Cli.</span>
                        </div>
                        <input type="text" name="co-cli" id="co-cli" class="form-control" placeholder="CEA-00000 (dato unico)">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-text col-1">
                            <span>Nombre</span>
                        </div>
                        <input type="text" name="cli-des" id="cli-des" class="form-control" placeholder="Nombre ó Razon social">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-text col-1">
                            <span>Cedula/RIF</span>
                        </div>
                        <input type="text" name="cedula-rif" id="cedula-rif" class="form-control" placeholder="V99999999 (dato unico)">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-text col-1">
                            <span>Deuda Cli.</span>
                        </div>
                        <input type="number" name="deuda" id="deuda" class="form-control" placeholder="0.00">
                    </div>
                    <div class="form-group mt-2">
                        <label for="observaciones">Observaciones:</label>
                        <textarea type="number" name="observaciones" id="observaciones" class="form-control" style="resize:none"></textarea>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <div class="btn-group">
                            <button id="cancelar-registro-btn" class="btn btn-outline-secondary"><i class="icon-block"></i> Cancelar</button>
                            <button id="registrar-cliente-btn" class="btn btn-outline-secondary"><i class="icon-ok"></i> Registrar</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Clientes registrados -->
            <div class="tab-pane p-3" id="clientes-registrados" role="tabpanel" aria-labelledby="clientes-registrados-tab">
                <div class="table-responsive">
                    <table id="clientes-registrados-tbl" class="table table-hover table-striped">
                        <thead>
                            <tr id="">
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Cedula/RIF</th>
                                <th>Deuda</th>
                                <th>Observaciones</th>
                                <th class="text-center">Acc</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Registros -->
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </main>

    <!-- PIE DE PAGINA -->
    <footer class="container text-center text-muted">
        <hr>
        <p>Solo para uso del Departamento comercial.</p>
    </footer>

    <!-- MODAL INICIO DE SESION -->
    <?php include("./ventanas-modal.php") ?>
</body>

</html>