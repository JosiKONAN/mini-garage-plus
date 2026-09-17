import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import api from '../api';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function ReparationDetail() {
  const { id } = useParams();
  const [reparation, setReparation] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    const controller = new AbortController();
    setReparation(null);
    setError(null);
    api.reparations
      .get(id, { signal: controller.signal })
      .then(setReparation)
      .catch((err) => {
        if (err.name === 'AbortError') return;
        setError(err);
      });
    return () => controller.abort();
  }, [id]);

  if (error) return <ErrorMessage error={error} />;
  if (!reparation) return <LoadingSpinner />;

  const v = reparation.vehicule ?? {};

  return (
    <div>
      <Link to="/reparations" className="small">&larr; Retour aux réparations</Link>
      <h1 className="h4 my-3">Réparation #{reparation.id}</h1>

      <div className="row g-4">
        <div className="col-lg-6">
          <div className="card">
            <div className="card-header bg-transparent fw-semibold">Informations</div>
            <ul className="list-group list-group-flush">
              <li className="list-group-item d-flex justify-content-between">
                <span className="text-muted">Date</span>
                <span>{reparation.date}</span>
              </li>
              <li className="list-group-item d-flex justify-content-between">
                <span className="text-muted">Objet</span>
                <span>{reparation.objet_reparation}</span>
              </li>
              <li className="list-group-item d-flex justify-content-between">
                <span className="text-muted">Durée de main-d’œuvre</span>
                <span>{reparation.duree_main_oeuvre} h</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="col-lg-6">
          <div className="card">
            <div className="card-header bg-transparent fw-semibold">Véhicule</div>
            {v.id ? (
              <ul className="list-group list-group-flush">
                <li className="list-group-item d-flex justify-content-between">
                  <span className="text-muted">Modèle</span>
                  <span>
                    {v.marque} {v.modele}
                  </span>
                </li>
                <li className="list-group-item d-flex justify-content-between">
                  <span className="text-muted">Immatriculation</span>
                  <Link to={`/vehicules/${v.id}`}>{v.immatriculation}</Link>
                </li>
              </ul>
            ) : (
              <div className="card-body text-muted">Véhicule introuvable.</div>
            )}
          </div>

          <div className="card mt-3">
            <div className="card-header bg-transparent fw-semibold">
              Techniciens ({reparation.techniciens?.length ?? 0})
            </div>
            {reparation.techniciens?.length === 0 && (
              <div className="card-body text-muted">Aucun technicien assigné.</div>
            )}
            <ul className="list-group list-group-flush">
              {reparation.techniciens?.map((t) => (
                <li key={t.id} className="list-group-item">
                  {t.prenom} {t.nom}
                  <span className="small text-muted ms-2">— {t.specialite}</span>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </div>
    </div>
  );
}