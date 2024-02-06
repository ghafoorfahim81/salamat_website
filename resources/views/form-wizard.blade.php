@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--wrapper-->
    <div class="wrapper" id="test">
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Forms</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Request for Purchase Wizard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row">
                    <div class="col-xl-12 mx-auto">

                        <div class="card-body">
                            <br/>
                            <!-- SmartWizard html -->
                            <div id="smartwizard">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-1"> <strong>Step 1</strong>
                                            <br>Welcome </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-2"> <strong>Step 2</strong>
                                            <br>RFP Details </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-3"> <strong>Step 3</strong>
                                            <br>Required Items List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-4"> <strong>Step 4</strong>
                                            <br>General Questioners </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-5"> <strong>Step 5</strong>
                                            <br>Items Questioners </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-6"> <strong>Step 6</strong>
                                            <br>Construction Questioner </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-7"> <strong>Step 7</strong>
                                            <br>Consultancy Questioner </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-8"> <strong>Step 8</strong>
                                            <br>Summery </a>
                                    </li>
                                </ul>
                                <!-- data to show -->
                                <div class="tab-content">
                                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                                        <h3 class="tab-mrg">General Guidelines for Submitting RFP</h3>
                                        <ul>
                                            <li>The wizard provides step-by-step process for creating RFP</li>
                                            <li>Provide up-to-date information.</li>
                                            <li>Fields labeled with * are considered as required and must be filled.
                                            </li>
                                            <li> You are required to provide initial RFP details, list of items, general
                                                questions filling, and associated questions filling and final review and
                                                summery before submission of the RFP.
                                            </li>
                                            <li> Each field is supported with screen tip which provides additional
                                                information on the required data.
                                            </li>
                                            <li>nformation entered can be modified later at the end of the summery
                                                phase.
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                        <form class="row g-3 needs-validation" novalidate>
                                            <h3 class="tab-mrg">Request for Procurement Initial Information</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">RFP
                                                            Number: *</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control mb-3" type="text"
                                                                   placeholder="RFP-ICT-1401-1"
                                                                   aria-label="Disabled input example" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Date
                                                            of Issue: *</label>
                                                        <div class="col-md-8">
                                                            <input class="result form-control" type="date"
                                                                   id="date-time" placeholder="Pick the Date..."
                                                                   data-dtp="dtp_AnnAw">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Directorate:
                                                            *</label>
                                                        <div class="col-md-8">
                                                            <select class="form-select"
                                                                    aria-label="Disabled select example" disabled="">
                                                                <option selected="">ICT Directorate</option>
                                                                <option value="1">One</option>
                                                                <option value="2">Two</option>
                                                                <option value="3">Three</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Procurement
                                                            Title:*</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Budget
                                                            Code: </label>
                                                        <div class="col-md-8">
                                                            <select class="form-select" required=""
                                                                    aria-label="select example">
                                                                <option value=""></option>
                                                                <option value="1">12</option>
                                                                <option value="2">13</option>
                                                                <option value="3">14</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback">Fild the required field</div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Procurement
                                                            Code:</label>
                                                        <div class="col-md-8">
                                                            <select class="form-select" required=""
                                                                    aria-label="select example">
                                                                <option value=""></option>
                                                                <option value="1">10029</option>
                                                                <option value="2">10030</option>
                                                                <option value="3">10031</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback">Please fild the required field
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Procurement
                                                            Type: *</label>
                                                        <div class="col-md-8">
                                                            <select class="form-select" required=""
                                                                    aria-label="select example" required>
                                                                <option value=""></option>
                                                                <option value="1">Non-Consultancy Services</option>
                                                                <option value="2">Consultancy Services</option>
                                                                <option value="3">Construction</option>
                                                                <option value="4">Items</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback">Please fild the required field
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-4 col-form-label">Recommended
                                                            Procurement Model: *</label>
                                                        <div class="col-md-8">
                                                            <select class="form-select" required=""
                                                                    aria-label="select example" required>
                                                                <option value=""></option>
                                                                <option value="1">Quotation</option>
                                                                <option value="2">Single Source</option>
                                                                <option value="3">Closed Bid</option>
                                                                <option value="3">Open Bid</option>
                                                            </select>
                                                        </div>
                                                        <div class="invalid-feedback">Please fild the required field
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                        <form class="row g-3 needs-validation" novalidate>
                                            <h3 class="tab-mrg">Required Items List</h3>
                                            <div class="card-body">
                                                <p>* For additional particulars contact administrator.</p>
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="table-light">
                                                        <tr>
                                                            <th>Items</th>
                                                            <th>Items Description</th>
                                                            <th>Unit of Measure</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price (AFN)</th>
                                                            <th>Total Price (AFN)</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-2">
                                                                        <select class="form-select mb-3 single-select select2-hidden-accessible"
                                                                                data-select2-id="1" tabindex="-1"
                                                                                aria-hidden="true">
                                                                            <option selected="">Sales revenue</option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="1">Sales revenue
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="2">Sales revenue1
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="3">Services revenue
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="4">Services
                                                                                revenue1
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="5">Sales & Services
                                                                                return
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="6">Sales & Services
                                                                                return1
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="7">Sales & Services
                                                                                discounts
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="8">Sales & Services
                                                                                discounts1
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="9">Fees &
                                                                                Commission core
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="10">Fees &
                                                                                Commission core 1
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="11">Other revenue
                                                                            </option>
                                                                            <option value="ICT Directorate"
                                                                                    data-select2-id="12">Other revenue1
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input class="form-control mb-3" type="text"
                                                                       aria-label="default input example">
                                                            </td>
                                                            <td>
                                                                <select class="form-select mb-3"
                                                                        aria-label="Default select example">
                                                                    <option selected=""></option>
                                                                    <option value="1">er</option>
                                                                    <option value="2">sd</option>
                                                                    <option value="3">fg</option>
                                                                    <option value="1">vc</option>
                                                                    <option value="2">sd</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control mb-3" type="number"
                                                                       aria-label="default input example">
                                                            </td>
                                                            <td>
                                                                <input class="form-control mb-3" type="number"
                                                                       aria-label="default input example">
                                                            </td>
                                                            <td>
                                                                <div class="d-flex order-actions">
                                                                    <a href="javascript:;" class="mx-auto"><i
                                                                                class="lni lni-circle-plus"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="d-flex justify-content-around">
                                            <tbody>
                                            <tr>
                                                <hr/>
                                                <td>
                                                    Total Estimated Price
                                                </td>
                                                <td>
                                                    0
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                                        <form class="row g-3 needs-validation" novalidate>
                                            <h3 class="tab-mrg">Request for Procurement Initial Information</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            items handover location or services or construction
                                                            implementation location: *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Elaborate
                                                            your reason in case of not utilizing open bid procurement
                                                            process: *</label>
                                                        <div class="col-md-2">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Document Attached</option>
                                                                <option selected="">Not Available</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                            of Pages:*</label>
                                                        <div class="col-md-2">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Provide
                                                            evidence/documents on estimated quotations:*</label>
                                                        <div class="col-md-2">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Document Attached</option>
                                                                <option selected="">Not Available</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                            of Pages:*</label>
                                                        <div class="col-md-2">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">What
                                                            is the estimated date for contract issuance: *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="date"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">What
                                                            is the overall contract duration after the contract
                                                            issuance? Specify in years: *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">What
                                                            laws and regulations are applied to the procurement process:
                                                            *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Provide
                                                            donors/third party approval in case if the procurement is
                                                            supported by donors/third party: *</label>
                                                        <div class="col-md-2">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Document Attached</option>
                                                                <option selected="">Not Available</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                            of Pages:*</label>
                                                        <div class="col-md-2">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Confirm
                                                            if all compulsory and relevant documents are attached:
                                                            *</label>
                                                        <div class="col-md-2">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Yes</option>
                                                                <option selected="">No</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                            of Pages:*</label>
                                                        <div class="col-md-2">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Elaborate
                                                            if any additional requirements of business constraints you
                                                            would like to be apart of bid document: *</label>
                                                        <div class="col-md-2">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Document Attached</option>
                                                                <option selected="">Not Available</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                            of Pages:*</label>
                                                        <div class="col-md-2">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Provide
                                                            representative full name for the procurement process:
                                                            *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Provide
                                                            representative designation for the procurement process:
                                                            *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col End -->
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Provide
                                                            representative contact # for the procurement process:
                                                            *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Provide
                                                            representative email address for the procurement process:
                                                            *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                        </form>
                                    </div>
                                    <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
                                        <form class="row g-3 needs-validation" novalidate>
                                            <h3 class="tab-mrg">Information Required for Items Procurement
                                                Processes</h3>
                                            <div class="row">
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            whether complete technical specifications are provided with
                                                            respect to article 16: *</label>
                                                        <div class="col-md-6">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Yes</option>
                                                                <option selected="">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            whether after sale warranty or services are required:
                                                            *</label>
                                                        <div class="col-md-2">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Yes</option>
                                                                <option selected="">No</option>
                                                            </select>
                                                        </div>
                                                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                            of Years: *</label>
                                                        <div class="col-md-2">
                                                            <input class="form-control mb-3" type="number"
                                                                   aria-label="Disabled input example" required
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            whether manufacturing authorization is required: *</label>
                                                        <div class="col-md-6">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Yes</option>
                                                                <option selected="">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            final destination of items: *</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control mb-3" type="text"
                                                                   aria-label="Disabled input example" required>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col Start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            INCOTERMS: *</label>
                                                        <div class="col-md-6">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">EXW (Ex Works)</option>
                                                                <option selected="">FCA (Free Carrier)</option>
                                                                <option selected="">CPT (Carriage Paid To)</option>
                                                                <option selected="">CIP (Carriage and Insurance Paid
                                                                    To)
                                                                </option>
                                                                <option selected="">DAP (Delivered at Place)</option>
                                                                <option selected="">DPU (Delivered at Place Unloaded)
                                                                </option>
                                                                <option selected="">DDP (Delivered Duty Paid)</option>
                                                                <option selected="">FAS (Free Alongside Ship)</option>
                                                                <option selected="">FOB (Free on Board)</option>
                                                                <option selected="">CFR (Cost and Freight)</option>
                                                                <option selected="">CIF (Cost, Insurance and Freight)
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            whether installation is required: *</label>
                                                        <div class="col-md-6">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Yes</option>
                                                                <option selected="">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                                <!-- col start -->
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                            whether physical location for the installation/project
                                                            implementation is required: *</label>
                                                        <div class="col-md-6">
                                                            <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                <option selected=""></option>
                                                                <option selected="">Yes</option>
                                                                <option selected="">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- col end -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
                                        <form>
                                            <h3 class="tab-mrg">Information Required for Construction Procurement
                                                Processes</h3>
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether complete bill of work is attached and available
                                                        (soft/hard form): *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether design/map is attached and available (soft/hard form):
                                                        *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether list of supplies is attached and available (soft/hard
                                                        form): *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether list of key employees are attached: *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether environmental study performed? If yes, provide
                                                        attachments: *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether social and legal study performed? If yes, provide
                                                        attachments: *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        duration of defects correction in year: *</label>
                                                    <div class="col-md-6">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                        </form>
                                    </div>
                                    <div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">
                                        <form>
                                            <h3 class="tab-mrg">Information Required for Consultancy Procurement
                                                Processes</h3>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether complete terms of reference is attached: *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        type of consultancy service: *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">LCS</option>
                                                            <option selected="">FBS</option>
                                                            <option selected="">QBS</option>
                                                            <option selected="">CQS</option>
                                                            <option selected="">QCBS</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                            <!-- col Start -->
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <label for="inputEnterYourName" class="col-sm-6 col-form-label">Specify
                                                        whether list of required technical members along with CV is
                                                        attached: *</label>
                                                    <div class="col-md-2">
                                                        <select class="form-select mb-3"
                                                                aria-label="Default select example">
                                                            <option selected=""></option>
                                                            <option selected="">Yes</option>
                                                            <option selected="">No</option>
                                                        </select>
                                                    </div>
                                                    <label for="inputEnterYourName" class="col-sm-2 col-form-label">Number
                                                        of Pages: *</label>
                                                    <div class="col-md-2">
                                                        <input class="form-control mb-3" type="number"
                                                               aria-label="Disabled input example" required disabled>
                                                    </div>
                                                </div>
                                                <!-- col end -->
                                            </div>
                                        </form>
                                    </div>
                                    <div id="step-8" class="tab-pane" role="tabpanel" aria-labelledby="step-8">
                                        <h3 class="tab-mrg">Review and Process</h3>
                                        <hr>
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                        Initial Information
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show"
                                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <form class="row g-3 needs-validation" novalidate>
                                                            <h3 class="tab-mrg">Request for Procurement Initial
                                                                Information</h3>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">RFP
                                                                            Number: *</label>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control mb-3" type="text"
                                                                                   placeholder="RFP-ICT-1401-1"
                                                                                   aria-label="Disabled input example"
                                                                                   disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Date of
                                                                            Issue: *</label>
                                                                        <div class="col-md-8 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">12-03-2022</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Directorate:
                                                                            *</label>
                                                                        <div class="col-md-8">
                                                                            <select class="form-select"
                                                                                    aria-label="Disabled select example"
                                                                                    disabled="">
                                                                                <option selected="">ICT Directorate
                                                                                </option>
                                                                                <option value="1">One</option>
                                                                                <option value="2">Two</option>
                                                                                <option value="3">Three</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Procurement
                                                                            Title:*</label>
                                                                        <div class="col-md-8 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">Procurement
                                                                                Title </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Budget
                                                                            Code: </label>
                                                                        <div class="col-md-8 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option value="">1234</option>
                                                                                <option value="1">12</option>
                                                                                <option value="2">13</option>
                                                                                <option value="3">14</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="invalid-feedback">Fild the required
                                                                            field
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Procurement
                                                                            Code:</label>
                                                                        <div class="col-md-8 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option value="">30222</option>
                                                                                <option value="1">10029</option>
                                                                                <option value="2">10030</option>
                                                                                <option value="3">10031</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="invalid-feedback">Please fild the
                                                                            required field
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Procurement
                                                                            Type: *</label>
                                                                        <div class="col-md-8 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option value="">Construction</option>
                                                                                <option value="1">Non-Consultancy
                                                                                    Services
                                                                                </option>
                                                                                <option value="2">Consultancy Services
                                                                                </option>
                                                                                <option value="3">Construction</option>
                                                                                <option value="4">Items</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="invalid-feedback">Please fild the
                                                                            required field
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-4 col-form-label">Recommended
                                                                            Procurement Model: *</label>
                                                                        <div class="col-md-8 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option value="">Quotation</option>
                                                                                <option value="1">Quotation</option>
                                                                                <option value="2">Single Source</option>
                                                                                <option value="3">Closed Bid</option>
                                                                                <option value="3">Open Bid</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="invalid-feedback">Please fild the
                                                                            required field
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Save Button -->
                                                            <div class="col" style="text-align: right;">
                                                                <button type="button"
                                                                        class="btn btn-primary px-5 rounded-0"> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                        Required Items List
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse"
                                                     aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <form class="row g-3 needs-validation" novalidate>
                                                            <h3 class="tab-mrg">Required Items List</h3>
                                                            <div class="card-body">
                                                                <p>* For additional particulars contact
                                                                    administrator.</p>
                                                                <div class="table-responsive">
                                                                    <table class="table mb-0">
                                                                        <thead class="table-light">
                                                                        <tr>
                                                                            <th>Items</th>
                                                                            <th>Items Description</th>
                                                                            <th>Unit of Measure</th>
                                                                            <th>Quantity</th>
                                                                            <th>Unit Price (AFN)</th>
                                                                            <th>Total Price (AFN)</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="ms-2 special-edit">
                                                                                        <select class="formedit form-select mb-3 single-select select2-hidden-accessible"
                                                                                                data-select2-id="1"
                                                                                                tabindex="-1"
                                                                                                aria-hidden="true">
                                                                                            <option selected="">Sales
                                                                                                revenue
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="1">
                                                                                                Sales revenue
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="2">
                                                                                                Sales revenue1
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="3">
                                                                                                Services revenue
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="4">
                                                                                                Services revenue1
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="5">
                                                                                                Sales & Services return
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="6">
                                                                                                Sales & Services return1
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="7">
                                                                                                Sales & Services
                                                                                                discounts
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="8">
                                                                                                Sales & Services
                                                                                                discounts1
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="9">
                                                                                                Fees & Commission core
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="10">
                                                                                                Fees & Commission core 1
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="11">
                                                                                                Other revenue
                                                                                            </option>
                                                                                            <option value="ICT Directorate"
                                                                                                    data-select2-id="12">
                                                                                                Other revenue1
                                                                                            </option>
                                                                                        </select>

                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td class="special-edit">
                                                                                <label class="formedit"
                                                                                       contentEditable="true">Item
                                                                                    descrip</label>

                                                                            </td>
                                                                            <td class="special-edit">
                                                                                <select class="formedit form-select"
                                                                                        required=""
                                                                                        aria-label="select example">
                                                                                    <option selected="">er</option>
                                                                                    <option value="1">er</option>
                                                                                    <option value="2">sd</option>
                                                                                    <option value="3">fg</option>
                                                                                    <option value="1">vc</option>
                                                                                    <option value="2">sd</option>
                                                                                </select>

                                                                            </td>
                                                                            <td class="special-edit">
                                                                                <label class="formedit"
                                                                                       contentEditable="true">232</label>

                                                                            </td>
                                                                            <td class="special-edit">
                                                                                <label class="formedit"
                                                                                       contentEditable="true">222</label>

                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex order-actions">
                                                                                    <a href="javascript:;"
                                                                                       class="mx-auto"><i
                                                                                                class="lni lni-circle-plus"></i></a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- Save Button -->
                                                            <div class="col" style="text-align: right;">
                                                                <button type="button"
                                                                        class="btn btn-primary px-5 rounded-0"> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <table class="d-flex justify-content-around">
                                                            <tbody>
                                                            <tr>
                                                                <hr/>
                                                                <td>
                                                                    Total Estimated Price
                                                                </td>
                                                                <td>
                                                                    0
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                        Request for Procurement Initial Information
                                                    </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse"
                                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <form class="row g-3 needs-validation" novalidate>
                                                            <h3 class="tab-mrg">Request for Procurement Initial
                                                                Information</h3>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            items handover location or services or
                                                                            construction implementation location:
                                                                            *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">Location
                                                                                name</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Elaborate
                                                                            your reason in case of not utilizing open
                                                                            bid procurement process: *</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                                <option selected="">Document Attached
                                                                                </option>
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-2 col-form-label">Number of
                                                                            Pages:*</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <input class="form-control mb-3"
                                                                                   type="number" placeholder="232"
                                                                                   aria-label="Disabled input example"
                                                                                   required="" disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Provide
                                                                            evidence/documents on estimated
                                                                            quotations:*</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                                <option selected="">Document Attached
                                                                                </option>
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-2 col-form-label">Number of
                                                                            Pages:*</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <input class="form-control mb-3"
                                                                                   type="number" placeholder="232"
                                                                                   aria-label="Disabled input example"
                                                                                   required="" disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">What is
                                                                            the estimated date for contract issuance:
                                                                            *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">12-08-2022</label>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">What is
                                                                            the overall contract duration after the
                                                                            contract issuance? Specify in years:
                                                                            *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">2311</label>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">What laws
                                                                            and regulations are applied to the
                                                                            procurement process: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">law
                                                                                porcess</label>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Provide
                                                                            donors/third party approval in case if the
                                                                            procurement is supported by donors/third
                                                                            party: *</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                                <option selected="">Document Attached
                                                                                </option>
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-2 col-form-label">Number of
                                                                            Pages:*</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <input class="form-control mb-3"
                                                                                   type="number" placeholder="232"
                                                                                   aria-label="Disabled input example"
                                                                                   required="" disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Confirm
                                                                            if all compulsory and relevant documents are
                                                                            attached: *</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">No</option>
                                                                                <option selected="">Yes</option>
                                                                                <option selected="">No</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-2 col-form-label">Number of
                                                                            Pages:*</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <input class="form-control mb-3"
                                                                                   type="number" placeholder="232"
                                                                                   aria-label="Disabled input example"
                                                                                   required="" disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Elaborate
                                                                            if any additional requirements of business
                                                                            constraints you would like to be apart of
                                                                            bid document: *</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                                <option selected="">Document Attached
                                                                                </option>
                                                                                <option selected="">Not Available
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-2 col-form-label">Number of
                                                                            Pages:*</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <input class="form-control mb-3"
                                                                                   type="number" placeholder="232"
                                                                                   aria-label="Disabled input example"
                                                                                   required="" disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Provide
                                                                            representative full name for the procurement
                                                                            process: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">Rahimullah
                                                                                Raihan</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Provide
                                                                            representative designation for the
                                                                            procurement process: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">designaiton</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- col End -->
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Provide
                                                                            representative contact # for the procurement
                                                                            process: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">23232222</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Provide
                                                                            representative email address for the
                                                                            procurement process: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">abc@gmail.com</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- Save Button -->
                                                            <div class="col" style="text-align: right;">
                                                                <button type="button"
                                                                        class="btn btn-primary px-5 rounded-0"> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tab 4 start -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                            aria-expanded="false" aria-controls="collapseFour">
                                                        Information Required for Items Procurement Processes
                                                    </button>
                                                </h2>
                                                <div id="collapseFour" class="accordion-collapse collapse"
                                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <form class="row g-3 needs-validation" novalidate>
                                                            <h3 class="tab-mrg">Information Required for Items
                                                                Procurement Processes</h3>
                                                            <div class="row">
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            whether complete technical specifications
                                                                            are provided with respect to article 16:
                                                                            *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">No</option>
                                                                                <option selected="">Yes</option>
                                                                                <option selected="">No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            whether after sale warranty or services are
                                                                            required: *</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">No</option>
                                                                                <option selected="">Yes</option>
                                                                                <option selected="">No</option>
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-2 col-form-label">Number of
                                                                            Years: *</label>
                                                                        <div class="col-md-2 special-edit">
                                                                            <input class="form-control mb-3"
                                                                                   type="number" placeholder="2Years"
                                                                                   aria-label="Disabled input example"
                                                                                   required="" disabled="">
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            whether manufacturing authorization is
                                                                            required: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">No</option>
                                                                                <option selected="">Yes</option>
                                                                                <option selected="">No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            final destination of items: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <label class="formedit"
                                                                                   contentEditable="true">Final
                                                                                desti</label>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col Start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            INCOTERMS: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected=""></option>
                                                                                <option selected="">EXW (Ex Works)
                                                                                </option>
                                                                                <option selected="">FCA (Free Carrier)
                                                                                </option>
                                                                                <option selected="">CPT (Carriage Paid
                                                                                    To)
                                                                                </option>
                                                                                <option selected="">CIP (Carriage and
                                                                                    Insurance Paid To)
                                                                                </option>
                                                                                <option selected="">DAP (Delivered at
                                                                                    Place)
                                                                                </option>
                                                                                <option selected="">DPU (Delivered at
                                                                                    Place Unloaded)
                                                                                </option>
                                                                                <option selected="">DDP (Delivered Duty
                                                                                    Paid)
                                                                                </option>
                                                                                <option selected="">FAS (Free Alongside
                                                                                    Ship)
                                                                                </option>
                                                                                <option selected="">FOB (Free on
                                                                                    Board)
                                                                                </option>
                                                                                <option selected="">CFR (Cost and
                                                                                    Freight)
                                                                                </option>
                                                                                <option selected="">CIF (Cost, Insurance
                                                                                    and Freight)
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            whether installation is required: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">No</option>
                                                                                <option selected="">Yes</option>
                                                                                <option selected="">No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                                <!-- col start -->
                                                                <div class="col-md-12">
                                                                    <div class="row mb-3">
                                                                        <label for="inputEnterYourName"
                                                                               class="col-sm-6 col-form-label">Specify
                                                                            whether physical location for the
                                                                            installation/project implementation is
                                                                            required: *</label>
                                                                        <div class="col-md-6 special-edit">
                                                                            <select class="formedit form-select"
                                                                                    required=""
                                                                                    aria-label="select example">
                                                                                <option selected="">No</option>
                                                                                <option selected="">Yes</option>
                                                                                <option selected="">No</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <!-- col end -->
                                                                </div>
                                                            </div>
                                                            <!-- Save Button -->
                                                            <div class="col" style="text-align: right;">
                                                                <button type="button"
                                                                        class="btn btn-primary px-5 rounded-0"> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tab 4 End -->
                                            <!-- Tab 5 start -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFive">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                        Information Required for Construction Procurement Processes
                                                    </button>
                                                </h2>
                                                <div id="collapseFive" class="accordion-collapse collapse"
                                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <form>
                                                            <h3 class="tab-mrg">Information Required for Construction
                                                                Procurement Processes</h3>
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether complete bill of work is attached and
                                                                        available (soft/hard form): *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether design/map is attached and available
                                                                        (soft/hard form): *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether list of supplies is attached and
                                                                        available (soft/hard form): *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether list of key employees are attached:
                                                                        *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether environmental study performed? If yes,
                                                                        provide attachments: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether social and legal study performed? If
                                                                        yes, provide attachments: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        duration of defects correction in year:
                                                                        *</label>
                                                                    <div class="col-md-6 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="2Years">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- Save Button -->
                                                            <div class="col" style="text-align: right;">
                                                                <button type="button"
                                                                        class="btn btn-primary px-5 rounded-0"> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tab 5 End -->
                                            <!-- Tab 6 start -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingSix">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                        Information Required for Consultancy Procurement Processes
                                                    </button>
                                                </h2>
                                                <div id="collapseSix" class="accordion-collapse collapse"
                                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <form>
                                                            <h3 class="tab-mrg">Information Required for Consultancy
                                                                Procurement Processes</h3>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether complete terms of reference is attached:
                                                                        *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify type
                                                                        of consultancy service: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">QBS</option>
                                                                            <option selected="">LCS</option>
                                                                            <option selected="">FBS</option>
                                                                            <option selected="">QBS</option>
                                                                            <option selected="">CQS</option>
                                                                            <option selected="">QCBS</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- col Start -->
                                                            <div class="col-md-12">
                                                                <div class="row mb-3">
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-6 col-form-label">Specify
                                                                        whether list of required technical members along
                                                                        with CV is attached: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <select class="formedit form-select" required=""
                                                                                aria-label="select example">
                                                                            <option selected="">No</option>
                                                                            <option selected="">Yes</option>
                                                                            <option selected="">No</option>
                                                                        </select>
                                                                    </div>
                                                                    <label for="inputEnterYourName"
                                                                           class="col-sm-2 col-form-label">Number of
                                                                        Pages: *</label>
                                                                    <div class="col-md-2 special-edit">
                                                                        <input class="form-control mb-3" type="number"
                                                                               placeholder="232"
                                                                               aria-label="Disabled input example"
                                                                               required="" disabled="">
                                                                    </div>
                                                                </div>
                                                                <!-- col end -->
                                                            </div>
                                                            <!-- Save Button -->
                                                            <div class="col" style="text-align: right;">
                                                                <button type="button"
                                                                        class="btn btn-primary px-5 rounded-0"> Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tab 6 End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <footer class="page-footer">
        <p class="mb-0">Copyright © MOF 2022. All right reserved.</p>
    </footer>
    </div>
    <!--end wrapper-->

    <script>
        // Toolbar extra buttons
        var btnFinish = $('<button></button>').text('Finish').addClass('btn btn-info').on('click', function () {
            alert('Finish Clicked');
        });
        var btnCancel = $('<button></button>').text('Cancel').addClass('btn btn-danger').on('click', function () {
            $('#smartwizard').smartWizard("reset");
        });
        // Step show event
        $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
            $("#prev-btn").removeClass('disabled');
            $("#next-btn").removeClass('disabled');
            if (stepPosition === 'first') {
                $("#prev-btn").addClass('disabled');
            } else if (stepPosition === 'last') {
                $("#next-btn").addClass('disabled');
            } else {
                $("#prev-btn").removeClass('disabled');
                $("#next-btn").removeClass('disabled');
            }
        });
        // Smart Wizard
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'arrows',
            transition: {
                animation: 'slide-horizontal', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            },
            toolbarSettings: {
                toolbarPosition: 'both', // both bottom
                toolbarExtraButtons: [btnFinish, btnCancel]
            }
        });
        // External Button Events
        $("#reset-btn").on("click", function () {
            // Reset wizard
            $('#smartwizard').smartWizard("reset");
            return true;
        });
        $("#prev-btn").on("click", function () {
            // Navigate previous
            $('#smartwizard').smartWizard("prev");
            return true;
        });
        $("#next-btn").on("click", function () {
            // Navigate next
            $('#smartwizard').smartWizard("next");
            return true;
        });
        // Demo Button Events
        $("#got_to_step").on("change", function () {
            // Go to step
            var step_index = $(this).val() - 1;
            $('#smartwizard').smartWizard("goToStep", step_index);
            return true;
        });
        $("#is_justified").on("click", function () {
            // Change Justify
            var options = {
                justified: $(this).prop("checked")
            };
            $('#smartwizard').smartWizard("setOptions", options);
            return true;
        });
        $("#animation").on("change", function () {
            // Change theme
            var options = {
                transition: {
                    animation: $(this).val()
                },
            };
            $('#smartwizard').smartWizard("setOptions", options);
            return true;
        });
        $("#theme_selector").on("change", function () {
            // Change theme
            var options = {
                theme: $(this).val()
            };
            $('#smartwizard').smartWizard("setOptions", options);
            re
    </script>
    </body>
    </html>
