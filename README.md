# Tur Yönetim Sistemi

Bu proje, Laravel kullanılarak geliştirilmiş basit bir tur yönetim sistemi örneğidir. Bu sistem, kullanıcıların turlar oluşturmasına, güncellemesine, listelemesine ve silmesine olanak tanır. Ayrıca, süper admin yetkisine sahip kullanıcıları da destekleyen bir kullanıcı yönetim sistemi içerir.

## Gereksinimler

-   **PHP** >= 8.2
-   **Composer**
-   **MySQL**
-   **Laravel** >= 11.x

## Kurulum

### 1. Projeyi Kopyalayın

Proje dizinini bilgisayarınıza kopyalayın:

```bash
git clone https://github.com/alikdb/tour-api.git
cd tour-api
```

### 2. Bağımlılıkları Yükleyin

Laravel bağımlılıklarını Composer kullanarak yükleyin:

```bash
composer install
```

### 3. Ortam Dosyasını Yapılandırın

`.env.example` dosyasını `.env` olarak kopyalayın ve veritabanı ayarlarını güncelleyin:

```bash
cp .env.example .env
```

`.env` dosyasında veritabanı bilgilerinizi şu şekilde ayarlayın:

```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tour_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Uygulama Anahtarını Oluşturun

Laravel uygulama anahtarını oluşturun:

```bash
php artisan key:generate
```

### 5. Veritabanını Migrate ve Seed Edin

Proje, veritabanı yapısını oluşturmak için `migrate` ve örnek kullanıcıları ve verileri oluşturmak için `seed` işlemi gerektirir. Aşağıdaki komutu çalıştırarak veritabanını migrate edip seed edin:

```bash
php artisan migrate:fresh --seed
```

Bu komut, veritabanını sıfırlar, tüm tabloları yeniden oluşturur ve örnek kullanıcıları ekler. Varsayılan olarak, `admin@example.com` e-posta adresi ve `password` şifresiyle bir **süper admin** kullanıcı oluşturulur.

**Giriş Bilgileri**:

-   E-posta: `admin@example.com`
-   Şifre: `password`

### 6. Sunucuyu Başlatın

Uygulamayı çalıştırmak için şu komutu kullanarak yerel geliştirme sunucusunu başlatın:

```bash
php artisan serve
```

Sunucu genellikle `http://127.0.0.1:8000` adresinde çalışacaktır.

## API Endpoints

Aşağıda projede yer alan temel API uç noktaları listelenmiştir.

### 1. Operator Oluşturma

-   **Endpoint**: `/api/operator/create`
-   **Yöntem**: `POST`
-   **Gövde**:
    ```json
    {
        "name": "Kullanıcı Adı",
        "email": "kullanici@example.com",
        "password": "şifre"
    }
    ```

### 2. Kullanıcı Girişi

-   **Endpoint**: `/api/auth/login`
-   **Yöntem**: `POST`
-   **Gövde**:
    ```json
    {
        "email": "admin@example.com",
        "password": "password"
    }
    ```

### 3. Tur Listeleme

-   **Endpoint**: `/api/tour`
-   **Yöntem**: `GET`
-   **Açıklama**: Tüm turları listeler.
-   **Gövde**:
    ```json
    {
        "start_date": "2024-12-10" // start_date gönderilmez ise tüm turlar listelenir.
    }
    ```

### 4. Tur Oluşturma

-   **Endpoint**: `/api/tours`
-   **Yöntem**: `POST`
-   **Gövde**:
    ```json
    {
        "name": "Tur Adı",
        "description": "Tur açıklaması",
        "location": "Konum",
        "start_date": "2024-01-01",
        "end_date": "2024-01-05",
        "price": 100.5
    }
    ```

### 5. Tur Güncelleme

-   **Endpoint**: `/api/tours/{id}`
-   **Yöntem**: `PUT`
-   **Açıklama**: Belirtilen turun bilgilerini günceller. Sadece turu oluşturan kişi ve süperadmin rolüne sahip kişiler güncelleyebilir.

### 6. Tur Silme

-   **Endpoint**: `/api/tours/{id}`
-   **Yöntem**: `DELETE`
-   **Açıklama**: Belirtilen turu siler. Sadece süperadmin silebilir.

### 7. Kullanıcı Çıkış Yapma

-   **Endpoint**: `/api/auth/logout`
-   **Yöntem**: `POST`
-   **Açıklama**: Giriş yapmış kullanıcıyı çıkış yapar.

## Kimlik Doğrulama

Bu API, `Sanctum` paketini kullanarak kimlik doğrulama yapmaktadır. Kimlik doğrulama gerektiren uç noktalara erişim sağlamak için `login` endpointinden alınan token'ı `Authorization: Bearer {token}` başlığıyla eklemeniz gerekmektedir.

## Ek Bilgiler

-   **Postman Koleksiyonu**: Proje içinde bir Postman koleksiyonu bulunmaktadır. Bu koleksiyon, tüm API uç noktalarına dair örnek istekleri içerir.
-   [Postman Linki](https://galactic-spaceship-637704.postman.co/workspace/8e7d4285-094c-450e-b616-dcaa1959f955)
-   **Kullanıcı Yetkileri**: Süper admin kullanıcı tüm turları yönetebilirken, diğer kullanıcılar yalnızca kendilerine ait turları yönetebilir.
