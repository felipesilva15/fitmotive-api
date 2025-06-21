# Fit Motive API

<div align="center">
    <img alt="Logo" width="350px" src="https://i.imgur.com/HzsQOZm.jpeg" />

![Status](http://img.shields.io/static/v1?label=STATUS&message=FINALIZADO&color=RED&style=for-the-badge)

![Top language](https://img.shields.io/github/languages/top/felipesilva15/fitmotive-api.svg)
![Language count](https://img.shields.io/github/languages/count/felipesilva15/fitmotive-api.svg)
![Repository size](https://img.shields.io/github/repo-size/felipesilva15/fitmotive-api.svg)
[![Last commit](https://img.shields.io/github/last-commit/felipesilva15/fitmotive-api.svg)](https://github.com/felipesilva15/fitmotive-api/commits/main)
[![Issues](https://img.shields.io/github/issues/felipesilva15/fitmotive-api.svg)](https://github.com/felipesilva15/fitmotive-api/issues)
[![Licence](https://img.shields.io/github/license/felipesilva15/fitmotive-api.svg)](https://github.com/felipesilva15/fitmotive-api/blob/main/LICENSE)

</div>

API RESTful desenvolvida em Laravel com MySQL com intuito de fornecer o backend para o SAAS Fit Motive. Possui autenticação via JWT, CRUD, envio de e-mails via AWS SES, integração com sistema de bancário da PagBank, CI/CD com publicação no DockerHub e deploy em uma VPS.

## 📑 Sumário

- [Descrição geral](#-descrição-geral)
- [Executando localmente](#-executando-localmente)
- [Executando com Docker](#-executando-com-docker)
- [Endpoints](#-endpoints)
- [Tecnologias utilizadas](#%EF%B8%8F-tecnologias-utilizadas)
- [Autores](#%EF%B8%8F-autores)
- [Licença](#-licença)

## 📘 Descrição Geral

- **Versão:** 1.0.0  
- **Autor:** [Felipe Silva](mailto:felipe.allware@gmail.com)  
- **Licença:** [Licença API](https://github.com/felipesilva15/fitmotive-api/blob/main/LICENSE)
- **Deploy:** [API](https://fitmotive-api.felipesilva15.com.br/api)

### Principais funcionalidades

- CRUD completo.
- Integração para geração de cobranças no PagBank (Boleto, PIX e cartão)
- Controle de planos e assinaturas através do PagBank
- Envio de e-mail através do serviço da AWS SES
- CI/CD com GitHub Actions e deploy para DockerHub.
- Autenticação com JWT.

## 🚀 Executando localmente

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

- PHP v8.1.0
- Composer

### 🔧 Instalação

1. Clone o projeto utilizando o comando abaixo

    ``` bash
    git clone https://github.com/felipesilva15/fitmotive-api.git
    ```

2. Acesse a pasta dos fonts deste projeto

    ```bash
    cd fitmotive-api
    ```

3. Instale as dependências do projeto

    ```bash
    composer install
    ```

4. Copie o arquivo de exemplo de variáveis de ambiente  

    ```bash
    cp .env.example .env
    ```

5. Atualize as credenciais de acesso ao seu banco de dados, secret para o JWT e informações da API do PagBank preenchendo os campos abaixo

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=root
    DB_PASSWORD=
    
    JWT_SECRET=

    PAGSEGURO_API_TOKEN=
    PAGSEGURO_API_SUBSCRIPTION_BASE_URL=https://sandbox.api.assinaturas.pagseguro.com
    PAGSEGURO_API_CONNECT_BASE_URL=https://connect.sandbox.pagseguro.uol.com.br
    PAGSEGURO_API_BASE_URL=https://sandbox.api.pagseguro.com
    ```

6. Gere as tabelas da aplicação e a semente para o serviço de autenticação

    ```bash
    php artisan migrate --seed
    ```

7. Inicie a aplicação

    ```bash
    php artisan serve
    ```

8. Acesse a aplicação em <http://localhost:8000>.

## 🐳 Executando com Docker

```bash
# Build da imagem
docker build -t felipesilva15/fitmotive-api:latest \
    --build-arg DB_HOST='localhost' \
    --build-arg DB_PORT='3306' \
    --build-arg DB_DATABASE='fitmotive' \
    --build-arg DB_USERNAME='root' \
    --build-arg DB_PASSWORD='root' \
    .

# Rodar container
docker run -d -p 8000:80 felipesilva15/fitmotive-api
```

## 🧪 Testes

Execute o comando de testes do Laravel (PHPUnit).

```bash
php artisan test
```

## 📁 Endpoints

### 🔐 Authentication

| Método | Endpoint                        | Descrição                              |
|--------|---------------------------------|----------------------------------------|
| POST   | `/api/login`                    | Obtém o token JWT para autenticação    |
| POST   | `/api/logout`                   | Realiza o logout e invalida o token    |
| POST   | `/api/refresh-token`            | Atualiza um token JWT                  |
| GET    | `/api/me`                       | Retorna o usuário autenticado do token |

### ⏱ Logs

| Método | Endpoint         | Descrição                    |
|--------|------------------|------------------------------|
| GET    | `/api/log`       | Lista todos os logs          |
| GET    | `/api/log/{id}`  | Detalha um log por ID        |
| POST   | `/api/log`       | Cadastra um novo log         |
| PUT    | `/api/log/{id}`  | Atualiza um log              |
| DELETE | `/api/log/{id}`  | Remove um log                |

### 🏋🏿️ Exercices

| Método | Endpoint              | Descrição                          |
|--------|-----------------------|------------------------------------|
| GET    | `/api/exercice`       | Lista todos os exercícios          |
| GET    | `/api/exercice/{id}`  | Detalha um exercício por ID        |
| POST   | `/api/exercice`       | Cadastra um novo exercício         |
| PUT    | `/api/exercice/{id}`  | Atualiza um exercício              |
| DELETE | `/api/exercice/{id}`  | Remove um exercício                |

### 🎯 Workouts

| Método | Endpoint             | Descrição                       |
|--------|----------------------|---------------------------------|
| GET    | `/api/workout`       | Lista todos os treinos          |
| GET    | `/api/workout/{id}`  | Detalha um treino por ID        |
| POST   | `/api/workout`       | Cadastra um novo treino         |
| PUT    | `/api/workout/{id}`  | Atualiza um treino              |
| DELETE | `/api/workout/{id}`  | Remove um treino                |

### 📞 Phones

| Método | Endpoint           | Descrição                         |
|--------|--------------------|-----------------------------------|
| GET    | `/api/phone`       | Lista todos os telefones          |
| GET    | `/api/phone/{id}`  | Detalha um telefone por ID        |
| POST   | `/api/phone`       | Cadastra um novo telefone         |
| PUT    | `/api/phone/{id}`  | Atualiza um telefone              |
| DELETE | `/api/phone/{id}`  | Remove um telefone                |

### 📍 Adresses

| Método | Endpoint             | Descrição                         |
|--------|----------------------|-----------------------------------|
| GET    | `/api/address`       | Lista todos os endereços          |
| GET    | `/api/address/{id}`  | Detalha um endereço por ID        |
| POST   | `/api/address`       | Cadastra um novo endereço         |
| PUT    | `/api/address/{id}`  | Atualiza um endereço              |
| DELETE | `/api/address/{id}`  | Remove um endereço                |

### 💳 Payment Methods

| Método | Endpoint                    | Descrição                                    |
|--------|-----------------------------|----------------------------------------------|
| GET    | `/api/payment_method`       | Lista todos os métodos de pagamento          |
| GET    | `/api/payment_method/{id}`  | Detalha um método de pagamento por ID        |
| POST   | `/api/payment_method`       | Cadastra um novo método de pagamento         |
| PUT    | `/api/payment_method/{id}`  | Atualiza um método de pagamento              |
| DELETE | `/api/payment_method/{id}`  | Remove um método de pagamento                |

### 💰 Financial transactions

| Método | Endpoint                                | Descrição                                      |
|--------|-----------------------------------------|------------------------------------------------|
| GET    | `/api/financial_transaction`            | Lista todas as transações financeiras          |
| GET    | `/api/financial_transaction/{id}`       | Detalha uma transação financeira por ID        |
| POST   | `/api/financial_transaction`            | Cadastra uma novo transação financeira         |
| PUT    | `/api/financial_transaction/{id}`       | Atualiza uma transação financeira              |
| DELETE | `/api/financial_transaction/{id}`       | Remove uma transação financeira                |
| DELETE | `/api/financial_transaction//withdraw`  | Realiza um saque                               |

### 📮 CEP

| Método | Endpoint             | Descrição                                    |
|--------|----------------------|----------------------------------------------|
| GET    | `/api/cep/{cep}`     | Busca os dados de um endereço pelo CEP       |

### 🔷 Plans

| Método | Endpoint                         | Descrição                      |
|--------|----------------------------------|--------------------------------|
| GET    | `/api/plan`                      | Lista todos os planos          |
| GET    | `/api/plan/{id}`                 | Detalha um plano por ID        |
| POST   | `/api/plan`                      | Cadastra um novo plano         |
| PUT    | `/api/plan/{id}`                 | Atualiza um plano              |
| DELETE | `/api/plan/{id}`                 | Remove um plano                |
| PATCH  | `/api/pagseguro/plan/{id}/sync`  | Registra um plano no PagBank   |

### 📋 Reports

| Método | Endpoint                             | Descrição                      |
|--------|--------------------------------------|--------------------------------|
| GET    | `/api/reports/financial/defaulters`  | Relatório de inadimplentes     |
| GET    | `/api/reports/financial/dashboard`   | Dashboard financeiro           |

### 📊 Dashboard

| Método | Endpoint             | Descrição                 |
|--------|----------------------|---------------------------|
| GET    | `/api/dashboard`     | Dashboard geral           |

### 💲 Charges

| Método | Endpoint                                     | Descrição                                 |
|--------|----------------------------------------------|-------------------------------------------|
| GET    | `/api/charge`                                | Lista todas as cobranças                  |
| GET    | `/api/charge/{id}`                           | Detalha uma cobrança por ID               |
| POST   | `/api/charge`                                | Cadastra uma novo cobrança                |
| PUT    | `/api/charge/{id}`                           | Atualiza uma cobrança                     |
| DELETE | `/api/charge/{id}`                           | Remove uma cobrança                       |
| PATCH  | `/api/pagseguro/charge/{id}/sync`            | Sincroniza uma cobrança no PagBank        |
| GET    | `/api/pagseguro/charge/{id}`                 | Consulta uma cobrança no PagBank          |
| PATCH  | `/api/pagseguro/charge/{id}/pay`             | Paga uma cobrança no PagBank              |
| PATCH  | `/api/pagseguro/charge/{id}/check-status`    | Atualiza o status uma cobrança no PagBank |

### 📝 Subscriptions

| Método | Endpoint                                       | Descrição                                           |
|--------|------------------------------------------------|-----------------------------------------------------|
| GET    | `/api/subscription`                            | Lista todas as assinaturas                          |
| GET    | `/api/subscription/{id}`                       | Detalha uma assinatura por ID                       |
| POST   | `/api/subscription`                            | Cadastra uma novo assinatura                        |
| PUT    | `/api/subscription/{id}`                       | Atualiza uma assinatura                             |
| DELETE | `/api/subscription/{id}`                       | Remove uma assinatura                               |
| PATCH  | `/api/pagseguro/subscription/{id}/sync`        | Sincroniza uma assinatura no PagBank                |
| GET    | `/api/pagseguro/subscription/{id}`             | Consulta uma assinatura no PagBank                  |
| GET    | `/api/pagseguro/subscription/{id}/invoices`    | Lista as cobranças de uma assinatura no PagBank     |
| GET    | `/api/pagseguro/subscription/{id}/complete`    | Consulta completamente uma assinatura no PagBank    |

### 📝 Patients

| Método | Endpoint                                  | Descrição                                        |
|--------|-------------------------------------------|--------------------------------------------------|
| GET    | `/api/patient`                            | Lista todos os pacientes                         |
| GET    | `/api/patient/{id}`                       | Detalha um paciente por ID                       |
| POST   | `/api/patient`                            | Cadastra um novo paciente                        |
| PUT    | `/api/patient/{id}`                       | Atualiza um paciente                             |
| DELETE | `/api/patient/{id}`                       | Remove um paciente                               |
| POST   | `/api/patient/{id}/generate_charge`       | Gera uma cobrança para um paciente               |

### 👤 Users

| Método | Endpoint                                         | Descrição                                       |
|--------|--------------------------------------------------|-------------------------------------------------|
| GET    | `/api/user`                                      | Lista todos os usuários                         |
| GET    | `/api/user/{id}`                                 | Detalha um usuário por ID                       |
| POST   | `/api/user`                                      | Cadastra um novo usuário                        |
| PUT    | `/api/user/{id}`                                 | Atualiza um usuário                             |
| DELETE | `/api/user/{id}`                                 | Remove um usuário                               |
| POST   | `/api/user/reset_password`                       | Recupara a senha de um usuário                  |
| POST   | `/api/pagseguro/subscriber/{id}/subscription`    | Exibe a assinatura de um usuário                |
| POST   | `/api/pagseguro/subscriber/{id}/sync`            | Registra um assinante no PagBank                |

### 👨🏿‍🏫 Providers

| Método | Endpoint                                     | Descrição                                       |
|--------|----------------------------------------------|-------------------------------------------------|
| GET    | `/api/provider`                              | Lista todos os prestadores                      |
| GET    | `/api/provider/{id}`                         | Detalha um prestador por ID                     |
| POST   | `/api/provider`                              | Cadastra um novo prestador                      |
| PUT    | `/api/provider/{id}`                         | Atualiza um prestador                           |
| DELETE | `/api/provider/{id}`                         | Remove um prestador                             |
| GET    | `/api/provider/{id}/patients`                | Lista os pacientes de um prestador              |
| GET    | `/api/provider/{id}/charges`                 | Lista as cobranças de um prestador              |
| GET    | `/api/provider/{id}/workouts`                | Lista os treinos de um prestador                |
| GET    | `/api/provider/{id}/financial_transactions`  | Lista as transações financeiras de um prestador |
| GET    | `/api/provider/{id}/logs`                    | Lista os logs de um prestador                   |

### 🔗 Charge links

| Método | Endpoint                 | Descrição                                |
|--------|--------------------------|------------------------------------------|
| GET    | `/api/charge_link`       | Lista todos os links da cobrança         |
| GET    | `/api/charge_link/{id}`  | Detalha um link da cobrança por ID       |
| POST   | `/api/charge_link`       | Cadastra um novo link da cobrança        |
| PUT    | `/api/charge_link/{id}`  | Atualiza um link da cobrança             |
| DELETE | `/api/charge_link/{id}`  | Remove um link da cobrança               |

### 📱 QR Codes

| Método | Endpoint             | Descrição                       |
|--------|----------------------|---------------------------------|
| GET    | `/api/qr_code`       | Lista todos os QR Codes         |
| GET    | `/api/qr_code/{id}`  | Detalha um QR Code por ID       |
| POST   | `/api/qr_code`       | Cadastra um novo QR Code        |
| PUT    | `/api/qr_code/{id}`  | Atualiza um QR Code             |
| DELETE | `/api/qr_code/{id}`  | Remove um QR Code               |

## 🛠️ Tecnologias utilizadas

- **Laravel 10.10**
- **PHP 8.1**
- **MySQL**
- **JWT**
- **AWS SES**
- **PagBank**
- **Docker**
- **GitHub Actions (CI/CD)**

## ✒️ Autores

- **Felipe Silva** - *Desenvolvedor e mentor* - [felipesilva15](https://github.com/felipesilva15)

## 📄 Licença

Este projeto está sob a licença (MIT) - veja o arquivo [LICENSE](https://github.com/felipesilva15/fitmotive-api/blob/main/LICENSE) para detalhes.

---

Documentado por [Felipe Silva](https://github.com/felipesilva15) 😊
