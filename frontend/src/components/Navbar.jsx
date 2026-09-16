import { NavLink } from 'react-router-dom';

const links = [
  { to: '/', label: 'Tableau de bord' },
  { to: '/vehicules', label: 'Véhicules' },
  { to: '/reparations', label: 'Réparations' },
  { to: '/techniciens', label: 'Techniciens' },
];

export default function Navbar() {
  return (
    <nav className="navbar navbar-expand navbar-dark bg-dark">
      <div className="container">
        <NavLink className="navbar-brand d-inline-flex align-items-center fw-semibold" to="/">
          <img src="/logo.svg" alt="Mini Garage Plus" height="34" width="170" />
        </NavLink>
        <ul className="navbar-nav ms-auto">
          {links.map((l) => (
            <li className="nav-item" key={l.to}>
              <NavLink
                end={l.to === '/'}
                className={({ isActive }) =>
                  `nav-link ${isActive ? 'active' : ''}`
                }
                to={l.to}
              >
                {l.label}
              </NavLink>
            </li>
          ))}
        </ul>
      </div>
    </nav>
  );
}