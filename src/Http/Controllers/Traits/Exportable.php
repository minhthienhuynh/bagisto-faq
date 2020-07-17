<?php

namespace DFM\FAQ\Http\Controllers\Traits;

use Maatwebsite\Excel\Facades\Excel;
use Webkul\Admin\Exports\DataGridExport;

trait Exportable
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $format = request()->get('format');

        $gridName = last(explode('\\', request()->get('gridName')));

        $path = request()->input('gridName');

        if (empty($this->exportableGrid) || $gridName !== $this->exportableGrid) {
            return redirect()->back();
        }

        $gridInstance = new $path;

        $records = $gridInstance->export();

        if (! count($records)) {
            session()->flash('warning', trans('admin::app.export.no-records'));

            return redirect()->back();
        }

        if (request()->filled('format')) {
            return Excel::download(new DataGridExport($records), "{$gridName}.{$format}");
        }

        session()->flash('warning', trans('admin::app.export.illegal-format'));

        return redirect()->back();
    }
}
