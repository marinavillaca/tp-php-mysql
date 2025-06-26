# Sistema de Cadastro e Login de Usuários com Dashboard

Este é um projeto básico de sistema web desenvolvido em **PHP** com **MySQL**. Ele permite o **cadastro, login e gerenciamento de usuários**, com um painel administrativo (dashboard) que possibilita editar e excluir os registros.

## 🧩 Funcionalidades

- Cadastro de usuários com validação de dados
- Hash de senha utilizando `password_hash()`
- Login com verificação de senha segura
- Dashboard com lista de usuários cadastrados
- Edição e exclusão de clientes
- Logout com destruição segura da sessão

---

## 🚀 Como rodar o projeto

### Pré-requisitos

- Servidor local (como XAMPP, WAMP ou MAMP)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Navegador Web

### 1. Configure o banco de dados

- Crie um banco chamado `marina`
- Execute o seguinte SQL no phpMyAdmin ou outro gerenciador de banco:

```sql
CREATE TABLE tabela_clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  ativo BOOLEAN DEFAULT 1
);
```

### 2. Atualize as credenciais do banco

No arquivo `config.php`, edite conforme suas credenciais locais:

```php
$pdo = new PDO('mysql:host=localhost;dbname=marina', 'SEU_USUARIO', 'SUA_SENHA');
```

---

## 🔐 Como usar

### Cadastro

1. Acesse o arquivo `cadastro.php` via navegador.
2. Preencha os dados obrigatórios.
3. Após o cadastro, você será redirecionado automaticamente para o painel (dashboard).

### Login

1. Acesse `index.php`.
2. Insira seu **nome de usuário** e **senha**.
3. Se os dados estiverem corretos, será redirecionado ao `dashboard.php`.

---

## 🖥️ Estrutura dos Arquivos

| Arquivo              | Função                                         |
| -------------------- | ---------------------------------------------- |
| `index.php`          | Tela de login                                  |
| `cadastro.php`       | Tela de cadastro de novos usuários             |
| `dashboard.php`      | Painel para listar, editar e deletar usuários  |
| `logout.php`         | Faz o logout destruindo a sessão               |
| `processa_login.php` | Processa os dados de login                     |
| `config.php`         | Conexão com o banco de dados e funções globais |
| `styles.css`         | Estilos visuais e responsividade               |

---

## 👩‍💻 Autora

Desenvolvido por [Marina Laura Villaça e Melo](https://github.com/marinavillaca) – apaixonada por tecnologia, sistemas e inovação.

Disciplina: Tópicos Especiais de Banco de Dados.

--
