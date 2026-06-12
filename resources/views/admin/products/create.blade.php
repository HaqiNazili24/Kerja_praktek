@extends('layouts.admin')
@section('page-title','Produk Baru')
@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">@csrf
    @include('admin.products._form')
</form>
@endsection
