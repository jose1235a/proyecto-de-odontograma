export function normalizeInitialData(data) {
    if (Array.isArray(data)) {
        return data;
    }

    if (typeof data === 'string') {
        try {
            const parsed = JSON.parse(data);
            if (Array.isArray(parsed)) {
                return parsed;
            }
            if (parsed && typeof parsed === 'object') {
                return Object.values(parsed);
            }
        } catch (error) {
            // Failed to parse odontogram data string - returning empty array
        }
        return [];
    }

    if (data && typeof data === 'object') {
        return Object.values(data);
    }

    return [];
}
