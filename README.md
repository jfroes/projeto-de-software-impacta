# Sistema de Controle de Estoque (ERP Simplificado)

Projeto acadêmico desenvolvido para a disciplina de **Software Product: Analysis, Specification, Project & Implementation 202602 - EAD - ADS 5A**, simulando um sistema simplificado de ERP com controle de estoque, clientes e pedidos.

## 🧱 Stack

- **Laravel 13**
- **Blade** (views)
- **Tailwind CSS** (estilo, inspirado em Material Design)
- **Livewire** (tabelas com filtro/listagem dinâmica)
- **barryvdh/laravel-dompdf** (geração de PDF / NF simulada)
- **MySQL**

## 👥 Perfis de usuário

O sistema possui controle de acesso baseado em roles (`Enum UserRole`):

| Role | Permissões |
|---|---|
| **Admin** | Acesso total, incluindo CRUD de usuários |
| **Gestor** | CRUD de produtos/clientes, relatórios, gerenciamento de pedidos |
| **Funcionário** | Cria/gerencia pedidos, edita o próprio perfil, consulta produtos/clientes |

## 📦 Funcionalidades

O projeto foi dividido em 4 entregas incrementais, cada uma com pelo menos 2 funcionalidades completas (backend + frontend + banco):

### Entrega 1 — Fundação
- [x] Autenticação (login/logout manual + middleware de role)
- [x] CRUD de Usuários (admin) + Tela de Perfil

### Entrega 2 — Cadastros base
- [ ] CRUD de Produtos
- [ ] CRUD de Clientes

### Entrega 3 — Núcleo do domínio
- [ ] Pedidos (criação com itens, baixa de estoque em transação, snapshot de preço)
- [ ] Faturamento de pedidos + geração de PDF (NF simulada)

### Entrega 4 — Fechamento
- [ ] Relatórios (vendas por período, produtos mais vendidos, pedidos por status)
- [ ] Movimentação de estoque (histórico/auditoria)
- [ ] Diagrama de Classes + Diagrama de Casos de Uso

> O acompanhamento detalhado de cada entrega está no [GitHub Project](https://github.com/users/jfroes/projects/1/views/1) deste repositório.

## 🗂️ Modelagem de dados

Entidades principais: `User`, `Product`, `Client`, `Order`, `OrderItem`, `StockMovement`.

Regras de negócio centrais:
- **Snapshot de preço**: cada `OrderItem` guarda `product_name` e `unit_price` no momento da venda — o pedido nunca reflete uma alteração futura no cadastro do produto.
- **Transação atômica na criação de pedidos**: baixa de estoque, criação dos itens e recálculo do total ocorrem dentro de uma única transação; falha em qualquer item desfaz tudo.
- **Cancelamento de pedido**: devolve a quantidade de cada item ao estoque e registra a movimentação correspondente.

Os diagramas de classes e de casos de uso ficam em [`docs/diagramas.md`](docs/diagramas.md) (Mermaid).

## ⚙️ Como rodar o projeto

```bash
git clone <url-do-repositorio>
cd controle-estoque

composer install
cp .env.example .env
php artisan key:generate

# configure as credenciais do banco no .env antes de migrar

php artisan migrate --seed

npm install
npm run dev
```

Em outro terminal:

```bash
php artisan serve
```

Acesse `http://localhost:8000`.

### Usuário de teste (seeder)

Rodar `php artisan db:seed --class=DataSeeder` cria um usuário admin de teste:

| Email            | Senha | Role |
|------------------|-------|------|
| test@example.com | password | admin |

## 🗃️ Estrutura de pastas (resumo)

```
app/
├── Enums/            # UserRole, OrderStatus
├── Http/
│   ├── Controllers/
│   ├── Middleware/   # EnsureUserHasRole
│   └── Mail/             # Mailables
├── Models/
├── Services/         # OrderService, ReportService (regra de negócio)
└── Database/
    ├── Factories/
    ├── Migrations/
    └── Seeders/
resources/
└── views/            # Blade templates
```

## 📄 Licença

Projeto acadêmico sem fins comerciais.
