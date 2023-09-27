<?php
namespace Tests\Traits;

trait ResponseStructureTrait
{
    public function paginateResponseStructure(): array
    {
        return [
            'status',
            'success',
            'data' => [$this->dataStructureList()],
            'pagination' => ['count', 'total', 'perPage', 'currentPage', 'totalPages']
        ];
    }

    public function modelResponseStructure(): array
    {
        return [
            'status',
            'success',
            'data' => $this->dataStructure(),
        ];
    }
}
