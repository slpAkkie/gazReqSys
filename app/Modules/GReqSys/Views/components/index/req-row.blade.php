<div class="row mx-0 req-table__row bg-light">
    <div class="col-2 req-table__cell req-table__cell_number-and-date"><span class="fw-bold">#{{ $data['id'] }} </span> от <span>{{ $data['created_at'] }}</span></div>
    <div class="col-3 req-table__cell">{{ $data['department'] }}</div>
    <div class="col-2 req-table__cell">{{ $data['city'] }}</div>
    <div class="col-2 req-table__cell">{{ $data['author'] }}</div>
    <div class="col-3 req-table__cell">{{ $data['type'] }}</div>
</div>
