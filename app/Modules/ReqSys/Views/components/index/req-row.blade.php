<a href="{{ route('req.show', $req->id) }}" class="table__row">
    <div class="col-2 table__cell req-table__cell_number-and-date">
        <span class="fw-bold">#{{ $req->id }} </span> от <span>{{ $req->created_at }}</span>
    </div>
    <div class="col-3 table__cell">{{ $req->department->title }}</div>
    <div class="col-2 table__cell">{{ $req->department->city->title }}</div>
    <div class="col-2 table__cell">{{ $req->author_staff->getFullName() }}</div>
    <div class="col-3 table__cell">{{ $req->type->title }}</div>
</a>
