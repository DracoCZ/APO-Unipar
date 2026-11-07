<?php
include 'conexao.php';

$mensagem = "";
$aba_ativa = "produtos"; 
$dados_atuais = null;

// PROCESSA A ATUALIZAÇÃO (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $id = $_POST['id'];
    $aba_ativa = $tipo; 

    if ($tipo == "produtos") {
        $nome = $_POST['nome'];
        $peso = $_POST['peso'];
        $comprimento = $_POST['comprimento'];
        $largura = $_POST['largura'];
        $altura = $_POST['altura'];
        $valor = $_POST['valor'];
        
        $sql = "UPDATE produtos SET nome='" . $nome . "', peso='" . $peso . "', comprimento='" . $comprimento . "', largura='" . $largura . "', altura='" . $altura . "', valor='" . $valor . "' WHERE id='" . $id . "'";
        
    } elseif ($tipo == "transportadoras") {
        $nome_empresa = $_POST['nome_empresa'];
        $cpf_cnpj = $_POST['cpf_cnpj'];
        $modelo_veiculo = $_POST['modelo_veiculo'];
        $placa = $_POST['placa'];
        
        $sql = "UPDATE transportadoras SET nome_empresa='" . $nome_empresa . "', cpf_cnpj='" . $cpf_cnpj . "', modelo_veiculo='" . $modelo_veiculo . "', placa='" . $placa . "' WHERE id='" . $id . "'";
        
    } elseif ($tipo == "enderecos") {
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $cep = $_POST['cep'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        
        $sql = "UPDATE enderecos SET rua='" . $rua . "', numero='" . $numero . "', bairro='" . $bairro . "', cep='" . $cep . "', cidade='" . $cidade . "', estado='" . $estado . "' WHERE id='" . $id . "'";
    }

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<div class='alert alert-success text-center mt-3'>Registo atualizado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger text-center mt-3'>Erro: " . $conn->error . "</div>";
    }
}

// BUSCA OS DADOS SE O UTILIZADOR SELECIONOU UM ITEM (GET)
if (isset($_GET['tipo_selecionado']) && isset($_GET['id_selecionado']) && !empty($_GET['id_selecionado'])) {
    $aba_ativa = $_GET['tipo_selecionado'];
    $id_selecionado = $_GET['id_selecionado'];
    
    if ($aba_ativa == "produtos") {
        $resultado = $conn->query("SELECT * FROM produtos WHERE id = '" . $id_selecionado . "'");
    } elseif ($aba_ativa == "transportadoras") {
        $resultado = $conn->query("SELECT * FROM transportadoras WHERE id = '" . $id_selecionado . "'");
    } elseif ($aba_ativa == "enderecos") {
        $resultado = $conn->query("SELECT * FROM enderecos WHERE id = '" . $id_selecionado . "'");
    }
    
    if (isset($resultado) && $resultado->num_rows > 0) {
        $dados_atuais = $resultado->fetch_assoc();
    }
}

