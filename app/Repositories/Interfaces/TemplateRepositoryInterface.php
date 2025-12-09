<?php

namespace App\Repositories\Interfaces;

interface TemplateRepositoryInterface
{
    public function getAllTemplates();
    public function getTemplateById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
