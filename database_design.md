# Müzik Dünyası E-Ticaret Sitesi Veritabanı Tasarımı

## Varlık-İlişki Diyagramı

```
+---------------+       +---------------+       +---------------+
|    USERS      |       |   PRODUCTS    |       |  CATEGORIES   |
+---------------+       +---------------+       +---------------+
| id            |       | id            |       | id            |
| name          |       | name          |       | name          |
| email         |       | description   |       | description   |
| password      |       | price         |       | parent_id     |
| address       |       | stock_quantity|       | created_at    |
| phone         |       | image_path    |       | updated_at    |
| role          |       | category_id   |------>|               |
| balance       |       | created_at    |       |               |
| created_at    |       | updated_at    |       |               |
| updated_at    |       |               |       |               |
+-------+-------+       +-------+-------+       +---------------+
        ^                       ^
        |                       |
        |                       |
+-------+-------+       +-------+-------+
|    ORDERS     |       | ORDER_ITEMS   |
+---------------+       +---------------+
| id            |       | id            |
| user_id       |------>| order_id      |------>+
| total_amount  |       | product_id    |------>+
| status        |       | quantity      |
| address       |       | price         |
| created_at    |       | created_at    |
| updated_at    |       | updated_at    |
+-------+-------+       +---------------+
        ^
        |
        |
+-------+-------+
| ORDER_STATUS  |
+---------------+
| id            |
| order_id      |------>+
| status        |
| created_at    |
| updated_at    |
+---------------+
```

## Tablolar ve İlişkiler

### Users Tablosu
- id (PK)
- name
- email (unique)
- password
- address
- phone
- role (admin/user)
- balance (kullanıcı bakiyesi)
- created_at
- updated_at

### Categories Tablosu
- id (PK)
- name
- description
- parent_id (self-referencing)
- created_at
- updated_at

### Products Tablosu
- id (PK)
- name
- description
- price
- stock_quantity
- image_path
- category_id (FK to Categories)
- created_at
- updated_at

### Orders Tablosu
- id (PK)
- user_id (FK to Users)
- total_amount
- status (pending, approved, canceled, etc.)
- address
- created_at
- updated_at

### OrderItems Tablosu
- id (PK)
- order_id (FK to Orders)
- product_id (FK to Products)
- quantity
- price
- created_at
- updated_at

### OrderStatus Tablosu
- id (PK)
- order_id (FK to Orders)
- status (tedarik, kutulama, kargolama, yolda, teslim)
- created_at
- updated_at

### Carts Tablosu
- id (PK)
- user_id (FK to Users)
- created_at
- updated_at

### CartItems Tablosu
- id (PK)
- cart_id (FK to Carts)
- product_id (FK to Products)
- quantity
- created_at
- updated_at
