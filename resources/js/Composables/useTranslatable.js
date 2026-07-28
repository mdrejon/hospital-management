/**
 * Helpers for editing spatie/laravel-translatable JSON fields ({en:'', bn:''})
 * in admin Inertia forms. Pair with <LanguageTabs> for the tab UI.
 */

/** Build an empty {code: ''} object from the shared `languages` Inertia prop. */
export function emptyTranslatable(languages) {
    return Object.fromEntries((languages ?? []).map((l) => [l.code, '']));
}

/** Merge an existing translatable value (object, or a bare string from legacy/blank data) onto an empty shape. */
export function seedTranslatable(languages, existing) {
    const empty = emptyTranslatable(languages);
    if (existing && typeof existing === 'object') {
        return { ...empty, ...existing };
    }
    if (typeof existing === 'string' && existing !== '') {
        const defaultCode = (languages ?? []).find((l) => l.is_default)?.code ?? 'en';
        return { ...empty, [defaultCode]: existing };
    }
    return empty;
}

export function defaultLangCode(languages) {
    return (languages ?? []).find((l) => l.is_default)?.code ?? 'en';
}

/** Best-effort single-locale display string for admin list/table views. */
export function displayTranslatable(value, languages) {
    if (value == null) return '';
    if (typeof value === 'string') return value;
    return value[defaultLangCode(languages)] ?? Object.values(value)[0] ?? '';
}
