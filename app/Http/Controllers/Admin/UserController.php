<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Grids;
use HTML;
use Illuminate\Support\Facades\Config;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\TotalsRow;
use Nayjest\Grids\DataRow;
use Nayjest\Grids\DbalDataProvider;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function index()
    {
        $grid = new Grid(
            (new GridConfig)
                ->setDataProvider(new EloquentDataProvider(User::query()))
                ->setName('example_grid4')
                ->setPageSize(15)
                ->setColumns([
                     (new FieldConfig)
                         ->setName('id')
                         ->setLabel('ID')
                         ->setSortable(true)
                         ->setSorting(Grid::SORT_ASC)
                         ->addFilter((new FilterConfig)->setOperator(FilterConfig::OPERATOR_EQ)),
                     (new FieldConfig)
                         ->setName('name')
                         ->setLabel('Name')
                         ->setSortable(true)
                         ->addFilter((new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE)),
                     (new FieldConfig)
                         ->setName('email')
                         ->setLabel('Email')
                         ->setSortable(true)
                         ->setCallback(function ($val) {
                             $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
                             return
                                 '<small>'
                                 . $icon
                                 . HTML::link("mailto:$val", $val)
                                 . '</small>';
                         })
                         ->addFilter(
                             (new FilterConfig)
                                 ->setOperator(FilterConfig::OPERATOR_LIKE)
                         ),
                     (new FieldConfig)
                         ->setName('created_at')
                         ->setLabel('Creeated At')
                         ->setSortable(true),
                     (new FieldConfig)
                         ->setLabel('Actions')
                         ->setSortable(false)
                         ->setCallback(function ($val, DataRow $row) {
                             $id = $row->getCellValue('id');

                             return '
                             <a href="/admin/users/' . $id . '" title="View" data-pjax="0">View</a> 
                             <a href="/admin/users/' . $id . '/edit" title="View" data-pjax="0">Edit</a>';
                         }),
                ])
        );
        $grid = $grid->render();
        return view('admin.user.index', compact('grid'));
    }

    public function view($id)
    {
        $user = User::find($id);

        return view('admin.user.view', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.user.edit', ['user' => $user]);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('admin/users/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }
        // store
        $nerd = User::find($id);
        $nerd->name = Input::get('name');
        $nerd->email = Input::get('email');
        $nerd->save();

        // redirect
        \Session::flash('message', 'Successfully updated user!');

        return Redirect::to('admin/users');
    }
}