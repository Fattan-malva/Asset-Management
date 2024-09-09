<!-- resources/views/auth/detailQR.blade.php -->
@extends('layouts.plain')

@section('content')
<div style="margin-top: 50px; display: flex; justify-content: center; padding: 10px;">
    <div style="width: 100%; max-width: 600px; border: 1px solid #ddd; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <div style="display: flex; align-items: center; padding: 20px;">
            @php
                // Determine the image file based on the jenis_aset
                $iconMap = [
                    'PC' => 'pc.png',
                    'Tablet' => 'tablet.png',
                    'Laptop' => 'laptop.png',
                    // Add more mappings as needed
                ];
                $iconFile = isset($iconMap[$inventory->asets]) ? $iconMap[$inventory->asets] : 'default.png'; // Fallback to default icon
            @endphp
            <div style="margin-right: 20px;">
                <img src="{{ asset('assets/img/' . $iconFile) }}" alt="Asset Icon"
                    style="width: 80px; height: 80px;">
            </div>
            <div style="flex: 1; margin-left: 20px;">
                <h4 style="margin-bottom: 10px;"><strong>{{ $inventory->asets }}</strong></h4>
                <p style="margin: 0; margin-bottom:20px;">
                    <strong>Asset Tag:</strong> {{ $inventory->tagging }}<br>
                    <strong>Jenis Aset:</strong> {{ $inventory->asets }}<br>
                    <strong>Merk:</strong> {{ $inventory->merk_name }}<br>
                    <strong>Serial Number:</strong> {{ $inventory->seri }}<br>
                    <strong>Type:</strong> {{ $inventory->type }}<br>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Inline responsive media query -->
<style>
    @media (max-width: 768px) {
        div[style*="display: flex"] {
            flex-direction: column;
            align-items: center;
        }

        div[style*="display: flex"] > div:first-child {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }
</style>
@endsection
