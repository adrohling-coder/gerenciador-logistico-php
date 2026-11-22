<?php
include "funcoes.php";
$tela = isset($_GET['tela']) ? $_GET['tela'] : "cadastros";

$ep = isset($_GET['ep']) ? $_SESSION['produtos'][$_GET['ep']] : null;
$ee = isset($_GET['ee']) ? $_SESSION['enderecos'][$_GET['ee']] : null;
$et = isset($_GET['et']) ? $_SESSION['transportadores'][$_GET['et']] : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Logística</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Logística</a>
        <div class="d-flex gap-3">
            <a class="text-white text-decoration-none" href="index.php?tela=cadastros">Cadastros</a>
            <a class="text-white text-decoration-none" href="index.php?tela=frete">Frete</a>
            <a class="text-white text-decoration-none" href="index.php?tela=relatorio">Relatório</a>
        </div>
    </div>
</nav>

<div class="container pb-5">
<?php if ($tela == "cadastros") { ?>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Produto</h6>
                <form method="post" action="funcoes.php">
                    <input type="hidden" name="id" value="<?php echo $ep ? $ep['id'] : ''; ?>">
                    <input type="text" name="nome" class="form-control mb-2" placeholder="Nome" required value="<?php echo $ep ? $ep['nome'] : ''; ?>">
                    <input type="number" step="0.01" name="preco" class="form-control mb-2" placeholder="Preço" required value="<?php echo $ep ? $ep['preco'] : ''; ?>">
                    <button name="salvar_produto" class="btn btn-primary btn-sm">Salvar</button>
                </form>
                <hr>
                <?php foreach ($_SESSION['produtos'] as $p) { ?>
                    <div>#<?php echo $p['id']; ?> <?php echo $p['nome']; ?> (<?php echo moeda($p['preco']); ?>) <a href="index.php?ep=<?php echo $p['id']; ?>">Editar</a></div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h6>Endereço</h6>
                <form method="post" action="funcoes.php">
                    <input type="hidden" name="id" value="<?php echo $ee ? $ee['id'] : ''; ?>">
                    <select name="tipo" class="form-select mb-2">
                        <option value="Origem">Origem</option>
                        <option value="Destino">Destino</option>
                    </select>
                    <input type="text" name="cidade" class="form-control mb-2" placeholder="Cidade" required value="<?php echo $ee ? $ee['cidade'] : ''; ?>">
                    <button name="salvar_endereco" class="btn btn-primary btn-sm">Salvar</button>
                </form>
                <hr>
                <?php foreach ($_SESSION['enderecos'] as $e) { ?>
                    <div>#<?php echo $e['id']; ?> [<?php echo $e['tipo']; ?>] <?php echo $e['cidade']; ?> <a href="index.php?ee=<?php echo $e['id']; ?>">Editar</a></div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h6>Transportador</h6>
                <form method="post" action="funcoes.php">
                    <input type="hidden" name="id" value="<?php echo $et ? $et['id'] : ''; ?>">
                    <input type="text" name="nome" class="form-control mb-2" placeholder="Nome" required value="<?php echo $et ? $et['nome'] : ''; ?>">
                    <input type="text" name="placa" class="form-control mb-2" placeholder="Placa" required value="<?php echo $et ? $et['placa'] : ''; ?>">
                    <button name="salvar_transportador" class="btn btn-primary btn-sm">Salvar</button>
                </form>
                <hr>
                <?php foreach ($_SESSION['transportadores'] as $t) { ?>
                    <div>#<?php echo $t['id']; ?> <?php echo $t['nome']; ?> (<?php echo $t['placa']; ?>) <a href="index.php?et=<?php echo $t['id']; ?>">Editar</a></div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php } elseif ($tela == "frete") { ?>
    <div class="card p-3 mb-4">
        <h6>Gerar Frete</h6>
        <form method="post" action="funcoes.php">
            <div class="row g-2 mb-2">
                <div class="col-md-3">
                    <select name="transportador" class="form-select" required>
                        <option value="">Transportador...</option>
                        <?php foreach ($_SESSION['transportadores'] as $t) { ?>
                            <option value="<?php echo $t['nome']; ?>"><?php echo $t['nome']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="origem" class="form-select" required>
                        <option value="">Origem...</option>
                        <?php foreach ($_SESSION['enderecos'] as $e) { ?>
                            <option value="<?php echo $e['cidade']; ?>"><?php echo $e['cidade']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="destino" class="form-select" required>
                        <option value="">Destino...</option>
                        <?php foreach ($_SESSION['enderecos'] as $e) { ?>
                            <option value="<?php echo $e['cidade']; ?>"><?php echo $e['cidade']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="data" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
            </div>

            <div id="produtos-frete">
                <div class="row g-2 mb-2">
                    <div class="col-md-7">
                        <select name="produto_id[]" class="form-select" required>
                            <option value="">Produto...</option>
                            <?php foreach ($_SESSION['produtos'] as $p) { ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="quantidade[]" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger w-100" onclick="delProduto(this)">X</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="addProduto()">+ Produto</button>

            <div class="row g-2">
                <div class="col-md-3">
                    <input type="number" step="0.01" name="valor" class="form-control" placeholder="Valor do Frete" required>
                </div>
                <div class="col-md-3">
                    <button name="salvar_frete" class="btn btn-success">Gerar Frete</button>
                </div>
            </div>
        </form>
    </div>

    <table class="table table-bordered bg-white">
        <tr><th>ID</th><th>Data</th><th>Transportador</th><th>Rota</th><th>Produtos</th><th>Valor</th></tr>
        <?php foreach ($_SESSION['fretes'] as $f) { ?>
            <tr>
                <td><?php echo $f['id']; ?></td>
                <td><?php echo dataBr($f['data']); ?></td>
                <td><?php echo $f['transportador']; ?></td>
                <td><?php echo $f['origem'] . " → " . $f['destino']; ?></td>
                <td>
                    <?php foreach ($f['itens'] as $item) echo $item['nome'] . " (" . $item['qtd'] . "x)<br>"; ?>
                </td>
                <td><?php echo moeda($f['valor']); ?></td>
            </tr>
        <?php } ?>
    </table>

<?php } else {
    $dia = isset($_GET['dia']) ? $_GET['dia'] : date('Y-m-d');
?>
    <div class="card p-3">
        <h6>Relatório do Dia</h6>
        <form method="get" class="d-flex gap-2 mb-3">
            <input type="hidden" name="tela" value="relatorio">
            <input type="date" name="dia" class="form-control" style="max-width: 220px;" value="<?php echo $dia; ?>">
            <button class="btn btn-primary">Ver</button>
            <a href="funcoes.php?baixar=1&dia=<?php echo $dia; ?>" class="btn btn-success">Baixar CSV</a>
        </form>

        <table class="table table-striped">
            <tr><th>ID</th><th>Data</th><th>Transportador</th><th>Rota</th><th>Valor</th></tr>
            <?php foreach ($_SESSION['fretes'] as $f) {
                if ($f['data'] == $dia) { ?>
                    <tr>
                        <td><?php echo $f['id']; ?></td>
                        <td><?php echo dataBr($f['data']); ?></td>
                        <td><?php echo $f['transportador']; ?></td>
                        <td><?php echo $f['origem'] . " → " . $f['destino']; ?></td>
                        <td><?php echo moeda($f['valor']); ?></td>
                    </tr>
                <?php }
            } ?>
        </table>
    </div>
<?php } ?>
</div>

<script src="script.js"></script>
</body>
</html>