export default function LoadingSpinner() {
  return (
    <div className="text-center py-5">
      <div className="spinner-border text-primary" role="status">
        <span className="visually-hidden">Chargement…</span>
      </div>
      <p className="text-muted mt-2 mb-0">Chargement…</p>
    </div>
  );
}