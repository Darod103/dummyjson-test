<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Сервис для загрузки данных с внешнего API (https://dummyjson.com)
 * Поддерживает постраничную загрузку всех элементов (limit, skip).
 */
class ImportService
{
    /**
     * Количество элементов, запрашиваемых за один запрос (пагинация).
     */
    private const DEFAULT_LIMIT = 100;

    /**
     * Загружает все данные по сущности с учётом пагинации.
     *
     * @param string $entity Например: 'products', 'users', 'posts', 'recipes'
     * @return array Массив всех полученных элементов
     *
     * @throws Exception Если не удалось получить данные от API
     */
    public function fetchDataAll(string $entity): array
    {
        $allItems = [];
        $skip = 0;
        $limit = self::DEFAULT_LIMIT;

        do {
            $response = Http::get("https://dummyjson.com/{$entity}?limit={$limit}&skip={$skip}");

            if (!$response->successful()) {
                throw new Exception("Failed to fetch {$entity}");
            }

            $json = $response->json();
            $items = $json[$entity] ?? [];
            $total = $json['total'] ?? count($items);

            $allItems = array_merge($allItems, $items);
            $skip += $limit;
        } while ($skip < $total);

        return $allItems;
    }
}
