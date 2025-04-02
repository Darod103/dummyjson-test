<?php

namespace App\Services\Importers;

use App\Services\ImportService;

/**
 * Абстрактный импортёр, реализующий общий шаблон импорта сущностей.
 * Наследники реализуют методы entityName, filter и save под конкретную сущность.
 */
abstract class AbstractImporter
{

    protected ImportService $service;

    /**
     * Поисковая строка для фильтрации данных.
     *
     * @var string|null
     */
    protected ?string $search = null;

    public function __construct(ImportService $service)
    {
        $this->service = $service;
    }

    /**
     * Устанавливает строку поиска.
     *
     * @param string|null $search
     */
    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

    /**
     * Возвращает имя сущности, например 'products'.
     *
     * @return string
     */
    abstract protected function entityName(): string;

    /**
     * Применяет фильтр к каждому элементу. Возвращает true, если элемент нужно импортировать.
     *
     * @param array $item
     * @return bool
     */
    abstract protected function filter(array $item): bool;

    /**
     * Сохраняет элемент в базу данных.
     *
     * @param array $item
     * @return void
     */
    abstract protected function save(array $item): void;

    /**
     * Основной метод запуска импорта: получает данные, фильтрует и сохраняет.
     *
     * @return void
     */
    public function import(): void
    {
        $items = $this->service->fetchDataAll($this->entityName());

        foreach ($items as $item) {
            if ($this->filter($item)) {
                $this->save($item);
            }
        }
    }
}
