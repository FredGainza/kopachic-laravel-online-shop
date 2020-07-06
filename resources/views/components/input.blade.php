<div class="row">
  <div class="input-field col s12">
    <i class="material-icons prefix">{{ $icon }}</i>
    <input 
      id="{{ $name }}" 
      type="{{ $type }}" 
      name="{{ $name }}" 
      value="{{ old($name, $value !== '' ? $value : '') }}" 
      class="{{ $errors->has($name) ? 'invalid' : '' }}" 
      {{ $required ? 'required' : '' }} 
      {{ $autofocus ? 'autofocus' : '' }}>
    <label for="{{ $name }}">{{ $label }}</label>
    <span class="red-text">{{ $errors->has($name) ? $errors->first($name): '' }}</span>
  </div>
</div>