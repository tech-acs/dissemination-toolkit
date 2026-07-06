@props(['var' => 'block', 'height' => '200px'])

<div x-show="{{ $var }}.type === 'text'" class="p-4 pt-6"
     x-init="if ({{ $var }}.type === 'text' && !editors[{{ $var }}.id]) {
         let q = new Quill($el.querySelector('.quill-editor'), { theme: 'snow' });
         if ({{ $var }}.data.content) q.root.innerHTML = {{ $var }}.data.content;
         q.on('text-change', () => { {{ $var }}.data.content = q.root.innerHTML; });
         editors[{{ $var }}.id] = q;
         $el.querySelector('.ql-editor').classList.add('prose', 'prose-indigo', 'max-w-none');
     }">
    <div class="quill-editor block-editor-quill" style="min-height: {{ $height }};"></div>
</div>
