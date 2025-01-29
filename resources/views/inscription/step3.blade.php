
<h1>Step 3: Select Your Interests</h1>
<form id="subscriberForm" action="{{ route('register.submit') }}" method="POST">
    @csrf
    <div class="interest-container">
        @foreach($interests as $interest)
            <label class="interest-button">
                <input type="checkbox" name="interests[]" value="{{ $interest->id }}">
                <span>{{ $interest->name }}</span>
            </label>
        @endforeach
    </div>
    <button type="submit" class="next-button">Complete Registration</button>
</form>
