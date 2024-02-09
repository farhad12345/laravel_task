@foreach($orders as $order)
    <tr>
        <td>{{ $order->order_no }}</td>
        <td>{{ $order->company->name }}</td>

        <td>{{ $order->city_from }}</td>
        <td>{{ $order->city_to }}</td>
        <td>{{ $order->price }}</td>
        <td><img src="{{ asset('images/orders/'.$order->order_images) }}" height="50px" width="55px"></td>
        <td class="px-5">
            <div class="btn-group" role="group">
                <a href="#" data-bs-toggle="modal" data-orders="{{ $order }}"  data-bs-target="#EditvehcModal" class="btn btn-secondary px-3 py-1 edit-post-btn">Edit</a>
                <a href="#" class="btn btn-danger px-3 py-1 delete-api-btn" id="{{ $order->id }}">Delete</a>
            </div>
        </td>
    </tr>
@endforeach

