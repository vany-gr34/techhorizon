
<h1>Step M3: Create a Category</h1>
<form id="managerForm" action="{{ route('register.submit') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" placeholder="Enter category name" required>
    </div>
    <button type="submit" class="next-button">Create Category and Complete Registration</button>
</form>
