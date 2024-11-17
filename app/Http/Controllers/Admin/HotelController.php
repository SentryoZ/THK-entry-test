<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Requests\HotelSearchRequest;
use App\Models\Prefecture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Hotel;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        $prefectures = Prefecture::all();
        return view('admin.hotel.search', [
            'prefectures' => $prefectures,
            'errorMessage' => Session::get('errorMessage')
        ]);
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit(Request $request): View
    {
        $id = $request->input('hotel_id');
        $hotel = Hotel::query()->findOrFail($id);
        $prefectures = Prefecture::all();
        return view('admin.hotel.edit', [
            'prefectures' => $prefectures,
            'hotel' => $hotel
        ]);
    }

    public function showCreate(): View
    {
        $prefectures = Prefecture::all();
        return view('admin.hotel.create', [
            'prefectures' => $prefectures
        ]);
    }

    /** post methods */

    public function searchResult(Request $request): View|RedirectResponse
    {
        $var = [];

        $prefectures = Prefecture::all();
        if (is_null($request->input('hotel_name'))) {
            return redirect()->route('adminHotelSearchPage')->with('errorMessage', '何も入力されていません');
        }
        $prefecture_id = $request->input('prefecture_id');
        $hotelNameToSearch = $request->input('hotel_name', '');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch, $prefecture_id);

        $var['hotelList'] = $hotelList;
        $var['prefectures'] = $prefectures;
        $var['prefecture_id'] = $prefecture_id;
        $var['hotelName'] = $hotelNameToSearch;

        return view('admin.hotel.result', $var);
    }

    public function confirmEdit()
    {
        $data = Session::get('temp_edit_data');

        if (is_null($data)) {
            return view('admin.hotel.search');
        }
        if (isset($data['file_path'])) {
            $newPath = Str::remove('/temp', $data['file_path']);
            Storage::disk('public_uploads')->move($data['file_path'], $newPath);
            $data['file_path'] = $newPath;
        }

        $hotel = Hotel::query()->find($data['id']);
        $hotel->update($data);

        return view('admin.hotel.search')->with('message', 'Edit hotel successfully');
    }

    public function edit(HotelRequest $request): View
    {
        $data = $request->validated();
        $data['id'] = $request->get('hotel_id');
        if (isset($data['hotel_image'])) {
            $image = $data['hotel_image'];
            unset($data['hotel_image']);

            $data['file_path'] = $this->handleImage($image);
        }

        Session::put('temp_edit_data', $data);

        $prefecture = Prefecture::query()->find($data['prefecture_id']);

        return view('admin.hotel.confirmEdit', [
            'prefecture' => $prefecture,
            'data' => $data
        ]);
    }

    public function create(HotelRequest $request): View
    {
        $data = $request->validated();

        if (isset($data['hotel_image'])) {
            $image = $data['hotel_image'];
            unset($data['hotel_image']);

            $data['file_path'] = $this->handleImage($image);
        }

        Session::put('temp_create_data', $data);

        $prefecture = Prefecture::query()->find($data['prefecture_id']);

        return view('admin.hotel.confirmCreate', [
            'data' => $data,
            'prefecture' => $prefecture
        ]);
    }

    public function confirm(): View
    {
        $data = Session::get('temp_create_data');

        if (is_null($data)) {
            return view('admin.hotel.search');
        }
        if (isset($data['file_path'])) {
            $newPath = Str::remove('/temp', $data['file_path']);
            Storage::disk('public_uploads')->move($data['file_path'], $newPath);
            $data['file_path'] = $newPath;
        }

        $hotel = new Hotel($data);
        $hotel->save();

        return view('admin.hotel.search')->with('message', 'Create hotel successfully');
    }

    public function delete(Request $request): View
    {
        $id = $request->input('hotel_id');
        Hotel::query()->findOrFail($id)->delete();
        return view('admin.hotel.search')->with('message', 'Delete hotel successfully');
    }

    private function handleImage(UploadedFile $image)
    {
        $imageExtension = $image->getClientOriginalExtension();
        $timestamp = now()->getTimestamp();
        $uuid = uuid_create();

        $path = "assets/img/hoteltype/temp/$uuid-$timestamp.$imageExtension";
        // Should dispatch a job to remove temp file here

        return $image->storeAs($path, [
            'disk' => 'public_uploads',
        ]);
    }
}
