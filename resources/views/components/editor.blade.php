@props([
    'id' => 'editor',
    'model' => null,
    'value' => null,
    'attributes' => [],
    'placeholder' => 'Type your content here...',
])

<div x-data="{
        editor: null,
        init() {
            this.editor = SUNEDITOR.create((document.getElementById('editor') || 'editor'), {
                buttonList: [
                    ['undo', 'redo'],
                    [':p-More Paragraph-default.more_paragraph', 'font', 'fontSize', 'formatBlock', 'paragraphStyle', 'blockquote'],
                    ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript'],
                    ['fontColor', 'hiliteColor', 'textStyle'],
                    ['removeFormat'],
                    ['outdent', 'indent'],
                    ['align', 'horizontalRule', 'list', 'lineHeight'],
                    ['-right', ':i-More Misc-default.more_vertical', 'fullScreen', 'save', 'print'],
                    ['-right', ':r-More Rich-default.more_plus', 'table', 'imageGallery'],
                    ['-right', 'image', 'video', 'audio', 'link'],
                    ['%992', [
                        ['undo', 'redo'],
                        [':p-More Paragraph-default.more_paragraph', 'font', 'fontSize', 'formatBlock', 'paragraphStyle', 'blockquote'],
                        ['bold', 'underline', 'italic', 'strike'],
                        [':t-More Text-default.more_text', 'subscript', 'superscript', 'fontColor', 'hiliteColor', 'textStyle'],
                        ['removeFormat'],
                        ['outdent', 'indent'],
                        ['align', 'horizontalRule', 'list', 'lineHeight'],
                        ['-right', ':i-More Misc-default.more_vertical', 'fullScreen', 'save', 'print'],
                        ['-right', ':r-More Rich-default.more_plus', 'table', 'link', 'image', 'video', 'audio', 'imageGallery']
                    ]],
                    ['%767', [
                        ['undo', 'redo'],
                        [':p-More Paragraph-default.more_paragraph', 'font', 'fontSize', 'formatBlock', 'paragraphStyle', 'blockquote'],
                        [':t-More Text-default.more_text', 'bold', 'underline', 'italic', 'strike', 'subscript', 'superscript', 'fontColor', 'hiliteColor', 'textStyle'],
                        ['removeFormat'],
                        ['outdent', 'indent'],
                        [':e-More Line-default.more_horizontal', 'align', 'horizontalRule', 'list', 'lineHeight'],
                        [':r-More Rich-default.more_plus', 'table', 'link', 'image', 'video', 'audio', 'imageGallery'],
                        ['-right', ':i-More Misc-default.more_vertical', 'fullScreen', 'save', 'print']
                    ]],
                    ['%480', [
                        ['undo', 'redo'],
                        [':p-More Paragraph-default.more_paragraph', 'font', 'fontSize', 'formatBlock', 'paragraphStyle', 'blockquote'],
                        [':t-More Text-default.more_text', 'bold', 'underline', 'italic', 'strike', 'subscript', 'superscript', 'fontColor', 'hiliteColor', 'textStyle', 'removeFormat'],
                        [':e-More Line-default.more_horizontal', 'outdent', 'indent', 'align', 'horizontalRule', 'list', 'lineHeight'],
                        [':r-More Rich-default.more_plus', 'table', 'link', 'image', 'video', 'audio', 'imageGallery'],
                        ['-right', ':i-More Misc-default.more_vertical', 'fullScreen', 'save', 'print']
                    ]]
                ]
            });
        }
    }"
    class="w-full max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <textarea id="{{ $id }}" name="{{ $model }}" x-ref="editor" x-bind:value="$refs.editor.value" {{ $attributes->merge(['class' => 'w-full h-96']) }} placeholder="{{ $placeholder }}">{{ $value }}</textarea>
</div>
