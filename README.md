
# 🚀 Sistema CRUD Completo com Autenticação de Usuários em PHP & MySQL

Este projeto é um sistema web dinâmico e seguro para gerenciamento de usuários (CRUD - Create, Read, Update, Delete), construído com **PHP** no back-end e **HTML/CSS** no front-end. Ele evoluiu de um conceito simples para uma aplicação robusta que demonstra a persistência de dados utilizando um **banco de dados MySQL** e gerencia o acesso de usuários através de um sistema de autenticação.

Este projeto é uma excelente oportunidade para aprofundar conhecimentos e aplicar conceitos em:

  * **PHP Avançado:**
      * **Programação Orientada a Procedimentos:** Estrutura e organização do código PHP.
      * **Manipulação de Formulários:** Processamento de requisições `GET` e `POST` com validação de dados.
      * **Superglobais:** Utilização de `$_GET`, `$_POST`, `$_SERVER` e, crucialmente, `$_SESSION` para gerenciamento de estado.
      * **Sessões PHP:** Implementação de sessões para autenticação de usuários e mensagens "flash".
      * **Funções de Segurança:** Uso de `htmlspecialchars()` para prevenção de XSS e `password_hash()` / `password_verify()` para armazenamento e verificação segura de senhas.
  * **Banco de Dados (MySQL):**
      * **Modelagem de Dados:** Criação de tabelas (`CREATE TABLE`) com tipos de dados apropriados e chaves primárias/únicas.
      * **Consultas SQL:** `SELECT`, `INSERT`, `UPDATE`, `DELETE`.
      * **PDO (PHP Data Objects):** Conexão segura e eficiente com o banco de dados.
      * **Prepared Statements:** Utilização de placeholders (nomeados e posicionais) para prevenir **SQL Injection**, garantindo a segurança das operações no banco.
  * **HTML & CSS:**
      * **Estruturação de Páginas:** Criação de formulários intuitivos e tabelas para exibição de dados.
      * **Estilização Profissional:** Utilização de CSS externo para um design moderno e visualmente agradável, com uma paleta de cores (roxo e lilás) e importação de fontes do Google Fonts (`Poppins`).
      * **Usabilidade (UX):** Mensagens de feedback claras e pré-preenchimento de formulários.
  * **Arquitetura de Aplicações Web:**
      * **Separação de Preocupações:** Código HTML e PHP em arquivos separados (`.html` / `.php`, `funcoes.php`).
      * **Modularização:** Funções de banco de dados e lógica de negócio em arquivos dedicados.
      * **Proteção de Rotas:** Restringindo o acesso a páginas específicas para usuários autenticados.

-----

## ✨ Funcionalidades

  * **Autenticação de Usuários:**
      * **Cadastro (`Sign Up`):** Formulário para novos usuários com registro de nome, e-mail, idade e senha (armazenada de forma segura com `password_hash()`).
      * **Login (`Sign In`):** Autenticação de usuários com verificação de credenciais via `password_verify()` contra hashes de senha no banco de dados.
      * **Logout (`Sign Out`):** Encerramento seguro da sessão do usuário.
      * **Proteção de Páginas:** Redirecionamento automático para a página de login caso um usuário não autenticado tente acessar áreas restritas do CRUD.
  * **CRUD Completo de Usuários:**
      * **C (Create):** Adiciona novos registros de usuários no banco de dados MySQL.
      * **R (Read):** Exibe a lista completa de usuários cadastrados em uma tabela interativa.
      * **U (Update):** Permite a edição de nome, e-mail e idade, com opção de atualização da senha.
      * **D (Delete):** Remove usuários específicos do banco de dados.
  * **Persistência de Dados Robusta:** Dados armazenados e gerenciados em um banco de dados **MySQL** real.
  * **Mensagens de Feedback:** Exibe mensagens de sucesso e erro (usando sessões PHP para "mensagens flash") após operações CRUD e de autenticação.
  * **Design Moderno e Intuitivo:** Interface de usuário limpa e amigável com estilização CSS personalizada e fontes do Google Fonts.

-----

## 🛠️ Tecnologias Utilizadas

  * **PHP:** Linguagem de programação principal (versão 5.6.x ou superior, compatível com PDO).
  * **MySQL:** Sistema de gerenciamento de banco de dados relacional.
  * **PDO (PHP Data Objects):** Extensão PHP para conexão e operação com bancos de dados.
  * **HTML5:** Para a estrutura das páginas web e formulários.
  * **CSS3:** Para o design e estilização do projeto.

-----

## 🚀 Como Executar Localmente

Para rodar este projeto em sua máquina, você precisará de um ambiente de servidor web com suporte a PHP e MySQL (como EasyPHP, XAMPP, WAMP ou LAMP).

1.  **Clone este repositório:**

    ```bash
    git clone https://github.com/MaryAylla/crud-php.git
    ```

    (Lembre-se de substituir `MaryAylla/crud-php` pelo caminho real do seu repositório no GitHub).

2.  **Acesse a pasta do projeto:**

    ```bash
    cd crud-php
    ```

3.  **Configuração do Banco de Dados MySQL:**

      * **Inicie o serviço MySQL** do seu ambiente (EasyPHP, XAMPP, etc.).
      * Acesse o **phpMyAdmin** (geralmente em `http://localhost/phpmyadmin`).
      * **Crie um novo banco de dados** chamado `crud_usuarios_mysql`.
      * **Execute o seguinte comando SQL** na aba "SQL" do seu novo banco de dados para criar a tabela `usuarios`:
        ```sql
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            idade INT NOT NULL,
            senha_hash VARCHAR(255) NOT NULL
        );
        ```
      * **Atualize o arquivo `conexao.php`** com as credenciais do seu banco de dados MySQL (host, nome do banco, usuário e senha). Se você não criou um usuário específico, pode usar `root` com senha vazia (`''`).

4.  **Habilitar Extensão PDO para MySQL (se necessário):**

      * No seu arquivo `php.ini` (localizado na pasta da sua versão PHP ativa no EasyPHP), procure e **descomente** a linha:
        ```ini
        extension=php_pdo_mysql.dll
        ```
      * **Reinicie o EasyPHP/servidor web completamente** para que as alterações no `php.ini` tenham efeito.

5.  **Acesse o Projeto:**

      * Abra seu navegador e navegue até a URL da sua página de login:
        ```
        http://localhost/crud-php/login.php
        ```

6.  **Primeiro Acesso e Cadastro:**

      * Como não há usuários ainda, o sistema irá redirecioná-lo para a página de login. Você não poderá fazer login inicialmente.
      * **Para cadastrar o primeiro usuário:** Você precisará **temporariamente comentar o bloco de proteção de página** (o `if (!isset($_SESSION['logado']) ...)` ) nos arquivos `index.php` e `salvar_usuario.php`.
      * Acesse `http://localhost/crud-php/index.php`.
      * Cadastre um novo usuário (lembre-se do e-mail e da senha\!).
      * Após o cadastro, **descomente os blocos de proteção** em `index.php` e `salvar_usuario.php` novamente.
      * Reinicie o EasyPHP.
      * Agora, acesse `login.php` e faça login com o usuário cadastrado.

7.  **Teste as Funcionalidades:**

      * Crie, leia, atualize e exclua usuários.
      * Teste o logout e tente acessar as páginas protegidas novamente.

