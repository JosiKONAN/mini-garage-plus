import { useState } from 'react';

export default function SearchBar({ onSearch, placeholder = 'Rechercher…', initialValue = '' }) {
  const [term, setTerm] = useState(initialValue);

  function handleSubmit(e) {
    e.preventDefault();
    onSearch(term.trim());
  }

  return (
    <form className="d-flex gap-2" onSubmit={handleSubmit}>
      <input
        type="search"
        className="form-control"
        placeholder={placeholder}
        value={term}
        onChange={(e) => setTerm(e.target.value)}
        aria-label="Recherche"
      />
      <button type="submit" className="btn btn-outline-secondary text-nowrap">
        Rechercher
      </button>
    </form>
  );
}