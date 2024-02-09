@foreach($companies as $list)
    <tr>
        <td>{{ $list->name }}</td>
        <td>{{ $list->email }}</td>
        <td>{{ $list->country_id }}</td>
        <td>{{ $list->company_code }}</td>
        <td>{{ $list->commercial_record_no }}</td>
        <td><img src="{{ asset('images/companies/'.$list->logo) }}" height="50px" width="55px"></td>
        <td class="px-5">
            <div class="btn-group" role="group">
                <a href="#" data-bs-toggle="modal" data-lists="{{ $list }}"  data-bs-target="#EditvehcModal" class="btn btn-secondary px-3 py-1 edit-company-btn">Edit</a>
                <a href="#" class="btn btn-danger px-3 py-1 delete-api-btn" id="{{ $list->id }}">Delete</a>
            </div>
        </td>
    </tr>
@endforeach

