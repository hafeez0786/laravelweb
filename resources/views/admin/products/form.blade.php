@if(isset($product))
    {!! Form::model($product, ['route' => ['admin.products.update', $product], 'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'admin.products.store']) !!}
@endif

<div class="mb-3">
    {{ Form::label('name', 'Product Name', ['class' => 'form-label']) }}
    {{ Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required']) }}
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    {{ Form::label('description', 'Description', ['class' => 'form-label']) }}
    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {{ Form::label('price', 'Price', ['class' => 'form-label']) }}
            <div class="input-group">
                <span class="input-group-text">$</span>
                {{ Form::number('price', null, [
                    'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''),
                    'step' => '0.01',
                    'min' => '0',
                    'required'
                ]) }}
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {{ Form::label('stock', 'Stock', ['class' => 'form-label']) }}
            {{ Form::number('stock', null, [
                'class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''),
                'min' => '0',
                'required'
            ]) }}
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> {{ isset($product) ? 'Update' : 'Create' }} Product
    </button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Cancel
    </a>
</div>

{!! Form::close() !!}
