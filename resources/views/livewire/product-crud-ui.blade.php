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
                        {{ $isEditMode ? 'Edit Product' : 'Add New Product' }}
                    </div>
                    <div>
                        @if (!$showForm)
                            <button wire:click="create" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> New Product
                            </button>
                        @else
                            <button wire:click="resetForm" class="btn btn-secondary btn-sm">Cancel</button>
                        @endif
                    </div>
                </div>

                @if ($showForm)
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                        <div class="mb-3 row">
                            <label for="code" class="col-md-4 col-form-label text-md-end text-start">Code</label>
                            <div class="col-md-6">
                                <input type="text" wire:model.defer="code" class="form-control @error('code') is-invalid @enderror">
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" wire:model.defer="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="quantity" class="col-md-4 col-form-label text-md-end text-start">Quantity</label>
                            <div class="col-md-6">
                                <input type="number" wire:model.defer="quantity" class="form-control @error('quantity') is-invalid @enderror">
                                @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="price" class="col-md-4 col-form-label text-md-end text-start">Price</label>
                            <div class="col-md-6">
                                <input type="number" step="0.01" wire:model.defer="price" class="form-control @error('price') is-invalid @enderror">
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                                <textarea wire:model.defer="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="image" class="col-md-4 col-form-label text-md-end text-start">Product Image</label>
                            <div class="col-md-6">
                                <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image') <span class="text-danger">{{ $message }}</span> @enderror

                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                                @elseif ($oldImage)
                                    <img src="{{ asset($oldImage) }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $isEditMode ? 'Update Product' : 'Add Product' }}
                                </button>
                            </div>
                        </div>
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