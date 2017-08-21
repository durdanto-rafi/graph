<option value="">Select</option>
@if(!empty($formattedContents))
  @foreach($formattedContents as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif