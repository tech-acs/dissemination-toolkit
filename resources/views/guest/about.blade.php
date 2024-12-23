<x-guest-layout>
    <div class="container mx-auto">
        @include('dissemination::partials.nav')

        <section>
            <div class="p-8 xl:px-0">
                <div class="bg-white">
                    <main class="isolate mb-20">
                        <!-- Hero section -->
                        <div class="relative isolate -z-10">
                            <svg class="absolute inset-x-0 top-0 -z-10 h-[64rem] w-full stroke-gray-200 [mask-image:radial-gradient(32rem_32rem_at_center,white,transparent)]" aria-hidden="true">
                                <defs>
                                    <pattern id="1f932ae7-37de-4c0a-a8b0-a6e3b4d44b84" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                                        <path d="M.5 200V.5H200" fill="none" />
                                    </pattern>
                                </defs>
                                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                                    <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z" stroke-width="0" />
                                </svg>
                                <rect width="100%" height="100%" stroke-width="0" fill="url(#1f932ae7-37de-4c0a-a8b0-a6e3b4d44b84)" />
                            </svg>
                            <div class="absolute left-1/2 right-0 top-0 -z-10 -ml-24 transform-gpu overflow-hidden blur-3xl lg:ml-24 xl:ml-48" aria-hidden="true">
                                <div class="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)"></div>
                            </div>
                            <div class="overflow-hidden">
                                <div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
                                    <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                                        <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                                            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">We’re changing the way people view data.</h1>
                                            <p class="relative mt-6 text-lg leading-8 text-gray-600 sm:max-w-md lg:max-w-none">Cupidatat minim id magna ipsum sint dolor qui. Sunt sit in quis cupidatat mollit aute velit. Et labore commodo nulla aliqua proident mollit ullamco exercitation tempor. Sint aliqua anim nulla sunt mollit id pariatur in voluptate cillum. Eu voluptate tempor esse minim amet fugiat veniam occaecat aliqua.</p>
                                        </div>
                                        <div class="mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0">
                                            <img src="img/about.jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content section -->
                        <div class="mx-auto -mt-12 max-w-7xl px-6 sm:mt-0 lg:px-8 xl:-mt-8">
                            <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our mission</h2>
                                <div class="mt-6 flex flex-col gap-x-8 gap-y-20 lg:flex-row">
                                    <div class="lg:w-full lg:max-w-2xl lg:flex-auto">
                                        <p class="text-xl leading-8 text-gray-600">Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem. At arcu, sit dui mi, nibh dui, diam eget aliquam. Quisque id at vitae feugiat egestas ac. Diam nulla orci at in viverra scelerisque eget. Eleifend egestas fringilla sapien.</p>
                                        <div class="mt-10 max-w-xl text-base leading-7 text-gray-700">
                                            <p>Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet vitae sed turpis id.</p>
                                            <p class="mt-10">Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id blandit molestie auctor fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius vulputate et ultrices hac adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel integer orci.</p>
                                        </div>
                                    </div>
                                    <div class="lg:flex lg:flex-auto lg:justify-center">
                                        <dl class="w-64 space-y-8 xl:w-80">
                                            <div class="flex flex-col-reverse gap-y-4">
                                                <dt class="text-base leading-7 text-gray-600">Transactions every 24 hours</dt>
                                                <dd class="text-5xl font-semibold tracking-tight text-gray-900">44 million</dd>
                                            </div>
                                            <div class="flex flex-col-reverse gap-y-4">
                                                <dt class="text-base leading-7 text-gray-600">Assets under holding</dt>
                                                <dd class="text-5xl font-semibold tracking-tight text-gray-900">$119 trillion</dd>
                                            </div>
                                            <div class="flex flex-col-reverse gap-y-4">
                                                <dt class="text-base leading-7 text-gray-600">New users annually</dt>
                                                <dd class="text-5xl font-semibold tracking-tight text-gray-900">46,000</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image section -->
                        <div class="mt-32 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
                            <img src="/img/about2.jpg" alt="" class="aspect-[5/2] w-full object-cover xl:rounded-3xl">
                        </div>

                        <!-- Values section -->
                        <div class="mx-auto mt-32 max-w-7xl px-6 sm:mt-40 lg:px-8">
                            <div class="mx-auto max-w-2xl lg:mx-0">
                                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our values</h2>
                                <p class="mt-6 text-lg leading-8 text-gray-600">Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.</p>
                            </div>
                            <dl class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 text-base leading-7 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                                <div>
                                    <dt class="font-semibold text-gray-900">Be world-class</dt>
                                    <dd class="mt-1 text-gray-600">Aut illo quae. Ut et harum ea animi natus. Culpa maiores et sed sint et magnam exercitationem quia. Ullam voluptas nihil vitae dicta molestiae et. Aliquid velit porro vero.</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-900">Share everything you know</dt>
                                    <dd class="mt-1 text-gray-600">Mollitia delectus a omnis. Quae velit aliquid. Qui nulla maxime adipisci illo id molestiae. Cumque cum ut minus rerum architecto magnam consequatur. Quia quaerat minima.</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-900">Always learning</dt>
                                    <dd class="mt-1 text-gray-600">Aut repellendus et officiis dolor possimus. Deserunt velit quasi sunt fuga error labore quia ipsum. Commodi autem voluptatem nam. Quos voluptatem totam.</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-900">Be supportive</dt>
                                    <dd class="mt-1 text-gray-600">Magnam provident veritatis odit. Vitae eligendi repellat non. Eum fugit impedit veritatis ducimus. Non qui aspernatur laudantium modi. Praesentium rerum error deserunt harum.</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-900">Take responsibility</dt>
                                    <dd class="mt-1 text-gray-600">Sit minus expedita quam in ullam molestiae dignissimos in harum. Tenetur dolorem iure. Non nesciunt dolorem veniam necessitatibus laboriosam voluptas perspiciatis error.</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-900">Enjoy downtime</dt>
                                    <dd class="mt-1 text-gray-600">Ipsa in earum deserunt aut. Quos minus aut animi et soluta. Ipsum dicta ut quia eius. Possimus reprehenderit iste aspernatur ut est velit consequatur distinctio.</dd>
                                </div>
                            </dl>
                        </div>

                    </main>

                </div>

            </div>


        </section>

        @include('dissemination::partials.footer')
    </div>
    @include('dissemination::partials.footer-end')
</x-guest-layout>
