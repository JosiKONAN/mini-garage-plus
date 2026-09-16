import { useEffect, useState } from 'react';
import api from '../api';
import SearchBar from '../components/SearchBar';
import VehiculeCard from '../components/VehiculeCard';
import Pagination from '../components/Pagination';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function Vehicules() {
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [page, setPage] = useState(1);
  const [q, setQ] = useState('');

  useEffect(() => {
    setError(null);
    const params = new URLSearchParams();
    params.set('page', page);
    if (q) params.set('q', q);
    api.vehicules
      .list(`?${params.toString()}`)
      .then(setData)
      .catch(setError);
  }, [page, q]);

  return (
    <div>
      <div className="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h1 className="h4 mb-0">Véhicules du garage</h1>
        <div style={{ maxWidth: 360, flex: '1 1 260px' }}>
          <SearchBar onSearch={setQ} placeholder="Rechercher (immatriculation, marque, modèle)…" />
        </div>
      </div>

      {error && <ErrorMessage error={error} />}
      {!data && <LoadingSpinner />}

      {data && (
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
          <Pagination page={data.current_page} lastPage={data.last_page} onPage={setPage} />
        </>
      )}
    </div>
  );
}