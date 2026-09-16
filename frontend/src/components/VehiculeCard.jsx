import { Link } from 'react-router-dom';

export default function VehiculeCard({ vehicule }) {
  return (
    <div className="card h-100">
      <div className="card-body">
        <h6 className="card-title text-uppercase text-muted mb-1">
          {vehicule.marque} {vehicule.modele}
        </h6>
        <p className="card-text fs-5 fw-semibold mb-2">{vehicule.immatriculation}</p>
        <ul className="list-unstyled small mb-3">
          <li>Année : {vehicule.annee}</li>
          <li>Kilométrage : {vehicule.kilometrage?.toLocaleString('fr-FR')} km</li>
          <li>
            Énergie : <span className="text-capitalize">{vehicule.energie}</span>
          </li>
          <li>
            Boîte : <span className="text-capitalize">{vehicule.boite}</span>
          </li>
        </ul>
        <Link to={`/vehicules/${vehicule.id}`} className="btn btn-sm btn-outline-primary">
          Voir la fiche
        </Link>
      </div>
    </div>
  );
}