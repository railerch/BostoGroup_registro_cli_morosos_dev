window.addEventListener("load", function () {
    console.log("DOM is ready.")

    // INICIAR SESION
    if (!sessionStorage.getItem("sesion")) {
        $("#inicio-sesion-modal").modal("show");

        document.getElementById("iniciar-sesion-btn").addEventListener("click", function () {
            let usuario = document.getElementById("usuario").value;
            let clave = document.getElementById("clave").value;
            let avisoSesion = document.getElementById("aviso-sesion");

            if (usuario.toLowerCase() == "ventas" && clave == "Ventas01") {
                avisoSesion.style.display = "block";
                avisoSesion.classList.add("alert-success");
                avisoSesion.innerText = "Acceso concedido!"
                setTimeout(() => {
                    sessionStorage.setItem("sesion", true)
                    avisoSesion.style.display = "none";
                    avisoSesion.classList.remove("alert-success");
                    $("#inicio-sesion-modal").modal("hide");
                    document.querySelectorAll("#inicio-sesion-modal input").forEach(el => el.value = "")
                }, 1500);
            } else {
                avisoSesion.style.display = "block";
                avisoSesion.classList.add("alert-danger")
                avisoSesion.innerText = "Datos incorrectos."
                setTimeout(() => {
                    avisoSesion.style.display = "none";
                    avisoSesion.classList.remove("alert-danger")
                }, 2000);
            }

        })
    }

    // CERRAR SESION
    document.getElementById("cerrar-sesion-btn").addEventListener("click", function () {
        sessionStorage.removeItem("sesion");
        $("#inicio-sesion-modal").modal("show");
    })

    // REGISTRAR CLIENTE
    document.getElementById("registrar-cliente-btn").addEventListener("click", function (evt) {
        evt.preventDefault();
        let data = new FormData(document.getElementById("datos-registro-frm"));
        reiniciar_aviso_usuario();
        let registrar = true;

        // Validar que no existan campos vacios
        document.querySelectorAll("#datos-registro-frm .form-control").forEach(el => {
            if (el.value == "") {
                aviso_warning("Debe completar todos los campos del formulario.");
                registrar = false;
            }
        })

        // Enviar datos para el registro
        if (registrar) {
            fetch("ctrl.php?registrar-cliente=true", { method: "post", body: data })
                .then(res => res.json())
                .then(res => {
                    if (res) {
                        aviso_success("Cliente registrado correctamente.")
                        document.getElementById("datos-registro-frm").reset();
                    }
                })
                .catch(err => {
                    aviso_danger("Error al registrar el cliente, valide los datos e intente nuevamente.");
                })
        }
    })

    // REINICIAR FORMULARIO
    document.getElementById("cancelar-registro-btn").addEventListener("click", function (evt) {
        evt.preventDefault();
        document.getElementById("datos-registro-frm").reset();
    })

    // CARGAR CLIENTES REGISTRADOS
    document.getElementById("clientes-registrados-tab").addEventListener("click", function () {
        fetch("ctrl.php?consultar-clientes=true")
            .then(res => res.json())
            .then(res => {
                // REINICIAR DATATABLE
                $("#clientes-registrados-tbl").DataTable().clear();
                $("#clientes-registrados-tbl").DataTable().destroy();
                $("#clientes-registrados-tbl tbody").empty();
                document.getElementById("clientes-registrados-tbl").append(document.createElement("tbody"));

                // GENERAR TABLA DE DATOS
                let cabecera = ["Codigo", "Nombre", "Cedula/RIF", "Deuda", "Observaciones"];
                let body = document.querySelector("#clientes-registrados-tbl tbody");
                body.innerHTML = "";

                // =====> Crear filas
                res.forEach(reg => {
                    let tr = document.createElement("tr");
                    tr.setAttribute("id", reg.id);

                    cabecera.forEach(th => {
                        let td = document.createElement("td");
                        switch (th) {
                            case "Codigo":
                                td.innerText = reg.co_cli;
                                break;
                            case "Nombre":
                                td.innerText = reg.cli_des;
                                break;
                            case "Cedula/RIF":
                                td.innerText = reg.cedula_rif;
                                break;
                            case "Deuda":
                                td.innerText = reg.deuda_act;
                                td.classList.add(`cli-${reg.co_cli.trim()}`);
                                td.setAttribute("data-cell", "deuda")
                                td.setAttribute("contenteditable", true);
                                break;
                            case "Observaciones":
                                td.innerText = reg.coment;
                                td.classList.add(`cli-${reg.co_cli.trim()}`);
                                td.setAttribute("data-cell", "observaciones")
                                td.setAttribute("contenteditable", true);
                                break;
                        }
                        tr.appendChild(td);
                    })

                    // =====> Boton de eliminar y actualizar
                    let delBtn = document.createElement("td");
                    delBtn.style.textAlign = "center";
                    delBtn.innerHTML =
                        `<button class="btn btn-outline-success btn-sm actualizar-icon-btn mt-2" data-co-cli="${reg.co_cli}" title="Actualizar registro"><i class="icon-arrows-cw"></i></button>
                        <button class="btn btn-outline-danger btn-sm eliminar-icon-btn mt-2" data-co-cli="${reg.co_cli}" data-bs-toggle="modal" data-bs-target="#eliminar-registro-modal" title="Eliminar registro"><i class="icon-trash"></i></button>`
                    tr.appendChild(delBtn);

                    // =====> Agregar fila a la tabla
                    body.appendChild(tr);
                })

                // ACTUALIZAR DEUDA Y OBSERVACIONES DEL REGISTRO
                document.querySelectorAll(".actualizar-icon-btn").forEach(btn => {
                    btn.addEventListener("click", function (evt) {
                        let coCli = this.getAttribute("data-co-cli");
                        let data = new FormData();
                        data.append("co-cli", coCli);
                        data.append("deuda", document.querySelector(`#clientes-registrados-tbl tbody tr td.cli-${coCli}[data-cell=deuda]`).innerText);
                        data.append("coment", document.querySelector(`#clientes-registrados-tbl tbody tr td.cli-${coCli}[data-cell=observaciones]`).innerText);

                        // Enviar datos para actualizar
                        reiniciar_aviso_usuario();
                        fetch("ctrl.php?actualizar-cliente=true", { method: "post", body: data })
                            .then(res => res.json())
                            .then(res => {
                                if (res) {
                                    aviso_success("Registro actualizado correctamente.");
                                    document.getElementById("datos-registro-frm").reset();
                                }
                            })
                            .catch(err => {
                                aviso_danger("Error al actualizar el registro, intente nuevamente.");
                            })
                    })
                })

                // ELIMINAR REGISTRO
                document.querySelectorAll(".eliminar-icon-btn").forEach(btn => {
                    btn.addEventListener("click", function () {
                        registroTmp = document.activeElement;
                        document.getElementById("eliminar-registro-btn").setAttribute("data-co-cli", this.getAttribute("data-co-cli"));
                    })
                })

                // ACTIVAR DATATABLE
                $(".table").DataTable({
                    "language": {
                        "url": "../../config/dataTableSpanish.json"
                    },
                    "order": [
                        [0, "asc"]
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            })
            .catch(err => {
                console.log(`ERROR: ${err}`);
                document.querySelector("#aviso-usuario .alert").classList.add("alert-danger");
                document.querySelector("#aviso-usuario #mensaje").innerText = "Error al consultar registros, intente nuevamente."
                $("#aviso-usuario").modal("show");
            })
    })

    // CONFIRMAR ELIMINAR REGISTRO
    let registroTmp;
    document.getElementById("eliminar-registro-btn").addEventListener("click", function () {
        let coCli = this.getAttribute("data-co-cli");
        reiniciar_aviso_usuario();

        fetch(`ctrl.php?eliminar-cliente=true&co-cli=${coCli}`)
            .then(res => res.json())
            .then(res => {
                if (res) {
                    $(".table").DataTable()
                        .row($(registroTmp).parents("tr"))
                        .remove()
                        .draw()

                    // Aviso al usuario
                    aviso_success("Cliente eliminado correctamente.");
                }
            })
            .catch(err => {
                // Aviso al usuario
                aviso_danger("Error al eliminar el cliente, intente nuevamente.");
            })
    })

    // AVISOS DE USUARIO

    // =====> Reiniciar aviso
    function reiniciar_aviso_usuario() {
        document.querySelector("#aviso-usuario .alert").classList.remove("alert-success");
        document.querySelector("#aviso-usuario .alert").classList.remove("alert-danger");
        document.querySelector("#aviso-usuario .alert").classList.remove("alert-warning");
    }

    // =====> Aviso success
    function aviso_success(mensaje) {
        document.querySelector("#aviso-usuario .alert").classList.add("alert-success");
        document.querySelector("#aviso-usuario #mensaje").innerText = mensaje
        $("#aviso-usuario").modal("show");
    }

    // =====> Aviso Warning
    function aviso_warning(mensaje) {
        document.querySelector("#aviso-usuario .alert").classList.add("alert-warning");
        document.querySelector("#aviso-usuario #mensaje").innerText = mensaje;
        $("#aviso-usuario").modal("show");
    }

    // =====> Aviso Danger
    function aviso_danger(mensaje) {
        document.querySelector("#aviso-usuario .alert").classList.add("alert-danger");
        document.querySelector("#aviso-usuario #mensaje").innerText = mensaje;
        $("#aviso-usuario").modal("show");
    }

})

