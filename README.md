# Easy way to make datatable(s) on Laravel
This is a simple method to make datatables on Laravel with a fast call and configuration.

## No Package
This is no package. In the future it may be.
But now is only a simple way to make datatables. We only use one **controller** and two **views**.

I make this because I tried different packages for develop datatables with Laravel, but no one works on useful way.
With no one we save time implementing the datatables. All packages are as useful and fast as create the table and include and configure DataTable jQuery.

But with this controller and views, we improve the way to include datatables on Laravel.

## Features
This way have some useful things:

* The first element contain a link to edit or show this item (p.e. if you show users, first element link with user profile)
* The first element link is by default *controller*.**edit**, but is posible to change it
* With other elements, if the element is an email, the system convert to email link
* Not need to configurate jQuery (but is possible, because the script is one of two views)

## Usage
* We assume you have jquery included in your HTML

1. Include jquery and css Datatable on your header/footer
```
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
```

2. Include file DatatableController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DatatableController extends Controller
{
    /**
     * Para mostrar datatables.
     *
     * @param   string      $dt_id          [el id de la tabla que se convertira en datatable]
     * @param   Collection  $values         [representa la colección de valores que se han de incorporar a la tabla]
     * @param   array       $array_values   [array que contiene los atributos/columnas a mostrar]
     * @param   string      $link           [dirección a la que saltar en el primer parámetro, por defecto 'edit']
     * @param   boolean     $search         [true = se muestran inputs de busqueda en cada columna (pierde traducción)]
     * @return vista HTML
     */
    public function datatable($dt_id, $values, $array_values, $link = 'edit', $search = false)
    {
        $view = \View::make('datatable.datatable', [
                                                        'values'        => $values,
                                                        'datatable_id'  => $dt_id,
                                                        'array_values'  => $array_values,
                                                        'link'          => $link,
                                                        'search'        => $search
                                                    ]);
        $contents = $view->render();

        return  $contents;
    }

    /**
     * Para mostrar el jQuery que carga los datatables.
     *
     * @param   string      $dt_id          [el id de la tabla que se convertira en datatable]
     * @param   boolean     $search         [true = se muestran inputs de busqueda en cada columna (pierde traducción)]
     * @return vista HTML
     */
    public function script($dt_id, $search = false)
    {
        $view = \View::make('datatable.script', ['datatable_id' => $dt_id, 'search' => $search]);
        $contents = $view->render();

        return  $contents;
    }
}
```

3. We create a new folder into views folder. Call it *datatable*. Inside we put the datatable views files, **datatable.blade.php** and **script.blade.php**
3.1 **datatable.blade.php**
```php
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
```
3.2 **script.blade.php**
```php
<script type="text/javascript">
    $(function() {
        window.table_id = '#' + '{{ $datatable_id }}';

        window.table = $(table_id).DataTable({
        	@if (!$search)
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json"
            }
            @endif
        });

        @if ($search)
        window.table_h = $(table_id + ' thead th');
        window.table_f = $(table_id + ' tfoot th');
        @endif
    });
</script>
```

## Usage
The way to use is very simple: On your controller, into method you want, you store into variable the data you want from database. After you only need to call the 2 views.

We have to lines to complete the datable:
```php
$datatable = (new DataTableController)->datatable(datatableId, itemsCollection, arrayWithColumnsOrValues, linkToProfile, BooleanToShowFinders);
$script = (new DataTableController)->script(datatableId, BooleanToShowFinders);
```

**Note:** The linkProfile and BooleanToShowFinders are optionals.

**EXAMPLE** If I want to show all users from `UsersController@index`, I do this :
Into controller
```php
$users = User::all(); // For get users from database

$datatable = (new DataTableController)->datatable('datatable_prueba', $users, ['name', 'email', 'phone'], 'show', false);
$script = (new DataTableController)->script('datatable_prueba', false);

return view('users.index', ['datatable' => $datatable, 'script' => $script]);
```

Into view
```php
@extends('app')

@section('content')
	<div class="col-xs-12 col-sm-10">
		{!! $datatable !!}
	</div>
@endsection

@section('scripts')
	{!! $script !!}
@endsection
```

### Credits
We hope it will be useful for you!
[freshware.es](http://freshware.es)