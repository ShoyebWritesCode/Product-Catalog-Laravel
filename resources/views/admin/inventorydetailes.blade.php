@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
    <div class="container">
        <h1>Inventory Details for {{ $product->name }}</h1>

        <div class="card mb-4">
            <div class="card-header">
                Product Details
            </div>
            <div class="card-body">
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Price:</strong> {{ $product->price }}</p>
                <!-- Add more details as needed -->
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Inventory Details
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Color / Size</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Red</td>
                            <td>
                                <ul>
                                    <li>Small: {{ $product->inventory->quantitySR }}</li>
                                    <li>Medium: {{ $product->inventory->quantityMR }}</li>
                                    <li>Large: {{ $product->inventory->quantityLR }}</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Blue</td>
                            <td>
                                <ul>
                                    <li>Small: {{ $product->inventory->quantitySB }}</li>
                                    <li>Medium: {{ $product->inventory->quantityMB }}</li>
                                    <li>Large: {{ $product->inventory->quantityLB }}</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Green</td>
                            <td>
                                <ul>
                                    <li>Small: {{ $product->inventory->quantitySG }}</li>
                                    <li>Medium: {{ $product->inventory->quantityMG }}</li>
                                    <li>Large: {{ $product->inventory->quantityLG }}</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
