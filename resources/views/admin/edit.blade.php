@extends('admin::layouts.content')

@section('page_title')
    {{ __('dfm-faq::faq.edit-title') }}
@stop

@section('content')
    <div class="content">
        <?php $locale = request()->get('locale') ?: app()->getLocale(); ?>

        <form method="POST" id="faq-form" action="{{ route('admin.faqs.update', [$faq->id, 'locale' => $locale]) }}" @submit.prevent="onSubmit">
            @method('PUT')
            @csrf()

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                        {{ __('dfm-faq::faq.edit-title') }}
                    </h1>

                    <div class="control-group">
                        <select class="control" id="locale-switcher" onChange="window.location.href = this.value">
                            @foreach (core()->getAllLocales() as $localeModel)
                                <option value="{{ route('admin.faqs.edit', [$faq->id, 'locale' => $localeModel->code]) }}" {{ ($localeModel->code) == $locale ? 'selected' : '' }}>
                                    {{ $localeModel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('dfm-faq::faq.buttons.edit-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    <accordian :title="'{{ __('admin::app.cms.pages.general') }}'" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="active">{{ __('dfm-faq::faq.fields.active') }}</label>
                                <label class="switch">
                                    <input type="checkbox" id="active" name="active" value="{{ $faq->active }}" @if ($faq->active || old('active')) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="control-group" :class="[errors.has('{{$locale}}[question]') ? 'has-error' : '']">
                                <label for="question" class="required">{{ __('dfm-faq::faq.fields.question') }}</label>
                                <textarea class="control editor" id="question" name="{{$locale}}[question]" v-validate="'required'" data-vv-as="&quot;{{ __('dfm-faq::faq.fields.question') }}&quot;">{{ old($locale)['question'] ?? ($faq->translate($locale)['question'] ?? '') }}</textarea>
                                <span class="control-error" v-if="errors.has('{{$locale}}[question]')">@{{ errors.first('{!!$locale!!}[question]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('{{$locale}}[answer]') ? 'has-error' : '']">
                                <label for="html_content" class="required">{{ __('dfm-faq::faq.fields.answer') }}</label>
                                <textarea class="control editor" id="answer" name="{{$locale}}[answer]" v-validate="'required'" data-vv-as="&quot;{{ __('dfm-faq::faq.fields.answer') }}&quot;">{{ old($locale)['answer'] ?? ($faq->translate($locale)['answer'] ?? '') }}</textarea>
                                <span class="control-error" v-if="errors.has('{{$locale}}[answer]')">@{{ errors.first('{!!$locale!!}[answer]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('channels[]') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('admin::app.cms.pages.channel') }}</label>
                                <select type="text" class="control" name="channels[]" v-validate="'required'" value="{{ old('channel[]') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.channel') }}&quot;" multiple="multiple">
                                    @php($selectedOptionIds = old('inventory_sources') ?: $faq->channels->pluck('id')->toArray())
                                    @foreach(app('Webkul\Core\Repositories\ChannelRepository')->all() as $channel)
                                        <option value="{{ $channel->id }}" {{ in_array($channel->id, $selectedOptionIds) ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="control-error" v-if="errors.has('channels[]')">@{{ errors.first('channels[]') }}</span>
                            </div>
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: 'textarea.editor',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code',
                image_advtab: true,
                valid_elements : '*[*]'
            });
        });
    </script>
@endpush
