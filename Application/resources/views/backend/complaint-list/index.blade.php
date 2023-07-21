@extends('backend.layouts.grid')
@section('title', $complaintType.__(' complaint Queries'))
@section('content')
	<div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-8 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Resolved') }}</h3>
                <p class="vironeer-counter-box-number">{{ @$totalResolved }}</p>
                <!-- <small>{{ __('Included inactive students') }}</small> -->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-9 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total In-Process') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalOnProcessing }}</p>
                <!--<small>{{ __('Included inactive marinas') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-11 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Pending') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalPending }}</p>
                <!--<small>{{ __('Included Pending Booking') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl">
            <div class="vironeer-counter-box bg-lg-7 h-100">
                <h3 class="vironeer-counter-box-title">{{ __('Total Rejected') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalRejected }}</p>
                <!--<small>{{ __('Included Pending Booking') }}</small>-->
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-users"></i>
                </span>
            </div>
        </div>
    </div>
	@if(count($complaintList) > 0)
        <div class="card">
			<table id="datatable-complaint" class="table w-100">
				<thead>
					<tr>
						<th class="tb-w-2x">{{ __('#') }}</th>
						<th class="tb-w-2x">{{ __('Student Name') }}</th>
						<th class="tb-w-2x">{{ __('Father Name') }}</th>
						<th class="tb-w-2x">{{ __('Mother Name') }}</th>
						<th class="tb-w-2x">{{ __('Class') }}</th>
						<th class="tb-w-2x">{{ __('Shift') }}</th>
						<th class="tb-w-2x">{{ __('Mobile') }}</th>
						<th class="tb-w-10x">{{ __('Complaint') }}</th>
						<th class="tb-w-10x">{{ __('Admin Comment') }}</th>
						<th class="tb-w-10x">{{ __('Created Date Time') }}</th>
						<th class="tb-w-2x">{{ __('Status') }}</th>
						{{--<th class="text-center">{{ __('Action') }}</th>--}}
					</tr>
				</thead>
				<tbody>
					@php
						$count=0;
					@endphp
					@foreach ($complaintList as $key => $complaint)
						@php
							$count++;
						@endphp
						<tr class="item">
							<td data-sort="{{ strtotime($complaint->created_at) }}"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adminCommentModal" onclick="getAdminComment({{$complaint->id}})">#{{ $complaint->id }}</a></td>
							<td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adminCommentModal" onclick="getAdminComment({{$complaint->id}})">{{ $complaint->student_name }}</a></td>
							<td>{{ $complaint->father_name }}</td>
							<td>{{ $complaint->mother_name }}</td>
							<td>{{ $complaint->student_class.' '.$complaint->student_section }}</td>
							<td>{{ $complaint->student_shift }}</td>
							<td>{{ $complaint->student_mobile }}</td>
							@if($complaint->student_complaint == 0)
								<td>{{ @$complaint->student_other_complaint }}</td>
							@else
								<td>{{ @$complaint->complaintType->title }}</td>
							@endif
							<td id="admin_comment{{$complaint->id}}"><?= $complaint->admin_comment; ?></td>
                            <td><?= vDate($complaint->created_at); ?></td>
							<td id="complaint-status{{ $complaint->id }}">
								<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adminCommentModal" onclick="getAdminComment({{$complaint->id}})">
									@if($complaint->status == 0)
										Pending
									@elseif($complaint->status == 1)
										In-Process
									@elseif($complaint->status == 2)
										Resolved
									@elseif($complaint->status == 3)
										Rejected
									@else
										--
									@endif
								</a>
							</td>
							{{--<td>
								<div class="text-end">
									<button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown"
										aria-expanded="true">
										<i class="fa fa-ellipsis-v fa-sm text-muted"></i>
									</button>
									<ul class="dropdown-menu dropdown-menu-sm-end" data-popper-placement="bottom-end">
									<li>
											<a class="dropdown-item" href="{{ route('admin.complaint.edit', $complaint->id) }}">
												<i class="fa fa-edit me-2"></i>{{ __('Edit') }}
											</a>
										</li>
										<li>
											<hr class="dropdown-divider" />
										</li>
										<li>
											<form action="{{ route('admin.complaint.complaintRemove', $complaint->id) }}" method="POST">
												@csrf @method('DELETE')
												<input type="hidden" value="{{$complaint->id}}" name="complaintType_id" >
												<button class="vironeer-able-to-delete dropdown-item text-danger">
													<i class="far fa-trash-alt me-2"></i>{{ __('Delete') }}
												</button>
											</form>
										</li>
									</ul>
								</div>
							</td>--}}
						</tr>
					@endforeach
				</tbody>
			</table>
        </div>
	@else
		@include('backend.includes.empty')
	@endif
	<div class="modal fade" id="adminCommentModal" tabindex="-1" aria-labelledby="mobileModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-top">
	        <div class="modal-content">
	            <form action="javascript:void(0)" method="POST" id="admin-comment-form">
	                <div class="modal-body">
	                    <div class="row form-group">
	                        <div class="col-md-12">
	                            <h5 class="form-label">{{ lang('Admin Comment', 'user') }}</h5>   
	                        </div><hr>
	                    </div>
	                    <div class="row form-group mb-3">
	                        <div class="col-md-12 mb-3">
	                            <label>Status<span class="text-danger">*</span></label>
	                            <select id="comment_status" name="comment_status" class="form-select form-control" onchange="setInProcessStatus(this.value)">
	                                <option value="">Select option</option>
	                                <option value="0">Pending</option>
	                                <option value="1">In-Process</option>
	                                <option value="2">Resolved</option>
	                                <option value="3">Rejected</option>
	                            </select>
	                            <span class="error_comment_status text-danger"></span>
	                        </div>
	                        <div class="col-md-12 mb-3" id="admin-comment">
	                            <label>Comment</label>
	                            <input type="hidden" name="complaint_id" id="complaint_id">
	                            <textarea class="form-control" name="admin_comment" maxlength="200" id="admin_comment" rows="3"></textarea>
	                        </div>
	                        <hr>
	                        <div class="col-md-12 mb-3">                            
	                            <div class="d-flex justify-content-between">
	                                <button type="button" class="btn btn-primary w-100 me-2" onclick="adminCommentSubmit()">{{ lang('Save', 'user') }}</button>
	                                <button type="button" class="btn btn-secondary w-100 ms-2" id="close_comment_modal" data-bs-dismiss="modal">{{ lang('Close') }}</button>
	                            </div>
	                        </div>                        
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
@endsection
