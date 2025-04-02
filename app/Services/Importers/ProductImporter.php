<?php

namespace App\Services\Importers;

use App\Models\Product;
use App\Services\ImportService;

/**
 * Импортёр товаров. Загружает и сохраняет продукты из внешнего API.
 * Реализует логику фильтрации по названию и сохранения в БД.
 */
class ProductImporter extends AbstractImporter
{
    /**
     * Конструктор, инициализирует сервис импорта.
     *
     * @param ImportService $service
     */
    public function __construct(ImportService $service)
    {
        parent::__construct($service);
    }

    /**
     * Возвращает имя сущности для импорта из внешнего API.
     *
     * @return string
     */
    protected function entityName(): string
    {
        return 'products';
    }

    /**
     * Фильтрует элементы по полю "title". Если задан search — ищет вхождение.
     * Если search не задан — импортирует все.
     *
     * @param array $item Один элемент массива данных
     * @return bool true, если элемент нужно импортировать
     */
    protected function filter(array $item): bool
    {
        if (!$this->search) {
            return true;
        }

        return stripos($item['title'], $this->search) !== false;
    }

    /**
     * Сохраняет или обновляет продукт в БД по названию.
     *
     * @param array $item Один элемент массива данных
     * @return void
     */
    protected function save(array $item): void
    {
        Product::updateOrCreate(
            ['title' => $item['title']],
            [
                'description' => $item['description'] ?? '',
                'price' => $item['price'] ?? 0,
                'brand' => $item['brand'] ?? '',
                'category' => $item['category'] ?? '',
                'thumbnail' => $item['thumbnail'] ?? '',
                'images' => $item['images'] ?? [],
            ]
        );
    }
}
