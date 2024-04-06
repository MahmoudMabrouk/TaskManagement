<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{ $id }}">
    Delete
</button>

<!-- Modal -->
<div class="modal fade" id="delete-{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="{{ route($route, $id) }}" method="POST">
        <div class="modal-body">
            <h3>Are you sure?</h3>
        </div>
        <div class="modal-footer">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-danger">Confirm</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>

    </div>
</div>
</div>
