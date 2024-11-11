{{--@props(['active'])--}}

<div x-data="embedCode()">
    <a x-on:click="open = true">{{ $trigger }}</a>
    <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-show="open" x-cloak>
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">

                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 text-gray-900 border-b-2 pb-1" id="modal-title">
                            {{ __('Embed code') }}
                        </h3>
                        <div class="mt-2">
                            <blockquote class="text-sm text-gray-900 dark:text-white pb-4">{{ __('Insert this code snippet wherever you wish the page to be displayed on your website.') }}</blockquote>
                            <div class="w-full p-2 text-sm text-gray-100 bg-gray-900" id="code" x-ref="contentDiv">
                                {{ $embedCode}}
                            </div>
                        </div>
                        <div x-show="copied" class="mt-2">
                            <div class="w-full p-2 text-base flex justify-end">
                                <p class="text-green-600">
                                {{ __('Copied to clipboard') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button x-on:click="copyToClipboard($refs.contentDiv)"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Copy') }}
                    </button>
                    <button x-on:click="open = false" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        {{ __('Close') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function embedCode() {
            return {
                open: false,
                copied: false,
                copyToClipboard: function (contentDiv) {
                    const range = document.createRange();
                    range.selectNode(contentDiv);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    window.navigator.clipboard.writeText(contentDiv.innerText);

                    window.getSelection().removeAllRanges();
                    this.copied = true;
                    setTimeout(() => {
                        this.copied = false;
                        this.open = false;
                    }, 1000);
                }
            }
        }
    </script>
</div>
