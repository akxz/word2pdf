@extends('converter::layouts.master')

@section('content')
    <div id="app">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-center">
                    <h1 class="h1-big my-5">Word2Pdf</h1>
                </div>
            </div>
            <converter-component></converter-component>
        </div>
    </div>
@endsection
