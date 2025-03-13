@extends('layouts.layout')

@section('title', 'Chi Tiết Sân')

@section('content')
<div class="container">
    <div class="card">
        <img src="{{ asset('images/field_default.jpg') }}" class="card-img-top" alt="Sân bóng">
        <div class="card-body">
            <h2 class="card-title">{{ $field->name }}</h2>
            <p><strong>Địa chỉ:</strong> {{ $field->location }}, {{ $field->ward }}, {{ $field->district }}, {{ $field->city }}</p>
            <p><strong>Loại sân:</strong> {{ $field->field_types }}</p>
            <a href="{{ route('fields.index') }}" class="btn btn-primary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
