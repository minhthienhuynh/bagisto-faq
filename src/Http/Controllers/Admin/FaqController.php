<?php

namespace DFM\FAQ\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DFM\FAQ\Http\Requests\StoreFAQ;
use DFM\FAQ\Http\Requests\UpdateFAQ;
use DFM\FAQ\Models\Faq;
use DFM\FAQ\Repositories\FaqRepository;
use Illuminate\Http\Response;

class FaqController extends Controller
{
    /**
     * To hold the FaqRepository instance
     *
     * @var FaqRepository
     */
    private $faqRepository;

    /**
     * Create a new controller instance.
     *
     * @param  FaqRepository  $faqRepository
     */
    public function __construct(FaqRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Display a listing of the FAQs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dfm-faq::admin.index');
    }

    /**
     * Show the form for creating a new FAQ.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dfm-faq::admin.create');
    }

    /**
     * Store a newly created FAQ in storage.
     *
     * @param  StoreFAQ  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StoreFAQ $request)
    {
        $this->faqRepository->create($request->all());

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'FAQ']));

        return redirect()->route('admin.faqs.index');
    }

    /**
     * Show the form for editing the specified FAQ.
     *
     * @param  Faq  $faq
     * @return \Illuminate\View\View
     */
    public function edit(Faq $faq)
    {
        return view('dfm-faq::admin.edit', compact('faq'));
    }

    /**
     * Update the specified FAQ in storage.
     *
     * @param  UpdateFAQ  $request
     * @param  Faq        $faq
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UpdateFAQ $request, Faq $faq)
    {
        $this->faqRepository->update($request->all(), $faq->id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'FAQ']));

        return redirect()->route('admin.faqs.index');
    }

    /**
     * Remove the specified FAQ from storage.
     *
     * @param  Faq  $faq
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Faq $faq)
    {
        if ($faq->delete()) {
            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'FAQ']));

            return response()->json(['message' => true], Response::HTTP_OK);
        } else {
            session()->flash('success', trans('admin::app.response.delete-failure', ['name' => 'FAQ']));

            return response()->json(['message' => false], Response::HTTP_OK);
        }
    }

    /**
     * To mass delete the FAQ resource from storage
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function massDelete()
    {
        $data = request()->all();

        if ($data['indexes']) {
            $faqIDs = explode(',', $data['indexes']);

            $count = 0;

            foreach ($faqIDs as $faqID) {
                $faq = $this->faqRepository->find($faqID);

                if ($faq) {
                    $faq->delete();

                    $count++;
                }
            }

            if (count($faqIDs) == $count) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', [
                    'resource' => 'FAQs',
                ]));
            } else {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.partial-action', [
                    'resource' => 'FAQs',
                ]));
            }
        } else {
            session()->flash('warning', trans('admin::app.datagrid.mass-ops.no-resource'));
        }

        return redirect()->route('admin.faqs.index');
    }
}
