<div>
    {{-- Success is as dangerous as failure. --}}
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0)">{{ strtoupper($previous) }}</a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ strtoupper($title ?? '') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->
</div>
