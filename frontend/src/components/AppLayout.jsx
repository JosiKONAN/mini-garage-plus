import { Outlet } from 'react-router-dom';
import Navbar from './Navbar';

export default function AppLayout() {
  return (
    <div>
      <Navbar />
      <main className="container py-4">
        <Outlet />
      </main>
      <footer className="border-top mt-5 py-3 text-center text-muted small">
        Mini Garage Plus — Projet React + Laravel (Semaine 6)
      </footer>
    </div>
  );
}