<div class="flash-messages">
    @if(session()->has('success'))
        <div class="alert alert-success">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            {{ session('error') }}
        </div>
    @endif
</div>