<?php
session_start();

if (!isset($_SESSION['produtos'])) $_SESSION['produtos'] = array();
if (!isset($_SESSION['enderecos'])) $_SESSION['enderecos'] = array();
if (!isset($_SESSION['transportadores'])) $_SESSION['transportadores'] = array();
if (!isset($_SESSION['fretes'])) $_SESSION['fretes'] = array();

function moeda($valor) {
    return "R$ " . number_format($valor, 2, ",", ".");
}

function dataBr($data) {
    $p = explode("-", $data);
    if (count($p) == 3) return $p[2] . "/" . $p[1] . "/" . $p[0];
    return $data;
}

if (isset($_POST['salvar_produto'])) {
    $id = $_POST['id'] != "" ? $_POST['id'] : count($_SESSION['produtos']) + 1;
    $_SESSION['produtos'][$id] = array(
        'id' => $id,
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco']
    );
    header("Location: index.php?tela=cadastros");
    exit;
}

if (isset($_POST['salvar_endereco'])) {
    $id = $_POST['id'] != "" ? $_POST['id'] : count($_SESSION['enderecos']) + 1;
    $_SESSION['enderecos'][$id] = array(
        'id' => $id,
        'tipo' => $_POST['tipo'],
        'cidade' => $_POST['cidade']
    );
    header("Location: index.php?tela=cadastros");
    exit;
}

if (isset($_POST['salvar_transportador'])) {
    $id = $_POST['id'] != "" ? $_POST['id'] : count($_SESSION['transportadores']) + 1;
    $_SESSION['transportadores'][$id] = array(
        'id' => $id,
        'nome' => $_POST['nome'],
        'placa' => $_POST['placa']
    );
    header("Location: index.php?tela=cadastros");
    exit;
}

if (isset($_POST['salvar_frete'])) {
    $id = count($_SESSION['fretes']) + 1;
    $itens = array();

    for ($i = 0; $i < count($_POST['produto_id']); $i++) {
        $pid = $_POST['produto_id'][$i];
        $qtd = $_POST['quantidade'][$i];
        if ($pid != "" && isset($_SESSION['produtos'][$pid])) {
            $itens[] = array(
                'nome' => $_SESSION['produtos'][$pid]['nome'],
                'qtd' => $qtd
            );
        }
    }

    $_SESSION['fretes'][$id] = array(
        'id' => $id,
        'data' => $_POST['data'],
        'transportador' => $_POST['transportador'],
        'origem' => $_POST['origem'],
        'destino' => $_POST['destino'],
        'valor' => $_POST['valor'],
        'itens' => $itens
    );

    header("Location: index.php?tela=frete");
    exit;
}

if (isset($_GET['baixar'])) {
    $dia = $_GET['dia'];
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=fretes_" . $dia . ".csv");
    echo "\xEF\xBB\xBF";

    $fp = fopen("php://output", "w");
    fputcsv($fp, array("ID", "Data", "Transportador", "Origem", "Destino", "Produtos", "Valor"), ";");

    foreach ($_SESSION['fretes'] as $f) {
        if ($f['data'] == $dia) {
            $prods = "";
            foreach ($f['itens'] as $item) {
                $prods .= $item['nome'] . " (" . $item['qtd'] . "x) ";
            }
            fputcsv($fp, array(
                $f['id'],
                dataBr($f['data']),
                $f['transportador'],
                $f['origem'],
                $f['destino'],
                $prods,
                moeda($f['valor'])
            ), ";");
        }
    }
    fclose($fp);
    exit;
}
?>