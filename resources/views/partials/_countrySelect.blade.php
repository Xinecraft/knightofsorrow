
{!! Form::select('country', App\Country::lists('countryName', 'id'), Input::old('country'), array('class'=>'form-control')) !!}