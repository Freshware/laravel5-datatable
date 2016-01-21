
	<div class="row">
		<div class="col-xs-12">
			<table id="{{ $datatable_id }}" class="table table-striped" cellspacing="0">
			    <thead>
			        <tr>
				    	@for ($i = 0; $i < count($array_values); $i++)
				    		<th>{!! $array_values[$i] !!}</th>
				    	@endfor
			        </tr>
			    </thead>
			    <tbody>
				    @foreach ($values as $value)
				    <tr>
				    	@for ($i = 0; $i < count($array_values); $i++)
				    		@if ($i == 0)
				    			<td>
				    				<a href="{{ route('usuario.' . $link, $value->id) }}" class="text-success">
				    					<strong>{!! $value->getAttribute($array_values[$i]) !!}</strong>
				    				</a>
				    			</td>
				    		@else
				    			@if (filter_var($value->getAttribute($array_values[$i]), FILTER_VALIDATE_EMAIL))
				    				<td>
					    				<a href="mailto:{!! $value->getAttribute($array_values[$i]) !!}" class="text-info">
					    					{!! $value->getAttribute($array_values[$i]) !!}
					    				</a>
				    				</td>
				    			@else
				    				<td>{!! $value->getAttribute($array_values[$i]) !!}</td>
				    			@endif
				    		@endif
				    	@endfor
				    </tr>
				    @endforeach
			    </tbody>
			    <tfoot>
			        <tr>
				    	@for ($i = 0; $i < count($array_values); $i++)
				    		<th>{!! $array_values[$i] !!}</th>
				    	@endfor
			        </tr>
			    </tfoot>
			</table>
		</div>
	</div>
