import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../api';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function Techniciens() {
  const [techniciens, setTechniciens] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    api.techniciens
      .list()
      .then((r) => setTechniciens(r.data))
      .catch(setError);
  }, []);

  if (error) return <ErrorMessage error={error} />;
  if (!techniciens) return <LoadingSpinner />;

  return (
    <div>
      <h1 className="h4 mb-4">Équipe technique</h1>
      {techniciens.length === 0 && (
        <div className="alert alert-light text-center">Aucun technicien.</div>
      )}
      <div className="row g-3">
        {techniciens.map((t) => (
          <div className="col-sm-6 col-lg-4" key={t.id}>
            <div className="card h-100">
              <div className="card-body">
                <h6 className="card-title mb-0">
                  {t.prenom} {t.nom}
                </h6>
                <div className="text-muted small mb-3">{t.specialite}</div>
                <Link to={`/techniciens/${t.id}`} className="btn btn-sm btn-outline-primary">
                  Voir le profil
                </Link>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}