<?php

namespace App\Http\Controllers;

use App\Models\ChildPersonalInformation;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $output = "";

        $data = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
            ->where('child_personal_information.lastname', 'Like', '%' . $request->search . '%')
                             ->orWhere('child_personal_information.middlename', 'like', '%' . $request->search . '%')
                             ->orWhere('child_personal_information.firstname', 'like', '%' .$request->search . '%')
            ->get();

        foreach ($data as $data) {
            $output .= '
                <tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">' . $data->lastname . '</h6>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-sm">' . $data->firstname . '</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $data->middlename . '</h6>
                    </td>
                    <td class="align-middle">
                        <a href="javascript:;" class="badge badge-sm bg-gradient-secondary"
                          onclick="showDetailsModal(' . htmlspecialchars(json_encode(['personalInfo' => $data, 'healthRecords' => $data])) . ')">
                            View
                        </a>
                    </td>
                    <td class="align-middle">
                        <a href="javascript:;" class="badge badge-sm bg-gradient-secondary"
                          onclick="newHealthRecordDetailModal(' . htmlspecialchars(json_encode(['personalInfo' => $data, 'healthRecords' => $data])) . ')">
                            New Record
                        </a>
                    </td>
                </tr>';
        }

    
        return response($output);
    }
}
