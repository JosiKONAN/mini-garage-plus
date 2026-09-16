import { Link } from 'react-router-dom';

export default function ReparationCard({ reparation }) {
  const vehicule = reparation.vehicule ?? {};
  return (
    <div className="card h-100">
      <div className="card-body">
        <div className="d-flex justify-content-between align-items-start">
          <h6 className="card-title mb-1">
            {vehicule.marque ? `${vehicule.marque} ${vehicule.modele}` : 'Véhicule #' + (vehicule.id ?? '')}
          </h6>
          <span className="badge text-bg-light">{reparation.date}</span>
        </div>
        <p className="card-text mb-2">{reparation.objet_reparation}</p>
        <div className="d-flex justify-content-between align-items-center small">
          <span>Durée : {reparation.duree_main_oeuvre} h</span>
          <span>{reparation.techniciens?.length ?? 0} technicien(s)</span>
        </div>
        <Link to={`/reparations/${reparation.id}`} className="btn btn-sm btn-outline-primary mt-3">
          Détails
        </Link>
      </div>
    </div>
  );
}