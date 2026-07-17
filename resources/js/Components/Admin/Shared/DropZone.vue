<template>
    <div>
        <!-- Drop zone -->
        <div
            @dragenter.prevent="isDragging = true"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="onDrop"
            @click="fileInput.click()"
            :class="[
                'relative cursor-pointer rounded-xl border-2 border-dashed transition-all duration-200 overflow-hidden select-none',
                isDragging
                    ? 'border-blue-500 bg-blue-50 scale-[1.01]'
                    : hasPreview
                        ? 'border-gray-200 hover:border-blue-400'
                        : 'border-gray-300 bg-gray-50 hover:border-blue-400 hover:bg-blue-50/40'
            ]"
        >
            <!-- Single-file: show preview when available -->
            <template v-if="!multiple">
                <div v-if="hasPreview" class="relative group">
                    <img :src="currentPreview" :class="previewClass" />
                    <!-- Remove button -->
                    <button
                        type="button"
                        @click.stop="clearImage"
                        title="Remove image"
                        class="absolute top-2 right-2 z-10 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-1 rounded-[10px]">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <span class="text-white text-xs font-semibold">Click or drop to replace</span>
                    </div>
                </div>
                <div v-else class="py-9 flex flex-col items-center gap-2.5 px-4 text-center">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="text-blue-600 font-semibold">Click to browse</span>
                            <span class="text-gray-400"> or drag &amp; drop</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ hint }}</p>
                    </div>
                </div>
            </template>

            <!-- Multiple-file: always show drop zone (parent manages previews) -->
            <template v-else>
                <div class="py-9 flex flex-col items-center gap-2.5 px-4 text-center">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">
                            <span class="text-blue-600 font-semibold">Click to browse</span>
                            <span class="text-gray-400"> or drag &amp; drop</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ hint }} — multiple files allowed</p>
                    </div>
                </div>
            </template>

            <!-- Drag-over overlay -->
            <div v-if="isDragging"
                class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-blue-50/90 rounded-[10px] pointer-events-none">
                <svg class="w-10 h-10 text-blue-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <p class="text-blue-600 font-semibold text-sm">Drop to upload</p>
            </div>
        </div>

        <!-- Hidden native input -->
        <input
            ref="fileInput"
            type="file"
            class="hidden"
            :multiple="multiple"
            :accept="accept"
            @change="onInputChange"
        />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    multiple:        { type: Boolean, default: false },
    accept:          { type: String,  default: 'image/*' },
    existingPreview: { type: String,  default: null },
    previewClass:    { type: String,  default: 'w-full h-44 object-cover' },
    hint:            { type: String,  default: 'JPEG / PNG / WebP — max 5 MB' },
});

const emit = defineEmits(['change', 'remove']);

const fileInput    = ref(null);
const isDragging   = ref(false);
const localPreview = ref(null);
const cleared      = ref(false);

const currentPreview = computed(() => cleared.value ? null : (localPreview.value || props.existingPreview));
const hasPreview     = computed(() => !!currentPreview.value);

function clearImage(e) {
    e?.stopPropagation();
    localPreview.value = null;
    cleared.value = true;
    if (fileInput.value) fileInput.value.value = '';
    emit('change', null);
    emit('remove');
}

function processFiles(fileList) {
    if (!fileList || fileList.length === 0) return;

    cleared.value = false;

    if (props.multiple) {
        emit('change', Array.from(fileList));
    } else {
        const file = fileList[0];
        localPreview.value = URL.createObjectURL(file);
        emit('change', file);
    }

    // Reset so same file can be re-selected
    if (fileInput.value) fileInput.value.value = '';
}

function onDrop(e) {
    isDragging.value = false;
    processFiles(e.dataTransfer.files);
}

function onInputChange(e) {
    processFiles(e.target.files);
}
</script>
