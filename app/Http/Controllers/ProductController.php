<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Контроллер для управления продуктами.
 * Поддерживает добавление, получение списка и одного продукта.
 * Наследуется от BaseApiController, реализуя только специфику продуктов.
 */
class ProductController extends BaseApiController
{
    /**
     * Возвращает класс модели, с которой работает контроллер.
     *
     * @return string
     */
    protected function modelClass(): string
    {
        return Product::class;
    }

    /**
     * Валидирует запрос на создание продукта.
     *
     * @param Request $request HTTP-запрос с данными продукта
     * @return array Валидированные данные
     */
    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'brand' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|url',
            'images' => 'nullable|array',
        ]);
    }
}
