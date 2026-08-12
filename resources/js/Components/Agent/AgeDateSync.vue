<template>
    <div class="p-4 bg-gray-50/50 rounded-lg border border-gray-100 mt-2">
        <p class="text-3xs text-center text-gray-400 italic mb-3">Enter either Date of Birth OR Age (they sync automatically)</p>
        <div class="grid grid-cols-4 gap-3">
            <div>
                <label class="block text-2xs font-bold text-gray-700 mb-1">Date of Birth</label>
                <div class="relative">
                    <FlatpickrInput
                        v-model="dobDate"
                        :options="{ maxDate: 'today', dateFormat: 'Y-m-d', enableTime: false }"
                        placeholder="Select date"
                        inputClass="w-full border border-gray-200 rounded px-2.5 py-1.5 text-xs focus:ring-1 focus:ring-purple-500 focus:border-purple-500 outline-none bg-white pr-7"
                    />
                </div>
            </div>
            <div>
                <label class="block text-2xs font-bold text-gray-700 mb-1">Age (Y)</label>
                <input type="number" v-model.number="ageY" min="0" max="150" @input="updateDobFromAge" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-purple-500 outline-none bg-white" />
            </div>
            <div>
                <label class="block text-2xs font-bold text-gray-700 mb-1">Age (M)</label>
                <input type="number" v-model.number="ageM" min="0" max="11" @input="updateDobFromAge" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-purple-500 outline-none bg-white" />
            </div>
            <div>
                <label class="block text-2xs font-bold text-gray-700 mb-1">Age (D)</label>
                <input type="number" v-model.number="ageD" min="0" max="31" @input="updateDobFromAge" class="w-full px-2.5 py-1.5 text-xs border border-gray-200 rounded focus:ring-1 focus:ring-purple-500 outline-none bg-white" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import FlatpickrInput from '@/Components/Admin/Shared/FlatpickrInput.vue';

const props = defineProps({
    modelValue: { type: String, default: '' },
});

const emit = defineEmits(['update:modelValue']);

const dobDate = ref(props.modelValue);
const ageY = ref('');
const ageM = ref('');
const ageD = ref('');

// Prevent infinite loop by tracking the source of the change
let isUpdatingFromAge = false;
let isUpdatingFromDob = false;

function calculateAgeFromDob(dobStr) {
    if (!dobStr) {
        ageY.value = '';
        ageM.value = '';
        ageD.value = '';
        return;
    }
    
    const dob = new Date(dobStr);
    const today = new Date();
    
    if (isNaN(dob)) return;

    let years = today.getFullYear() - dob.getFullYear();
    let months = today.getMonth() - dob.getMonth();
    let days = today.getDate() - dob.getDate();

    if (days < 0) {
        months--;
        const prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
        days += prevMonth.getDate();
    }
    
    if (months < 0) {
        years--;
        months += 12;
    }

    ageY.value = years;
    ageM.value = months;
    ageD.value = days;
}

function updateDobFromAge() {
    isUpdatingFromAge = true;
    
    const y = parseInt(ageY.value) || 0;
    const m = parseInt(ageM.value) || 0;
    const d = parseInt(ageD.value) || 0;
    
    if (y === 0 && m === 0 && d === 0 && !ageY.value && !ageM.value && !ageD.value) {
        dobDate.value = '';
        emit('update:modelValue', '');
        isUpdatingFromAge = false;
        return;
    }

    const today = new Date();
    // Calculate new date by subtracting years, months, days
    let targetDate = new Date(today.getFullYear() - y, today.getMonth() - m, today.getDate() - d);
    
    const formattedDate = targetDate.toISOString().split('T')[0];
    
    if (dobDate.value !== formattedDate) {
        dobDate.value = formattedDate;
        emit('update:modelValue', formattedDate);
    }
    
    setTimeout(() => { isUpdatingFromAge = false; }, 50);
}

watch(dobDate, (newVal) => {
    if (!isUpdatingFromAge) {
        isUpdatingFromDob = true;
        calculateAgeFromDob(newVal);
        emit('update:modelValue', newVal);
        setTimeout(() => { isUpdatingFromDob = false; }, 50);
    }
});

watch(() => props.modelValue, (newVal) => {
    if (newVal !== dobDate.value) {
        dobDate.value = newVal;
        if (!isUpdatingFromAge) {
            calculateAgeFromDob(newVal);
        }
    }
});

onMounted(() => {
    if (props.modelValue) {
        calculateAgeFromDob(props.modelValue);
    }
});
</script>
