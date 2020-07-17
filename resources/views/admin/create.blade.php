@extends('admin::layouts.content')

@section('page_title')
    {{ __('dfm-faq::faq.add-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.faqs.store') }}" @submit.prevent="onSubmit">
            @csrf()

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                        {{ __('dfm-faq::faq.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('dfm-faq::faq.buttons.create-title') }}
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
                                    <input type="checkbox" id="active" name="active" value="active" @if (old('active')) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <div class="control-group" :class="[errors.has('question') ? 'has-error' : '']">
                                <label for="question" class="required">{{ __('dfm-faq::faq.fields.question') }}</label>
                                <textarea class="control editor" id="question" name="question" v-validate="'required'" data-vv-as="&quot;{{ __('dfm-faq::faq.fields.question') }}&quot;">{{ old('question') }}</textarea>
                                <span class="control-error" v-if="errors.has('question')">@{{ errors.first('question') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('answer') ? 'has-error' : '']">
                                <label for="answer" class="required">{{ __('dfm-faq::faq.fields.answer') }}</label>
                                <textarea class="control editor" id="answer" name="answer" v-validate="'required'" data-vv-as="&quot;{{ __('dfm-faq::faq.fields.answer') }}&quot;">{{ old('answer') }}</textarea>
                                <span class="control-error" v-if="errors.has('answer')">@{{ errors.first('answer') }}</span>
                            </div>

                            @inject('channels', 'Webkul\Core\Repositories\ChannelRepository')
                            <div class="control-group" :class="[errors.has('channels[]') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('admin::app.cms.pages.channel') }}</label>
                                <select type="text" class="control" id="url-key" name="channels[]" v-validate="'required'" value="{{ old('channel[]') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.channel') }}&quot;" multiple="multiple">
                                    @foreach($channels->all() as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->name }}</option>
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
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
                image_advtab: true,
                valid_elements : '*[*]'
            });
        });
    </script>
@endpush
