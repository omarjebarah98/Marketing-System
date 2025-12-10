<?php

namespace App\Repositories\Interfaces;

interface CampaignRepositoryInterface
{
    public function getAllCampaigns();
    public function getCampaignsById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function findTrashedById($id);
    public function restore(int $id);
}
