# Diagramas do projeto

Sistema de Controle de Estoque (ERP Simplificado).

## Diagrama de classes

```mermaid
classDiagram
    class User {
        +int id
        +string name
        +string email
        +string password
        +UserRole role
    }

    class Client {
        +int id
        +string name
        +string document
        +string email
        +string phone
        +string address
    }

    class Product {
        +int id
        +string name
        +string sku
        +string description
        +decimal price
        +int stock_quantity
        +bool active
        +isLowStock() bool
    }

    class Order {
        +int id
        +OrderStatus status
        +decimal total
        +string notes
        +datetime billed_at
    }

    class OrderItem {
        +int id
        +string product_name
        +decimal unit_price
        +int quantity
        +decimal subtotal
    }

    class StockMovement {
        +int id
        +StockMovementType type
        +int quantity
        +string reason
    }

    class UserRole {
        <<enumeration>>
        ADMIN
        GESTOR
        FUNCIONARIO
    }

    class OrderStatus {
        <<enumeration>>
        ABERTO
        FATURADO
        SAIU_ENTREGA
        ENTREGUE
        CANCELADO
    }

    class StockMovementType {
        <<enumeration>>
        ENTRADA
        SAIDA
    }

    User "1" --> "0..*" Order : abre
    Client "1" --> "0..*" Order : realiza
    Order "1" *-- "1..*" OrderItem : contém
    Product "1" --> "0..*" OrderItem : referenciado em
    Product "1" --> "0..*" StockMovement : movimenta
    Order "0..1" --> "0..*" StockMovement : origina
    User "0..1" --> "0..*" StockMovement : registra

    User ..> UserRole
    Order ..> OrderStatus
    StockMovement ..> StockMovementType
```

## Diagrama de casos de uso

Os papéis herdam permissões: o **Gestor** pode tudo o que o **Funcionário** pode, e o **Admin** pode tudo o que o **Gestor** pode.

```mermaid
flowchart LR
    Funcionario["👤 Funcionário"]
    Gestor["👤 Gestor"]
    Admin["👤 Admin"]

    Gestor -->|herda de| Funcionario
    Admin -->|herda de| Gestor

    subgraph Sistema["Sistema de Controle de Estoque"]
        UC_Login(["Fazer login / logout"])
        UC_Perfil(["Editar próprio perfil"])
        UC_ConsultarProdutos(["Consultar produtos"])
        UC_ConsultarClientes(["Consultar clientes"])
        UC_CadastrarCliente(["Cadastrar cliente"])
        UC_CriarPedido(["Criar pedido"])
        UC_BaixarEstoque(["Baixar estoque"])
        UC_AvancarPedido(["Avançar status do pedido"])
        UC_FaturarPedido(["Faturar pedido"])
        UC_GerarPDF(["Gerar PDF da NF"])
        UC_CancelarPedido(["Cancelar pedido"])
        UC_DevolverEstoque(["Devolver estoque"])
        UC_RegistrarMov(["Registrar movimentação"])

        UC_CRUDProdutos(["CRUD de produtos"])
        UC_EditarClientes(["Editar / excluir clientes"])
        UC_MovManual(["Movimentar estoque manualmente"])
        UC_VerMov(["Consultar histórico de movimentações"])
        UC_Relatorios(["Gerar relatórios"])
        UC_RelPDF(["Exportar relatório em PDF"])

        UC_CRUDUsuarios(["CRUD de usuários"])
    end

    Funcionario --- UC_Login
    Funcionario --- UC_Perfil
    Funcionario --- UC_ConsultarProdutos
    Funcionario --- UC_ConsultarClientes
    Funcionario --- UC_CadastrarCliente
    Funcionario --- UC_CriarPedido
    Funcionario --- UC_AvancarPedido
    Funcionario --- UC_CancelarPedido

    Gestor --- UC_CRUDProdutos
    Gestor --- UC_EditarClientes
    Gestor --- UC_MovManual
    Gestor --- UC_VerMov
    Gestor --- UC_Relatorios

    Admin --- UC_CRUDUsuarios

    UC_CriarPedido -.->|include| UC_BaixarEstoque
    UC_BaixarEstoque -.->|include| UC_RegistrarMov
    UC_CancelarPedido -.->|include| UC_DevolverEstoque
    UC_DevolverEstoque -.->|include| UC_RegistrarMov
    UC_MovManual -.->|include| UC_RegistrarMov
    UC_AvancarPedido -.->|extend: faturar| UC_FaturarPedido
    UC_FaturarPedido -.->|extend| UC_GerarPDF
    UC_Relatorios -.->|extend| UC_RelPDF
```
