
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Food Items</h1>
                    <a class="text-right btn btn-primary" href="/food_items/create">Add Food Item</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Food Item</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($foodItems as $food_item)
                                <tr>
                                    <td>{{ $food_item->name }}</td>
                                    <td>{{ $food_item->price }}</td>
                                    <td>{{ $food_item->category }}</td>
                                    <td>
                                        <a href="/food_items/{{ $food_item->_id }}/edit" class="btn btn-warning">Edit</a>
                                        <form action="/food_items/{{ $food_item->_id }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

