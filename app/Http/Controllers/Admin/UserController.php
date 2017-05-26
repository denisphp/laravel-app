<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use HTML;
use Illuminate\Http\Request;
use Nayjest\Grids\DataRow;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

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
        $user = $this->findModel($id);

        return view('admin.user.view', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = $this->findModel($id);

        return view('admin.user.edit', ['user' => $user]);
    }

    public function update($id, Request $request)
    {
        $user = $this->findModel($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $input = $request->all();
        $user->fill($input)->save();

        \Session::flash('message', 'Successfully updated user!');

        return redirect()->back();
    }

    protected function findModel($id)
    {
        return User::findOrFail($id);
    }
}