# Laravel API Importer (dummyjson.com)

Проект на Laravel 12 с использованием Sail (Docker) для импорта данных из внешнего API (https://dummyjson.com), фильтрации и работы с ними через REST API.

---

## Возможности

- Импорт `products`, `users`, `posts`, `recipes` из DummyJSON
- Фильтрация по ключевым словам (`?search=iphone`)
- Работа с API: добавление, получение одного и всех записей
- Расширяемая архитектура под любые сущности
- Встроенный Laravel Sail (Docker окружение)

---


## Установка через Laravel Sail

```bash
git clone https://github.com/your-username/laravel-api-importer.git
cd laravel-api-importer

# Установи зависимости
./vendor/bin/sail up -d

# Создай .env и сгенерируй ключ
cp .env.example .env
./vendor/bin/sail artisan key:generate

# Примени миграции
./vendor/bin/sail artisan migrate
```

---

## Импорт данных

Импортировать продукты, содержащие "iPhone":

```
POST /api/import/products?search=iphone
```
Импорт всех продуктов:
```
POST /api/import/products
```
---
## Расширение

Чтобы добавить новую сущность (users, posts, recipes):
1.	Создай модель и миграцию
2.	Создай XxxImporter, расширяя AbstractImporter
3.	Создай XxxController, расширяя BaseApiController
4.	Пропиши роуты в routes/api/xxx.php
---
## Пример Api

```
GET     /api/products              Получить список продуктов (можно ?search=iphone)
GET     /api/products/{id}         Получить один продукт по ID
POST    /api/products              Добавить продукт вручную
POST    /api/import/products       Импортировать продукты из API (можно ?search=iphone)
```
