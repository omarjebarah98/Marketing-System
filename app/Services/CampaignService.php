<?php

namespace App\Services;

use App\Repositories\Interfaces\CampaignRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CampaignService {

    protected $campaignRepo;

    public function __construct(CampaignRepositoryInterface $campaignRepo)
    {
        $this->campaignRepo = $campaignRepo;
    }

    public function getAllCampaigns() {
        return $this->campaignRepo->getAllCampaigns();
    }

    public function getCampaign($id) {
        return $this->campaignRepo->getCampaignsById($id);
    }

    public function createCampaign(array $data) {
        return $this->campaignRepo->create($data);
    }

    public function editCampaign($id, array $data) {
        $campaign = $this->campaignRepo->getCampaignsById($id);
        if(!$campaign) {
            throw new ModelNotFoundException("Campaign not found");
        }
        return $this->campaignRepo->update($id, $data);
    }

    public function deleteCampaign($id) {
        $campaign = $this->campaignRepo->getCampaignsById($id);
        if(!$campaign) {
            throw new ModelNotFoundException("Campaign not found");
        }

        return $this->campaignRepo->delete($id);
    }
}
