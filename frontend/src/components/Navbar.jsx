import { useState } from 'react';
import { NavLink } from 'react-router-dom';

const links = [
  { to: '/', label: 'Tableau de bord' },
  { to: '/vehicules', label: 'Véhicules' },
  { to: '/reparations', label: 'Réparations' },
  { to: '/techniciens', label: 'Techniciens' },
];

export default function Navbar() {
  const [open, setOpen] = useState(false);

  return (
    <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
      <div className="container">
        <NavLink className="navbar-brand d-inline-flex align-items-center fw-semibold" to="/">
          <img src="/logo.svg" alt="Mini Garage Plus" height="34" width="170" />
        </NavLink>
        <button
          className="navbar-toggler"
          type="button"
          aria-label="Ouvrir le menu"
          aria-expanded={open}
          onClick={() => setOpen((v) => !v)}
        >
          <span className="navbar-toggler-icon"></span>
        </button>
        <div className={`${open ? '' : 'collapse '}navbar-collapse`}>
          <ul className="navbar-nav ms-auto">
            {links.map((l) => (
              <li className="nav-item" key={l.to}>
                <NavLink
                  end={l.to === '/'}
                  className={({ isActive }) =>
                    `nav-link ${isActive ? 'active' : ''}`
                  }
                  to={l.to}
                  onClick={() => setOpen(false)}
                >
                  {l.label}
                </NavLink>
              </li>
            ))}
          </ul>
        </div>
      </div>
    </nav>
  );
}