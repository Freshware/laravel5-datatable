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
     * @param   string      $template       [cambiamos la plantilla por defecto por otra a nuestro gusto]
     * @param   string      $dt_id          [el id de la tabla que se convertira en datatable]
     * @param   Collection  $values         [representa la colección de valores que se han de incorporar a la tabla]
     * @param   array       $array_values   [array que contiene los atributos/columnas a mostrar]
     * @param   string      $route          [ruta del controlador al que saltar]
     * @param   string      $link           [dirección a la que saltar en el primer parámetro, por defecto 'edit']
     * @param   boolean     $search         [true = se muestran inputs de busqueda en cada columna (pierde traducción)]
     * @return vista HTML
     */
    public function datatable($dt_id, $values, $array_values, $link = 'edit', $route = NULL, $search = false, $template = 'datatable.datatable')
    {
        $view = \View::make($template, [
                                            'values'        => $values,
                                            'datatable_id'  => $dt_id,
                                            'array_values'  => $array_values,
                                            'route'         => $route,
                                            'link'          => $link,
                                            'search'        => $search,
                                            'template'      => $template
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
