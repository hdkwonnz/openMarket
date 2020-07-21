<div class="container">
    <div class="row no-gutters" style="margin-top:69px; max-width: 1180px;">
        @foreach ($categorybs as $categoryb)
        <div class="col-md-3 col-sm-3">
            <div class="mt-1">
                <a href="/product/showProductsCategoryBC/{{ $categoryb->id }}" class="text-decoration-none text-dark">
                    <h5>{{ $categoryb->name }}</h5>
                </a>
            </div>
            @foreach ($categoryb->categorycs as $categoryc)
            <div class="ml-2">
                <a href="/product/showProductsCategoryC/{{ $categoryc->id }}" class="text-decoration-none text-dark">
                    <span>{{ $categoryc->name }}</span>
                </a>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
