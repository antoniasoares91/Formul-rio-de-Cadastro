<?php
include 'conexao.php';

// Adaptação para garantir que a variável de conexão do `conexao.php` ($conexao) seja usada
$conn = $conexao; 

// Consulta para pegar os 100 primeiros alunos cadastrados (LÓGICA MANTIDA)
$sql = "SELECT * FROM alunos ORDER BY aluno_id ASC LIMIT 100";
$resultado = $conn->query($sql);

// Consulta para contar todos os alunos cadastrados (LÓGICA MANTIDA)
$sqlTotal = "SELECT COUNT(*) AS total FROM alunos";
$resTotal = $conn->query($sqlTotal);
// Assume fetch_assoc() funciona se a conexão for mysqli orientada a objetos
$d = $resTotal->fetch_assoc(); 
$total = $d['total'];

$falta = 100 - $total;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeiros 100 Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* VARIÁVEIS DE CORES MODERNAS */
        :root {
            --primary-color: #3f51b5; /* Deep Indigo - Para menus, textos primários */
            --primary-dark: #303f9f;
            --accent-color: #ff9800; /* Amber/Laranja - Para botões de ação e destaque (AJUSTE CONFORME SEU LOGO) */
            --success-color: #4CAF50; /* Verde para sucesso */
            --background-color: #f4f6f9; /* Fundo Leve */
            --card-bg: #ffffff;
            --shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-color);
            padding: 30px;
        }
        
        .modern-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow);
            background-color: var(--card-bg);
            padding: 20px;
            margin-top: 20px;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 300;
        }
        
        .box {
            padding: 15px 20px;
            margin-bottom: 15px;
            border-left: 5px solid;
            border-radius: 8px;
            font-size: 1.05rem;
        }
        .ok {
            border-color: #4CAF50; /* Verde */
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        .alerta {
            border-color: var(--accent-color); /* Laranja */
            background-color: #fff3e0;
            color: #e65100;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead th {
            background-color: var(--success-color);
            color: white;
            border-color: var(--primary-dark);
        }
        .table tbody tr:hover {
            background-color: #f0f4f7;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1><i class="bi bi-list-ol me-2"></i> Primeiros 100 Alunos Cadastrados</h1>
            </div>
        </div>

        <?php if ($total < 100): ?>
            <div class="box alerta">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Atenção:</strong> Ainda não atingiu 100 alunos.<br>
                Faltam **<?php echo $falta; ?>** para completar a marca.
            </div>
        <?php else: ?>
            <div class="box ok">
                <i class="bi bi-check-circle-fill me-2"></i> **Os 100 primeiros alunos já foram registrados!**
            </div>
        <?php endif; ?>

        <div class="modern-card">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>Data Nasc.</th>
                            <th>Curso</th>
                            <th>Responsável</th>
                            <th>Cadastro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultado->num_rows > 0) {
                            while ($aluno = $resultado->fetch_assoc()) {
                                // Garante que a data de nascimento seja formatada corretamente
                                $data_nasc_formatada = !empty($aluno['data_nascimento']) ? date('d/m/Y', strtotime($aluno['data_nascimento'])) : 'N/A';
                                
                                echo "<tr>";
                                echo "<td>{$aluno['aluno_id']}</td>";
                                echo "<td>" . htmlspecialchars($aluno['nome_completo']) . "</td>";
                                echo "<td>" . $data_nasc_formatada . "</td>";
                                echo "<td><span class=\"badge bg-primary\">" . htmlspecialchars($aluno['curso']) . "</span></td>";
                                echo "<td>" . htmlspecialchars($aluno['tipo_responsavel']) . "</td>";
                                echo "<td>" . date('d/m/Y', strtotime($aluno['data_cadastro'])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Nenhum aluno encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
             <a href="painel.php" class="btn btn-primary"><i class="bi bi-house-fill me-2"></i> Voltar ao Painel</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>