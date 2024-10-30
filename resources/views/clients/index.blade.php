@extends('clients.layouts')


@section('content')
<x-app-layout>
<div class="row justify-content-center mt-3">
    <div class="col-md-12">

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">Lista de clientes</div>
            <div class="card-body">
                <a href="{{ route('clients.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Agregar nuevo cliente</a>
                <form action="{{route('clients.buscarClientes') }}" method="get">
                    @csrf
                    <input type="search" name="nombreCliente" id="nombreCliente" >

                    <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
                </form>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Nro</th>
                        <th scope="col">NOMBRE DEL CLIENTE</th>
                        <th scope="col">DIRECCION</th>
                        <th scope="col">CUIT</th>
                        <th scope="col">TELEFONO</th>
                        <th scope="col">ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $client->username }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->cuit }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>
                                <form action="{{ route('clients.destroy', $client->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   

                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Estas seguro de que quieres eliminar este cliente?');"><i class="bi bi-trash"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="7">
                                <span class="text-danger">
                                    <strong>Ningun cliente encontrado!</strong>
                                </span>
                            </td>
                        @endforelse
                    </tbody>
                  </table>

                   {{ $clients->links() }} 

            </div>
        </div>
    </div>    
</div>
</x-app-layout>    
@endsection