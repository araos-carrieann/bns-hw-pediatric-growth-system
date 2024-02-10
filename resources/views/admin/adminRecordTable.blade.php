@if(isset($filteredData))
@foreach($filteredData as $item)
<tr>
    <td>
        <div class="d-flex px-2 py-1">
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">{{ $item->lastname }}</h6>
            </div>
        </div>
    </td>
    <td>
        <h6 class="mb-0 text-sm">{{ $item->firstname }}</h6>
    </td>
    <td class="align-middle text-center text-sm">
        <h6 class="mb-0 text-sm">{{ $item->middlename }}</h6>
    </td>
    <td class="align-middle">
        <a href="javascript:;" class="badge badge-sm bg-gradient-secondary"
            onclick="showDetailsModal({{ json_encode(['personalInfo' => $item, 'healthRecords' => $item]) }})">
            View
        </a>
    </td>
</tr>
@endforeach
@else
@foreach($data as $item)
<tr>
    <td>
        <div class="d-flex px-2 py-1">
            <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm">{{ $item->lastname }}</h6>
            </div>
        </div>
    </td>
    <td>
        <h6 class="mb-0 text-sm">{{ $item->firstname }}</h6>
    </td>
    <td class="align-middle text-center text-sm">
        <h6 class="mb-0 text-sm">{{ $item->middlename }}</h6>
    </td>
    <td class="align-middle">
        <a href="javascript:;" class="badge badge-sm bg-gradient-secondary"
            onclick="showDetailsModal({{ json_encode(['personalInfo' => $item, 'healthRecords' => $item]) }})">
            View
        </a>
    </td>
</tr>
@endforeach
@endif
