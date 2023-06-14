<!-- MODAL INICIO DE SESION -->
<div class="modal fade" id="inicio-sesion-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document" style="min-width:400px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"><i class="icon-id-card-o"></i> DATOS DE ACCESO</h5>
            </div>
            <div class="modal-body d-grid gap-2">
                <div class="input-group">
                    <div class="input-group-text col-3">
                        <span>Usuario</span>
                    </div>
                    <input type="text" class="form-control" id="usuario">
                </div>

                <div class="input-group">
                    <div class="input-group-text col-3">
                        <span>Clave</span>
                    </div>
                    <input type="password" class="form-control" id="clave">
                </div>

                <div id="aviso-sesion" class="alert text-center" role="alert" style="display:none"></div>

            </div>
            <div class="modal-footer">
                <button id="iniciar-sesion-btn" type="button" class="btn btn-primary"><i class="icon-login"></i> Entrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AVISO ELIMINAR -->
<div class="modal fade" id="eliminar-registro-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="false">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document" style="min-width:400px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId"><i class="icon-trash"></i> ELIMINAR REGISTRO</h5>
            </div>
            <div class="modal-body">
                <p>Desea eliminar el cliente seleccionado?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                <button id="eliminar-registro-btn" type="button" class="btn btn-danger" data-bs-dismiss="modal">Si</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AVISO USUARIO -->
<div class="modal fade" id="aviso-usuario" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert text-center m-0" role="alert">
                    <p id="mensaje" class="m-0"></p>
                </div>
            </div>
        </div>
    </div>
</div>