<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">検索画面</h2>

        @if(isset($message))
            <hr>
            <div class="search-hotel-name">
                {{ $message }}
            </div>
        @endif

        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelSearchResult') }}" method="post">
                @csrf
                <label for="hotel_name">ホテル名</label><br>
                <input type="text" name="hotel_name" id="hotel_name" value="{{ $hotelName ?? "" }}" placeholder="ホテル名">
                @if(isset($errorMessage))
                    <br>
                    <small style="color: red">{{ $errorMessage }}</small>
                @endif
                <br>
                <label for="prefecture_id">都道府県</label><br>
                <select name="prefecture_id" id="prefecture_id">
                    <option value="0">ALL</option>
                    @foreach($prefectures as $prefecture)
                        <option
                            value="{{ $prefecture->prefecture_id }}"
                            @if($prefecture->prefecture_id == $prefecture_id ?? null) selected @endif
                        >{{ $prefecture->prefecture_name }}</option>
                    @endforeach
                </select>
                <button type="submit">検索</button>
            </form>
        </div>
        <hr>
    </div>
    @yield('search_results')
@endsection
