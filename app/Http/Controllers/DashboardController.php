<?php

namespace App\Http\Controllers;
use App\Repositories\AdminDashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected AdminDashboardRepository $repo;

    public function __construct(AdminDashboardRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $stats = $this->repo->getDashboardStats();
        return view('dashboard', ['stats' => $stats]);
    }
}
