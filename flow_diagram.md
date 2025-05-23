# Müzik Dünyası E-Ticaret Sitesi Akış Diyagramı

## Kullanıcı Akışı

```
+------------+     +-----------+     +-------------+     +-------------+     +-----------+
|            |     |           |     |             |     |             |     |           |
| Kayıt Olma +---->+ Giriş     +---->+ Ürün        +---->+ Sepete      +---->+ Ödeme     |
|            |     | Yapma     |     | İnceleme    |     | Ekleme      |     | İşlemi    |
+------------+     +-----------+     +-------------+     +-------------+     +-----+-----+
                                                                                  |
                   +-----------+     +-------------+     +-------------+          |
                   |           |     |             |     |             |          |
                   | Sipariş   <-----+ Sipariş     <-----+ Ödeme       <----------+
                   | Takibi    |     | Oluşturma   |     | Onayı       |
                   +-----------+     +-------------+     +-------------+
```

## Admin Akışı

```
+-----------+     +------------+     +-----------+     +-------------+
|           |     |            |     |           |     |             |
| Giriş     +---->+ Admin      +---->+ Ürün      +---->+ Ürün        |
| Yapma     |     | Paneli     |     | Listesi   |     | Ekleme      |
+-----------+     +-----+------+     +-----------+     +-------------+
                        |
                        |
           +------------v-----------+
           |                        |
           |                        |
+----------v-------+     +----------v---------+
|                  |     |                    |
| Kullanıcı        |     | Sipariş            |
| Yönetimi         |     | Yönetimi           |
+------------------+     +--------------------+
```

## Sipariş İşleme Akışı

```
+-------------+     +-------------+     +-------------+
|             |     |             |     |             |
| Kullanıcı   +---->+ Sipariş     +---->+ Beklemede   |
| Sipariş     |     | Oluşturuldu |     | Durumu      |
| Verdi       |     |             |     |             |
+-------------+     +-------------+     +------+------+
                                               |
                                               | Admin Onayı
                                               |
+-------------+     +-------------+     +------v------+
|             |     |             |     |             |
| Teslim      <-----+ Yolda       <-----+ Tedarik     |
| Edildi      |     | Durumu      |     | Aşaması     |
|             |     |             |     |             |
+------+------+     +------+------+     +-------------+
       |                   ^
       |                   |
       |            +------+------+     +-------------+
       |            |             |     |             |
       |            | Kargoya     <-----+ Kutulama    |
       |            | Verildi     |     | Aşaması     |
       |            |             |     |             |
       |            +-------------+     +-------------+
       |
       | Kullanıcı Onayı
       v
+------+------+
|             |
| Sipariş     |
| Tamamlandı  |
|             |
+-------------+
```

## Ödeme İşlemi Akışı

```
+-------------+     +-------------+     +-------------+
|             |     |             |     |             |
| Sepet       +---->+ Ödeme       +---->+ Kredi Kartı |
| Onayı       |     | Sayfası     |     | Bilgileri   |
|             |     |             |     |             |
+-------------+     +-------------+     +------+------+
                                               |
                         +--------------------+
                         |
                         v
+-------------+     +----+--------+     +-------------+
|             |     |             |     |             |
| Sipariş     <-----+ Ödeme       <-----+ Bakiye      |
| Oluşturuldu |     | Onayı       |     | Kontrolü    |
|             |     |             |     |             |
+-------------+     +-------------+     +-------------+
```
