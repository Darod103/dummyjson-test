<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


/**
 * Абстрактный контроллер для получения и добавления сущностей.
 */
abstract class BaseApiController
{
    /**
     * Возвращает класс модели.
     *
     * @return string
     */
    abstract protected function modelClass(): string;

    /**
     * Валидирует и возвращает данные для создания сущности.
     *
     * @param Request $request
     * @return array
     */
    abstract protected function validateRequest(Request $request): array;

    /**
     * Получить список всех записей, с фильтрацией по ?search=...
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $model = $this->modelClass();
        $query = $model::query();

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        return response()->json($query->get());
    }

    /**
     * Получить одну запись по ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $model = $this->modelClass();
        $item = $model::find($id);

        if (!$item) {
            return response()->json(['error' => 'Не найдено'], 404);
        }

        return response()->json($item);
    }

}
