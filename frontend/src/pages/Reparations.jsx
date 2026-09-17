import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../api';
import Pagination from '../components/Pagination';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function Reparations() {
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);
  const [page, setPage] = useState(1);

  useEffect(() => {
    const controller = new AbortController();
    setError(null);
    setLoading(true);
    api.reparations
      .list(`?page=${page}&per_page=9`, { signal: controller.signal })
      .then(setData)
      .catch((err) => {
        if (err.name === 'AbortError') return;
        setError(err);
      })
      .finally(() => setLoading(false));
    return () => controller.abort();
  }, [page]);

  return (
    <div>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h1 className="h4 mb-0">Réparations</h1>
        <Link to="/reparations/nouvelle" className="btn btn-primary">
          + Nouvelle réparation
        </Link>
      </div>

      {error && <ErrorMessage error={error} />}
      {(loading || !data) && <LoadingSpinner />}

      {data && !loading && (
        <>
          <p className="text-muted small">
            {data.total} réparation(s) — page {data.current_page} / {data.last_page}
          </p>
          {data.data.length === 0 && (
            <div className="alert alert-light text-center">Aucune réparation trouvée.</div>
          )}
          <div className="table-responsive">
            <table className="table table-striped table-hover align-middle">
              <thead className="table-light">
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Véhicule</th>
                  <th scope="col">Objet</th>
                  <th scope="col">Durée</th>
                  <th scope="col">Techniciens</th>
                  <th scope="col">
                    <span className="visually-hidden">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                {data.data.map((r) => (
                  <tr key={r.id}>
                    <td>{r.date}</td>
                    <td>
                      {r.vehicule?.marque} {r.vehicule?.modele}
                      <div className="small text-muted">{r.vehicule?.immatriculation}</div>
                    </td>
                    <td>{r.objet_reparation}</td>
                    <td>{r.duree_main_oeuvre} h</td>
                    <td>{r.techniciens?.length ?? 0}</td>
                    <td className="text-end">
                      <Link to={`/reparations/${r.id}`} className="btn btn-sm btn-outline-primary">
                        Détails
                      </Link>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          <Pagination page={data.current_page} lastPage={data.last_page} onPage={setPage} />
        </>
      )}
    </div>
  );
}