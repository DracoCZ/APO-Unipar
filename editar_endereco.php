<?php
include 'conexao.php';

$mensagem = "";
$endereco_atual = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "UPDATE enderecos SET 
                rua='$rua', numero='$numero', bairro='$bairro', 
                cep='$cep', cidade='$cidade', estado='$estado' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Endereço atualizado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger text-center mt-3'>Erro: " . $conn->error . "</div>";
    }
}

if (isset($_GET['id_selecionado']) && !empty($_GET['id_selecionado'])) {
    $id_selecionado = $_GET['id_selecionado'];
    $resultado = $conn->query("SELECT * FROM enderecos WHERE id = '$id_selecionado'");
    if ($resultado->num_rows > 0) {
        $endereco_atual = $resultado->fetch_assoc();
    }
}

$lista_enderecos = $conn->query("SELECT id, rua, cidade, estado FROM enderecos");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Endereço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-custom { background-color: #343a40; }
        .btn-custom { background-color: #5b58ff; color: white; border: none; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Gestor Logístico</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Fretes</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="text-center mb-4 fw-bold">Editar Endereço Existente</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <form method="GET" action="editar_endereco.php">
                    <label class="form-label text-muted fw-bold">Selecione o endereço que deseja editar:</label>
                    <div class="input-group">
                        <select class="form-select" name="id_selecionado" required>
                            <option value="">Selecione...</option>
                            <?php while($e = $lista_enderecos->fetch_assoc()) { ?>
                                <option value="<?= $e['id'] ?>" <?= (isset($id_selecionado) && $id_selecionado == $e['id']) ? 'selected' : '' ?>>
                                    <?= $e['rua'] ?> - <?= $e['cidade'] ?>/<?= $e['estado'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Carregar Dados</button>
                    </div>
                </form>
            </div>
        </div>

        <?= $mensagem ?>

        <?php if ($endereco_atual != null): ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="editar_endereco.php">
                    <input type="hidden" name="id" value="<?= $endereco_atual['id'] ?>">

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label text-muted">Rua</label>
                            <input type="text" class="form-control" name="rua" value="<?= $endereco_atual['rua'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted">Número</label>
                            <input type="text" class="form-control" name="numero" value="<?= $endereco_atual['numero'] ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Bairro</label>
                        <input type="text" class="form-control" name="bairro" value="<?= $endereco_atual['bairro'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">CEP</label>
                        <input type="text" class="form-control" name="cep" value="<?= $endereco_atual['cep'] ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label text-muted">Cidade</label>
                            <input type="text" class="form-control" name="cidade" value="<?= $endereco_atual['cidade'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label text-muted">Estado (UF)</label>
                            <input type="text" class="form-control" name="estado" value="<?= $endereco_atual['estado'] ?>" maxlength="2" required>
                        </div>
                    </div>

                    <div class="d-grid text-center">
                        <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-white">Atualizar Dados</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
</body>
</html>