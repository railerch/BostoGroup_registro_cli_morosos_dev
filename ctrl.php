<?php
error_reporting(E_ALL);
date_default_timezone_set('America/caracas');

// CONEXION A LA BD
# ==================
try {
    $conn = new PDO("sqlite:data/data.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "ERROR EN CONEXIOn: " . $e->getMessage();
}

// FUNCIONES
# ====================
function depurar_texto(string $txt, bool $comment = false): string
{
    if ($comment) {
        $tmp = trim(addslashes(strip_tags($txt)));
    } else {
        $tmp = strtoupper(trim(addslashes(strip_tags($txt))));
    }

    return $tmp;
}

// REGISTROS
# ====================
if (@$_GET['registrar-cliente']) {
    $coCli      = depurar_texto($_POST['co-cli']);
    $cliDes     = depurar_texto($_POST['cli-des']);
    $cedulaRif  = depurar_texto($_POST['cedula-rif']);
    $deuda      = floatVal($_POST['deuda']);
    $coment     = depurar_texto($_POST['observaciones'], true);

    try {
        $stmt = $conn->prepare(
            "INSERT INTO cli_morosos (
            'id', 
            'co_cli', 
            'cli_des', 
            'cedula_rif', 
            'deuda_act', 
            'coment' ) 
            VALUES(
                NULL,
                '$coCli',
                '$cliDes',
                '$cedulaRif',
                $deuda,
                '$coment'
                )
        "
        );
        $stmt->execute();
        echo true;
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    exit();
}

if (@$_GET['actualizar-cliente']) {
    $coCli  = depurar_texto($_POST['co-cli']);
    $deuda  = floatVal($_POST['deuda']);
    $coment = depurar_texto($_POST['coment'], true);

    try {
        $stmt = $conn->prepare("UPDATE cli_morosos SET coment = '$coment', deuda_act = $deuda WHERE co_cli = '$coCli'");
        $stmt->execute();
        echo true;
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    exit();
}

if (@$_GET['eliminar-cliente']) {
    $coCli = $_GET['co-cli'];

    try {
        $stmt = $conn->query("DELETE FROM cli_morosos WHERE co_cli = '$coCli'");
        echo true;
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    exit();
}

if (@$_GET['consultar-clientes']) {
    try {
        $stmt = $conn->query("SELECT * FROM cli_morosos");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    exit();
}
