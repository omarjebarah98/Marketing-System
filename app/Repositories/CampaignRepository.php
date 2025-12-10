<?php

namespace App\Repositories;

use App\Models\Campaign;
use App\Repositories\Interfaces\CampaignRepositoryInterface;

class CampaignRepository implements CampaignRepositoryInterface {

    protected $model;

    public function __construct(Campaign $campaign) {
        $this->model = $campaign;
    }

    public function getAllCampaigns() {
        return $this->model->with('template')->get();
    }
    public function getCampaignsById(int $id) {
       return $this->model->with(['template', 'sends'])->findOrFail($id);
    }
    public function create(array $data) {
        return $this->model->create($data);
    }
    public function update(int $id, array $data) {
        $campaign = $this->getCampaignsById($id);
        $campaign->update($data);
        return $campaign;
    }
    public function delete(int $id) {
        $campaign = $this->getCampaignsById($id);
        return $campaign->delete();
    }
    public function findTrashedById($id) {
        $deletedCampaign = $this->model->onlyTrashed()->find($id);
        return $deletedCampaign;
    }
    public function restore(int $id) {
        $campaign = $this->model->onlyTrashed()->find($id);
        return $campaign->restore();
    }
}
