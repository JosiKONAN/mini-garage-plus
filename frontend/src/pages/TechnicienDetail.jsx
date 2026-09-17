import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import api from '../api';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function TechnicienDetail() {
  const { id } = useParams();
  const [technicien, setTechnicien] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    const controller = new AbortController();
    setTechnicien(null);
    setError(null);
    api.techniciens
      .get(id, { signal: controller.signal })
      .then(setTechnicien)
      .catch((err) => {
        if (err.name === 'AbortError') return;
        setError(err);
      });
    return () => controller.abort();
  }, [id]);

  if (error) return <ErrorMessage error={error} />;
  if (!technicien) return <LoadingSpinner />;

  return (
    <div>
      <Link to="/techniciens" className="small">&larr; Retour à l’équipe</Link>
      <h1 className="h4 my-3">
        {technicien.prenom} {technicien.nom}
      </h1>
      <p className="text-muted mb-4">Spécialité : {technicien.specialite}</p>

      <div className="card">
        <div className="card-header bg-transparent fw-semibold">
          Réparations réalisées ({technicien.reparations?.length ?? 0})
        </div>
        {technicien.reparations?.length === 0 && (
          <div className="card-body text-muted">Aucune réparation associée.</div>
        )}
        <ul className="list-group list-group-flush">
          {technicien.reparations?.map((r) => (
            <li key={r.id} className="list-group-item d-flex justify-content-between align-items-center">
              <span>{r.objet_reparation}</span>
              <span className="badge text-bg-light">{r.date}</span>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
}