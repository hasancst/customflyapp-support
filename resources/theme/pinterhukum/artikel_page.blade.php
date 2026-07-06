@extends('tema::layout')

@section('title', $artikel->judul)

@section('konten')
<div class="cms-page-content">
    {!! $artikel->isi !!}
</div>
@endsection
