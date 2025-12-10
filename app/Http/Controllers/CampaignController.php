<?php

namespace App\Http\Controllers;

use App\Services\CampaignService;
use App\Http\Resources\CampaignResource;
use App\Http\Requests\StoreCampaignRequest;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Events\CampaignStatusUpdated;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService) {
        $this->campaignService = $campaignService;
    }

    public function index() {
        $campaigns = $this->campaignService->getAllCampaigns();
        return CampaignResource::collection($campaigns);
    }

    public function store(StoreCampaignRequest $request) {
        $campaign = $this->campaignService->createCampaign($request->validated());
        return new CampaignResource($campaign);
    }

    public function show($id) {
        $campaign = $this->campaignService->getCampaign($id);
        return new CampaignResource($campaign);
    }

    public function update($id, StoreCampaignRequest $request) {
        $campaign = $this->campaignService->editCampaign($id, $request->validated());
        return new CampaignResource($campaign);
    }

    public function destroy($id) {
        $this->campaignService->deleteCampaign($id);
        return response()->json(['message'=>'Campaign deleted successfully']);
    }

    public function statistics($id) {
        $campaign = $this->campaignService->getCampaign($id);
        return new CampaignResource($campaign);
    }

    public function updateStatus(Request $request, $id) {
        $campaign = Campaign::findOrFail($id);
        $request->validate(['status' => 'required|in:draft,active,paused,completed']);
        $campaign->update(['status' => $request->status]);

        event(new CampaignStatusUpdated($campaign));

        return redirect()->back();
    }

    public function deleteCampaign($id) {
        $this->campaignService->deleteCampaign($id);

        return redirect()->back()->with('success', 'Campaign deleted successfully.');
    }

    public function restore($id) {
        $this->campaignService->restoreCampaign($id);
        return response()->json(['message'=>'Campaign restored successfully']);
    }

}
