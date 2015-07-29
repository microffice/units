@if (isset($id))<input id='unit-id' name='form[unit][id]' value='{{$id}}' type='hidden' />@endif
<label for='form[unit][unit]' class=' ' >Unit</label>
<input id='unit-name' name='form[unit][unit]' class=' ' type='text' @if (isset($id))value='{{$unit}}' @endif/>