// BUSCA AS LISTAS PARA OS DROPDOWNS
$lista_produtos = $conn->query("SELECT id, nome FROM produtos");
$lista_transp = $conn->query("SELECT id, nome_empresa FROM transportadoras");
$lista_enderecos = $conn->query("SELECT id, rua, cidade, estado FROM enderecos");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central de Edição</title>
    <!-- CSS DO BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JS DO BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* NAVBAR IGUAL AO DESIGN DO FIGMA */
        .navbar-custom { background-color: #3b3f45; }
        .navbar-custom .nav-link { color: #a9a9a9; padding: 8px 16px; margin: 0 4px; }
        .navbar-custom .nav-link:hover { color: #ffffff; }
        .navbar-custom .nav-link.active { color: #ffffff; font-weight: 500; background-color: #555960; border-radius: 4px; }
        
        /* ABAS */
        .nav-tabs .nav-link { color: #495057; font-weight: bold; cursor: pointer; }
        .nav-tabs .nav-link.active { color: #5b58ff; border-bottom: 3px solid #5b58ff; background-color: transparent;}
        .tab-content-custom { background-color: #ffffff; padding: 25px; border: 1px solid #dee2e6; border-top: none; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>

    <!-- BARRA DE NAVEGAÇÃO CORRIGIDA -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom px-3">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_produto.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_endereco.php">Endereços</a></li>
                    <li class="nav-item"><a class="nav-link" href="cadastro_transportadora.php">Transportadoras</a></li>
                    <li class="nav-item"><a class="nav-link" href="gerar_frete.php">Frete</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorio.php">Relatorios</a></li>
                    <li class="nav-item"><a class="nav-link active" href="editar_geral.php">Central de Edição</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 700px;">
        <h2 class="text-center mb-4 fw-bold">Central de Edição</h2>
        
        <?= $mensagem ?>

        <!-- MENU DAS ABAS -->
        <ul class="nav nav-tabs justify-content-center" id="edicaoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if($aba_ativa == 'produtos') echo 'active'; ?>" id="produtos-tab" data-bs-toggle="tab" data-bs-target="#produtos" type="button" role="tab">📦 Produtos</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if($aba_ativa == 'transportadoras') echo 'active'; ?>" id="transportadoras-tab" data-bs-toggle="tab" data-bs-target="#transportadoras" type="button" role="tab">🚚 Transportadoras</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if($aba_ativa == 'enderecos') echo 'active'; ?>" id="enderecos-tab" data-bs-toggle="tab" data-bs-target="#enderecos" type="button" role="tab">📍 Endereços</button>
            </li>
        </ul>

        <!-- CONTEÚDO DAS ABAS -->
        <div class="tab-content tab-content-custom shadow-sm" id="edicaoTabsContent">
            
            <!-- 1. ABA PRODUTOS -->
            <div class="tab-pane fade <?php if($aba_ativa == 'produtos') echo 'show active'; ?>" id="produtos" role="tabpanel">
                <form method="GET" action="editar_geral.php" class="mb-4">
                    <input type="hidden" name="tipo_selecionado" value="produtos">
                    <label class="form-label fw-bold text-muted">Selecione o produto para editar:</label>
                    <div class="input-group">
                        <select class="form-select" name="id_selecionado" required>
                            <option value="">Selecione um produto...</option>
                            <?php while($p = $lista_produtos->fetch_assoc()) { ?>
                                <option value="<?= $p['id'] ?>" <?php if($aba_ativa == 'produtos' && isset($id_selecionado) && $id_selecionado == $p['id']) echo 'selected'; ?>><?= $p['nome'] ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Carregar Dados</button>
                    </div>
                </form>

                <?php if ($aba_ativa == 'produtos' && $dados_atuais != null): ?>
                <form method="POST" action="editar_geral.php">
                    <input type="hidden" name="tipo" value="produtos">
                    <input type="hidden" name="id" value="<?= $dados_atuais['id'] ?>">
                    
                    <div class="mb-3"><label class="form-label">Nome do Produto</label><input type="text" class="form-control" name="nome" value="<?= $dados_atuais['nome'] ?>" required></div>
                    <div class="mb-3"><label class="form-label">Peso (kg)</label><input type="number" step="0.01" class="form-control" name="peso" value="<?= $dados_atuais['peso'] ?>" required></div>
                    
                    <div class="row">
                        <div class="col-4 mb-3"><label class="form-label">Compr. (cm)</label><input type="number" step="0.01" class="form-control" name="comprimento" value="<?= $dados_atuais['comprimento'] ?>" required></div>
                        <div class="col-4 mb-3"><label class="form-label">Larg. (cm)</label><input type="number" step="0.01" class="form-control" name="largura" value="<?= $dados_atuais['largura'] ?>" required></div>
                        <div class="col-4 mb-3"><label class="form-label">Alt. (cm)</label><input type="number" step="0.01" class="form-control" name="altura" value="<?= $dados_atuais['altura'] ?>" required></div>
                    </div>
                    
                    <div class="mb-4"><label class="form-label">Valor (R$)</label><input type="number" step="0.01" class="form-control" name="valor" value="<?= $dados_atuais['valor'] ?>" required></div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white">Atualizar Produto</button>
                </form>
                <?php endif; ?>
            </div>

            <!-- 2. ABA TRANSPORTADORAS -->
            <div class="tab-pane fade <?php if($aba_ativa == 'transportadoras') echo 'show active'; ?>" id="transportadoras" role="tabpanel">
                <form method="GET" action="editar_geral.php" class="mb-4">
                    <input type="hidden" name="tipo_selecionado" value="transportadoras">
                    <label class="form-label fw-bold text-muted">Selecione a transportadora para editar:</label>
                    <div class="input-group">
                        <select class="form-select" name="id_selecionado" required>
                            <option value="">Selecione uma transportadora...</option>
                            <?php while($t = $lista_transp->fetch_assoc()) { ?>
                                <option value="<?= $t['id'] ?>" <?php if($aba_ativa == 'transportadoras' && isset($id_selecionado) && $id_selecionado == $t['id']) echo 'selected'; ?>><?= $t['nome_empresa'] ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Carregar Dados</button>
                    </div>
                </form>

                <?php if ($aba_ativa == 'transportadoras' && $dados_atuais != null): ?>
                <form method="POST" action="editar_geral.php">
                    <input type="hidden" name="tipo" value="transportadoras">
                    <input type="hidden" name="id" value="<?= $dados_atuais['id'] ?>">
                    
                    <div class="mb-3"><label class="form-label">Nome/Empresa</label><input type="text" class="form-control" name="nome_empresa" value="<?= $dados_atuais['nome_empresa'] ?>" required></div>
                    <div class="mb-3"><label class="form-label">CPF/CNPJ</label><input type="text" class="form-control" name="cpf_cnpj" value="<?= $dados_atuais['cpf_cnpj'] ?>" required></div>
                    <div class="mb-3"><label class="form-label">Modelo Veículo</label><input type="text" class="form-control" name="modelo_veiculo" value="<?= $dados_atuais['modelo_veiculo'] ?>" required></div>
                    <div class="mb-4"><label class="form-label">Placa</label><input type="text" class="form-control" name="placa" value="<?= $dados_atuais['placa'] ?>" required></div>
                    
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white">Atualizar Transportadora</button>
                </form>
                <?php endif; ?>
            </div>

            <!-- 3. ABA ENDEREÇOS -->
            <div class="tab-pane fade <?php if($aba_ativa == 'enderecos') echo 'show active'; ?>" id="enderecos" role="tabpanel">
                <form method="GET" action="editar_geral.php" class="mb-4">
                    <input type="hidden" name="tipo_selecionado" value="enderecos">
                    <label class="form-label fw-bold text-muted">Selecione o endereço para editar:</label>
                    <div class="input-group">
                        <select class="form-select" name="id_selecionado" required>
                            <option value="">Selecione um endereço...</option>
                            <?php while($e = $lista_enderecos->fetch_assoc()) { ?>
                                <option value="<?= $e['id'] ?>" <?php if($aba_ativa == 'enderecos' && isset($id_selecionado) && $id_selecionado == $e['id']) echo 'selected'; ?>><?= $e['rua'] ?> - <?= $e['cidade'] ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary">Carregar Dados</button>
                    </div>
                </form>

                <?php if ($aba_ativa == 'enderecos' && $dados_atuais != null): ?>
                <form method="POST" action="editar_geral.php">
                    <input type="hidden" name="tipo" value="enderecos">
                    <input type="hidden" name="id" value="<?= $dados_atuais['id'] ?>">
                    
                    <div class="row">
                        <div class="col-8 mb-3"><label class="form-label">Rua</label><input type="text" class="form-control" name="rua" value="<?= $dados_atuais['rua'] ?>" required></div>
                        <div class="col-4 mb-3"><label class="form-label">Número</label><input type="text" class="form-control" name="numero" value="<?= $dados_atuais['numero'] ?>" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Bairro</label><input type="text" class="form-control" name="bairro" value="<?= $dados_atuais['bairro'] ?>" required></div>
                    <div class="mb-3"><label class="form-label">CEP</label><input type="text" class="form-control" name="cep" value="<?= $dados_atuais['cep'] ?>" required></div>
                    <div class="row">
                        <div class="col-8 mb-4"><label class="form-label">Cidade</label><input type="text" class="form-control" name="cidade" value="<?= $dados_atuais['cidade'] ?>" required></div>
                        <div class="col-4 mb-4"><label class="form-label">Estado (UF)</label><input type="text" class="form-control" name="estado" value="<?= $dados_atuais['estado'] ?>" maxlength="2" required></div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100 fw-bold text-white">Atualizar Endereço</button>
                </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>
</html>