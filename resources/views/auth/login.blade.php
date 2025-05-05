<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - AFL Finanças</title>

    <style>
        body {
            background: #f9f9f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        /* Faixa preta no topo */
        .top-bar {
            background: #26519c;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar .logo {
            font-size: 1.2em;
            font-weight: bold;
        }

        .top-bar .right-content {
            font-size: 0.9em;
            color: #ccc;
        }

        .login-container {
            width: 300px;
            margin: 80px auto;
        }

        .login-box {
            background: #fff;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            background: #333;
            color: #fff;
            padding: 10px;
            margin: -25px -25px 20px -25px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-check input {
            margin-right: 5px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        .forgot {
            text-align: right;
            margin-top: 10px;
        }

        .forgot a {
            font-size: 0.9em;
            text-decoration: none;
        }
    </style>

</head>

<body>

    <!-- Faixa preta -->
    <div class="top-bar">
        <div class="logo">AFL Finanças</div>
        <div class="right-content">Sistema</div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Manter conectado</label>
                </div>
                <div class="forgot">
                    <a href="#">Esqueceu sua senha?</a>
                </div>
                <button type="submit" class="btn">Entrar</button>
            </form>
        </div>
    </div>

</body>

</html>
