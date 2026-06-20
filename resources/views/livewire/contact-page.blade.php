<main class="px-6 py-10 lg:px-8 lg:py-14">
    <section class="mx-auto max-w-7xl">
        <div class="grid gap-10 xl:grid-cols-[0.95fr_1.05fr]">
            <div class="rounded-[2rem] bg-[#141b2b] p-8 text-white shadow-2xl shadow-slate-900/15 lg:p-10">
                <span class="text-xs font-semibold uppercase tracking-[0.22em] text-orange-300">Start the Conversation</span>
                <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-tight md:text-6xl">
                    Tell us what you are building, writing, or rethinking.
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-9 text-slate-300">
                    Wide Web Blog is built for thoughtful builders. Use the form to reach out about collaborations, editorial opportunities, sponsorships, or ideas worth exploring.
                </p>

                <div class="mt-10 space-y-5">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <h2 class="text-lg font-semibold text-white">Editorial partnerships</h2>
                        <p class="mt-2 text-sm leading-7 text-slate-300">Share your concept, audience, and what the collaboration should accomplish.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <h2 class="text-lg font-semibold text-white">Product or resource ideas</h2>
                        <p class="mt-2 text-sm leading-7 text-slate-300">If there is a template, guide, or workflow you want us to cover, describe the gap clearly.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <h2 class="text-lg font-semibold text-white">Signal over noise</h2>
                        <p class="mt-2 text-sm leading-7 text-slate-300">The more specific your context is, the better the response will be.</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5 lg:p-10">
                <div class="max-w-2xl">
                    <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#c2410c]">Contact Form</span>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-950 md:text-4xl">
                        One message, clearly framed.
                    </h2>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Keep it concise but useful. Tell us what you need, why it matters, and what a good outcome looks like.
                    </p>
                </div>

                @if ($submitted)
                    <div class="mt-8 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-900">
                        <h3 class="text-lg font-semibold">Message received</h3>
                        <p class="mt-2 text-sm leading-7">
                            Thanks for reaching out. Your note is queued on our side and we will review it with the context you provided.
                        </p>
                    </div>
                @endif

                <form class="mt-8 space-y-6" wire:submit="submit">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="contact-name" class="text-sm font-semibold text-slate-700">Your name</label>
                            <input
                                id="contact-name"
                                type="text"
                                wire:model.blur="name"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition-colors focus:border-[#c2410c] focus:bg-white focus:ring-4 focus:ring-orange-100"
                                placeholder="Alex Rivera">
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="contact-email" class="text-sm font-semibold text-slate-700">Email</label>
                            <input
                                id="contact-email"
                                type="email"
                                wire:model.blur="email"
                                class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition-colors focus:border-[#c2410c] focus:bg-white focus:ring-4 focus:ring-orange-100"
                                placeholder="alex@example.com">
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="contact-topic" class="text-sm font-semibold text-slate-700">Topic</label>
                        <input
                            id="contact-topic"
                            type="text"
                            wire:model.blur="topic"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition-colors focus:border-[#c2410c] focus:bg-white focus:ring-4 focus:ring-orange-100"
                            placeholder="Partnership, editorial idea, sponsorship, product question">
                        @error('topic') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact-message" class="text-sm font-semibold text-slate-700">Message</label>
                        <textarea
                            id="contact-message"
                            wire:model.blur="message"
                            rows="8"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition-colors focus:border-[#c2410c] focus:bg-white focus:ring-4 focus:ring-orange-100"
                            placeholder="What are you reaching out about, and what outcome are you aiming for?"></textarea>
                        @error('message') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-4 border-t border-slate-200 pt-6 md:flex-row md:items-center md:justify-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#141b2b] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/10 transition-colors hover:bg-[#c2410c]">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
