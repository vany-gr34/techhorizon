<style>:root {
  --primary-color: #4a90e2;
  --secondary-color: #f0f8ff;
  --text-color: #333;
  --border-color: #e0e0e0;
  --hover-color: #3a7bd5;
  --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  --transition: all 0.3s ease;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f5f7fa;
  color: var(--text-color);
  line-height: 1.6;
}

form {
  max-width: 500px;
  margin: 2rem auto;
  padding: 2rem;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: var(--shadow);
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-size: 1rem;
  font-weight: 600;
  color: var(--text-color);
}

input[type="text"] {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid var(--border-color);
  border-radius: 6px;
  font-size: 1rem;
  transition: var(--transition);
}

input[type="text"]:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
}

.checkbox-group {
  margin-bottom: 1.5rem;
}

.checkbox-container {
  display: flex;
  align-items: center;
  margin-bottom: 0.75rem;
  cursor: pointer;
}

.checkbox-container input[type="checkbox"] {
  position: absolute;
  opacity: 0;
}

.checkbox-container .checkmark {
  width: 22px;
  height: 22px;
  border: 2px solid var(--border-color);
  border-radius: 4px;
  margin-right: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: var(--transition);
}

.checkbox-container input[type="checkbox"]:checked + .checkmark {
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.checkbox-container .checkmark:after {
  content: '\2714';
  color: white;
  font-size: 14px;
  display: none;
}

.checkbox-container input[type="checkbox"]:checked + .checkmark:after {
  display: block;
}

.checkbox-container:hover .checkmark {
  border-color: var(--primary-color);
}

button[type="submit"] {
  width: 100%;
  padding: 0.75rem;
  background-color: var(--primary-color);
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

button[type="submit"]:hover {
  background-color: var(--hover-color);
}

@media (max-width: 600px) {
  form {
    padding: 1.5rem;
  }
}

</style>
<<form method="POST" action="{{ url('/register/step2') }}">
    @csrf
    @if ($data['role'] === 'subscriber')
        <label>Choisissez vos intérêts :</label>
        <div class="checkbox-group">
            @foreach ($intersts as $category)
                <label class="checkbox-container">
                    <input type="checkbox" name="interests[]" value="{{ $category->id }}">
                    <span class="checkmark"></span>
                    {{ $category->name }}
                </label>
            @endforeach
        </div>
    @else
        <input type="text" name="category_name" placeholder="Nom de la catégorie">
    @endif

    <button type="submit">Terminer l'inscription</button>
</form>