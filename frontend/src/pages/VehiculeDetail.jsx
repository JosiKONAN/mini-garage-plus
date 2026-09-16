import { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import api, { vehiculeImage } from '../api';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

const labels = {
  immatriculation: 'Immatriculation',
  marque: 'Marque',
  modele: 'Modèle',
  couleur: 'Couleur',
  annee: 'Année',
  kilometrage: 'Kilométrage',
  carrosserie: 'Carrosserie',
  energie: 'Énergie',
  boite: 'Boîte de vitesses',
};

export default function VehiculeDetail() {
  const { id } = useParams();
  const [vehicule, setVehicule] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    api.vehicules
      .get(id)
      .then(setVehicule)
      .catch(setError);
  }, [id]);

  if (error) return <ErrorMessage error={error} />;
  if (!vehicule) return <LoadingSpinner />;

  return (
    <div>
      <Link to="/vehicules" className="small">&larr; Retour aux véhicules</Link>
      <h1 className="h4 my-3">
        {vehicule.marque} {vehicule.modele}{' '}
        <span className="text-muted fs-5">({vehicule.immatriculation})</span>
      </h1>

      <div className="row g-4">
        <div className="col-lg-5">
          {vehiculeImage(vehicule) && (
            <img
              src={vehiculeImage(vehicule)}
              alt={`${vehicule.marque} ${vehicule.modele}`}
              className="img-fluid rounded mb-3 w-100"
              style={{ objectFit: 'cover', maxHeight: '280px' }}
            />
          )}
          <div className="card">
            <div className="card-header bg-transparent fw-semibold">Fiche véhicule</div>
            <ul className="list-group list-group-flush">
              {Object.entries(labels).map(([key, label]) => (
                <li key={key} className="list-group-item d-flex justify-content-between">
                  <span className="text-muted">{label}</span>
                  <span>
                    {key === 'kilometrage'
                      ? `${(vehicule[key] ?? 0).toLocaleString('fr-FR')} km`
                      : vehicule[key]}
                  </span>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="col-lg-7">
          <div className="card">
            <div className="card-header bg-transparent fw-semibold">
              Historique des réparations ({vehicule.reparations?.length ?? 0})
            </div>
            {vehicule.reparations?.length === 0 && (
              <div className="card-body text-muted">Aucune réparation enregistrée.</div>
            )}
            <ul className="list-group list-group-flush">
              {vehicule.reparations?.map((r) => (
                <li key={r.id} className="list-group-item">
                  <div className="d-flex justify-content-between">
                    <span className="fw-semibold">{r.objet_reparation}</span>
                    <span className="badge text-bg-light">{r.date}</span>
                  </div>
                  <span className="small text-muted">Durée : {r.duree_main_oeuvre} h</span>
                </li>
              ))}
            </ul>
          </div>

          <Link to="/reparations/nouvelle" className="btn btn-primary mt-3">
            + Nouvelle réparation
          </Link>
        </div>
      </div>
    </div>
  );
}