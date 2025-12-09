<?php

namespace App\Http\Controllers;

use App\Services\CampaignService;
use App\Http\Resources\CampaignResource;
use App\Http\Requests\StoreCampaignRequest;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService) {
        $this->campaignService = $campaignService;
    }

    public function index() {
        $templates = $this->campaignService->getAllCampaigns();
        return CampaignResource::collection($templates);
    }

    public function store(StoreCampaignRequest $request) {
        $template = $this->campaignService->createCampaign($request->validated());
        return new CampaignResource($template);
    }

    public function show($id) {
        $template = $this->campaignService->getCampaign($id);
        return new CampaignResource($template);
    }

    public function update($id, StoreCampaignRequest $request) {
        $template = $this->campaignService->editCampaign($id, $request->validated());
        return new CampaignResource($template);
    }

    public function destroy($id) {
        $this->campaignService->deleteCampaign($id);
        return response()->json(['message'=>'Campaign deleted successfully']);
    }

    public function statistics($id)
    {
        $campaign = $this->campaignService->getCampaign($id);
        return new CampaignResource($campaign);
    }

    public function updateStatus(Request $request, $id) {
        $campaign = Campaign::findOrFail($id);
        $request->validate(['status' => 'required|in:draft,active,paused,completed']);
        $campaign->update(['status' => $request->status]);
        return redirect()->back();
    }

    public function deleteCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->back()->with('success', 'Campaign deleted successfully.');
    }

}
