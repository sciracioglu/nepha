@extends('layouts.app')
@section('title')
<i class="fal fa-file-chart-line"></i> Raporlar
@endsection

@section('content')
    <rapor :cities="{{ $cities }}" :groups="{{ $groups }}" :medicines="{{ $medicines }}"></rapor>
@endsection
