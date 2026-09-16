import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../api';
import StatCard from '../components/StatCard';
import LoadingSpinner from '../components/LoadingSpinner';
import ErrorMessage from '../components/ErrorMessage';

export default function Dashboard() {
  const [stats, setStats] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    api
      .stats()
      .then(setStats)
      .catch(setError);
  }, []);

  if (error) return <ErrorMessage error={error} />;
  if (!stats) return <LoadingSpinner />;

  const energies = stats.energies ?? {};

  return (
    <div>
      <h1 className="h4 mb-4">Tableau de bord</h1>

      <div className="row g-3 mb-4">
        <div className="col-6 col-md-3">
          <StatCard label="Véhicules" value={stats.total_vehicules} icon="🚗" color="primary" />
        </div>
        <div className="col-6 col-md-3">
          <StatCard label="Réparations" value={stats.total_reparations} icon="🔧" color="success" />
        </div>
        <div className="col-6 col-md-3">
          <StatCard label="Techniciens" value={stats.total_techniciens} icon="👨‍🔧" color="info" />
        </div>
        <div className="col-6 col-md-3">
          <StatCard label="Réparations / mois" value={stats.reparations_mois} icon="📅" color="warning" />
        </div>
      </div>

      <div className="row g-4">
        <div className="col-lg-5">
          <div className="card h-100">
            <div className="card-header bg-transparent fw-semibold">Répartition par énergie</div>
            <div className="card-body">
              <ul className="list-group list-group-flush">
                {Object.entries(energies).length === 0 && (
                  <li className="list-group-item text-muted">Aucune donnée.</li>
                )}
                {Object.entries(energies).map(([energie, total]) => (
                  <li
                    key={energie}
                    className="list-group-item d-flex justify-content-between align-items-center"
                  >
                    <span className="text-capitalize">{energie}</span>
                    <span className="badge text-bg-secondary rounded-pill">{total}</span>
                  </li>
                ))}
              </ul>
              <p className="small text-muted mt-3 mb-0">
                Durée moyenne de main-d’œuvre : {stats.duree_moyenne} h
              </p>
            </div>
          </div>
        </div>

        <div className="col-lg-7">
          <div className="card h-100">
            <div className="card-header d-flex justify-content-between align-items-center bg-transparent">
              <span className="fw-semibold">Dernières réparations</span>
              <Link to="/reparations" className="small">Tout voir</Link>
            </div>
            <div className="card-body p-0">
              <ul className="list-group list-group-flush">
                {stats.dernieres_reparations.map((r) => (
                  <li key={r.id} className="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                      <div className="fw-semibold">
                        {r.vehicule?.marque} {r.vehicule?.modele}{' '}
                        <span className="text-muted fw-normal">
                          ({r.vehicule?.immatriculation})
                        </span>
                      </div>
                      <div className="small text-muted">{r.objet_reparation}</div>
                    </div>
                    <span className="badge text-bg-light">{r.date}</span>
                  </li>
                ))}
                {stats.dernieres_reparations.length === 0 && (
                  <li className="list-group-item text-muted">Aucune réparation.</li>
                )}
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}