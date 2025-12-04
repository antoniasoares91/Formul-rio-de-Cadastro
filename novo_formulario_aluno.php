<?php
session_start();
// Array de opções para o campo Curso (LÓGICA MANTIDA)
$cursos = [
    'Desenvolvimento de Sistemas',
    'Informática',
    'Administração',
    'Enfermagem'
];

// Array de opções para o campo Tipo de Responsável (LÓGICA MANTIDA)
$tipos_responsavel = [
    'Pai',
    'Mãe',
    'Tio(a)',
    'Avô(ó)',
    'Outro'
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cadastro de Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* VARIÁVEIS DE CORES MODERNAS */
        :root {
            --primary-color: #3f51b5; /* Deep Indigo - Para menus, textos primários */
            --primary-dark: #303f9f;
            --accent-color: #ff9800; /* Amber/Laranja - Para botões de ação e destaque (AJUSTE CONFORME SEU LOGO) */
            --background-color: #f4f6f9; /* Fundo Leve */
            --card-bg: #ffffff;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 0;
        }

        .form-section {
            padding: 20px 0;
        }

        .modern-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            background-color: var(--card-bg);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(63, 81, 181, 0.25);
        }

        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.2s;
        }
        .btn-accent:hover {
            background-color: #e68900;
            border-color: #e68900;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            max-width: 200px;
            height: auto;
        }
    </style>
    </head>
<body>  
    <section class="form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="modern-card">
                        <div class="card-body p-4 p-md-5">

                            <div class="logo-container">
                                <img src="data:image/png;base64,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" alt="">
                            </div>
                            <h4 class="text-center mb-4 fw-bold" style="color: var(--primary-dark);">Cadastro de Aluno</h4>

                            <?php 
                                if(isset($_SESSION['mensagem_aluno'])):
                                    $alert_class = strpos($_SESSION['mensagem_aluno'], 'Erro') !== false ? 'alert-danger' : 'alert-success';
                            ?>
                            <div class="alert <?= $alert_class ?> text-center" role="alert">
                                <?= $_SESSION['mensagem_aluno'] ?>
                            </div>
                            <?php 
                                    unset($_SESSION['mensagem_aluno']);
                                endif;
                            ?>
                            
                            <form action="processa_aluno.php" method="POST" class="row g-3">
                                
                                <h5 class="mt-4 pb-2 border-bottom text-success"><i class="bi bi-person-circle me-2"></i>Dados do Aluno</h5>

                                <div class="col-md-6">
                                    <label class="form-label" for="nome_completo">Nome Completo</label>
                                    <input type="text" class="form-control" name="nome_completo" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="data_nascimento">Data de Nascimento</label>
                                    <input type="date" class="form-control" name="data_nascimento" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="curso">Curso</label>
                                    <select class="form-select" name="curso" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($cursos as $c): ?>
                                            <option value="<?= $c ?>"><?= $c ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <h5 class="mt-4 pb-2 border-bottom text-success"><i class="bi bi-geo-alt-fill me-2"></i>Endereço</h5>
                                
                                <div class="col-md-8">
                                    <label class="form-label" for="rua">Rua</label>
                                    <input type="text" class="form-control" name="rua" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="numero">Número</label>
                                    <input type="text" class="form-control" name="numero">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="bairro">Bairro</label>
                                    <input type="text" class="form-control" name="bairro">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="cep">CEP</label>
                                    <input type="text" class="form-control" name="cep">
                                </div>

                                <h5 class="mt-4 pb-2 border-bottom text-success"><i class="bi bi-people-fill me-2"></i>Responsável</h5>
                                
                                <div class="col-md-6">
                                    <label class="form-label" for="nome_responsavel">Nome do Responsável</label>
                                    <input type="text" class="form-control" name="nome_responsavel">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="tipo_responsavel">Tipo de Responsável</label>
                                    <select class="form-select" name="tipo_responsavel" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($tipos_responsavel as $t): ?>
                                            <option value="<?= $t ?>"><?= $t ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-12 mt-5 text-center">
                                    <button type="submit" class="btn btn-accent btn-lg w-50">
                                        <i class="bi bi-person-plus-fill me-2"></i> Cadastrar Aluno
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer py-3 border-0 text-center">
                            <a href="painel.php" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i> Voltar para o Painel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>