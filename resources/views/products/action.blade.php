<div class="btn-group">
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i> Edit
    </a>
    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
        <i class="fa fa-eye"></i> View
    </a>
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
            <i class="fa fa-trash"></i> Delete
        </button>
    </form>
</div>