<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endSection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">ホテルを編集する</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelEditProcess', ['hotel_id' => $hotel->hotel_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="hotel_name">ホテル名</label><br>
                    <input type="text" name="hotel_name" id="hotel_name"
                           value="{{ old('hotel_name', $hotel->hotel_name) }}"
                           placeholder="ホテル名">
                    @error('hotel_name')
                    <br>
                    <small>{{ $message }}</small>
                    @enderror
                </div>
                <br>
                <div>
                    <label for="prefecture_id">都道府県</label><br>
                    <select name="prefecture_id" id="prefecture_id">
                        @foreach($prefectures as $prefecture)
                            <option
                                value="{{ $prefecture->prefecture_id }}"
                                @if($prefecture->prefecture_id == old('prefecture_id', $hotel->prefecture_id)) selected @endif
                            >{{ $prefecture->prefecture_name }}</option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                    <br>
                    <small>{{ $message }}</small>
                    @enderror
                </div>
                <br>
                <div>
                    <label for="hotel_image">ホテルイメージ</label><br>
                    <input type="file" name="hotel_image" id="hotel_image" value="" placeholder="ホテルイメージ">
                    @error('hotel_image')
                    <br>
                    <small>{{ $message }}</small>
                    @enderror
                    <br>
                    @if(is_null($hotel->file_path))
                        <img src="" alt="ホテルイメージ" style="max-height: 400px" hidden="">
                    @else
                        <img src="{{ url($hotel->file_path) }}" alt="ホテルイメージ" style="max-height: 400px">
                    @endif
                </div>
                <br>
                <button type="submit">検索</button>
            </form>
        </div>
        <hr>
    </div>
@endSection
