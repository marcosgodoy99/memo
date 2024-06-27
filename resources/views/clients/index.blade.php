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

        <div class="card">
            <div class="card-header">Client List</div>
            <div class="card-body">
                <a href="{{ route('clients.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Client</a>
                <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Address</th>
                        <th scope="col">CUIT</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $client->username }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->cuit }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>
                                <form action="{{ route('clients.destroy', $client->users_id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('clients.show', $client->users_id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                    <a href="{{ route('clients.edit', $client->users_id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>   

                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this client?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="7">
                                <span class="text-danger">
                                    <strong>No Client Found!</strong>
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