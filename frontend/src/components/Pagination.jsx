export default function Pagination({ page, lastPage, onPage }) {
  if (lastPage <= 1) return null;

  const pages = [];
  for (let i = 1; i <= lastPage; i += 1) pages.push(i);

  return (
    <nav aria-label="Pagination">
      <ul className="pagination justify-content-center mb-0">
        <li className={`page-item ${page <= 1 ? 'disabled' : ''}`}>
          <button className="page-link" onClick={() => onPage(page - 1)} aria-label="Précédent">
            ‹
          </button>
        </li>
        {pages.map((p) => (
          <li key={p} className={`page-item ${p === page ? 'active' : ''}`}>
            <button className="page-link" onClick={() => onPage(p)}>
              {p}
            </button>
          </li>
        ))}
        <li className={`page-item ${page >= lastPage ? 'disabled' : ''}`}>
          <button className="page-link" onClick={() => onPage(page + 1)} aria-label="Suivant">
            ›
          </button>
        </li>
      </ul>
    </nav>
  );
}