<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinição de senha - Fit Motive</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        .greeting {
            font-size: 20px;
            font-weight: bold;
        }

        .message {
            font-size: 16px;
            line-height: 1.5;
        }

        .new-password {
            font-weight: bold;
            font-size: 1.25em;
			text-align: center;
			border-radius: 6px;
			background: #f4f4f4;
			padding: 1rem;
			width: 50%;
			margin: 0 auto 20px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .link {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://www.logo.com.br/logo" alt="Fit Motive" class="logo">
        <h1 class="greeting">Olá, {{ $user->name }}!</h1>
    </div>
    <p class="message">Sua senha foi redefinida com sucesso. Agora você pode acessar sua conta com a nova senha abaixo:</p>
    <div class="new-password">{{ $newPassword }}</div>
    <p class="message">Por favor, guarde esta senha em um local seguro e não a compartilhe com ninguém.</p>
    <p class="message">Se você tiver qualquer problema para acessar sua conta, entre em contato com nosso <a href="https://support.link.com/" class="link">Suporte</a>.</p>
	<hr></hr>
    <div class="footer">
        <p>&copy; 2024 Fit Motive</p>
    </div>
</div>
</body>
</html>