
@extends('products.layouts')

@section('content')
<x-app-layout>
    <style>

        

    </style>
<div class="row justify-content-center mt-3">
    <div class="col-md-12">

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">Lista de categorias</div>
            <div class="card-body">
                <a href="{{ route('categorias.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Agregar Nueva Categoria</a>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOMBRE CATEGORIA</th>

                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                        <tr>
                            
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $categoria->name }}</td>
                            <td>
                            
                            
                                <form action="{{ route('categorias.destroy', $categoria->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>

                                    
                                    
                                    {{-- <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> --}}
                                    
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Quieres eliminar esta categoria?');"><i class="bi bi-trash"></i></button>
                                    
                                    
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>Categoria No Encontrada!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                  </table>

                  {{-- {{ $categorias->links() }} --}}

            </div>
        </div>
    </div>    
</div>
</x-app-layout>
@endsection

