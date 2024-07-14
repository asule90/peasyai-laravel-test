<?php

namespace App\Http\Controllers;

use App\Services\SiteServiceInterface;
use App\Utils\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function index(SiteServiceInterface $service)
    {
        $collection = $service->getList();
        
        return Inertia::render('Home', [
            'data' => $collection
        ]);
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
}
