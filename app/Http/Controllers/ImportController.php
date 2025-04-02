<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\ImportManager;
use Illuminate\Http\JsonResponse;


/**
 * Контроллер для запуска импорта данных с внешнего API (dummyjson.com).
 */
class ImportController extends Controller
{
    protected ImportManager $importManager;

    public function __construct(ImportManager $importManager)
    {
        $this->importManager = $importManager;
    }

    /**
     * Импортирует данные по указанной сущности.
     * Поддерживается фильтрация по ключевому слову (?search=...).
     *
     * Пример: POST /api/import/products?search=iphone
     *
     * @param Request $request HTTP-запрос, может содержать параметр ?search
     * @param string $entity Название сущности для импорта (например: products, users, posts, recipes)
     * @return JsonResponse Ответ с сообщением об успешном импорте или ошибкой
     */
    public function import(Request $request, string $entity): JsonResponse
    {
        try {
            $this->importManager->handle($request, $entity);
            return response()->json(['message' => ucfirst($entity) . ' импортированы']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}

