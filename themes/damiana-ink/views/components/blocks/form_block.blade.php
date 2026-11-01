@php
    $locale = app()->getLocale();
    $formId = $data['form_id'] ?? null;
    $form = $formId ? \Celios\Core\Models\Form::where('is_active', true)->find($formId) : null;
    if (!$form) {
        $form = \Celios\Core\Models\Form::where('slug', 'tattoo-booking')->first();
    }
    $submitUrl = $form ? '/' . $locale . '/forms/' . $form->slug . '/submit' : '/forms/tattoo-booking/submit';
@endphp

<!-- BOOKING / CONTACT SECTION -->
<div id="booking" class="section-book bg-black text-white py-12" x-data="{
    status: null,
    isSubmitting: false,
    pickerOpen: false,
    selectedDate: '',
    dateError: false,
    viewYear: new Date().getFullYear(),
    viewMonth: new Date().getMonth(),
    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    weekDays: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
    get blankDays() {
        const firstDay = new Date(this.viewYear, this.viewMonth, 1).getDay();
        return Array.from({ length: (firstDay + 6) % 7 }, (_, i) => i);
    },
    get daysInMonth() {
        const count = new Date(this.viewYear, this.viewMonth + 1, 0).getDate();
        return Array.from({ length: count }, (_, i) => i + 1);
    },
    formatYmd(year, month, day) {
        const m = String(month + 1).padStart(2, '0');
        const d = String(day).padStart(2, '0');
        return `${year}-${m}-${d}`;
    },
    isPast(day) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return new Date(this.viewYear, this.viewMonth, day) < today;
    },
    isToday(day) {
        const now = new Date();
        return this.viewYear === now.getFullYear() && this.viewMonth === now.getMonth() && day === now.getDate();
    },
    isSelected(day) {
        return this.selectedDate === this.formatYmd(this.viewYear, this.viewMonth, day);
    },
    selectDay(day) {
        if (this.isPast(day)) return;
        this.selectedDate = this.formatYmd(this.viewYear, this.viewMonth, day);
        this.dateError = false;
        this.pickerOpen = false;
    },
    selectToday() {
        const now = new Date();
        this.viewYear = now.getFullYear();
        this.viewMonth = now.getMonth();
        this.selectedDate = this.formatYmd(this.viewYear, this.viewMonth, now.getDate());
        this.dateError = false;
        this.pickerOpen = false;
    },
    clearDate() {
        this.selectedDate = '';
        this.pickerOpen = false;
    },
    prevMonth() {
        if (this.viewMonth === 0) {
            this.viewMonth = 11;
            this.viewYear--;
        } else {
            this.viewMonth--;
        }
    },
    nextMonth() {
        if (this.viewMonth === 11) {
            this.viewMonth = 0;
            this.viewYear++;
        } else {
            this.viewMonth++;
        }
    },
    async handleSubmit(e) {
        this.status = null;
        if (!this.selectedDate) {
            this.dateError = true;
            this.pickerOpen = true;
            return;
        }
        this.dateError = false;
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
                this.selectedDate = '';
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

                    <div class="relative flex flex-row space-x-2 items-center lg:h-8" @click.outside="pickerOpen = false" @keydown.escape.window="pickerOpen = false">
                        <button type="button" @click="pickerOpen = !pickerOpen" class="cursor-pointer focus:outline-none" aria-label="Open calendar">
                            <img src="/icons/calendar.png" alt="Calendar Icon" class="w-5 h-5 object-contain">
                        </button>

                        <div class="custom-input-wrapper relative flex items-center">
                            <input
                                type="text"
                                name="preferred_date"
                                x-model="selectedDate"
                                @click="pickerOpen = !pickerOpen"
                                placeholder="preferred date*"
                                readonly
                                class="date-dark-input underline-input font-body italic text-white pr-6 focus:outline-none"
                                :class="{ '!border-red-500': dateError }"
                            />
                            <button
                                type="button"
                                x-show="selectedDate"
                                @click.stop="clearDate()"
                                class="absolute right-1 text-gray-400 hover:text-white text-sm leading-none cursor-pointer"
                                aria-label="Clear date"
                                style="display: none;"
                            >&times;</button>
                        </div>

                        <!-- Alpine Pitch-Black Studio Calendar Popover -->
                        <div
                            x-show="pickerOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="absolute left-0 bottom-full mb-2 z-50 w-72 bg-black border border-[#333333] p-4 text-white select-none"
                            style="display: none;"
                        >
                            <!-- Month / Year Navigation -->
                            <div class="flex items-center justify-between mb-3 pb-2 border-b border-[#333333]">
                                <button
                                    type="button"
                                    @click="prevMonth()"
                                    class="w-7 h-7 flex items-center justify-center rounded hover:bg-[#333333] text-gray-300 hover:text-white transition-colors cursor-pointer"
                                    aria-label="Previous month"
                                >&lsaquo;</button>

                                <div class="font-heading text-sm tracking-wide">
                                    <span x-text="monthNames[viewMonth]"></span>
                                    <span x-text="viewYear" class="ml-1 text-gray-300"></span>
                                </div>

                                <button
                                    type="button"
                                    @click="nextMonth()"
                                    class="w-7 h-7 flex items-center justify-center rounded hover:bg-[#333333] text-gray-300 hover:text-white transition-colors cursor-pointer"
                                    aria-label="Next month"
                                >&rsaquo;</button>
                            </div>

                            <!-- Weekday Headers -->
                            <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-body text-gray-400 mb-1">
                                <template x-for="dayName in weekDays" :key="dayName">
                                    <div class="py-1" x-text="dayName"></div>
                                </template>
                            </div>

                            <!-- Days Grid -->
                            <div class="grid grid-cols-7 gap-1 text-center text-xs font-body">
                                <template x-for="blank in blankDays" :key="'blank-' + blank">
                                    <div class="h-8"></div>
                                </template>

                                <template x-for="day in daysInMonth" :key="'day-' + day">
                                    <button
                                        type="button"
                                        @click="selectDay(day)"
                                        :disabled="isPast(day)"
                                        class="h-8 w-8 mx-auto flex items-center justify-center rounded-full transition-colors"
                                        :class="{
                                            'bg-white text-black font-semibold cursor-pointer': isSelected(day),
                                            'border border-[#767676] text-white': isToday(day) && !isSelected(day),
                                            'text-white hover:bg-[#333333] cursor-pointer': !isPast(day) && !isSelected(day),
                                            'text-neutral-600 cursor-not-allowed': isPast(day)
                                        }"
                                        x-text="day"
                                    ></button>
                                </template>
                            </div>

                            <!-- Footer Actions -->
                            <div class="flex items-center justify-between mt-3 pt-2 border-t border-[#333333] text-xs font-body italic">
                                <button
                                    type="button"
                                    @click="selectToday()"
                                    class="text-gray-300 hover:text-white transition-colors cursor-pointer"
                                >Today</button>
                                <button
                                    type="button"
                                    @click="clearDate()"
                                    class="text-gray-400 hover:text-white transition-colors cursor-pointer"
                                >Clear</button>
                            </div>
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
