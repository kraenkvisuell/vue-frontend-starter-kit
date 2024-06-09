@extends('statamic::layout')
@section('title', __('Artikel-Import'))

@section('content')
    <div class="flex items-center justify-between">
        <h1>{{ __('Artikel-Import') }}</h1>
    </div>

    <div class="mt-3 card">
        <div class="grid gap-8">
            <div class="flex justify-end">
                <a
                    href="{{ cp_route('utilities.sku-import.download-template') }}"
                    class="underline text-sm"
                >
                    Excel-Vorlage downloaden
                </a>
            </div>

            <sku-import uploadroute="{{ cp_route('utilities.sku-import.upload-sku-file') }}"></sku-import>
        </div>
    </div>
@stop
