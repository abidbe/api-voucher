# Dokumentasi API Aplikasi Voucher

## URL Dasar

```
http://localhost/api
```

## Autentikasi

Sebagian besar endpoint memerlukan token autentikasi (Bearer Token) yang diperoleh setelah login.

---

## Endpoint

### 1. Registrasi Pengguna

**Endpoint:** `POST /register`

**Deskripsi:** Mendaftarkan pengguna baru.

**Header Permintaan:**

-   `Content-Type: application/json`

**Body Permintaan:**

```json
{
    "username": "testuser",
    "password": "password123",
    "email": "testuser@example.com",
    "nama": "Test User"
}
```

**Respons:**

-   **Sukses:**
    -   **Status:** `201 Created`
    -   **Body:**
        ```json
        {
            "message": "User registered successfully"
        }
        ```
-   **Gagal:**
    -   **Status:** `400 Bad Request`
    -   **Body:**
        ```json
        {
            "message": "Validation error messages"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X POST http://localhost/api/register \
-H "Content-Type: application/json" \
-d '{
  "username": "testuser",
  "password": "password123",
  "email": "testuser@example.com",
  "nama": "Test User"
}'
```

---

### 2. Login Pengguna

**Endpoint:** `POST /login`

**Deskripsi:** Login pengguna dan mengembalikan token autentikasi.

**Header Permintaan:**

-   `Content-Type: application/json`

**Body Permintaan:**

```json
{
    "username": "testuser",
    "password": "password123"
}
```

**Respons:**

-   **Sukses:**
    -   **Status:** `200 OK`
    -   **Body:**
        ```json
        {
            "access_token": "string",
            "token_type": "Bearer"
        }
        ```
-   **Gagal:**
    -   **Status:** `401 Unauthorized`
    -   **Body:**
        ```json
        {
            "message": "Invalid login credentials"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X POST http://localhost/api/login \
-H "Content-Type: application/json" \
-d '{
  "username": "testuser",
  "password": "password123"
}'
```

---

### 3. Logout Pengguna

**Endpoint:** `POST /logout`

**Deskripsi:** Logout pengguna dan menghapus token autentikasi.

**Header Permintaan:**

-   `Authorization: Bearer {access_token}`

**Respons:**

-   **Sukses:**
    -   **Status:** `200 OK`
    -   **Body:**
        ```json
        {
            "message": "User logged out successfully"
        }
        ```
-   **Gagal:**
    -   **Status:** `401 Unauthorized`
    -   **Body:**
        ```json
        {
            "message": "Unauthenticated"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X POST http://localhost/api/logout \
-H "Authorization: Bearer your_access_token"
```

---

### 4. Dapatkan Voucher yang Tersedia

**Endpoint:** `GET /vouchers`

**Deskripsi:** Mengambil semua voucher yang tersedia.

**Header Permintaan:**

-   `Authorization: Bearer {access_token}`

**Respons:**

-   **Sukses:**
    -   **Status:** `200 OK`
    -   **Body:**
        ```json
        [
          {
            "id": 1,
            "nama": "Voucher A",
            "foto": "path/to/foto_a.jpg",
            "kategori": "Kategori 1",
            "status": true,
            "created_at": "datetime",
            "updated_at": "datetime"
          },
          ...
        ]
        ```
-   **Gagal:**
    -   **Status:** `401 Unauthorized`
    -   **Body:**
        ```json
        {
            "message": "Unauthenticated"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X GET http://localhost/api/vouchers \
-H "Authorization: Bearer your_access_token"
```

---

### 5. Klaim Voucher

**Endpoint:** `POST /vouchers/claim/{id}`

**Deskripsi:** Klaim voucher berdasarkan ID-nya.

**Header Permintaan:**

-   `Authorization: Bearer {access_token}`

**Respons:**

-   **Sukses:**
    -   **Status:** `200 OK`
    -   **Body:**
        ```json
        {
            "message": "Voucher claimed successfully"
        }
        ```
-   **Gagal:**
    -   **Status:** `400 Bad Request`
    -   **Body:**
        ```json
        {
            "message": "Voucher is not available"
        }
        ```
    -   **Status:** `401 Unauthorized`
    -   **Body:**
        ```json
        {
            "message": "Unauthenticated"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X POST http://localhost/api/vouchers/claim/1 \
-H "Authorization: Bearer your_access_token"
```

---

### 6. Lihat Voucher yang Diklaim (Riwayat)

**Endpoint:** `GET /vouchers/history`

**Deskripsi:** Mengambil semua voucher yang diklaim oleh pengguna yang diautentikasi.

**Header Permintaan:**

-   `Authorization: Bearer {access_token}`

**Respons:**

-   **Sukses:**
    -   **Status:** `200 OK`
    -   **Body:**
        ```json
        [
          {
            "id": 1,
            "id_voucher": 1,
            "id_user": 1,
            "tanggal_claim": "datetime",
            "created_at": "datetime",
            "updated_at": "datetime",
            "voucher": {
              "id": 1,
              "nama": "Voucher A",
              "foto": "path/to/foto_a.jpg",
              "kategori": "Kategori 1",
              "status": false,
              "created_at": "datetime",
              "updated_at": "datetime"
            }
          },
          ...
        ]
        ```
-   **Gagal:**

    -   **Status:** `401 Unauthorized`
    -   **Body:**

        ```json
        {
            "message": "Unauthenticated"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X GET http://localhost/api/vouchers/history \
-H "Authorization: Bearer your_access_token"
```

---

### 7. Hapus Voucher yang Diklaim

**Endpoint:** `DELETE /vouchers/history/{id}`

**Deskripsi:** Menghapus voucher yang diklaim berdasarkan ID klaim dan mengembalikan voucher ke daftar yang tersedia.

**Header Permintaan:**

-   `Authorization: Bearer {access_token}`

**Respons:**

-   **Sukses:**
    -   **Status:** `200 OK`
    -   **Body:**
        ```json
        {
            "message": "Claim deleted successfully"
        }
        ```
-   **Gagal:**
    -   **Status:** `403 Forbidden`
    -   **Body:**
        ```json
        {
            "message": "Unauthorized"
        }
        ```
    -   **Status:** `401 Unauthorized`
    -   **Body:**
        ```json
        {
            "message": "Unauthenticated"
        }
        ```

**Contoh Permintaan:**

```bash
curl -X DELETE http://localhost/api/vouchers/history/1 \
-H "Authorization: Bearer your_access_token"
```
