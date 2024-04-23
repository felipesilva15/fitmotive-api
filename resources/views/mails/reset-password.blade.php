<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefina sua senha</title>
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

        .reset-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
			text-wrap: nowrap;
			width: min-content;
        }

        .reset-button:hover {
            background-color: #0056b3;
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
        <img src="https://www.siteselogos.pt/" alt="Fit Motive" class="logo">
        <h1 class="greeting">Olá {{ $user->name }},</h1>
    </div>

    <p class="message">Recebemos uma solicitação para redefinir a senha da sua conta. Se você não solicitou essa redefinição, por favor, ignore este e-mail.</p>

    <p class="message">Para redefinir sua senha, clique no botão abaixo:</p>

    <a href="{{$resetLink}}" class="reset-button">Redefinir senha</a>

    <p class="message">Este link irá expirar em 24 horas.</p>

    <p class="message">Se você tiver qualquer problema para redefinir sua senha, por favor, entre em contato com nosso suporte: <a href="https://support.link.com/" class="link">Suporte</a></p>

    <div class="footer">
        <p>&copy; 2024 Fit Motive</p>
    </div>
</div>
</body>
</html>