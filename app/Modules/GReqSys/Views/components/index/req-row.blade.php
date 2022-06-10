<div class="row mx-0 req-table__row bg-light">
    <div class="col-2 req-table__cell req-table__cell_number-and-date">
        <span class="fw-bold">#{{ $req->id }} </span> от <span>{{ $req->created_at }}</span>
    </div>
    <div class="col-3 req-table__cell">{{ $req->department->title }}</div>
    <div class="col-2 req-table__cell">{{ $req->department->city->title }}</div>
    <div class="col-2 req-table__cell">{{ $req->stuff->getFullName() }}</div>
    <div class="col-3 req-table__cell">{{ $req->type->title }}</div>
</div>
