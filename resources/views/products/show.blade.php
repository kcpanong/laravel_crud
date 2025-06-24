@extends('layouts.app')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-10">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Product Information
                </div>
                <div class="float-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <label class="col-md-4 col-form-label text-md-end text-start"><strong>Code:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $product->code }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $product->name }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-4 col-form-label text-md-end text-start"><strong>Quantity:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $product->quantity }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-4 col-form-label text-md-end text-start"><strong>Price:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $product->price }}
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $product->description }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        @if($product->image && file_exists(public_path($product->image)))
                            <img src="{{ asset($product->image) }}" alt="Product Image" class="img-thumbnail" style="max-width: 100%; height: auto; margin-left: -20px;">
                        @elseif($product->image)
                            <p class="text-danger">Image file not found at <code>{{ $product->image }}</code></p>
                        @else
                            <p class="text-muted">No image uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

@endsection
