import { Link } from 'react-router-dom';

export default function NotFound() {
  return (
    <div className="text-center py-5">
      <h1 className="display-6">404 — Page introuvable</h1>
      <p className="text-muted">L’adresse demandée n’existe pas.</p>
      <Link to="/" className="btn btn-primary">
        Retour au tableau de bord
      </Link>
    </div>
  );
}