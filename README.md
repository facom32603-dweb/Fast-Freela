# FastFreela

Aplicação web didática em **PHP** seguindo o padrão **MVC**, com interface em **Bootstrap 5** e estilização própria baseada em uma paleta de cores definida. O sistema permite cadastro/login, publicação e busca de vagas, favoritos, comentários, área do usuário e área administrativa.

---

## Arquitetura

### Fluxo (Front Controller)

1. Toda requisição entra por `public/index.php`
2. O `Router` resolve a rota
3. Um `Controller` trata a requisição e valida entrada
4. Um `Service` aplica regras de negócio
5. Um `Repository` acessa o banco via **PDO**
6. A `View` é renderizada usando layout padrão

### Camadas

* **Controllers**: recebem requisições, chamam Services e definem a View
* **Services**: regras de negócio (ex.: fechar/reabrir vaga, moderação)
* **Repositories**: acesso ao banco (PDO + SQL)
* **Views**: páginas e parciais (HTML) com layout global
* **Core**: Router, View, Database, Auth, Env, Flash

---

## Estrutura de pastas (principais)

```text
fastfreela/
├─ public/
│  ├─ index.php
│  ├─ .htaccess
│  └─ assets/
│     ├─ css/
│     ├─ js/
│     └─ img/
├─ app/
│  ├─ Controllers/
│  ├─ Core/
│  ├─ Helpers/
│  ├─ Models/
│  ├─ Repositories/
│  ├─ Services/
│  └─ Views/
├─ scripts/
│  └─ db_fastfreela.sql
├─ storage/
│  ├─ logs/
│  └─ uploads/
├─ docker/
│  └─ php/
├─ docker-compose.yml
├─ .env.example
└─ README.md
```

> Em hospedagens como InfinityFree pode ser necessário reorganizar para que tudo fique dentro de `htdocs/`. Veja a seção de implantação.

---

## Variáveis de ambiente (conexão com banco)

O projeto lê um `.env` para configurar a conexão PDO:

```env
APP_ENV=local
APP_DEBUG=1
APP_BASE_URL=http://localhost:8080

DB_HOST=db
DB_PORT=3306
DB_NAME=fast-freela
DB_USER=web-app
DB_PASS=lc9y&3W0U5~N
DB_CHARSET=utf8mb4
```

---

## Uso local (Docker Compose)

### Requisitos

* Docker e Docker Compose

### Passos

1. Crie o `.env` e preencha as credenciais do MySQL.
2. Suba o servidor:

   ```bash
   docker compose up --build
   ```
3. Acesse:

   * `http://localhost:8080`

### Banco de dados

* Conecte ao banco de dados por alguma ferramenta como o DBeaver e execute o DDL do banco (htdocs/scripts/db_fastfreela.sql)
