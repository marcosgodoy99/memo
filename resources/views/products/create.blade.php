@extends('products.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Agregar Nuevo Producto
                </div>
                <div class="float-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Atras</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="code" class="col-md-4 col-form-label text-md-end text-start">CODIGO</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}">
                            @if ($errors->has('code'))
                                <span class="text-danger">{{ $errors->first('code') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">NOMBRE</label>
                        <div class="col-md-6">
                          <input type="text" step="" class="form-control @error('name') is-invalid @enderror" pattern="[A-Za-z0-9\s]+" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="stock" class="col-md-4 col-form-label text-md-end text-start">STOCK</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}">
                            @if ($errors->has('stock'))
                                <span class="text-danger">{{ $errors->first('stock') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="price" class="col-md-4 col-form-label text-md-end text-start">PRECIO</label>
                        <div class="col-md-6">
                          <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">DESCRIPCION</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="categorias_id" class="col-md-4 col-form-label text-md-end text-start">SELECCIONE UNA CATEGORIA</label>
                        <div class="col-md-6">
                          <select class="form-control @error('categorias_id') is-invalid @enderror" id="categorias_id" name="categorias_id">
                              <option value=""> Seleccionar </option>
                              @foreach ($categorias as $categoria)
                                  <option value="{{ $categoria->id }}" {{ old('categorias_id') == $categoria->id ? 'selected' : '' }}>
                                      {{ $categoria->name }}
                                  </option>
                              @endforeach
                          </select>
                          @if ($errors->has('categorias_id'))
                              <span class="text-danger">{{ $errors->first('categorias_id') }}</span>
                          @endif
                        </div>
                    </div>
                    
                    
                    <div class="mb-3 row">
                        <label for="links" class="col-md-4 col-form-label text-md-end text-start">LINKS</label>
                        <div class="col-md-6">
                          <input type="url" class="form-control @error('links') is-invalid @enderror" id="links" name="links" value="{{ old('links') }}">
                            @if ($errors->has('links'))
                                <span class="text-danger">{{ $errors->first('links') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Product">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection