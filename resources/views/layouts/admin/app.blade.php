<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>{{ $title ?? '' }} | {{ config('app.name') }}</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('admin/images/favicon.svg') }}" type="image/x-icon"
        data-navigate-once>
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('admin/fonts/inter/inter.css') }}" id="main-font-link" data-navigate-once />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('admin/fonts/tabler-icons.min.css') }}" data-navigate-once />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('admin/fonts/feather.css') }}" data-navigate-once />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('admin/fonts/fontawesome.css') }}" data-navigate-once />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('admin/fonts/material.css') }}" data-navigate-once />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}" id="main-style-link" data-navigate-once />
    <link rel="stylesheet" href="{{ asset('admin/css/style-preset.css') }}" data-navigate-once />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.0/css/tom-select.default.min.css"
        integrity="sha512-XeOgSpMYAOQI0N8mkz8Isilgg/iws6XL7ODCWX2XEfrGARHq+y1W8FlBmm6mvcKBviyvA+flVc+0sCPeBPSeUg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('admin/css/plugins/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.css"
        integrity="sha512-+Vla3mZvC+lQdBu1SKhXLCbzoNCl0hQ8GtCK8+4gOJS/PN9TTn0AO6SxlpX8p+5Zoumf1vXFyMlhpQtVD5+eSw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @livewireStyles
    @stack('styles')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    @livewire('admin.component.navbar')
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    @livewire('admin.component.topbar')
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            @livewire('admin.component.breadcrumb', ['title' => $title ?? ''])
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            {{ $slot }}
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @livewire('admin.component.footer')

    <!-- [Page Specific JS] start -->
    @if (request()->routeIs('admin.dashboard.index'))
    <script src="{{ asset('admin/js/plugins/apexcharts.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/pages/dashboard-default.js') }}" data-navigate-once></script>
    @endif
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('admin/js/plugins/popper.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/plugins/simplebar.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/plugins/bootstrap.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/fonts/custom-font.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/config.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/pcoded.js') }}" data-navigate-once></script>
    <script src="{{ asset('admin/js/plugins/feather.min.js') }}" data-navigate-once></script>

    <script src="{{ asset('admin/js/plugins/datepicker-full.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.0/js/tom-select.complete.js"
        integrity="sha512-rC/BuVjE/c8+4ZUsdDl3ldt4yhAwZru/cc3DFPOrluXDoxMuo8Aewg+GDoIhtfobtQCsbGZl/fBsL9Ew51Lr7g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('closeModal', () => {
                $('.modal').modal('hide');
            });
        });

    </script>
    @livewireScripts
    @stack('scripts')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11" data-navigate-once></script>

    <x-livewire-alert::scripts />
</body>
<!-- [Body] end -->

</html>
