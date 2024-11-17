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
        <h2 class="title">確認: ホテルを編集する</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelConfirmEditProcess') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    ホテル名: {{ $data['hotel_name'] }}
                </div>
                <br>
                <div>
                    ホテル名: {{ $prefecture->prefecture_name }}
                </div>
                <br>
                @if(isset($data['file_path']))
                    <div>
                        ホテルイメージ:
                        <br>
                        <img src="{{ url($data['file_path']) }}" alt="ホテルイメージ" style="max-height: 400px">
                    </div>
                    <br>
                @endif
                <button type="submit">検索</button>
            </form>
        </div>
        <hr>
    </div>
@endSection
