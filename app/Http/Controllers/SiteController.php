<?php

namespace App\Http\Controllers;

use App\Services\SiteServiceInterface;
use App\Utils\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function index()
    {   
        return Inertia::render('Home');
    }

    public function report()
    {   
        return Inertia::render('Report');
    }

    public function get(SiteServiceInterface $service)
    {
        try {
            $collection = $service->getList();
            
            return Response::success(
                data: $collection
            );
        } catch (\Throwable $th) {
            return Response::error(
                statusCode: $th->getCode(),
                message: $th->getMessage(),
            );
        }
    }

    public function delete(Request $request, string $id, SiteServiceInterface $service)
    {
        try {
            $service->delete($request, $id);

            return Response::success(
                message: 'success deleting data '. $id,
            );
        } catch (\Throwable $th) {
            return Response::error(
                statusCode: $th->getCode(),
                message: $th->getMessage(),
            );
        }
        
    }

    public function getDailyRecords(SiteServiceInterface $service)
    {
        try {
            $collection = $service->getDailyRecords();
            
            return Response::success(
                data: $collection
            );
        } catch (\Throwable $th) {
            return Response::error(
                statusCode: $th->getCode(),
                message: $th->getMessage(),
            );
        }
    }

}
