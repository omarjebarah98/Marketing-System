<?php

namespace App\Repositories;

use App\Models\Template;
use App\Repositories\Interfaces\TemplateRepositoryInterface;

class TemplateRepository implements TemplateRepositoryInterface {

    protected $model;

    public function __construct(Template $template) {
        $this->model = $template;
    }

    public function getAllTemplates() {
        return $this->model->all();
    }
    public function getTemplateById(int $id) {
        return $this->model->findOrFail($id);
    }
    public function create(array $data) {
        return $this->model->create($data);
    }
    public function update(int $id, array $data) {
        $template = $this->getTemplateById($id);
        $template->update($data);
        return $template;
    }
    public function delete(int $id) {
        $template = $this->getTemplateById($id);
        return $template->delete();
    }
    public function findTrashedById($id) {
        $deletedTemplate = $this->model->onlyTrashed()->find($id);
        return $deletedTemplate;
    }
    public function restore(int $id) {
        $template = $this->model->onlyTrashed()->find($id);
        return $template->restore();
    }
}
