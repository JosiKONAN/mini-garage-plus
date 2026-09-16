export default function ErrorMessage({ error }) {
  const message =
    typeof error === 'object' && error !== null ? error.message : String(error);

  const detail = error && typeof error === 'object' && error.detail;

  return (
    <div className="alert alert-danger" role="alert">
      <div className="fw-semibold">Oups, une erreur est survenue.</div>
      <div>{message}</div>
      {detail && (
        <ul className="mb-0 mt-2 small">
          {Object.entries(detail).map(([field, errors]) => (
            <li key={field}>
              <strong>{field}</strong> : {Array.isArray(errors) ? errors.join(', ') : errors}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}