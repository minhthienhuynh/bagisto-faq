@extends('admin::layouts.content')

@section('page_title')
    {{ __('dfm-faq::faq.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('dfm-faq::faq.title') }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-lg btn-primary">
                    {{ __('dfm-faq::faq.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('faqGrid', 'DFM\FAQ\DataGrids\FaqDataGrid')
            {!! $faqGrid->render() !!}
        </div>
    </div>
@stop
