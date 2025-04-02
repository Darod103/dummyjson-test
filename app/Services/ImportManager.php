<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\Importers\ProductImporter;

/**
 * Класс ImportManager отвечает за организацию импорта сущностей с внешнего API.
 * Он валидирует запрос, выбирает нужный импортёр и запускает процесс импорта.
 */
class ImportManager
{
    /**
     * Обрабатывает запрос на импорт сущности.
     *
     * @param Request $request HTTP-запрос, может содержать search-параметр
     * @param string $entity Имя сущности (например: products, users)
     * @throws \InvalidArgumentException если указаны неверные параметры или неизвестная сущность
     */
    public function handle(Request $request, string $entity): void
    {
        $queryParams = $request->query();
        $allowed = ['search'];
        $unknownParams = array_diff(array_keys($queryParams), $allowed);

        if (!empty($unknownParams)) {
            throw new \InvalidArgumentException('Неразрешённые параметры: ' . implode(', ', $unknownParams));
        }

        $search = $request->query('search');

        $importer = match ($entity) {
            'products' => app(ProductImporter::class),
            default => throw new \InvalidArgumentException("Unknown entity: {$entity}"),
        };

        $importer->setSearch($search);
        $importer->import();
    }
}

