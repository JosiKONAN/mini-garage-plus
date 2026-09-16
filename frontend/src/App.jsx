import { Routes, Route } from 'react-router-dom';
import AppLayout from './components/AppLayout';
import Dashboard from './pages/Dashboard';
import Vehicules from './pages/Vehicules';
import VehiculeDetail from './pages/VehiculeDetail';
import Reparations from './pages/Reparations';
import ReparationForm from './pages/ReparationForm';
import ReparationDetail from './pages/ReparationDetail';
import Techniciens from './pages/Techniciens';
import TechnicienDetail from './pages/TechnicienDetail';

export default function App() {
  return (
    <Routes>
      <Route element={<AppLayout />}>
        <Route path="/" element={<Dashboard />} />
        <Route path="/vehicules" element={<Vehicules />} />
        <Route path="/vehicules/:id" element={<VehiculeDetail />} />
        <Route path="/reparations" element={<Reparations />} />
        <Route path="/reparations/nouvelle" element={<ReparationForm />} />
        <Route path="/reparations/:id" element={<ReparationDetail />} />
        <Route path="/techniciens" element={<Techniciens />} />
        <Route path="/techniciens/:id" element={<TechnicienDetail />} />
        <Route path="*" element={<Dashboard />} />
      </Route>
    </Routes>
  );
}