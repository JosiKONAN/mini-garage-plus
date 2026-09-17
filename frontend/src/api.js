const API_BASE = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000/api';

export function vehiculeImage(vehicule) {
  if (!vehicule?.image) return null;
  const base = API_BASE.replace(/\/api\/?$/, '');
  return `${base}/${vehicule.image.replace(/^\//, '')}`;
}

async function apiFetch(path, options = {}) {
  const res = await fetch(`${API_BASE}${path}`, {
    headers: { 'Content-Type': 'application/json' },
    ...options,
  });

  if (!res.ok) {
    const body = await res.json().catch(() => ({}));
    const message = body.message || 'Une erreur est survenue.';
    const detail = body.errors;
    throw { status: res.status, message, detail };
  }

  if (res.status === 204) return null;

  return res.json();
}

export const api = {
  vehicules: {
    list: (params = '', options = {}) => apiFetch(`/vehicules${params}`, options),
    get: (id, options = {}) => apiFetch(`/vehicules/${id}`, options),
    create: (data) => apiFetch('/vehicules', { method: 'POST', body: JSON.stringify(data) }),
    update: (id, data) => apiFetch(`/vehicules/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
    remove: (id) => apiFetch(`/vehicules/${id}`, { method: 'DELETE' }),
  },
  reparations: {
    list: (params = '', options = {}) => apiFetch(`/reparations${params}`, options),
    get: (id, options = {}) => apiFetch(`/reparations/${id}`, options),
    create: (data) => apiFetch('/reparations', { method: 'POST', body: JSON.stringify(data) }),
    remove: (id) => apiFetch(`/reparations/${id}`, { method: 'DELETE' }),
  },
  techniciens: {
    list: (params = '', options = {}) => apiFetch(`/techniciens${params}`, options),
    get: (id, options = {}) => apiFetch(`/techniciens/${id}`, options),
  },
  stats: (options = {}) => apiFetch('/stats', options),
};

export default api;