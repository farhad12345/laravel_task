<!DOCTYPE html>
<html lang="en">

<head>
    <title>Orbit - Bootstrap 5 Resume/CV Template for Developers</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Resume/CV Template for Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Google Font -->
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- FontAwesome JS-->
    <script defer src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>
    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/orbit-1.css') }}">
</head>

<body>
    <div class="wrapper mt-lg-5">
        @foreach ($user_resumes as $resume)
            <div class="sidebar-wrapper">
                <div class="profile-container">
                    <img class="profile" src="{{ asset('assets/images/profile.png') }}" alt="" />
                    <h1 class="name">{{ $resume->user->name }}</h1>
                    <h3 class="tagline">{{ $resume->user->role }}</h3>
                </div>
                <!--//profile-container-->

                <div class="contact-container container-block">
                    <ul class="list-unstyled contact-list">
                        <li class="email"><i class="fa-solid fa-envelope"></i>
                            <span contenteditable>{{ $resume->user->email }}</span>
                        </li>
                        <li class="phone"><i class="fa-solid fa-phone"></i>
                            <span
                                contenteditable>{{ $resume->personal_info ? $resume->personal_info->contact_number : '' }}</span>
                        </li>
                        <li class="website"><i class="fa-solid fa-globe"></i>
                            <span
                                contenteditable>{{ $resume->personal_info ? $resume->personal_info->website : '' }}</span>
                        </li>
                        <li class="linkedin"><i class="fa-brands fa-linkedin-in"></i>
                            <span
                                contenteditable>{{ $resume->personal_info ? $resume->personal_info->linkedin : '' }}</span>
                        </li>
                        <li class="github"><i class="fa-brands fa-github"></i>
                            <span
                                contenteditable>{{ $resume->personal_info ? $resume->personal_info->github : '' }}</span>
                        </li>
                        <li class="twitter"><i class="fa-brands fa-twitter"></i>
                            <span
                                contenteditable>{{ $resume->personal_info ? $resume->personal_info->twitter : '' }}</span>
                        </li>
                    </ul>
                </div>
                <!--//contact-container-->

                <div class="education-container container-block">
                    <h2 class="container-block-title">Education</h2>
                    @if ($resume->education)
                        @foreach ($resume->education as $education)
                            <div class="item">
                                <h4 class="degree">
                                    <span contenteditable>{{ $education->degree }}</span>
                                    in
                                    <span contenteditable>{{ $education->field_of_study }}</span>
                                </h4>
                                <h5 class="meta">
                                    <span contenteditable>{{ $education->institution }}</span>
                                </h5>
                                <div class="time">
                                    <span contenteditable>{{ $education->start_date }}</span> - <span
                                        contenteditable>{{ $education->end_date }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <li>No interests found.</li>
                    @endif
                </div>
                <!--//education-container-->

                <div class="languages-container container-block">
                    <h2 class="container-block-title">Languages</h2>
                    <ul class="list-unstyled interests-list">
                        @if ($resume->languages)
                            @foreach ($resume->languages as $language)
                                <li>
                                    <span contenteditable>{{ $language->language }}</span>
                                    <span class="lang-desc">(<span
                                            contenteditable>{{ $language->proficiency_level }}</span>)</span>
                                </li>
                            @endforeach
                        @else
                            <li>No Languages found.</li>
                        @endif
                    </ul>
                </div>
                <!--//languages-container-->

                <div class="interests-container container-block">
                    <h2 class="container-block-title">Interests</h2>
                    <ul class="list-unstyled interests-list">
                        @if ($resume->interests)
                            @foreach ($resume->interests as $interest)
                                <li contenteditable>{{ $interest->interest }}</li>
                            @endforeach
                        @else
                            <li>No interests found.</li>
                        @endif
                    </ul>
                </div>
                <!--//interests-container-->
            </div>
            <!--//sidebar-wrapper-->

            <div class="main-wrapper">
                <section class="section summary-section">
                    <h2 class="section-title"><span class="icon-holder"><i class="fa-solid fa-user"></i></span>Career
                        Profile
                    </h2>
                    <div class="summary">
                        <p contenteditable>{{ $resume->summary }}</p>
                    </div>
                    <!--//summary-->
                </section>
                <!--//section-->
                <form id="experience-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $resume->user_id }}">
                    <!-- Include user_id -->
                    <input type="hidden" name="template_id" value="{{ $resume->template_id }}">
                    <section class="section experiences-section">
                        <h2 class="section-title"><span class="icon-holder"><i
                                    class="fa-solid fa-briefcase"></i></span>Experiences
                        </h2>
                        <button type="button" id="add-experience-btn">Add New</button>
                        <br>
                        <div class="item">
                            <div class="meta">
                                <div class="upper-row">
                                    <h3 class="job-title"><input type="text" class="form-input" name="job_title[]"
                                            value=""></h3>
                                    <div class="time"><input type="text" class="form-input" name="start_date[]"
                                            value="">-
                                        <input type="text" class="form-input" hidden name="end_date[]"
                                            value="">
                                    </div>
                                </div>
                                <!--//upper-row-->
                                <div class="company"><input type="text" class="form-input" name="company[]"
                                        value=""></div>
                            </div>
                            <!--//meta-->

                            <div class="details">
                                <p><input type="text" name="description[]" class="form-input" value="">
                                </p>
                            </div>

                        </div>
                        @if ($resume->experience)
                            @foreach ($resume->experience as $experience)
                                <div class="item">
                                    <div class="meta">
                                        <div class="upper-row">
                                            <input type="hidden" name="experience_id[]"
                                                value="{{ $experience->id }}">
                                            <h3 class="job-title"><input type="text" class="form-input"
                                                    name="job_title[]" value="{{ $experience->position }}"></h3>
                                            <div class="time"><input type="text" class="form-input"
                                                    name="start_date[]" value="{{ $experience->start_date }}">-
                                                {{ $experience->end_date ?: 'Present' }}
                                                <input type="text" class="form-input" hidden name="end_date[]"
                                                    value="{{ $experience->end_date }}">
                                            </div>
                                        </div>
                                        <!--//upper-row-->
                                        <div class="company"><input type="text" class="form-input"
                                                name="company[]" value="{{ $experience->company }}"></div>
                                    </div>
                                    <!--//meta-->

                                    <div class="details">
                                        <p><input type="text" name="description[]" class="form-input"
                                                value="{{ $experience->description }}">
                                        </p>
                                    </div>

                                </div>
                            @endforeach
                            <input type="submit" value="Create">
                        @else
                            <li>No Experience Found</li>
                        @endif
                    </section>
                </form>
                <!--//section-->

                <section class="section projects-section">
                    <h2 class="section-title"><span class="icon-holder"><i
                                class="fa-solid fa-archive"></i></span>Projects</h2>
                    <div class="intro">
                        <p>You can list your side projects or open source libraries in this section. Lorem ipsum dolor
                            sit amet,
                            consectetur adipiscing elit. Vestibulum et ligula in nunc bibendum fringilla a eu lectus.
                        </p>
                    </div>
                    @if ($resume->projects)
                        @foreach ($resume->projects as $project)
                            <div class="item">
                                <span class="project-title" contenteditable>{{ $project->title }}</span>
                                - <span class="project-tagline" contenteditable>{{ $project->description }}</span>
                            </div>
                        @endforeach
                    @else
                        <li>No Projects Found</li>
                    @endif
                </section>
                <!--//section-->

                <section class="skills-section section">
                    <h2 class="section-title"><span class="icon-holder"><i
                                class="fa-solid fa-rocket"></i></span>Skills
                        &amp;
                        Proficiency</h2>
                    <div class="skillset">
                        @if ($resume->projects)
                            @foreach ($resume->skills as $skill)
                                <div class="item">
                                    <h3 class="level-title" contenteditable>{{ $skill->skill }}</h3>
                                    <div class="progress level-bar">
                                        <div class="progress-bar theme-progress-bar" role="progressbar"
                                            style="width: {{ $skill->proficiency_level }}%"
                                            aria-valuenow="{{ $skill->proficiency_level }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <li>No Skills Found</li>
                        @endif
                    </div>
                </section>
                <!--//skills-section-->
            </div>
            <!--//main-body-->
        @endforeach
    </div>

    <footer class="footer">
        <div class="text-center">
            <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            <small class="copyright">Designed with <i class="fa-solid fa-heart"></i> by <a href=""
                    target="_blank">X</a> for developers</small>
        </div>
        <!--//container-->
    </footer>
    <!--//footer-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update experience
            function updateExperience(formData) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.update.experience') }}', // Replace with your actual route
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // You can handle the success response here
                    },
                    error: function(response) {
                        alert('Error: ' + response.responseJSON.message); // Handle errors here
                    }
                });
            }

            // Function to create experience
            function createExperience(formData) {
                // Check if experience_id is present in the formData
                if (!formData.get('experience_id[]')) {
                    // If experience_id doesn't exist, it's a new record, so create it
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('admin.create.experience') }}',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.message);
                            // Optionally, update your UI with the newly created experience data
                            // Clear the form or reset it for the next entry
                            $('#experience-form')[0].reset();
                        },
                        error: function(response) {
                            alert('Error: ' + response.responseJSON.message);
                        }
                    });
                }
            }

            $('.form-input').on('focusout', function() {
                var formData = new FormData($('#experience-form')[0]);
                if (formData.get('experience_id[]')) {
                    // If experience_id exists, it's an update action
                    updateExperience(formData);
                }
            });
            // Submit form to create experience
            $('#experience-form').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                var formData = new FormData(this);
                createExperience(formData);
            });
            $('#add-experience-btn').on('click', function() {
                // Clone the last experience item and clear its values
                var $lastExperience = $('.item:last').clone();
                $lastExperience.find('input[type="text"]').val('');
                $('.section.experiences-section').append($lastExperience);
            });
        });
    </script>
</body>

</html>
