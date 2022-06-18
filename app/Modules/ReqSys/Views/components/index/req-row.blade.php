<a href="{{ route('req.show', $req->id) }}" class="table__row">
    <div class="col-2 table__cell req-table__cell_number-and-date">
        <span class="fw-bold rounded p-1
            @switch($req->status->slug)
                @case('waiting')
                    border border-black
                    @break
                @case('confirmed')
                    bg-success border border-success text-light
                    @break
                @case('resolved')
                    bg-primary border border-primary
                    @break
                @case('denied')
                    bg-danger border border-danger text-light
                    @break
            @endswitch
        ">#{{ $req->id }}</span> от <span>{{ $req->created_at }}</span>
    </div>
    <div class="col-3 table__cell">{{ $req->organization->title }}</div>
    <div class="col-2 table__cell">{{ $req->organization->city->title }}</div>
    <div class="col-2 table__cell">{{ $req->author_staff->getFullName() }}</div>
    <div class="col-3 table__cell">{{ $req->type->title }}</div>
</a>
