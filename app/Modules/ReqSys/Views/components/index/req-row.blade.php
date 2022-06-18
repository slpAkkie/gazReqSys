<a href="{{ route('req.show', $req->id) }}" class="table__row">
    <div class="col-2 table__cell req-table__cell_number-and-date">
        @if($req->status->slug === 'confirmed')
            <span class="fw-bold border-success border text-success rounded p-1">#{{ $req->id }} </span>
        @elseif($req->status->slug === 'denied')
            <span class="fw-bold border-danger border text-danger rounded p-1">#{{ $req->id }} </span>
        @else
            <span class="fw-bold border-black border rounded p-1">#{{ $req->id }} </span>
        @endif
         от <span>{{ $req->created_at }}</span>
    </div>
    <div class="col-3 table__cell">{{ $req->organization->title }}</div>
    <div class="col-2 table__cell">{{ $req->organization->city->title }}</div>
    <div class="col-2 table__cell">{{ $req->author_staff->getFullName() }}</div>
    <div class="col-3 table__cell">{{ $req->type->title }}</div>
</a>
