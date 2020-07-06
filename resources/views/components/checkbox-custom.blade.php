
<div class="form-group">
    <div class="custom-control custom-switch custom-switch-off-{{ $off }} custom-switch-on-{{ $on }}">
      <input type="checkbox" class="custom-control-input" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        @if(old($name, $value)) checked @endif>
      <label class="custom-control-label" for="{{ $name }}">{{ $label }}</label>
    </div>
  </div>