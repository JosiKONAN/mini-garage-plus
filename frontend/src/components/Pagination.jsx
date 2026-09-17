export default function Pagination({ page, lastPage, onPage }) {
  if (lastPage <= 1) return null;

  const windowSize = 2;
  const pages = [];
  for (let i = 1; i <= lastPage; i += 1) {
    if (
      i === 1 ||
      i === lastPage ||
      (i >= page - windowSize && i <= page + windowSize)
    ) {
      pages.push(i);
    }
  }

  const items = [];
  let prev = 0;
  pages.forEach((p) => {
    if (p - prev > 1) {
      items.push(
        <li key={`gap-${p}`} className="page-item disabled">
          <span className="page-link">…</span>
        </li>
      );
    }
    items.push(
      <li key={p} className={`page-item ${p === page ? 'active' : ''}`}>
        <button type="button" className="page-link" onClick={() => onPage(p)}>
          {p}
        </button>
      </li>
    );
    prev = p;
  });

  return (
    <nav aria-label="Pagination">
      <ul className="pagination justify-content-center mb-0">
        <li className={`page-item ${page <= 1 ? 'disabled' : ''}`}>
          <button
            type="button"
            className="page-link"
            onClick={() => onPage(page - 1)}
            aria-label="Précédent"
            disabled={page <= 1}
          >
            ‹
          </button>
        </li>
        {items}
        <li className={`page-item ${page >= lastPage ? 'disabled' : ''}`}>
          <button
            type="button"
            className="page-link"
            onClick={() => onPage(page + 1)}
            aria-label="Suivant"
            disabled={page >= lastPage}
          >
            ›
          </button>
        </li>
      </ul>
    </nav>
  );
}