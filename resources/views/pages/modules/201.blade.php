@extends('layout.app')

@section('content')
<style>
    .profile-hero { background: linear-gradient(135deg, #008080 0%, #005a5a 100%); border-radius: 1.5rem; color: white; border: none; }
    .profile-img-container { width: 150px; height: 150px; border: 5px solid rgba(255, 255, 255, 0.2); object-fit: cover; }
    .nav-resume { border: none; gap: 8px; }
    .nav-resume .nav-link { border: none; color: #6c757d; font-weight: 600; padding: 10px 20px; border-radius: 50px; }
    .nav-resume .nav-link.active { background-color: #008080 !important; color: white !important; }
    .info-label { font-size: 0.72rem; font-weight: 800; color: #008080; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 0.95rem; color: #2d3748; font-weight: 500; }
    .resume-card { border: none; border-radius: 1.25rem; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05); }
    .text-teal { color: #008080 !important; }
</style>

<div class="container-fluid px-4 py-3">

    {{-- Hero Section --}}
    <div class="card profile-hero shadow-sm mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-2 text-center mb-3 mb-lg-0">
                    <img src="{{ $emp->path ?? URL::asset('/img/undraw_profile.svg') }}" 
                         alt="profile" class="rounded-circle profile-img-container shadow-lg">
                </div>
                <div class="col-lg-7 text-center text-lg-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-2">
                        <h1 class="fw-bold mb-0 me-3">
                            {{ $emp->firstname ?? 'Select' }} {{ $emp->middlename ?? '' }} {{ $emp->lastname ?? 'Employee' }} {{ $emp->suffix ?? '' }}
                        </h1>
                        @if(isset($emp->status))
                        <span class="badge {{ $emp->status == 1 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                            {{ $emp->status == 1 ? 'ACTIVE' : 'RESIGNED' }}
                        </span>
                        @endif
                    </div>
                    <p class="fs-5 opacity-75 mb-3">{{ $emp->pos_desc ?? 'Position' }} <span class="mx-2">|</span> {{ $emp->dep_name ?? 'Department' }}</p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-2">
                        <span class="badge bg-white bg-opacity-20 rounded-pill px-3 py-2"><i class="fa-solid fa-id-card me-1 text-info"></i> {{ $emp->employee_number ?? '---' }}</span>
                        <span class="badge bg-white bg-opacity-20 rounded-pill px-3 py-2"><i class="fa-solid fa-envelope me-1 text-info"></i> {{ $emp->email ?? '---' }}</span>
                    </div>
                </div>
                <div class="col-lg-3 text-center text-lg-end">
                    <div class="btn-group shadow-sm">
                        <button class="btn btn-white text-primary" title="Print Resume"><i class="fa-solid fa-file-pdf"></i></button>
                        <button class="btn btn-white text-info" title="Edit Record"><i class="fa-solid fa-user-pen"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-resume mb-4" id="resumeTab" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal">Personal Info</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#education">Education</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#employment">Employment</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#compliance">Compliance</button></li>
    </ul>

    <div class="tab-content">
        {{-- Personal Tab --}}
        <div class="tab-pane fade show active" id="personal" role="tabpanel">
            <div class="card resume-card p-4">
                <div class="row g-4">
                    <div class="col-md-12"><h6 class="fw-bold text-teal text-uppercase"><i class="fa-solid fa-user me-2"></i>General Details</h6><hr></div>
                    <div class="col-md-4">
                        <div class="info-label">Gender / Citizenship</div>
                        <div class="info-value">
                            {{ isset($emp->gender) ? ($emp->gender == 1 ? 'Male' : 'Female') : '---' }} / {{ $emp->citizenship ?? '---' }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Birth Date</div>
                        <div class="info-value">{{ isset($emp->birthdate) ? date('M d, Y', strtotime($emp->birthdate)) : '---' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Contact Numbers</div>
                        <div class="info-value">{{ $emp->mobile ?? '---' }} {{ isset($emp->homephone) ? '/ '.$emp->homephone : '' }}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-label">Mailing Address</div>
                        <div class="info-value">
                            {{ $emp->street ?? '---' }}, Brgy. {{ $emp->barangay ?? '---' }}, {{ $emp->city ?? '---' }}, {{ $emp->province ?? '---' }}, {{ $emp->zipcode ?? '' }}, {{ $emp->country ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Education Tab --}}
        <div class="tab-pane fade" id="education" role="tabpanel">
            <div class="card resume-card p-4">
                <div class="row g-4">
                    <div class="col-md-12 d-flex align-items-center">
                        <div class="bg-light p-3 rounded-circle me-3 text-primary"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div>
                            <div class="info-label">Tertiary Education</div>
                            <div class="info-value fw-bold">{{ $emp->tertiary_school ?? 'Not Specified' }}</div>
                            <div class="small text-muted">{{ $emp->tertiary_year_started ?? '' }} - {{ $emp->tertiary_year_graduated ?? '' }} | {{ $emp->tertiary_school_address ?? '' }}</div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex align-items-center border-top pt-4">
                        <div class="bg-light p-3 rounded-circle me-3 text-secondary"><i class="fa-solid fa-school"></i></div>
                        <div>
                            <div class="info-label">Secondary Education</div>
                            <div class="info-value fw-bold">{{ $emp->secondary_school ?? 'Not Specified' }}</div>
                            <div class="small text-muted">{{ $emp->secondary_year_started ?? '' }} - {{ $emp->secondary_year_graduated ?? '' }} | {{ $emp->secondary_school_address ?? '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Employment Tab --}}
        <div class="tab-pane fade" id="employment" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card resume-card p-4 bg-light">
                        <h6 class="fw-bold mb-3">Compensation</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="info-label">Basic Salary</span>
                            <span class="info-value">₱ {{ number_format($emp->basic ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="info-label">Allowance</span>
                            <span class="info-value">₱ {{ number_format($emp->allowance ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span class="info-label">Hourly Rate</span>
                            <span class="info-value">₱ {{ number_format($emp->hourly_rate ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card resume-card p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Company / Agency</div>
                                <div class="info-value">{{ $emp->comp_name ?? '---' }} / {{ $emp->ag_name ?? 'Direct' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Date Hired</div>
                                <div class="info-value text-primary fw-bold">{{ isset($emp->date_hired) ? date('M d, Y', strtotime($emp->date_hired)) : '---' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">Job Level / Classification</div>
                                <div class="info-value">{{ $emp->job_desc ?? '---' }} / {{ $emp->class_desc ?? '---' }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-label">HMO Provider / No.</div>
                                <div class="info-value">{{ $emp->hmoName ?? 'None' }} ({{ $emp->hmo_number ?? 'N/A' }})</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Compliance Tab --}}
        <div class="tab-pane fade" id="compliance" role="tabpanel">
            <div class="card resume-card p-4">
                <div class="row g-4">
                    @php
                        $governmentFields = [
                            ['label' => 'SSS Number', 'val' => $emp->sss ?? null, 'icon' => 'fa-shield-halved'],
                            ['label' => 'PhilHealth', 'val' => $emp->philhealth ?? null, 'icon' => 'fa-kit-medical'],
                            ['label' => 'Pag-IBIG', 'val' => $emp->pagibig ?? null, 'icon' => 'fa-house-chimney-user'],
                            ['label' => 'TIN', 'val' => $emp->tin ?? null, 'icon' => 'fa-file-invoice'],
                            ['label' => 'UMID', 'val' => $emp->umid ?? null, 'icon' => 'fa-address-card'],
                            ['label' => 'Passport', 'val' => $emp->passport_no ?? null, 'icon' => 'fa-passport']
                        ];
                    @endphp
                    @foreach($governmentFields as $item)
                        <div class="col-md-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                <div class="fs-4 text-teal me-3"><i class="fa-solid {{ $item['icon'] }}"></i></div>
                                <div>
                                    <div class="info-label">{{ $item['label'] }}</div>
                                    <div class="info-value fw-bold">{{ $item['val'] ?? 'Not Provided' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection