const API_BASE = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000/api';

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

  return res.json();
}

export const api = {
  vehicules: {
    list: (params = '') => apiFetch(`/vehicules${params}`),
    get: (id) => apiFetch(`/vehicules/${id}`),
    create: (data) => apiFetch('/vehicules', { method: 'POST', body: JSON.stringify(data) }),
    update: (id, data) => apiFetch(`/vehicules/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
    remove: (id) => apiFetch(`/vehicules/${id}`, { method: 'DELETE' }),
  },
  reparations: {
    list: (params = '') => apiFetch(`/reparations${params}`),
    get: (id) => apiFetch(`/reparations/${id}`),
    create: (data) => apiFetch('/reparations', { method: 'POST', body: JSON.stringify(data) }),
    remove: (id) => apiFetch(`/reparations/${id}`, { method: 'DELETE' }),
  },
  techniciens: {
    list: () => apiFetch('/techniciens'),
    get: (id) => apiFetch(`/techniciens/${id}`),
  },
  stats: () => apiFetch('/stats'),
};

export default api;