<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        <section>
            <div class="p-8 xl:px-0">
                <div class="relative bg-white border">
                    <div class="absolute inset-0">
                        <div class="absolute inset-y-0 left-0 w-1/2 bg-gray-50"></div>
                    </div>
                    <div class="relative mx-auto max-w-7xl lg:grid lg:grid-cols-5">
                        <div class="bg-gray-50 px-6 py-16 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                            <div class="mx-auto max-w-lg">
                                <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Get in touch</h2>
                                <p class="mt-3 text-lg leading-6 text-gray-500">We're here to help! If you have any questions, comments, or feedback, please don't hesitate to contact us.</p>
                                <dl class="mt-8 text-base text-gray-500">
                                    <div>
                                        <dt class="sr-only">Postal address</dt>
                                        <dd>
                                            {!! str($org->address)->markdown() !!}
                                        </dd>
                                    </div>
                                </dl>
                                <p class="mt-6 text-base text-gray-500">
                                    Looking for our organization's website?<br>
                                    <a href="{{ $org->website }}" class="font-medium text-gray-700 underline">Click here to visit</a>
                                </p>
                            </div>
                        </div>
                        <div class="bg-white px-6 py-16 lg:col-span-3 lg:px-8 lg:py-24 xl:pl-12">
                            <div class="mx-auto max-w-lg lg:max-w-none">
                                <form class="grid grid-cols-1 gap-y-6">
                                    <div>
                                        <label for="full-name" class="sr-only">Full name</label>
                                        <input type="text" name="full-name" id="full-name" autocomplete="name" class="block w-full rounded-md border-gray-300 px-4 py-3 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Full name">
                                    </div>
                                    <div>
                                        <label for="email" class="sr-only">Email</label>
                                        <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-gray-300 px-4 py-3 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Email">
                                    </div>
                                    <div>
                                        <label for="phone" class="sr-only">Phone</label>
                                        <input type="text" name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md border-gray-300 px-4 py-3 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Phone">
                                    </div>
                                    <div>
                                        <label for="phone" class="sr-only">Subject</label>
                                        <input type="text" name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md border-gray-300 px-4 py-3 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Subject">
                                    </div>
                                    <div>
                                        <label for="message" class="sr-only">Message</label>
                                        <textarea id="message" name="message" rows="4" class="block w-full rounded-md border-gray-300 px-4 py-3 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Message"></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')
</x-guest-layout>
