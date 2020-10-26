<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        $data = [
            'settings' => setting()->all()
        ];

        return view('settings.index', $data);
    }

    public function update(Request $request)
    {
        $requestData = $request->all();

        if ($request['logo'] && $request['logo'] != url('images/company_logo.png')) {
            $fileName = 'company_logo.png';
            $imageData = $request['logo'];

            Image::make($request['logo'])->save(public_path('images/') . $fileName);
            $requestData['logo'] = 'images/' . $fileName;
        }


        setting($requestData)->save();
        return response()->json('Settings Updated', 200);
    }
}
