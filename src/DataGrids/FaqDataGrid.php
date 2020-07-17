<?php

namespace DFM\FAQ\DataGrids;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Webkul\Ui\DataGrid\DataGrid;

class FaqDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('faqs')
            ->select('faqs.id', 'faq_translations.question', 'faq_translations.answer', 'faqs.active')
            ->leftJoin('faq_translations', function($leftJoin) {
                $leftJoin->on('faqs.id', '=', 'faq_translations.faq_id')
                         ->where('faq_translations.locale', app()->getLocale());
            });

        $this->addFilter('id', 'faqs.id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'question',
            'label'      => trans('dfm-faq::faq.fields.question'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => false,
            'wrapper'    => function($row) {
                return Str::limit(strip_tags($row->question));
            },
        ]);

        $this->addColumn([
            'index'      => 'answer',
            'label'      => trans('dfm-faq::faq.fields.answer'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => false,
            'wrapper'    => function($row) {
                return Str::limit(strip_tags($row->answer));
            },
        ]);

        $this->addColumn([
            'index'      => 'active',
            'label'      => trans('dfm-faq::faq.fields.active'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->active) {
                    return '<span class="badge badge-md badge-success">' . trans('admin::app.customers.customers.active') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">' . trans('admin::app.customers.customers.inactive') . '</span>';
                }
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'route'  => 'admin.faqs.edit',
            'icon'   => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'title'  => trans('admin::app.datagrid.delete'),
            'method' => 'DELETE',
            'route'  => 'admin.faqs.destroy',
            'icon'   => 'icon trash-icon',
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.faqs.mass-delete'),
            'method' => 'DELETE',
        ]);
    }
}
