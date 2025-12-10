<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Services\TemplateService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends Controller
{
    protected $templateService;

    public function __construct(TemplateService $templateService) {
        $this->templateService = $templateService;
    }

    public function index() {
        $templates = $this->templateService->getAllTempaltes();
        return TemplateResource::collection($templates);
    }

    public function store(StoreTemplateRequest $request) {
        $template = $this->templateService->createTemplate($request->validated());
        return new TemplateResource($template);
    }

    public function show($id) {
        $template = $this->templateService->getTemplate($id);
        return new TemplateResource($template);
    }

    public function update($id, UpdateTemplateRequest $request) {
        $template = $this->templateService->editTemplate($id, $request->validated());
        return new TemplateResource($template);
    }

    public function destroy($id) {
        $this->templateService->deleteTemplate($id);
        return response()->json(['message'=>'Template deleted successfully']);
    }

    public function restore($id) {
        $this->templateService->restoreTemplate($id);
        return response()->json(['message'=>'Template restored successfully']);
    }

    public function render(Request $request, $id)
    {
        $template = $this->templateService->getTemplate($id);

        $data = $request->input('data', []);

        $renderedContent = $template->render($data);

        return response()->json([
            'template_id' => $template->id,
            'rendered' => $renderedContent
        ]);
    }

}
