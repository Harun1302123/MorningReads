@extends('public_home.front')
@section('body')
    <div class="login-details my-5 container">
        {{-- <div id="logo" class="d-flex justify-content-center mb-3">
            <img src="{{ asset('assets/images/logo-npo.jpg') }}" alt="Logo"> <br>
            <span>National Productivity Organization</span>
        </div> --}}
        <div id="form">
            <div id="title">
                <h2>SignUp</h2>
            </div>

            <label for="name">Name</label>
            <input type="text" id="name" placeholder="Enter Your Name">

            <label for="mobile">Mobile Number</label>
            <input type="number" id="mobile" placeholder="Enter your number">

            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter Your email">

            <fieldset>
                <legend>Identification Type</legend>
                <div class="radio-buttons">
                    <input type="radio" id="nid" name="document_type" value="NID">
                    <label for="nid">NID</label>
                    <input type="radio" id="tin" name="document_type" value="TIN">
                    <label for="tin">TIN</label>
                    <input type="radio" id="brc" name="document_type" value="BRC">
                    <label for="brc">BRC</label>

                    <input type="radio" id="passport" name="document_type" value="Passport">
                    <label for="passport">Passport</label>
                </div>
            </fieldset>

            <div id="nid_section" class="attachment-section">
                <label for="nid_number">NID Number</label>
                <input type="text" id="nid_number" placeholder="Enter your NID number">
                <label for="nid_attachment">Upload NID Copy</label>
                <input type="file" id="nid_attachment" accept="application/pdf">
            </div>

            <div id="tin_section" class="attachment-section">
                <label for="tin_number">TIN Number</label>
                <input type="text" id="tin_number" placeholder="Enter your TIN number">
                <label for="tin_attachment">Upload TIN Copy</label>
                <input type="file" id="tin_attachment" accept="application/pdf">
            </div>

            <div id="brc_section" class="attachment-section">
                <label for="brc_number">BRC Number</label>
                <input type="text" id="brc_number" placeholder="Enter your BRC number">
                <label for="brc_attachment">Upload BRC Copy</label>
                <input type="file" id="brc_attachment" accept="application/pdf">
            </div>

            <div id="passport_section" class="attachment-section">
                <label for="passport_number">Passport Number</label>
                <input type="text" id="passport_number" placeholder="Enter your passport number">
                <label for="passport_attachment">Upload Passport Copy</label>
                <input type="file" id="passport_attachment" accept="application/pdf">
            </div>

            <div id="SignUp">
                <button>Sign Up</button>
                <p>------------ Or ------------</p>
                <p>Already have an account? <a href="{{ route('mobileLogin') }}" target="_blank">Login</a></p>
                <p><a href="/">Back to Home</a></p>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script>
        document.querySelectorAll('input[name="document_type"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                document.querySelectorAll('.attachment-section').forEach((section) => {
                    section.style.display = 'none';
                });
                let selectedSection = document.getElementById(event.target.value.toLowerCase() +
                '_section');
                selectedSection.style.display = 'block';
            });
        });
    </script>
@endsection
