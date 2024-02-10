<?php

namespace App\Http\Controllers;

use App\Models\ChildPersonalInformation;
use Illuminate\Http\Request;
use App\Models\HealthWorker;
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
                          onclick="showDetailsModal(' . htmlspecialchars(json_encode(['personalInfo' => $data])) . ')">
                            View
                        </a>
                    </td>
                    <td class="align-middle">
                        <a href="javascript:;" class="badge badge-sm bg-gradient-secondary"
                          onclick="newHealthRecordDetailModal(' . htmlspecialchars(json_encode(['personalInfo' => $data])) . ')">
                            New Record
                        </a>
                    </td>
                </tr>';
        }

    
        return response($output);
    }

    public function searchAdminAccount(Request $request)
    {
        $output = "";
    
        $data = HealthWorker::where('role', 'admin')
            ->where('status', 'active')
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->search . '%');
            })
            ->get();
    
        foreach ($data as $adminAccount) {
            $output .= '
                <tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <img src="' . asset($adminAccount->profile_picture) . '" width="50" height="50" class="img img-responsive">
                            </div>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-sm">' . $adminAccount->last_name . ' </h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $adminAccount->first_name . '</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $adminAccount->middle_name . '</h6>
                    </td>
                    <td class="align-middle">
                    <button class="btn btn-primary" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseExample'. $adminAccount->id .'"
                        aria-expanded="false"
                        aria-controls="collapseExample'.$adminAccount->id .'">
                        View
                    </button>
                </td>

                <td class="align-middle">
                    <button href="#" data-toggle="modal"
                        data-target="#editAdminAccountModal'. $adminAccount->id .'"
                        class="btn badge badge-sm bg-gradient-secondary edit-btn">
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                        Edit
                    </button>
                </td>
               
                <td class="align-middle">
                    <button onclick="deleteAdminAccount('.$adminAccount->id .')"
                        class="btn badge badge-sm bg-gradient-secondary">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </td>
                </tr>
                <tr>
                    <td colspan="7"> <!-- Use colspan to span all columns -->
                        <div class="collapse" id="collapseExample'.$adminAccount->id .'">
                            <div class="card card-body">
                                <!-- Your collapsible content here -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Municipality:</strong> '. $adminAccount->municipality .'
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Barangay:</strong>'. $adminAccount->barangay .'
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Sitio:</strong> '. $adminAccount->sitio .'
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Email:</strong> '. $adminAccount->email .'
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Contact Number:</strong> '. $adminAccount->contact_number .'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>';
        }
    
        return response($output);
    }


    public function searchBhwAccount(Request $request)
    {
        $output = "";
        $healthWorkerBrgy = session('UserBrgy');
    
        $data = HealthWorker::where('role', 'bhw-user')
            ->where('barangay', $healthWorkerBrgy)
            ->where('status', 'active')
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $request->search . '%');
            })
            ->get();
    
        foreach ($data as $bhwAccount) {
            $output .= '
                <tr>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <img src="' . asset($bhwAccount->profile_picture) . '" width="50" height="50" class="img img-responsive">
                            </div>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-sm">' . $bhwAccount->last_name . ' </h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $bhwAccount->first_name . '</h6>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <h6 class="mb-0 text-sm">' . $bhwAccount->middle_name . '</h6>
                    </td>
                    <td class="align-middle">
                    <button class="btn btn-primary" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseExample'. $bhwAccount->id .'"
                        aria-expanded="false"
                        aria-controls="collapseExample'.$bhwAccount->id .'">
                        View
                    </button>
                </td>

                <td class="align-middle">
                    <button href="#" data-toggle="modal"
                        data-target="#editBHWAccountModal'. $bhwAccount->id .'"
                        class="btn badge badge-sm bg-gradient-secondary edit-btn">
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                        Edit
                    </button>
                </td>
               
                <td class="align-middle">
                    <button onclick="deleteBHWAccount('.$bhwAccount->id .')"
                        class="btn badge badge-sm bg-gradient-secondary">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </td>
                </tr>
                <tr>
                    <td colspan="7"> <!-- Use colspan to span all columns -->
                        <div class="collapse" id="collapseExample'.$bhwAccount->id .'">
                            <div class="card card-body">
                                <!-- Your collapsible content here -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Municipality:</strong> '. $bhwAccount->municipality .'
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Barangay:</strong>'. $bhwAccount->barangay .'
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Sitio:</strong> '. $bhwAccount->sitio .'
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Email:</strong> '. $bhwAccount->email .'
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Contact Number:</strong> '. $bhwAccount->contact_number .'
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>';
        }
    
        return response($output);
    }
    
}
