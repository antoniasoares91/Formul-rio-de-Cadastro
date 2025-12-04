<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Sistema Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
      <img src="data:image/png;base64,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" alt="Logo" style="display: block; margin: 10px auto; width: 100px; height: auto;">

    <style>
        body {
            background-color: #e9ecef; /* Fundo cinza claro */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px #27813eff(0, 0, 0, 0.1);
        }
        .header-title {
            color: #27813eff; /* Azul primário */
            font-weight: 700;
        }
        .form-control:focus {
            border-color: #27813eff;
            box-shadow: 0 0 0 0.25rem #27813eff(78, 115, 223, 0.25);
        }
    </style>
</head>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100 align-items-center">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    
                    <div class="text-center my-4">
                        <i class="bi bi-lock-fill text-secondary" style="font-size: 3rem;"></i>
                    </div>
                    
                    <div class="card login-card">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold text-center header-title mb-4">Acesso ao Painel</h1>
                            
                            <?php 
                                if (isset($_SESSION['nao_autenticado'])): 
                                unset($_SESSION['nao_autenticado']);
                            ?>
                            <div class="alert alert-danger text-center small" role="alert">
                                E-mail ou Senha incorretos.
                            </div>
                            <?php endif; ?>

                            <?php 
                                if (isset($_SESSION['mensagem'])): 
                            ?>
                            <div class="alert alert-success text-center small" role="alert">
                                <?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?>
                            </div>
                            <?php endif; ?>

                            <form method="POST" action="login.php" class="needs-validation" novalidate="" autocomplete="off">
                                
                                <div class="mb-3">
                                    <label class="text-muted" for="email">E-mail</label>
                                    <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <div class="mb-2 w-100">
                                        <label class="text-muted" for="password">Senha</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="senha" required>
                                </div>

                                <div class="d-flex align-items-center mt-4">
                                    <button type="submit" class="btn btn-success w-100">
                                        Entrar <i class="bi bi-box-arrow-in-right"></i>
                                    </button>
                                </div> 
                            </form>
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                Não tem uma conta? <a href="telacadastro.php" class="text-primary fw-bold">Crie uma!</a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-muted">
                        Sistema Administrativo | <?php echo date('Y'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>