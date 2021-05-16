<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDeviceRequest;
use App\Http\Resources\DeviceResource;

class DeviceController extends Controller
{
    public function store(CreateDeviceRequest $request)
    {
        return DeviceResource::make($request->persist());
    }
}
