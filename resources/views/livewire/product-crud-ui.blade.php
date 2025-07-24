<div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-10">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        {{ $isEditMode ? 'Edit Product' : ($showingProduct ? 'View Product' : 'Add New Product') }}
                    </div>
                    <div>
                        @if (!$showForm && !$showingProduct)
                            <button wire:click="create" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> New Product
                            </button>
                        @else
                            <button wire:click="resetForm" class="btn btn-secondary btn-sm">Back</button>
                        @endif
                    </div>
                </div>

                @if ($showForm || $showingProduct)
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end text-start">Code</label>
                            <div class="col-md-6">
                                <input type="text"
                                       @if($showingProduct) value="{{ $showingProduct['code'] }}" disabled @else wire:model.defer="code" @endif
                                       class="form-control @error('code') is-invalid @enderror">
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text"
                                       @if($showingProduct) value="{{ $showingProduct['name'] }}" disabled @else wire:model.defer="name" @endif
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end text-start">Quantity</label>
                            <div class="col-md-6">
                                <input type="number"
                                       @if($showingProduct) value="{{ $showingProduct['quantity'] }}" disabled @else wire:model.defer="quantity" @endif
                                       class="form-control @error('quantity') is-invalid @enderror">
                                @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end text-start">Price</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01"
                                       @if($showingProduct) value="{{ $showingProduct['price'] }}" disabled @else wire:model.defer="price" @endif
                                       class="form-control @error('price') is-invalid @enderror">
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                @if ($showingProduct)
                                    <textarea class="form-control" disabled>{{ $showingProduct['description'] }}</textarea>
                                @else
                                    <textarea wire:model.defer="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-4 col-form-label text-md-end text-start">Product Image</label>
                            <div class="col-md-6">
                                @if ($showingProduct)
                                    @if($showingProduct['image'] && file_exists(public_path($showingProduct['image'])))
                                        <img src="{{ asset($showingProduct['image']) }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @elseif($showingProduct['image'])
                                        <p class="text-danger">Image not found at <code>{{ $showingProduct['image'] }}</code></p>
                                    @else
                                        <p class="text-muted">No image uploaded</p>
                                    @endif
                                @else
                                    <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror">
                                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror

                                    @if ($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @elseif ($oldImage)
                                        <img src="{{ asset($oldImage) }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                                    @endif
                                @endif
                            </div>
                        </div>

                        @if (!$showingProduct)
                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditMode ? 'Update Product' : 'Add Product' }}
                                </button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header">Product List</div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <button wire:click="show({{ $product->id }})" class="btn btn-warning btn-sm">
                                            <i class="bi bi-eye"></i> Show
                                        </button>
                                        <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <button wire:click="delete({{ $product->id }})" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this product?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"><span class="text-danger"><strong>No Product Found!</strong></span></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
