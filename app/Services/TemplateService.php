<?php

namespace App\Services;

use App\Repositories\Interfaces\TemplateRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TemplateService {

    protected $templateRepo;

    public function __construct(TemplateRepositoryInterface $templateRepo)
    {
        $this->templateRepo = $templateRepo;
    }

    public function getAllTempaltes() {
        return $this->templateRepo->getAllTemplates();
    }

    public function getTemplate($id) {
        return $this->templateRepo->getTemplateById($id);
    }

    public function createTemplate(array $data) {
        return $this->templateRepo->create($data);
    }

    public function editTemplate($id, array $data) {
        $template = $this->templateRepo->getTemplateById($id);
        if(!$template) {
            throw new ModelNotFoundException("Template not found");
        }
        return $this->templateRepo->update($id, $data);
    }

    public function deleteTemplate($id) {
        $template = $this->templateRepo->getTemplateById($id);
        if(!$template) {
            throw new ModelNotFoundException("Template not found");
        }

        return $this->templateRepo->delete($id);
    }

    public function restoreTemplate($id) {
        $template = $this->templateRepo->findTrashedById($id);
        if(!$template) {
            throw new ModelNotFoundException("Template not found");
        }

        return $this->templateRepo->restore($id);
    }
}
