<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;

class ProductCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $productId;
    public $code, $name, $quantity, $price, $description, $image, $oldImage;
    public $isEditMode = false;
    public $showForm = false;

    protected $rules = [
        'code' => 'required|unique:products,code',
        'name' => 'required',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        return view('livewire.product-crud-ui', [
            'products' => Product::latest()->paginate(4),
        ]);
    }

    public function resetForm()
    {
        $this->reset(['productId', 'code', 'name', 'quantity', 'price', 'description', 'image', 'oldImage']);
        $this->isEditMode = false;
        $this->showForm = false;
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('images', 'public');
        }

        Product::create([
            'code' => $this->code,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $imagePath ? 'storage/' . $imagePath : null,
        ]);

        session()->flash('message', 'Product added successfully.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->quantity = $product->quantity;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->oldImage = $product->image;

        $this->isEditMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $product = Product::findOrFail($this->productId);

        $rules = $this->rules;
        $rules['code'] = 'required|unique:products,code,' . $product->id;
        $this->validate($rules);

        if ($this->image) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $imagePath = $this->image->store('images', 'public');
            $product->image = 'storage/' . $imagePath;
        }

        $product->update([
            'code' => $this->code,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $product->image ?? $this->oldImage,
        ]);

        session()->flash('message', 'Product updated successfully.');
        $this->resetForm();
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();
        session()->flash('message', 'Product deleted.');
    }
}
