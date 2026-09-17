import { useEffect, useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import api from '../api';
import SearchBar from '../components/SearchBar';
import VehiculeCard from '../components/VehiculeCard';
import Pagination from '../components/Pagination';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function Vehicules() {
  const [searchParams, setSearchParams] = useSearchParams();
  const page = Math.max(1, parseInt(searchParams.get('page') || '1', 10));
  const q = searchParams.get('q') || '';
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const controller = new AbortController();
    setError(null);
    setLoading(true);
    const params = new URLSearchParams();
    params.set('page', page);
    if (q) params.set('q', q);
    api.vehicules
      .list(`?${params}`, { signal: controller.signal })
      .then(setData)
      .catch((err) => {
        if (err.name === 'AbortError') return;
        setError(err);
      })
      .finally(() => setLoading(false));
    return () => controller.abort();
  }, [page, q]);

  function onPage(nextPage) {
    const next = new URLSearchParams(searchParams);
    next.set('page', nextPage);
    setSearchParams(next);
  }

  function onSearch(value) {
    const next = new URLSearchParams(searchParams);
    next.delete('page');
    if (value) next.set('q', value);
    else next.delete('q');
    setSearchParams(next);
  }

  return (
    <div>
      <div className="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h1 className="h4 mb-0">Véhicules du garage</h1>
        <div style={{ maxWidth: 360, flex: '1 1 260px' }}>
          <SearchBar onSearch={onSearch} initialValue={q} placeholder="Rechercher (immatriculation, marque, modèle)…" />
        </div>
      </div>

      {error && <ErrorMessage error={error} />}
      {(loading || !data) && <LoadingSpinner />}

      {data && !loading && (
        <>
          <p className="text-muted small">
            {data.total} véhicule(s) — page {data.current_page} / {data.last_page}
          </p>
          {data.data.length === 0 && (
            <div className="alert alert-light text-center">Aucun véhicule trouvé.</div>
          )}
          <div className="row g-3 mb-4">
            {data.data.map((v) => (
              <div className="col-sm-6 col-lg-4" key={v.id}>
                <VehiculeCard vehicule={v} />
              </div>
            ))}
          </div>
          <Pagination page={data.current_page} lastPage={data.last_page} onPage={onPage} />
        </>
      )}
    </div>
  );
}