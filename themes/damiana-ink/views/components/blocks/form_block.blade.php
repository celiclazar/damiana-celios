@php
    $locale = app()->getLocale();
    $formId = $data['form_id'] ?? null;
    $form = $formId ? \Celios\Core\Models\Form::where('is_active', true)->find($formId) : null;
    if (!$form) {
        $form = \Celios\Core\Models\Form::where('slug', 'tattoo-booking')->first();
    }
    $submitUrl = $form ? url('/' . $locale . '/forms/' . $form->slug . '/submit') : url('/forms/tattoo-booking/submit');
@endphp

<!-- BOOKING / CONTACT SECTION -->
<div id="booking" class="section-book bg-black text-white py-12" x-data="{
    status: null,
    isSubmitting: false,
    async handleSubmit(e) {
        this.status = null;
        this.isSubmitting = true;
        const formData = new FormData(e.target);

        try {
            const res = await fetch('{{ $submitUrl }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (res.ok) {
                this.status = 'success';
                e.target.reset();
                setTimeout(() => { this.status = null; }, 7000);
            } else {
                this.status = 'error';
            }
        } catch (err) {
            this.status = 'error';
        } finally {
            this.isSubmitting = false;
        }
    }
}">
    <form @submit.prevent="handleSubmit" class="section-book bg-black text-white py-12">
        @csrf
        {{-- Honeypots --}}
        <input type="text" name="_hp_name" style="display:none !important;" tabindex="-1" autocomplete="off" />
        <input type="hidden" name="_hp_time" value="{{ time() - 10 }}" />

        <div class="container mx-auto px-4 sm:px-16">
            <h2 class="font-heading text-2xl sm:text-4xl text-center mb-10">Book an appointment</h2>

            <div x-show="status" class="text-center mb-8 h-6" style="display: none;">
                <p x-show="status === 'success'" class="text-white font-body italic tracking-widest uppercase text-xs sm:text-sm">
                    Thank you. Your inquiry has been received. We will contact you shortly.
                </p>
                <p x-show="status === 'error'" class="text-red-500 font-body italic tracking-widest uppercase text-xs sm:text-sm">
                    Submission failed. Please ensure all required fields are correctly filled.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row justify-center gap-8">
                <!-- Left Column -->
                <div class="flex flex-col space-y-4 w-full lg:w-1/4">
                    <input name="name" class="booking-input font-body italic" type="text" placeholder="Name*" required>
                    <input name="email" class="booking-input font-body italic" type="email" placeholder="E-mail*" required>
                    <input name="phone" class="booking-input font-body italic" type="tel" placeholder="Phone*" required>
                    <input name="budget" class="booking-input font-body italic" type="text" placeholder="Budget (optional)">
                </div>

                <!-- Right Column -->
                <div class="flex flex-col space-y-4 w-full lg:w-2/4">
                    <textarea name="tattoo_idea" class="booking-input min-h-48 lg:h-3/4 font-body italic" placeholder="Tattoo idea*" required></textarea>

                    <div class="flex flex-row lg:space-x-2 items-center lg:h-8">
                        <div>
                            <img src="/icons/calendar.png" alt="Calendar Icon" class="w-5 h-5 object-contain">
                        </div>

                        <div class="custom-input-wrapper">
                            <input
                                type="text"
                                name="preferred_date"
                                onfocus="(this.type='date')"
                                onblur="if(!this.value) this.type='text'"
                                placeholder="preferred date*"
                                class="date-dark-input underline-input font-body italic text-white"
                                required
                            />
                        </div>
                    </div>

                    <div class="text-center lg:text-right mt-8">
                        <button type="submit" 
                                :disabled="isSubmitting"
                                class="inline-block right-0 px-6 py-1 border border-gray-100 text-gray-100 font-button uppercase tracking-wide hover:bg-gray-100 hover:text-black transition-colors duration-300 disabled:opacity-50 cursor-pointer">
                            <span x-text="isSubmitting ? 'Sending...' : 'Send &raquo;'">Send &raquo;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
