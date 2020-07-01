<div class="row mt-4">
    <div class="col-md-2 text-center">
        <h3 class="bg-dark text-white">Results</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <strong>First Option</strong>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <input type="text" value="{{ $firstToSecondOption->description }}" readonly>
        @php
            $amount = number_format($firstToSecondOption->amount,2)
        @endphp
        <input type="text" value="${{ $amount }}" readonly>
        @php
            $stock = number_format($firstToSecondOption->stock,0)
        @endphp
        <input type="text" value="{{ $stock }}ea" readonly>
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-6">
        <strong>Second Options</strong>
    </div>
</div>
<div class="row">
    @foreach ($firstToSecondOption->secondoptions as $item)
    <div class="col-md-6">
        <input type="text" value="{{ $item->description }}" readonly>
        @php
            $amount = number_format($item->amount,2)
        @endphp
        <input type="text" value="${{ $amount }}" readonly>
        @php
            $stock = number_format($item->stock,0)
        @endphp
        <input type="text" value="{{ $stock }}ea" readonly>
    </div>
    @endforeach
</div>
